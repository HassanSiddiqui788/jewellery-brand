<?php
/**
 * Essential Frontend Scripts Include
 * Bijoux Jewelry Store
 */
$base_path = $base_path ?? './';
?>
<!-- Theme Configuration -->
<script id="vamtam-all-js-extra">
    var VAMTAM_FRONT = {
        "ajaxurl": "<?= $base_path ?>shop/cart.php",
        "jspath": "<?= $base_path ?>assets/js/",
        "max_breakpoint": "1025",
        "beaver_responsive": "1025",
        "beaver_small": "768",
        "content_width": "1260",
        "enable_ajax_add_to_cart": "yes"
    };
</script>
<script id="vamtam-all-js" src="<?= $base_path ?>assets/js/all.min.js" defer></script>
<script id="vamtam-all-js-after">
    VAMTAM_FRONT.theme_supports = (feature) => [
        "social-icons--custom-layout", "slides--force-slide-stretch", "slides--bijoux-slider-arrows",
        "slides--arrows-position-overlap", "slides--arrows-responsive-size", "slides--arrows-color-tabs",
        "slides--arrows-color-tabs__hover-anim", "tabs--empty-title-button",
        "tabs--bijoux-tabs-mega-menu-title-line-prefix", "nav-menu--bijoux-menu-toggle",
        "nav-menu--line-through-pointer", "nav-menu--prefix-pointer", "nav-menu--custom-dropdown-divider",
        "icon-box--box-is-link", "image-box--box-is-link", "wc-categories--bijoux-default-column-gap",
        "form--prefix-grow-hover-anims", "button--bijoux-button-type", "products-base--bijoux-products-layout",
        "products-base--product-image-anims", "form--bijoux-button-type", "product-add-to-cart--bijoux-button-type",
        "woocommerce-menu-cart--bijoux-button-type", "woocommerce-menu-cart--close-cart-theme-icon",
        "woocommerce-product-meta--meta-filter", "woocommerce-product-images--full-sized-gallery",
        "woocommerce-product-images--disable-image-link", "image--grow-with-scale-anims",
        "animated-headline--blurred-letters", "site-settings--theme-settings",
        "nav-menu--disable-scroll-on-mobile", "nav-menu--toggle-sticky-hover-state-on-touch-fix",
        "column--logical-spacings", "text-editor--selectors-include-links"
    ].includes(feature);
</script>

<!-- Libraries & Elementor Runtime -->
<script id="smartmenus-js" src="<?= $base_path ?>assets/js/jquery.smartmenus.min.js" defer></script>
<script id="elementor-webpack-runtime-js" src="<?= $base_path ?>assets/js/webpack.runtime.min.js" defer></script>
<script id="elementor-frontend-modules-js" src="<?= $base_path ?>assets/js/frontend-modules.min.js" defer></script>
<script id="jquery-ui-core-js-before">
    jQuery.uiBackCompat = true;
</script>
<script id="jquery-ui-core-js" src="<?= $base_path ?>assets/js/jquery-ui-core.min.js" defer></script>

