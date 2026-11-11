<?php
/**
 * Admin Page: Messages & Contact Inquiries
 */
require_once __DIR__ . '/includes/config.php';

$page_title = 'Messages';
$page_subtitle = 'Client Inquiries & Bespoke Requests';
$active_nav = 'messages';

$messages = get_sample_messages();

require_once __DIR__ . '/includes/header.php';
?>

<!-- Filters -->
<div class="page-action-bar">
    <div id="messageFilters" class="filter-pills">
        <button type="button" class="filter-pill active" data-status="all">All Inquiries</button>
        <button type="button" class="filter-pill" data-status="Unread">Unread</button>
        <button type="button" class="filter-pill" data-status="Read">Read</button>
        <button type="button" class="filter-pill" data-status="Replied">Replied</button>
    </div>

    <div class="search-input-wrap" style="max-width: 280px;">
        <i class="fas fa-search" aria-hidden="true"></i>
        <input type="text" id="messageSearch" class="search-input" placeholder="Search sender or subject..." />
    </div>
</div>

<!-- Messages Table -->
<section class="admin-card">
    <div class="admin-card-header">
        <div>
            <h2 class="admin-card-title">Contact Inbox</h2>
            <div class="admin-card-subtitle">Respond promptly to sizing questions and private styling inquiries</div>
        </div>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Sender</th>
                    <th>Subject</th>
                    <th>Received</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="messagesTableBody">
                <?php foreach ($messages as $msg):
                    $cls = ($msg['status'] === 'Unread') ? 'badge-warning' : (($msg['status'] === 'Replied') ? 'badge-success' : 'badge-info');
                    $blob = $msg['name'] . ' ' . $msg['email'] . ' ' . $msg['subject'];
                ?>
                    <tr data-sender="<?= e_admin($msg['name']) ?>"
                        data-status="<?= e_admin($msg['status']) ?>"
                        data-search="<?= e_admin($blob) ?>"
                        data-message="<?= e_admin(json_encode($msg)) ?>">
                        <td>
                            <span class="table-primary-text"><?= e_admin($msg['name']) ?></span>
                            <span class="table-sub-text"><?= e_admin($msg['email']) ?></span>
                        </td>
                        <td>
                            <span class="table-primary-text" style="font-weight: 500;"><?= e_admin($msg['subject']) ?></span>
                            <span class="table-sub-text"><?= e_admin(mb_strimwidth($msg['message'], 0, 72, '...')) ?></span>
                        </td>
                        <td><span class="table-sub-text"><?= e_admin($msg['date']) ?></span></td>
                        <td class="msg-status-cell"><span class="badge <?= $cls ?>"><?= e_admin($msg['status']) ?></span></td>
                        <td>
                            <div class="table-actions">
                                <button type="button" class="btn btn-outline btn-sm btn-view-message">
                                    <i class="fas fa-envelope" aria-hidden="true"></i> Read &amp; Reply
                                </button>
                                <button type="button" class="btn-icon delete btn-delete-message" title="Delete Inquiry" aria-label="Delete Inquiry">
                                    <i class="fas fa-trash-alt" aria-hidden="true"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="messagesEmptyState" class="empty-state">
        <div class="empty-state-icon"><i class="fas fa-inbox" aria-hidden="true"></i></div>
        <h3>No Inquiries Found</h3>
        <p>Your inbox is clear under this filter.</p>
    </div>
</section>

<!-- Read & Reply Modal -->
<div id="messageModal" class="admin-modal-overlay" role="dialog" aria-modal="true" aria-labelledby="msgModalTitle" aria-hidden="true">
    <div class="admin-modal">
        <div class="admin-modal-header">
            <div>
                <h2 id="msgModalTitle" class="admin-modal-title">Client Inquiry</h2>
                <div id="msgDetailDate" class="table-sub-text">—</div>
            </div>
            <button type="button" class="modal-close-btn" data-close-modal="messageModal" aria-label="Close">
                <i class="fas fa-times" aria-hidden="true"></i>
            </button>
        </div>

        <div class="admin-modal-body">
            <div class="detail-meta-grid" style="grid-template-columns: 1fr;">
                <div>
                    <span class="detail-meta-label">From</span>
                    <span id="msgDetailSender" class="detail-meta-val">—</span>
                    <div id="msgDetailContact" class="table-sub-text">—</div>
                </div>
                <div>
                    <span class="detail-meta-label">Subject</span>
                    <span id="msgDetailSubject" class="detail-meta-val">—</span>
                </div>
            </div>

            <div style="background: #FFFFFF; border: 1px solid var(--color-border); padding: 16px; border-radius: var(--radius-md); margin-bottom: 20px;">
                <p id="msgDetailBody" style="margin: 0; font-size: 13.5px; line-height: 1.7;"></p>
            </div>

            <div class="form-group">
                <label for="msgReplyInput" class="form-label">Write a Reply</label>
                <textarea id="msgReplyInput" class="form-control" placeholder="Dear client, thank you for reaching out to our atelier..."></textarea>
            </div>
        </div>

        <div class="admin-modal-footer">
            <button type="button" class="btn btn-outline btn-sm" data-close-modal="messageModal">Close</button>
            <button type="button" id="sendReplyBtn" class="btn btn-primary btn-sm">
                <i class="fas fa-check-circle" aria-hidden="true"></i> Send Reply
            </button>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/includes/footer.php';
?>

