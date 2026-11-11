<?php
/**
 * Admin Page: Store & Admin Settings
 */
require_once __DIR__ . '/includes/config.php';

$page_title = 'Settings';
$page_subtitle = 'Store Identity & Atelier Preferences';
$active_nav = 'settings';

$settings = get_sample_settings();

require_once __DIR__ . '/includes/header.php';
?>

<div id="settingsAlertBox" class="admin-alert" style="display: none;"></div>

<form id="settingsForm" class="admin-form" novalidate>
    <div class="settings-grid">
        <!-- Store Identity -->
        <section class="admin-card">
            <div class="admin-card-header">
                <div>
                    <h2 class="admin-card-title">Boutique Details</h2>
                    <div class="admin-card-subtitle">Core storefront name and contact details</div>
                </div>
            </div>
            <div class="admin-card-body">
                <div class="form-group" style="margin-bottom: 18px;">
                    <label for="setStoreName" class="form-label">Store Name</label>
                    <input type="text" id="setStoreName" class="form-control" value="<?= e_admin($settings['store_name']) ?>" />
                </div>

                <div class="form-group" style="margin-bottom: 18px;">
                    <label for="setTagline" class="form-label">Store Tagline</label>
                    <input type="text" id="setTagline" class="form-control" value="<?= e_admin($settings['store_tagline']) ?>" />
                </div>

                <div class="form-group" style="margin-bottom: 18px;">
                    <label for="setEmail" class="form-label">Concierge Email</label>
                    <input type="email" id="setEmail" class="form-control" value="<?= e_admin($settings['store_email']) ?>" />
                </div>

                <div class="form-group">
                    <label for="setPhone" class="form-label">Support Phone</label>
                    <input type="text" id="setPhone" class="form-control" value="<?= e_admin($settings['store_phone']) ?>" />
                </div>
            </div>
        </section>

        <!-- Inventory, Shipping & Notifications -->
        <section class="admin-card">
            <div class="admin-card-header">
                <div>
                    <h2 class="admin-card-title">Orders &amp; Inventory Rules</h2>
                    <div class="admin-card-subtitle">Currency, shipping thresholds, and alerts</div>
                </div>
            </div>
            <div class="admin-card-body">
                <div class="form-grid" style="margin-bottom: 18px;">
                    <div class="form-group">
                        <label for="setCurrency" class="form-label">Currency</label>
                        <select id="setCurrency" class="form-control">
                            <option value="USD ($)" selected>USD ($)</option>
                            <option value="EUR (&euro;)">EUR (&euro;)</option>
                            <option value="GBP (&pound;)">GBP (&pound;)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="setThreshold" class="form-label">Low Stock Alert At</label>
                        <input type="number" id="setThreshold" class="form-control" min="1" value="<?= (int)$settings['low_stock_threshold'] ?>" />
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 18px;">
                    <label for="setShippingMin" class="form-label">Complimentary Shipping Minimum ($)</label>
                    <input type="number" id="setShippingMin" class="form-control" step="1" min="0" value="<?= (float)$settings['free_shipping_min'] ?>" />
                </div>

                <div class="toggle-row">
                    <div>
                        <strong style="display: block; font-size: 13px; color: var(--color-primary);">New Order Notifications</strong>
                        <span class="table-sub-text">Send summary alerts when a customer places a purchase</span>
                    </div>
                    <label class="switch">
                        <input type="checkbox" <?= $settings['order_notifications'] ? 'checked' : '' ?> />
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="toggle-row">
                    <div>
                        <strong style="display: block; font-size: 13px; color: var(--color-primary);">Low Stock Alerts</strong>
                        <span class="table-sub-text">Highlight items on Dashboard when quantity drops below threshold</span>
                    </div>
                    <label class="switch">
                        <input type="checkbox" <?= $settings['low_stock_alerts'] ? 'checked' : '' ?> />
                        <span class="slider"></span>
                    </label>
                </div>
            </div>
        </section>

        <!-- Admin Profile Security -->
        <section class="admin-card" style="grid-column: 1 / -1;">
            <div class="admin-card-header">
                <div>
                    <h2 class="admin-card-title">Administrator Account</h2>
                    <div class="admin-card-subtitle">Manage your studio login details</div>
                </div>
            </div>
            <div class="admin-card-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="setAdminName" class="form-label">Admin Name</label>
                        <input type="text" id="setAdminName" class="form-control" value="<?= e_admin($settings['admin_name']) ?>" />
                    </div>
                    <div class="form-group">
                        <label for="setAdminEmail" class="form-label">Admin Email</label>
                        <input type="email" id="setAdminEmail" class="form-control" value="<?= e_admin($settings['admin_email']) ?>" />
                    </div>
                    <div class="form-group">
                        <label for="setNewPass" class="form-label">New Password</label>
                        <input type="password" id="setNewPass" class="form-control" placeholder="Leave blank to keep current password" />
                    </div>
                    <div class="form-group">
                        <label for="setConfirmPass" class="form-label">Confirm New Password</label>
                        <input type="password" id="setConfirmPass" class="form-control" placeholder="Re-enter new password" />
                    </div>
                </div>

                <div class="form-footer-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check-circle" aria-hidden="true"></i> Save All Settings
                    </button>
                </div>
            </div>
        </section>
    </div>
</form>

<?php
require_once __DIR__ . '/includes/footer.php';
?>

