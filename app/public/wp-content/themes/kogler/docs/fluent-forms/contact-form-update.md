# Contact form import

The earlier plan to edit Fluent Form 1 in place is superseded. Import a new form. It should become ID 4. Do not edit form 1 for this page.

`$formId` in `resources/views/partials/contact/info-form.blade.php` is **4**.

## Checklist

1. In wp-admin go to **Fluent Forms → Tools → Import** and upload `docs/fluent-forms/contact.json`.
2. Open the new form and confirm its ID is **4**. If WordPress assigns another ID, change `$formId` in the partial to match.
3. Paste the SMS disclosure from form 1 into the checkbox option. The imported text is the placeholder `[Paste the existing SMS opt-in disclosure from form 1 here, with the company name replaced by: Company legal name]`. Replace that placeholder with the real disclosure, and replace the company name in it with the legal name when the client supplies one. Leave the box optional and unchecked. The field label is hidden (`hide_label`), so only that checkbox text shows. It is a single checkbox, which is what `.contact-section` styles as the SMS box.
4. Paste form 1’s confirmation message over `[Copy the confirmation message from form 1]`. Leave the behaviour as **Same page** with the form hidden. Do not write a new sentence.
5. Recreate form 1’s notifications and integrations on the new form. The admin notification in the file is disabled and has no address. There is no auto-reply. SMS and CRM integrations do not come across in a Fluent Forms import.
6. Do not add a new captcha. Leave Fluent’s global honeypot as the site already has it.

## What the file contains

Labels, in order: First Name*, Last Name* (two columns), Company, Email*, Phone (two columns), I am a…, Brand of interest, Message*, the SMS checkbox, Submit.

Phone is a text input with type `tel`, not Fluent’s Phone field. Autocomplete is `given-name`, `family-name`, `organization`, `email`, and `tel`. Required labels contain one `*`. The theme hides Fluent’s extra asterisk.

The confirmation message is wrapped in a `<p>` so the scoped Fraunces rule applies. The words inside that tag are only the placeholder.
