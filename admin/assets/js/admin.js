/**
 * LOREM Atelier — Luxury Jewellery Admin Panel Scripts
 * Pure Vanilla JavaScript (Zero external dependencies)
 */

(function () {
    'use strict';

    /* ======================================================================
       1. Core UI Namespace: Toasts, Modals & Sidebar Drawer
       ====================================================================== */
    const AdminUI = {
        pendingDeleteCallback: null,

        init: function () {
            this.initSidebar();
            this.initModals();
            this.initChartSwitcher();
            this.initDropzones();
            this.initProductsPage();
            this.initCategoriesPage();
            this.initOrdersPage();
            this.initCustomersPage();
            this.initInventoryPage();
            this.initMessagesPage();
            this.initSettingsPage();
        },

        toast: function (message, type = 'success') {
            const container = document.getElementById('adminToastContainer');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = `admin-toast ${type}`;

            const iconClass = type === 'error'
                ? 'fas fa-exclamation-triangle'
                : 'fas fa-check-circle';

            toast.innerHTML = `
                <i class="${iconClass}" aria-hidden="true"></i>
                <span style="flex:1;">${this.escapeHtml(message)}</span>
                <button type="button" style="background:none;border:none;color:rgba(255,255,255,0.65);font-size:12px;" aria-label="Dismiss">&times;</button>
            `;

            toast.querySelector('button').addEventListener('click', () => toast.remove());
            container.appendChild(toast);

            setTimeout(() => {
                if (toast.parentNode) {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateY(6px)';
                    toast.style.transition = 'all 0.2s ease';
                    setTimeout(() => toast.remove(), 220);
                }
            }, 3500);
        },

        showAlert: function (containerId, message, type = 'success') {
            const box = document.getElementById(containerId);
            if (!box) return;
            box.className = `admin-alert admin-alert-${type}`;
            box.innerHTML = `
                <span><i class="fas ${type === 'error' ? 'fa-exclamation-triangle' : 'fa-check-circle'}" style="margin-right:8px;"></i>${this.escapeHtml(message)}</span>
                <button type="button" style="background:none;border:none;color:inherit;font-size:16px;" aria-label="Close">&times;</button>
            `;
            box.style.display = 'flex';
            box.querySelector('button').addEventListener('click', () => {
                box.style.display = 'none';
            });
        },

        escapeHtml: function (str) {
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        },

        openModal: function (modalId) {
            const modal = document.getElementById(modalId);
            if (!modal) return;
            modal.classList.add('open');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        },

        closeModal: function (modalId) {
            const modal = document.getElementById(modalId);
            if (!modal) return;
            modal.classList.remove('open');
            modal.setAttribute('aria-hidden', 'true');
            if (!document.querySelector('.admin-modal-overlay.open')) {
                document.body.style.overflow = '';
            }
        },

        confirmDelete: function ({ title, message, onConfirm }) {
            const titleEl = document.getElementById('deleteModalTitle');
            const msgEl = document.getElementById('deleteModalMessage');
            if (titleEl) titleEl.textContent = title || 'Confirm Deletion';
            if (msgEl) msgEl.textContent = message || 'Are you sure you want to remove this item? This action cannot be undone.';
            this.pendingDeleteCallback = onConfirm;
            this.openModal('adminDeleteModal');
        },

        /* ------------------------------------------------------------------
           Sidebar Mobile Drawer
           ------------------------------------------------------------------ */
        initSidebar: function () {
            const sidebar = document.getElementById('adminSidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            const openBtn = document.getElementById('mobileSidebarToggle');
            const closeBtn = document.getElementById('sidebarCloseBtn');

            if (!sidebar) return;

            const toggle = (show) => {
                sidebar.classList.toggle('open', show);
                if (backdrop) backdrop.classList.toggle('open', show);
            };

            if (openBtn) openBtn.addEventListener('click', () => toggle(true));
            if (closeBtn) closeBtn.addEventListener('click', () => toggle(false));
            if (backdrop) backdrop.addEventListener('click', () => toggle(false));
        },

        /* ------------------------------------------------------------------
           Modal Backdrop & Confirmation Handler
           ------------------------------------------------------------------ */
        initModals: function () {
            document.querySelectorAll('.admin-modal-overlay').forEach((overlay) => {
                overlay.addEventListener('click', (e) => {
                    if (e.target === overlay) {
                        this.closeModal(overlay.id);
                    }
                });
            });

            document.querySelectorAll('[data-close-modal]').forEach((btn) => {
                btn.addEventListener('click', () => {
                    const id = btn.getAttribute('data-close-modal');
                    this.closeModal(id);
                });
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    document.querySelectorAll('.admin-modal-overlay.open').forEach((m) => {
                        this.closeModal(m.id);
                    });
                }
            });

            const confirmBtn = document.getElementById('confirmDeleteBtn');
            if (confirmBtn) {
                confirmBtn.addEventListener('click', () => {
                    if (typeof this.pendingDeleteCallback === 'function') {
                        this.pendingDeleteCallback();
                        this.pendingDeleteCallback = null;
                    }
                    this.closeModal('adminDeleteModal');
                });
            }
        },

        /* ------------------------------------------------------------------
           Dashboard Monthly Sales Chart Range Switcher (6M vs 12M)
           ------------------------------------------------------------------ */
        initChartSwitcher: function () {
            const rangeBtns = document.querySelectorAll('.chart-range-btn');
            const bars = document.querySelectorAll('.sales-bar-col');
            const totalRevEl = document.getElementById('chartTotalRevenue');
            const totalOrdEl = document.getElementById('chartTotalOrders');

            if (!rangeBtns.length || !bars.length) return;

            rangeBtns.forEach((btn) => {
                btn.addEventListener('click', () => {
                    rangeBtns.forEach((b) => b.classList.remove('active'));
                    btn.classList.add('active');

                    const months = parseInt(btn.getAttribute('data-months') || '12', 10);
                    const totalCount = bars.length;
                    let sumRev = 0;
                    let sumOrd = 0;

                    bars.forEach((col, idx) => {
                        const visible = idx >= totalCount - months;
                        col.style.display = visible ? 'flex' : 'none';
                        if (visible) {
                            sumRev += parseFloat(col.getAttribute('data-revenue') || '0');
                            sumOrd += parseInt(col.getAttribute('data-orders') || '0', 10);
                        }
                    });

                    if (totalRevEl) {
                        totalRevEl.textContent = '$' + sumRev.toLocaleString('en-US', { minimumFractionDigits: 0 });
                    }
                    if (totalOrdEl) {
                        totalOrdEl.textContent = sumOrd + ' orders';
                    }
                });
            });
        },

        /* ------------------------------------------------------------------
           Reusable Image Dropzone Previewer
           ------------------------------------------------------------------ */
        initDropzones: function () {
            document.querySelectorAll('[data-dropzone]').forEach((zone) => {
                const inputId = zone.getAttribute('data-dropzone');
                const previewId = zone.getAttribute('data-preview');
                const multiple = zone.getAttribute('data-multiple') === 'true';
                const input = document.getElementById(inputId);
                const previewBox = document.getElementById(previewId);

                if (!input || !previewBox) return;

                zone.addEventListener('click', () => input.click());

                zone.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    zone.classList.add('dragover');
                });

                zone.addEventListener('dragleave', () => {
                    zone.classList.remove('dragover');
                });

                zone.addEventListener('drop', (e) => {
                    e.preventDefault();
                    zone.classList.remove('dragover');
                    if (e.dataTransfer && e.dataTransfer.files.length) {
                        this.handleFiles(e.dataTransfer.files, previewBox, multiple);
                    }
                });

                input.addEventListener('change', () => {
                    if (input.files && input.files.length) {
                        this.handleFiles(input.files, previewBox, multiple);
                    }
                });
            });
        },

        handleFiles: function (files, previewBox, multiple) {
            if (!multiple) {
                previewBox.innerHTML = '';
            }
            const fileArr = Array.from(files);
            fileArr.forEach((file) => {
                if (!file.type.startsWith('image/')) {
                    this.toast(`"${file.name}" is not a valid image file.`, 'error');
                    return;
                }
                const reader = new FileReader();
                reader.onload = (ev) => {
                    this.appendPreviewThumb(previewBox, ev.target.result, file.name);
                };
                reader.readAsDataURL(file);
            });
        },

        appendPreviewThumb: function (previewBox, src, altText) {
            const item = document.createElement('div');
            item.className = 'preview-item';
            const isFirst = previewBox.children.length === 0;
            item.innerHTML = `
                <img src="${src}" alt="${this.escapeHtml(altText || 'Preview')}">
                ${isFirst ? '<span class="preview-badge">Main</span>' : ''}
                <button type="button" class="preview-remove" title="Remove image" aria-label="Remove image">&times;</button>
            `;
            item.querySelector('.preview-remove').addEventListener('click', (e) => {
                e.stopPropagation();
                item.remove();
                // Ensure remaining first item gets the Main badge
                if (previewBox.children.length > 0 && !previewBox.querySelector('.preview-badge')) {
                    const badge = document.createElement('span');
                    badge.className = 'preview-badge';
                    badge.textContent = 'Main';
                    previewBox.children[0].appendChild(badge);
                }
            });
            previewBox.appendChild(item);
        },

        /* ------------------------------------------------------------------
           Empty State Visibility Helper
           ------------------------------------------------------------------ */
        updateEmptyState: function (itemsSelector, emptyId) {
            const emptyEl = document.getElementById(emptyId);
            if (!emptyEl) return;
            const visibleCount = Array.from(document.querySelectorAll(itemsSelector))
                .filter((el) => el.style.display !== 'none').length;
            emptyEl.classList.toggle('visible', visibleCount === 0);
        },

        /* ------------------------------------------------------------------
           Products Management Page
           ------------------------------------------------------------------ */
        initProductsPage: function () {
            const tableBody = document.getElementById('productsTableBody');
            if (!tableBody) return;

            const searchInput = document.getElementById('productSearch');
            const categorySelect = document.getElementById('productCategoryFilter');
            const statusSelect = document.getElementById('productStatusFilter');
            const formPanel = document.getElementById('productFormPanel');
            const productForm = document.getElementById('productForm');
            const formTitle = document.getElementById('productFormTitle');
            const openAddBtn = document.getElementById('openAddProductBtn');
            const emptyAddBtn = document.getElementById('emptyAddProductBtn');
            const cancelFormBtn = document.getElementById('cancelProductFormBtn');
            const resetFilterBtn = document.getElementById('resetProductFiltersBtn');
            const previewBox = document.getElementById('productImagePreviews');

            const filterRows = () => {
                const q = (searchInput?.value || '').trim().toLowerCase();
                const cat = categorySelect?.value || 'all';
                const status = statusSelect?.value || 'all';

                tableBody.querySelectorAll('tr').forEach((row) => {
                    const name = (row.getAttribute('data-name') || '').toLowerCase();
                    const sku = (row.getAttribute('data-sku') || '').toLowerCase();
                    const rCat = row.getAttribute('data-category') || '';
                    const rStatus = row.getAttribute('data-status') || '';

                    const matchQ = !q || name.includes(q) || sku.includes(q);
                    const matchCat = cat === 'all' || rCat === cat;
                    const matchStatus = status === 'all' || rStatus === status;

                    row.style.display = (matchQ && matchCat && matchStatus) ? '' : 'none';
                });

                this.updateEmptyState('#productsTableBody tr', 'productsEmptyState');
            };

            [searchInput, categorySelect, statusSelect].forEach((el) => {
                if (el) el.addEventListener(el.tagName === 'INPUT' ? 'input' : 'change', filterRows);
            });

            if (resetFilterBtn) {
                resetFilterBtn.addEventListener('click', () => {
                    if (searchInput) searchInput.value = '';
                    if (categorySelect) categorySelect.value = 'all';
                    if (statusSelect) statusSelect.value = 'all';
                    filterRows();
                });
            }

            const openForm = (mode = 'add', data = null) => {
                if (!formPanel || !productForm) return;
                productForm.reset();
                previewBox.innerHTML = '';
                document.getElementById('editingProductId').value = '';

                if (mode === 'edit' && data) {
                    formTitle.textContent = 'Edit Product: ' + data.name;
                    document.getElementById('editingProductId').value = data.id;
                    document.getElementById('prodName').value = data.name;
                    document.getElementById('prodCategory').value = data.category;
                    document.getElementById('prodPrice').value = data.price;
                    document.getElementById('prodDiscountPrice').value = data.discount_price || '';
                    document.getElementById('prodStock').value = data.stock;
                    document.getElementById('prodStatus').value = data.status;
                    document.getElementById('prodDescription').value = data.description || '';

                    (data.images || []).forEach((imgPath) => {
                        const resolved = imgPath.startsWith('data:') || imgPath.startsWith('../')
                            ? imgPath
                            : '../' + imgPath;
                        this.appendPreviewThumb(previewBox, resolved, data.name);
                    });
                } else {
                    formTitle.textContent = 'Add New Jewellery Product';
                    document.getElementById('prodStatus').value = 'Active';
                    document.getElementById('prodStock').value = '10';
                }

                formPanel.classList.add('active');
                formPanel.scrollIntoView({ behavior: 'smooth', block: 'start' });
            };

            if (openAddBtn) openAddBtn.addEventListener('click', () => openForm('add'));
            if (emptyAddBtn) emptyAddBtn.addEventListener('click', () => openForm('add'));
            if (cancelFormBtn) {
                cancelFormBtn.addEventListener('click', () => {
                    formPanel.classList.remove('active');
                });
            }

            // Open add form automatically if ?action=add is in URL
            const params = new URLSearchParams(window.location.search);
            if (params.get('action') === 'add') {
                openForm('add');
            }

            // Delegate Edit / Delete row clicks
            tableBody.addEventListener('click', (e) => {
                const editBtn = e.target.closest('.btn-edit-product');
                const deleteBtn = e.target.closest('.btn-delete-product');

                if (editBtn) {
                    const row = editBtn.closest('tr');
                    const data = JSON.parse(row.getAttribute('data-product') || '{}');
                    openForm('edit', data);
                }

                if (deleteBtn) {
                    const row = deleteBtn.closest('tr');
                    const name = row.getAttribute('data-name') || 'this product';
                    this.confirmDelete({
                        title: 'Delete Product',
                        message: `Are you sure you want to delete "${name}"? It will be removed from your catalog preview.`,
                        onConfirm: () => {
                            row.remove();
                            this.toast(`"${name}" has been deleted.`);
                            this.updateEmptyState('#productsTableBody tr', 'productsEmptyState');
                        },
                    });
                }
            });

            // Save Add/Edit Product Preview
            if (productForm) {
                productForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    const editId = document.getElementById('editingProductId').value;
                    const name = document.getElementById('prodName').value.trim();
                    const category = document.getElementById('prodCategory').value;
                    const price = parseFloat(document.getElementById('prodPrice').value);
                    const discountRaw = document.getElementById('prodDiscountPrice').value.trim();
                    const discountPrice = discountRaw !== '' ? parseFloat(discountRaw) : null;
                    const stock = parseInt(document.getElementById('prodStock').value, 10);
                    const status = document.getElementById('prodStatus').value;
                    const description = document.getElementById('prodDescription').value.trim();

                    if (!name || isNaN(price) || price <= 0) {
                        this.showAlert('productsAlertBox', 'Please enter a valid Product Name and Price.', 'error');
                        return;
                    }
                    if (discountPrice !== null && discountPrice >= price) {
                        this.showAlert('productsAlertBox', 'Discount Price should be lower than the Regular Price.', 'error');
                        return;
                    }

                    const firstImgEl = previewBox.querySelector('img');
                    const thumbSrc = firstImgEl
                        ? firstImgEl.src
                        : '../assets/images/2020/10/j3376co023200.pw-1280-420x583.jpg';

                    const allImgs = Array.from(previewBox.querySelectorAll('img')).map((im) => im.src);
                    if (!allImgs.length) allImgs.push(thumbSrc);

                    const productObj = {
                        id: editId || Math.floor(200 + Math.random() * 799),
                        sku: 'JWL-' + Math.floor(100 + Math.random() * 899),
                        name,
                        category,
                        price,
                        discount_price: discountPrice,
                        stock: isNaN(stock) ? 0 : stock,
                        status,
                        description,
                        images: allImgs,
                    };

                    const priceHtml = discountPrice
                        ? `<span class="price-sale">$${discountPrice.toFixed(2)}</span><span class="price-strike">$${price.toFixed(2)}</span>`
                        : `<span class="price-current">$${price.toFixed(2)}</span>`;

                    const stockBadge = productObj.stock <= 0
                        ? `<span class="badge badge-danger">Out of Stock (0)</span>`
                        : productObj.stock <= 5
                            ? `<span class="badge badge-warning">Low Stock (${productObj.stock})</span>`
                            : `<span class="badge badge-success">In Stock (${productObj.stock})</span>`;

                    const statusBadge = status === 'Active'
                        ? `<span class="badge badge-success">Active</span>`
                        : `<span class="badge badge-neutral">Inactive</span>`;

                    const buildRowHtml = (obj) => `
                        <td>
                            <div class="table-product-cell">
                                <img src="${this.escapeHtml(thumbSrc)}" alt="${this.escapeHtml(obj.name)}" class="table-thumb">
                                <div>
                                    <span class="table-primary-text">${this.escapeHtml(obj.name)}</span>
                                    <span class="table-sub-text">SKU: ${this.escapeHtml(obj.sku)}</span>
                                </div>
                            </div>
                        </td>
                        <td>${this.escapeHtml(obj.category)}</td>
                        <td>${priceHtml}</td>
                        <td>${stockBadge}</td>
                        <td>${statusBadge}</td>
                        <td>
                            <div class="table-actions">
                                <button type="button" class="btn-icon btn-edit-product" title="Edit Product"><i class="fas fa-edit"></i></button>
                                <button type="button" class="btn-icon delete btn-delete-product" title="Delete Product"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </td>
                    `;

                    if (editId) {
                        const existingRow = tableBody.querySelector(`tr[data-id="${editId}"]`);
                        if (existingRow) {
                            productObj.sku = existingRow.getAttribute('data-sku') || productObj.sku;
                            existingRow.setAttribute('data-name', productObj.name);
                            existingRow.setAttribute('data-category', productObj.category);
                            existingRow.setAttribute('data-status', productObj.status);
                            existingRow.setAttribute('data-product', JSON.stringify(productObj));
                            existingRow.innerHTML = buildRowHtml(productObj);
                        }
                        this.showAlert('productsAlertBox', `"${name}" updated successfully.`, 'success');
                        this.toast(`"${name}" updated successfully.`);
                    } else {
                        const tr = document.createElement('tr');
                        tr.setAttribute('data-id', productObj.id);
                        tr.setAttribute('data-sku', productObj.sku);
                        tr.setAttribute('data-name', productObj.name);
                        tr.setAttribute('data-category', productObj.category);
                        tr.setAttribute('data-status', productObj.status);
                        tr.setAttribute('data-product', JSON.stringify(productObj));
                        tr.innerHTML = buildRowHtml(productObj);
                        tableBody.prepend(tr);
                        this.showAlert('productsAlertBox', `"${name}" added to your jewelry catalog.`, 'success');
                        this.toast(`"${name}" added successfully.`);
                    }

                    formPanel.classList.remove('active');
                    filterRows();
                });
            }
        },

        /* ------------------------------------------------------------------
           Categories Management Page
           ------------------------------------------------------------------ */
        initCategoriesPage: function () {
            const grid = document.getElementById('categoriesGrid');
            if (!grid) return;

            const addBtn = document.getElementById('openAddCategoryBtn');
            const emptyAddBtn = document.getElementById('emptyAddCategoryBtn');
            const catForm = document.getElementById('categoryForm');
            const modalTitle = document.getElementById('categoryModalTitle');
            const previewBox = document.getElementById('categoryImagePreview');

            const openCatModal = (mode = 'add', card = null) => {
                catForm.reset();
                previewBox.innerHTML = '';
                document.getElementById('editingCategoryId').value = '';

                if (mode === 'edit' && card) {
                    const data = JSON.parse(card.getAttribute('data-category') || '{}');
                    modalTitle.textContent = 'Edit Category';
                    document.getElementById('editingCategoryId').value = data.id;
                    document.getElementById('catName').value = data.name || '';
                    document.getElementById('catDescription').value = data.description || '';
                    if (data.image) {
                        const src = data.image.startsWith('data:') || data.image.startsWith('../')
                            ? data.image
                            : '../' + data.image;
                        this.appendPreviewThumb(previewBox, src, data.name);
                    }
                } else {
                    modalTitle.textContent = 'Add New Category';
                }

                this.openModal('categoryModal');
            };

            if (addBtn) addBtn.addEventListener('click', () => openCatModal('add'));
            if (emptyAddBtn) emptyAddBtn.addEventListener('click', () => openCatModal('add'));

            grid.addEventListener('click', (e) => {
                const editBtn = e.target.closest('.btn-edit-category');
                const deleteBtn = e.target.closest('.btn-delete-category');

                if (editBtn) {
                    openCatModal('edit', editBtn.closest('.category-admin-card'));
                }
                if (deleteBtn) {
                    const card = deleteBtn.closest('.category-admin-card');
                    const data = JSON.parse(card.getAttribute('data-category') || '{}');
                    this.confirmDelete({
                        title: 'Delete Category',
                        message: `Delete "${data.name}"? Products in this category will remain unassigned until moved.`,
                        onConfirm: () => {
                            card.remove();
                            this.toast(`Category "${data.name}" removed.`);
                            this.updateEmptyState('#categoriesGrid .category-admin-card', 'categoriesEmptyState');
                        },
                    });
                }
            });

            if (catForm) {
                catForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    const editId = document.getElementById('editingCategoryId').value;
                    const name = document.getElementById('catName').value.trim();
                    const desc = document.getElementById('catDescription').value.trim();

                    if (!name) {
                        this.toast('Category Name is required.', 'error');
                        return;
                    }

                    const imgEl = previewBox.querySelector('img');
                    const imgSrc = imgEl
                        ? imgEl.src
                        : '../assets/images/2020/10/j3376co023200.pw-1280-420x583.jpg';

                    if (editId) {
                        const card = grid.querySelector(`.category-admin-card[data-id="${editId}"]`);
                        if (card) {
                            const oldData = JSON.parse(card.getAttribute('data-category') || '{}');
                            oldData.name = name;
                            oldData.description = desc;
                            oldData.image = imgSrc;
                            card.setAttribute('data-category', JSON.stringify(oldData));
                            card.querySelector('.category-card-title').textContent = name;
                            card.querySelector('.category-card-desc').textContent = desc || 'Curated luxury jewellery collection.';
                            card.querySelector('.category-card-media img').src = imgSrc;
                        }
                        this.toast(`Category "${name}" updated.`);
                    } else {
                        const id = Math.floor(10 + Math.random() * 900);
                        const catObj = { id, name, description: desc || 'Curated luxury jewellery collection.', image: imgSrc, count: 0 };
                        const card = document.createElement('div');
                        card.className = 'category-admin-card';
                        card.setAttribute('data-id', id);
                        card.setAttribute('data-category', JSON.stringify(catObj));
                        card.innerHTML = `
                            <div class="category-card-media">
                                <img src="${this.escapeHtml(imgSrc)}" alt="${this.escapeHtml(name)}">
                                <span class="category-count-pill">0 Pieces</span>
                            </div>
                            <div class="category-card-body">
                                <div>
                                    <h3 class="category-card-title">${this.escapeHtml(name)}</h3>
                                    <p class="category-card-desc">${this.escapeHtml(catObj.description)}</p>
                                </div>
                                <div class="category-card-actions">
                                    <span class="badge badge-success">Active</span>
                                    <div class="table-actions">
                                        <button type="button" class="btn-icon btn-edit-category" title="Edit Category"><i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn-icon delete btn-delete-category" title="Delete Category"><i class="fas fa-trash-alt"></i></button>
                                    </div>
                                </div>
                            </div>
                        `;
                        grid.appendChild(card);
                        this.toast(`Category "${name}" added.`);
                    }

                    this.closeModal('categoryModal');
                    this.updateEmptyState('#categoriesGrid .category-admin-card', 'categoriesEmptyState');
                });
            }
        },

        /* ------------------------------------------------------------------
           Orders Management Page
           ------------------------------------------------------------------ */
        initOrdersPage: function () {
            const tableBody = document.getElementById('ordersTableBody');
            if (!tableBody) return;

            const searchInput = document.getElementById('orderSearch');
            const filterPills = document.querySelectorAll('#orderStatusFilters .filter-pill');
            const resetBtn = document.getElementById('resetOrderFiltersBtn');
            let currentStatus = 'all';

            const filterOrders = () => {
                const q = (searchInput?.value || '').trim().toLowerCase();
                tableBody.querySelectorAll('tr').forEach((row) => {
                    const oid = (row.getAttribute('data-id') || '').toLowerCase();
                    const cust = (row.getAttribute('data-customer') || '').toLowerCase();
                    const status = row.getAttribute('data-status') || '';

                    const matchQ = !q || oid.includes(q) || cust.includes(q);
                    const matchS = currentStatus === 'all' || status === currentStatus;
                    row.style.display = (matchQ && matchS) ? '' : 'none';
                });
                this.updateEmptyState('#ordersTableBody tr', 'ordersEmptyState');
            };

            if (searchInput) searchInput.addEventListener('input', filterOrders);

            filterPills.forEach((pill) => {
                pill.addEventListener('click', () => {
                    filterPills.forEach((p) => p.classList.remove('active'));
                    pill.classList.add('active');
                    currentStatus = pill.getAttribute('data-status') || 'all';
                    filterOrders();
                });
            });

            if (resetBtn) {
                resetBtn.addEventListener('click', () => {
                    if (searchInput) searchInput.value = '';
                    currentStatus = 'all';
                    filterPills.forEach((p) => p.classList.toggle('active', p.getAttribute('data-status') === 'all'));
                    filterOrders();
                });
            }

            const statusBadgeClass = (status) => {
                switch (status) {
                    case 'Delivered': return 'badge-success';
                    case 'Shipped': return 'badge-info';
                    case 'Processing': return 'badge-warning';
                    case 'Pending': return 'badge-warning';
                    case 'Cancelled': return 'badge-danger';
                    default: return 'badge-neutral';
                }
            };

            let activeOrderRow = null;

            tableBody.addEventListener('click', (e) => {
                const viewBtn = e.target.closest('.btn-view-order');
                const deleteBtn = e.target.closest('.btn-delete-order');

                if (viewBtn) {
                    activeOrderRow = viewBtn.closest('tr');
                    const order = JSON.parse(activeOrderRow.getAttribute('data-order') || '{}');

                    document.getElementById('detailOrderId').textContent = order.id;
                    document.getElementById('detailOrderDate').textContent = order.date;
                    document.getElementById('detailCustName').textContent = order.customer_name;
                    document.getElementById('detailCustContact').textContent = `${order.customer_email} • ${order.customer_phone}`;
                    document.getElementById('detailShippingAddr').textContent = order.shipping_addr;
                    document.getElementById('detailPaymentStatus').textContent = order.payment_status;
                    document.getElementById('detailOrderTotal').textContent = '$' + parseFloat(order.total).toFixed(2);
                    document.getElementById('detailOrderStatusSelect').value = order.order_status;

                    const itemsBody = document.getElementById('detailOrderItemsBody');
                    itemsBody.innerHTML = (order.items || []).map((it) => {
                        const imgSrc = it.image.startsWith('../') ? it.image : '../' + it.image;
                        return `
                            <tr>
                                <td>
                                    <div class="table-product-cell">
                                        <img src="${this.escapeHtml(imgSrc)}" alt="${this.escapeHtml(it.name)}" class="table-thumb">
                                        <span class="table-primary-text">${this.escapeHtml(it.name)}</span>
                                    </div>
                                </td>
                                <td>&times;${it.qty}</td>
                                <td>$${parseFloat(it.price).toFixed(2)}</td>
                            </tr>
                        `;
                    }).join('');

                    this.openModal('orderDetailModal');
                }

                if (deleteBtn) {
                    const row = deleteBtn.closest('tr');
                    const oid = row.getAttribute('data-id');
                    this.confirmDelete({
                        title: 'Remove Order Record',
                        message: `Are you sure you want to remove order ${oid} from the list?`,
                        onConfirm: () => {
                            row.remove();
                            this.toast(`Order ${oid} removed.`);
                            this.updateEmptyState('#ordersTableBody tr', 'ordersEmptyState');
                        },
                    });
                }
            });

            // Save Updated Order Status inside Modal
            const saveStatusBtn = document.getElementById('saveOrderStatusBtn');
            if (saveStatusBtn) {
                saveStatusBtn.addEventListener('click', () => {
                    if (!activeOrderRow) return;
                    const newStatus = document.getElementById('detailOrderStatusSelect').value;
                    const order = JSON.parse(activeOrderRow.getAttribute('data-order') || '{}');
                    order.order_status = newStatus;
                    activeOrderRow.setAttribute('data-order', JSON.stringify(order));
                    activeOrderRow.setAttribute('data-status', newStatus);

                    const badgeCell = activeOrderRow.querySelector('.order-status-cell');
                    if (badgeCell) {
                        badgeCell.innerHTML = `<span class="badge ${statusBadgeClass(newStatus)}">${this.escapeHtml(newStatus)}</span>`;
                    }
                    this.closeModal('orderDetailModal');
                    this.toast(`Order ${order.id} updated to "${newStatus}".`);
                    filterOrders();
                });
            }
        },

        /* ------------------------------------------------------------------
           Customers Management Page
           ------------------------------------------------------------------ */
        initCustomersPage: function () {
            const tableBody = document.getElementById('customersTableBody');
            if (!tableBody) return;

            const searchInput = document.getElementById('customerSearch');
            const resetBtn = document.getElementById('resetCustomerSearchBtn');

            const filterCustomers = () => {
                const q = (searchInput?.value || '').trim().toLowerCase();
                tableBody.querySelectorAll('tr').forEach((row) => {
                    const txt = (row.getAttribute('data-search') || '').toLowerCase();
                    row.style.display = (!q || txt.includes(q)) ? '' : 'none';
                });
                this.updateEmptyState('#customersTableBody tr', 'customersEmptyState');
            };

            if (searchInput) searchInput.addEventListener('input', filterCustomers);
            if (resetBtn) {
                resetBtn.addEventListener('click', () => {
                    if (searchInput) searchInput.value = '';
                    filterCustomers();
                });
            }

            tableBody.addEventListener('click', (e) => {
                const btn = e.target.closest('.btn-view-customer');
                if (!btn) return;
                const row = btn.closest('tr');
                const c = JSON.parse(row.getAttribute('data-customer') || '{}');

                document.getElementById('custDetailName').textContent = c.name;
                document.getElementById('custDetailEmail').textContent = c.email;
                document.getElementById('custDetailPhone').textContent = c.phone;
                document.getElementById('custDetailAddress').textContent = c.address;
                document.getElementById('custDetailSpent').textContent = '$' + parseFloat(c.total_spent).toFixed(2);
                document.getElementById('custDetailOrdersCount').textContent = `${c.orders_count} order(s)`;

                const historyBody = document.getElementById('custOrderHistoryBody');
                historyBody.innerHTML = (c.history || []).map((h) => `
                    <tr>
                        <td><strong>${this.escapeHtml(h.id)}</strong></td>
                        <td>${this.escapeHtml(h.date)}</td>
                        <td>${this.escapeHtml(h.items)}</td>
                        <td>$${parseFloat(h.total).toFixed(2)}</td>
                        <td><span class="badge ${h.status === 'Delivered' ? 'badge-success' : (h.status === 'Cancelled' ? 'badge-danger' : 'badge-warning')}">${this.escapeHtml(h.status)}</span></td>
                    </tr>
                `).join('');

                this.openModal('customerDetailModal');
            });
        },

        /* ------------------------------------------------------------------
           Inventory Management Page
           ------------------------------------------------------------------ */
        initInventoryPage: function () {
            const tableBody = document.getElementById('inventoryTableBody');
            if (!tableBody) return;

            const searchInput = document.getElementById('inventorySearch');
            const filterPills = document.querySelectorAll('#inventoryFilters .filter-pill');
            let activeFilter = 'all';

            const filterStock = () => {
                const q = (searchInput?.value || '').trim().toLowerCase();
                tableBody.querySelectorAll('tr').forEach((row) => {
                    const name = (row.getAttribute('data-name') || '').toLowerCase();
                    const qty = parseInt(row.getAttribute('data-stock') || '0', 10);

                    const matchQ = !q || name.includes(q);
                    let matchF = true;
                    if (activeFilter === 'low') matchF = (qty > 0 && qty <= 5);
                    if (activeFilter === 'out') matchF = (qty <= 0);

                    row.style.display = (matchQ && matchF) ? '' : 'none';
                });
                this.updateEmptyState('#inventoryTableBody tr', 'inventoryEmptyState');
            };

            if (searchInput) searchInput.addEventListener('input', filterStock);
            filterPills.forEach((pill) => {
                pill.addEventListener('click', () => {
                    filterPills.forEach((p) => p.classList.remove('active'));
                    pill.classList.add('active');
                    activeFilter = pill.getAttribute('data-filter') || 'all';
                    filterStock();
                });
            });

            tableBody.addEventListener('click', (e) => {
                const minusBtn = e.target.closest('.qty-minus');
                const plusBtn = e.target.closest('.qty-plus');
                const saveBtn = e.target.closest('.btn-save-stock');
                const row = e.target.closest('tr');
                if (!row) return;

                const input = row.querySelector('.stock-qty-input');
                if (minusBtn && input) {
                    input.value = Math.max(0, parseInt(input.value || '0', 10) - 1);
                }
                if (plusBtn && input) {
                    input.value = parseInt(input.value || '0', 10) + 1;
                }
                if (saveBtn && input) {
                    const qty = Math.max(0, parseInt(input.value || '0', 10));
                    row.setAttribute('data-stock', qty);
                    const badgeCell = row.querySelector('.stock-status-cell');
                    if (badgeCell) {
                        if (qty === 0) {
                            badgeCell.innerHTML = '<span class="badge badge-danger">Out of Stock</span>';
                        } else if (qty <= 5) {
                            badgeCell.innerHTML = '<span class="badge badge-warning">Low Stock</span>';
                        } else {
                            badgeCell.innerHTML = '<span class="badge badge-success">Healthy</span>';
                        }
                    }
                    const pName = row.getAttribute('data-name') || 'Item';
                    this.toast(`Updated stock for "${pName}" to ${qty} units.`);
                    filterStock();
                }
            });
        },

        /* ------------------------------------------------------------------
           Messages / Contact Inquiries Page
           ------------------------------------------------------------------ */
        initMessagesPage: function () {
            const tableBody = document.getElementById('messagesTableBody');
            if (!tableBody) return;

            const filterPills = document.querySelectorAll('#messageFilters .filter-pill');
            const searchInput = document.getElementById('messageSearch');
            let currentFilter = 'all';
            let activeMsgRow = null;

            const filterMsgs = () => {
                const q = (searchInput?.value || '').trim().toLowerCase();
                tableBody.querySelectorAll('tr').forEach((row) => {
                    const txt = (row.getAttribute('data-search') || '').toLowerCase();
                    const status = row.getAttribute('data-status') || '';
                    const matchQ = !q || txt.includes(q);
                    const matchF = currentFilter === 'all' || status === currentFilter;
                    row.style.display = (matchQ && matchF) ? '' : 'none';
                });
                this.updateEmptyState('#messagesTableBody tr', 'messagesEmptyState');
            };

            if (searchInput) searchInput.addEventListener('input', filterMsgs);
            filterPills.forEach((p) => {
                p.addEventListener('click', () => {
                    filterPills.forEach((b) => b.classList.remove('active'));
                    p.classList.add('active');
                    currentFilter = p.getAttribute('data-status') || 'all';
                    filterMsgs();
                });
            });

            tableBody.addEventListener('click', (e) => {
                const viewBtn = e.target.closest('.btn-view-message');
                const deleteBtn = e.target.closest('.btn-delete-message');

                if (viewBtn) {
                    activeMsgRow = viewBtn.closest('tr');
                    const msg = JSON.parse(activeMsgRow.getAttribute('data-message') || '{}');
                    document.getElementById('msgDetailSender').textContent = msg.name;
                    document.getElementById('msgDetailContact').textContent = `${msg.email} • ${msg.phone}`;
                    document.getElementById('msgDetailSubject').textContent = msg.subject;
                    document.getElementById('msgDetailDate').textContent = msg.date;
                    document.getElementById('msgDetailBody').textContent = msg.message;
                    document.getElementById('msgReplyInput').value = '';

                    if (msg.status === 'Unread') {
                        msg.status = 'Read';
                        activeMsgRow.setAttribute('data-status', 'Read');
                        activeMsgRow.setAttribute('data-message', JSON.stringify(msg));
                        activeMsgRow.querySelector('.msg-status-cell').innerHTML = '<span class="badge badge-info">Read</span>';
                    }

                    this.openModal('messageModal');
                }

                if (deleteBtn) {
                    const row = deleteBtn.closest('tr');
                    const sender = row.getAttribute('data-sender') || 'this message';
                    this.confirmDelete({
                        title: 'Delete Inquiry',
                        message: `Remove customer inquiry from "${sender}"?`,
                        onConfirm: () => {
                            row.remove();
                            this.toast('Inquiry deleted.');
                            this.updateEmptyState('#messagesTableBody tr', 'messagesEmptyState');
                        },
                    });
                }
            });

            const sendReplyBtn = document.getElementById('sendReplyBtn');
            if (sendReplyBtn) {
                sendReplyBtn.addEventListener('click', () => {
                    const replyText = document.getElementById('msgReplyInput').value.trim();
                    if (!replyText) {
                        this.toast('Please write a short reply message first.', 'error');
                        return;
                    }
                    if (activeMsgRow) {
                        const msg = JSON.parse(activeMsgRow.getAttribute('data-message') || '{}');
                        msg.status = 'Replied';
                        activeMsgRow.setAttribute('data-status', 'Replied');
                        activeMsgRow.setAttribute('data-message', JSON.stringify(msg));
                        activeMsgRow.querySelector('.msg-status-cell').innerHTML = '<span class="badge badge-success">Replied</span>';
                    }
                    this.closeModal('messageModal');
                    this.toast('Reply prepared & marked as Replied.');
                });
            }
        },

        /* ------------------------------------------------------------------
           Settings Page
           ------------------------------------------------------------------ */
        initSettingsPage: function () {
            const form = document.getElementById('settingsForm');
            if (!form) return;

            form.addEventListener('submit', (e) => {
                e.preventDefault();
                this.showAlert('settingsAlertBox', 'Store and studio settings saved successfully (Design Preview).', 'success');
                this.toast('Settings updated successfully.');
            });
        },
    };

    window.AdminUI = AdminUI;
    document.addEventListener('DOMContentLoaded', () => AdminUI.init());
})();

