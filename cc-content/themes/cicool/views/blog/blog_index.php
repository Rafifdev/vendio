<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$is_logged_in = function_exists('app') && isset(app()->aauth) && app()->aauth->is_loggedin();
$user_name = $is_logged_in ? get_user_data('full_name') : '';
$admin_url = $is_logged_in ? site_url('administrator/dashboard') : site_url('administrator/login');
$search_q = $this->input->get('q');
$curr_cat_id = null;
if (!empty($category_id)) {
    $curr_cat_id = (int)$category_id;
} else {
    $s1 = $this->uri->segment(1);
    $s2 = $this->uri->segment(2);
    $s3 = $this->uri->segment(3);
    if ($s1 === 'blog' && $s2 === 'category' && is_numeric($s3)) {
        $curr_cat_id = (int)$s3;
    } elseif ($s2 === 'category' && is_numeric($s3)) {
        $curr_cat_id = (int)$s3;
    } elseif ($s1 === 'category' && is_numeric($s2)) {
        $curr_cat_id = (int)$s2;
    }
}
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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Vendio Brand Fonts (Impact BC & Vladivostok) -->
    <link rel="stylesheet" href="<?= BASE_ASSET; ?>fonts/vendio-brand-fonts.css">

    <style id="vendio-blog-styles">
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
           DESIGN SYSTEM (MATCHING VENDIO LANDING PAGE PALETTE)
           ========================================================================== */
        :root {
            --bg-body: #ffffff;
            --bg-alt: #f7f2eb;
            --bg-cream: #f7f2eb;
            --bg-sand: #eae2d6;
            --bg-card: #ffffff;
            
            --primary-purple: #8b9a6e;
            --primary-purple-hover: #77855b;
            --primary-dark: #55643b;
            --primary-gradient: linear-gradient(135deg, #8b9a6e 0%, #5d6e42 100%);
            
            --text-title: #232b1e;
            --text-heading: #2d3827;
            --text-body: #55614e;
            --text-muted: #828f7c;

            --border-light: #eae2d6;
            --border-card: rgba(234, 226, 214, 0.95);

            --shadow-sm: 0 2px 8px rgba(139, 154, 110, 0.08);
            --shadow-card: 0 10px 28px -4px rgba(35, 43, 30, 0.08), 0 4px 12px -2px rgba(35, 43, 30, 0.04);
            --shadow-card-hover: 0 22px 45px -8px rgba(35, 43, 30, 0.12), 0 8px 18px -4px rgba(139, 154, 110, 0.08);
            
            --font-main: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            --font-heading: 'Poppins', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            font-size: 16px;
            scroll-behavior: smooth;
            background-color: var(--bg-body);
            color: var(--text-heading);
        }

        body {
            font-family: var(--font-main);
            background-color: var(--bg-body);
            color: var(--text-body);
            line-height: 1.65;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        a {
            color: inherit;
            text-decoration: none;
            transition: all 0.25s ease;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
            padding-left: 24px;
            padding-right: 24px;
            position: relative;
        }

        /* ==========================================================================
           1. NAVIGATION BAR (Full BG at Top with Rounded Bottom Corners & Shadow, Floating Island when Scrolled)
           ========================================================================== */
        .navbar-main {
            position: fixed;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 100%;
            z-index: 100;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            padding: 14px 0;
            border-bottom: 1px solid rgba(226, 232, 240, 0.85);
            border-left: 1px solid transparent;
            border-right: 1px solid transparent;
            border-top: none;
            border-radius: 0 0 24px 24px;
            box-shadow: 0 10px 30px -4px rgba(15, 23, 42, 0.08), 0 4px 12px -2px rgba(139, 154, 110, 0.04);
            pointer-events: auto;
            transition: top 0.4s cubic-bezier(0.16, 1, 0.3, 1),
                        width 0.4s cubic-bezier(0.16, 1, 0.3, 1),
                        max-width 0.4s cubic-bezier(0.16, 1, 0.3, 1),
                        border-radius 0.4s cubic-bezier(0.16, 1, 0.3, 1),
                        box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1),
                        border-color 0.4s cubic-bezier(0.16, 1, 0.3, 1),
                        padding 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .navbar-main .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 28px;
            transition: padding 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .nav-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            background: transparent;
            padding: 0;
            border-radius: 0;
            box-shadow: none;
            border: none;
            pointer-events: auto;
        }

        /* Floating Island State when Scrolled */
        .navbar-main.is-scrolled {
            top: 14px;
            width: calc(100% - 40px);
            max-width: 1200px;
            border-radius: 20px;
            border: 1px solid rgba(226, 232, 240, 0.9);
            box-shadow: 0 16px 38px -6px rgba(15, 23, 42, 0.12), 0 6px 16px -2px rgba(139, 154, 110, 0.06);
            padding: 10px 0;
        }

        .navbar-main.is-scrolled .container {
            padding: 0 24px;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-logo-img,
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
            font-size: 1.38rem;
            color: #8b9a6e;
            letter-spacing: 0.15em;
            line-height: 1;
            text-transform: uppercase;
        }

        .brand-name-sub {
            font-family: 'Vladivostok', sans-serif;
            font-size: 0.47rem;
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
        }

        .nav-link {
            font-size: 0.92rem;
            font-weight: 600;
            color: #475569;
            position: relative;
            padding: 6px 0;
            transition: all 0.2s ease;
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

        .mobile-dropdown-card,
        .mobile-menu-backdrop {
            display: none;
        }

        /* ==========================================================================
           2. BLOG HERO HEADER
           ========================================================================== */
        .blog-header {
            position: relative;
            padding: 110px 0 35px 0;
            background: #ffffff;
            border-bottom: none;
            text-align: center;
            overflow: hidden;
        }

        /* Entrance Keyframes for Reload & Page Change */
        @keyframes blogHeroTitleIn {
            0% {
                opacity: 0;
                transform: translateY(-16px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes blogHeroIndicatorIn {
            0% {
                opacity: 0;
                transform: scaleX(0);
            }
            100% {
                opacity: 1;
                transform: scaleX(1);
            }
        }

        @keyframes blogHeroFadeUp {
            0% {
                opacity: 0;
                transform: translateY(22px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .blog-header-title {
            font-family: var(--font-heading);
            font-size: clamp(2.2rem, 4.2vw, 3.2rem);
            font-weight: 800;
            color: var(--text-title);
            line-height: 1.25;
            letter-spacing: -0.02em;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
            animation: blogHeroTitleIn 0.7s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        .blog-header-indicator {
            height: 3px;
            width: 56px;
            background: var(--primary-purple);
            margin: 0 auto 18px auto;
            border-radius: 2px;
            position: relative;
            z-index: 1;
            transform-origin: center;
            animation: blogHeroIndicatorIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) 0.12s both;
        }

        .blog-header-desc {
            font-size: 1.05rem;
            color: var(--text-body);
            line-height: 1.65;
            max-width: 680px;
            margin: 0 auto 34px auto;
            position: relative;
            z-index: 1;
            animation: blogHeroFadeUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.2s both;
        }

        /* Search Pill Bar */
        .search-bar-wrap {
            max-width: 560px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
            animation: blogHeroFadeUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.28s both;
        }

        .search-input-box {
            width: 100%;
            height: 52px;
            padding: 0 54px 0 24px;
            background: #ffffff;
            border: 1px solid #eae2d6;
            border-radius: 9999px;
            color: var(--text-title);
            font-size: 0.95rem;
            font-family: inherit;
            outline: none;
            box-shadow: 0 4px 20px rgba(35, 43, 30, 0.05);
            transition: all 0.25s ease;
        }

        .search-input-box:focus {
            border-color: var(--primary-purple);
            box-shadow: 0 0 0 4px rgba(139, 154, 110, 0.16), 0 8px 24px rgba(35, 43, 30, 0.08);
        }

        .search-btn-icon {
            position: absolute;
            right: 8px;
            top: 7px;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--primary-purple);
            color: #ffffff;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .search-btn-icon:hover {
            background: var(--primary-dark);
            transform: scale(1.05);
        }

        /* Category Filter Chips */
        .category-filter-strip {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
            margin: 28px auto 0 auto;
            position: relative;
            z-index: 1;
            max-width: 820px;
            animation: blogHeroFadeUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.36s both;
        }

        .cat-chip {
            font-size: 0.82rem;
            font-weight: 600;
            padding: 7px 18px;
            border-radius: 9999px;
            background: #ffffff;
            border: 1px solid #eae2d6;
            color: var(--text-body);
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(35, 43, 30, 0.03);
        }

        .cat-chip:hover {
            border-color: var(--primary-purple);
            color: var(--text-title);
            background: #fcfbfa;
            transform: translateY(-1px);
        }

        .cat-chip.active {
            background: var(--primary-purple);
            color: #ffffff;
            border-color: var(--primary-purple);
            box-shadow: 0 4px 14px rgba(139, 154, 110, 0.35);
        }

        /* ==========================================================================
           3. BLOG ARTICLES GRID (FULL-WIDTH CREAM SECTION MATCHING SHOWCASE)
           ========================================================================== */
        .blog-main-content {
            flex-grow: 1;
            padding: 70px 0 85px 0;
            background: var(--bg-cream); /* #f7f2eb */
            border-radius: 48px;
            position: relative;
            width: 100%;
        }

        .search-info-bar {
            margin-bottom: 28px;
            padding: 14px 20px;
            background: #ffffff;
            border: 1px solid rgba(234, 226, 214, 0.95);
            border-radius: 16px;
            font-size: 0.92rem;
            color: var(--text-body);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            box-shadow: 0 4px 12px rgba(35, 43, 30, 0.03);
        }

        .blog-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-bottom: 0;
        }

        .blog-card {
            background: transparent;
            border: none;
            border-bottom: 1px solid #e2e8f0;
            border-radius: 0;
            overflow: visible;
            display: flex;
            flex-direction: column;
            box-shadow: none;
            padding: 0 0 22px 0;
            /* Entrance Reveal State (Scroll, Reload, & Page Transition) */
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.5s cubic-bezier(0.16, 1, 0.3, 1),
                        transform 0.5s cubic-bezier(0.16, 1, 0.3, 1),
                        border-color 0.25s ease;
            transition-delay: calc(var(--card-col, 0) * 0.08s);
            will-change: opacity, transform;
            animation: blogCardSafeReveal 0.5s cubic-bezier(0.16, 1, 0.3, 1) 0.65s forwards;
        }

        .blog-card.is-revealed {
            animation: none;
            opacity: 1;
            transform: translateY(0);
        }

        .blog-card:hover {
            opacity: 1;
            transform: translateY(-4px);
            box-shadow: none;
            border-bottom-color: #cbd5e1;
            transition-delay: 0s !important;
        }

        @keyframes blogCardSafeReveal {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .blog-card {
                opacity: 1 !important;
                transform: none !important;
                animation: none !important;
                transition: none !important;
            }
        }

        .blog-card-img-wrap {
            width: 100%;
            aspect-ratio: 16 / 9;
            background: #f1f5f9;
            border-radius: 16px;
            overflow: hidden;
            display: block;
            margin-bottom: 20px;
            position: relative;
        }

        .blog-card-img-link {
            display: block;
            width: 100%;
            height: 100%;
            overflow: hidden;
            border-radius: 16px;
        }

        .blog-card-img {
            width: 100%;
            height: 100%;
            aspect-ratio: 16 / 9;
            object-fit: cover;
            border-radius: 16px;
            transition: transform 0.4s ease;
            display: block;
        }

        .blog-card:hover .blog-card-img {
            transform: scale(1.04);
        }

        .blog-card-placeholder {
            width: 100%;
            height: 100%;
            aspect-ratio: 16 / 9;
            background: linear-gradient(135deg, #f7f2eb 0%, #eae2d6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #8b9a6e;
            font-size: 2.5rem;
            opacity: 0.75;
            border-radius: 16px;
        }

        .blog-card-category {
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

        .blog-card-title {
            font-family: var(--font-heading);
            font-size: 1.35rem;
            font-weight: 600;
            line-height: 1.35;
            color: var(--text-title);
            margin: 0 0 14px 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            transition: color 0.2s ease;
        }

        .blog-card-title a {
            color: inherit;
            text-decoration: none;
        }

        .blog-card-title a:hover {
            color: var(--primary-purple);
        }

        .blog-card-meta {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.95rem;
            color: #6b7280;
            margin: 0 0 24px 0;
            line-height: 1.4;
        }

        .blog-card-meta .meta-dot {
            font-size: 0.85rem;
            color: #9ca3af;
            margin: 0 2px;
        }

        .blog-card-author {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: auto;
        }

        .blog-card-author-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            border: 1px solid rgba(0, 0, 0, 0.06);
            flex-shrink: 0;
        }

        .blog-card-author-name {
            font-size: 1rem;
            font-weight: 600;
            color: #2563eb;
            line-height: 1.2;
            transition: color 0.2s ease;
        }

        /* Empty State */
        .empty-blog-box {
            text-align: center;
            padding: 80px 24px;
            background: #ffffff;
            border: 1px solid var(--border-light);
            border-radius: 24px;
            margin-bottom: 60px;
            box-shadow: var(--shadow-card);
        }

        .empty-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: rgba(139, 154, 110, 0.12);
            color: var(--primary-purple);
            font-size: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px auto;
        }

        /* Enhanced Modern Pagination Styling */
        .pagination-wrap {
            display: flex;
            justify-content: center;
            margin-top: 35px;
            margin-bottom: 25px;
        }

        .pagination-wrap ul.pagination {
            display: inline-flex;
            list-style: none;
            gap: 8px;
            align-items: center;
            padding: 8px 12px;
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid rgba(234, 226, 214, 0.95);
            box-shadow: 0 4px 16px -2px rgba(35, 43, 30, 0.05);
        }

        .pagination-wrap ul.pagination li {
            display: inline-flex;
        }

        .pagination-wrap ul.pagination li a,
        .pagination-wrap ul.pagination li span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 42px;
            height: 42px;
            padding: 0 16px;
            border-radius: 12px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: var(--text-heading);
            font-size: 0.92rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .pagination-wrap ul.pagination li a:hover {
            border-color: var(--primary-purple);
            color: var(--primary-purple);
            background: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(139, 154, 110, 0.18);
        }

        .pagination-wrap ul.pagination li.active a,
        .pagination-wrap ul.pagination li.active span {
            background: var(--primary-purple) !important;
            border-color: var(--primary-purple) !important;
            color: #ffffff !important;
            box-shadow: 0 6px 16px rgba(139, 154, 110, 0.4) !important;
            cursor: default;
            pointer-events: none;
            transform: none !important;
        }

        /* Blog Grid Slide Animations */
        .blog-grid.grid-slide-out-left {
            animation: gridSlideOutLeft 0.26s cubic-bezier(0.16, 1, 0.3, 1) forwards !important;
            pointer-events: none;
        }

        .blog-grid.grid-slide-in-right {
            animation: gridSlideInRight 0.32s cubic-bezier(0.16, 1, 0.3, 1) forwards !important;
        }

        .blog-grid.grid-slide-out-right {
            animation: gridSlideOutRight 0.26s cubic-bezier(0.16, 1, 0.3, 1) forwards !important;
            pointer-events: none;
        }

        .blog-grid.grid-slide-in-left {
            animation: gridSlideInLeft 0.32s cubic-bezier(0.16, 1, 0.3, 1) forwards !important;
        }

        @keyframes gridSlideOutLeft {
            0% { opacity: 1; transform: translate3d(0, 0, 0); }
            100% { opacity: 0; transform: translate3d(-30px, 0, 0); }
        }

        @keyframes gridSlideInRight {
            0% { opacity: 0; transform: translate3d(30px, 0, 0); }
            100% { opacity: 1; transform: translate3d(0, 0, 0); }
        }

        @keyframes gridSlideOutRight {
            0% { opacity: 1; transform: translate3d(0, 0, 0); }
            100% { opacity: 0; transform: translate3d(30px, 0, 0); }
        }

        @keyframes gridSlideInLeft {
            0% { opacity: 0; transform: translate3d(-30px, 0, 0); }
            100% { opacity: 1; transform: translate3d(0, 0, 0); }
        }

        /* ==========================================================================
           4. FOOTER (Matching Landing Page Footer Style)
           ========================================================================== */
        .footer-light {
            background: #ffffff;
            border-top: none;
            padding: 50px 0 32px 0;
            font-size: 0.88rem;
            color: #64748b;
            margin-top: auto;
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
            margin-bottom: 18px;
        }

        .footer-brand-desc {
            font-size: 0.88rem;
            color: var(--text-body);
            line-height: 1.65;
            margin: 14px 0 20px 0;
            max-width: 360px;
        }

        .footer-nav-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .footer-nav-list a:hover {
            color: var(--primary-purple);
        }

        .footer-bottom-bar {
            border-top: 1px solid #f1ece4;
            padding-top: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 0.82rem;
            color: #94a3b8;
        }

        /* ==========================================================================
           RESPONSIVE (HP & TABLET)
           ========================================================================== */
        @media (max-width: 992px) {
            .navbar-main {
                border-radius: 0 0 18px 18px;
            }
            .navbar-main .container,
            .navbar-main.is-scrolled .container {
                padding: 0 16px;
            }
            .navbar-main.is-scrolled {
                top: 10px;
                width: calc(100% - 24px);
                border-radius: 16px;
                padding: 8px 0;
            }
            .blog-main-content { border-radius: 36px; padding: 50px 0 65px 0; }
            .blog-grid { grid-template-columns: repeat(2, 1fr); gap: 24px; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
            .nav-links { display: none !important; }
            .mobile-toggle { display: inline-flex; }
        }

        @media (max-width: 768px) {
            .brand-logo-icon { height: 28px; }
            .brand-name-title { font-size: 1.2rem; }
            .brand-name-sub { font-size: 0.44rem; }
            .blog-header { padding: 95px 0 25px 0; }
            .blog-main-content { border-radius: 24px; padding: 40px 0 50px 0; }
            .blog-grid { grid-template-columns: 1fr; gap: 20px; }
            .blog-card { transition-delay: 0s !important; }
            .blog-card-img-wrap { aspect-ratio: 16 / 9; height: auto; }
            .footer-grid { grid-template-columns: 1fr; }

            /* Mobile Dropdown Card matching Landing Page Image 2 */
            .mobile-dropdown-card {
                display: block;
                position: absolute;
                top: calc(100% + 8px);
                left: 12px;
                right: 12px;
                background: #ffffff;
                border: 1px solid rgba(226, 232, 240, 0.95);
                border-radius: 24px;
                padding: 14px;
                box-shadow: 0 24px 50px -12px rgba(15, 23, 42, 0.22), 0 10px 20px -5px rgba(0, 0, 0, 0.08);
                z-index: 105;
                opacity: 0;
                visibility: hidden;
                transform: translateY(-10px) scale(0.97);
                pointer-events: none;
                transition: opacity 0.28s cubic-bezier(0.16, 1, 0.3, 1),
                            transform 0.28s cubic-bezier(0.16, 1, 0.3, 1),
                            visibility 0.28s;
            }

            .navbar-main.is-scrolled .mobile-dropdown-card {
                left: 0;
                right: 0;
                top: calc(100% + 8px);
            }

            .mobile-dropdown-card.is-open {
                opacity: 1;
                visibility: visible;
                transform: translateY(0) scale(1);
                pointer-events: auto;
            }

            .mobile-dropdown-list {
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .mobile-dropdown-item {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 14px 18px;
                background: #f8fafc;
                border-radius: 14px;
                text-decoration: none;
                transition: all 0.2s ease;
            }

            .mobile-dropdown-item .item-label {
                font-family: var(--font-heading);
                font-size: 0.98rem;
                font-weight: 700;
                color: #2d3827;
            }

            .mobile-dropdown-item:hover,
            .mobile-dropdown-item.active {
                background: #f1f5f9;
            }

            .mobile-dropdown-item:hover .item-label,
            .mobile-dropdown-item.active .item-label {
                color: var(--primary-purple);
            }

            .mobile-menu-backdrop {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(15, 23, 42, 0.25);
                backdrop-filter: blur(4px);
                -webkit-backdrop-filter: blur(4px);
                z-index: 95;
                opacity: 0;
                visibility: hidden;
                pointer-events: none;
                transition: opacity 0.28s ease, visibility 0.28s;
            }

            .mobile-menu-backdrop.is-open {
                opacity: 1;
                visibility: visible;
                pointer-events: auto;
            }
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
            overflow-x: hidden;
        }

        .app-page-view {
            width: 100%;
            min-height: 100vh;
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

    <!-- Top Nav (100% matching Landing Page Image 2) -->
    <nav class="navbar-main" id="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <a href="<?= site_url(); ?>" class="brand-logo" title="Kembali ke atas">
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
        </div>

        <!-- Mobile Menu Dropdown Card (matching Image 2) -->
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
        <div id="app-page-view" class="app-page-view" data-page="blog">

    <!-- Hero Header Section -->
    <header class="blog-header">
        <div class="container">
            <h1 class="blog-header-title">Vendio Tech Insights</h1>
            <div class="blog-header-indicator"></div>
            <p class="blog-header-desc">
                Riset arsitektur ritel, panduan operasional multi-gudang, dan strategi mencegah overselling saat pesanan memuncak di TikTok Shop &amp; Tokopedia.
            </p>

            <!-- Search Form -->
            <div class="search-bar-wrap">
                <form action="<?= site_url('blog'); ?>" method="get">
                    <input type="text" name="q" class="search-input-box" placeholder="Cari artikel, topik, atau kata kunci..." value="<?= _ent($search_q); ?>">
                    <button type="submit" class="search-btn-icon" title="Cari">
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
                        <?php 
                            $is_cat_active = (!empty($curr_cat_id) && (int)$curr_cat_id === (int)$cat->category_id);
                        ?>
                        <a href="<?= site_url('blog/category/' . $cat->category_id . '/' . url_title($cat->category_name)); ?>" class="cat-chip <?= $is_cat_active ? 'active' : ''; ?>">
                            <?= _ent($cat->category_name); ?>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Main Content Area (Full-Width Cream Section matching Showcase) -->
    <main class="blog-main-content" id="blog-content-area">
        <div class="container">
            <?php if (!empty($search_q)): ?>
                <div class="search-info-bar">
                    <div>
                        Menampilkan hasil pencarian untuk: <strong style="color: var(--primary-purple);">"<?= _ent($search_q); ?>"</strong> (<?= intval($blog_counts); ?> artikel ditemukan)
                    </div>
                    <div>
                        <a href="<?= site_url('blog'); ?>" style="color: #ef4444; font-weight: 600; font-size: 0.85rem;">
                            <i class="fa-solid fa-xmark"></i> Hapus Filter Pencarian
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($blogs) && count($blogs) > 0): ?>
                <?php
                $bulan_indo = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                ];
                ?>
                <div class="blog-grid" id="blog-grid">
                    <?php 
                    $card_idx = 0;
                    foreach ($blogs as $item): 
                        $first_image = '';
                        if (!empty($item->image)) {
                            $imgs = explode(',', $item->image);
                            $first_image = trim($imgs[0]);
                        }
                        $image_url = !empty($first_image) ? BASE_URL . 'uploads/blog/' . $first_image : '';
                        $col_idx = $card_idx % 3;
                        $card_idx++;

                        $pub_ts = strtotime(!empty($item->published_at) ? $item->published_at : ($item->created_at ?: 'now'));
                        $pub_date_str = date('j', $pub_ts) . ' ' . $bulan_indo[(int)date('n', $pub_ts)] . ' ' . date('Y', $pub_ts);
                        $card_read_time = !empty($item->read_time) ? $item->read_time : max(1, ceil(str_word_count(strip_tags($item->content)) / 200));

                        $author_display_name = !empty($item->author_name) ? $item->author_name : (!empty($item->author) ? $item->author : 'Penulis Vendio');
                        $author_avatar_file = !empty($item->author_avatar) ? $item->author_avatar : '';
                        $has_author_avatar = !empty($author_avatar_file) && file_exists(FCPATH . 'uploads/user/' . $author_avatar_file);
                        $author_avatar_url = $has_author_avatar ? BASE_URL . 'uploads/user/' . $author_avatar_file : 'https://ui-avatars.com/api/?name=' . urlencode($author_display_name) . '&background=eff6ff&color=2563eb&size=64';
                    ?>
                        <article class="blog-card" style="--card-col: <?= $col_idx; ?>;">
                            <!-- 1. image di div sendiri -->
                            <div class="blog-card-img-wrap">
                                <a href="<?= site_url('blog/' . $item->slug); ?>" class="blog-card-img-link" title="<?= _ent($item->title); ?>">
                                    <?php if (!empty($image_url) && file_exists(FCPATH . 'uploads/blog/' . $first_image)): ?>
                                        <img src="<?= $image_url; ?>" alt="<?= _ent($item->title); ?>" class="blog-card-img" loading="lazy">
                                    <?php else: ?>
                                        <div class="blog-card-placeholder">
                                            <i class="fa-solid fa-newspaper"></i>
                                        </div>
                                    <?php endif; ?>
                                </a>
                            </div>

                            <!-- 2. Kategori -->
                            <div class="blog-card-category">
                                <?= !empty($item->category_name) ? _ent($item->category_name) : 'Omnichannel Marketplace'; ?>
                            </div>

                            <!-- 3. Judul artikel -->
                            <h2 class="blog-card-title">
                                <a href="<?= site_url('blog/' . $item->slug); ?>" title="<?= _ent($item->title); ?>">
                                    <?= _ent($item->title); ?>
                                </a>
                            </h2>

                            <!-- 4. waktu di buat dan estimasi baca -->
                            <div class="blog-card-meta">
                                <span><?= $pub_date_str; ?></span>
                                <span class="meta-dot">&bull;</span>
                                <span><?= $card_read_time; ?> mins read</span>
                            </div>

                            <!-- 5. author -->
                            <div class="blog-card-author">
                                <img src="<?= $author_avatar_url; ?>" alt="<?= _ent($author_display_name); ?>" class="blog-card-author-avatar" loading="lazy">
                                <span class="blog-card-author-name"><?= _ent($author_display_name); ?></span>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <?php if (!empty($pagination)): ?>
                    <div class="pagination-wrap" id="blog-pagination">
                        <?= $pagination; ?>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="empty-blog-box">
                    <div class="empty-icon"><i class="fa-regular fa-folder-open"></i></div>
                    <h3 style="font-size: 1.35rem; font-weight: 700; color: var(--text-title); margin-bottom: 8px;">Belum Ada Artikel yang Diterbitkan</h3>
                    <p style="color: var(--text-body); font-size: 0.95rem; max-width: 480px; margin: 0 auto 24px;">
                        Belum ada artikel yang cocok dengan filter atau kata kunci Anda. Anda dapat menambahkan artikel baru melalui portal administrator.
                    </p>
                    <a href="<?= site_url('administrator/blog/add'); ?>" class="btn-portal-admin">
                        <i class="fa-solid fa-pen-to-square"></i> Tulis Artikel di Portal Admin
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer (Matching Landing Page & Image 2) -->
    <footer class="footer-light">
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
        </div><!-- /#app-page-view -->
    </div><!-- /#app-page-stage -->

    <script>
        // Mobile Menu Dropdown Toggle is handled centrally by vendio-page-transition.js (initMobileMenu)
        if (typeof window.initMobileMenu === 'function') {
            window.initMobileMenu();
        }

        // Navbar Scroll Animation: Full-width background at top, Floating island when scrolled
        const navbarElement = document.getElementById('navbar');
        function handleNavbarFloatingState() {
            if (!navbarElement) return;
            if (window.scrollY > 30) {
                navbarElement.classList.add('is-scrolled');
            } else {
                navbarElement.classList.remove('is-scrolled');
            }
        }
        window.addEventListener('scroll', handleNavbarFloatingState, { passive: true });
        window.addEventListener('load', handleNavbarFloatingState);
        handleNavbarFloatingState();

        // Blog Card Scroll & Page-Change Reveal Observer
        let blogRevealObserver = null;
        function initBlogAnimations() {
            const cards = document.querySelectorAll('.blog-card');
            if (!cards.length) return;

            if (blogRevealObserver) {
                blogRevealObserver.disconnect();
                blogRevealObserver = null;
            }

            const windowHeight = window.innerHeight || document.documentElement.clientHeight;

            if ('IntersectionObserver' in window) {
                blogRevealObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const card = entry.target;
                            card.classList.add('is-revealed');
                            blogRevealObserver.unobserve(card);

                            // Clear transition-delay after reveal completes so hover is snappy
                            setTimeout(() => {
                                card.style.transitionDelay = '0s';
                            }, 650);
                        }
                    });
                }, {
                    rootMargin: '80px 0px 80px 0px',
                    threshold: 0.05
                });

                cards.forEach(card => {
                    if (!card.classList.contains('is-revealed')) {
                        const rect = card.getBoundingClientRect();
                        if (rect.top < windowHeight + 250) {
                            card.classList.add('is-revealed');
                            setTimeout(() => {
                                card.style.transitionDelay = '0s';
                            }, 650);
                        } else {
                            blogRevealObserver.observe(card);
                        }
                    }
                });
            } else {
                cards.forEach(card => card.classList.add('is-revealed'));
            }

            // Fallback safety timeout: ensure cards are visible if observer doesn't fire
            setTimeout(() => {
                cards.forEach(card => {
                    if (!card.classList.contains('is-revealed')) {
                        card.classList.add('is-revealed');
                        card.style.transitionDelay = '0s';
                    }
                });
            }, 250);
        }

        window.initBlogAnimations = initBlogAnimations;
        document.addEventListener('DOMContentLoaded', initBlogAnimations);
        window.addEventListener('load', initBlogAnimations);
        window.addEventListener('pageshow', function() {
            const currentView = document.getElementById('app-page-view');
            if (currentView) {
                currentView.classList.remove('slide-out-left', 'slide-out-right', 'slide-in-right', 'slide-in-left');
                currentView.style.opacity = '';
                currentView.style.transform = '';
                currentView.style.pointerEvents = '';
            }
            const blogGrid = document.getElementById('blog-grid');
            if (blogGrid) {
                blogGrid.classList.remove('grid-slide-out-left', 'grid-slide-out-right', 'grid-slide-in-right', 'grid-slide-in-left');
                blogGrid.style.opacity = '';
                blogGrid.style.transform = '';
                blogGrid.style.pointerEvents = '';
            }
            initBlogAnimations();
        });
        initBlogAnimations();
    </script>

    <!-- Seamless Page Transition Router -->
    <script src="<?= BASE_ASSET; ?>js/vendio-page-transition.js?v=<?= file_exists(FCPATH . 'asset/js/vendio-page-transition.js') ? filemtime(FCPATH . 'asset/js/vendio-page-transition.js') : time(); ?>"></script>
</body>
</html>