# Bootstrap a new site from this starter

Preferred flow: copy the Sage theme folder into a new Local WP site, open the **site root** in Cursor, fill Active identity in:

`app/public/wp-content/themes/kogler/docs/agent-context.md`

…then run that file’s **Agent prompt**. The agent creates `AGENTS.md`, `.cursor/rules/*`, and this checklist’s next-site copy.

## Manual prerequisites

- [ ] Local WP site with `app/public/` layout; workspace = site root
- [ ] Theme at `app/public/wp-content/themes/kogler/` (folder slug `kogler`)
- [ ] Plugins installed on the machine (Blockstudio; Fluent Forms / Rank Math if used)
- [ ] Active identity filled in `docs/agent-context.md` → agent prompt applied
- [ ] Active brand filled in `docs/design-tokens.md` → that playbook’s agent prompt applied
- [ ] In the theme: `composer install`, `npm install`, `npm run build`

## Do not commit

Theme `node_modules/`, `vendor/`, `public/build/`, block `_dist/`, uploads, plugins, `conf/`, `logs/`.

## Day-to-day agent orientation

1. Root `AGENTS.md`
2. `.cursor/rules/*`
3. Theme `BLOCKSTUDIO-7.md` + `docs/blocks.md` + `docs/design-tokens.md`
4. On-disk plugin LLM docs
