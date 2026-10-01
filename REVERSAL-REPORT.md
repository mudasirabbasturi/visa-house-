# Services Modal Reversal Report

## 1. Deleted files

- `inc/class-vs-walker-services-modal.php` — removed the menu-driven services modal walker.
- `inc/menu-icon-field.php` — removed the menu icon field support used by the new modal.
- `inc/services-menu-modal.php` — removed the menu-driven services modal renderer and its `wp_footer` output hook.
- `assets/css/modal-bento.css` — removed the new modal's Bento/vh styling.
- `assets/js/modal-bento.js` — removed the new modal's JavaScript.

## 2. Edited files

- `functions.php` — removed the three new-modal includes and removed the `services_modal` menu location; retained the four old-modal includes.
- `inc/enqueue.php` — removed the new modal's CSS/JS enqueues and restored the old `modal-services.css` / `modal-services.js` enqueues.
- `inc/modal-cpt.php` — retained the `vs_modal_item` CPT and `vs_modal_group` taxonomy, confirmed `show_in_menu => 'vs-options'`, and added the requested Polylang registrations for both.
- `REVERSAL-REPORT.md` — added this report.

## 3. Reconstructed files

None.

`footer.php`, `template-parts/modal-services.php`, `inc/services-modal.php`, `assets/css/modal-services.css`, and `assets/js/modal-services.js` were already present and consistent with the old CPT-driven modal, so they were not rewritten.

## 4. Judgment calls / uncertainties

- The requested Polylang registrations were missing from `inc/modal-cpt.php`, so they were added there as explicitly authorized by the user.
- `assets/css/main.css` contained no `.vh-modal`, `.vh-panel`, `.vh-head`, `.vh-scroll`, `.bento`, or `.btile` rules, so no edit was necessary there.
- `assets/js/main.js` contained no references to the new services-menu modal and its existing WhatsApp/calculator modal functions were retained unchanged.
- `footer.php` already contained the requested old services modal template call and did not contain a separate new-modal hook.
- `inc/services-modal.php` already enqueues the old modal assets; `inc/enqueue.php` was also restored to enqueue them as requested. This existing duplication was left intact rather than introducing unrelated changes.

## 5. New-modal reference confirmation

The final theme was checked for the requested removal strings, including:

- `services-menu-modal`
- `modal-bento`
- `vsServicesMenuModal`
- `#vs-services-menu-modal`
- `vsOpenServicesMenuModal`
- `vsCloseServicesMenuModal`
- `class-vs-walker-services-modal`
- `menu-icon-field`
- `services_modal`
- `vh-modal`
- `vh-panel`
- `vh-scroll`
- `.bento`
- `.btile`

They return zero matches in the final theme.

The old modal markers were also checked and remain present, including `vs_modal_item`, `vs_modal_group`, `modal-services`, `vsServicesModal`, `#vs-services-modal`, `vsOpenServicesModal`, `vsCloseServicesModal`, `.vs-sm-overlay`, and `.vs-sm-panel`.
