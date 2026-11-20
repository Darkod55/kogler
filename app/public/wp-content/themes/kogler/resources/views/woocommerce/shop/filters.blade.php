{{--
  Shop sidebar filters — search, categories, auto attribute facets.
  Category is open by default; attribute groups are collapsed.
--}}

@php
  $facets = $facets ?? ['categories' => [], 'attributes' => []];
  $search = $search ?? '';
  $selectedCategories = $selectedCategories ?? [];
  $selectedAttributes = $selectedAttributes ?? [];
@endphp

<div class="mpx-shop-filters">
  <div class="mpx-shop-filters__search">
    <label class="mpx-shop-filters__search-label sr-only" for="mpx-shop-search">
      {{ __('Search products', 'sage') }}
    </label>
    <div class="mpx-shop-filters__search-field">
      <span class="mpx-shop-filters__search-icon" aria-hidden="true">@svgIcon('search'|18|18)</span>
      <input
        id="mpx-shop-search"
        type="search"
        class="mpx-shop-filters__search-input"
        placeholder="{{ esc_attr__('Search', 'sage') }}"
        autocomplete="off"
        x-model="search"
        @input.debounce.300ms="onSearch()"
      >
    </div>
  </div>

  <div class="mpx-shop-filters__chips" x-show="hasActiveFilters()" x-cloak>
    <template x-for="chip in activeChips()" :key="chip.key">
      <button
        type="button"
        class="mpx-shop-filters__chip"
        @click="removeChip(chip)"
      >
        <span class="mpx-shop-filters__chip-label" x-text="chip.label"></span>
        <span class="mpx-shop-filters__chip-x" aria-hidden="true">@svgIcon('close'|12|12)</span>
      </button>
    </template>
  </div>

  <details
    class="mpx-shop-filters__group"
    open
    x-show="facets.categories.length"
    x-cloak
  >
    <summary class="mpx-shop-filters__heading">
      <span class="mpx-shop-filters__heading-label">{{ __('Category', 'sage') }}</span>
      <span class="mpx-shop-filters__heading-icon" aria-hidden="true">@svgIcon('chevron-down'|16|16)</span>
    </summary>
    <ul class="mpx-shop-filters__list">
      <template x-for="term in facets.categories" :key="'cat-' + term.slug">
        <li class="mpx-shop-filters__item">
          <label class="mpx-shop-filters__check">
            <input
              type="checkbox"
              class="mpx-shop-filters__checkbox"
              :value="term.slug"
              :checked="categories.includes(term.slug)"
              @change="toggleCategory(term.slug)"
            >
            <span class="mpx-shop-filters__check-copy">
              <span class="mpx-shop-filters__check-label" x-text="term.name"></span>
              <span class="mpx-shop-filters__check-count" x-text="'(' + term.count + ')'"></span>
            </span>
          </label>
        </li>
      </template>
    </ul>
  </details>

  <template x-for="group in facets.attributes" :key="'attr-' + group.name">
    <details
      class="mpx-shop-filters__group"
      :open="(attributes[group.name] || []).length > 0"
    >
      <summary class="mpx-shop-filters__heading">
        <span class="mpx-shop-filters__heading-label" x-text="group.label"></span>
        <span class="mpx-shop-filters__heading-icon" aria-hidden="true">@svgIcon('chevron-down'|16|16)</span>
      </summary>
      <ul class="mpx-shop-filters__list">
        <template x-for="term in group.terms" :key="group.name + '-' + term.slug">
          <li class="mpx-shop-filters__item">
            <label class="mpx-shop-filters__check">
              <input
                type="checkbox"
                class="mpx-shop-filters__checkbox"
                :value="term.slug"
                :checked="(attributes[group.name] || []).includes(term.slug)"
                @change="toggleAttribute(group.name, term.slug)"
              >
              <span class="mpx-shop-filters__check-copy">
                <span class="mpx-shop-filters__check-label" x-text="term.name"></span>
                <span class="mpx-shop-filters__check-count" x-text="'(' + term.count + ')'"></span>
              </span>
            </label>
          </li>
        </template>
      </ul>
    </details>
  </template>
</div>
