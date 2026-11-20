# Update Fluent Form 1 (Contact)

Form 1 already exists. Edit it in **Fluent Forms → All Forms → form 1 → Editor**. Do not import a new form. Importing would create a duplicate and drop this form’s notifications, integrations, and SMS opt-in.

The page partial is `resources/views/partials/contact/info-form.blade.php` with `$formId = 1`. It prints `[fluentform id="1"]` when that shortcode is registered.

## Fields, in this order

Use two-column containers where noted. Leave every other field full width. Put one `*` in the label text of required fields, and turn off Fluent’s extra asterisk (**Settings → Layout → Asterisk** can stay, the theme hides it).

1. **Two columns**
   - **First Name\*** — Simple text, required. Name `first_name`. Autocomplete `given-name`.
   - **Last Name\*** — Simple text, required. Name `last_name`. Autocomplete `family-name`.
2. **Company** — Simple text, not required. Name `company`. Autocomplete `organization`.
3. **Two columns**
   - **Email\*** — Email, required. Name `email`. Autocomplete `email`.
   - **Phone** — Simple text, not required. Set the input type to **tel** (do not use Fluent’s Phone field; that adds a country picker). Name `phone`. Autocomplete `tel`.
4. **I am a…** — Radio, not required. Options, in order: Fleet, Distributor, Dealership, Retailer, Repair shop, Owner-Operator, Other.
5. **Brand of interest** — Checkbox, not required. Options, in order: Kogler, Goliath Steel, Kogler Outdoor.
6. **Message\*** — Textarea, required. About 5 rows. The theme sets the height.
7. **SMS opt-in** — Keep the existing checkbox or terms field and its disclosure text. Do not rewrite the disclosure. The only edit is to replace the company name inside that existing sentence with `[Company legal name]`. Leave the box optional and unchecked.
8. **Submit** — Button text `Submit`. Button style **No style**, so the theme CSS controls it.

## Confirmation

Leave the current confirmation as **Same page** with the form hidden. Do not change the message text and do not write a new one.

## CSS the theme expects

Styles are in `resources/css/theme/contact-section.css`, only under `.contact-section .fluentform`.

- Inputs use `.ff-el-form-control`. A textarea is `textarea.ff-el-form-control`.
- Two-column rows use `.ff-t-container.ff_columns_total_2`.
- Radio and checkbox groups that contain more than one `.ff-el-form-check` are the pills. The native input is visually hidden and stays focusable.
- The SMS box is a single checkbox or Fluent’s terms field. The selectors are `.ff-el-tc .ff-el-form-check-label` and `.ff-el-group:not(:has(.ff-el-form-check + .ff-el-form-check)) .ff-el-form-check-label`. Terms text is `.ff_t_c`.
- Errors use `.ff-el-is-error .ff-el-form-control` and `.error.text-danger`.
- The success message is `.ff-message-success` (Fluent adds `role="status"`).

## Do not change

- Admin notification recipients and other integrations already on form 1.
- The SMS opt-in, except the company-name placeholder above.
- The existing confirmation sentence.
