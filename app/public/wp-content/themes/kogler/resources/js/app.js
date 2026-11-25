import Alpine from 'alpinejs';

window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
  Alpine.store('fitment', {
    make: '',
    model: null,
    truck: '',
    contactHref(base) {
      const truck = Alpine.store('fitment').truck;

      if (! truck || ! base) {
        return base;
      }

      try {
        const url = new URL(base, window.location.origin);
        url.searchParams.set('topic', 'mattress-fit');
        url.searchParams.set('truck', truck);

        return `${url.pathname}${url.search}`;
      } catch (error) {
        return base;
      }
    },
  });

  /**
   * Close over Alpine’s reactive `ctx` (`this` from init). Expressions like
   * `goTo(n)` are invoked unbound, so method bodies must not rely on `this`.
   */
  Alpine.data('mpxProductThumbs', () => {
    let ctx;

    return {
      active: 0,
      canPrev: false,
      canNext: false,
      gallery: null,
      _ro: null,

      init() {
        ctx = this;

        // Thumbs live outside `.woocommerce-product-gallery` (sibling under
        // `.mpx-product-gallery`) so FlexSlider cannot reorder or capture them.
        const shell = ctx.$el.closest('.mpx-product-gallery');
        ctx.gallery = shell?.querySelector('.woocommerce-product-gallery') || null;

        ctx.$nextTick(() => {
          ctx.updateArrows();
          ctx.bindFlexslider();

          const track = ctx.$refs.track;
          if (track) {
            track.addEventListener('scrollend', ctx.updateArrows);
          }

          if (typeof ResizeObserver !== 'undefined' && track) {
            ctx._ro = new ResizeObserver(() => ctx.updateArrows());
            ctx._ro.observe(track);
          }
        });
      },

      destroy() {
        ctx.$refs.track?.removeEventListener('scrollend', ctx.updateArrows);
        ctx?._ro?.disconnect();
      },

      items() {
        return [...ctx.$el.querySelectorAll('.mpx-product-thumbs__item')];
      },

      /**
       * Item x in scroll-content coords. Avoid offsetLeft — it can be relative
       * to an ancestor outside the scrollport (the nav grid), which made
       * scroll-to-end leave a gap and keep the next arrow enabled.
       */
      itemScrollLeft(item) {
        const track = ctx.$refs.track;
        if (! track || ! item) return 0;
        const vp = track.getBoundingClientRect();
        const ir = item.getBoundingClientRect();
        return track.scrollLeft + (ir.left - vp.left);
      },

      maxScroll() {
        const track = ctx.$refs.track;
        const items = ctx.items();
        if (! track || ! items.length) return 0;

        const last = items[items.length - 1];
        const lastRight = ctx.itemScrollLeft(last) + last.getBoundingClientRect().width;
        return Math.max(0, lastRight - track.clientWidth);
      },

      bindFlexslider() {
        if (! window.jQuery || ! ctx.gallery) return;

        const $gallery = window.jQuery(ctx.gallery);
        let attempts = 0;

        const attach = () => {
          const slider = $gallery.data('flexslider');
          if (! slider) {
            if (attempts++ < 40) {
              window.setTimeout(attach, 50);
            }
            return;
          }

          const previousAfter = slider.vars.after;
          slider.vars.after = (s) => {
            if (typeof previousAfter === 'function') {
              previousAfter(s);
            }
            ctx.active = s.currentSlide;
            ctx.scrollThumbIntoView(s.currentSlide);
          };
        };

        $gallery.on('wc-product-gallery-after-init', attach);
        attach();
      },

      /**
       * Drive FlexSlider via flexAnimate(..., override=true).
       * Plain `$().flexslider(n)` can no-op when canAdvance() is false.
       */
      goTo(index) {
        const max = ctx.items().length - 1;
        const target = Math.max(0, Math.min(Number(index) || 0, max));
        ctx.active = target;

        const slider = window.jQuery?.(ctx.gallery)?.data('flexslider');
        if (slider && typeof slider.flexAnimate === 'function') {
          if (slider.currentSlide !== target) {
            slider.flexAnimate(target, true, true);
          }
        }

        ctx.scrollThumbIntoView(target);
      },

      prev() {
        ctx.scrollBy(-1);
      },

      next() {
        ctx.scrollBy(1);
      },

      scrollBy(direction) {
        const track = ctx.$refs.track;
        if (! track) return;

        const max = ctx.maxScroll();
        const next = Math.min(max, Math.max(0, track.scrollLeft + direction * ctx.pageWidth()));
        track.scrollTo({ left: next, behavior: 'smooth' });
        window.requestAnimationFrame(() => ctx.updateArrows());
      },

      pageWidth() {
        const track = ctx.$refs.track;
        if (! track) return 0;
        return Math.max(track.clientWidth * 0.85, 1);
      },

      scrollThumbIntoView(index) {
        const track = ctx.$refs.track;
        const item = ctx.items()[index];
        if (! track || ! item) return;

        const max = ctx.maxScroll();
        const itemLeft = ctx.itemScrollLeft(item);
        const itemRight = itemLeft + item.getBoundingClientRect().width;
        const viewLeft = track.scrollLeft;
        const viewRight = viewLeft + track.clientWidth;

        let next = viewLeft;
        if (itemLeft < viewLeft) {
          next = itemLeft;
        } else if (itemRight > viewRight) {
          next = itemRight - track.clientWidth;
        }

        next = Math.min(max, Math.max(0, next));
        if (Math.abs(next - viewLeft) > 1) {
          track.scrollTo({ left: next, behavior: 'smooth' });
        }

        window.requestAnimationFrame(() => ctx.updateArrows());
      },

      updateArrows() {
        const track = ctx.$refs.track;
        const items = ctx.items();
        if (! track || ! items.length) {
          ctx.canPrev = false;
          ctx.canNext = false;
          return;
        }

        const vp = track.getBoundingClientRect();
        const last = items[items.length - 1].getBoundingClientRect();

        // If we overscrolled past the last thumb, pull back so there is no gap.
        const gapAfter = vp.right - last.right;
        if (gapAfter > 2 && track.scrollLeft > 0) {
          track.scrollLeft = Math.max(0, track.scrollLeft - gapAfter);
        }

        const vp2 = track.getBoundingClientRect();
        const first2 = items[0].getBoundingClientRect();
        const last2 = items[items.length - 1].getBoundingClientRect();

        ctx.canPrev = first2.left < vp2.left - 2;
        ctx.canNext = last2.right > vp2.right + 2;
      },
    };
  });

  Alpine.data('mpxCardsSlider', (config = {}) => ({
    pages: 1,
    active: 0,
    slidesPerView: 1,
    autoplay: Boolean(config?.autoplay),
    intervalMs: 5000,
    direction: 1,
    _paused: false,
    _timer: null,
    _ro: null,
    _mqlDesktop: null,
    _mqlTablet: null,
    _onPause: null,
    _onResume: null,
    _onPointerUp: null,

    init() {
      this._mqlDesktop = window.matchMedia('(min-width: 64rem)');
      this._mqlTablet = window.matchMedia('(min-width: 48rem)');
      const onBreakpoint = () => this.update();
      this._mqlDesktop.addEventListener?.('change', onBreakpoint);
      this._mqlTablet.addEventListener?.('change', onBreakpoint);

      this.$nextTick(() => {
        this.update();
        if (typeof ResizeObserver !== 'undefined' && this.$refs.track) {
          this._ro = new ResizeObserver(() => this.update());
          this._ro.observe(this.$refs.track);
        }
        this.setupAutoplay();
      });
    },

    destroy() {
      this.stopAutoplay();
      this._ro?.disconnect();
      if (this._onPause && this._onResume) {
        this.$el.removeEventListener('mouseenter', this._onPause);
        this.$el.removeEventListener('mouseleave', this._onResume);
        this.$el.removeEventListener('focusin', this._onPause);
        this.$el.removeEventListener('focusout', this._onResume);
        this.$refs.track?.removeEventListener('pointerdown', this._onPause);
        window.removeEventListener('pointerup', this._onPointerUp);
        window.removeEventListener('pointercancel', this._onPointerUp);
      }
    },

    setupAutoplay() {
      if (! this.autoplay) return;
      if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

      this._onPause = () => {
        this._paused = true;
      };
      this._onResume = () => {
        this._paused = false;
      };
      // Touch has no hover — resume after the gesture ends unless still hovered.
      this._onPointerUp = () => {
        if (! this.$el.matches(':hover')) {
          this._paused = false;
        }
      };

      this.$el.addEventListener('mouseenter', this._onPause);
      this.$el.addEventListener('mouseleave', this._onResume);
      this.$el.addEventListener('focusin', this._onPause);
      this.$el.addEventListener('focusout', (event) => {
        if (! this.$el.contains(event.relatedTarget)) {
          this._paused = false;
        }
      });
      this.$refs.track?.addEventListener('pointerdown', this._onPause);
      window.addEventListener('pointerup', this._onPointerUp);
      window.addEventListener('pointercancel', this._onPointerUp);

      this.startAutoplay();
    },

    startAutoplay() {
      this.stopAutoplay();
      if (! this.autoplay || this.pages <= 1) return;

      this._timer = window.setInterval(() => {
        if (! this._paused) {
          this.advance();
        }
      }, this.intervalMs);
    },

    stopAutoplay() {
      if (this._timer != null) {
        window.clearInterval(this._timer);
        this._timer = null;
      }
    },

    /**
     * Step forward/back; reverse direction at either end (ping-pong).
     * Avoids cloning slides for a seamless loop with scroll-snap.
     */
    advance() {
      if (this.pages <= 1) return;

      let next = this.active + this.direction;

      if (next >= this.pages) {
        this.direction = -1;
        next = this.active - 1;
      } else if (next < 0) {
        this.direction = 1;
        next = this.active + 1;
      }

      if (next !== this.active) {
        this.goTo(next);
      }
    },

    readSlidesPerView() {
      const root = this.$el;
      const styles = getComputedStyle(root);
      const desktop = parseInt(styles.getPropertyValue('--mpx-slides-desktop'), 10) || 4;
      const tablet = parseInt(styles.getPropertyValue('--mpx-slides-tablet'), 10) || 2;
      const mobile = parseInt(styles.getPropertyValue('--mpx-slides-mobile'), 10) || 1;

      // lg ≥ 64rem → desktop; md ≥ 48rem (and below lg) → tablet; else mobile.
      if (this._mqlDesktop?.matches) {
        this.slidesPerView = Math.max(1, desktop);
      } else if (this._mqlTablet?.matches) {
        this.slidesPerView = Math.max(1, tablet);
      } else {
        this.slidesPerView = Math.max(1, mobile);
      }

      // Write the active count onto the element so card width calc updates.
      // Avoids Blockstudio CSS media-query reordering fighting the theme CSS.
      root.style.setProperty('--mpx-slides', String(this.slidesPerView));
    },

    cards() {
      const track = this.$refs.track;
      if (! track) return [];
      return [...track.querySelectorAll(':scope > *')];
    },

    /**
     * Scroll distance for one card (always advance by a single slide,
     * even when several are visible).
     */
    slideStep() {
      const track = this.$refs.track;
      const card = track?.querySelector(':scope > *');
      if (! track || ! card) return 0;

      const styles = getComputedStyle(track);
      const gap = parseFloat(styles.columnGap || styles.gap || '0') || 0;
      return card.getBoundingClientRect().width + gap;
    },

    update() {
      const track = this.$refs.track;
      if (! track) return;

      this.readSlidesPerView();
      const count = this.cards().length;
      // Positions = how far you can shift by one card while keeping N visible.
      const pages = Math.max(1, count - this.slidesPerView + 1);
      const pagesChanged = pages !== this.pages;
      this.pages = pages;

      const step = this.slideStep();
      let active = step > 0 ? Math.round(track.scrollLeft / step) : 0;
      active = Math.max(0, Math.min(active, this.pages - 1));
      this.active = active;

      this.renderDots();

      if (pagesChanged && this.autoplay) {
        this.startAutoplay();
      }
    },

    goTo(index) {
      const track = this.$refs.track;
      if (! track) return;

      const target = Math.max(0, Math.min(index, this.pages - 1));
      track.scrollTo({ left: target * this.slideStep(), behavior: 'smooth' });
    },

    renderDots() {
      const nav = this.$refs.dots;
      if (! nav) return;

      // One page fills the track — no pagination chrome needed.
      if (this.pages <= 1) {
        nav.replaceChildren();
        nav.hidden = true;
        return;
      }

      nav.hidden = false;

      const existing = nav.querySelectorAll('.mpx-cards-slider__dot');
      if (existing.length === this.pages) {
        existing.forEach((btn, i) => {
          const on = i === this.active;
          btn.classList.toggle('is-active', on);
          if (on) {
            btn.setAttribute('aria-current', 'true');
          } else {
            btn.removeAttribute('aria-current');
          }
        });
        return;
      }

      nav.replaceChildren();

      for (let i = 0; i < this.pages; i++) {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'mpx-cards-slider__dot' + (i === this.active ? ' is-active' : '');
        btn.setAttribute('aria-label', `Go to slide ${i + 1}`);
        if (i === this.active) {
          btn.setAttribute('aria-current', 'true');
        }
        btn.addEventListener('click', () => this.goTo(i));
        nav.appendChild(btn);
      }
    },
  }));

  Alpine.data('mpxShopFilters', (config = {}) => {
    let ctx;
    let abortController = null;
    let requestSeq = 0;

    return {
      endpoint: config.endpoint || '',
      shopUrl: config.shopUrl || '',
      brand: config.brand || 'kogler',
      brandName: config.brandName || '',
      search: config.search || '',
      categories: Array.isArray(config.categories) ? [...config.categories] : [],
      attributes: config.attributes && typeof config.attributes === 'object'
        ? JSON.parse(JSON.stringify(config.attributes))
        : {},
      facets: config.facets || { categories: [], attributes: [] },
      paged: Number(config.paged) || 1,
      loading: false,
      filtersOpen: false,
      isDesktop: false,
      _mqlDesktop: null,

      init() {
        ctx = this;
        ctx._mqlDesktop = window.matchMedia('(min-width: 64rem)');
        ctx.isDesktop = ctx._mqlDesktop.matches;
        ctx._onBreakpoint = () => {
          ctx.isDesktop = ctx._mqlDesktop.matches;
          if (ctx.isDesktop) {
            ctx.closeFilters();
          }
        };
        ctx._mqlDesktop.addEventListener?.('change', ctx._onBreakpoint);
      },

      destroy() {
        ctx.closeFilters();
        ctx._mqlDesktop?.removeEventListener?.('change', ctx._onBreakpoint);
      },

      openFilters() {
        if (ctx.isDesktop) return;
        ctx.filtersOpen = true;
        document.documentElement.classList.add('mpx-shop-filters-open');
      },

      closeFilters() {
        ctx.filtersOpen = false;
        document.documentElement.classList.remove('mpx-shop-filters-open');
      },

      activeFilterCount() {
        let count = 0;
        if (ctx.search.trim() !== '') count += 1;
        count += ctx.categories.length;
        Object.values(ctx.attributes).forEach((slugs) => {
          if (Array.isArray(slugs)) count += slugs.length;
        });
        return count;
      },

      hasActiveFilters() {
        if (ctx.search.trim() !== '') return true;
        if (ctx.categories.length) return true;
        return Object.values(ctx.attributes).some((slugs) => Array.isArray(slugs) && slugs.length > 0);
      },

      activeChips() {
        const chips = [];
        if (ctx.search.trim() !== '') {
          chips.push({ key: 's', type: 'search', label: ctx.search.trim() });
        }
        ctx.categories.forEach((slug) => {
          const term = (ctx.facets.categories || []).find((t) => t.slug === slug);
          chips.push({
            key: `cat-${slug}`,
            type: 'category',
            slug,
            label: term?.name || slug,
          });
        });
        Object.entries(ctx.attributes).forEach(([name, slugs]) => {
          const group = (ctx.facets.attributes || []).find((g) => g.name === name);
          (slugs || []).forEach((slug) => {
            const term = (group?.terms || []).find((t) => t.slug === slug);
            chips.push({
              key: `${name}-${slug}`,
              type: 'attribute',
              name,
              slug,
              label: term?.name || slug,
            });
          });
        });
        return chips;
      },

      removeChip(chip) {
        if (chip.type === 'search') {
          ctx.search = '';
        } else if (chip.type === 'category') {
          ctx.categories = ctx.categories.filter((s) => s !== chip.slug);
        } else if (chip.type === 'attribute') {
          const next = (ctx.attributes[chip.name] || []).filter((s) => s !== chip.slug);
          if (next.length) {
            ctx.attributes[chip.name] = next;
          } else {
            const copy = { ...ctx.attributes };
            delete copy[chip.name];
            ctx.attributes = copy;
          }
        }
        ctx.paged = 1;
        ctx.fetchResults(true);
      },

      onSearch() {
        ctx.paged = 1;
        ctx.fetchResults(true);
      },

      toggleCategory(slug) {
        if (ctx.categories.includes(slug)) {
          ctx.categories = ctx.categories.filter((s) => s !== slug);
        } else {
          ctx.categories = [...ctx.categories, slug];
        }
        ctx.paged = 1;
        ctx.fetchResults(true);
      },

      toggleAttribute(name, slug) {
        const current = Array.isArray(ctx.attributes[name]) ? [...ctx.attributes[name]] : [];
        const next = current.includes(slug)
          ? current.filter((s) => s !== slug)
          : [...current, slug];
        const copy = { ...ctx.attributes };
        if (next.length) {
          copy[name] = next;
        } else {
          delete copy[name];
        }
        ctx.attributes = copy;
        ctx.paged = 1;
        ctx.fetchResults(true);
      },

      goToPage(page) {
        ctx.paged = Math.max(1, Number(page) || 1);
        ctx.fetchResults(true);
      },

      onPaginationClick(event) {
        const link = event.target.closest('[data-mpx-shop-page]');
        if (! link) return;
        event.preventDefault();
        ctx.goToPage(link.getAttribute('data-mpx-shop-page'));
      },

      buildParams() {
        const params = new URLSearchParams();
        params.set('brand', ctx.brand);
        if (ctx.search.trim() !== '') {
          params.set('s', ctx.search.trim());
        }
        if (ctx.categories.length) {
          params.set('product_cat', ctx.categories.join(','));
        }
        Object.entries(ctx.attributes).forEach(([name, slugs]) => {
          if (Array.isArray(slugs) && slugs.length) {
            params.set(name, slugs.join(','));
          }
        });
        if (ctx.paged > 1) {
          params.set('paged', String(ctx.paged));
        }
        return params;
      },

      async fetchResults(pushUrl) {
        if (! ctx.endpoint) return;

        const seq = ++requestSeq;
        abortController?.abort();
        abortController = new AbortController();
        ctx.loading = true;

        try {
          const params = ctx.buildParams();
          const response = await fetch(`${ctx.endpoint}?${params.toString()}`, {
            signal: abortController.signal,
            headers: { Accept: 'application/json' },
          });
          if (! response.ok) throw new Error(`Shop filter request failed (${response.status})`);
          const data = await response.json();
          if (seq !== requestSeq) return;

          if (ctx.$refs.products) {
            ctx.$refs.products.innerHTML = data.products_html || '';
          }
          if (ctx.$refs.pagination) {
            ctx.$refs.pagination.innerHTML = data.pagination_html || '';
          }
          if (data.facets) {
            ctx.facets = data.facets;
          }
          if (data.title) {
            ctx.brandName = data.title;
          }
          if (data.paged) {
            ctx.paged = Number(data.paged) || 1;
          }

          if (pushUrl && data.url) {
            window.history.pushState({ mpxShop: true }, '', data.url);
          }

          if (pushUrl && ctx.paged > 1) {
            ctx.$el.querySelector('.mpx-shop__main')?.scrollIntoView({
              behavior: 'smooth',
              block: 'start',
            });
          }

          if (window.jQuery) {
            window.jQuery(document.body).trigger('wc_fragment_refresh');
          }
        } catch (error) {
          if (error?.name === 'AbortError') return;
          console.error(error);
        } finally {
          if (seq === requestSeq) {
            ctx.loading = false;
          }
        }
      },

      onPopState() {
        const params = new URLSearchParams(window.location.search);
        ctx.brand = params.get('brand') || ctx.brand;
        ctx.search = params.get('s') || '';
        ctx.categories = (params.get('product_cat') || '')
          .split(',')
          .map((s) => s.trim())
          .filter(Boolean);
        const attrs = {};
        (ctx.facets.attributes || []).forEach((group) => {
          const raw = params.get(group.name);
          if (raw) {
            attrs[group.name] = raw.split(',').map((s) => s.trim()).filter(Boolean);
          }
        });
        // Also pick any other known attribute query keys from current facets
        params.forEach((value, key) => {
          if (['brand', 's', 'product_cat', 'paged', 'page'].includes(key)) return;
          if (! attrs[key] && value) {
            attrs[key] = value.split(',').map((s) => s.trim()).filter(Boolean);
          }
        });
        ctx.attributes = attrs;
        ctx.paged = Math.max(1, Number(params.get('paged') || 1));
        ctx.fetchResults(false);
      },
    };
  });

  /**
   * Brand fitment guide. Methods close over `ctx` because Alpine calls
   * expressions such as `submit()` unbound.
   */
  Alpine.data('fitmentGuide', () => {
    let ctx;

    const uniqueSorted = (values) => [...new Set(values.filter(Boolean))]
      .sort((a, b) => String(a).localeCompare(String(b)));

    return {
      fitments: [],
      make: '',
      model: '',
      result: null,
      contactUrl: '#',

      init() {
        ctx = this;
        ctx.contactUrl = ctx.$el.dataset.contactUrl || '#';

        try {
          const parsed = JSON.parse(ctx.$el.dataset.fitments || '[]');
          ctx.fitments = Array.isArray(parsed) ? parsed : [];
        } catch (error) {
          ctx.fitments = [];
        }
      },

      get makes() {
        return uniqueSorted((this.fitments || []).map((row) => row.make));
      },

      get models() {
        if (! this.make) {
          return [];
        }

        return uniqueSorted(
          (this.fitments || [])
            .filter((row) => row.make === this.make)
            .map((row) => row.model),
        );
      },

      onMakeChange() {
        ctx.model = '';
        ctx.result = null;
      },

      submit() {
        const match = ctx.fitments.find((row) => row.make === ctx.make && row.model === ctx.model);

        if (! match) {
          ctx.result = { status: 'none' };
          return;
        }

        ctx.result = { status: 'match', ...match };
      },

      sizeLabel(row) {
        if (! row || row.status !== 'match') {
          return '';
        }

        const mark = (value) => {
          const text = String(value ?? '');
          return text.includes('"') ? text : `${text}"`;
        };

        return `${mark(row.width)} × ${mark(row.length)} × ${mark(row.thickness)}`;
      },
    };
  });

  /**
   * Kögler Sleep mattress finder. One scope covers the card and the results.
   * Methods close over `ctx` because Alpine calls them unbound.
   */
  Alpine.data('fitmentFinder', (data = {}) => {
    let ctx;

    const empty = { trucks: {}, makeNotes: {}, parts: {} };

    const bunksFor = (catalog, make, model) => {
      const truck = catalog.trucks?.[make]?.[model];

      if (! truck) {
        return [];
      }

      return truck.bunks.map((bunk) => {
        const widthsLabel = bunk.widths.map((width) => `${width}"`).join(' or ');
        const expanded = bunk.widths.flatMap((width) => (width === '38/39' ? ['38', '39'] : [width]));
        const options = expanded.flatMap((width) => (catalog.parts[width] || []).map((part) => ({
          type: `${part.construction}, ${part.cover} cover`,
          size: `${width}" × ${width === '29' ? '79' : '80'}" × 7"`,
          sku: part.sku,
        })));

        const extra = bunk.mark && catalog.footnotes ? catalog.footnotes[bunk.mark] : '';
        let note = bunk.note || '';

        if (note && extra) {
          note = `${note}${/[.!?]$/.test(note) ? ' ' : '. '}${extra}`;
        } else if (extra) {
          note = extra;
        }

        return {
          position: bunk.position,
          widthsLabel,
          note,
          options,
        };
      });
    };

    return {
      catalog: empty,
      make: '',
      model: null,

      init() {
        ctx = this;
        ctx.catalog = data && data.trucks ? data : empty;

        const params = new URLSearchParams(window.location.search);
        const make = params.get('make') || '';
        const modelParam = params.get('model');
        const models = ctx.catalog.trucks[make] || [];

        if (! models.length) {
          return;
        }

        ctx.make = make;

        if (modelParam !== null && modelParam !== '' && models[Number(modelParam)]) {
          ctx.model = Number(modelParam);
        } else if (models.length === 1) {
          ctx.model = 0;
        }

        ctx.dispatchWidths();
        ctx.publishSelection();
      },

      dispatchWidths() {
        const widths = [];

        if (ctx.make !== '' && ctx.model !== null) {
          const truck = ctx.catalog.trucks?.[ctx.make]?.[ctx.model];

          (truck?.bunks || []).forEach((bunk) => {
            bunk.widths.forEach((width) => {
              if (width === '38/39') {
                widths.push('38', '39');
              } else {
                widths.push(String(width));
              }
            });
          });
        }

        window.dispatchEvent(new CustomEvent('fitment:widths', {
          detail: { widths: [...new Set(widths)] },
        }));
      },

      publishSelection() {
        const store = Alpine.store('fitment');
        const model = ctx.model !== null ? ctx.catalog.trucks?.[ctx.make]?.[ctx.model] : null;
        store.make = ctx.make || '';
        store.model = ctx.model;
        store.truck = model ? `${ctx.make} ${model.name}` : '';
      },

      get makes() {
        return Object.keys(ctx.catalog.trucks || {});
      },

      get models() {
        if (ctx.make === '') {
          return [];
        }

        return ctx.catalog.trucks[ctx.make] || [];
      },

      get bunks() {
        if (ctx.make === '' || ctx.model === null) {
          return [];
        }

        return bunksFor(ctx.catalog, ctx.make, ctx.model);
      },

      get truckName() {
        const model = ctx.catalog.trucks?.[ctx.make]?.[ctx.model];

        return model ? `${ctx.make} ${model.name}` : '';
      },

      get makeNote() {
        return ctx.catalog.makeNotes?.[ctx.make] || '';
      },

      get emptyMessage() {
        if (ctx.make === '') {
          return 'Choose your truck make to see which Kögler mattress fits.';
        }

        if (ctx.model === null) {
          return `Now choose your ${ctx.make} model.`;
        }

        return '';
      },

      onMakeChange() {
        const models = ctx.catalog.trucks[ctx.make] || [];
        ctx.model = models.length === 1 ? 0 : null;
        ctx.syncUrl();
        ctx.dispatchWidths();
      },

      onModelChange(event) {
        const value = event.target.value;
        ctx.model = value === '' ? null : Number(value);
        ctx.syncUrl();
        ctx.dispatchWidths();
      },

      selectTruck(detail) {
        const models = detail && ctx.catalog.trucks[detail.make];

        if (! models || ! models.length) {
          return;
        }

        const index = Number(detail.model);
        ctx.make = detail.make;
        ctx.model = Number.isInteger(index) && models[index] ? index : (models.length === 1 ? 0 : null);
        ctx.syncUrl();
        ctx.dispatchWidths();

        const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        document.getElementById('find-your-size')?.scrollIntoView({
          behavior: reduce ? 'auto' : 'smooth',
          block: 'start',
        });
      },

      syncUrl() {
        const url = new URL(window.location.href);

        if (ctx.make) {
          url.searchParams.set('make', ctx.make);
        } else {
          url.searchParams.delete('make');
        }

        if (ctx.model !== null) {
          url.searchParams.set('model', String(ctx.model));
        } else {
          url.searchParams.delete('model');
        }

        window.history.replaceState(null, '', url);
        ctx.publishSelection();
      },
    };
  });

  /**
   * Size Finder: copy a SKU, and highlight widths sent by the mattress finder.
   */
  Alpine.data('sizeFinder', () => {
    let ctx;
    let copiedTimer;

    return {
      copied: '',
      widths: [],

      init() {
        ctx = this;
      },

      setWidths(detail) {
        ctx.widths = detail && Array.isArray(detail.widths) ? detail.widths.map(String) : [];
      },

      highlighted(width) {
        return ctx.widths.includes(String(width));
      },

      async copySku(sku, event) {
        window.clearTimeout(copiedTimer);

        try {
          if (! navigator.clipboard || ! navigator.clipboard.writeText) {
            throw new Error('clipboard unavailable');
          }

          await navigator.clipboard.writeText(sku);
          ctx.copied = sku;
          copiedTimer = window.setTimeout(() => {
            if (ctx.copied === sku) {
              ctx.copied = '';
            }
          }, 1500);
        } catch (error) {
          const range = document.createRange();
          range.selectNodeContents(event.currentTarget);
          const selection = window.getSelection();
          selection.removeAllRanges();
          selection.addRange(range);
          ctx.copied = '';
        }
      },
    };
  });

  /**
   * Goliath Quick Reference. Copy a part number, then clear the confirmation.
   */
  Alpine.data('goliathQuickReference', () => {
    let ctx;
    let copiedTimer;

    return {
      copied: '',

      init() {
        ctx = this;
      },

      async copySku(sku, event) {
        window.clearTimeout(copiedTimer);

        try {
          if (! navigator.clipboard || ! navigator.clipboard.writeText) {
            throw new Error('clipboard unavailable');
          }

          await navigator.clipboard.writeText(sku);
          ctx.copied = sku;
          copiedTimer = window.setTimeout(() => {
            if (ctx.copied === sku) {
              ctx.copied = '';
            }
          }, 1500);
        } catch (error) {
          const range = document.createRange();
          range.selectNodeContents(event.currentTarget);
          const selection = window.getSelection();
          selection.removeAllRanges();
          selection.addRange(range);
          ctx.copied = '';
        }
      },
    };
  });

  /**
   * Goliath product card. Each card keeps its own variant.
   */
  Alpine.data('goliathProduct', (config = {}) => ({
    variant: config.variant ?? '',
    keys: Array.isArray(config.keys) ? config.keys : [],

    next(step) {
      if (this.keys.length < 2) {
        return;
      }

      const index = this.keys.indexOf(this.variant);
      const next = (index + step + this.keys.length) % this.keys.length;
      this.variant = this.keys[next];
      this.$nextTick(() => {
        this.$root.querySelector(`[data-tab="${this.variant}"]`)?.focus();
      });
    },
  }));
});

