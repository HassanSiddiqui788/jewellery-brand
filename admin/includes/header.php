<?php
/**
 * Admin Layout Header Component
 * Loads typography, icons, and luxury admin styling from local project assets
 */
if (!defined('ADMIN_APP')) {
    require_once __DIR__ . '/config.php';
}
$page_title = $page_title ?? 'Dashboard';
$active_nav = $active_nav ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= e_admin($page_title) ?> – <?= e_admin(ADMIN_SITE_NAME) ?> Admin</title>

    <!-- Storefront Favicons -->
    <link rel="icon" href="../assets/images/favicons/cropped-favicon-32x32.png" sizes="32x32" />
    <link rel="icon" href="../assets/images/favicons/cropped-favicon-192x192.png" sizes="192x192" />

    <!-- Storefront Brand Typography -->
    <link rel="stylesheet" href="../assets/css/montserrat.css" media="all" />
    <link rel="stylesheet" href="../assets/css/sortsmillgoudy.css" media="all" />
    <link rel="stylesheet" href="../assets/css/jomolhari.css" media="all" />

    <!-- Local FontAwesome Icon Fonts -->
    <link rel="stylesheet" href="../assets/css/fontawesome.min.css" media="all" />
    <link rel="stylesheet" href="../assets/css/all.min.css" media="all" />

    <!-- Luxury Admin Panel Stylesheet -->
    <link rel="stylesheet" href="assets/css/admin.css" media="all" />
</head>
<body>
<div class="admin-shell">
<?php
require_once __DIR__ . '/sidebar.php';
?>
<div class="admin-main">
<?php
require_once __DIR__ . '/topbar.php';
?>
<main class="admin-content">

