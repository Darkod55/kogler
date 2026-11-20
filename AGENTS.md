# Kogler — agent orientation

Local WP site. Almost all work happens in the Sage theme.

## Layout

| Path | Role |
| --- | --- |
| `app/public/` | WordPress root |
| `app/public/wp-content/themes/kogler/` | Theme (primary codebase) |
| `app/public/wp-content/plugins/` | Plugins (Local install; **not in git**) |
| `conf/`, `logs/` | Local WP config / logs (ignored) |

Theme-relative paths in docs (`app/blocks`, `resources/…`) mean **inside the theme**, not the repo `app/` folder.

## What’s tracked

Root `.gitignore` ignores most of WordPress and **whitelists** the theme plus a few mu-plugins (`wp-admin-bar, wp-login-screen, wp-last-edited`). Do not commit plugins, uploads, `vendor/`, `node_modules/`, `public/build/`, or block `_dist/` folders.

Blockstudio, Fluent Forms, Rank Math, WooCommerce, etc. exist only on the Local machine. Prefer their on-disk sources / LLM docs over inventing APIs.

## Stack

- **Theme:** Sage 11.2.1 (text domain `sage`), PHP ≥ 8.3, WP ≥ 6.6
- **PHP:** Acorn ^6, PSR-4 `App\` → theme `app/`
- **Frontend:** Vite 8, Tailwind CSS v4, Alpine 3, Node 20 (`.nvmrc`)
- **Blocks:** Blockstudio **7.6.6** (plugin), namespace `mpx/*`, scan root theme `app/blocks`

## Boot order

1. Theme `functions.php` — Composer autoload, Acorn + `ThemeServiceProvider`
2. `app/setup.php`, `app/filters.php`, `app/includes.php`
3. `includes.php` globs traits (`helpers` → `filters` → `blocks`) then `Classes/*`
4. `App\Classes\MpxBlocks` wires Blockstudio hooks from `app/Traits/blocks/trait-blocks.php`

FSE / block templates are intentionally off; layouts live in Blade (`resources/views/`).

## Dev commands (from theme directory)

```bash
cd app/public/wp-content/themes/kogler
composer install   # vendor/ (gitignored)
npm install
npm run dev        # Vite HMR — set APP_URL to the Local site URL if needed
npm run build
```

## Where to look before inventing

- Blockstudio decisions: `app/public/wp-content/themes/kogler/BLOCKSTUDIO-7.md`
- Blockstudio framework index (if plugin present): `app/public/wp-content/plugins/blockstudio/includes/llm/blockstudio-llm.txt`
- Cursor rules: `.cursor/rules/blockstudio.mdc`, `kogler-theme.mdc`, `kogler-design-system.mdc`, `kogler-plugins.mdc`
- WooCommerce (Sage): `generoi/sage-woocommerce` → Blade views in `resources/views/woocommerce/`, hooks in `app/wc-template-hooks.php`, skin in `resources/css/theme/woocommerce.css`; playbook `docs/woocommerce.md` (+ Cursor skill `sage-woocommerce-skin`)
- Block inventory: `app/public/wp-content/themes/kogler/docs/blocks.md`
- Rebrand playbook: `app/public/wp-content/themes/kogler/docs/design-tokens.md`
- Agent context bootstrap (this flow): `app/public/wp-content/themes/kogler/docs/agent-context.md`
- Runtime tokens / utilities: theme `resources/css/theme/*.css` (entry `resources/css/theme.css`; `variables.css` written from the rebrand playbook)
- Site bootstrap checklist: `docs/copy-theme.md`