Alpine.start();

const headerScrollOn = 48;
const headerScrollOff = 8;
let headerIsScrolled = window.scrollY > headerScrollOn;

function syncHeaderScrolled() {
  const y = window.scrollY;

  if (!headerIsScrolled && y > headerScrollOn) {
    headerIsScrolled = true;
  } else if (headerIsScrolled && y < headerScrollOff) {
    headerIsScrolled = false;
  }

  document.body.classList.toggle('scrolled', headerIsScrolled);
}

syncHeaderScrolled();
window.addEventListener('scroll', syncHeaderScrolled, { passive: true });

/**
 * Admin bar + preheader + the full main-header slot.
 * `--site-header-h` stays the unscrolled stack. The shortened bar does not change it.
 * Admin bar only when `#wpadminbar` is visible (logged-in).
 */
function syncSiteChromeHeight() {
  const adminBar = document.getElementById('wpadminbar');
  const preheader = document.querySelector('.preheader');
  const slot = document.querySelector('.header-bar-slot');
  const header = document.getElementById('main-header');
  let adminBarHeight = 0;
  let preheaderHeight = 0;
  let height = 0;

  if (adminBar && getComputedStyle(adminBar).display !== 'none') {
    adminBarHeight = adminBar.getBoundingClientRect().height;
  }

  if (preheader && getComputedStyle(preheader).display !== 'none') {
    preheaderHeight = preheader.getBoundingClientRect().height;
  }

  if (slot) {
    height = slot.offsetHeight;
  } else if (header) {
    height = header.offsetHeight;
  }

  document.documentElement.style.setProperty(
    '--site-admin-bar-height',
    `${Math.round(adminBarHeight)}px`
  );
  document.documentElement.style.setProperty(
    '--site-preheader-height',
    `${Math.round(preheaderHeight)}px`
  );
  document.documentElement.style.setProperty('--site-chrome-height', `${Math.round(height)}px`);
  document.documentElement.style.setProperty(
    '--site-header-h',
    `${Math.round(preheaderHeight + height + adminBarHeight)}px`
  );
}

