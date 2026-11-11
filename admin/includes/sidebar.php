<?php
/**
 * Admin Sidebar Component
 */
$nav_items = get_admin_nav_items();
$active_nav = $active_nav ?? 'dashboard';
?>
<div id="sidebarBackdrop" class="sidebar-backdrop" aria-hidden="true"></div>

<aside id="adminSidebar" class="admin-sidebar" aria-label="Admin Navigation">
    <div class="sidebar-brand">
        <a href="index.php" class="sidebar-brand-link" title="Return to Dashboard">
            <img src="../assets/icons/logo.svg" alt="<?= e_admin(ADMIN_SITE_NAME) ?>" class="sidebar-logo-img" />
            <span class="sidebar-brand-tag"><?= e_admin(ADMIN_BRAND_SUBTITLE) ?></span>
        </a>
        <button type="button" id="sidebarCloseBtn" class="sidebar-close-btn" aria-label="Close Sidebar">
            <i class="fas fa-times" aria-hidden="true"></i>
        </button>
    </div>

    <nav class="sidebar-nav">
        <ul class="sidebar-nav-list">
            <?php foreach ($nav_items as $item): ?>
                <?php if (!empty($item['divider_before'])): ?>
                    <li class="sidebar-divider" role="separator"></li>
                <?php endif; ?>
                <li>
                    <a href="<?= e_admin($item['href']) ?>"
                       class="sidebar-link <?= ($active_nav === $item['id']) ? 'active' : '' ?>">
                        <i class="<?= e_admin($item['icon']) ?>" aria-hidden="true"></i>
                        <span><?= e_admin($item['label']) ?></span>
                        <?php if (!empty($item['badge'])): ?>
                            <span class="sidebar-badge <?= !empty($item['badge_type']) ? e_admin($item['badge_type']) : '' ?>">
                                <?= e_admin($item['badge']) ?>
                            </span>
                        <?php endif; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <div class="sidebar-footer">
        <a href="../index.php" target="_blank" rel="noopener" class="sidebar-store-link">
            <span><i class="fas fa-store" style="margin-right:8px; color: var(--color-accent);"></i>View Storefront</span>
            <i class="fas fa-external-link-alt" style="font-size: 11px;"></i>
        </a>
    </div>
</aside>

