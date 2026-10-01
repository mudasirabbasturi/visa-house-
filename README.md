# VisaHouse WordPress Theme

This ZIP contains the VisaHouse classic WordPress theme reconstructed from the supplied build document.

## Included
- 38 theme files from the supplied document
- Homepage, archives, single post/service, page, search, 404, comments and sidebar templates
- ACF field definitions
- Polylang CPT/taxonomy integration
- Customizer settings
- CSS, JavaScript and placeholder SVG

## Installation
1. Upload `visahouse.zip` in WordPress under Appearance → Themes → Add New → Upload Theme.
2. Install/activate the required plugins: ACF (free or Pro), Polylang / Polylang Pro, your existing footer plugin, and the FamilyVisa calculator plugin.
3. In Polylang, add the required languages and enable translation for:
   - service
   - review
   - faq
   - service_category
   - faq_category
4. After activation, open the VisaHouse options screen and fill the homepage fields, including Hero, Trust, About, CTA and Steps.
5. In Appearance → Customize → VisaHouse — Global, set WhatsApp, Google rating, phone, email and address.
6. Create Services, Reviews, FAQs and Posts.
7. Set a static Home page under Settings → Reading.
8. Create/assign the Primary Menu under Appearance → Menus.
9. Save Settings → Permalinks once to flush CPT rewrite rules.

## Important note
The supplied source references `assets/css/rtl.css` from `inc/enqueue.php`, but the build document does not provide an `rtl.css` file. The ZIP therefore preserves the supplied source as-is and does not invent that missing stylesheet.

## Source fidelity
The theme files are reconstructed from the code blocks in the supplied DeepSeek build document. No application logic was silently rewritten.
