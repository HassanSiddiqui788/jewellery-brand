<?php
/**
 * Admin Page: Product Management
 */
require_once __DIR__ . '/includes/config.php';

$page_title = 'Products';
$page_subtitle = 'Manage Jewellery Catalog & Pricing';
$active_nav = 'products';

$dbProducts = [];
try {
    $dbRaw = get_catalog_products(null, 100);
    foreach ($dbRaw as $p) {
        $dbProducts[] = [
            'id'             => $p->id,
            'sku'            => 'JW-' . $p->id,
            'name'           => $p->name,
            'description'    => $p->description,
            'category'       => $p->categoryName ?? 'Jewellery',
            'price'          => $p->price,
            'discount_price' => $p->discountPrice,
            'stock'          => $p->stockQuantity,
            'sales'          => 0,
            'status'         => ucfirst($p->status),
            'images'         => [$p->mainImage],
        ];
    }
} catch (\Throwable $e) {}

$products   = !empty($dbProducts) ? $dbProducts : get_sample_products();
$categories = get_sample_categories();

require_once __DIR__ . '/includes/header.php';
?>

<div id="productsAlertBox" class="admin-alert" style="display: none;"></div>

<!-- Action Toolbar -->
<div class="page-action-bar">
    <div class="toolbar-filters">
        <div class="search-input-wrap">
            <i class="fas fa-search" aria-hidden="true"></i>
            <input type="text" id="productSearch" class="search-input" placeholder="Search jewellery by name or SKU..." />
        </div>

        <select id="productCategoryFilter" class="filter-select" aria-label="Filter by Category">
            <option value="all">All Categories</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= e_admin($cat['name']) ?>"><?= e_admin($cat['name']) ?></option>
            <?php endforeach; ?>
        </select>

        <select id="productStatusFilter" class="filter-select" aria-label="Filter by Status">
            <option value="all">All Statuses</option>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
        </select>
    </div>

    <button type="button" id="openAddProductBtn" class="btn btn-primary">
        <i class="fas fa-plus" aria-hidden="true"></i> Add New Product
    </button>
</div>

<!-- Beginner-Friendly Add / Edit Product Form Panel -->
<section id="productFormPanel" class="admin-card admin-form-panel" aria-labelledby="productFormTitle">
    <div class="admin-card-header">
        <div>
            <h2 id="productFormTitle" class="admin-card-title">Add New Jewellery Product</h2>
            <div class="admin-card-subtitle">Fill in the simple details below to publish or update a piece in your store</div>
        </div>
        <button type="button" id="cancelProductFormBtn" class="btn btn-outline btn-sm">
            <i class="fas fa-times" aria-hidden="true"></i> Close
        </button>
    </div>

    <form id="productForm" class="admin-card-body admin-form" novalidate>
        <input type="hidden" id="editingProductId" value="" />

        <div class="form-grid">
            <div class="form-group">
                <label for="prodName" class="form-label">Product Name <span class="req">*</span></label>
                <input type="text" id="prodName" class="form-control" placeholder="e.g., Exuberant Golden Necklace" required />
                <span class="form-help">Give this piece a clear, memorable title for customers.</span>
            </div>

            <div class="form-group">
                <label for="prodCategory" class="form-label">Category <span class="req">*</span></label>
                <select id="prodCategory" class="form-control" required>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= e_admin($cat['name']) ?>"><?= e_admin($cat['name']) ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="form-help">Choose which collection section this piece appears in.</span>
            </div>

            <div class="form-group">
                <label for="prodPrice" class="form-label">Price (USD $) <span class="req">*</span></label>
                <input type="number" id="prodPrice" class="form-control" step="0.01" min="0" placeholder="e.g., 299.00" required />
            </div>

            <div class="form-group">
                <label for="prodDiscountPrice" class="form-label">Discount Price (USD $)</label>
                <input type="number" id="prodDiscountPrice" class="form-control" step="0.01" min="0" placeholder="Optional sale price (e.g., 249.00)" />
                <span class="form-help">Optional: Leave empty if this piece is not currently discounted.</span>
            </div>

            <div class="form-group">
                <label for="prodStock" class="form-label">Stock Quantity <span class="req">*</span></label>
                <input type="number" id="prodStock" class="form-control" min="0" value="10" required />
                <span class="form-help">Number of pieces currently ready for purchase.</span>
            </div>

            <div class="form-group">
                <label for="prodStatus" class="form-label">Product Status</label>
                <select id="prodStatus" class="form-control">
                    <option value="Active">Active (Visible in Store)</option>
                    <option value="Inactive">Inactive (Hidden Draft)</option>
                </select>
            </div>

            <div class="form-group full">
                <label for="prodDescription" class="form-label">Description</label>
                <textarea id="prodDescription" class="form-control" placeholder="Describe the craftsmanship, gold karat, dimensions, and inspiration behind this piece..."></textarea>
            </div>

            <div class="form-group full">
                <label class="form-label">Product Images (Upload Multiple)</label>
                <input type="file" id="prodImagesInput" accept="image/*" multiple class="sr-only" />
                <div class="upload-dropzone" data-dropzone="prodImagesInput" data-preview="productImagePreviews" data-multiple="true">
                    <i class="fas fa-cloud-upload-alt" aria-hidden="true"></i>
                    <div class="upload-dropzone-title">Click to choose photos or drag &amp; drop here</div>
                    <div class="upload-dropzone-sub">Select one or multiple JPG / PNG photos. The first photo becomes the Main thumbnail.</div>
                </div>
                <div id="productImagePreviews" class="upload-previews"></div>
            </div>
        </div>

        <div class="form-footer-actions">
            <button type="button" class="btn btn-outline" onclick="document.getElementById('productFormPanel').classList.remove('active');">Cancel</button>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-check-circle" aria-hidden="true"></i> Save Product
            </button>
        </div>
    </form>
