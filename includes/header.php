<?php
/**
 * Global Header Include
 * Bijoux Jewelry Store
 */
if (!defined('BIJOUX_APP')) {
    require_once __DIR__ . '/config.php';
}
$base_path = $base_path ?? './';
$page_title = $page_title ?? (SITE_NAME . ' – ' . SITE_TAGLINE);
$body_class = $body_class ?? '';
?>
<!DOCTYPE html>
<html lang="en-US" class="no-js">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= e($page_title) ?></title>
    <meta name="robots" content="max-image-preview:large" />

    <!-- Favicons -->
    <link rel="icon" href="<?= $base_path ?>assets/images/favicons/cropped-favicon-32x32.png" sizes="32x32" />
    <link rel="icon" href="<?= $base_path ?>assets/images/favicons/cropped-favicon-192x192.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="<?= $base_path ?>assets/images/favicons/cropped-favicon-180x180.png" />

    <!-- Typography & Fonts -->
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/montserrat.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/sortsmillgoudy.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/jomolhari.css" media="all" />

    <!-- Icon Fonts -->
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/fontawesome.min.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/all.min.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/brands.min.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/solid.min.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/v4-shims.min.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/elementor-icons.min.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/theme-icons.css" media="all" />

    <!-- WooCommerce Styles -->
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/woocommerce-layout.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/woocommerce-smallscreen.css" media="only screen and (max-width: 768px)" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/woocommerce.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/wc-gc.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/wc-small-screen.css" media="only screen and (max-width: 768px)" />

    <!-- Elementor Core Styles -->
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/elementor-frontend.min.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/post-4.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/theme-all.css" media="all" />

    <!-- Responsive Layouts -->
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/layout-max.css" media="(min-width: 1025px)" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/layout-max-low.css" media="(min-width: 1025px) and (max-width: 1260px)" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/layout-below-max.css" media="(max-width: 1024px)" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/layout-small.css" media="(max-width: 767px)" />

    <!-- Components: Header, Footer & Global Popups -->
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/post-13.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/post-998.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/popup.min.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/post-206.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/post-1122.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/post-7362.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/post-7405.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/post-7415.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/post-1628.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/post-1621.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/post-1635.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/post-1640.css" media="all" />

    <!-- Elementor Widget Styles & Animations -->
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/widget-nav-menu.min.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/widget-image.min.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/widget-heading.min.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/widget-tabs.min.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/widget-icon-list.min.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/widget-spacer.min.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/widget-social-icons.min.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/widget-woocommerce-products.min.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/widget-woocommerce-categories.min.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/widget-woocommerce-menu-cart.min.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/sticky.min.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/motion-fx.min.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/apple-webkit.min.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/fadeIn.min.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/fadeInDown.min.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/slideInUp.min.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/zoomIn.min.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/e-animation-shrink.min.css" media="all" />
    <link rel="stylesheet" href="<?= $base_path ?>assets/css/e-animation-float.min.css" media="all" />

    <!-- Page Specific Stylesheets -->
    <?php if (!empty($page_css)): ?>
    <?php foreach ((array)$page_css as $css_file): ?>
        <link rel="stylesheet" href="<?= $base_path ?>assets/css/<?= e($css_file) ?>" media="all" />
    <?php endforeach; ?>
    <?php endif; ?>

    <!-- Theme Variables & Options -->
    <style id="vamtam-theme-options">
        body {
            --vamtam-body-link-regular: #30373E;
            --vamtam-body-link-visited: #30373E;
            --vamtam-body-link-hover: #CB9274;
            --vamtam-body-link-active: #CB9274;
            --vamtam-body-background-color: #F6F4F2;
            --vamtam-btn-text-color: #051F34;
            --vamtam-btn-hover-text-color: #FFFFFF;
            --vamtam-btn-bg-color: #FFFFFF;
            --vamtam-btn-hover-bg-color: #051F34;
            --vamtam-btn-border-radius: 0px 0px 0px 0px;
            --vamtam-icon-theme-arrow-right: '\e900';
            --vamtam-icon-search: '\e901';
            --vamtam-icon-plus: '\e902';
            --vamtam-icon-minus: '\e903';
            --vamtam-icon-shopping-bag: '\e904';
            --vamtam-icon-side-menu: '\e905';
            --vamtam-icon-close: '\e906';
            --vamtam-loading-animation: url('<?= $base_path ?>assets/images/theme/loader-ring.gif');
        }
    </style>

    <!-- Core Head Scripts -->
    <script id="jquery-core-js" src="<?= $base_path ?>assets/js/jquery.min.js"></script>
    <script id="jquery-migrate-js" src="<?= $base_path ?>assets/js/jquery-migrate.min.js" defer></script>
    <script id="wc-jquery-blockui-js" src="<?= $base_path ?>assets/js/jquery.blockUI.min.js" defer></script>
    <script id="wc-add-to-cart-js-extra">
        var wc_add_to_cart_params = {
            "ajax_url": "<?= $base_path ?>shop/cart.php",
            "wc_ajax_url": "<?= $base_path ?>shop/cart.php?wc-ajax=%%endpoint%%",
            "i18n_view_cart": "View cart",
            "cart_url": "<?= $base_path ?>shop/cart.php",
            "is_cart": "",
            "cart_redirect_after_add": "no"
        };
    </script>
    <script id="wc-add-to-cart-js" src="<?= $base_path ?>assets/js/add-to-cart.min.js" defer></script>
    <script id="wc-js-cookie-js" src="<?= $base_path ?>assets/js/js.cookie.min.js" defer></script>
    <script id="woocommerce-js-extra">
        var woocommerce_params = {
            "ajax_url": "<?= $base_path ?>shop/cart.php",
            "wc_ajax_url": "<?= $base_path ?>shop/cart.php?wc-ajax=%%endpoint%%",
            "i18n_password_show": "Show password",
            "i18n_password_hide": "Hide password"
        };
    </script>
    <script id="woocommerce-js" src="<?= $base_path ?>assets/js/woocommerce.min.js" defer></script>
    <script id="font-awesome-4-shim-js" src="<?= $base_path ?>assets/js/v4-shims.min.js" defer></script>

    <?php if (!empty($extra_head)) echo $extra_head; ?>
</head>
<body class="<?= e($body_class) ?>">
    <div id="top"></div>
    <?php include __DIR__ . '/navbar.php'; ?>
    <div id="page" class="main-container">
        <div id="main-content">
