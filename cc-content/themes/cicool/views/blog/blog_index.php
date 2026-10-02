<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$is_logged_in = function_exists('app') && isset(app()->aauth) && app()->aauth->is_loggedin();
$user_name = $is_logged_in ? get_user_data('full_name') : '';
$admin_url = $is_logged_in ? site_url('administrator/dashboard') : site_url('administrator/login');
$search_q = $this->input->get('q');
$curr_cat_id = $this->uri->segment(3) == 'category' ? $this->uri->segment(4) : null;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($title) ? $title : 'Vendio Tech Insights | Blog & Panduan Ritel Omnichannel'; ?></title>
    <meta name="description" content="Kumpulan artikel, studi kasus ritel, panduan integrasi TikTok Shop & Tokopedia, dan optimasi operasional omnichannel dari tim engineering Vendio.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --bg-canvas: #090d16;
            --bg-surface: #0f1626;
            --bg-card: rgba(18, 26, 44, 0.78);
            --bg-card-hover: rgba(24, 35, 60, 0.95);
            --border-subtle: rgba(255, 255, 255, 0.08);
            --border-medium: rgba(255, 255, 255, 0.15);
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --accent-brand: #3b82f6;
            --accent-emerald: #10b981;
            --accent-purple: #8b5cf6;
            --font-sans: 'Plus Jakarta Sans', sans-serif;
            --font-mono: 'JetBrains Mono', monospace;
            --radius-md: 10px;
            --radius-lg: 16px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: var(--font-sans);
            background-color: var(--bg-canvas);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-image: 
                radial-gradient(ellipse 80% 50% at 50% -20%, rgba(59, 130, 246, 0.12), transparent),
                radial-gradient(circle at 100% 40%, rgba(16, 185, 129, 0.04), transparent 400px);
            background-attachment: fixed;
        }

        a { color: inherit; text-decoration: none; transition: all 0.2s; }
        .container { width: 100%; max-width: 1200px; margin: 0 auto; padding: 0 24px; }
        .font-mono { font-family: var(--font-mono); }

        /* Navigation */
        .blog-nav {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(9, 13, 22, 0.9);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-subtle);
            padding: 16px 0;
        }
        .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 800;
            font-size: 1.25rem;
        }
        .brand-symbol {
            width: 34px;
            height: 34px;
            background: linear-gradient(135deg, #1e293b, #0f172a);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #60a5fa;
        }
        .nav-links-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .btn-home-link {
            font-size: 0.88rem;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 8px;
        }
        .btn-home-link:hover { color: var(--text-primary); background: rgba(255,255,255,0.05); }
        .btn-admin-cta {
            font-size: 0.85rem;
            font-weight: 600;
            background: #ffffff;
            color: #090d16;
            padding: 8px 16px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-admin-cta:hover { background: #e2e8f0; }

        /* Hero Header */
        .blog-header {
            padding: 60px 0 40px;
            text-align: center;
            border-bottom: 1px solid var(--border-subtle);
        }
        .blog-badge {
            font-family: var(--font-mono);
            font-size: 0.72rem;
            background: rgba(59, 130, 246, 0.12);
            color: #60a5fa;
            border: 1px solid rgba(59, 130, 246, 0.25);
            padding: 4px 12px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: inline-block;
            margin-bottom: 16px;
        }
        .blog-header-title {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 800;
            letter-spacing: -0.02em;
            margin-bottom: 14px;
        }
        .blog-header-desc {
            font-size: 1.05rem;
            color: var(--text-secondary);
            max-width: 650px;
            margin: 0 auto 30px;
        }

        /* Search & Filter Toolbar */
        .search-bar-wrap {
            max-width: 580px;
            margin: 0 auto;
            position: relative;
        }
        .search-input {
            width: 100%;
            height: 48px;
            padding: 0 48px 0 20px;
            background: #0f1626;
            border: 1px solid var(--border-medium);
            border-radius: 30px;
            color: var(--text-primary);
            font-size: 0.95rem;
            font-family: inherit;
            outline: none;
            transition: all 0.2s;
        }
        .search-input:focus {
            border-color: var(--accent-brand);
            box-shadow: 0 0 16px rgba(59, 130, 246, 0.3);
        }
        .search-btn {
            position: absolute;
            right: 8px;
            top: 7px;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--accent-brand);
            color: #fff;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        /* Category Filter Chips */
        .category-filter-strip {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
            margin: 32px 0 48px;
        }
        .cat-chip {
            font-size: 0.82rem;
            font-weight: 500;
            padding: 6px 16px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-subtle);
            color: var(--text-secondary);
            transition: all 0.2s;
        }
        .cat-chip:hover {
            border-color: var(--border-medium);
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.08);
        }
        .cat-chip.active {
            background: #3b82f6;
            color: #ffffff;
            border-color: #3b82f6;
            font-weight: 600;
        }

        /* Blog Grid */
        .blog-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
            margin-bottom: 60px;
        }
        .blog-card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-lg);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: all 0.25s ease;
            backdrop-filter: blur(10px);
        }
        .blog-card:hover {
            border-color: var(--border-medium);
            transform: translateY(-4px);
            box-shadow: 0 16px 32px -8px rgba(0, 0, 0, 0.5);
            background: var(--bg-card-hover);
        }
        .blog-card-img-wrap {
            width: 100%;
            height: 200px;
            background: #0f1626;
            position: relative;
            overflow: hidden;
        }
        .blog-card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .blog-card:hover .blog-card-img {
            transform: scale(1.04);
        }
        .blog-card-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #111a2e 0%, #0d1422 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #3b82f6;
            font-size: 2.2rem;
            opacity: 0.6;
        }
        .blog-card-content {
            padding: 22px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        .blog-card-category {
            font-family: var(--font-mono);
            font-size: 0.7rem;
            color: #60a5fa;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 10px;
            font-weight: 600;
        }
        .blog-card-title {
            font-size: 1.15rem;
            font-weight: 700;
            line-height: 1.4;
            color: var(--text-primary);
            margin-bottom: 10px;
        }
        .blog-card-title:hover { color: #60a5fa; }
        .blog-card-excerpt {
            font-size: 0.86rem;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 18px;
            flex-grow: 1;
        }
        .blog-card-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.78rem;
            color: var(--text-muted);
            padding-top: 14px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Empty State */
        .empty-blog-box {
            text-align: center;
            padding: 80px 20px;
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-lg);
            margin-bottom: 60px;
        }
        .empty-icon {
            font-size: 3rem;
            color: var(--text-muted);
            margin-bottom: 16px;
        }

        /* Pagination Styling */
        .pagination-wrap {
            display: flex;
            justify-content: center;
            margin-bottom: 80px;
        }
        .pagination-wrap ul.pagination {
            display: flex;
            list-style: none;
            gap: 6px;
        }
        .pagination-wrap ul.pagination li a,
        .pagination-wrap ul.pagination li span {
            padding: 8px 14px;
            border-radius: 8px;
            background: var(--bg-surface);
            border: 1px solid var(--border-subtle);
            color: var(--text-secondary);
            font-size: 0.88rem;
            font-weight: 500;
        }
        .pagination-wrap ul.pagination li.active span {
            background: #3b82f6;
            border-color: #3b82f6;
            color: #ffffff;
            font-weight: 600;
        }

        /* Footer */
        .footer-blog {
            margin-top: auto;
            border-top: 1px solid var(--border-subtle);
            padding: 30px 0;
            background: #060910;
            font-size: 0.82rem;
            color: var(--text-muted);
        }
        .footer-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        @media (max-width: 992px) {
            .blog-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 640px) {
            .blog-grid { grid-template-columns: 1fr; }
            .blog-header { padding: 40px 0 24px; }
        }
    </style>
</head>

<body>
    <!-- Top Nav -->
    <nav class="blog-nav">
        <div class="container">
            <div class="nav-inner">
                <a href="<?= site_url(); ?>" class="brand-logo">
                    <div class="brand-symbol">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <span>VENDIO<span style="font-size: 0.68rem; font-family: var(--font-mono); color: #60a5fa; margin-left: 6px; border: 1px solid rgba(59,130,246,0.3); padding: 1px 6px; border-radius: 4px;">INSIGHTS</span></span>
                </a>

                <div class="nav-links-right">
                    <a href="<?= site_url(); ?>" class="btn-home-link">
                        <i class="fa-solid fa-house"></i> Beranda Platform
                    </a>
                    <?php if ($is_logged_in): ?>
                        <a href="<?= $admin_url; ?>" class="btn-admin-cta">
                            <i class="fa-solid fa-gauge"></i> Dashboard &nbsp;→
                        </a>
                    <?php else: ?>
                        <a href="<?= site_url('administrator/login'); ?>" class="btn-admin-cta">
                            <i class="fa-solid fa-arrow-right-to-bracket"></i> Masuk Admin
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header Section -->
    <header class="blog-header">
        <div class="container">
            <span class="blog-badge"><i class="fa-solid fa-newspaper"></i> Engineering, Retail & Omnichannel Strategy</span>
            <h1 class="blog-header-title">Vendio Tech Insights</h1>
            <p class="blog-header-desc">
                Riset, panduan operasional ritel, optimasi multi-gudang, dan strategi mencegah overselling di marketplace skala besar.
            </p>

            <!-- Search Form -->
            <div class="search-bar-wrap">
                <form action="<?= site_url('blog'); ?>" method="get">
                    <input type="text" name="q" class="search-input" placeholder="Cari artikel, topik, atau kata kunci..." value="<?= _ent($search_q); ?>">
                    <button type="submit" class="search-btn" title="Cari">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
            </div>

            <!-- Categories Strip -->
            <div class="category-filter-strip">
                <a href="<?= site_url('blog'); ?>" class="cat-chip <?= empty($curr_cat_id) ? 'active' : ''; ?>">
                    Semua Topik
                </a>
                <?php if (!empty($categories) && is_array($categories)): ?>
                    <?php foreach ($categories as $cat): ?>
                        <a href="<?= site_url('blog/category/' . $cat->category_id . '/' . url_title($cat->category_name)); ?>" class="cat-chip <?= ($curr_cat_id == $cat->category_id) ? 'active' : ''; ?>">
                            <?= _ent($cat->category_name); ?>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="container" style="flex-grow: 1; padding-top: 40px;">
        <?php if (!empty($search_q)): ?>
            <div style="margin-bottom: 24px; font-size: 0.95rem; color: var(--text-secondary);">
                Menampilkan hasil pencarian untuk: <strong style="color: #60a5fa;">"<?= _ent($search_q); ?>"</strong> (<?= intval($blog_counts); ?> artikel ditemukan)
                <a href="<?= site_url('blog'); ?>" style="margin-left: 12px; color: #f87171; font-size: 0.82rem;"><i class="fa-solid fa-xmark"></i> Hapus Filter</a>
            </div>
        <?php endif; ?>

        <?php if (!empty($blogs) && count($blogs) > 0): ?>
            <div class="blog-grid">
                <?php foreach ($blogs as $item): 
                    $first_image = '';
                    if (!empty($item->image)) {
                        $imgs = explode(',', $item->image);
                        $first_image = trim($imgs[0]);
                    }
                    $image_url = !empty($first_image) ? BASE_URL . 'uploads/blog/' . $first_image : '';
                ?>
                    <article class="blog-card">
                        <a href="<?= site_url('blog/' . $item->slug); ?>" class="blog-card-img-wrap">
                            <?php if (!empty($image_url) && file_exists(FCPATH . 'uploads/blog/' . $first_image)): ?>
                                <img src="<?= $image_url; ?>" alt="<?= _ent($item->title); ?>" class="blog-card-img" loading="lazy">
                            <?php else: ?>
                                <div class="blog-card-placeholder">
                                    <i class="fa-solid fa-layer-group"></i>
                                </div>
                            <?php endif; ?>
                        </a>

                        <div class="blog-card-content">
                            <div class="blog-card-category">
                                <?= !empty($item->category_name) ? _ent($item->category_name) : 'OMNICHANNEL TECH'; ?>
                            </div>

                            <h2 class="blog-card-title">
                                <a href="<?= site_url('blog/' . $item->slug); ?>">
                                    <?= _ent($item->title); ?>
                                </a>
                            </h2>

                            <p class="blog-card-excerpt">
                                <?= function_exists('character_limiter') ? character_limiter(strip_tags($item->content), 120) : (strlen(strip_tags($item->content)) > 120 ? substr(strip_tags($item->content), 0, 120) . '...' : strip_tags($item->content)); ?>
                            </p>

                            <div class="blog-card-meta">
                                <span><i class="fa-regular fa-calendar"></i> <?= date('d M Y', strtotime($item->created_at ?: 'now')); ?></span>
                                <span class="font-mono"><i class="fa-regular fa-eye"></i> <?= intval($item->viewers); ?> views</span>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if (!empty($pagination)): ?>
                <div class="pagination-wrap">
                    <?= $pagination; ?>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <div class="empty-blog-box">
                <div class="empty-icon"><i class="fa-regular fa-folder-open"></i></div>
                <h3 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 8px;">Belum Ada Artikel yang Diterbitkan</h3>
                <p style="color: var(--text-muted); font-size: 0.92rem; max-width: 480px; margin: 0 auto 24px;">
                    Belum ada artikel yang cocok dengan filter atau kata kunci Anda. Anda dapat menambahkan artikel baru melalui portal administrator.
                </p>
                <a href="<?= site_url('administrator/blog/add'); ?>" class="btn-admin-cta">
                    <i class="fa-solid fa-pen-to-square"></i> Tulis Artikel di Portal Admin
                </a>
            </div>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer class="footer-blog">
        <div class="container">
            <div class="footer-inner">
                <div>
                    &copy; <?= date('Y'); ?> <strong>Vendio Omnichannel Platform</strong>. Publikasi & Riset Ritel.
                </div>
                <div class="font-mono">
                    <a href="<?= site_url(); ?>" style="color: var(--text-secondary); margin-right: 16px;">Platform Home</a>
                    <a href="<?= $admin_url; ?>" style="color: var(--text-secondary);">Portal Admin</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>