</section>

<!-- Products Catalog Table -->
<section class="admin-card">
    <div class="admin-card-header">
        <div>
            <h2 class="admin-card-title">All Jewellery Pieces</h2>
            <div class="admin-card-subtitle">Click edit to update pricing, stock, or photos anytime</div>
        </div>
        <span class="table-sub-text"><?= count($products) ?> sample pieces loaded</span>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="productsTableBody">
                <?php foreach ($products as $prod):
                    $thumb = admin_asset_img($prod['images'][0] ?? '');
                    $stock = (int)$prod['stock'];
                    $stock_cls = ($stock <= 0) ? 'badge-danger' : (($stock <= 5) ? 'badge-warning' : 'badge-success');
                    $stock_lbl = ($stock <= 0) ? 'Out of Stock (0)' : (($stock <= 5) ? "Low Stock ({$stock})" : "In Stock ({$stock})");
                    $status_cls = ($prod['status'] === 'Active') ? 'badge-success' : 'badge-neutral';
                ?>
                    <tr data-id="<?= (int)$prod['id'] ?>"
                        data-sku="<?= e_admin($prod['sku']) ?>"
                        data-name="<?= e_admin($prod['name']) ?>"
                        data-category="<?= e_admin($prod['category']) ?>"
                        data-status="<?= e_admin($prod['status']) ?>"
                        data-product="<?= e_admin(json_encode($prod)) ?>">
                        <td>
                            <div class="table-product-cell">
                                <img src="<?= e_admin($thumb) ?>" alt="<?= e_admin($prod['name']) ?>" class="table-thumb" />
                                <div>
                                    <span class="table-primary-text"><?= e_admin($prod['name']) ?></span>
                                    <span class="table-sub-text">SKU: <?= e_admin($prod['sku']) ?> &bull; <?= count($prod['images']) ?> photo(s)</span>
                                </div>
                            </div>
                        </td>
                        <td><?= e_admin($prod['category']) ?></td>
                        <td>
                            <?php if (!empty($prod['discount_price'])): ?>
                                <span class="price-sale"><?= admin_currency($prod['discount_price']) ?></span>
                                <span class="price-strike"><?= admin_currency($prod['price']) ?></span>
                            <?php else: ?>
                                <span class="price-current"><?= admin_currency($prod['price']) ?></span>
                            <?php endif; ?>
                        </td>
                        <td><span class="badge <?= $stock_cls ?>"><?= e_admin($stock_lbl) ?></span></td>
                        <td><span class="badge <?= $status_cls ?>"><?= e_admin($prod['status']) ?></span></td>
                        <td>
                            <div class="table-actions">
                                <button type="button" class="btn-icon btn-edit-product" title="Edit Product" aria-label="Edit Product">
                                    <i class="fas fa-edit" aria-hidden="true"></i>
                                </button>
                                <button type="button" class="btn-icon delete btn-delete-product" title="Delete Product" aria-label="Delete Product">
                                    <i class="fas fa-trash-alt" aria-hidden="true"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Meaningful Empty State -->
    <div id="productsEmptyState" class="empty-state">
        <div class="empty-state-icon"><i class="fas fa-gem" aria-hidden="true"></i></div>
        <h3>No Jewellery Pieces Found</h3>
        <p>No products match your current search or filter criteria. Reset filters or add a new piece to your collection.</p>
        <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
            <button type="button" id="resetProductFiltersBtn" class="btn btn-outline btn-sm">Reset Filters</button>
            <button type="button" id="emptyAddProductBtn" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add First Product</button>
        </div>
    </div>
</section>

<?php
require_once __DIR__ . '/includes/footer.php';
?>