/**
 * Partners marquee: fill the viewport with cloned groups (avoids empty
 * teal when the logo set is narrower than the screen), then set pixel
 * shift + duration from the first group width.
 * Percentage translateX is unreliable with width:max-content on iOS.
 */
function syncPartnersMarqueeShift() {
  const pxPerSecond = window.matchMedia('(max-width: 767px)').matches ? 55 : 45;
  const minTrackWidth = Math.max(window.innerWidth, document.documentElement.clientWidth) * 2;

  document.querySelectorAll('.mpx-partners-slider .wp-block-gallery[data-mpx-marquee="true"]').forEach((gallery) => {
    const groups = [...gallery.querySelectorAll(':scope > .mpx-partners-group')];
    const source = groups[0];
    if (!source) return;

    // Reset to a single source group, then rebuild clones for this viewport.
    groups.slice(1).forEach((group) => group.remove());

    const firstClone = source.cloneNode(true);
    firstClone.setAttribute('aria-hidden', 'true');
    gallery.appendChild(firstClone);

    // Keep cloning until the track covers 2× viewport (seamless + no gap).
    let guard = 0;
    while (gallery.scrollWidth < minTrackWidth && guard < 12) {
      const extra = source.cloneNode(true);
      extra.setAttribute('aria-hidden', 'true');
      gallery.appendChild(extra);
      guard += 1;
    }

    const width = source.getBoundingClientRect().width;
    if (width <= 0) return;

    gallery.style.setProperty('--mpx-partners-shift', `-${width}px`);
    gallery.style.setProperty('--mpx-partners-duration', `${Math.max(width / pxPerSecond, 12)}s`);
  });
}