<!-- Elementor Frontend Configuration -->
<script id="elementor-frontend-js-before">
    var elementorFrontendConfig = {
        "environmentMode": { "edit": false, "wpPreview": false, "isScriptDebug": false },
        "i18n": {
            "shareOnFacebook": "Share on Facebook", "shareOnX": "Share on X", "pinIt": "Pin it",
            "download": "Download", "downloadImage": "Download image", "fullscreen": "Fullscreen",
            "zoom": "Zoom", "share": "Share", "playVideo": "Play Video", "previous": "Previous",
            "next": "Next", "close": "Close", "a11yCarouselPrevSlideMessage": "Previous slide",
            "a11yCarouselNextSlideMessage": "Next slide", "a11yCarouselFirstSlideMessage": "This is the first slide",
            "a11yCarouselLastSlideMessage": "This is the last slide", "a11yCarouselPaginationBulletMessage": "Go to slide"
        },
        "is_rtl": false,
        "breakpoints": { "xs": 0, "sm": 480, "md": 768, "lg": 1025, "xl": 1440, "xxl": 1600 },
        "responsive": {
            "breakpoints": {
                "mobile": { "label": "Mobile Portrait", "value": 767, "default_value": 767, "direction": "max", "is_enabled": true },
                "mobile_extra": { "label": "Mobile Landscape", "value": 880, "default_value": 880, "direction": "max", "is_enabled": false },
                "tablet": { "label": "Tablet Portrait", "value": 1024, "default_value": 1024, "direction": "max", "is_enabled": true },
                "tablet_extra": { "label": "Tablet Landscape", "value": 1200, "default_value": 1200, "direction": "max", "is_enabled": false },
                "laptop": { "label": "Laptop", "value": 1366, "default_value": 1366, "direction": "max", "is_enabled": false },
                "widescreen": { "label": "Widescreen", "value": 2400, "default_value": 2400, "direction": "min", "is_enabled": false }
            },
            "hasCustomBreakpoints": false
        },
        "version": "4.3.4",
        "is_static": false,
        "experimentalFeatures": {
            "theme_builder_v2": true, "import-export-customization": true,
            "e_pro_atomic_form": true, "e_pro_collection_loop": true
        },
        "urls": { "assets": "<?= $base_path ?>assets\/", "ajaxurl": "<?= $base_path ?>shop/cart.php", "uploadUrl": "<?= $base_path ?>assets\/images" },
        "nonces": { "floatingButtonsClickTracking": "", "atomicFormsSendForm": "" },
        "swiperClass": "swiper",
        "settings": { "page": [], "editorPreferences": [] },
        "kit": {
            "body_background_background": "classic",
            "active_breakpoints": ["viewport_mobile", "viewport_tablet"],
            "global_image_lightbox": "yes",
            "lightbox_enable_counter": "yes",
            "lightbox_enable_fullscreen": "yes",
            "lightbox_enable_zoom": "yes",
            "lightbox_enable_share": "yes",
            "lightbox_title_src": "title",
            "lightbox_description_src": "description",
            "woocommerce_notices_elements": [],
            "vamtam_theme_has_theme_cursor": ""
        },
        "post": { "id": 11, "title": "Bijoux", "excerpt": "", "featuredImage": false }
    };
</script>
<script id="elementor-frontend-js" src="<?= $base_path ?>assets/js/elementor-frontend.min.js" defer></script>

<!-- Interactive Widgets -->
<script id="vamtam-nav-menu-js" src="<?= $base_path ?>assets/js/vamtam-nav-menu.min.js" defer></script>
<script id="vamtam-woocommerce-menu-cart-js" src="<?= $base_path ?>assets/js/vamtam-woocommerce-menu-cart.min.js" defer></script>
<script id="e-sticky-js" src="<?= $base_path ?>assets/js/jquery.sticky.min.js" defer></script>
<script id="vamtam-text-editor-js" src="<?= $base_path ?>assets/js/vamtam-text-editor.min.js" defer></script>
<script id="vamtam-tabs-js" src="<?= $base_path ?>assets/js/vamtam-tabs.min.js" defer></script>
<script id="vamtam-products-base-js" src="<?= $base_path ?>assets/js/vamtam-products-base.min.js" defer></script>
<script id="vamtam-image-js" src="<?= $base_path ?>assets/js/vamtam-image.min.js" defer></script>

<!-- WooCommerce & Utility Scripts -->
<script id="sourcebuster-js-js" src="<?= $base_path ?>assets/js/sourcebuster.min.js" defer></script>
<script id="wc-order-attribution-js-extra">
    var wc_order_attribution = {
        "params": { "lifetime": 1.0e-5, "session": 30, "base64": false, "ajaxurl": "<?= $base_path ?>shop/cart.php", "prefix": "wc_order_attribution_", "allowTracking": true },
        "fields": { "source_type": "current.typ", "referrer": "current_add.rf", "utm_campaign": "current.cmp", "utm_source": "current.src", "utm_medium": "current.mdm", "utm_content": "current.cnt", "utm_id": "current.id", "utm_term": "current.trm", "utm_source_platform": "current.plt", "utm_creative_format": "current.fmt", "utm_marketing_tactic": "current.tct", "session_entry": "current_add.ep", "session_start_time": "current_add.fd", "session_pages": "session.pgs", "session_count": "udata.vst", "user_agent": "udata.uag" }
    };
