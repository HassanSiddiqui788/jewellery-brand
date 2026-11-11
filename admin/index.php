<?php
/**
 * Admin Page: Dashboard Overview
 */
require_once __DIR__ . '/includes/config.php';

$page_title = 'Dashboard';
$page_subtitle = 'Atelier Performance & Overview';
$active_nav = 'dashboard';

$stats         = get_sample_dashboard_stats();
$monthly_sales = get_sample_monthly_sales();
$products      = get_sample_products();
$orders        = array_slice(get_sample_orders(), 0, 5);

// Sort products for Best Sellers (Top 4)
$best_sellers = $products;
usort($best_sellers, function ($a, $b) {
    return $b['sales'] <=> $a['sales'];
});
$best_sellers = array_slice($best_sellers, 0, 4);

// Filter Low Stock Products (<= 5 units)
$low_stock = array_values(array_filter($products, function ($p) {
    return $p['stock'] <= 5;
}));

// Chart scaling calculations
$max_rev = max(array_column($monthly_sales, 'revenue')) ?: 1;
$sum_rev = array_sum(array_column($monthly_sales, 'revenue'));
$sum_ord = array_sum(array_column($monthly_sales, 'orders'));

require_once __DIR__ . '/includes/header.php';
?>

<!-- 1. KPI Summary Cards -->
<section class="kpi-grid" aria-label="Key Performance Metrics">
    <?php foreach ($stats as $stat): ?>
        <a href="<?= e_admin($stat['href']) ?>" class="kpi-card">
            <div class="kpi-top">
                <span class="kpi-label"><?= e_admin($stat['label']) ?></span>
                <span class="kpi-icon"><i class="<?= e_admin($stat['icon']) ?>" aria-hidden="true"></i></span>
            </div>
            <div class="kpi-value"><?= e_admin($stat['value']) ?></div>
            <div class="kpi-trend">
                <i class="fas fa-chart-line" aria-hidden="true"></i>
                <span><?= e_admin($stat['change']) ?></span>
            </div>
        </a>
    <?php endforeach; ?>
</section>

<!-- 2. Monthly Sales Chart + Best Selling Products -->
<section class="dashboard-grid-main">
    <!-- Monthly Sales Chart -->
    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <h2 class="admin-card-title">Monthly Sales Revenue</h2>
                <div class="admin-card-subtitle">Revenue and order volume across recent months</div>
            </div>
            <div class="chart-header-controls" role="group" aria-label="Chart Timeframe">
                <button type="button" class="chart-range-btn" data-months="6">6 Months</button>
                <button type="button" class="chart-range-btn active" data-months="12">12 Months</button>
            </div>
        </div>
        <div class="admin-card-body">
            <div class="sales-chart-wrapper">
                <div class="sales-bars-grid">
                    <?php foreach ($monthly_sales as $m):
                        $height_pct = max(8, round(($m['revenue'] / $max_rev) * 100));
                        $is_peak = ($m['revenue'] === $max_rev);
                    ?>
                        <div class="sales-bar-col <?= $is_peak ? 'peak' : '' ?>"
                             data-revenue="<?= e_admin($m['revenue']) ?>"
                             data-orders="<?= e_admin($m['orders']) ?>">
                            <div class="sales-bar-track">
                                <div class="sales-bar-fill" style="height: <?= $height_pct ?>%;">
                                    <div class="sales-bar-tooltip">
                                        <strong>$<?= number_format($m['revenue']) ?></strong>
                                        <?= (int)$m['orders'] ?> orders
                                    </div>
                                </div>
                            </div>
                            <span class="sales-bar-label"><?= e_admin($m['month']) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="chart-summary-strip">
                    <span>Period Revenue: <strong id="chartTotalRevenue">$<?= number_format($sum_rev) ?></strong></span>
                    <span>Completed Volume: <strong id="chartTotalOrders"><?= (int)$sum_ord ?> orders</strong></span>
                    <span>Peak Month: <strong>November ($<?= number_format($max_rev) ?>)</strong></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Best Selling Products -->
    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <h2 class="admin-card-title">Best Selling Pieces</h2>
                <div class="admin-card-subtitle">Most requested collections</div>
            </div>
            <a href="products.php" class="card-link-action">All Products <i class="fas fa-chevron-right"></i></a>
        </div>
        <div class="admin-card-body">
            <div class="mini-list">
                <?php foreach ($best_sellers as $item):
                    $unit_price = $item['discount_price'] ?? $item['price'];
                ?>
                    <a href="products.php" class="mini-item">
                        <img src="<?= e_admin(admin_asset_img($item['images'][0] ?? '')) ?>"
                             alt="<?= e_admin($item['name']) ?>" class="mini-thumb" />
                        <div class="mini-info">
                            <div class="mini-title"><?= e_admin($item['name']) ?></div>
                            <div class="mini-meta"><?= e_admin($item['category']) ?> &bull; <?= (int)$item['sales'] ?> sold</div>
                        </div>
                        <div class="mini-right">
                            <div class="mini-value"><?= admin_currency($unit_price) ?></div>
                            <div class="mini-meta"><?= (int)$item['stock'] ?> left</div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- 3. Recent Orders + Low Stock Alerts -->
