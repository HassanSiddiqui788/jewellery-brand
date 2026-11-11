<?php
/**
 * Admin Topbar Component
 */
$page_title = $page_title ?? 'Dashboard';
$page_subtitle = $page_subtitle ?? 'Atelier Overview';
?>
<header class="admin-topbar">
    <div class="topbar-left">
        <button type="button" id="mobileSidebarToggle" class="mobile-menu-btn" aria-label="Open Navigation Menu">
            <i class="fas fa-bars" aria-hidden="true"></i>
        </button>
        <div class="topbar-heading">
            <h1><?= e_admin($page_title) ?></h1>
            <div class="topbar-subtitle"><?= e_admin($page_subtitle) ?></div>
        </div>
    </div>

    <div class="topbar-right">
        <a href="products.php?action=add" class="btn btn-primary btn-sm topbar-hide-sm">
            <i class="fas fa-plus" aria-hidden="true"></i> Add Product
        </a>

        <a href="messages.php" class="topbar-icon-btn" title="Contact Inquiries" aria-label="Contact Inquiries">
            <i class="fas fa-bell" aria-hidden="true"></i>
            <span class="topbar-dot" title="Unread inquiries"></span>
        </a>

        <a href="settings.php" class="admin-profile-pill" title="Account & Settings">
            <span class="admin-avatar">SD</span>
            <span class="admin-profile-info">
                <span class="admin-profile-name">Studio Director</span>
                <span class="admin-profile-role">Administrator</span>
            </span>
        </a>
    </div>
</header>