function syncLayoutMetrics() {
  syncSiteChromeHeight();
  syncPartnersMarqueeShift();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', syncLayoutMetrics, { once: true });
} else {
  syncLayoutMetrics();
}

window.addEventListener('load', syncLayoutMetrics);
window.addEventListener('resize', syncLayoutMetrics);

/**
 * WooCommerce variable products: pill buttons sync to the hidden attribute
 * <select> so core variation.js keeps working. Also mirrors the selected
 * variation price into the summary price under the title.
 */
function syncMpxVariationPills(form) {
  form.querySelectorAll('.mpx-variation').forEach((row) => {
    const select = row.querySelector('select');
    const label = row.querySelector('[data-mpx-selected-label]');
    const pills = [...row.querySelectorAll('.mpx-variation__pill')];
    if (! select || ! pills.length) return;

    const paint = () => {
      const value = select.value;
      let selectedLabel = '';

      pills.forEach((pill) => {
        const on = pill.dataset.value === value;
        pill.classList.toggle('is-selected', on);
        pill.setAttribute('aria-selected', on ? 'true' : 'false');
        if (on) {
          selectedLabel = pill.dataset.label || pill.textContent.trim();
        }
      });

      if (label) {
        label.textContent = selectedLabel;
      }
    };

    pills.forEach((pill) => {
      if (pill.dataset.mpxBound === '1') return;
      pill.dataset.mpxBound = '1';
      pill.addEventListener('click', () => {
        if (select.value === pill.dataset.value) return;
        select.value = pill.dataset.value;
        select.dispatchEvent(new Event('change', { bubbles: true }));
        if (window.jQuery) {
          window.jQuery(select).trigger('change');
        }
        paint();
      });
    });

    select.addEventListener('change', paint);

    // Preselect the first size when none is chosen (matches design comps).
    if (! select.value && pills[0]?.dataset.value) {
      select.value = pills[0].dataset.value;
      select.dispatchEvent(new Event('change', { bubbles: true }));
      if (window.jQuery) {
        window.jQuery(select).trigger('change');
      }
    }

    paint();
  });
}

