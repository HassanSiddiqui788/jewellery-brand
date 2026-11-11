<?php
/**
 * Admin Layout Footer Component
 * Includes Global Delete Confirmation Modal & Toast Container
 */
?>
</main><!-- /.admin-content -->
</div><!-- /.admin-main -->
</div><!-- /.admin-shell -->

<!-- Shared Delete Confirmation Modal -->
<div id="adminDeleteModal" class="admin-modal-overlay" role="dialog" aria-modal="true" aria-labelledby="deleteModalTitle" aria-hidden="true">
    <div class="admin-modal modal-sm">
        <div class="admin-modal-header">
            <h2 id="deleteModalTitle" class="admin-modal-title">Confirm Deletion</h2>
            <button type="button" class="modal-close-btn" data-close-modal="adminDeleteModal" aria-label="Close">
                <i class="fas fa-times" aria-hidden="true"></i>
            </button>
        </div>
        <div class="admin-modal-body" style="text-align: center;">
            <div class="confirm-icon-circle">
                <i class="fas fa-exclamation-triangle" aria-hidden="true"></i>
            </div>
            <p id="deleteModalMessage" style="margin: 0; color: var(--color-text); font-size: 14px;">
                Are you sure you want to delete this item? This action cannot be undone.
            </p>
        </div>
        <div class="admin-modal-footer">
            <button type="button" class="btn btn-outline btn-sm" data-close-modal="adminDeleteModal">Cancel</button>
            <button type="button" id="confirmDeleteBtn" class="btn btn-danger btn-sm">
                <i class="fas fa-trash-alt" aria-hidden="true"></i> Yes, Delete
            </button>
        </div>
    </div>
</div>

<!-- Toast Notification Container -->
<div id="adminToastContainer" class="toast-container" aria-live="polite"></div>

<!-- Admin JavaScript Engine -->
<script src="assets/js/admin.js" defer></script>
</body>
</html>