</script>
<script id="wc-order-attribution-js" src="<?= $base_path ?>assets/js/order-attribution.min.js" defer></script>
<script id="wc-cart-fragments-js-extra">
    var wc_cart_fragments_params = {
        "ajax_url": "<?= $base_path ?>shop/cart.php",
        "wc_ajax_url": "<?= $base_path ?>shop/cart.php?wc-ajax=%%endpoint%%",
        "cart_hash_key": "wc_cart_hash_cc6231673bc71815bb610de4d7c83b79",
        "fragment_name": "wc_fragments_cc6231673bc71815bb610de4d7c83b79",
        "request_timeout": "5000"
    };
</script>
<script id="wc-cart-fragments-js" src="<?= $base_path ?>assets/js/cart-fragments.min.js" defer></script>
<script id="wp-hooks-js" src="<?= $base_path ?>assets/js/hooks.min.js"></script>
<script id="wp-i18n-js" src="<?= $base_path ?>assets/js/i18n.min.js"></script>
<script id="wp-i18n-js-after">
    if (window.wp && wp.i18n) {
        wp.i18n.setLocaleData({ 'text direction\u0004ltr': ['ltr'] });
    }
</script>

<!-- Elementor Pro Handlers -->
<script id="elementor-pro-frontend-js-before">
    var ElementorProFrontendConfig = {
        "ajaxurl": "<?= $base_path ?>shop/cart.php",
        "nonce": "",
        "urls": { "assets": "<?= $base_path ?>assets\/" },
        "settings": { "lazy_load_background_images": true },
        "popup": { "hasPopUps": true },
        "shareButtonsNetworks": {
            "facebook": { "title": "Facebook", "has_counter": true },
            "twitter": { "title": "Twitter" },
            "linkedin": { "title": "LinkedIn", "has_counter": true },
            "pinterest": { "title": "Pinterest", "has_counter": true },
            "whatsapp": { "title": "WhatsApp" },
            "email": { "title": "Email" }
        },
        "woocommerce": {
            "menu_cart": {
                "cart_page_url": "<?= $base_path ?>shop/cart.php",
                "checkout_page_url": "<?= $base_path ?>shop/checkout.php",
                "fragments_nonce": ""
            }
        }
    };
</script>
<script id="elementor-pro-frontend-js" src="<?= $base_path ?>assets/js/elementor-pro-frontend.min.js" defer></script>
<script id="pro-elements-handlers-js" src="<?= $base_path ?>assets/js/elements-handlers.min.js" defer></script>
<script id="vamtam-elementor-frontend-js" src="<?= $base_path ?>assets/js/vamtam-elementor-frontend.min.js" defer></script>
<script id="vamtam-theme-elementor-js" src="<?= $base_path ?>assets/js/theme-elementor.min.js" defer></script>

<!-- LazyLoad Engine -->
<script>
window.lazyLoadOptions = [{
    elements_selector: "img[data-lazy-src],.rocket-lazyload,iframe[data-lazy-src]",
    data_src: "lazy-src",
    data_srcset: "lazy-srcset",
    data_sizes: "lazy-sizes",
    class_loading: "lazyloading",
    class_loaded: "lazyloaded",
    threshold: 300
}];
</script>
<script src="<?= $base_path ?>assets/js/lazyload.min.js" async></script>

<!-- Universal Navigation, Hamburger Menu & Side Cart Engine -->
<script src="<?= $base_path ?>assets/js/nav-toggle.js" defer></script>

<!-- Page Specific Scripts -->
<?php if (!empty($page_scripts)): ?>
<?php foreach ((array)$page_scripts as $script_file): ?>
<script src="<?= $base_path ?>assets/js/<?= e($script_file) ?>"></script>
<?php endforeach; ?>
<?php endif; ?>
