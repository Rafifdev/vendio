<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$is_logged_in = function_exists('app') && isset(app()->aauth) && app()->aauth->is_loggedin();
$admin_url = $is_logged_in ? site_url('administrator/dashboard') : site_url('administrator/login');

$images = !empty($blog->image) ? explode(',', $blog->image) : [];
$first_image = isset($images[0]) ? trim($images[0]) : '';
$image_url = !empty($first_image) ? BASE_URL . 'uploads/blog/' . $first_image : '';
$tags = !empty($blog->tags) ? explode(',', $blog->tags) : [];

// Extract and structure Headings for Daftar Isi (Table of Contents)
$toc_tree = [];
$counter = 1;

$processed_content = preg_replace_callback('/<(h[2-3])([^>]*)>(.*?)<\/\1>/si', function($matches) use (&$counter, &$toc_tree) {
    $tag = strtolower($matches[1]);
    $attrs = $matches[2];
    $inner_html = $matches[3];
    $clean_text = trim(html_entity_decode(strip_tags($inner_html)));
    
    // Check if tag already has an id
    if (preg_match('/id=["\']([^"\']+)["\']/i', $attrs, $id_match)) {
        $heading_id = $id_match[1];
    } else {
        $heading_id = 'heading-' . $counter++;
        $attrs = ' id="' . $heading_id . '"' . $attrs;
    }

    $item = [
        'id' => $heading_id,
        'tag' => $tag,
        'text' => $clean_text,
        'children' => []
    ];

    if ($tag === 'h2') {
        $GLOBALS['__cur_h2_idx'] = count($toc_tree);
        $toc_tree[] = $item;
    } elseif ($tag === 'h3') {
        if (isset($GLOBALS['__cur_h2_idx']) && isset($toc_tree[$GLOBALS['__cur_h2_idx']])) {
            $toc_tree[$GLOBALS['__cur_h2_idx']]['children'][] = $item;
        } else {
            $toc_tree[] = $item;
        }
    }

    return "<{$tag}{$attrs}>{$inner_html}</{$tag}>";
}, $blog->content);
unset($GLOBALS['__cur_h2_idx']);

