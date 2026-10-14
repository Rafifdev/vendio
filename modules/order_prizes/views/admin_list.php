<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
/* Modern Container and Header */
.box-op-modern {
    background: #ffffff;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    margin-bottom: 25px;
}
.box-op-modern .op-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 24px;
    border-bottom: 1px solid #edf2f7;
    flex-wrap: wrap;
    gap: 16px;
}
.box-op-modern .op-header-left {
    display: flex;
    align-items: center;
    gap: 16px;
}
.box-op-modern .op-icon-badge {
    width: 48px;
    height: 48px;
    background: #ecfdf5;
    color: #059669;
    border: 1px solid #a7f3d0;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
}
.box-op-modern .op-header-title {
    font-size: 20px;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
}
.box-op-modern .op-header-desc {
    font-size: 13px;
    color: #64748b;
    margin: 3px 0 0;
}
.box-op-modern .btn-primary-action {
    background: #00a65a;
    color: #fff !important;
    border: 1px solid #008d4c;
    border-radius: 6px;
    padding: 8px 16px;
    font-size: 13px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.15s ease;
}
.box-op-modern .btn-primary-action:hover {
    background: #008d4c;
    box-shadow: 0 2px 6px rgba(0, 166, 90, 0.25);
}

/* KPI Summary Cards */
.op-kpi-row {
    display: flex;
    gap: 14px;
    padding: 16px 24px;
    background: #f8fafc;
    border-bottom: 1px solid #edf2f7;
    flex-wrap: wrap;
}
.op-kpi-card {
    flex: 1;
    min-width: 170px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 12px 16px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
}
.op-kpi-title {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    color: #64748b;
    letter-spacing: 0.5px;
}
.op-kpi-value {
    font-size: 18px;
    font-weight: 700;
    color: #0f172a;
    margin-top: 4px;
}

/* Tabs Bar */
.op-tab-bar {
    display: flex;
    gap: 4px;
    padding: 10px 24px 0;
    border-bottom: 1px solid #e2e8f0;
    background: #ffffff;
    overflow-x: auto;
}
.op-tab-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 18px;
    font-size: 13.5px;
    font-weight: 600;
    color: #64748b;
    border-bottom: 2px solid transparent;
    text-decoration: none !important;
    transition: all 0.15s ease;
}
.op-tab-link:hover {
    color: #0f172a;
    border-bottom-color: #cbd5e1;
}
.op-tab-link.active {
    color: #00a65a;
    border-bottom-color: #00a65a;
}
.op-tab-badge {
    background: #f1f5f9;
    color: #475569;
    font-size: 11px;
    padding: 2px 7px;
    border-radius: 10px;
}
.op-tab-link.active .op-tab-badge {
    background: #ecfdf5;
    color: #059669;
}

