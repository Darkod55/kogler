# Design tokens — rebrand playbook

## Order on a new site

1. **First** `docs/agent-context.md` — identity, `AGENTS.md`, Cursor rules, path retargets  
2. **This file** (`docs/design-tokens.md`) — brand tokens, type, buttons  

On an existing site that already has agent context, you can run this playbook alone for rebrand-only work.

---

**Human input:** edit the **Active** blocks in this file only.  
**Runtime CSS:** `resources/css/theme/variables.css` (and related files) — written by the agent.

### Agent prompt (copy/paste)

```text
Read docs/design-tokens.md in this theme. For every Active value that is not (pending), write it into the mapped targets (variables.css, typography.css, button sync files). Run palette / type / button sync checklists, then npm run build from the theme directory. Do not invent tokens or button variants that are not listed. Do not reverse-engineer existing clamp() values. (pending) = leave that target unchanged.
```

Paths below are theme-relative (`app/public/wp-content/themes/kogler/…`).

---

## Source of truth

| Role | Where |
| --- | --- |
| **You edit** | This file — Active brand tokens, type scale, button recipes |
| **Agent writes** | `variables.css`, `typography.css`, `buttons.css`, `editor.css`, `button.json`, `trait-blocks.php` (+ optional nav) |
| Fonts (files / `@font-face`) | `resources/css/theme/fonts.css` (swap files separately if needed) |

Never invent one-off hex / magic widths / radii / type sizes in components. Use `var(--…)` / theme utilities after apply.

---

## Active brand tokens

Edit values here. Agent maps each key → `variables.css` `@theme static`.  
`(pending)` = skip that key. Remove a colour key only when intentionally dropping it (then run palette sync).

```text
# Colours → --color-{name}
primary: #1570a4
secondary: #b4d3e6
tertiary: #d0bd9c
teal: #a3bcc6
gray: #f9f9fb
light: #faf6f0
dark-blue: #0a1737
darker-blue: #060e24
light-blue: #d4eef8
ink: #0a1737
dark-gray: #7e7e7e
white: #fff
black: #000
goliath-950: #141619
goliath-900: #1c1f22
goliath-800: #26292d
goliath-700: #3a3f44
goliath-silver: #aeb5bb
goliath-chrome: #d6dbdf
goliath-green: #41ad4a
goliath-green-ink: #10140f
goliath-orange: #f07a20
goliath-orange-light: #f5a15a
outdoor-950: #24392d
outdoor-900: #2f4a3a
outdoor-700: #3d5c49
outdoor-600: #4a6b57
outdoor-water: #45647a
outdoor-amber: #f2c88f
outdoor-amber-ink: #8a5a1e
outdoor-ink: #1f3328
outdoor-tint: #cfdcd3

# Kögler Sleep page only ([data-brand="kogler-sleep"] in variables.css).
# Reassigns dark-blue to primary and darker-blue to #0f5a85.
# Does not change the tokens above. --site-ink stays --color-ink.

# Section spacing → --spacing-clamp-*
spacing-clamp-inline: 24px
spacing-clamp-block: 65px

# Layout → --width-* / --radius-* / --padding-*
width-container: 1300px
width-content: 1000px
radius-surface: 12px
padding-surface: 20px
padding-surface-lg: 30px
padding-btn-y: 14px
padding-btn-x: 14px
padding-btn-sm-y: 10px
padding-btn-sm-x: 10px

# Fixed type tokens → --font-size-* (for fluid headings / fluid body see § Type scale)
font-size-xs: 12px
font-size-sm: 16px
font-size-base: 17px
font-size-lead: 20px
font-size-tagline: 18px
font-size-btn: 15px
```

### Brand token → CSS variable

| Recipe key | Writes |
| --- | --- |
| `primary` … `black` (and any new colour name) | `--color-{name}` |
| `spacing-clamp-inline` / `block` / `block-xl` | `--spacing-clamp-*` |
| `width-container` / `width-content` | `--width-*` |
| `radius-surface` | `--radius-surface` |
| `padding-surface` / `padding-surface-lg` | `--padding-surface*` |
| `padding-btn-y` / `x` / `sm-y` / `sm-x` | `--padding-btn-*` |
| `font-size-xs` / `sm` / `base` / `lead` / `tagline` / `btn` | `--font-size-*` |

### What each token is for

| Token | Used for |
| --- | --- |
| `--color-*` | Editor palette + `text-*` / `bg-*` |
| `--spacing-clamp-*` | `px-clamp`, `py-clamp`, `py-clamp-xl`, … |
| `--width-container` | `.container` + editor mirrors |
| `--width-content` | `.mw-1000` |
| `--radius-surface` | Shared radius (`rounded-surface`) |
| `--padding-surface*` | Cards, FAQ, column cells, bleed |
| `--padding-btn-*` | `.btn` / `.btn-sm` |
| `--font-size-xs\|sm\|base\|lead` | `.fs-*` (+ body/`p` via base) |
| `--font-size-tagline` | `.fs-tagline` (18px, uppercase, dark-gray) |
| `--font-size-btn` | Button labels |

### Palette sync (add / rename / remove a colour)

When colour **names** change (not only hex):

1. Update Active brand tokens above  
2. Agent writes `--color-{name}` in `variables.css`  
3. `theme.css` — add/remove `text-{name}` and `bg-{name}` in `@source inline`  
4. Update any button recipes that reference the old name  
5. `npm run build`

