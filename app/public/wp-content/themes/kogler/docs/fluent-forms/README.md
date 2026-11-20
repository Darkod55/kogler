# Become a Distributor — Fluent Forms

The live form ID is **3**. `resources/views/partials/become-a-distributor/application.blade.php` sets `$formId = 3` and prints `[fluentform id="3"]` when that shortcode is registered.

## Import

1. In wp-admin go to **Fluent Forms → Tools → Import** (or **Fluent Forms → Import Forms**).
2. Upload `become-a-distributor.json`.
3. The imported form should be ID 3. If WordPress assigns a different ID, change `$formId` in `application.blade.php` to match.

If the `[fluentform]` shortcode is not registered, the card stays empty except for an HTML comment. No shortcode text is printed.

The export matches Fluent Forms’ current transfer format (plugin source `Transfer.php` / `TransferService.php`, readme stable tag **6.2.17**): a JSON array of forms, `form_fields` as an object, and `metas` entries whose `value` is a JSON string.

## To do after import

- **Sales inbox.** The admin notification is in the export and is **disabled**, with no email address. Turn it on and set the address when sales confirms the inbox. Do not invent one.
- **State.** It is a text field. Change it to a US-states dropdown only if the client asks.
- **Auto-reply.** None is included. Add one only when the client supplies the copy.
- **Spam.** Other forms’ spam settings are not in this repo, so this export does not add reCAPTCHA or Akismet. It does not turn off Fluent’s global honeypot (on by default in Fluent Forms security settings). Leave that on unless the site already uses something else.

## Styling before the form exists

Rules live in `resources/css/theme/distributor-application.css` and apply only under `.distributor-application`. The partial already uses form ID 3. View the Become a Distributor page once Fluent Forms is active. The error colour is the section property `--da-error: #B42318` (6.57:1 on white). The theme has no danger token, and this value is not added to the global theme.