function initMpxVariationPriceMirror(form) {
  const summary = form.closest('.mpx-single-product, .product');
  const priceEl = summary?.querySelector('.summary > p.price, .summary > .price');
  if (! priceEl || ! window.jQuery) return;

  if (form.dataset.mpxPriceBound === '1') return;
  form.dataset.mpxPriceBound = '1';

  const $form = window.jQuery(form);
  const original = priceEl.innerHTML;

  $form.on('found_variation', (_event, variation) => {
    if (variation?.price_html) {
      priceEl.innerHTML = variation.price_html;
    }
  });

  $form.on('reset_data hide_variation', () => {
    priceEl.innerHTML = original;
  });
}

/**
 * Specs panel: update variation attributes (e.g. Size) and append
 * Width / Length / Height when the selected variation has dimensions.
 */
function initMpxProductSpecs(form) {
  const root = form.closest('.mpx-single-product, .product');
  const specs = root?.querySelector('[data-mpx-product-specs]');
  if (! specs || ! window.jQuery) return;
  if (form.dataset.mpxSpecsBound === '1') return;
  form.dataset.mpxSpecsBound = '1';

  const $form = window.jQuery(form);

  const labelForAttribute = (attrName, slug) => {
    if (! slug) return '';
    const row = form.querySelector(`.mpx-variation[data-attribute="${CSS.escape(attrName.replace(/^attribute_/, ''))}"]`);
    const pill = row?.querySelector(`.mpx-variation__pill[data-value="${CSS.escape(slug)}"]`);
    if (pill) {
      return pill.dataset.label || pill.textContent.trim();
    }
    const select = form.querySelector(`select[name="${CSS.escape(attrName)}"]`);
    const option = select ? [...select.options].find((opt) => opt.value === slug) : null;
    return option?.textContent?.trim() || slug;
  };

  const setSpecValue = (row, value) => {
    const cell = row.querySelector('[data-mpx-spec-value]');
    if (! cell) return;

    cell.replaceChildren();
    const parts = String(value || '')
      .split(/,\s*/)
      .map((part) => part.trim())
      .filter(Boolean);

    parts.forEach((part) => {
      const option = document.createElement('span');
      option.className = 'mpx-product-specs__option';
      option.textContent = part;
      cell.appendChild(option);
    });
  };

  const resetSpecs = () => {
    specs.querySelectorAll('[data-mpx-spec]').forEach((row) => {
      if (row.hasAttribute('data-mpx-spec-dimension')) {
        row.hidden = true;
        setSpecValue(row, '');
        return;
      }
      setSpecValue(row, row.dataset.mpxSpecDefault || '');
    });
  };

  const applyVariation = (variation) => {
    if (! variation) {
      resetSpecs();
      return;
    }

    const attributes = variation.attributes || {};
    Object.entries(attributes).forEach(([attrName, slug]) => {
      if (! slug) return;
      const row = specs.querySelector(`[data-mpx-spec-attr="${CSS.escape(attrName)}"]`);
      if (! row) return;
      setSpecValue(row, labelForAttribute(attrName, slug));
    });

    const formatDimension = (raw) => {
      const value = String(raw || '').trim();
      if (! value) return '';
      // Avoid doubling if the store already includes a unit/" mark.
      if (/["″]|in(?:ch(?:es)?)?\b|cm\b|mm\b|m\b/i.test(value)) {
        return value;
      }
      return `${value}"`;
    };

    const dimensions = variation.dimensions || {};
    ['width', 'length', 'height'].forEach((dim) => {
      const row = specs.querySelector(`[data-mpx-spec="${dim}"][data-mpx-spec-dimension]`);
      if (! row) return;
      const value = formatDimension(dimensions[dim]);
      if (value) {
        row.hidden = false;
        setSpecValue(row, value);
      } else {
        row.hidden = true;
        setSpecValue(row, '');
      }
    });
  };

  $form.on('found_variation', (_event, variation) => {
    applyVariation(variation);
  });

  $form.on('reset_data hide_variation', () => {
    resetSpecs();
  });
}

function initMpxVariationPills() {
  document.querySelectorAll('form.variations_form').forEach((form) => {
    syncMpxVariationPills(form);
    initMpxVariationPriceMirror(form);
    initMpxProductSpecs(form);

    if (form.dataset.mpxPillsBound === '1') return;
    form.dataset.mpxPillsBound = '1';

    if (window.jQuery) {
      window.jQuery(form).on('woocommerce_update_variation_values reset_data', () => {
        syncMpxVariationPills(form);
      });

      // Re-check variations after our preselect so ATC enables + price updates.
      window.jQuery(form).trigger('check_variations');
    }
  });
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initMpxVariationPills, { once: true });
} else {
  initMpxVariationPills();
}
