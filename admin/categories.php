<?php
/**
 * Admin Page: Category Management
 */
require_once __DIR__ . '/includes/config.php';

$page_title = 'Categories';
$page_subtitle = 'Organize Jewellery Collections';
$active_nav = 'categories';

$dbCats = [];
try {
    $dbRawCats = get_catalog_categories();
    foreach ($dbRawCats as $c) {
        $dbCats[] = [
            'id'          => $c->id,
            'name'        => $c->name,
            'slug'        => $c->slug,
            'image'       => $c->image,
            'description' => $c->description,
            'count'       => 2,
            'status'      => ucfirst($c->status),
        ];
    }
} catch (\Throwable $e) {}

$categories = !empty($dbCats) ? $dbCats : get_sample_categories();

require_once __DIR__ . '/includes/header.php';
?>

<!-- Top Action Bar -->
<div class="page-action-bar">
    <div>
        <span class="table-sub-text" style="font-size: 13px;">Manage your storefront categories (Necklaces, Bracelets, Earrings)</span>
    </div>

    <button type="button" id="openAddCategoryBtn" class="btn btn-primary">
        <i class="fas fa-plus" aria-hidden="true"></i> Add Category
    </button>
</div>

<!-- Category Luxury Grid -->
<section id="categoriesGrid" class="categories-grid" aria-label="Product Categories">
    <?php foreach ($categories as $cat): ?>
        <article class="category-admin-card"
                 data-id="<?= (int)$cat['id'] ?>"
                 data-category="<?= e_admin(json_encode($cat)) ?>">
            <div class="category-card-media">
                <img src="<?= e_admin(admin_asset_img($cat['image'])) ?>" alt="<?= e_admin($cat['name']) ?>" />
                <span class="category-count-pill"><?= (int)$cat['count'] ?> Pieces</span>
            </div>
            <div class="category-card-body">
                <div>
                    <h2 class="category-card-title"><?= e_admin($cat['name']) ?></h2>
                    <p class="category-card-desc"><?= e_admin($cat['description']) ?></p>
                </div>
                <div class="category-card-actions">
                    <span class="badge badge-success"><?= e_admin($cat['status']) ?></span>
                    <div class="table-actions">
                        <button type="button" class="btn-icon btn-edit-category" title="Edit Category" aria-label="Edit Category">
                            <i class="fas fa-edit" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn-icon delete btn-delete-category" title="Delete Category" aria-label="Delete Category">
                            <i class="fas fa-trash-alt" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </article>
    <?php endforeach; ?>
</section>

<!-- Empty State -->
<div id="categoriesEmptyState" class="admin-card empty-state">
    <div class="empty-state-icon"><i class="fas fa-tags" aria-hidden="true"></i></div>
    <h3>No Categories Available</h3>
    <p>Create your first jewelry category to neatly organize necklaces, bracelets, or earrings.</p>
    <button type="button" id="emptyAddCategoryBtn" class="btn btn-primary btn-sm">
        <i class="fas fa-plus" aria-hidden="true"></i> Add Category
    </button>
</div>

<!-- Add / Edit Category Modal -->
<div id="categoryModal" class="admin-modal-overlay" role="dialog" aria-modal="true" aria-labelledby="categoryModalTitle" aria-hidden="true">
    <div class="admin-modal">
        <div class="admin-modal-header">
            <h2 id="categoryModalTitle" class="admin-modal-title">Add New Category</h2>
            <button type="button" class="modal-close-btn" data-close-modal="categoryModal" aria-label="Close">
                <i class="fas fa-times" aria-hidden="true"></i>
            </button>
        </div>

        <form id="categoryForm" class="admin-form" novalidate>
            <input type="hidden" id="editingCategoryId" value="" />
            <div class="admin-modal-body">
                <div class="form-group" style="margin-bottom: 18px;">
                    <label for="catName" class="form-label">Category Name <span class="req">*</span></label>
                    <input type="text" id="catName" class="form-control" placeholder="e.g., Necklaces" required />
                </div>

                <div class="form-group" style="margin-bottom: 18px;">
                    <label for="catDescription" class="form-label">Short Description</label>
                    <textarea id="catDescription" class="form-control" style="min-height: 82px;" placeholder="Brief editorial summary shown on category headers..."></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Category Cover Image</label>
                    <input type="file" id="catImageInput" accept="image/*" class="sr-only" />
                    <div class="upload-dropzone" data-dropzone="catImageInput" data-preview="categoryImagePreview" data-multiple="false" style="padding: 20px;">
                        <i class="fas fa-cloud-upload-alt" style="font-size: 24px;" aria-hidden="true"></i>
                        <div class="upload-dropzone-title">Click to upload category image</div>
                        <div class="upload-dropzone-sub">Recommended portrait or square high-resolution photo</div>
                    </div>
                    <div id="categoryImagePreview" class="upload-previews"></div>
                </div>
            </div>

            <div class="admin-modal-footer">
                <button type="button" class="btn btn-outline btn-sm" data-close-modal="categoryModal">Cancel</button>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-check-circle" aria-hidden="true"></i> Save Category
                </button>
            </div>
        </form>
    </div>
</div>

<?php
require_once __DIR__ . '/includes/footer.php';
?>