/* Filter & Search Bar */
.op-filter-bar {
    padding: 16px 24px;
    background: #ffffff;
    border-bottom: 1px solid #edf2f7;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}
.op-filter-form {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}
.op-filter-form .form-control {
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    font-size: 13px;
    height: 34px;
    padding: 6px 12px;
}

/* Table Design */
.op-table-wrap {
    padding: 0;
    overflow-x: auto;
}
.table-op {
    width: 100%;
    margin-bottom: 0;
    border-collapse: collapse;
}
.table-op thead th {
    background: #f8fafc;
    color: #475569;
    font-size: 11.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    padding: 12px 16px;
    border-bottom: 1px solid #e2e8f0;
    border-top: none;
    white-space: nowrap;
}
.table-op tbody td {
    padding: 13px 16px;
    font-size: 13px;
    color: #1e293b;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}
.table-op tbody tr:hover {
    background: #f8fafc;
}

/* Status Badges */
.badge-status {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 9px;
    border-radius: 12px;
    font-size: 11.5px;
    font-weight: 600;
    line-height: 1;
}
.badge-active { background: #dcfce7; color: #166534; }
.badge-draft { background: #fef3c7; color: #92400e; }
.badge-paused { background: #fee2e2; color: #991b1b; }
.badge-ended { background: #f1f5f9; color: #475569; }

.badge-claimed { background: #dcfce7; color: #166534; }
.badge-pending { background: #fef3c7; color: #92400e; }
.badge-expired { background: #fee2e2; color: #991b1b; }
.badge-rejected { background: #f1f5f9; color: #475569; }

.badge-kind {
    font-size: 11px;
    font-weight: 600;
    padding: 3px 8px;
    border-radius: 4px;
    display: inline-block;
}
.badge-kind-physical { background: #e0f2fe; color: #0369a1; }
.badge-kind-voucher { background: #f3e8ff; color: #7e22ce; }
.badge-kind-none { background: #f1f5f9; color: #64748b; }

.op-mono {
    font-family: Menlo, Monaco, Consolas, monospace;
    font-size: 12px;
    background: #f1f5f9;
    padding: 2px 6px;
    border-radius: 4px;
    color: #0f172a;
}
.btn-action-icon {
    width: 30px;
    height: 30px;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    color: #475569;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    transition: all 0.15s ease;
    text-decoration: none !important;
}
.btn-action-icon:hover {
    background: #f8fafc;
    color: #0f172a;
    border-color: #cbd5e1;
}
.btn-action-delete:hover {
    background: #fef2f2;
    color: #dc2626;
    border-color: #fecaca;
}
</style>

<section class="content-header">
    <h1>
        Order Prizes
        <small>Loyalty & Spin Wheel Reward Campaign</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url(ADMIN_NAMESPACE_URL . '/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Order Prizes</li>
    </ol>
</section>

<section class="content">
    <?php if ($f_message = $this->session->flashdata('f_message')): ?>
        <div class="alert alert-<?= $this->session->flashdata('f_type') === 'error' ? 'danger' : ($this->session->flashdata('f_type') ?: 'success'); ?> alert-dismissible" style="border-radius: 6px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?= $f_message; ?>
        </div>
    <?php endif; ?>

    <div class="box-op-modern">
        <!-- Header -->
        <div class="op-header">
            <div class="op-header-left">
                <div class="op-icon-badge">
                    <i class="fa fa-gift"></i>
                </div>
                <div>
                    <h2 class="op-header-title">Order Prizes Management</h2>
                    <p class="op-header-desc">Kelola campaign hadiah belanja, threshold omset/profit, verifikasi order, dan klaim pemenang.</p>
                </div>
            </div>
            <div>
                <?php if ($can_manage): ?>
                    <?php if ($active_tab === 'campaigns'): ?>
                        <a href="<?= site_url(ADMIN_NAMESPACE_URL . '/order_prizes/campaign_add'); ?>" class="btn btn-primary-action">
                            <i class="fa fa-plus"></i> Tambah Campaign Baru
                        </a>
                    <?php elseif ($active_tab === 'prizes'): ?>
                        <a href="<?= site_url(ADMIN_NAMESPACE_URL . '/order_prizes/prize_add'); ?>" class="btn btn-primary-action">
                            <i class="fa fa-plus"></i> Tambah Hadiah Baru
                        </a>
                    <?php elseif ($active_tab === 'orders'): ?>
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-import-csv" style="margin-right: 6px; border-radius: 6px; font-weight: 600;">
                            <i class="fa fa-file-excel-o text-green"></i> Import CSV
                        </button>
                        <a href="<?= site_url(ADMIN_NAMESPACE_URL . '/order_prizes/order_add'); ?>" class="btn btn-primary-action">
                            <i class="fa fa-plus"></i> Tambah Order Manual
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- KPI Metrics Summary -->
        <div class="op-kpi-row">
            <div class="op-kpi-card">
                <div class="op-kpi-title">Total Campaign</div>
                <div class="op-kpi-value"><?= number_format($stats['total_campaigns']); ?> <small style="font-size: 12px; color: #16a34a; font-weight: 600;">(<?= $stats['active_campaigns']; ?> Aktif)</small></div>
            </div>
            <div class="op-kpi-card">
                <div class="op-kpi-title">Total Varian Hadiah</div>
                <div class="op-kpi-value"><?= number_format($stats['total_prizes']); ?></div>
            </div>
            <div class="op-kpi-card">
                <div class="op-kpi-title">Pesanan Terverifikasi</div>
                <div class="op-kpi-value"><?= number_format($stats['total_orders']); ?></div>
            </div>
            <div class="op-kpi-card">
                <div class="op-kpi-title">Total Spin Selesai</div>
                <div class="op-kpi-value"><?= number_format($stats['total_spins']); ?></div>
            </div>
            <div class="op-kpi-card">
                <div class="op-kpi-title">Omset Masuk (Spin)</div>
                <div class="op-kpi-value" style="color: #059669;">Rp <?= number_format($stats['total_revenue'], 0, ',', '.'); ?></div>
            </div>
        </div>

        <!-- Tab Bar Navigation -->
        <div class="op-tab-bar">
            <a href="<?= site_url(ADMIN_NAMESPACE_URL . '/order_prizes/tab/campaigns'); ?>" class="op-tab-link <?= $active_tab === 'campaigns' ? 'active' : ''; ?>">
                <i class="fa fa-bullhorn"></i> 1. Campaigns
                <span class="op-tab-badge"><?= $active_tab === 'campaigns' ? $records['total'] : $stats['total_campaigns']; ?></span>
            </a>
            <a href="<?= site_url(ADMIN_NAMESPACE_URL . '/order_prizes/tab/prizes'); ?>" class="op-tab-link <?= $active_tab === 'prizes' ? 'active' : ''; ?>">
                <i class="fa fa-gift"></i> 2. Hadiah & Threshold
                <span class="op-tab-badge"><?= $active_tab === 'prizes' ? $records['total'] : $stats['total_prizes']; ?></span>
            </a>
            <a href="<?= site_url(ADMIN_NAMESPACE_URL . '/order_prizes/tab/orders'); ?>" class="op-tab-link <?= $active_tab === 'orders' ? 'active' : ''; ?>">
                <i class="fa fa-shopping-cart"></i> 3. Order Terverifikasi
                <span class="op-tab-badge"><?= $active_tab === 'orders' ? $records['total'] : $stats['total_orders']; ?></span>
            </a>
            <a href="<?= site_url(ADMIN_NAMESPACE_URL . '/order_prizes/tab/spins'); ?>" class="op-tab-link <?= $active_tab === 'spins' ? 'active' : ''; ?>">
                <i class="fa fa-trophy"></i> 4. Riwayat Spin & Klaim
                <span class="op-tab-badge"><?= $active_tab === 'spins' ? $records['total'] : $stats['total_spins']; ?></span>
            </a>
            <a href="<?= site_url(ADMIN_NAMESPACE_URL . '/order_prizes/tab/audit'); ?>" class="op-tab-link <?= $active_tab === 'audit' ? 'active' : ''; ?>">
                <i class="fa fa-history"></i> 5. Audit Log
            </a>
        </div>

        <!-- Filter Bar -->
        <div class="op-filter-bar">
            <form method="GET" action="<?= site_url(ADMIN_NAMESPACE_URL . '/order_prizes/tab/' . $active_tab); ?>" class="op-filter-form">
                <input type="text" name="q" class="form-control" placeholder="Cari nama / no order / nomor HP..." value="<?= html_escape($filters['q'] ?? ''); ?>" style="min-width: 260px;">

                <?php if (in_array($active_tab, ['prizes', 'orders', 'spins'], true)): ?>
                    <select name="campaign_id" class="form-control">
                        <option value="">Semua Campaign</option>
                        <?php foreach ($campaigns_dropdown as $c): ?>
                            <option value="<?= $c['id']; ?>" <?= ($filters['campaign_id'] ?? '') == $c['id'] ? 'selected' : ''; ?>>
                                #<?= $c['id']; ?> - <?= html_escape($c['name']); ?> (<?= strtoupper($c['channel']); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>

                <?php if ($active_tab === 'campaigns'): ?>
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="draft" <?= ($filters['status'] ?? '') === 'draft' ? 'selected' : ''; ?>>Draft</option>
                        <option value="active" <?= ($filters['status'] ?? '') === 'active' ? 'selected' : ''; ?>>Active</option>
                        <option value="paused" <?= ($filters['status'] ?? '') === 'paused' ? 'selected' : ''; ?>>Paused</option>
                        <option value="ended" <?= ($filters['status'] ?? '') === 'ended' ? 'selected' : ''; ?>>Ended</option>
                    </select>
                <?php elseif ($active_tab === 'spins'): ?>
                    <select name="claim_status" class="form-control">
                        <option value="">Semua Status Klaim</option>
                        <option value="pending" <?= ($filters['claim_status'] ?? '') === 'pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="claimed" <?= ($filters['claim_status'] ?? '') === 'claimed' ? 'selected' : ''; ?>>Claimed</option>
                        <option value="expired" <?= ($filters['claim_status'] ?? '') === 'expired' ? 'selected' : ''; ?>>Expired</option>
                        <option value="rejected" <?= ($filters['claim_status'] ?? '') === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                    </select>
                <?php endif; ?>

                <button type="submit" class="btn btn-default" style="border-radius: 6px; height: 34px;">
                    <i class="fa fa-search"></i> Filter
                </button>
                <?php if (!empty($filters['q']) || !empty($filters['campaign_id']) || !empty($filters['status']) || !empty($filters['claim_status'])): ?>
                    <a href="<?= site_url(ADMIN_NAMESPACE_URL . '/order_prizes/tab/' . $active_tab); ?>" class="btn btn-default" style="border-radius: 6px; height: 34px;" title="Reset Filter">
                        <i class="fa fa-times text-danger"></i>
                    </a>
                <?php endif; ?>
            </form>
            <div style="font-size: 13px; color: #64748b;">
                Total <strong><?= number_format($records['total']); ?></strong> data
            </div>
        </div>

        <!-- Table Content -->
        <div class="op-table-wrap">
            <?php if ($active_tab === 'campaigns'): ?>
                <!-- 1. CAMPAIGNS TABLE -->
                <table class="table-op">
                    <thead>
                        <tr>
                            <th width="40">ID</th>
                            <th>Nama Campaign</th>
                            <th>Channel & Toko</th>
                            <th>Periode</th>
                            <th>Status</th>
                            <th>Statistik Spin</th>
                            <th>Omset / Profit</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($records['items'])): ?>
                            <tr><td colspan="8" class="text-center" style="padding: 30px; color: #94a3b8;">Belum ada campaign. Klik tombol <strong>Tambah Campaign Baru</strong> di atas.</td></tr>
                        <?php else: foreach ($records['items'] as $item): ?>
                            <tr>
                                <td>#<?= $item['id']; ?></td>
                                <td>
                                    <strong style="color: #0f172a; font-size: 14px;"><?= html_escape($item['name']); ?></strong>
                                    <div style="margin-top: 4px;">
                                        <a href="<?= site_url('order_prizes?campaign=' . urlencode($item['slug'])); ?>" target="_blank" class="op-mono" style="color: #0284c7; text-decoration: none;">
                                            <i class="fa fa-external-link"></i> /order_prizes?campaign=<?= html_escape($item['slug']); ?>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge" style="background: #f1f5f9; color: #334155; text-transform: uppercase;"><?= html_escape($item['channel']); ?></span>
                                    <div style="font-size: 12px; color: #64748b; margin-top: 2px;"><?= html_escape($item['shop_ref']); ?></div>
                                </td>
                                <td style="font-size: 12px; color: #475569;">
                                    <div><?= date('d M Y H:i', strtotime($item['starts_at'])); ?></div>
                                    <div style="color: #94a3b8;">s/d <?= date('d M Y H:i', strtotime($item['ends_at'])); ?></div>
                                    <div style="color: #64748b; font-size: 11px;">Masa klaim: <?= $item['claim_days']; ?> hari</div>
                                </td>
                                <td>
                                    <span class="badge-status badge-<?= $item['status']; ?>">
                                        <i class="fa fa-circle" style="font-size: 8px;"></i> <?= ucfirst($item['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <strong><?= number_format($item['spin_count']); ?></strong> spin
                                    <div style="font-size: 11.5px; color: #64748b;">Biaya Hadiah: Rp <?= number_format($item['awarded_cost'], 0, ',', '.'); ?></div>
                                </td>
                                <td>
                                    <div style="color: #059669; font-weight: 600;">Rp <?= number_format($item['revenue_total'], 0, ',', '.'); ?></div>
                                    <div style="font-size: 11.5px; color: #64748b;">Profit: Rp <?= number_format($item['profit_total'], 0, ',', '.'); ?></div>
                                </td>
                                <td class="text-center">
                                    <div style="display: inline-flex; gap: 6px;">
                                        <a href="<?= site_url(ADMIN_NAMESPACE_URL . '/order_prizes/prize_add?campaign_id=' . $item['id']); ?>" class="btn-action-icon" title="Tambah Hadiah">
                                            <i class="fa fa-gift text-green"></i>
                                        </a>
                                        <a href="<?= site_url(ADMIN_NAMESPACE_URL . '/order_prizes/campaign_edit/' . $item['id']); ?>" class="btn-action-icon" title="Edit Campaign">
                                            <i class="fa fa-pencil text-blue"></i>
                                        </a>
                                        <?php if ($can_manage): ?>
                                            <button type="button" class="btn-action-icon btn-action-delete" title="Hapus / Nonaktifkan" onclick="deleteRecord('campaigns', <?= $item['id']; ?>, '<?= html_escape($item['name']); ?>')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>

            <?php elseif ($active_tab === 'prizes'): ?>
                <!-- 2. PRIZES TABLE -->
                <table class="table-op">
                    <thead>
                        <tr>
                            <th width="40">ID</th>
                            <th>Nama Hadiah</th>
                            <th>Campaign</th>
                            <th>Jenis</th>
                            <th>Bobot / Peluang</th>
                            <th>Sisa Stok</th>
                            <th>Biaya Hadiah</th>
                            <th>Threshold (Syarat Muncul)</th>
                            <th>Keluar</th>
                            <th>Status</th>
                            <th width="100" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($records['items'])): ?>
                            <tr><td colspan="11" class="text-center" style="padding: 30px; color: #94a3b8;">Belum ada hadiah. Klik tombol <strong>Tambah Hadiah Baru</strong> di atas.</td></tr>
                        <?php else: foreach ($records['items'] as $item): ?>
                            <tr>
                                <td>#<?= $item['id']; ?></td>
                                <td>
                                    <strong style="color: #0f172a; font-size: 13.5px;"><?= html_escape($item['name']); ?></strong>
                                    <?php if (!empty($item['description'])): ?>
                                        <div style="font-size: 11.5px; color: #64748b;"><?= html_escape($item['description']); ?></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge" style="background: #f1f5f9; color: #334155;">#<?= $item['campaign_id']; ?></span>
                                </td>
                                <td>
                                    <span class="badge-kind badge-kind-<?= $item['kind']; ?>">
                                        <?= ucfirst($item['kind'] === 'none' ? 'Zonk (Fallback)' : $item['kind']); ?>
                                    </span>
                                </td>
                                <td>
                                    <strong>Bobot: <?= number_format($item['weight']); ?></strong>
                                </td>
                                <td>
                                    <?php if ($item['stock'] === null): ?>
                                        <span class="label label-info"><i class="fa fa-infinity"></i> Unlimited</span>
                                    <?php elseif ($item['stock'] <= 0): ?>
                                        <span class="label label-danger">Habis (0)</span>
                                    <?php else: ?>
                                        <strong style="color: #059669;"><?= number_format($item['stock']); ?></strong> pcs
                                    <?php endif; ?>
                                </td>
                                <td>
                                    Rp <?= number_format($item['cost'], 0, ',', '.'); ?>
                                </td>
                                <td style="font-size: 11.5px; color: #475569;">
                                    <?php if ($item['auto_metric'] !== 'none'): ?>
                                        <span class="badge" style="background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe;">
                                            Auto <?= ucfirst($item['auto_metric']); ?> (<?= $item['allocation_percent']; ?>%)
                                        </span>
                                    <?php elseif ($item['threshold_spins'] == 0 && $item['threshold_revenue'] == 0 && $item['threshold_profit'] == 0): ?>
                                        <span class="text-muted"><i class="fa fa-check text-green"></i> Tanpa Syarat (Terbuka)</span>
                                    <?php else: ?>
                                        <?php if ($item['threshold_spins'] > 0): ?><div>• Tiap <?= number_format($item['threshold_spins']); ?> spin</div><?php endif; ?>
                                        <?php if ($item['threshold_revenue'] > 0): ?><div>• Omset: Rp <?= number_format($item['threshold_revenue'], 0, ',', '.'); ?></div><?php endif; ?>
                                        <?php if ($item['threshold_profit'] > 0): ?><div>• Profit: Rp <?= number_format($item['threshold_profit'], 0, ',', '.'); ?></div><?php endif; ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?= number_format($item['awarded_count']); ?></strong> kali
                                </td>
                                <td>
                                    <?php if ($item['active']): ?>
                                        <span class="badge-status badge-active"><i class="fa fa-check"></i> Aktif</span>
                                    <?php else: ?>
                                        <span class="badge-status badge-ended">Non-Aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div style="display: inline-flex; gap: 6px;">
                                        <a href="<?= site_url(ADMIN_NAMESPACE_URL . '/order_prizes/prize_edit/' . $item['id']); ?>" class="btn-action-icon" title="Edit Hadiah">
                                            <i class="fa fa-pencil text-blue"></i>
                                        </a>
                                        <?php if ($can_manage): ?>
                                            <button type="button" class="btn-action-icon btn-action-delete" title="Hapus / Nonaktifkan" onclick="deleteRecord('prizes', <?= $item['id']; ?>, '<?= html_escape($item['name']); ?>')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>

            <?php elseif ($active_tab === 'orders'): ?>
                <!-- 3. ORDERS TABLE -->
                <table class="table-op">
                    <thead>
                        <tr>
                            <th width="40">ID</th>
                            <th>No. Pesanan</th>
                            <th>Campaign</th>
                            <th>Nomor HP</th>
                            <th>Status Order</th>
                            <th>Omset (Revenue)</th>
                            <th>Profit</th>
                            <th>Waktu Order</th>
                            <th>Status Spin</th>
                            <th width="80" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($records['items'])): ?>
                            <tr><td colspan="10" class="text-center" style="padding: 30px; color: #94a3b8;">Belum ada pesanan terverifikasi. Gunakan <strong>Tambah Order Manual</strong> atau <strong>Import CSV</strong>.</td></tr>
                        <?php else: foreach ($records['items'] as $item): ?>
                            <tr>
                                <td>#<?= $item['id']; ?></td>
                                <td>
                                    <strong class="op-mono"><?= html_escape($item['order_number']); ?></strong>
                                    <div style="font-size: 11px; color: #64748b; margin-top: 2px;">Via: <?= strtoupper($item['channel']); ?> (<?= html_escape($item['shop_ref']); ?>)</div>
                                </td>
                                <td>
                                    <span class="badge" style="background: #f1f5f9; color: #334155;">#<?= $item['campaign_id']; ?></span>
                                </td>
                                <td>
                                    <span><?= html_escape($item['phone']); ?></span>
                                    <a href="https://wa.me/<?= preg_replace('/^0/', '62', $item['phone']); ?>" target="_blank" style="margin-left: 4px; color: #16a34a;" title="Chat WhatsApp">
                                        <i class="fa fa-whatsapp"></i>
                                    </a>
                                </td>
                                <td>
                                    <span class="badge-status <?= in_array($item['status'], ['completed','paid']) ? 'badge-active' : 'badge-ended'; ?>">
                                        <?= ucfirst($item['status']); ?>
                                    </span>
                                </td>
                                <td style="font-weight: 600; color: #0f172a;">
                                    Rp <?= number_format($item['revenue'], 0, ',', '.'); ?>
                                </td>
                                <td style="color: #64748b;">
                                    <?= $item['profit'] !== null ? 'Rp ' . number_format($item['profit'], 0, ',', '.') : '—'; ?>
                                </td>
                                <td style="font-size: 12px; color: #64748b;">
                                    <?= date('d M Y H:i', strtotime($item['ordered_at'])); ?>
                                </td>
                                <td>
                                    <!-- Spin status checking -->
                                    <span class="label label-default">Siap Spin</span>
                                </td>
                                <td class="text-center">
                                    <div style="display: inline-flex; gap: 6px;">
                                        <a href="<?= site_url(ADMIN_NAMESPACE_URL . '/order_prizes/order_edit/' . $item['id']); ?>" class="btn-action-icon" title="Edit Order">
                                            <i class="fa fa-pencil text-blue"></i>
                                        </a>
                                        <?php if ($can_manage): ?>
                                            <button type="button" class="btn-action-icon btn-action-delete" title="Hapus Order" onclick="deleteRecord('orders', <?= $item['id']; ?>, '<?= html_escape($item['order_number']); ?>')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>

            <?php elseif ($active_tab === 'spins'): ?>
                <!-- 4. SPINS & CLAIMS TABLE -->
                <table class="table-op">
                    <thead>
                        <tr>
                            <th width="40">ID</th>
                            <th>No. Pesanan & HP</th>
                            <th>Hadiah Dimenangkan</th>
                            <th>Waktu Spin</th>
                            <th>Status Klaim</th>
                            <th>Status Hadiah</th>
                            <th>Follow-up</th>
                            <th>Broadcast</th>
                            <th width="110" class="text-center">Kelola</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($records['items'])): ?>
                            <tr><td colspan="9" class="text-center" style="padding: 30px; color: #94a3b8;">Belum ada customer yang melakukan spin.</td></tr>
                        <?php else: foreach ($records['items'] as $item): ?>
                            <tr>
                                <td>#<?= $item['id']; ?></td>
                                <td>
                                    <strong class="op-mono"><?= html_escape($item['order_number']); ?></strong>
                                    <div style="margin-top: 3px;">
                                        <?= html_escape($item['phone']); ?>
                                        <a href="https://wa.me/<?= preg_replace('/^0/', '62', $item['phone']); ?>" target="_blank" style="margin-left: 4px; color: #16a34a;" title="Chat WhatsApp Customer">
                                            <i class="fa fa-whatsapp"></i> Chat
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <strong style="color: #0f172a;"><?= html_escape($item['prize_name']); ?></strong>
                                    <div style="font-size: 11px; color: #64748b;">Biaya: Rp <?= number_format($item['prize_cost'], 0, ',', '.'); ?></div>
                                </td>
                                <td style="font-size: 12px; color: #475569;">
                                    <?= date('d M Y H:i', strtotime($item['spun_at'])); ?>
                                    <div style="font-size: 11px; color: #94a3b8;">Deadline: <?= date('d M H:i', strtotime($item['claim_deadline'])); ?></div>
                                </td>
                                <td>
                                    <span class="badge-status badge-<?= $item['claim_status']; ?>">
                                        <?= ucfirst($item['claim_status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge" style="background: #f1f5f9; color: #334155; font-size: 11.5px;">
                                        <?= ucfirst($item['prize_status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="label label-<?= $item['follow_up_status'] === 'closed' ? 'success' : 'default'; ?>">
                                        <?= ucfirst($item['follow_up_status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="label label-<?= $item['broadcast_status'] === 'sent' ? 'success' : 'default'; ?>">
                                        <?= ucfirst($item['broadcast_status']); ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-xs btn-primary" onclick="openFulfillmentModal(<?= html_escape(json_encode($item)); ?>)" style="border-radius: 4px; font-weight: 600;">
                                        <i class="fa fa-truck"></i> Kelola Hadiah
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>

            <?php elseif ($active_tab === 'audit'): ?>
                <!-- 5. AUDIT LOG TABLE -->
                <table class="table-op">
                    <thead>
                        <tr>
                            <th width="40">ID</th>
                            <th>Waktu</th>
                            <th>Aktor (User ID)</th>
                            <th>Aksi</th>
                            <th>Entitas</th>
                            <th>ID Target</th>
                            <th>Detail Perubahan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($records['items'])): ?>
                            <tr><td colspan="7" class="text-center" style="padding: 30px; color: #94a3b8;">Belum ada rekaman audit.</td></tr>
                        <?php else: foreach ($records['items'] as $item): ?>
                            <tr>
                                <td>#<?= $item['id']; ?></td>
                                <td style="font-size: 12px; color: #475569; white-space: nowrap;">
                                    <?= date('d M Y H:i:s', strtotime($item['created_at'])); ?>
                                </td>
                                <td>
                                    <?= $item['actor_id'] ? 'User #' . $item['actor_id'] : '<span class="text-muted">System / Public</span>'; ?>
                                </td>
                                <td>
                                    <span class="op-mono" style="font-weight: 600; color: #0369a1;"><?= html_escape($item['action']); ?></span>
                                </td>
                                <td><span class="badge" style="background: #f1f5f9; color: #334155;"><?= html_escape($item['entity']); ?></span></td>
                                <td>#<?= $item['entity_id']; ?></td>
                                <td>
                                    <button type="button" class="btn btn-xs btn-default" onclick="showAuditDetail(<?= html_escape(json_encode($item['detail_json'])); ?>)">
                                        <i class="fa fa-eye"></i> Lihat JSON
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <div style="padding: 16px 24px; border-top: 1px solid #edf2f7; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
            <div style="font-size: 13px; color: #64748b;">
                Menampilkan halaman <strong><?= $records['page']; ?></strong> dari <strong><?= max(1, ceil($records['total'] / $records['limit'])); ?></strong>
            </div>
            <div>
                <?php
                    $total_pages = max(1, ceil($records['total'] / $records['limit']));
                    $current_page = $records['page'];
                ?>
                <div class="btn-group">
                    <?php if ($current_page > 1): ?>
                        <a href="<?= site_url(ADMIN_NAMESPACE_URL . '/order_prizes/tab/' . $active_tab . '?' . http_build_query(array_merge($filters, ['page' => $current_page - 1]))); ?>" class="btn btn-default btn-sm">
                            <i class="fa fa-chevron-left"></i> Sebelumnya
                        </a>
                    <?php endif; ?>
                    <?php if ($current_page < $total_pages): ?>
                        <a href="<?= site_url(ADMIN_NAMESPACE_URL . '/order_prizes/tab/' . $active_tab . '?' . http_build_query(array_merge($filters, ['page' => $current_page + 1]))); ?>" class="btn btn-default btn-sm">
                            Berikutnya <i class="fa fa-chevron-right"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- MODAL KELOLA FULFILLMENT & RESI            -->
<!-- ========================================== -->
<div class="modal fade" id="modal-fulfillment" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header" style="border-bottom: 1px solid #edf2f7; padding: 18px 24px;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-weight: 700; color: #0f172a;"><i class="fa fa-truck text-green"></i> Kelola Hadiah & Pengiriman Pemenang</h4>
            </div>
            <form id="form-fulfillment">
                <input type="hidden" name="spin_id" id="ful-spin-id">
                <div class="modal-body" style="padding: 24px;">
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 14px; margin-bottom: 18px;">
                        <div style="font-size: 12px; color: #64748b; text-transform: uppercase; font-weight: 600;">Data Pemenang</div>
                        <div style="font-size: 15px; font-weight: 700; color: #0f172a; margin-top: 4px;" id="ful-prize-name"></div>
                        <div style="font-size: 13px; color: #475569; margin-top: 4px;">
                            No. Pesanan: <strong class="op-mono" id="ful-order-number"></strong> | HP: <span id="ful-phone"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Status Klaim Customer</label>
                            <select name="claim_status" id="ful-claim-status" class="form-control">
                                <option value="pending">Pending</option>
                                <option value="claimed">Claimed (Sudah Diklaim)</option>
                                <option value="expired">Expired (Lewat Batas)</option>
                                <option value="rejected">Rejected (Ditolak)</option>
                                <option value="not_required">Not Required (Zonk)</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Status Pengiriman Hadiah</label>
                            <select name="prize_status" id="ful-prize-status" class="form-control">
                                <option value="reserved">Reserved (Disiapkan)</option>
                                <option value="processing">Processing (Diproses)</option>
                                <option value="sent">Sent (Terkirim)</option>
                                <option value="delivered">Delivered (Diterima)</option>
                                <option value="void">Void (Dibatalkan)</option>
                                <option value="not_required">Not Required</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Status Follow-up CS</label>
                            <select name="follow_up_status" id="ful-followup-status" class="form-control">
                                <option value="pending">Pending</option>
                                <option value="contacted">Contacted (Sudah Dihubungi)</option>
                                <option value="closed">Closed (Selesai)</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Status Broadcast</label>
                            <select name="broadcast_status" id="ful-broadcast-status" class="form-control">
                                <option value="not_sent">Not Sent</option>
                                <option value="queued">Queued</option>
                                <option value="sent">Sent</option>
                                <option value="failed">Failed</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Catatan / Nomor Resi / Kode Voucher / Alasan</label>
                        <textarea name="notes" id="ful-notes" class="form-control" rows="3" placeholder="Masukkan nomor resi pengiriman, kode voucher diskon, atau alasan penolakan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #edf2f7; padding: 16px 24px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="btn-save-fulfillment">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL IMPORT ORDER CSV                     -->
<!-- ========================================== -->
<div class="modal fade" id="modal-import-csv" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header" style="border-bottom: 1px solid #edf2f7; padding: 18px 24px;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-weight: 700; color: #0f172a;"><i class="fa fa-file-excel-o text-green"></i> Import Order Terverifikasi (CSV)</h4>
            </div>
            <form id="form-import-csv" enctype="multipart/form-data">
                <div class="modal-body" style="padding: 24px;">
                    <p style="font-size: 13px; color: #475569; line-height: 1.6;">
                        Unggah file CSV berisi pesanan pembeli yang berhak melakukan spin. Format file harus memiliki header persis berikut:
                    </p>
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 14px; margin-bottom: 16px;">
                        <code style="font-size: 12px; color: #0f172a;">order_number,phone,status,revenue,profit,ordered_at</code>
                        <div style="margin-top: 6px;">
                            <a href="<?= base_url('docs/order_prizes_orders_template.csv'); ?>" download class="btn btn-xs btn-default">
                                <i class="fa fa-download"></i> Unduh File Template CSV
                            </a>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Pilih Target Campaign <span class="text-danger">*</span></label>
                        <select name="campaign_id" class="form-control" required>
                            <option value="">-- Pilih Campaign --</option>
                            <?php foreach ($campaigns_dropdown as $c): ?>
                                <option value="<?= $c['id']; ?>">#<?= $c['id']; ?> - <?= html_escape($c['name']); ?> (<?= strtoupper($c['channel']); ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Pilih File CSV (.csv) <span class="text-danger">*</span></label>
                        <input type="file" name="file" accept=".csv,text/csv" class="form-control" required>
                        <small class="text-muted">Maksimal 1000 baris / 2 MB. Duplicate nomor pesanan akan menolak seluruh batch.</small>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #edf2f7; padding: 16px 24px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btn-submit-csv">Mulai Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL AUDIT DETAIL JSON                    -->
<!-- ========================================== -->
<div class="modal fade" id="modal-audit-json" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header" style="border-bottom: 1px solid #edf2f7; padding: 18px 24px;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-weight: 700; color: #0f172a;"><i class="fa fa-code text-blue"></i> Detail Keputusan & Audit Snapshot</h4>
            </div>
            <div class="modal-body" style="padding: 20px;">
                <pre id="audit-json-content" style="background: #0f172a; color: #38bdf8; padding: 16px; border-radius: 6px; max-height: 450px; overflow: auto; font-size: 12px;"></pre>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #edf2f7; padding: 14px 20px;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
var CSRF_NAME = '<?= $this->security->get_csrf_token_name(); ?>';
var CSRF_HASH = '<?= $this->security->get_csrf_hash(); ?>';
var BASE_ADMIN = '<?= site_url(ADMIN_NAMESPACE_URL . "/order_prizes"); ?>';

function showAuditDetail(jsonStr) {
    try {
        var parsed = typeof jsonStr === 'string' ? JSON.parse(jsonStr) : jsonStr;
        $('#audit-json-content').text(JSON.stringify(parsed, null, 2));
    } catch(e) {
        $('#audit-json-content').text(jsonStr);
    }
    $('#modal-audit-json').modal('show');
}

function openFulfillmentModal(spin) {
    $('#ful-spin-id').val(spin.id);
    $('#ful-prize-name').text(spin.prize_name);
    $('#ful-order-number').text(spin.order_number);
    $('#ful-phone').text(spin.phone);
    $('#ful-claim-status').val(spin.claim_status);
    $('#ful-prize-status').val(spin.prize_status);
    $('#ful-followup-status').val(spin.follow_up_status);
    $('#ful-broadcast-status').val(spin.broadcast_status);
    $('#ful-notes').val(spin.notes || '');
    $('#modal-fulfillment').modal('show');
}

$('#form-fulfillment').on('submit', function(e) {
    e.preventDefault();
    var spinId = $('#ful-spin-id').val();
    var formData = new FormData(this);
    formData.append(CSRF_NAME, CSRF_HASH);

    $('#btn-save-fulfillment').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

    $.ajax({
        url: BASE_ADMIN + '/fulfill/' + spinId,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(res) {
            if (res.csrf) CSRF_HASH = res.csrf.hash;
            if (res.success) {
                $('#modal-fulfillment').modal('hide');
                swal({
                    title: 'Berhasil!',
                    text: 'Status fulfillment berhasil diperbarui.',
                    type: 'success',
                    timer: 1500,
                    showConfirmButton: false
                });
                setTimeout(function() { location.reload(); }, 1200);
            } else {
                swal('Perhatian', res.message || 'Gagal menyimpan.', 'warning');
            }
        },
        error: function(xhr) {
            var msg = 'Terjadi kesalahan sistem.';
            if (xhr.status === 403) {
                msg = 'Sesi atau token keamanan (CSRF) tidak valid / kedaluwarsa. Silakan refresh halaman (F5).';
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message;
            }
            swal('Error', msg, 'error');
        },
        complete: function() {
            $('#btn-save-fulfillment').prop('disabled', false).html('Simpan Perubahan');
        }
    });
});

$('#form-import-csv').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    formData.append(CSRF_NAME, CSRF_HASH);

    $('#btn-submit-csv').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Mengimpor...');

    $.ajax({
        url: BASE_ADMIN + '/import_orders',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(res) {
            if (res.csrf) CSRF_HASH = res.csrf.hash;
            if (res.success) {
                $('#modal-import-csv').modal('hide');
                swal({
                    title: 'Sukses!',
                    text: (res.data.imported || 0) + ' order berhasil diimpor.',
                    type: 'success'
                }, function() {
                    location.reload();
                });
            } else {
                swal('Gagal Import', res.message || 'File tidak valid.', 'error');
            }
        },
        error: function(xhr) {
            var msg = 'Terjadi kesalahan sistem saat mengimpor.';
            if (xhr.status === 403) {
                msg = 'Sesi atau token keamanan (CSRF) tidak valid / kedaluwarsa. Silakan refresh halaman (F5).';
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message;
            }
            swal('Gagal Import', msg, 'error');
        },
        complete: function() {
            $('#btn-submit-csv').prop('disabled', false).html('Mulai Import');
        }
    });
});

function deleteRecord(entity, id, title) {
    swal({
        title: 'Hapus / Nonaktifkan?',
        text: 'Anda akan menghapus data "' + title + '" (#' + id + ').',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Lanjutkan!',
        cancelButtonText: 'Batal'
    }, function(isConfirm) {
        if (!isConfirm) return;

        var data = {};
        data[CSRF_NAME] = CSRF_HASH;

        $.ajax({
            url: BASE_ADMIN + '/delete/' + entity + '/' + id,
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(res) {
                if (res.csrf) CSRF_HASH = res.csrf.hash;
                if (res.success) {
                    swal({
                        title: 'Berhasil',
                        text: res.data.message || 'Data berhasil diproses.',
                        type: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    setTimeout(function() { location.reload(); }, 1200);
                } else {
                    swal('Gagal', res.message || 'Tidak dapat menghapus.', 'error');
                }
            },
            error: function(xhr) {
                var msg = 'Gagal menghapus data.';
                if (xhr.status === 403) {
                    msg = 'Sesi atau token keamanan (CSRF) tidak valid / kedaluwarsa. Silakan refresh halaman (F5).';
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                swal('Error', msg, 'error');
            }
        });
    });
}
</script>
