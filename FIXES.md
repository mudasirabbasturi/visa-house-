# VisaHouse Theme — Bug-Fix Report
> Generated: 2026-09-30 | Author: Antigravity debug pass

---

## Files Edited

### 1. `inc/enqueue.php`
**What was broken:**
`vs-main` (main.js) was registered **first** with an empty dependency array `array()`.
`vs-modal-services` (modal-services.js) was registered **second** with no dependency either.
Because WordPress outputs footer scripts in registration order, `main.js` loaded **before**
`modal-services.js`. Any code that calls `window.vsOpenServicesModal()` before
`modal-services.js` has executed would get `undefined is not a function`.
Additionally, the modal's auto-trigger click handler (bound inside the IIFE of
`modal-services.js`) wasn't yet attached when `main.js` ran.

**What was changed:**
- Swapped the registration order so `vs-modal-services` is declared **first**.
- Added `vs-modal-services` to the dependency array of `vs-main`:
  ```php
  // BEFORE
  wp_enqueue_script( 'vs-main', ..., array(), VS_VERSION, true );
  wp_enqueue_script( 'vs-modal-services', ..., array(), VS_VERSION, true );

  // AFTER
  wp_enqueue_script( 'vs-modal-services', ..., array(), VS_VERSION, true );
  wp_enqueue_script( 'vs-main', ..., array( 'vs-modal-services' ), VS_VERSION, true );
  ```
WordPress now guarantees `modal-services.js` is output first in every page response.

---

### 2. `assets/js/main.js`
**What was broken:**
The mobile drawer had **no JavaScript whatsoever**.
- `window.vsOpenMobileDrawer` did not exist.
- `window.vsCloseMobileDrawer` did not exist.
- No click handler was ever bound to `#vsMobileToggle` (the hamburger button).
- No click handler was ever bound to `#vsMobileDrawerClose` (the x inside the drawer).

As a result, clicking the hamburger did nothing. The inline `onclick` attributes in
`header.php` footer buttons (`vsCloseMobileDrawer()`) would also throw console errors.

**What was changed:**
Added the following inside the existing IIFE in `main.js`:
```js
/* Mobile Drawer */
var drawer      = $('vsMobileDrawer');
var toggle      = $('vsMobileToggle');
var drawerClose = $('vsMobileDrawerClose');

window.vsOpenMobileDrawer = function () {
    if (!drawer) return;
    drawer.classList.add('vs-open');
    drawer.setAttribute('aria-hidden', 'false');
    if (toggle) toggle.setAttribute('aria-expanded', 'true');
    document.body.classList.add('vs-drawer-open');
};

window.vsCloseMobileDrawer = function () {
    if (!drawer) return;
    drawer.classList.remove('vs-open');
    drawer.setAttribute('aria-hidden', 'true');
    if (toggle) toggle.setAttribute('aria-expanded', 'false');
    document.body.classList.remove('vs-drawer-open');
};

if (toggle)      toggle.addEventListener('click', window.vsOpenMobileDrawer);
if (drawerClose) drawerClose.addEventListener('click', window.vsCloseMobileDrawer);

// Close on overlay click
if (drawer) {
    drawer.addEventListener('click', function (e) {
        if (e.target === drawer) window.vsCloseMobileDrawer();
    });
}
```
The `.vs-open` class is already defined in `assets/css/main.css`
(`.vs-mobile-drawer.vs-open`) and handles the visual show/hide via CSS transitions.

---

## Files Verified (No Changes Needed)

| File | Status | Notes |
|------|--------|-------|
| `functions.php` | OK | All require_once calls present and correct |
| `assets/js/modal-services.js` | OK | vsOpenServicesModal, vsCloseServicesModal, and the a[href="#vs-services-modal"] click handler are all correctly defined |
| `template-parts/modal-services.php` | OK | Root element is `<div id="vsServicesModal" class="vh-modal" hidden>` — correct ID + class |
| `inc/modal-helpers.php` | OK | Reads icon with get_post_meta($post->ID, 'vs_item_icon', true) |
| `inc/modal-cpt.php` | OK | Saves icon with update_post_meta($post_id, 'vs_item_icon', ...) — keys match |
| `assets/css/modal-services.css` | OK | .vh-modal, .vh-modal[hidden], .vh-modal.is-open all correctly defined |
| `header.php` | OK | id="vsMobileToggle" and id="vsMobileDrawerClose" both present |
| `footer.php` | OK | Modal template-parts included BEFORE wp_footer() |

---

## Root Causes Summary

| Bug | Root Cause | Fix |
|-----|-----------|-----|
| Menu trigger #vs-services-modal does not open modal | vs-main loaded before vs-modal-services due to wrong registration order and missing dependency | Swapped order + added dependency in enqueue.php |
| Mobile drawer hamburger does not work | vsOpenMobileDrawer / vsCloseMobileDrawer were never defined; no click handlers bound | Added both functions + event listeners in main.js |
| Admin icon field not reflecting on frontend | No code bug found — meta key chain vs_item_icon is consistent across save/read/output | Re-save Modal Items in wp-admin; verify FA CDN loads |

---

## Items Requiring Manual Verification

1. **FontAwesome icon display** — The PHP meta-key chain is correct in code.
   If icons still show as `fa-star` default after the script-order fix:
   - Open a `vs_modal_item` post in wp-admin, confirm the Icon field contains a
     valid FA class (e.g. `fa-people-roof`), and click **Update**.
   - Clear any server-side object-cache (Redis/Memcached/WP Super Cache).
   - Confirm the FA CDN CSS loads without a 404 (check Network tab in DevTools).

2. **Drawer body-scroll lock** — `vs-drawer-open` is added to `<body>` when the
   drawer opens. Verify `assets/css/main.css` has a rule like
   `body.vs-drawer-open { overflow: hidden; }`. If not, add it.

3. **Escape key closes drawer** — Not implemented (was not in the original scope).
   If needed, add inside `main.js`:
   ```js
   document.addEventListener('keydown', function (e) {
       if ((e.key === 'Escape' || e.keyCode === 27) && drawer &&
           drawer.classList.contains('vs-open')) {
           window.vsCloseMobileDrawer();
       }
   });
   ```
