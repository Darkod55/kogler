# WooCommerce — Kogler theme map

Agent playbook for this theme’s commerce skin. For portable CSS/cascade rules that apply on any Sage + Woo project, use the Cursor skill `sage-woocommerce-skin` (`~/.cursor/skills/sage-woocommerce-skin/`).

Paths below are **theme-relative** (`app/public/wp-content/themes/kogler/…`).

## Stack

| Piece | Location |
| --- | --- |
| Package | `generoi/sage-woocommerce` (Composer) |
| Support / gallery | `app/setup.php` |
| Hooks | `app/wc-template-hooks.php` |
| Skin | `resources/css/theme/woocommerce.css` (via `resources/css/theme.css`) |
| Blade | `resources/views/woocommerce/` |
| AJAX catalog | `app/Classes/ShopCatalog.php` — REST `mpx/v1/shop` |
| Header cart/account | `resources/views/sections/header.blade.php` + fragments in `app/filters.php` |

Dev: from theme dir, `npm run build` (or `npm run dev`) after CSS changes.

## Templates

| View | Purpose |
| --- | --- |
| `archive-product.blade.php` | Shop + product tax archives (filters sidebar, Alpine catalog) |
| `shop/filters.blade.php` | Search, category, attribute facets |
| `shop/pagination.blade.php` | Catalog pagination markup |
| `content-product.blade.php` | Loop card (`.mpx-product-card`) |
| `single-product.blade.php` / `content-single-product.blade.php` | PDP shell |
| `single-product/details.blade.php`, `related.blade.php`, `product-image.blade.php`, `meta.blade.php`, `add-to-cart/variable.blade.php` | PDP pieces |
| `checkout/form-checkout.blade.php` | Classic checkout layout |

## Hooks highlights (`wc-template-hooks.php`)

- Replaces Woo content wrappers with `.woocommerce-site.p-clamp` → `.container`.
- Removes default shop sidebar.
- Moves breadcrumb into single-product summary.
- Brand / catalog query filters coordinated with `ShopCatalog`.
- Strips tabs/upsells where the custom PDP replaces them.

## CSS layout in `woocommerce.css`

1. **`@layer components`** — cards, shop grid, filters UI, notices, default `.woocommerce a.button`, compact **orders View** padding (must stay in-layer — see skill `css-cascade.md`).
2. **Unlayered section** (after the layer) — beats Woo core for breadcrumbs, product grids, account chrome, cart buttons, form controls.

### Known gotchas (this project)

| Symptom | Cause | Fix used |
| --- | --- | --- |
| Orders View padding ignored | Layered `.woocommerce a.button { padding: !important }` beats unlayered overrides | View sizing inside `@layer components` as `.button.view` |
| Nav dropdown hover looks like header | `hover:bg-dark-blue` on primary panel under dark-blue header | Primary + white mix hover |
| Dropdown radius “disappears” on hover | Item hover bg not clipped | `.nav-dropdown { overflow: hidden }` |
| Tax archive empty / no pages | `no_found_rows` on product tax queries | Keep found rows for catalog/tax queries |
| Account columns swapped | Empty notices wrapper in flex/grid | Explicit `> .woocommerce-MyAccount-navigation` / `content` columns |

## Account / cart / checkout notes

- My Account: segmented nav, bordered content panel, pill inputs, primary pill saves; orders **View** is compact (`5px` / `6px` / `14px`) and scoped to `.view` only.
- Cart/Checkout: unlayered button + table resets; prefer classic shortcodes if Blade overrides are required (WC 9 block pages otherwise).
- Site visibility: disable Woo **Coming soon** so guests see theme templates.

## Related

- Tokens / buttons: `docs/design-tokens.md`, `resources/css/theme/buttons.css`, `variables.css`
- Nav flyouts: `resources/css/theme/nav.css`
- Plugins rule: `.cursor/rules/kogler-plugins.mdc` (Woo section)
- Portable skill: `sage-woocommerce-skin`