<section class="dashboard-grid-bottom">
    <!-- Recent Orders -->
    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <h2 class="admin-card-title">Recent Orders</h2>
                <div class="admin-card-subtitle">Latest boutique purchases</div>
            </div>
            <a href="orders.php" class="card-link-action">View All Orders <i class="fas fa-chevron-right"></i></a>
        </div>
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $ord):
                        $badge_cls = 'badge-warning';
                        if ($ord['order_status'] === 'Delivered') $badge_cls = 'badge-success';
                        elseif ($ord['order_status'] === 'Shipped') $badge_cls = 'badge-info';
                        elseif ($ord['order_status'] === 'Cancelled') $badge_cls = 'badge-danger';
                    ?>
                        <tr>
                            <td><a href="orders.php" style="font-weight: 600; color: var(--color-primary);"><?= e_admin($ord['id']) ?></a></td>
                            <td><?= e_admin($ord['customer_name']) ?></td>
                            <td><span class="table-sub-text"><?= e_admin($ord['date']) ?></span></td>
                            <td><strong><?= admin_currency($ord['total']) ?></strong></td>
                            <td><span class="badge <?= $badge_cls ?>"><?= e_admin($ord['order_status']) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Low Stock Products -->
    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <h2 class="admin-card-title">Low Stock Alerts</h2>
                <div class="admin-card-subtitle">Pieces needing restock soon</div>
            </div>
            <a href="inventory.php" class="card-link-action">Manage Stock <i class="fas fa-chevron-right"></i></a>
        </div>
        <div class="admin-card-body">
            <?php if (empty($low_stock)): ?>
                <div class="empty-state visible" style="padding: 28px 16px;">
                    <div class="empty-state-icon"><i class="fas fa-check-circle"></i></div>
                    <h3>Inventory Healthy</h3>
                    <p>All jewellery pieces are adequately stocked.</p>
                </div>
            <?php else: ?>
                <div class="mini-list">
                    <?php foreach ($low_stock as $ls):
                        $is_out = ($ls['stock'] <= 0);
                    ?>
                        <div class="mini-item">
                            <img src="<?= e_admin(admin_asset_img($ls['images'][0] ?? '')) ?>"
                                 alt="<?= e_admin($ls['name']) ?>" class="mini-thumb" />
                            <div class="mini-info">
                                <div class="mini-title"><?= e_admin($ls['name']) ?></div>
                                <div class="mini-meta"><?= e_admin($ls['category']) ?> &bull; SKU: <?= e_admin($ls['sku']) ?></div>
                            </div>
                            <div class="mini-right">
                                <span class="badge <?= $is_out ? 'badge-danger' : 'badge-warning' ?>">
                                    <?= $is_out ? 'Out of Stock' : ((int)$ls['stock'] . ' left') ?>
                                </span>
                                <div style="margin-top: 5px;">
                                    <a href="inventory.php" style="font-size: 11px; font-weight: 600; color: var(--color-accent);">Restock &rarr;</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
require_once __DIR__ . '/includes/footer.php';
?>

