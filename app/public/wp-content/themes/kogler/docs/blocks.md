# Kogler blocks inventory

Namespace `mpx/*`. Sections: `metapixels-blocks`. Partials: `metapixels-partials`. Scan root: theme `app/blocks`. Deep decisions: [`BLOCKSTUDIO-7.md`](../BLOCKSTUDIO-7.md).

## Sections

| Block | Purpose | Typical children |
| --- | --- | --- |
| `mpx/hero` | Cinematic full-bleed photo or looping video + light black overlay | `partial-subheading`, `core/heading`, `core/paragraph`, `mpx/partial-button` |
| `mpx/column-cover` | Full-bleed cover image + content box overlay | `core/heading`, `core/paragraph`, `mpx/partial-button` |
| `mpx/columns` | Two-column section; solid/image bg; widths on parent | `partial-column` × 2 (optional card bg; checklist allowed) |
| `mpx/one-column` | Single content column | Heading, paragraph, list, image, video, embed (YouTube etc.), button, subheading, cards, products, checklist, Rank Math FAQ, Fluent Form |
| `mpx/feature-mosaic` | One-off bento promo grid (2 small + 1 wide + 1 tall) | `partial-mosaic-tile` × 4 (`templateLock=insert`) |
| `mpx/form-cta` | Bordered contact CTA panel; two columns via `partial-column` | `partial-column` × 2 (copy + Fluent Form) |
| `mpx/partners-slider` | Logo marquee | `core/gallery`, heading, paragraph |

## Partials

| Block | Purpose | Typical children |
| --- | --- | --- |
| `mpx/partial-column` | Grid cell; widths set on parent Columns; hidden `allowedBlocks` | heading, paragraph, list, image, html, button, subheading, checklist, Fluent Forms |
| `mpx/partial-button` | Theme button wrapper | `core/button` / `core/buttons` |
| `mpx/partial-subheading` | Label + accent bar | (own attrs / InnerBlocks as implemented) |
| `mpx/partial-cards` | Card grid / optional slider; solid card bg; Grid Controls | `partial-card`, `partial-card-icon`, `partial-card-image`, `partial-card-square`, `partial-card-cover`, `partial-card-cover-small`, `partial-card-testimonial-simple`, `partial-button` |
| `mpx/partial-products` | WooCommerce product card grid (4-up); latest / custom / by category | — |
| `mpx/partial-card` | Text card; optional check/icon (off = centered tile) | heading, paragraph, `partial-button` |
| `mpx/partial-card-icon` | Icon + text card | `partial-icon`, heading, paragraph, `partial-button` |
| `mpx/partial-card-image` | Image/logo card; optional edge-to-edge, centred content, natural image size | image, heading, paragraph, `partial-button` |
| `mpx/partial-card-square` | Square image tile with optional link (brand / logo cards) | — |
| `mpx/partial-card-cover` | Full-bleed photo + scrim; own bg image (like Hero); tall feature layout | `partial-tags`, heading, paragraph, `partial-button` (link-white) |
| `mpx/partial-card-cover-small` | Compact cover tile; centred title + pill CTA; height from content | heading, paragraph (optional), `partial-button` (primary) |
| `mpx/partial-mosaic-tile` | Feature Mosaic cell; photo or solid colour; centred title + pill CTA | heading, paragraph (optional), `partial-button` |
| `mpx/partial-card-testimonial-simple` | Name / role, quote, optional star rating | heading, paragraph |
| `mpx/partial-icon` | Sprite icon (`footer-icons`) | — |
| `mpx/partial-tags` | Pill tag row | `partial-tag` |
| `mpx/partial-tag` | Single pill | `core/paragraph` |
| `mpx/partial-checklist` | Checkmark list | `partial-checklist-item` |
| `mpx/partial-checklist-item` | List row | `core/paragraph` |

## Parent → child matrix (defaults)

```
mpx/hero
  └─ mpx/partial-subheading | core/heading | core/paragraph | mpx/partial-button
     (+ full-bleed background image and/or looping video + poster)

mpx/column-cover
  └─ core/heading | core/paragraph | mpx/partial-button
     (+ full-bleed cover image + content box colour / left|right)

mpx/columns  (vertical_align; sticky_column none|left|right desktop-only;
              col_1/col_2 widths; gaps; mobile = 100%)
  └─ mpx/partial-column × 2  (optional bg_colour card panel)
       └─ heading | paragraph | list | image | html | partial-button | partial-subheading | partial-checklist | fluentfom/guten-block

mpx/one-column
  └─ heading | paragraph | list | image | video | embed | partial-button | partial-subheading
     | partial-cards | partial-products | partial-checklist | rank-math/faq-block | fluentfom/guten-block

mpx/feature-mosaic  (section padding + bg colour; desktop bento A|B|D / C—|D)
  └─ partial-mosaic-tile × 4  (image and/or solid tile_bg; heading + partial-button)

mpx/form-cta  (section padding + bg; bordered/padded panel; gaps + column widths)
  └─ partial-column × 2  (same allowed blocks as Columns)
       ├─ copy: fs-tagline paragraph | heading | paragraph (optional subheading)
       └─ form: fluentfom/guten-block

mpx/partial-cards  (enable_slider + optional autoplay ping-pong;
                   slides_desktop + slides_tablet; editor = wrapping grid;
                   frontend slider = exact-fit N visible, step by 1 + bullets)
  └─ partial-card | partial-card-icon | partial-card-image | partial-card-square
     | partial-card-cover | partial-card-cover-small | partial-card-testimonial-simple
     | partial-button
     (media coverage: card-image + btn-white;
      square: edge-to-edge image + optional link;
      cover: own bg image + tags + link-white CTAs;
      cover-small: category tiles, title + btn-primary;
      button row: 3× partial-button + cols ~33%; testimonials: name/role + quote + stars)

mpx/partial-card-cover
  └─ partial-tags → partial-tag → paragraph
     | heading | paragraph | partial-button (btn-link-white + icon)

mpx/partial-card-cover-small
  └─ heading | paragraph | partial-button (btn-primary)

mpx/partial-tags
  └─ partial-tag → core/paragraph

mpx/partial-checklist
  └─ partial-checklist-item → core/paragraph

mpx/partners-slider
  └─ core/gallery | core/heading | core/paragraph
```

## Shared pieces

- **Reusable fields** (`app/blocks/fields/{name}/` only): `section_padding`, `background`, `background_colour`, `grid_controls`, `grid_gaps`, `column_widths`, `grid_item_width`, `text_colour`, `typography`.
- **Extensions**: `core/button`, `core/heading`, `core/paragraph`, `rank-math/faq-block`.
- **New `mpx/*` block**: add name to `mpxRemoveInnerBlocksWrapper()` in `trait-blocks.php`.
- **Fluent Forms block id**: `fluentfom/guten-block` (plugin typo — keep it).
- **Patterns / pages**: not added yet (`patterns/`, `pages/` at theme root when needed). FSE site templates unused.