Hex-only changes: step 1 → agent writes `variables.css` → build.

---

## Type scale

Use for **headings** (usually fluid) and optional **fluid overrides** of body/fs/btn.  
Fixed body/fs/btn sizes normally live in § Active brand tokens; fill a key here only when you want `min / max` fluid type or to override a heading.

### Convention

```text
Minimum Viewport Width: {vmin}px
Maximum Viewport Width: {vmax}px
H1: {minFont}px / {maxFont}px
body: 17px
```

| Recipe value | Meaning | Agent output |
| --- | --- | --- |
| `16px` (no slash) | Fixed | Set target to `16px` — **no** `clamp()` |
| `16px / 18px` | Fluid | Calculate `clamp()` (formula below) |
| `--font-size-lead` | Alias | `font-size: var(--font-size-lead)` |
| `(pending)` / omitted | Skip | Do not change that target |

- Before `/` = size at `vmin`; after `/` = size at `vmax`.
- Root **16px**. Prefer `Maximum Viewport Width` = `width-container`.
- Viewport lines required only if any filled recipe uses `min / max`.
- Optional: `H1 line-height (lg+): 64px` → `typography.css` lg media query.

| Recipe key | Also accept | Writes to |
| --- | --- | --- |
| `H1` … `H6` | `h1` … `h6` | `typography.css` → `hN, .hN` |
| `body` | `p`, `base`, `fs-base` | `--font-size-base` (+ `body`/`p` use the token) |
| `fs-xs` / `fs-sm` / `fs-lead` / `fs-tagline` | `fs-small`, `lead`, `tagline` | matching `--font-size-*` (+ tagline styles) |
| `btn` | `button` | `--font-size-btn` |

### Clamp formula (`min / max` only)

```text
slope      = (maxPx - minPx) / (vmax - vmin)
intercept  = minPx - slope * vmin
preferred  = (intercept / root)rem + (slope * 100)vw
result     = clamp( (minPx/root)rem , preferred , (maxPx/root)rem )
```

Round rem/vw to **4 decimal places**. Do not hand-tune the middle term.

Example: `vmin=767`, `vmax=1330`, `H1: 50px / 75px` →  
`clamp(3.125rem, 0.9963rem + 4.4405vw, 4.6875rem)`.

### Active recipes

```text
Minimum Viewport Width: 1100
Maximum Viewport Width: 1300
H1: 50px / 96px
H2: 36px / 48px
H3: 26px / 32px
H4: 20px / 24px
H5: 18px / 22px
H6: 16px / 20px
body: 16px
fs-sm: 12px
fs-lead: 18px
fs-tagline: 18px
btn: 15px
```

### Type sync (filled keys only)

1. This file — Active recipes  
2. Headings → `typography.css`  
3. body/fs/btn → `variables.css` (overrides brand-token values for those keys)  
4. `npm run build`

---

## Button recipes

Colour states only. Padding / radius / label size come from brand tokens.

### Convention

```text
{class}: {default utilities} / {hover utilities}
```

- Before `/` = default; after `/` = hover.  
- Utilities: `bg-{token}`, `text-{token}`, optional `border-{token}`, `bg-transparent`.  
- Default border matches `bg-*` unless `border-*` is set.

Example: `btn-primary: bg-primary text-white / bg-secondary text-white`

### Active recipes

```text
btn-primary: bg-primary text-white / bg-secondary text-white
btn-secondary: bg-secondary text-black / bg-primary text-white
btn-tertiary: bg-tertiary text-black / bg-primary text-white
btn-white: bg-white text-primary / bg-transparent text-white border-white
btn-link-white: bg-transparent text-white / bg-transparent text-secondary
btn-link-dark: bg-transparent text-black / bg-transparent text-secondary
```

Legacy aliases: `btn-primary-alt` → `btn-primary`; `btn-outline-primary` → `btn-white`.

### Button sync (when Active recipes change)

| # | File | What |
| --- | --- | --- |
| 1 | `resources/css/theme/buttons.css` | `.btn-{name}` default + hover |
| 2 | `resources/css/editor.css` | Editor `.wp-block-button.btn-{name}` mirrors |
| 3 | `app/blocks/extensions/button.json` | `button_type` options |
| 4 | `app/Traits/blocks/trait-blocks.php` | `populateButtonTypes()` + type allow-list in `moveCoreButtonClassesToLink()` |
| 5 | `app/Traits/filters/trait-navs.php` | Optional `menu-btn-{name}` map |
| 6 | This file | Keep Active recipes in sync |

**Required for custom blocks:** step 4. Default type remains `btn-primary`.

Modifiers (not colour recipes): `btn-sm`, `btn-full`, `btn-has-icon`.

---

## Apply order (agent)

1. Write filled § Active brand tokens → `variables.css`  
2. Palette name changes → `theme.css` `@source inline`  
3. Filled § Type scale → `typography.css` / type tokens  
4. § Button recipes → button CSS + PHP/JSON sync  
5. `npm run build` from theme directory  

```bash
cd app/public/wp-content/themes/kogler
npm run build
```

Spot-check: colours in editor palette, `.container` width, buttons (FE + editor + custom block select), type at fixed sizes and at vmin/vmax if fluid recipes were applied.
