<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$is_logged_in = function_exists('app') && isset(app()->aauth) && app()->aauth->is_loggedin();
$admin_url = $is_logged_in ? site_url('administrator/dashboard') : site_url('administrator/login');

$images = !empty($blog->image) ? explode(',', $blog->image) : [];
$first_image = isset($images[0]) ? trim($images[0]) : '';
$image_url = !empty($first_image) ? BASE_URL . 'uploads/blog/' . $first_image : '';
$tags = !empty($blog->tags) ? explode(',', $blog->tags) : [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= _ent($blog->title); ?> | Vendio Tech Insights</title>
    <meta name="description" content="<?= (strlen(strip_tags($blog->content)) > 160 ? substr(strip_tags($blog->content), 0, 160) . '...' : strip_tags($blog->content)); ?>">
    <meta name="author" content="<?= _ent($blog->author); ?>">
    
    <!-- OpenGraph -->
    <meta property="og:title" content="<?= _ent($blog->title); ?>">
    <meta property="og:description" content="<?= character_limiter(strip_tags($blog->content), 160); ?>">
    <?php if (!empty($image_url)): ?>
        <meta property="og:image" content="<?= $image_url; ?>">
    <?php endif; ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --bg-canvas: #090d16;
            --bg-surface: #0f1626;
            --bg-card: rgba(18, 26, 44, 0.85);
            --border-subtle: rgba(255, 255, 255, 0.08);
            --border-medium: rgba(255, 255, 255, 0.15);
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --accent-brand: #3b82f6;
            --accent-emerald: #10b981;
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
            line-height: 1.7;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-image: 
                radial-gradient(ellipse 80% 50% at 50% -20%, rgba(59, 130, 246, 0.1), transparent);
            background-attachment: fixed;
        }

        a { color: inherit; text-decoration: none; transition: all 0.2s; }
        .container { width: 100%; max-width: 860px; margin: 0 auto; padding: 0 24px; }
        .font-mono { font-family: var(--font-mono); }

        /* Navigation */
        .article-nav {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(9, 13, 22, 0.92);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-subtle);
            padding: 16px 0;
        }
        .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 24px;
        }
        .brand-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            font-size: 1.2rem;
        }
        .brand-symbol {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #1e293b, #0f172a);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #60a5fa;
            font-size: 0.85rem;
        }
        .btn-back-blog {
            font-size: 0.86rem;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 8px;
            border: 1px solid var(--border-subtle);
            background: rgba(255,255,255,0.03);
        }
        .btn-back-blog:hover {
            color: var(--text-primary);
            border-color: var(--border-medium);
        }

        /* Article Header */
        .article-header {
            padding: 50px 0 30px;
        }
        .article-breadcrumbs {
            font-size: 0.82rem;
            color: var(--text-muted);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .article-breadcrumbs a:hover { color: #60a5fa; }
        .article-cat-badge {
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
            font-weight: 600;
        }
        .article-title {
            font-size: clamp(2rem, 3.8vw, 2.75rem);
            font-weight: 800;
            letter-spacing: -0.02em;
            line-height: 1.25;
            margin-bottom: 24px;
            color: var(--text-primary);
        }
        .article-meta-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            padding-bottom: 24px;
            border-bottom: 1px solid var(--border-subtle);
            font-size: 0.86rem;
            color: var(--text-muted);
        }
        .article-author-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .author-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #1e293b;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #60a5fa;
            font-weight: 700;
            border: 1px solid var(--border-medium);
        }

        /* Featured Image */
        .article-cover-wrap {
            margin: 32px 0 40px;
            border-radius: var(--radius-lg);
            overflow: hidden;
            border: 1px solid var(--border-subtle);
            box-shadow: 0 20px 40px -15px rgba(0,0,0,0.6);
            background: #0f1626;
        }
        .article-cover-img {
            width: 100%;
            max-height: 480px;
            object-fit: cover;
            display: block;
        }

        /* Article Prose / Content */
        .article-prose {
            font-size: 1.08rem;
            color: #cbd5e1;
            line-height: 1.85;
            margin-bottom: 48px;
        }
        .article-prose p {
            margin-bottom: 24px;
        }
        .article-prose h2, .article-prose h3, .article-prose h4 {
            color: var(--text-primary);
            font-weight: 700;
            letter-spacing: -0.01em;
            margin: 40px 0 16px;
            line-height: 1.35;
        }
        .article-prose h2 { font-size: 1.6rem; border-bottom: 1px solid var(--border-subtle); padding-bottom: 8px; }
        .article-prose h3 { font-size: 1.35rem; }
        .article-prose ul, .article-prose ol {
            margin: 0 0 24px 24px;
        }
        .article-prose li {
            margin-bottom: 8px;
        }
        .article-prose blockquote {
            border-left: 3px solid #3b82f6;
            padding: 12px 20px;
            background: rgba(59, 130, 246, 0.05);
            border-radius: 0 8px 8px 0;
            margin: 28px 0;
            color: #94a3b8;
            font-style: italic;
        }
        .article-prose code {
            font-family: var(--font-mono);
            font-size: 0.88em;
            background: rgba(255,255,255,0.08);
            padding: 2px 6px;
            border-radius: 4px;
            color: #93c5fd;
        }
        .article-prose img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid var(--border-subtle);
        }

        /* Tags Strip */
        .article-tags-wrap {
            padding: 24px 0;
            border-top: 1px solid var(--border-subtle);
            border-bottom: 1px solid var(--border-subtle);
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 48px;
        }
        .tag-pill {
            font-family: var(--font-mono);
            font-size: 0.78rem;
            color: #60a5fa;
            background: rgba(59, 130, 246, 0.08);
            border: 1px solid rgba(59, 130, 246, 0.2);
            padding: 4px 12px;
            border-radius: 20px;
            transition: all 0.2s;
        }
        .tag-pill:hover {
            background: rgba(59, 130, 246, 0.2);
            border-color: #3b82f6;
        }

        /* Related Articles */
        .related-section {
            padding: 40px 0 60px;
        }
        .related-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 24px;
            color: var(--text-primary);
        }
        .related-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        .related-card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-md);
            padding: 20px;
            transition: all 0.2s;
        }
        .related-card:hover {
            border-color: var(--border-medium);
            transform: translateY(-2px);
        }

        /* Footer */
        .article-footer {
            margin-top: auto;
            border-top: 1px solid var(--border-subtle);
            padding: 28px 0;
            background: #060910;
            font-size: 0.82rem;
            color: var(--text-muted);
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Top Nav -->
    <nav class="article-nav">
        <div class="nav-inner">
            <a href="<?= site_url(); ?>" class="brand-logo">
                <div class="brand-symbol">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <span>VENDIO<span style="font-size: 0.65rem; font-family: var(--font-mono); color: #60a5fa; margin-left: 6px; border: 1px solid rgba(59,130,246,0.3); padding: 1px 6px; border-radius: 4px;">INSIGHTS</span></span>
            </a>

            <div style="display: flex; align-items: center; gap: 12px;">
                <a href="<?= site_url('blog'); ?>" class="btn-back-blog">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Semua Artikel
                </a>
                <?php if ($is_logged_in): ?>
                    <a href="<?= site_url('administrator/blog/edit/' . $blog->id); ?>" style="font-size: 0.82rem; color: #fbbf24; border: 1px solid rgba(251,191,36,0.3); padding: 6px 12px; border-radius: 8px;">
                        <i class="fa-solid fa-pen-to-square"></i> Edit Artikel
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="container">
        <!-- Article Header -->
        <header class="article-header">
            <div class="article-breadcrumbs">
                <a href="<?= site_url(); ?>"><i class="fa-solid fa-house"></i> Home</a>
                <span>/</span>
                <a href="<?= site_url('blog'); ?>">Blog</a>
                <span>/</span>
                <span><?= !empty($blog->category_name) ? _ent($blog->category_name) : 'Ritel & Omnichannel'; ?></span>
            </div>

            <span class="article-cat-badge">
                <?= !empty($blog->category_name) ? _ent($blog->category_name) : 'VENDIO RESEARCH'; ?>
            </span>

            <h1 class="article-title"><?= _ent($blog->title); ?></h1>

            <div class="article-meta-row">
                <div class="article-author-info">
                    <div class="author-avatar">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div>
                        <div style="font-weight: 600; color: var(--text-primary);"><?= _ent($blog->author ?: 'Tim Vendio'); ?></div>
                        <div style="font-size: 0.78rem;"><?= date('d F Y', strtotime($blog->created_at ?: 'now')); ?></div>
                    </div>
                </div>

                <div class="font-mono" style="display: flex; align-items: center; gap: 16px;">
                    <span><i class="fa-regular fa-eye"></i> <?= intval($blog->viewers); ?> pembaca</span>
                    <span><i class="fa-regular fa-clock"></i> <?= max(2, ceil(str_word_count(strip_tags($blog->content)) / 180)); ?> menit baca</span>
                </div>
            </div>
        </header>

        <!-- Cover Image -->
        <?php if (!empty($image_url) && file_exists(FCPATH . 'uploads/blog/' . $first_image)): ?>
            <div class="article-cover-wrap">
                <img src="<?= $image_url; ?>" alt="<?= _ent($blog->title); ?>" class="article-cover-img">
            </div>
        <?php endif; ?>

        <!-- Prose Content -->
        <article class="article-prose">
            <?= $blog->content; ?>
        </article>

        <!-- Tags -->
        <?php if (!empty($tags)): ?>
            <div class="article-tags-wrap">
                <span style="font-size: 0.82rem; color: var(--text-muted);"><i class="fa-solid fa-tags"></i> Topik:</span>
                <?php foreach ($tags as $tag): 
                    $t = trim($tag);
                    if (empty($t)) continue;
                ?>
                    <a href="<?= site_url('blog/tag/' . url_title($t)); ?>" class="tag-pill">#<?= _ent($t); ?></a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Related Articles -->
        <?php if (!empty($related) && count($related) > 1): ?>
            <section class="related-section">
                <h3 class="related-title">Artikel Terkait Lainnya</h3>
                <div class="related-grid">
                    <?php 
                    $shown = 0;
                    foreach ($related as $rel): 
                        if ($rel->id == $blog->id) continue;
                        if ($shown >= 2) break;
                        $shown++;
                    ?>
                        <div class="related-card">
                            <div style="font-size: 0.72rem; font-family: var(--font-mono); color: #60a5fa; margin-bottom: 8px;">
                                <?= date('d M Y', strtotime($rel->created_at ?: 'now')); ?>
                            </div>
                            <h4 style="font-size: 1rem; font-weight: 700; line-height: 1.4; margin-bottom: 8px;">
                                <a href="<?= site_url('blog/' . $rel->slug); ?>" style="color: var(--text-primary);">
                                    <?= _ent($rel->title); ?>
                                </a>
                            </h4>
                            <p style="font-size: 0.82rem; color: var(--text-secondary); line-height: 1.5;">
                                <?= (strlen(strip_tags($rel->content)) > 90 ? substr(strip_tags($rel->content), 0, 90) . '...' : strip_tags($rel->content)); ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer class="article-footer">
        <div class="container">
            <p>&copy; <?= date('Y'); ?> <strong>Vendio Omnichannel Platform</strong>. Publikasi & Riset Ritel.</p>
        </div>
    </footer>
</body>
</html>