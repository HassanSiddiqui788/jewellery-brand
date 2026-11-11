<?php
/**
 * Admin Page: Inventory Management
 */
require_once __DIR__ . '/includes/config.php';

$page_title = 'Inventory';
$page_subtitle = 'Stock Levels & Replenishment';
$active_nav = 'inventory';

$products = get_sample_products();

$total_skus = count($products);
$low_count = count(array_filter($products, fn($p) => $p['stock'] > 0 && $p['stock'] <= 5));
$out_count = count(array_filter($products, fn($p) => $p['stock'] <= 0));
$healthy_count = $total_skus - $low_count - $out_count;

require_once __DIR__ . '/includes/header.php';
?>

<!-- Stock Summary Strip -->
<section class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-top">
            <span class="kpi-label">Total SKUs</span>
            <span class="kpi-icon"><i class="fas fa-boxes"></i></span>
        </div>
        <div class="kpi-value"><?= $total_skus ?></div>
    </div>
    <div class="kpi-card">
        <div class="kpi-top">
            <span class="kpi-label">Healthy Stock</span>
            <span class="kpi-icon"><i class="fas fa-check-circle" style="color: var(--status-success);"></i></span>
        </div>
        <div class="kpi-value"><?= $healthy_count ?></div>
    </div>
    <div class="kpi-card">
        <div class="kpi-top">
            <span class="kpi-label">Low Stock (&le;5)</span>
            <span class="kpi-icon"><i class="fas fa-exclamation-triangle" style="color: var(--status-warning);"></i></span>
        </div>
        <div class="kpi-value"><?= $low_count ?></div>
    </div>
    <div class="kpi-card">
        <div class="kpi-top">
            <span class="kpi-label">Out of Stock</span>
            <span class="kpi-icon"><i class="fas fa-times" style="color: var(--status-danger);"></i></span>
        </div>
        <div class="kpi-value"><?= $out_count ?></div>
    </div>
</section>

<!-- Filters -->
<div class="page-action-bar">
    <div id="inventoryFilters" class="filter-pills">
        <button type="button" class="filter-pill active" data-filter="all">All Pieces</button>
        <button type="button" class="filter-pill" data-filter="low">Low Stock</button>
        <button type="button" class="filter-pill" data-filter="out">Out of Stock</button>
    </div>

    <div class="search-input-wrap" style="max-width: 280px;">
        <i class="fas fa-search" aria-hidden="true"></i>
        <input type="text" id="inventorySearch" class="search-input" placeholder="Filter pieces by name..." />
    </div>
</div>

<!-- Inventory Table -->
<section class="admin-card">
    <div class="admin-card-header">
        <div>
            <h2 class="admin-card-title">Stock Control</h2>
            <div class="admin-card-subtitle">Use the +/- buttons to quickly adjust available quantities</div>
        </div>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Piece</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Quantity Available</th>
                    <th>Quick Update</th>
                </tr>
            </thead>
            <tbody id="inventoryTableBody">
                <?php foreach ($products as $prod):
                    $qty = (int)$prod['stock'];
                    $cls = ($qty <= 0) ? 'badge-danger' : (($qty <= 5) ? 'badge-warning' : 'badge-success');
                    $lbl = ($qty <= 0) ? 'Out of Stock' : (($qty <= 5) ? 'Low Stock' : 'Healthy');
                ?>
                    <tr data-name="<?= e_admin($prod['name']) ?>" data-stock="<?= $qty ?>">
                        <td>
                            <div class="table-product-cell">
                                <img src="<?= e_admin(admin_asset_img($prod['images'][0] ?? '')) ?>" alt="<?= e_admin($prod['name']) ?>" class="table-thumb" />
                                <div>
                                    <span class="table-primary-text"><?= e_admin($prod['name']) ?></span>
                                    <span class="table-sub-text">SKU: <?= e_admin($prod['sku']) ?></span>
                                </div>
                            </div>
                        </td>
                        <td><?= e_admin($prod['category']) ?></td>
                        <td class="stock-status-cell"><span class="badge <?= $cls ?>"><?= $lbl ?></span></td>
                        <td>
                            <div class="stock-stepper">
                                <button type="button" class="stock-step-btn qty-minus" aria-label="Decrease quantity"><i class="fas fa-minus"></i></button>
                                <input type="number" class="stock-qty-input" value="<?= $qty ?>" min="0" aria-label="Stock quantity" />
                                <button type="button" class="stock-step-btn qty-plus" aria-label="Increase quantity"><i class="fas fa-plus"></i></button>
                            </div>
                        </td>
                        <td>
                            <button type="button" class="btn btn-outline btn-sm btn-save-stock">Update Stock</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="inventoryEmptyState" class="empty-state">
        <div class="empty-state-icon"><i class="fas fa-boxes" aria-hidden="true"></i></div>
        <h3>No Items Match Filter</h3>
        <p>All inventory items look healthy under this filter.</p>
    </div>
</section>

<?php
require_once __DIR__ . '/includes/footer.php';
?>