// Total sub-headings count
$total_subheadings = 0;
foreach ($toc_tree as $h2) {
    $total_subheadings += 1 + count($h2['children']);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= _ent($blog->title); ?> | Vendio Tech Insights</title>
    <?php
        $seo_desc = !empty($blog->meta_description) 
            ? $blog->meta_description 
            : (!empty($blog->excerpt) ? $blog->excerpt : character_limiter(strip_tags($blog->content), 160));
        $seo_desc_clean = _ent(trim(preg_replace('/\s+/', ' ', strip_tags($seo_desc))));
    ?>
    <meta name="description" content="<?= $seo_desc_clean; ?>">
    <?php if (!empty($blog->meta_keywords)): ?>
    <meta name="keywords" content="<?= _ent($blog->meta_keywords); ?>">
    <?php endif; ?>
    <meta name="author" content="<?= _ent($blog->author ?: 'Vendio'); ?>">
    
    <!-- OpenGraph -->
    <meta property="og:title" content="<?= _ent($blog->title); ?>">
    <meta property="og:description" content="<?= $seo_desc_clean; ?>">
    <?php if (!empty($image_url)): ?>
        <meta property="og:image" content="<?= $image_url; ?>">
    <?php endif; ?>
    <meta property="og:type" content="article">
    <meta property="article:published_time" content="<?= date('c', strtotime(!empty($blog->published_at) ? $blog->published_at : ($blog->created_at ?: 'now'))); ?>">
    <?php if (!empty($image_url)): ?>
        <meta property="og:image" content="<?= $image_url; ?>">
    <?php endif; ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,400;0,700;1,400&family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Vendio Brand Fonts (Impact BC & Vladivostok) -->
    <link rel="stylesheet" href="<?= BASE_ASSET; ?>fonts/vendio-brand-fonts.css">

    <style id="vendio-article-styles">
        @font-face {
            font-family: 'Impact BC';
            src: url('<?= BASE_ASSET; ?>fonts/impact-bc/ImpactBC.woff2') format('woff2'),
                 url('<?= BASE_ASSET; ?>fonts/impact-bc/ImpactBC.woff') format('woff'),
                 url('<?= BASE_ASSET; ?>fonts/impact-bc/ImpactBC.ttf') format('truetype');
            font-weight: 400 900;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Vladivostok';
            src: url('<?= BASE_ASSET; ?>fonts/vladivostok/bold.woff2') format('woff2'),
                 url('<?= BASE_ASSET; ?>fonts/vladivostok/bold.woff') format('woff'),
                 url('<?= BASE_ASSET; ?>fonts/vladivostok/bold.ttf') format('truetype');
            font-weight: 600 800;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Vladivostok';
            src: url('<?= BASE_ASSET; ?>fonts/vladivostok/regular.woff2') format('woff2'),
                 url('<?= BASE_ASSET; ?>fonts/vladivostok/regular.woff') format('woff'),
                 url('<?= BASE_ASSET; ?>fonts/vladivostok/regular.ttf') format('truetype');
            font-weight: 300 500;
            font-style: normal;
            font-display: swap;
        }

        /* ==========================================================================
           DESIGN SYSTEM (MATCHING VENDIO LANDING PAGE LIGHT THEME)
           ========================================================================== */
        :root {
            --nav-actual-height: 65px;
            --bg-body: #ffffff;
            --bg-alt: #f7f2eb;
            --bg-cream: #f7f2eb;
            --bg-sand: #eae2d6;
            --bg-card: #ffffff;
            
            --primary-purple: #8b9a6e;
            --primary-purple-hover: #77855b;
            --primary-dark: #55643b;
            
            --text-title: #232b1e;
            --text-heading: #2d3827;
            --text-body: #414f3b;
            --text-muted: #828f7c;

            --border-light: #eae2d6;
            --border-subtle: #f0ebe1;

            --shadow-sm: 0 2px 8px rgba(139, 154, 110, 0.08);
            --shadow-card: 0 10px 28px -4px rgba(35, 43, 30, 0.08), 0 4px 12px -2px rgba(35, 43, 30, 0.04);
            
            --font-main: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            --font-heading: 'Poppins', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        
        body {
            font-family: var(--font-main);
            background-color: var(--bg-body);
            color: var(--text-body);
            line-height: 1.75;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
        }

        a { color: inherit; text-decoration: none; transition: all 0.2s ease; }
        .container { width: 100%; max-width: 1200px; margin: 0 auto; padding: 0 24px; }

        /* ==========================================================================
           TWO-COLUMN LAYOUT & STICKY DAFTAR ISI (TOC)
           ========================================================================== */
        .article-layout {
            display: flex;
            align-items: stretch;
            gap: 48px;
            position: relative;
            padding: 24px 0 60px;
        }

        /* Left Column: Outer Container for Sticky Sidebar */
        .article-toc-col {
            width: 300px;
            flex-shrink: 0;
            position: relative;
            z-index: 20;
            padding-top: 0;
        }

        /* Sticky Card that floats and follows viewport during scroll */
        .toc-sticky-card {
            position: -webkit-sticky;
            position: sticky;
            top: 78px;
            max-height: calc(100vh - 98px);
            overflow-y: auto;
            padding: 0 8px 20px 0;
            scrollbar-width: thin;
            scrollbar-color: rgba(148, 163, 184, 0.35) transparent;
            background: #ffffff;
            border-radius: 16px;
        }

        .toc-sticky-card::-webkit-scrollbar {
            width: 5px;
        }
        .toc-sticky-card::-webkit-scrollbar-track {
            background: transparent;
        }
        .toc-sticky-card::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.35);
            border-radius: 9999px;
        }
        .toc-sticky-card::-webkit-scrollbar-thumb:hover {
            background: rgba(100, 116, 139, 0.5);
        }

        /* Search input: Cari artikel di sini (Matching Image 2) */
        .toc-search-wrap {
            position: relative;
            margin-bottom: 22px;
        }
        .toc-search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.95rem;
            pointer-events: none;
        }
        .toc-search-input {
            width: 100%;
            padding: 10px 34px 10px 38px;
            font-size: 0.88rem;
            font-family: var(--font-main);
            color: #1e293b;
            background: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            outline: none;
            transition: all 0.2s ease;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
        }
        .toc-search-input:focus {
            border-color: #8b9a6e;
            box-shadow: 0 0 0 3px rgba(139, 154, 110, 0.18);
        }
        .toc-search-input::placeholder {
            color: #9ca3af;
        }
        .toc-search-clear {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            font-size: 1.15rem;
            cursor: pointer;
            padding: 2px 6px;
            line-height: 1;
            border-radius: 50%;
        }
        .toc-search-clear:hover {
            color: #475569;
        }

        /* TOC Title: Daftar isi (Matching Image 2) */
        .toc-header-row {
            margin-bottom: 12px;
        }
        .toc-title {
            font-family: var(--font-heading);
            font-size: 1.15rem;
            font-weight: 700;
            color: #1e293b;
            letter-spacing: -0.01em;
            margin: 0;
        }

        /* TOC Navigation List */
        .toc-nav {
            display: flex;
            flex-direction: column;
        }

        .toc-item {
            border-bottom: 1px dashed #e2e8f0;
            transition: all 0.2s ease;
        }
        .toc-item:last-child {
            border-bottom: none;
        }

        .toc-link-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            padding: 11px 12px;
            border-radius: 8px;
            transition: all 0.18s ease;
            cursor: pointer;
        }
        .toc-link-row:hover {
            background: rgba(0, 0, 0, 0.025);
        }

        .toc-link {
            flex: 1;
            min-width: 0;
            font-size: 0.88rem;
            font-weight: 500;
            color: #475569;
            line-height: 1.45;
            text-decoration: none;
            transition: color 0.2s ease;
            display: block;
        }
        .toc-link:hover {
            color: #1e293b;
        }

        /* Active Highlight (Matching Vendio Green Brand Palette) */
        .toc-item.is-active > .toc-link-row {
            background: rgba(139, 154, 110, 0.14);
            border-radius: 8px;
        }
        .toc-item.is-active > .toc-link-row .toc-link {
            color: #55643b;
            font-weight: 700;
        }
        .toc-item.is-active > .toc-link-row .toc-chevron-btn {
            color: #55643b;
        }

        /* Chevron Button for Accordion */
        .toc-chevron-btn {
            background: transparent;
            border: 1px solid transparent;
            width: 30px;
            height: 30px;
            padding: 0;
            cursor: pointer;
            color: #64748b;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: color 0.2s ease, background 0.2s ease, border-color 0.2s ease, transform 0.15s ease;
            flex-shrink: 0;
            user-select: none;
        }
        .toc-chevron-btn:hover {
            color: #1e293b;
            background: rgba(0, 0, 0, 0.05);
            border-color: rgba(0, 0, 0, 0.08);
        }
        .toc-chevron-btn:active {
            transform: scale(0.92);
        }
        .toc-chevron-btn i {
            transition: transform 0.32s cubic-bezier(0.22, 1, 0.36, 1);
            pointer-events: none;
            display: inline-block;
            transform: rotate(0deg);
        }
        .toc-item.is-open > .toc-link-row .toc-chevron-btn i,
        .toc-item.is-expanded > .toc-link-row .toc-chevron-btn i {
            transform: rotate(180deg);
        }

        /* Sub-items (H3) Butter-smooth CSS Grid Accordion */
        .toc-sub-list {
            display: grid;
            grid-template-rows: 0fr;
            transition: grid-template-rows 0.32s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .toc-sub-inner {
            overflow: hidden;
            min-height: 0;
            padding-left: 14px;
            margin: 0 0 0 12px;
            border-left: 2px solid #e2e8f0;
            opacity: 0;
            transform: translateY(-4px);
            transition: opacity 0.24s cubic-bezier(0.22, 1, 0.36, 1),
                        transform 0.32s cubic-bezier(0.22, 1, 0.36, 1),
                        margin 0.32s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .toc-item.is-open > .toc-sub-list,
        .toc-item.is-expanded > .toc-sub-list {
            grid-template-rows: 1fr;
        }

        .toc-item.is-open > .toc-sub-list > .toc-sub-inner,
        .toc-item.is-expanded > .toc-sub-list > .toc-sub-inner {
            opacity: 1;
            transform: translateY(0);
            margin: 4px 0 8px 12px;
        }

        .toc-sub-item {
            margin: 4px 0;
        }
        .toc-sub-link {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            font-size: 0.82rem;
            color: #64748b;
            line-height: 1.45;
            padding: 5px 8px;
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.18s ease;
        }
        .toc-sub-bullet {
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: #cbd5e1;
            flex-shrink: 0;
            margin-top: 7px;
            transition: all 0.2s ease;
        }
        .toc-sub-link:hover {
            color: #1e293b;
            background: rgba(0, 0, 0, 0.03);
        }
        .toc-sub-item.is-active .toc-sub-link {
            background: rgba(139, 154, 110, 0.14);
            color: #55643b;
            font-weight: 700;
        }
        .toc-sub-item.is-active .toc-sub-bullet {
            background: #55643b;
            transform: scale(1.4);
        }

        /* Search empty state */
        .toc-empty-state {
            padding: 16px 8px;
            font-size: 0.82rem;
            color: #64748b;
            text-align: center;
            background: #f8fafc;
            border-radius: 8px;
            margin-top: 8px;
        }
        .toc-search-all-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #55643b;
        }
        .toc-search-all-link:hover {
            color: #8b9a6e;
            text-decoration: underline;
        }

        /* ==========================================================================
           TOC SHARE SECTION (WA, IG, X, FB, LinkedIn, Copy Link)
           ========================================================================== */
        .toc-share-section {
            margin-top: 24px;
            padding-top: 20px;
            padding-bottom: 58px;
            border-top: 1px dashed #e2e8f0;
        }
        .toc-share-section.no-toc {
            margin-top: 0;
            padding-top: 0;
            border-top: none;
        }

        .toc-share-header {
            margin-bottom: 12px;
        }

        .toc-share-title {
            font-size: 0.8rem;
            font-weight: 700;
            color: #55643b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .toc-share-title i {
            color: #55643b;
            font-size: 0.85rem;
        }

        .toc-share-icons-grid {
            display: flex;
            align-items: center;
            gap: 7px;
            flex-wrap: wrap;
        }

        .toc-share-btn {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            color: #64748b;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
            user-select: none;
            flex-shrink: 0;
            position: relative;
        }

        .toc-share-btn:hover {
            transform: translateY(-2px);
        }

        /* 1. WhatsApp */
        .toc-share-btn.share-wa:hover {
            color: #ffffff;
            background: #25d366;
            border-color: #25d366;
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.32);
        }

        /* 2. Instagram */
        .toc-share-btn.share-ig:hover {
            color: #ffffff;
            background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
            border-color: #dc2743;
            box-shadow: 0 4px 12px rgba(220, 39, 67, 0.32);
        }

        /* 3. X (Twitter) */
        .toc-share-btn.share-x:hover {
            color: #ffffff;
            background: #000000;
            border-color: #000000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.28);
        }

        /* 4. Facebook */
        .toc-share-btn.share-fb:hover {
            color: #ffffff;
            background: #1877f2;
            border-color: #1877f2;
            box-shadow: 0 4px 12px rgba(24, 119, 242, 0.32);
        }

        /* 5. LinkedIn */
        .toc-share-btn.share-linkedin:hover {
            color: #ffffff;
            background: #0a66c2;
            border-color: #0a66c2;
            box-shadow: 0 4px 12px rgba(10, 102, 194, 0.32);
        }

        /* 6. Copy Link */
        .toc-share-btn.share-copy:hover {
            color: #ffffff;
            background: #55643b;
            border-color: #55643b;
            box-shadow: 0 4px 12px rgba(85, 100, 59, 0.32);
        }

        /* 6. Copy Link Wrapper & Floating Tooltip (Matching Image Design) */
        .toc-share-copy-wrap {
            position: relative;
            display: inline-flex;
        }

        .toc-copy-tooltip {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            background: #eff1eb;
            color: #55643b;
            font-size: 0.8rem;
            font-weight: 700;
            padding: 7px 14px;
            border-radius: 9px;
            white-space: nowrap;
            border: none;
            box-shadow: 0 4px 16px rgba(45, 60, 25, 0.10);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            opacity: 0;
            pointer-events: none;
            transform: translateY(-4px);
            transition: opacity 0.22s cubic-bezier(0.16, 1, 0.3, 1), transform 0.22s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 100;
        }

        /* Tooltip Pointer Triangle (pointing UP, no stroke, matches #eff1eb) */
        .toc-copy-tooltip::after {
            content: '';
            position: absolute;
            bottom: 100%;
            right: 12px;
            border-width: 0 6px 6px 6px;
            border-style: solid;
            border-color: transparent transparent #eff1eb transparent;
        }

        .toc-copy-tooltip.is-visible {
            opacity: 1;
            pointer-events: auto;
            transform: translateY(0);
        }

        .toc-tooltip-check {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 17px;
            height: 17px;
            background: #65a30d;
            color: #ffffff;
            border-radius: 4px;
            font-size: 0.65rem;
            font-weight: 800;
            flex-shrink: 0;
            line-height: 1;
        }

        .toc-tooltip-text {
            color: #55643b;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: -0.01em;
            line-height: 1.2;
        }

        /* Right Column: Article Main Body */
        .article-main-col {
            flex: 1;
            min-width: 0;
            max-width: 840px;
        }

        /* Smooth Heading Scroll Margins */
        .article-header,
        .article-title,
        .article-prose h2,
        .article-prose h3,
        .article-prose h4 {
            scroll-margin-top: 96px;
        }

        /* Mobile Dropdown Bar & Container (Hidden on Desktop) */
        .toc-mobile-bar-btn {
            display: none !important;
        }
        .toc-content-collapse {
            display: block !important;
        }
        .toc-desktop-only {
            display: block;
        }

        /* Mobile Floating Share FAB (Hidden on Desktop) */
        .mobile-share-fab-container {
            display: none;
        }

        /* Floating Scroll-To-Top Button */
        .floating-scroll-top-btn {
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 1040;
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: #8b9a6e;
            color: #ffffff;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 8px 24px rgba(85, 100, 59, 0.38);
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transform: translateY(12px) scale(0.9);
            transition: opacity 0.28s cubic-bezier(0.16, 1, 0.3, 1),
                        transform 0.28s cubic-bezier(0.16, 1, 0.3, 1),
                        background 0.2s ease,
                        box-shadow 0.2s ease,
                        visibility 0.28s;
            text-decoration: none;
            user-select: none;
            -webkit-tap-highlight-color: transparent;
        }
        .floating-scroll-top-btn.is-visible {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
            transform: translateY(0) scale(1);
        }
        .floating-scroll-top-btn:hover {
            background: #77855b;
            box-shadow: 0 10px 28px rgba(85, 100, 59, 0.45);
            color: #ffffff;
        }
        .floating-scroll-top-btn:active {
            transform: scale(0.92);
            background: #55643b;
        }
        .floating-scroll-top-btn i {
            font-size: 1.15rem;
            line-height: 1;
            display: block;
            transition: transform 0.2s ease;
        }
        .floating-scroll-top-btn:hover i {
            transform: translateY(-2px);
        }

        /* Responsive adjustments (Mobile Screen <= 991px, matching Image 2) */
        @media (max-width: 991px) {
            .article-nav {
                background: #ffffff !important;
                border-radius: 0 0 24px 24px !important;
                box-shadow: 0 10px 30px -4px rgba(15, 23, 42, 0.08), 0 4px 12px -2px rgba(139, 154, 110, 0.04) !important;
                border-bottom: 1px solid rgba(226, 232, 240, 0.85) !important;
                position: sticky !important;
                top: 0 !important;
                z-index: 1000 !important;
                overflow: visible !important;
            }
            .nav-inner {
                padding: 0 16px !important;
            }
            .nav-links {
                display: none !important;
            }
            .mobile-toggle {
                display: inline-flex !important;
                margin-left: auto;
            }

            /* Mobile Dropdown Card matching Landing Page Image 2 */
            .mobile-dropdown-card {
                display: block !important;
                position: absolute !important;
                top: calc(100% + 8px) !important;
                left: 12px !important;
                right: 12px !important;
                background: #ffffff !important;
                border: 1px solid rgba(226, 232, 240, 0.95) !important;
                border-radius: 24px !important;
                padding: 14px !important;
                box-shadow: 0 24px 50px -12px rgba(15, 23, 42, 0.22), 0 10px 20px -5px rgba(0, 0, 0, 0.08) !important;
                z-index: 1010 !important;
                opacity: 0;
                visibility: hidden;
                transform: translateY(-10px) scale(0.97);
                pointer-events: none;
                transition: opacity 0.28s cubic-bezier(0.16, 1, 0.3, 1),
                            transform 0.28s cubic-bezier(0.16, 1, 0.3, 1),
                            visibility 0.28s;
            }

            .mobile-dropdown-card.is-open {
                opacity: 1 !important;
                visibility: visible !important;
                transform: translateY(0) scale(1) !important;
                pointer-events: auto !important;
            }

            .mobile-dropdown-list {
                display: flex !important;
                flex-direction: column !important;
                gap: 8px !important;
            }

            .mobile-dropdown-item {
                display: flex !important;
                align-items: center !important;
                justify-content: space-between !important;
                padding: 14px 18px !important;
                background: #f8fafc !important;
                border-radius: 14px !important;
                text-decoration: none !important;
                transition: all 0.2s ease !important;
            }

            .mobile-dropdown-item .item-label {
                font-family: var(--font-heading) !important;
                font-size: 0.98rem !important;
                font-weight: 700 !important;
                color: #2d3827 !important;
            }

            .mobile-dropdown-item:hover,
            .mobile-dropdown-item.active {
                background: #f1f5f9 !important;
            }

            .mobile-dropdown-item:hover .item-label,
            .mobile-dropdown-item.active .item-label {
                color: var(--primary-purple) !important;
            }

            .mobile-menu-backdrop {
                display: block !important;
                position: fixed !important;
                inset: 0 !important;
                background: rgba(15, 23, 42, 0.25) !important;
                backdrop-filter: blur(4px) !important;
                -webkit-backdrop-filter: blur(4px) !important;
                z-index: 999 !important;
                opacity: 0;
                visibility: hidden;
                pointer-events: none;
                transition: opacity 0.28s ease, visibility 0.28s;
            }

            .mobile-menu-backdrop.is-open {
                opacity: 1 !important;
                visibility: visible !important;
                pointer-events: auto !important;
            }

            .article-layout {
                flex-direction: column;
                gap: 0;
                padding-top: 0 !important;
            }
            .article-toc-col {
                position: -webkit-sticky;
                position: sticky;
                top: calc(var(--nav-actual-height, 65px) - 6px);
                z-index: 95;
                width: 100%;
                background: transparent !important;
                padding: 0 !important;
                margin: -6px 0 0 0 !important;
                height: 0;
                overflow: visible;
            }
            .article-toc-col.no-toc {
                display: none !important;
            }
            .article-header {
                padding: 10px 0 0px !important;
                margin-bottom: 24px !important;
            }
            .article-cover-wrap {
                margin: 24px 0 !important;
            }
            .article-breadcrumbs {
                margin-bottom: 14px !important;
            }
            .article-header,
            .article-title,
            .article-prose h2,
            .article-prose h3,
            .article-prose h4 {
                scroll-margin-top: calc(var(--nav-actual-height, 65px) + 72px) !important;
            }
            .article-toc-col .toc-sticky-card {
                position: static !important;
                max-height: none !important;
                overflow-y: visible !important;
                padding: 0 !important;
                border: none !important;
                background: transparent !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                transform: translateY(0);
                transition: transform 0.38s cubic-bezier(0.16, 1, 0.3, 1);
                will-change: transform;
            }
            .article-toc-col.is-hidden .toc-sticky-card {
                transform: translateY(-120%);
                pointer-events: none;
                transition: transform 0.30s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .toc-desktop-only {
                display: none !important;
            }

            /* Mobile Green Bar Button (Exact match for Image 2) */
            .toc-mobile-bar-btn {
                position: relative;
                overflow: hidden;
                display: flex !important;
                align-items: center;
                justify-content: space-between;
                width: 100%;
                background: #8b9a6e;
                color: #ffffff;
                padding: 10px 18px 13px;
                border-radius: 0 0 12px 12px !important;
                border: none;
                cursor: pointer;
                font-family: var(--font-heading);
                font-size: 0.95rem;
                font-weight: 700;
                letter-spacing: -0.01em;
                box-shadow: 0 6px 16px rgba(139, 154, 110, 0.28);
                transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
                user-select: none;
                margin: 0 !important;
            }

            /* Reading Progress Bar (Matching Image 2 Mekari Desty reference) */
            .toc-mobile-progress-track {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                height: 3.5px;
                background: rgba(0, 0, 0, 0.20);
                pointer-events: none;
                z-index: 5;
            }
            .toc-mobile-progress-bar {
                height: 100%;
                width: 0%;
                background: #ffffff;
                border-radius: 0 2px 2px 0;
                transition: width 0.08s linear;
                will-change: width;
            }
            .toc-mobile-bar-btn:active {
                transform: scale(0.985);
                background: #77855b;
            }
            .toc-mobile-bar-btn.is-active {
                border-radius: 0 !important;
            }
            .toc-mobile-bar-title {
                color: #ffffff;
                font-weight: 700;
            }
            .toc-mobile-bar-arrow {
                color: #ffffff;
                font-size: 0.95rem;
                transition: transform 0.28s cubic-bezier(0.16, 1, 0.3, 1);
                pointer-events: none;
            }
            .toc-mobile-bar-btn.is-active .toc-mobile-bar-arrow {
                transform: rotate(180deg);
            }

            /* Mobile Collapse Dropdown Container */
            .toc-content-collapse {
                display: none !important;
                background: #ffffff;
                border: 1px solid var(--border-light);
                border-top: none;
                border-radius: 0 0 16px 16px;
                padding: 16px;
                margin-top: 0;
                box-shadow: 0 14px 32px rgba(35, 43, 30, 0.14);
                animation: mobileTocSlideDown 0.25s cubic-bezier(0.16, 1, 0.3, 1);
                max-height: calc(100vh - var(--nav-actual-height, 65px) - 70px);
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
            }
            .toc-content-collapse.is-open {
                display: block !important;
            }
            @keyframes mobileTocSlideDown {
                from { opacity: 0; transform: translateY(-8px); }
                to { opacity: 1; transform: translateY(0); }
            }

            .toc-nav {
                display: flex !important;
            }

            /* Hide desktop static share section on mobile */
            .toc-share-section {
                display: none !important;
            }

            .article-main-col {
                max-width: 100%;
            }

            /* ==========================================================================
               MOBILE FLOATING SHARE ACTION BUTTON (FAB) & 2x3 GRID (MATCHING IMAGE 2)
               ========================================================================== */
            .mobile-share-fab-container {
                display: block;
                position: fixed;
                bottom: 24px;
                right: 20px;
                z-index: 1050;
            }

            .mobile-share-backdrop {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.28);
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.25s ease, visibility 0.25s ease;
                z-index: 1;
            }
            .mobile-share-fab-container.is-open .mobile-share-backdrop {
                opacity: 1;
                visibility: visible;
            }

            /* Floating Green Trigger Button */
            .mobile-share-fab-btn {
                position: relative;
                z-index: 2;
                width: 48px;
                height: 48px;
                border-radius: 14px;
                background: #8b9a6e;
                color: #ffffff;
                border: none;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                box-shadow: 0 8px 24px rgba(85, 100, 59, 0.42);
                transition: transform 0.22s cubic-bezier(0.16, 1, 0.3, 1), background 0.2s ease;
            }
            .mobile-share-fab-btn:active {
                transform: scale(0.92);
            }
            .mobile-share-fab-btn .fab-icon-plane,
            .mobile-share-fab-btn .fab-icon-dots {
                font-size: 1.15rem;
                display: block;
                transform: translate(-1px, 1px);
            }
            .mobile-share-fab-btn .fab-icon-close {
                font-size: 1.15rem;
                display: none;
            }
            .mobile-share-fab-container.is-open .mobile-share-fab-btn {
                background: #55643b;
            }
            .mobile-share-fab-container.is-open .mobile-share-fab-btn .fab-icon-plane,
            .mobile-share-fab-container.is-open .mobile-share-fab-btn .fab-icon-dots {
                display: none;
            }
            .mobile-share-fab-container.is-open .mobile-share-fab-btn .fab-icon-close {
                display: block;
            }

            /* Green Card with 2-Column Grid (Matching Image 2) */
            .mobile-share-card {
                position: absolute;
                bottom: calc(100% + 14px);
                right: 0;
                z-index: 2;
                background: #8b9a6e;
                border-radius: 18px;
                padding: 12px;
                box-shadow: 0 16px 36px rgba(35, 43, 30, 0.32);
                opacity: 0;
                visibility: hidden;
                transform: translateY(12px) scale(0.85);
                transform-origin: bottom right;
                transition: opacity 0.24s cubic-bezier(0.16, 1, 0.3, 1),
                            transform 0.24s cubic-bezier(0.16, 1, 0.3, 1),
                            visibility 0.24s;
                pointer-events: none;
            }
            .mobile-share-fab-container.is-open .mobile-share-card {
                opacity: 1;
                visibility: visible;
                transform: translateY(0) scale(1);
                pointer-events: auto;
            }

            /* 2 Columns x 3 Rows Grid of White Boxes */
            .mobile-share-grid {
                display: grid;
                grid-template-columns: repeat(2, 46px);
                gap: 10px;
            }

            .mobile-share-item {
                width: 46px;
                height: 46px;
                border-radius: 12px;
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                display: flex;
                align-items: center;
                justify-content: center;
                text-decoration: none;
                cursor: pointer;
                color: #64748b;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
                transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
                user-select: none;
                position: relative;
            }
            .mobile-share-item i {
                color: #64748b;
                transition: color 0.2s ease;
            }
            .mobile-share-item:hover,
            .mobile-share-item:active {
                transform: translateY(-2px);
            }

            /* 1. WhatsApp */
            .mobile-share-item.item-wa i { font-size: 1.25rem; }
            .mobile-share-item.item-wa:hover,
            .mobile-share-item.item-wa:active {
                color: #ffffff;
                background: #25d366;
                border-color: #25d366;
                box-shadow: 0 4px 12px rgba(37, 211, 102, 0.36);
            }
            .mobile-share-item.item-wa:hover i,
            .mobile-share-item.item-wa:active i {
                color: #ffffff;
            }

            /* 2. Instagram */
            .mobile-share-item.item-ig i { font-size: 1.25rem; }
            .mobile-share-item.item-ig:hover,
            .mobile-share-item.item-ig:active {
                color: #ffffff;
                background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
                border-color: #dc2743;
                box-shadow: 0 4px 12px rgba(220, 39, 67, 0.36);
            }
            .mobile-share-item.item-ig:hover i,
            .mobile-share-item.item-ig:active i {
                color: #ffffff;
            }

            /* 3. X (Twitter) */
            .mobile-share-item.item-x i { font-size: 1.15rem; }
            .mobile-share-item.item-x:hover,
            .mobile-share-item.item-x:active {
                color: #ffffff;
                background: #000000;
                border-color: #000000;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.32);
            }
            .mobile-share-item.item-x:hover i,
            .mobile-share-item.item-x:active i {
                color: #ffffff;
            }

            /* 4. Facebook */
            .mobile-share-item.item-fb i { font-size: 1.2rem; }
            .mobile-share-item.item-fb:hover,
            .mobile-share-item.item-fb:active {
                color: #ffffff;
                background: #1877f2;
                border-color: #1877f2;
                box-shadow: 0 4px 12px rgba(24, 119, 242, 0.36);
            }
            .mobile-share-item.item-fb:hover i,
            .mobile-share-item.item-fb:active i {
                color: #ffffff;
            }

            /* 5. LinkedIn */
            .mobile-share-item.item-linkedin i { font-size: 1.15rem; }
            .mobile-share-item.item-linkedin:hover,
            .mobile-share-item.item-linkedin:active {
                color: #ffffff;
                background: #0a66c2;
                border-color: #0a66c2;
                box-shadow: 0 4px 12px rgba(10, 102, 194, 0.36);
            }
            .mobile-share-item.item-linkedin:hover i,
            .mobile-share-item.item-linkedin:active i {
                color: #ffffff;
            }

            /* 6. Copy Link */
            .mobile-share-item.item-copy i { font-size: 1.15rem; }
            .mobile-share-item.item-copy:hover,
            .mobile-share-item.item-copy:active {
                color: #ffffff;
                background: #55643b;
                border-color: #55643b;
                box-shadow: 0 4px 12px rgba(85, 100, 59, 0.36);
            }
            .mobile-share-item.item-copy:hover i,
            .mobile-share-item.item-copy:active i {
                color: #ffffff;
            }

            /* Tooltip inside mobile card */
            .mobile-copy-tooltip {
                position: absolute;
                bottom: calc(100% + 10px);
                right: 0;
                background: #eff1eb;
                color: #55643b;
                font-size: 0.78rem;
                font-weight: 700;
                padding: 7px 14px;
                border-radius: 9px;
                white-space: nowrap;
                border: none;
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.18);
                display: inline-flex;
                align-items: center;
                gap: 8px;
                opacity: 0;
                pointer-events: none;
                transform: translateY(4px);
                transition: opacity 0.2s ease, transform 0.2s ease;
                z-index: 10;
            }
            .mobile-copy-tooltip::after {
                content: '';
                position: absolute;
                top: 100%;
                right: 18px;
                border-width: 6px 6px 0 6px;
                border-style: solid;
                border-color: #eff1eb transparent transparent transparent;
            }
            .mobile-copy-tooltip.is-visible {
                opacity: 1;
                transform: translateY(0);
            }

            /* Floating Scroll-To-Top Button: Stacked directly above the Mobile Share FAB */
            .floating-scroll-top-btn {
                bottom: 82px !important;
                right: 20px !important;
                width: 48px !important;
                height: 48px !important;
                border-radius: 14px !important;
                z-index: 1040 !important;
            }
            /* Hide scroll-to-top when share modal popup is open */
            .mobile-share-fab-container.is-open ~ .floating-scroll-top-btn,
            .mobile-share-fab-container.is-open + .floating-scroll-top-btn {
                opacity: 0 !important;
                visibility: hidden !important;
                pointer-events: none !important;
                transform: translateY(10px) scale(0.85) !important;
            }
        }

        /* Navigation Bar */
        .article-nav {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.85);
            border-radius: 0 0 24px 24px;
            box-shadow: 0 10px 30px -4px rgba(15, 23, 42, 0.08), 0 4px 12px -2px rgba(139, 154, 110, 0.04);
            padding: 14px 0;
        }
        .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1140px;
            margin: 0 auto;
            padding: 0 24px;
        }
        .brand-logo {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }
        .brand-logo-icon {
            height: 36px;
            max-height: 36px;
            width: auto;
            object-fit: contain;
            display: block;
        }
        .brand-name {
            display: flex;
            flex-direction: column;
            line-height: 1;
            justify-content: center;
            text-align: left;
            user-select: none;
        }
        .brand-name-title {
            font-family: 'Impact BC', sans-serif;
            font-weight: 900;
            font-size: 1.35rem;
            color: #8b9a6e;
            letter-spacing: 0.15em;
            line-height: 1;
            text-transform: uppercase;
        }
        .brand-name-sub {
            font-family: 'Vladivostok', sans-serif;
            font-size: 0.45rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.31em;
            color: #8b9a6e;
            line-height: 1;
            margin-top: 4px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 32px;
            list-style: none;
            margin-left: auto;
            padding: 0;
            margin-bottom: 0;
        }

        .nav-link {
            font-size: 0.92rem;
            font-weight: 600;
            color: #475569;
            position: relative;
            padding: 6px 0;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary-purple);
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 50%;
            transform: translateX(-50%);
            width: 6px;
            height: 6px;
            background: var(--primary-purple);
            border-radius: 50%;
            box-shadow: 0 0 6px rgba(139, 154, 110, 0.6);
        }

        .mobile-toggle {
            display: none;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            color: #1e293b;
            font-size: 1.2rem;
            width: 42px;
            height: 42px;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            touch-action: manipulation;
            -webkit-tap-highlight-color: transparent;
        }

        .mobile-toggle:hover {
            background: #f1f5f9;
            color: var(--primary-purple);
        }

        @media (min-width: 992px) {
            .mobile-dropdown-card,
            .mobile-menu-backdrop {
                display: none !important;
            }
        }

        /* Article Header */
        .article-header {
            padding: 0;
            margin-bottom: 30px;
        }
        .article-breadcrumbs {
            font-size: 0.84rem;
            color: var(--text-muted);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .article-breadcrumbs a {
            color: #55643b;
            font-weight: 500;
        }
        .article-breadcrumbs a:hover {
            color: var(--primary-purple);
            text-decoration: underline;
        }
        .article-read-estimate {
            font-size: 0.95rem;
            color: #64748b;
            font-weight: 500;
            margin-bottom: 10px;
            display: block;
            line-height: 1.4;
        }
        .article-title {
            font-family: 'Merriweather', Georgia, 'Times New Roman', serif;
            font-size: clamp(2.1rem, 3.8vw, 2.9rem);
            font-weight: 700;
            letter-spacing: -0.015em;
            line-height: 1.28;
            margin-bottom: 16px;
            color: #1e293b;
        }
        .article-meta-dates {
            font-size: 0.95rem;
            color: #475569;
            margin-bottom: 10px;
            line-height: 1.5;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
        }
        .article-meta-dates .meta-date-label {
            font-weight: 700;
            color: #1e293b;
        }
        .article-meta-dates .meta-date-val {
            font-weight: 400;
            color: #475569;
        }
        .article-meta-dates .meta-date-sep {
            color: #94a3b8;
            margin: 0 4px;
            font-size: 0.8rem;
        }
        .article-author-by {
            font-size: 0.95rem;
            line-height: 1.5;
            margin-bottom: 0;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .article-author-by .author-by-label {
            color: #64748b;
            font-weight: 400;
        }
        .article-author-by .author-by-name {
            color: #2563eb;
            font-weight: 600;
        }

        /* Featured Image - Borderless, clean 16:9 ratio */
        .article-cover-wrap {
            margin: 30px 0 30px;
            border-radius: 16px;
            overflow: hidden;
            border: none !important;
            box-shadow: none !important;
            background: transparent;
            width: 100%;
            aspect-ratio: 16 / 9;
        }
        .article-cover-img {
            width: 100%;
            height: 100%;
            aspect-ratio: 16 / 9;
            object-fit: cover;
            display: block;
            border-radius: 16px;
            border: none !important;
        }

        /* Article Content / Prose */
        .article-prose {
            font-size: 1.1rem;
            color: var(--text-body);
            line-height: 1.85;
            margin-bottom: 48px;
        }
        .article-prose p {
            margin-bottom: 24px;
        }
        .article-prose h2, .article-prose h3, .article-prose h4 {
            color: var(--text-title);
            font-family: var(--font-heading);
            font-weight: 700;
            letter-spacing: -0.01em;
            margin: 40px 0 16px;
            line-height: 1.35;
        }
        .article-prose h2 { 
            font-size: 1.65rem; 
            border-bottom: 2px solid var(--border-light); 
            padding-bottom: 8px; 
        }
        .article-prose h3 { font-size: 1.38rem; }
        .article-prose ul, .article-prose ol {
            margin: 0 0 24px 28px;
        }
        .article-prose li {
            margin-bottom: 8px;
        }
        .article-prose blockquote {
            border-left: 4px solid var(--primary-purple);
            padding: 14px 22px;
            background: #f7f2eb;
            border-radius: 0 12px 12px 0;
            margin: 28px 0;
            color: #333f2d;
            font-style: italic;
        }
        .article-prose code {
            font-family: monospace;
            font-size: 0.9em;
            background: #f1ede6;
            padding: 2px 7px;
            border-radius: 4px;
            color: #55643b;
        }
        .article-prose img {
            max-width: 100%;
            height: auto;
            border-radius: 14px;
            margin: 24px 0;
            border: none !important;
            box-shadow: none !important;
        }

        /* Tags Strip */
        .article-tags-wrap {
            padding: 22px 0;
            border-top: 1px solid var(--border-light);
            border-bottom: 1px solid var(--border-light);
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 48px;
        }
        .tag-pill {
            font-size: 0.8rem;
            font-weight: 600;
            color: #55643b;
            background: rgba(139, 154, 110, 0.1);
            border: 1px solid rgba(139, 154, 110, 0.25);
            padding: 4px 14px;
            border-radius: 9999px;
            transition: all 0.2s;
        }
        .tag-pill:hover {
            background: var(--primary-purple);
            color: #ffffff;
            border-color: var(--primary-purple);
        }

        /* Related Articles */
        .related-section {
            padding: 36px 0 60px;
        }
        .related-title {
            font-family: var(--font-heading);
            font-size: 1.45rem;
            font-weight: 700;
            margin-bottom: 24px;
            color: var(--text-title);
            letter-spacing: -0.02em;
        }
        .related-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }
        .related-card {
            background: transparent;
            border: none;
            border-bottom: 1px solid #94a3b8;
            border-radius: 0;
            overflow: visible;
            display: flex;
            flex-direction: column;
            padding: 0 0 22px 0;
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1),
                        border-color 0.25s ease;
            box-shadow: none;
        }
        .related-card:hover {
            transform: translateY(-4px);
            box-shadow: none;
            border-bottom-color: #475569;
        }
        .related-card-img-wrap {
            width: 100%;
            aspect-ratio: 16 / 9;
            background: #f1f5f9;
            border-radius: 16px;
            overflow: hidden;
            display: block;
            text-decoration: none;
            margin-bottom: 20px;
            position: relative;
        }
        .related-card-img {
            width: 100%;
            height: 100%;
            aspect-ratio: 16 / 9;
            object-fit: cover;
            border-radius: 16px;
            display: block;
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .related-card:hover .related-card-img {
            transform: scale(1.04);
        }
        .related-card-placeholder {
            width: 100%;
            height: 100%;
            aspect-ratio: 16 / 9;
            background: linear-gradient(135deg, #f7f2eb 0%, #eae2d6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #8b9a6e;
            font-size: 2.2rem;
            opacity: 0.8;
            border-radius: 16px;
        }
        .related-card-category {
            font-size: 0.95rem;
            font-weight: 600;
            color: #4b5563;
            background: none;
            border: none;
            padding: 0;
            margin: 0 0 10px 0;
            display: block;
            letter-spacing: 0.01em;
            line-height: 1.4;
        }
        .related-card-title {
            font-size: 1.35rem;
            font-family: var(--font-heading);
            font-weight: 600;
            line-height: 1.35;
            margin: 0 0 14px 0;
            letter-spacing: -0.01em;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .related-card-title a {
            color: var(--text-title);
            text-decoration: none;
            transition: color 0.2s ease;
        }
        .related-card-title a:hover {
            color: var(--primary-purple);
        }
        .related-card-meta {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.95rem;
            color: #6b7280;
            margin: 0 0 24px 0;
            line-height: 1.4;
        }
        .related-card-meta .meta-dot {
            font-size: 0.85rem;
            color: #9ca3af;
            margin: 0 2px;
        }
        .related-card-author {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: auto;
        }
        .related-card-author-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            border: 1px solid rgba(0, 0, 0, 0.06);
            flex-shrink: 0;
        }
        .related-card-author-name {
            font-size: 1rem;
            font-weight: 600;
            color: #2563eb;
            line-height: 1.2;
            transition: color 0.2s ease;
        }

        /* ==========================================================================
           FOOTER (Matching Landing Page & Image 2)
           ========================================================================== */
        .site-footer.footer-light {
            margin-top: auto;
            background: #ffffff;
            border-top: 1px solid rgba(234, 226, 214, 0.55);
            padding: 65px 0 32px 0;
            font-size: 0.88rem;
            color: #64748b;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1.15fr 1.15fr 1.15fr;
            gap: 40px;
            margin-bottom: 45px;
        }

        .footer-col-title {
            font-family: var(--font-heading);
            font-size: 0.84rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: var(--text-title);
            margin-bottom: 20px;
        }

        .footer-brand-desc {
            font-size: 0.88rem;
            color: var(--text-body);
            line-height: 1.65;
            margin: 14px 0 20px 0;
            max-width: 340px;
        }

        .footer-nav-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
            padding: 0;
            margin: 0;
        }

        .footer-nav-list li {
            list-style: none;
        }

        .footer-nav-list a {
            color: #55614e;
            transition: color 0.2s ease, transform 0.2s ease;
            display: inline-block;
            text-decoration: none;
        }

        .footer-nav-list a:hover {
            color: var(--primary-purple);
            transform: translateX(3px);
        }

        .footer-bottom-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            padding-top: 26px;
            border-top: 1px solid #f1f5f9;
        }

        @media (max-width: 992px) {
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 768px) {
            .site-footer.footer-light {
                padding-top: 45px;
                padding-bottom: 30px;
            }
            .footer-grid { grid-template-columns: 1fr; }
            .related-grid { grid-template-columns: 1fr; }
            .article-meta-row { flex-direction: column; align-items: flex-start; }
        }

        /* ==========================================================================
           PAGE TRANSITION & PROGRESS BAR
           ========================================================================== */
        .page-progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            width: 0%;
            background: linear-gradient(90deg, #8b9a6e 0%, #a2b482 50%, #55643b 100%);
            box-shadow: 0 0 10px rgba(139, 154, 110, 0.8), 0 0 5px rgba(139, 154, 110, 0.5);
            z-index: 99999;
            opacity: 0;
            pointer-events: none;
            transition: width 0.3s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.2s ease;
        }

        .app-page-stage {
            position: relative;
            width: 100%;
            min-height: 100vh;
            overflow-x: clip !important;
            overflow-y: visible !important;
        }

        .app-page-view {
            width: 100%;
            min-height: 100vh;
            overflow: visible !important;
        }

        .app-page-view.slide-in-right,
        .app-page-view.slide-in-left,
        .app-page-view.slide-out-right,
        .app-page-view.slide-out-left {
            will-change: transform, opacity;
        }

        /* Slide Transition Animations (Buttery Smooth 60fps) */
        .slide-out-left {
            animation: appSlideOutLeft 0.28s cubic-bezier(0.16, 1, 0.3, 1) forwards !important;
            pointer-events: none;
        }

        .slide-in-right {
            animation: appSlideInRight 0.34s cubic-bezier(0.16, 1, 0.3, 1) forwards !important;
        }

        .slide-out-right {
            animation: appSlideOutRight 0.28s cubic-bezier(0.16, 1, 0.3, 1) forwards !important;
            pointer-events: none;
        }

        .slide-in-left {
            animation: appSlideInLeft 0.34s cubic-bezier(0.16, 1, 0.3, 1) forwards !important;
        }

        @keyframes appSlideOutLeft {
            0% {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
            100% {
                opacity: 0;
                transform: translate3d(-35px, 0, 0);
            }
        }

        @keyframes appSlideInRight {
            0% {
                opacity: 0;
                transform: translate3d(35px, 0, 0);
            }
            100% {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        @keyframes appSlideOutRight {
            0% {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
            100% {
                opacity: 0;
                transform: translate3d(35px, 0, 0);
            }
        }

        @keyframes appSlideInLeft {
            0% {
                opacity: 0;
                transform: translate3d(-35px, 0, 0);
            }
            100% {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }
    </style>
</head>

<body>
    <!-- Top Loading Progress Bar -->
    <div id="page-progress-bar" class="page-progress-bar"></div>

    <!-- Top Nav (Matching Landing Page & Blog Index) -->
    <nav class="article-nav" id="navbar">
        <div class="nav-inner">
            <a href="<?= site_url(); ?>" class="brand-logo" title="Kembali ke beranda">
                <img src="<?= BASE_ASSET; ?>img/vendio-logo.png" alt="Vendio Logo" class="brand-logo-icon">
                <div class="brand-name">
                    <span class="brand-name-title">VENDIO</span>
                    <span class="brand-name-sub">OMNICHANNEL ERP</span>
                </div>
            </a>

            <ul class="nav-links">
                <li><a href="<?= site_url('#feature'); ?>" class="nav-link">Fitur</a></li>
                <li><a href="<?= site_url('#showcase'); ?>" class="nav-link">Cara Kerja</a></li>
                <li><a href="<?= site_url('blog'); ?>" class="nav-link active">Blog</a></li>
                <li><a href="<?= site_url('#faq'); ?>" class="nav-link">FAQ</a></li>
            </ul>

            <button type="button" class="mobile-toggle" id="mobileMenuBtn" aria-label="Toggle Menu" aria-expanded="false">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>

        <!-- Mobile Menu Dropdown Card (matching Landing Page Image 2) -->
        <div class="mobile-dropdown-card" id="mobileDropdownCard">
            <div class="mobile-dropdown-list">
                <a href="<?= site_url('#feature'); ?>" class="mobile-dropdown-item">
                    <span class="item-label">Fitur</span>
                </a>
                <a href="<?= site_url('#showcase'); ?>" class="mobile-dropdown-item">
                    <span class="item-label">Cara Kerja</span>
                </a>
                <a href="<?= site_url('blog'); ?>" class="mobile-dropdown-item active">
                    <span class="item-label">Blog</span>
                </a>
                <a href="<?= site_url('#faq'); ?>" class="mobile-dropdown-item">
                    <span class="item-label">FAQ</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu Backdrop -->
    <div class="mobile-menu-backdrop" id="mobileMenuBackdrop"></div>

    <!-- Main Page Stage for Seamless Slide Transitions -->
    <div id="app-page-stage" class="app-page-stage">
        <div id="app-page-view" class="app-page-view" data-page="blog-detail">

    <main class="container">
        <div class="article-layout">
            <!-- Left Side: Sticky Daftar Isi (Matching Image 2) -->
            <aside class="article-toc-col is-hidden <?= empty($toc_tree) ? 'no-toc' : ''; ?>" id="article-toc-sidebar">
                <div class="toc-sticky-card">
                    <?php if (!empty($toc_tree)): ?>
                        <!-- Mobile Bar Button (Visible only on mobile screen <= 991px, matching Image 2) -->
                        <button type="button" class="toc-mobile-bar-btn" id="toc-mobile-bar-btn" aria-expanded="false">
                            <span class="toc-mobile-bar-title">Daftar Isi</span>
                            <i class="fa-solid fa-caret-down toc-mobile-bar-arrow" id="toc-mobile-bar-arrow"></i>
                            <!-- Reading Progress Bar (Matching Image 2 Mekari Desty reference) -->
                            <div class="toc-mobile-progress-track">
                                <div class="toc-mobile-progress-bar" id="tocMobileProgressBar" style="width: 0%;"></div>
                            </div>
                        </button>

                        <div class="toc-content-collapse" id="toc-content-collapse">
                            <!-- Search Input: Cari artikel di sini -->
                            <div class="toc-search-wrap">
                                <i class="fa-solid fa-magnifying-glass toc-search-icon"></i>
                                <input type="text" id="toc-search-input" class="toc-search-input" placeholder="Cari artikel di sini" autocomplete="off" aria-label="Cari sub judul artikel">
                                <button type="button" id="toc-search-clear" class="toc-search-clear" style="display: none;" title="Hapus pencarian">&times;</button>
                            </div>

                            <!-- Title: Daftar isi (Desktop only) -->
                            <div class="toc-header-row toc-desktop-only">
                                <h3 class="toc-title">Daftar isi</h3>
                            </div>

                            <!-- TOC Navigation List -->
                            <nav class="toc-nav" id="toc-nav" aria-label="Daftar Isi Artikel">
                                <!-- H1 Article Title link at top -->
                                <div class="toc-item toc-item-h1 is-active" data-target="heading-article-title" data-text="<?= strtolower(htmlspecialchars($blog->title)); ?>">
                                    <div class="toc-link-row">
                                        <a href="#heading-article-title" class="toc-link" title="<?= _ent($blog->title); ?>">
                                            <span class="toc-link-text"><?= _ent($blog->title); ?></span>
                                        </a>
                                    </div>
                                </div>

                                <!-- H2 and H3 Items -->
                                <?php foreach ($toc_tree as $h2_item): ?>
                                    <?php $has_children = !empty($h2_item['children']); ?>
                                    <div class="toc-item toc-item-h2 <?= $has_children ? 'has-children' : ''; ?>" data-target="<?= $h2_item['id']; ?>" data-text="<?= strtolower(htmlspecialchars($h2_item['text'])); ?>">
                                        <div class="toc-link-row">
                                            <a href="#<?= $h2_item['id']; ?>" class="toc-link" title="<?= htmlspecialchars($h2_item['text']); ?>">
                                                <span class="toc-link-text"><?= htmlspecialchars($h2_item['text']); ?></span>
                                            </a>
                                            <?php if ($has_children): ?>
                                                <button type="button" class="toc-chevron-btn" aria-label="Toggle sub-headings" title="Buka/tutup sub-judul">
                                                    <i class="fa-solid fa-chevron-down"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>

                                        <?php if ($has_children): ?>
                                            <div class="toc-sub-list">
                                                <div class="toc-sub-inner">
                                                    <?php foreach ($h2_item['children'] as $h3_item): ?>
                                                        <div class="toc-sub-item" data-target="<?= $h3_item['id']; ?>" data-text="<?= strtolower(htmlspecialchars($h3_item['text'])); ?>">
                                                            <a href="#<?= $h3_item['id']; ?>" class="toc-sub-link" title="<?= htmlspecialchars($h3_item['text']); ?>">
                                                                <span class="toc-sub-bullet"></span>
                                                                <span class="toc-sub-text"><?= htmlspecialchars($h3_item['text']); ?></span>
                                                            </a>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>

                                <!-- Empty state when search doesn't match -->
                                <div class="toc-empty-state" id="toc-empty-state" style="display: none;">
                                    Tidak ada sub-judul yang sesuai.
                                    <div>
                                        <a href="<?= site_url('blog'); ?>" id="toc-search-site-link" class="toc-search-all-link">
                                            <i class="fa-solid fa-magnifying-glass"></i> Cari di seluruh blog
                                        </a>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    <?php endif; ?>

                    <!-- Social Share Strip (WA, IG, X, FB, LinkedIn, Copy Link) -->
                    <?php
                    $current_share_url = site_url('blog/' . $blog->slug);
                    $current_share_title = rawurlencode($blog->title);
                    $current_share_encoded_url = rawurlencode($current_share_url);
                    ?>
                    <div class="toc-share-section <?= empty($toc_tree) ? 'no-toc' : ''; ?>">
                        <div class="toc-share-header">
                            <span class="toc-share-title"><i class="fa-solid fa-share-nodes"></i> BAGIKAN ARTIKEL</span>
                        </div>
                        <div class="toc-share-icons-grid">
                            <!-- 1. WhatsApp -->
                            <a href="https://api.whatsapp.com/send?text=<?= $current_share_title; ?>%20<?= $current_share_encoded_url; ?>" 
                               target="_blank" rel="noopener noreferrer" 
                               class="toc-share-btn share-wa" title="Bagikan ke WhatsApp" aria-label="Bagikan ke WhatsApp">
                                <i class="fa-brands fa-whatsapp"></i>
                            </a>

                            <!-- 2. Instagram -->
                            <a href="https://www.instagram.com/" 
                               target="_blank" rel="noopener noreferrer" 
                               class="toc-share-btn share-ig" id="tocShareIgBtn" data-url="<?= $current_share_url; ?>" title="Bagikan ke Instagram (Salin Tautan)" aria-label="Bagikan ke Instagram">
                                <i class="fa-brands fa-instagram"></i>
                            </a>

                            <!-- 3. X (Twitter) -->
                            <a href="https://twitter.com/intent/tweet?text=<?= $current_share_title; ?>&url=<?= $current_share_encoded_url; ?>" 
                               target="_blank" rel="noopener noreferrer" 
                               class="toc-share-btn share-x" title="Bagikan ke X (Twitter)" aria-label="Bagikan ke X">
                                <i class="fa-brands fa-x-twitter"></i>
                            </a>

                            <!-- 4. Facebook -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $current_share_encoded_url; ?>" 
                               target="_blank" rel="noopener noreferrer" 
                               class="toc-share-btn share-fb" title="Bagikan ke Facebook" aria-label="Bagikan ke Facebook">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>

                            <!-- 5. LinkedIn -->
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= $current_share_encoded_url; ?>" 
                               target="_blank" rel="noopener noreferrer" 
                               class="toc-share-btn share-linkedin" title="Bagikan ke LinkedIn" aria-label="Bagikan ke LinkedIn">
                                <i class="fa-brands fa-linkedin-in"></i>
                            </a>

                            <!-- 6. Copy Link with Floating Tooltip -->
                            <div class="toc-share-copy-wrap">
                                <button type="button" 
                                   class="toc-share-btn share-copy" id="tocCopyLinkBtn" data-url="<?= $current_share_url; ?>" title="Salin Tautan Artikel" aria-label="Salin Tautan Artikel">
                                    <i class="fa-solid fa-link"></i>
                                </button>
                                <div class="toc-copy-tooltip" id="tocCopyTooltip" role="status" aria-live="polite">
                                    <span class="toc-tooltip-check"><i class="fa-solid fa-check"></i></span>
                                    <span class="toc-tooltip-text">Tautan Berhasil Disalin</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Right Side: Article Body -->
            <div class="article-main-col">
                <!-- Article Header (Matching Simple Layout in Reference Image 2) -->
                <header class="article-header" id="heading-article-title">
                    <?php 
                        $article_read_time = !empty($blog->read_time) ? intval($blog->read_time) : max(1, ceil(str_word_count(strip_tags($blog->content)) / 200));

                        $bulan_indo_art = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];

                        $pub_ts = strtotime(!empty($blog->published_at) ? $blog->published_at : ($blog->created_at ?: 'now'));
                        $pub_date_str = date('j', $pub_ts) . ' ' . $bulan_indo_art[(int)date('n', $pub_ts)] . ' ' . date('Y', $pub_ts);

                        // Check if article has ever been updated
                        $is_art_updated = false;
                        if (!empty($blog->updated_at) && $blog->updated_at != '0000-00-00 00:00:00') {
                            $upd_ts = strtotime($blog->updated_at);
                            $created_ts = strtotime($blog->created_at ?: '');
                            if ($upd_ts > 0 && ($created_ts <= 0 || $upd_ts > $created_ts)) {
                                $is_art_updated = true;
                            }
                        }

                        if ($is_art_updated) {
                            $upd_date_str = date('j', $upd_ts) . ' ' . $bulan_indo_art[(int)date('n', $upd_ts)] . ' ' . date('Y', $upd_ts);
                        } else {
                            $upd_date_str = '-';
                        }

                        $author_display_name = !empty($blog->author_name) ? $blog->author_name : (!empty($blog->author) ? $blog->author : 'Tim Vendio');
                    ?>

                    <div class="article-breadcrumbs">
                        <a href="<?= site_url(); ?>"><i class="fa-solid fa-house"></i> Home</a>
                        <span>/</span>
                        <a href="<?= site_url('blog'); ?>">Blog</a>
                        <span>/</span>
                        <?php if (!empty($blog->category_name)): ?>
                            <a href="<?= site_url('blog/category/' . (!empty($blog->category) ? $blog->category : url_title($blog->category_name, '-', true))); ?>"><?= _ent($blog->category_name); ?></a>
                        <?php else: ?>
                            <span>Ritel & Omnichannel</span>
                        <?php endif; ?>
                    </div>

                    <div class="article-read-estimate"><?= $article_read_time; ?> mins read</div>

                    <h1 class="article-title"><?= _ent($blog->title); ?></h1>

                    <div class="article-meta-dates">
                        <span class="meta-date-label">Diterbitkan</span> <span class="meta-date-val"><?= $pub_date_str; ?></span>
                        <span class="meta-date-sep">&bull;</span>
                        <span class="meta-date-label">Diperbarui</span> <span class="meta-date-val"><?= $upd_date_str; ?></span>
                    </div>

                    <div class="article-author-by">
                        <span class="author-by-label">Ditulis oleh:</span>
                        <span class="author-by-name"><?= _ent($author_display_name); ?></span>
                    </div>
                </header>


                <!-- Cover Image -->
                <?php if (!empty($image_url) && file_exists(FCPATH . 'uploads/blog/' . $first_image)): ?>
                    <div class="article-cover-wrap">
                        <img src="<?= $image_url; ?>" alt="<?= _ent($blog->title); ?>" class="article-cover-img">
                    </div>
                <?php endif; ?>

                <!-- Prose Content with Injected Heading IDs -->
                <article class="article-prose" id="article-prose-content">
                    <?= $processed_content; ?>
                </article>

                <!-- Tags -->
                <?php if (!empty($tags)): ?>
                    <div class="article-tags-wrap">
                        <span style="font-size: 0.85rem; font-weight: 600; color: var(--text-title);"><i class="fa-solid fa-tags" style="color: var(--primary-purple);"></i> Topik Terkait:</span>
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
                    <?php
                    $bulan_indo_rel = [
                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                    ];
                    ?>
                    <section class="related-section">
                        <h3 class="related-title">Artikel Terkait Lainnya</h3>
                        <div class="related-grid">
                            <?php 
                            $shown = 0;
                            foreach ($related as $rel): 
                                if ($rel->id == $blog->id) continue;
                                if ($shown >= 2) break;
                                $shown++;

                                $rel_first_image = '';
                                if (!empty($rel->image)) {
                                    $rel_imgs = explode(',', $rel->image);
                                    $rel_first_image = trim($rel_imgs[0]);
                                }
                                $rel_has_file = !empty($rel_first_image) && file_exists(FCPATH . 'uploads/blog/' . $rel_first_image);
                                $rel_image_url = $rel_has_file ? BASE_URL . 'uploads/blog/' . $rel_first_image : '';

                                $rel_pub_ts = strtotime(!empty($rel->published_at) ? $rel->published_at : ($rel->created_at ?: 'now'));
                                $rel_pub_date_str = date('j', $rel_pub_ts) . ' ' . $bulan_indo_rel[(int)date('n', $rel_pub_ts)] . ' ' . date('Y', $rel_pub_ts);
                                $rel_read_time = !empty($rel->read_time) ? $rel->read_time : max(1, ceil(str_word_count(strip_tags($rel->content)) / 200));

                                $rel_author_display = !empty($rel->author_name) ? $rel->author_name : (!empty($rel->author) ? $rel->author : 'Penulis Vendio');
                                $rel_author_avatar_file = !empty($rel->author_avatar) ? $rel->author_avatar : '';
                                $rel_has_author_avatar = !empty($rel_author_avatar_file) && file_exists(FCPATH . 'uploads/user/' . $rel_author_avatar_file);
                                $rel_author_avatar_url = $rel_has_author_avatar ? BASE_URL . 'uploads/user/' . $rel_author_avatar_file : 'https://ui-avatars.com/api/?name=' . urlencode($rel_author_display) . '&background=eff6ff&color=2563eb&size=64';
                            ?>
                                <article class="related-card">
                                    <!-- 1. image di div sendiri -->
                                    <div class="related-card-img-wrap">
                                        <a href="<?= site_url('blog/' . $rel->slug); ?>" title="<?= _ent($rel->title); ?>">
                                            <?php if (!empty($rel_image_url)): ?>
                                                <img src="<?= $rel_image_url; ?>" alt="<?= _ent($rel->title); ?>" class="related-card-img" loading="lazy">
                                            <?php else: ?>
                                                <div class="related-card-placeholder">
                                                    <i class="fa-solid fa-newspaper"></i>
                                                </div>
                                            <?php endif; ?>
                                        </a>
                                    </div>

                                    <!-- 2. Kategori -->
                                    <div class="related-card-category">
                                        <?= !empty($rel->category_name) ? _ent($rel->category_name) : 'Omnichannel Marketplace'; ?>
                                    </div>

                                    <!-- 3. Judul artikel -->
                                    <h4 class="related-card-title">
                                        <a href="<?= site_url('blog/' . $rel->slug); ?>" title="<?= _ent($rel->title); ?>">
                                            <?= _ent($rel->title); ?>
                                        </a>
                                    </h4>

                                    <!-- 4. waktu di buat dan estimasi baca -->
                                    <div class="related-card-meta">
                                        <span><?= $rel_pub_date_str; ?></span>
                                        <span class="meta-dot">&bull;</span>
                                        <span><?= $rel_read_time; ?> mins read</span>
                                    </div>

                                    <!-- 5. author -->
                                    <div class="related-card-author">
                                        <img src="<?= $rel_author_avatar_url; ?>" alt="<?= _ent($rel_author_display); ?>" class="related-card-author-avatar" loading="lazy">
                                        <span class="related-card-author-name"><?= _ent($rel_author_display); ?></span>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- Mobile Floating Share Action Button (FAB) & 2x3 Grid Popup (Matching Image 2) -->
    <div class="mobile-share-fab-container" id="mobileShareFabContainer">
        <!-- Backdrop -->
        <div class="mobile-share-backdrop" id="mobileShareBackdrop"></div>

        <!-- 2-Column x 3-Row Grid Popup Menu inside Green Card -->
        <div class="mobile-share-card" id="mobileShareCard" role="dialog" aria-label="Opsi Bagikan Artikel">
            <div class="mobile-share-grid">
                <!-- 1. WhatsApp -->
                <a href="https://api.whatsapp.com/send?text=<?= $current_share_title; ?>%20<?= $current_share_encoded_url; ?>" 
                   target="_blank" rel="noopener noreferrer" 
                   class="mobile-share-item item-wa" title="WhatsApp" aria-label="Bagikan ke WhatsApp">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>

                <!-- 2. Instagram -->
                <a href="https://www.instagram.com/" 
                   target="_blank" rel="noopener noreferrer" 
                   class="mobile-share-item item-ig" id="mobileShareIgBtn" data-url="<?= $current_share_url; ?>" title="Instagram" aria-label="Bagikan ke Instagram">
                    <i class="fa-brands fa-instagram"></i>
                </a>

                <!-- 3. X (Twitter) -->
                <a href="https://twitter.com/intent/tweet?text=<?= $current_share_title; ?>&url=<?= $current_share_encoded_url; ?>" 
                   target="_blank" rel="noopener noreferrer" 
                   class="mobile-share-item item-x" title="X (Twitter)" aria-label="Bagikan ke X">
                    <i class="fa-brands fa-x-twitter"></i>
                </a>

                <!-- 4. Facebook -->
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $current_share_encoded_url; ?>" 
                   target="_blank" rel="noopener noreferrer" 
                   class="mobile-share-item item-fb" title="Facebook" aria-label="Bagikan ke Facebook">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>

                <!-- 5. LinkedIn -->
                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= $current_share_encoded_url; ?>" 
                   target="_blank" rel="noopener noreferrer" 
                   class="mobile-share-item item-linkedin" title="LinkedIn" aria-label="Bagikan ke LinkedIn">
                    <i class="fa-brands fa-linkedin-in"></i>
                </a>

                <!-- 6. Copy Link -->
                <button type="button" class="mobile-share-item item-copy" id="mobileCopyLinkBtn" data-url="<?= $current_share_url; ?>" title="Salin Tautan" aria-label="Salin Tautan">
                    <i class="fa-solid fa-link"></i>
                </button>
            </div>

            <!-- Floating Feedback Tooltip for mobile -->
            <div class="mobile-copy-tooltip" id="mobileCopyTooltip">
                <span class="toc-tooltip-check"><i class="fa-solid fa-check"></i></span>
                <span class="toc-tooltip-text">Tautan Berhasil Disalin</span>
            </div>
        </div>

        <!-- Floating Green Trigger Button (Share Paper Plane Icon) -->
        <button type="button" class="mobile-share-fab-btn" id="mobileShareFabBtn" aria-label="Bagikan Artikel" title="Bagikan Artikel">
            <i class="fa-solid fa-paper-plane fab-icon-plane"></i>
            <i class="fa-solid fa-xmark fab-icon-close"></i>
        </button>
    </div>

    <!-- Floating Scroll-To-Top Button (Directly above Mobile Share Button) -->
    <button type="button" class="floating-scroll-top-btn" id="scrollTopBtn" aria-label="Kembali ke atas" title="Kembali ke atas">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

    <!-- Footer (Matching Landing Page & Image 2) -->
    <footer class="site-footer footer-light">
        <div class="container">
            <div class="footer-grid">
                <!-- Column 1: Brand Info -->
                <div>
                    <a href="<?= site_url(); ?>" class="brand-logo" style="margin-bottom: 6px; display: inline-flex; align-items: center; gap: 10px;" title="Vendio Omnichannel ERP">
                        <img src="<?= BASE_ASSET; ?>img/vendio-logo.png" alt="Vendio Logo" class="brand-logo-icon" style="height: 32px;">
                        <div class="brand-name">
                            <span class="brand-name-title" style="font-size: 1.35rem;">VENDIO</span>
                            <span class="brand-name-sub" style="font-size: 0.44rem;">OMNICHANNEL ERP</span>
                        </div>
                    </a>
                    <p class="footer-brand-desc">
                        Platform ERP dan orkestrasi omnichannel enterprise untuk seller ritel, brand distributor, dan pelaku e-commerce skala bertumbuh di Indonesia.
                    </p>
                </div>

                <!-- Column 2: MODUL ERP -->
                <div>
                    <h5 class="footer-col-title">MODUL ERP</h5>
                    <ul class="footer-nav-list">
                        <li><a href="<?= site_url('#feature'); ?>">Sinkronisasi Katalog</a></li>
                        <li><a href="<?= site_url('#feature'); ?>">Orkestrasi Pesanan</a></li>
                        <li><a href="<?= site_url('#feature'); ?>">Multi-Gudang (WMS)</a></li>
                        <li><a href="<?= site_url('#feature'); ?>">Rekonsiliasi Finansial</a></li>
                        <li><a href="<?= site_url('#feature'); ?>">Audit &amp; Reporting</a></li>
                    </ul>
                </div>

                <!-- Column 3: KANAL INTEGRASI -->
                <div>
                    <h5 class="footer-col-title">KANAL INTEGRASI</h5>
                    <ul class="footer-nav-list">
                        <li><a href="<?= site_url('#showcase'); ?>">TikTok Shop Open API</a></li>
                        <li><a href="<?= site_url('#showcase'); ?>">Tokopedia Merchant Hub</a></li>
                        <li><a href="<?= site_url('#showcase'); ?>">Shopee Open Platform</a></li>
                        <li><a href="<?= site_url('#showcase'); ?>">Integrasi J&amp;T &amp; SiCepat</a></li>
                        <li><a href="<?= site_url('#showcase'); ?>">Accurate &amp; Jurnal ERP</a></li>
                    </ul>
                </div>

                <!-- Column 4: PERUSAHAAN & BLOG -->
                <div>
                    <h5 class="footer-col-title">PERUSAHAAN &amp; BLOG</h5>
                    <ul class="footer-nav-list">
                        <li><a href="<?= site_url('blog'); ?>">Vendio Tech Insights</a></li>
                        <li><a href="<?= site_url('blog'); ?>">Arsip Artikel Blog</a></li>
                        <li><a href="<?= $admin_url; ?>">Portal Login Admin</a></li>
                        <li><a href="<?= site_url('#faq'); ?>">Dokumentasi API</a></li>
                        <li><a href="<?= site_url('#faq'); ?>">Privasi &amp; Keamanan Data</a></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="footer-bottom-bar">
                <div style="font-size: 0.88rem; color: #64748b;">
                    &copy; <?= date('Y'); ?> Vendio Omnichannel Platform. Hak Cipta Dilindungi Undang-Undang.
                </div>
            </div>
        </div>
    </footer>
        <!-- Interactive Table of Contents (TOC) Controller -->
        <script id="article-toc-script">
            (function() {
                function updateNavHeight() {
                    const navbar = document.getElementById('navbar');
                    if (navbar) {
                        const rect = navbar.getBoundingClientRect();
                        const h = Math.round(rect.height) || navbar.offsetHeight || 65;
                        document.documentElement.style.setProperty('--nav-actual-height', h + 'px');
                    }
                }
                updateNavHeight();
                window.addEventListener('resize', updateNavHeight, { passive: true });

                function initTOC() {
                    updateNavHeight();
                    initShareButtons();
                    initScrollTopButton();

                    const nav = document.getElementById('toc-nav');
                    const sidebar = document.getElementById('article-toc-sidebar');
                    if (!nav) return;

                    // Idempotency: prevent duplicate event listeners on same DOM instance
                    if (nav._hasTocBound) {
                        return;
                    }
                    nav._hasTocBound = true;

                    const searchInput = document.getElementById('toc-search-input');
                    const searchClear = document.getElementById('toc-search-clear');
                    const mobileBarBtn = document.getElementById('toc-mobile-bar-btn');
                    const mobileCollapse = document.getElementById('toc-content-collapse');
                    const siteSearchLink = document.getElementById('toc-search-site-link');

                    // 1. Delegated Click Handler on nav (Robust Accordion Toggle & Smooth Scroll)
                    nav.addEventListener('click', function(e) {
                        // Check if clicked the Chevron Button (or its icon)
                        const chevronBtn = e.target.closest('.toc-chevron-btn');
                        if (chevronBtn) {
                            e.preventDefault();
                            e.stopPropagation();

                            const parentItem = chevronBtn.closest('.toc-item');
                            if (!parentItem) return;

                            const isCurrentlyOpen = parentItem.classList.contains('is-open');

                            if (isCurrentlyOpen) {
                                // User explicitly CLOSED this dropdown
                                parentItem.classList.remove('is-open');
                                parentItem.dataset.userCollapsed = 'true';
                                chevronBtn.setAttribute('aria-expanded', 'false');
                            } else {
                                // User explicitly OPENED this dropdown
                                parentItem.classList.add('is-open');
                                delete parentItem.dataset.userCollapsed;
                                chevronBtn.setAttribute('aria-expanded', 'true');
                            }
                            return;
                        }

                        // Check if clicked a TOC Anchor Link
                        const link = e.target.closest('a[href^="#"]');
                        if (link) {
                            const href = link.getAttribute('href');
                            if (!href || href === '#') return;

                            const targetEl = document.querySelector(href);
                            if (targetEl) {
                                e.preventDefault();
                                targetEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
                                try {
                                    history.replaceState(null, '', href);
                                } catch(err) {}

                                // If clicking an H2 with children, open it and clear userCollapsed
                                const parentH2 = link.closest('.toc-item-h2');
                                if (parentH2 && parentH2.classList.contains('has-children')) {
                                    delete parentH2.dataset.userCollapsed;
                                    parentH2.classList.add('is-open');
                                    const btn = parentH2.querySelector('.toc-chevron-btn');
                                    if (btn) btn.setAttribute('aria-expanded', 'true');
                                }

                                // Close mobile dropdown if open
                                if (mobileCollapse && mobileCollapse.classList.contains('is-open')) {
                                    mobileCollapse.classList.remove('is-open');
                                    if (mobileBarBtn) {
                                        mobileBarBtn.classList.remove('is-active');
                                        mobileBarBtn.setAttribute('aria-expanded', 'false');
                                    }
                                }
                            }
                        }
                    });

                    // 2. Mobile View Dropdown Toggle (Matching Image 2)
                    if (mobileBarBtn && mobileCollapse && !mobileBarBtn._hasBound) {
                        mobileBarBtn._hasBound = true;
                        mobileBarBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            const isOpening = !mobileCollapse.classList.contains('is-open');
                            mobileCollapse.classList.toggle('is-open', isOpening);
                            mobileBarBtn.classList.toggle('is-active', isOpening);
                            mobileBarBtn.setAttribute('aria-expanded', isOpening);
                        });

                        document.addEventListener('click', function(e) {
                            if (mobileCollapse.classList.contains('is-open')) {
                                if (!mobileCollapse.contains(e.target) && !mobileBarBtn.contains(e.target)) {
                                    mobileCollapse.classList.remove('is-open');
                                    mobileBarBtn.classList.remove('is-active');
                                    mobileBarBtn.setAttribute('aria-expanded', 'false');
                                }
                            }
                        });
                    }

                    // 3. Live Search in TOC (Cari artikel di sini)
                    if (searchInput && !searchInput._hasBound) {
                        searchInput._hasBound = true;
                        searchInput.addEventListener('input', function() {
                            const query = this.value.trim().toLowerCase();
                            if (searchClear) searchClear.style.display = query ? 'block' : 'none';

                            if (siteSearchLink) {
                                siteSearchLink.href = '<?= site_url("blog?q="); ?>' + encodeURIComponent(query);
                            }

                            let visibleCount = 0;
                            const items = nav.querySelectorAll('.toc-item');

                            items.forEach(item => {
                                const h2Text = (item.getAttribute('data-text') || '').toLowerCase();
                                const subItems = item.querySelectorAll('.toc-sub-item');
                                let anySubMatch = false;

                                subItems.forEach(sub => {
                                    const subText = (sub.getAttribute('data-text') || '').toLowerCase();
                                    if (!query || subText.includes(query)) {
                                        sub.style.display = '';
                                        anySubMatch = true;
                                    } else {
                                        sub.style.display = 'none';
                                    }
                                });

                                const h2Match = !query || h2Text.includes(query);

                                if (h2Match || anySubMatch) {
                                    item.style.display = '';
                                    visibleCount++;
                                    // Auto open accordion if search query matched a child
                                    if (query && anySubMatch) {
                                        item.classList.add('is-open');
                                    }
                                } else {
                                    item.style.display = 'none';
                                }
                            });

                            if (emptyState) {
                                emptyState.style.display = (visibleCount === 0 && query) ? 'block' : 'none';
                            }
                        });

                        searchInput.addEventListener('keydown', function(e) {
                            if (e.key === 'Enter') {
                                const val = this.value.trim();
                                if (val) {
                                    window.location.href = '<?= site_url("blog?q="); ?>' + encodeURIComponent(val);
                                }
                            }
                        });
                    }

                    if (searchClear && !searchClear._hasBound) {
                        searchClear._hasBound = true;
                        searchClear.addEventListener('click', function() {
                            if (searchInput) {
                                searchInput.value = '';
                                searchInput.dispatchEvent(new Event('input'));
                                searchInput.focus();
                            }
                        });
                    }

                    // 4. ScrollSpy with User-Collapse Respect
                    const headingsToWatch = [
                        document.getElementById('heading-article-title'),
                        ...Array.from(document.querySelectorAll('#article-prose-content h2, #article-prose-content h3'))
                    ].filter(Boolean);

                    if (headingsToWatch.length > 0) {
                        function updateActiveTOC(activeId) {
                            // Remove existing active states
                            nav.querySelectorAll('.toc-item.is-active, .toc-sub-item.is-active').forEach(el => {
                                el.classList.remove('is-active');
                            });

                            // If scrolled past article or no active heading, collapse open sections and exit
                            if (!activeId) {
                                nav.querySelectorAll('.toc-item-h2.has-children').forEach(h2Item => {
                                    const btn = h2Item.querySelector('.toc-chevron-btn');
                                    h2Item.classList.remove('is-open');
                                    delete h2Item.dataset.userCollapsed;
                                    if (btn) btn.setAttribute('aria-expanded', 'false');
                                });
                                return;
                            }

                            let currentActiveH2 = null;

                            // 1. Check if activeId belongs to an H3 sub-item
                            const subItem = nav.querySelector(`.toc-sub-item[data-target="${activeId}"]`);
                            if (subItem) {
                                subItem.classList.add('is-active');
                                currentActiveH2 = subItem.closest('.toc-item-h2');
                            } else {
                                // 2. Otherwise check H2 or H1
                                const topItem = nav.querySelector(`.toc-item[data-target="${activeId}"]`);
                                if (topItem) {
                                    topItem.classList.add('is-active');
                                    if (topItem.classList.contains('toc-item-h2')) {
                                        currentActiveH2 = topItem;
                                    }
                                }
                            }

                            // 3. Auto-close dropdowns of H2s that are NOT the current active section
                            nav.querySelectorAll('.toc-item-h2.has-children').forEach(h2Item => {
                                const btn = h2Item.querySelector('.toc-chevron-btn');
                                if (h2Item === currentActiveH2) {
                                    // In current active H2: open it if user hasn't explicitly closed it
                                    if (h2Item.dataset.userCollapsed !== 'true') {
                                        h2Item.classList.add('is-open');
                                        if (btn) btn.setAttribute('aria-expanded', 'true');
                                    }
                                } else {
                                    // Not in this H2: automatically close it!
                                    h2Item.classList.remove('is-open');
                                    delete h2Item.dataset.userCollapsed; // reset so it will open when entered later
                                    if (btn) btn.setAttribute('aria-expanded', 'false');
                                }
                            });
                        }

                        // Reading Progress Bar & Auto Hide/Show Controller (Matching Image 2 Mekari Desty)
                        function updateReadingProgress() {
                            const progressBar = document.getElementById('tocMobileProgressBar');
                            const tocCol = document.getElementById('article-toc-sidebar');
                            const proseEl = document.getElementById('article-prose-content');
                            if (!progressBar || !tocCol || !proseEl) return;

                            const relatedSection = document.querySelector('.related-section') || document.querySelector('.article-tags-wrap') || document.querySelector('.site-footer');

                            // 1. Dynamic header threshold (Navbar actual height + mobile green bar height)
                            const navActualHeight = parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--nav-actual-height')) || 65;
                            const hideThreshold = navActualHeight + 68; // ~133px from top of viewport

                            // 2. Calculate reading boundaries
                            const proseRect = proseEl.getBoundingClientRect();
                            const articleTop = proseRect.top + window.scrollY;
                            const articleEnd = relatedSection 
                                ? (relatedSection.getBoundingClientRect().top + window.scrollY)
                                : (proseRect.bottom + window.scrollY);

                            const scrollY = window.scrollY;
                            const readPos = scrollY + hideThreshold;

                            // 3. Compute progress percentage (0% to 100%)
                            let progress = 0;
                            const totalDistance = articleEnd - articleTop;
                            if (totalDistance > 0) {
                                if (readPos <= articleTop) {
                                    progress = 0;
                                } else if (readPos >= articleEnd) {
                                    progress = 100;
                                } else {
                                    progress = Math.min(100, Math.max(0, ((readPos - articleTop) / totalDistance) * 100));
                                }
                            }

                            progressBar.style.width = progress.toFixed(1) + '%';

                            // 4. Check if scrolled past article title ("pas setelah melewati judulnya")
                            const titleEl = document.querySelector('.article-title') || document.getElementById('heading-article-title');
                            let passedTitle = true;
                            if (titleEl) {
                                const titleRect = titleEl.getBoundingClientRect();
                                // Passed title when the bottom of title has scrolled up past the navbar
                                passedTitle = titleRect.bottom <= (navActualHeight + 10);
                            }

                            // 5. Check if entered cards section below article ("card untuk pindah ke view artikel lain")
                            let enteredCards = false;
                            if (relatedSection) {
                                const relatedRect = relatedSection.getBoundingClientRect();
                                if (relatedRect.top <= hideThreshold) {
                                    enteredCards = true;
                                }
                            } else if (progress >= 100) {
                                enteredCards = true;
                            }

                            // Only show mobile TOC bar if user has passed the title AND not entered the cards below
                            const shouldShow = passedTitle && !enteredCards;

                            if (!shouldShow) {
                                if (!tocCol.classList.contains('is-hidden')) {
                                    tocCol.classList.add('is-hidden');
                                    // Auto close mobile dropdown if open
                                    const mobileCollapse = document.getElementById('toc-content-collapse');
                                    const mobileBarBtn = document.getElementById('toc-mobile-bar-btn');
                                    if (mobileCollapse && mobileCollapse.classList.contains('is-open')) {
                                        mobileCollapse.classList.remove('is-open');
                                        if (mobileBarBtn) {
                                            mobileBarBtn.classList.remove('is-active');
                                            mobileBarBtn.setAttribute('aria-expanded', 'false');
                                        }
                                    }
                                }
                            } else {
                                if (tocCol.classList.contains('is-hidden')) {
                                    tocCol.classList.remove('is-hidden');
                                }
                            }
                        }

                        // Window Scroll listener to find heading currently in reading position
                        let scrollTimeout;
                        function onScrollCheck() {
                            updateReadingProgress();
                            if (typeof checkScrollTopVisibility === 'function') {
                                checkScrollTopVisibility();
                            }

                            const proseEl = document.getElementById('article-prose-content');
                            const relatedSection = document.querySelector('.related-section');
                            const tagsWrap = document.querySelector('.article-tags-wrap');
                            const footerEl = document.querySelector('.site-footer');

                            const navActualHeight = parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--nav-actual-height')) || 65;
                            const boundaryThreshold = navActualHeight + 70; // ~135px from top of viewport

                            let isPastArticle = false;

                            // Check if user has scrolled past the article content into related cards or footer
                            if (relatedSection && relatedSection.getBoundingClientRect().top <= boundaryThreshold) {
                                isPastArticle = true;
                            } else if (tagsWrap && tagsWrap.getBoundingClientRect().top <= boundaryThreshold) {
                                isPastArticle = true;
                            } else if (proseEl && proseEl.getBoundingClientRect().bottom <= boundaryThreshold) {
                                isPastArticle = true;
                            } else if (footerEl && footerEl.getBoundingClientRect().top <= boundaryThreshold) {
                                isPastArticle = true;
                            } else if (relatedSection && (window.innerHeight + window.scrollY >= document.documentElement.scrollHeight - 25) && relatedSection.getBoundingClientRect().top <= window.innerHeight * 0.75) {
                                isPastArticle = true;
                            }

                            if (isPastArticle) {
                                updateActiveTOC(null);
                                return;
                            }

                            const scrollPos = window.scrollY + 120;
                            let currentHeading = headingsToWatch[0];

                            for (let i = 0; i < headingsToWatch.length; i++) {
                                const heading = headingsToWatch[i];
                                const offsetTop = heading.getBoundingClientRect().top + window.scrollY;
                                if (offsetTop <= scrollPos) {
                                    currentHeading = heading;
                                } else {
                                    break;
                                }
                            }

                            if (currentHeading && currentHeading.id) {
                                updateActiveTOC(currentHeading.id);
                            }
                        }

                        window.addEventListener('scroll', function() {
                            if (scrollTimeout) cancelAnimationFrame(scrollTimeout);
                            scrollTimeout = requestAnimationFrame(onScrollCheck);
                        }, { passive: true });

                        window.addEventListener('resize', updateReadingProgress, { passive: true });

                        // Run once on load
                        onScrollCheck();
                    }

                }

                // 5. Social Share Actions (Desktop & Mobile, Independent from TOC presence)
                function initShareButtons() {
                    // --- Desktop Share: Salin Tautan (Copy Link) ---
                    const copyBtn = document.getElementById('tocCopyLinkBtn');
                    if (copyBtn && !copyBtn._hasBound) {
                        copyBtn._hasBound = true;
                        copyBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            const urlToCopy = this.getAttribute('data-url') || window.location.href;

                            let copyTimer = null;
                            function showCopySuccess() {
                                const tooltip = document.getElementById('tocCopyTooltip');
                                if (tooltip) {
                                    tooltip.classList.add('is-visible');
                                    if (copyTimer) clearTimeout(copyTimer);
                                    copyTimer = setTimeout(() => {
                                        tooltip.classList.remove('is-visible');
                                    }, 2400);

                                    // Pastikan tooltip terlihat utuh dan tidak terpotong container sticky card
                                    const stickyCard = document.querySelector('.toc-sticky-card');
                                    if (stickyCard) {
                                        requestAnimationFrame(() => {
                                            const cardRect = stickyCard.getBoundingClientRect();
                                            const tooltipRect = tooltip.getBoundingClientRect();
                                            if (tooltipRect.bottom > cardRect.bottom) {
                                                stickyCard.scrollBy({
                                                    top: (tooltipRect.bottom - cardRect.bottom) + 18,
                                                    behavior: 'smooth'
                                                });
                                            }
                                        });
                                    }
                                }
                            }

                            if (navigator.clipboard && navigator.clipboard.writeText) {
                                navigator.clipboard.writeText(urlToCopy).then(showCopySuccess).catch(() => {
                                    fallbackCopyText(urlToCopy);
                                    showCopySuccess();
                                });
                            } else {
                                fallbackCopyText(urlToCopy);
                                showCopySuccess();
                            }
                        });
                    }

                    // --- Desktop Share: Instagram (Salin tautan) ---
                    const igBtn = document.getElementById('tocShareIgBtn');
                    if (igBtn && !igBtn._hasBound) {
                        igBtn._hasBound = true;
                        igBtn.addEventListener('click', function() {
                            const urlToCopy = this.getAttribute('data-url') || window.location.href;
                            if (navigator.clipboard && navigator.clipboard.writeText) {
                                navigator.clipboard.writeText(urlToCopy).catch(() => {});
                            }
                        });
                    }

                    // --- Mobile Share FAB & Popup Grid (Matching Image 2) ---
                    const fabContainer = document.getElementById('mobileShareFabContainer');
                    const fabBtn = document.getElementById('mobileShareFabBtn');
                    const backdrop = document.getElementById('mobileShareBackdrop');
                    const mobileCopyBtn = document.getElementById('mobileCopyLinkBtn');
                    const mobileIgBtn = document.getElementById('mobileShareIgBtn');

                    // Toggle FAB popup on trigger click
                    if (fabBtn && fabContainer && !fabBtn._hasBound) {
                        fabBtn._hasBound = true;
                        fabBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            const isOpen = fabContainer.classList.contains('is-open');
                            if (isOpen) {
                                fabContainer.classList.remove('is-open');
                                fabBtn.setAttribute('aria-expanded', 'false');
                            } else {
                                fabContainer.classList.add('is-open');
                                fabBtn.setAttribute('aria-expanded', 'true');
                            }
                            if (typeof checkScrollTopVisibility === 'function') {
                                checkScrollTopVisibility();
                            }
                        });
                    }

                    // Close FAB on backdrop click
                    if (backdrop && fabContainer && !backdrop._hasBound) {
                        backdrop._hasBound = true;
                        backdrop.addEventListener('click', function(e) {
                            e.preventDefault();
                            fabContainer.classList.remove('is-open');
                            if (fabBtn) fabBtn.setAttribute('aria-expanded', 'false');
                            if (typeof checkScrollTopVisibility === 'function') {
                                checkScrollTopVisibility();
                            }
                        });
                    }

                    // Mobile Copy Link with elegant tooltip feedback
                    if (mobileCopyBtn && !mobileCopyBtn._hasBound) {
                        mobileCopyBtn._hasBound = true;
                        mobileCopyBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            const urlToCopy = this.getAttribute('data-url') || window.location.href;

                            let mobTimer = null;
                            function showMobileCopySuccess() {
                                const mobTooltip = document.getElementById('mobileCopyTooltip');
                                if (mobTooltip) {
                                    mobTooltip.classList.add('is-visible');
                                    if (mobTimer) clearTimeout(mobTimer);
                                    mobTimer = setTimeout(() => {
                                        mobTooltip.classList.remove('is-visible');
                                    }, 2400);
                                }
                            }

                            if (navigator.clipboard && navigator.clipboard.writeText) {
                                navigator.clipboard.writeText(urlToCopy).then(showMobileCopySuccess).catch(() => {
                                    fallbackCopyText(urlToCopy);
                                    showMobileCopySuccess();
                                });
                            } else {
                                fallbackCopyText(urlToCopy);
                                showMobileCopySuccess();
                            }
                        });
                    }

                    // Mobile Instagram (Copy link)
                    if (mobileIgBtn && !mobileIgBtn._hasBound) {
                        mobileIgBtn._hasBound = true;
                        mobileIgBtn.addEventListener('click', function() {
                            const urlToCopy = this.getAttribute('data-url') || window.location.href;
                            if (navigator.clipboard && navigator.clipboard.writeText) {
                                navigator.clipboard.writeText(urlToCopy).catch(() => {});
                            }
                        });
                    }

                    // Auto-close FAB when clicking external social share links
                    if (fabContainer && !fabContainer._hasItemClicksBound) {
                        fabContainer._hasItemClicksBound = true;
                        fabContainer.querySelectorAll('a.mobile-share-item').forEach(link => {
                            link.addEventListener('click', function() {
                                setTimeout(() => {
                                    fabContainer.classList.remove('is-open');
                                    if (fabBtn) fabBtn.setAttribute('aria-expanded', 'false');
                                    if (typeof checkScrollTopVisibility === 'function') {
                                        checkScrollTopVisibility();
                                    }
                                }, 300);
                            });
                        });
                    }

                    // Close on Escape key
                    if (!window._hasFabEscBound) {
                        window._hasFabEscBound = true;
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape' && fabContainer && fabContainer.classList.contains('is-open')) {
                                fabContainer.classList.remove('is-open');
                                if (fabBtn) fabBtn.setAttribute('aria-expanded', 'false');
                                if (typeof checkScrollTopVisibility === 'function') {
                                    checkScrollTopVisibility();
                                }
                            }
                        });
                    }
                }

                // 6. Floating Scroll-To-Top Button
                function checkScrollTopVisibility() {
                    const scrollBtn = document.getElementById('scrollTopBtn');
                    if (!scrollBtn) return;
                    const fabContainer = document.getElementById('mobileShareFabContainer');
                    const isShareOpen = fabContainer && fabContainer.classList.contains('is-open');

                    if (!isShareOpen && window.scrollY > 200) {
                        scrollBtn.classList.add('is-visible');
                    } else {
                        scrollBtn.classList.remove('is-visible');
                    }
                }

                function initScrollTopButton() {
                    const scrollBtn = document.getElementById('scrollTopBtn');
                    if (!scrollBtn) return;

                    if (!scrollBtn._hasScrollBound) {
                        scrollBtn._hasScrollBound = true;
                        scrollBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            window.scrollTo({
                                top: 0,
                                behavior: 'smooth'
                            });
                        });

                        window.addEventListener('scroll', function() {
                            checkScrollTopVisibility();
                        }, { passive: true });
                    }

                    checkScrollTopVisibility();
                }

                function fallbackCopyText(text) {
                    const tempInput = document.createElement('textarea');
                    tempInput.value = text;
                    tempInput.style.position = 'fixed';
                    tempInput.style.left = '-9999px';
                    document.body.appendChild(tempInput);
                    tempInput.focus();
                    tempInput.select();
                    try { document.execCommand('copy'); } catch(err) {}
                    tempInput.remove();
                }

                // Expose globally so transition router and page can call it
                window.initArticleTOC = initTOC;

                // Initialize on DOM load
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initTOC);
                } else {
                    initTOC();
                }

                // Safe re-run on BFCache / page transition
                window.addEventListener('pageshow', initTOC);
            })();
        </script>
        </div><!-- /#app-page-view -->
    </div><!-- /#app-page-stage -->

    <script>
        // BFCache reset safety
        window.addEventListener('pageshow', function() {
            const currentView = document.getElementById('app-page-view');
            if (currentView) {
                currentView.classList.remove('slide-out-left', 'slide-out-right', 'slide-in-right', 'slide-in-left');
                currentView.style.opacity = '';
                currentView.style.transform = '';
                currentView.style.pointerEvents = '';
            }
        });
    </script>

    <!-- Seamless Page Transition Router -->
    <script src="<?= BASE_ASSET; ?>js/vendio-page-transition.js?v=<?= file_exists(FCPATH . 'asset/js/vendio-page-transition.js') ? filemtime(FCPATH . 'asset/js/vendio-page-transition.js') : time(); ?>"></script>
</body>
</html>