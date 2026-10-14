<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$is_logged_in = function_exists('app') && isset(app()->aauth) && app()->aauth->is_loggedin();
$user_name = $is_logged_in ? get_user_data('full_name') : '';
$admin_url = $is_logged_in ? site_url('administrator/dashboard') : site_url('administrator/login');
$admin_btn_text = $is_logged_in ? 'Buka Dashboard' : 'Masuk ke Sistem';
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vendio | Modern Omnichannel Commerce & ERP Platform</title>
    <meta name="description" content="Platform Omnichannel ERP modern untuk sinkronisasi katalog TikTok Shop, Tokopedia, Shopee, orkestrasi pesanan, multi-gudang, dan rekonsiliasi finansial.">
    <meta name="keywords" content="omnichannel ERP, tiktok shop sync, tokopedia sync, inventory management, retail ERP, marketplace reconciliation">
    <meta name="author" content="Vendio Tech">

    <!-- Google Fonts: Plus Jakarta Sans & Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Vendio Brand Fonts (Impact BC & Vladivostok) -->
    <link rel="stylesheet" href="<?= BASE_ASSET; ?>fonts/vendio-brand-fonts.css">

    <style id="vendio-home-styles">
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
           DESIGN SYSTEM (LIGHT MODE - LUXI PURPLE & VIOLET PALETTE MATCHING LANDING.JPG)
           ========================================================================== */
        :root {
            --bg-body: #ffffff;
            --bg-alt: #f7f2eb;
            --bg-cream: #f7f2eb;
            --bg-sand: #eae2d6;
            --bg-neutral: #eeeeee;
            --bg-card: #ffffff;
            
            --primary-purple: #8b9a6e;
            --primary-purple-hover: #77855b;
            --primary-gradient: linear-gradient(135deg, #8b9a6e 0%, #5d6e42 100%);
            --primary-soft-gradient: linear-gradient(135deg, rgba(139, 154, 110, 0.12) 0%, rgba(234, 226, 214, 0.35) 100%);
            
            --accent-cyan: #788b5d;
            --accent-pink: #c48a5e;
            --accent-amber: #d99b43;
            --accent-emerald: #8b9a6e;
            --accent-blue: #5d6e42;

            --text-title: #232b1e;
            --text-heading: #2d3827;
            --text-body: #55614e;
            --text-muted: #828f7c;

            --border-light: #eae2d6;
            --border-card: #e4dcce;

            --shadow-sm: 0 2px 8px rgba(139, 154, 110, 0.08);
            --shadow-md: 0 10px 30px rgba(139, 154, 110, 0.12);
            --shadow-lg: 0 20px 45px rgba(35, 43, 30, 0.12);
            --shadow-card: 0 12px 35px -5px rgba(35, 43, 30, 0.07), 0 4px 12px -2px rgba(139, 154, 110, 0.04);
            
            --radius-sm: 8px;
            --radius-md: 14px;
            --radius-lg: 20px;
            --radius-xl: 32px;
            --radius-pill: 9999px;

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
            position: relative;
        }

        a {
            color: inherit;
            text-decoration: none;
            transition: all 0.25s ease;
        }

        button {
            font-family: inherit;
            cursor: pointer;
            border: none;
            outline: none;
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

        /* Decorative Background Ornaments */
        .dot-grid {
            width: 84px;
            height: 68px;
            background-image: radial-gradient(#d5cbbf 2px, transparent 2px);
            background-size: 14px 14px;
            position: absolute;
            z-index: 1;
            pointer-events: none;
            opacity: 0.85;
        }

        .cyan-ring {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            border: 5px solid #a5f3fc;
            position: absolute;
            z-index: 1;
            pointer-events: none;
            opacity: 0.85;
        }

        .trans-triangle {
            width: 0;
            height: 0;
            border-left: 22px solid transparent;
            border-right: 22px solid transparent;
            border-bottom: 38px solid rgba(255, 255, 255, 0.22);
            position: absolute;
            pointer-events: none;
        }

        .trans-circle {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            border: 4px solid rgba(255, 255, 255, 0.22);
            position: absolute;
            pointer-events: none;
        }

        /* Typography Utilities */
        .title-indicator {
            width: 44px;
            height: 4px;
            background: var(--primary-purple);
            border-radius: var(--radius-pill);
            margin: 10px auto 0 auto;
        }

        .title-indicator.left {
            margin: 10px 0 0 0;
        }

        .section-header {
            text-align: center;
            max-width: 680px;
            margin: 0 auto 55px auto;
            position: relative;
        }

        .section-title {
            font-family: var(--font-heading);
            font-size: 2.15rem;
            font-weight: 700;
            color: var(--text-title);
            letter-spacing: -0.02em;
            line-height: 1.25;
        }

        .section-subtitle {
            font-size: 0.95rem;
            color: var(--text-body);
            margin-top: 14px;
            line-height: 1.6;
        }

        /* App Store / Google Play Badges matching Landing.jpg */
        .store-badges {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .badge-store-btn {
            background-color: #000000;
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.25s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.18);
            border: 1px solid #1e293b;
        }

        .badge-store-btn:hover {
            background-color: var(--primary-purple);
            border-color: var(--primary-purple);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(139, 154, 110, 0.3);
        }

        .badge-store-btn i {
            font-size: 1.55rem;
        }

        .badge-store-text {
            display: flex;
            flex-direction: column;
            text-align: left;
            line-height: 1.1;
        }

        .badge-store-text small {
            font-size: 0.62rem;
            letter-spacing: 0.02em;
            color: #cbd5e1;
            font-weight: 400;
        }

        .badge-store-text strong {
            font-size: 0.88rem;
            font-weight: 600;
            color: #ffffff;
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

        .brand-logo-text {
            height: 30px;
            max-height: 30px;
            width: auto;
            object-fit: contain;
            display: block;
        }

        .brand-icon-circle {
            width: 44px;
            height: 44px;
            background: var(--primary-gradient);
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(139, 154, 110, 0.35);
        }

        .brand-icon-circle span {
            font-family: var(--font-heading);
            font-weight: 800;
            font-size: 1.15rem;
            line-height: 1;
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
           2. HERO SECTION (Organic Sweeping Purple Wave + 3D Isometric Phone)
           ========================================================================== */
        .hero-section {
            padding: 135px 0 110px 0;
            position: relative;
            background: #ffffff;
            overflow: visible;
            min-height: 800px;
        }

        /* Large Sweeping Purple Wave Background matching Image 2 */
        .hero-bg-waves-wrapper {
            position: absolute;
            top: 0;
            right: 0;
            width: 58vw;
            min-width: 680px;
            height: 100%;
            min-height: 800px;
            z-index: 1;
            pointer-events: none;
            overflow: visible;
        }

        .hero-waves-svg {
            width: 100%;
            height: 100%;
            object-fit: fill;
            overflow: visible;
        }

        /* Left Edge Triangle */
        .hero-edge-triangle {
            position: absolute;
            top: 280px;
            left: -4px;
            width: 0;
            height: 0;
            border-right: 28px solid #eae2d6;
            border-top: 22px solid transparent;
            border-bottom: 22px solid transparent;
            z-index: 2;
            opacity: 0.8;
        }

        .hero-bottom-dots {
            bottom: -55px;
            left: 20px;
        }

        .hero-bottom-cyan-ring {
            bottom: 25px;
            right: 32%;
            width: 72px;
            height: 72px;
            border: 6px solid #8b9a6e; opacity: 0.6;
            border-radius: 50%;
            position: absolute;
            z-index: 2;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
            position: relative;
            z-index: 3;
        }

        .hero-content {
            text-align: left;
            position: relative;
            z-index: 4;
        }

        .hero-headline {
            font-family: var(--font-heading);
            font-size: clamp(2.4rem, 4.4vw, 3.4rem);
            font-weight: 700;
            line-height: 1.2;
            color: var(--text-title);
            letter-spacing: -0.025em;
            margin-bottom: 20px;
        }

        .hero-headline span.highlight {
            color: var(--primary-purple);
            font-weight: 800;
            display: inline-block;
        }

        .hero-description {
            font-size: 1.05rem;
            color: var(--text-body);
            line-height: 1.7;
            margin-bottom: 34px;
            max-width: 500px;
        }

        /* ==========================================================================
           VENDIO OMNICHANNEL ERP ISOMETRIC HERO ILLUSTRATION
           ========================================================================== */
        .hero-illustration-wrap {
            position: relative;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            z-index: 5;
        }

        .hero-illustration-card {
            position: relative;
            width: 100%;
            max-width: 660px;
            background: #ffffff;
            border-radius: 36px;
            overflow: hidden;
            padding: 0;
            border: none;
            box-shadow: 0 20px 50px -10px rgba(35, 43, 30, 0.16);
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease;
            cursor: pointer;
        }

        .hero-illustration-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 30px 65px -10px rgba(35, 43, 30, 0.22);
        }

        .hero-illustration-img {
            width: 100%;
            height: auto;
            display: block;
            border-radius: 36px;
            object-fit: contain;
        }

        /* ==========================================================================
           3. COUNTER / METRICS STRIP (Matching Landing.jpg +200M, +480M, +180M)
           ========================================================================== */
        .metrics-strip {
            padding: 55px 0;
            background: var(--bg-body);
            border-bottom: 1px solid var(--border-light);
            position: relative;
        }

        .metrics-grid-wrap {
            position: relative;
        }

        .metrics-dot-grid {
            top: 50%;
            left: -20px;
            transform: translateY(-50%);
        }

        .metrics-cyan-ring {
            top: 50%;
            right: -10px;
            transform: translateY(-50%);
        }

        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .metric-col {
            padding: 10px 20px;
            position: relative;
        }

        .metric-col:not(:last-child)::after {
            content: '';
            position: absolute;
            right: 0;
            top: 15%;
            height: 70%;
            width: 1px;
            background: #e8e6f5;
        }

        .metric-number {
            font-family: var(--font-heading);
            font-size: 2.6rem;
            font-weight: 800;
            color: var(--primary-purple);
            letter-spacing: -0.02em;
            line-height: 1.1;
        }

        .metric-label-group {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            margin-top: 6px;
            color: var(--text-body);
            font-size: 0.95rem;
            font-weight: 600;
        }

        .metric-label-group i {
            color: var(--primary-purple);
            font-size: 0.95rem;
        }

        /* ==========================================================================
           4. MODUL ERP OMNICHANNEL - STORYLINE TIMELINE (Original Theme Colors)
           ========================================================================== */
        .feature-section {
            padding: 95px 0 105px 0;
            background: var(--bg-body);
            position: relative;
            overflow: hidden;
        }

        .feature-section .container {
            position: relative;
            z-index: 2;
        }

        /* Organic Sage Green Background Waves matching user sketch & Hero Section */
        .feature-left-wave-wrapper {
            position: absolute;
            top: 260px;
            left: 0;
            width: 32vw;
            min-width: 280px;
            max-width: 460px;
            height: 1250px;
            z-index: 1;
            pointer-events: none;
            overflow: visible;
        }

        .feature-left-wave-svg {
            width: 100%;
            height: 100%;
            object-fit: fill;
            overflow: visible;
        }

        .feature-right-wave-wrapper {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 340px;
            height: 680px;
            z-index: 1;
            pointer-events: none;
            overflow: visible;
        }

        @media (max-width: 991px) {
            .feature-right-wave-wrapper {
                width: 260px;
                height: 520px;
            }
        }

        @media (max-width: 576px) {
            .feature-right-wave-wrapper {
                width: 180px;
                height: 360px;
                opacity: 1;
            }
        }

        .feature-right-wave-svg {
            width: 100%;
            height: 100%;
            object-fit: fill;
            overflow: visible;
        }

        .story-header-pill {
            display: inline-block;
            padding: 5px 16px;
            background: rgba(139, 154, 110, 0.14);
            color: #55643b;
            border: 1px solid rgba(139, 154, 110, 0.28);
            border-radius: 9999px;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 12px;
        }

        .story-header-title {
            font-family: var(--font-heading);
            font-size: clamp(1.8rem, 3.2vw, 2.5rem);
            font-weight: 800;
            color: #232b1e;
            line-height: 1.25;
            margin-bottom: 14px;
        }

        .story-header-indicator {
            height: 3px;
            width: 60px;
            background: #8b9a6e;
            margin: 0 auto 16px auto;
            border-radius: 2px;
        }

        .story-header-subtitle {
            font-size: 1.05rem;
            color: #55614e;
            line-height: 1.6;
            max-width: 720px;
            margin: 0 auto;
        }

        /* Timeline Container & Central Spine */
        .storyline-container {
            position: relative;
            max-width: 1120px;
            margin: 60px auto 0 auto;
            padding: 20px 0;
        }

        .storyline-spine {
            position: absolute;
            top: 40px;
            bottom: 40px;
            left: 50%;
            width: 3px;
            background: #8b9a6e;
            transform: translateX(-50%);
            box-shadow: 0 0 10px rgba(139, 154, 110, 0.25);
            z-index: 1;
        }

        .storyline-row {
            position: relative;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 75px;
            align-items: center;
            margin-bottom: 90px;
        }

        .storyline-row:last-child {
            margin-bottom: 0;
        }

        .storyline-node {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 16px;
            height: 16px;
            background: #8b9a6e;
            border: 4px solid var(--bg-body, #ffffff);
            border-radius: 50%;
            box-shadow: 0 0 0 2px #8b9a6e, 0 3px 8px rgba(139, 154, 110, 0.4);
            z-index: 5;
        }

        /* Paper Scrapbook Text Card */
        .story-paper-wrap {
            position: relative;
            z-index: 3;
        }

        /* Text Content Card with Clean White Background */
        .story-paper-card {
            position: relative;
            background: #ffffff;
            border-radius: 24px;
            padding: 26px 28px;
            box-shadow: 0 10px 30px rgba(35, 43, 30, 0.07), 0 2px 8px rgba(35, 43, 30, 0.04);
            border: 1px solid rgba(234, 226, 214, 0.85);
            transition: all 0.3s ease;
        }

        .story-paper-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 36px rgba(35, 43, 30, 0.1);
        }


        /* Card Content Styling */
        .story-category {
            font-family: var(--font-heading);
            font-style: italic;
            font-weight: 700;
            color: #708152;
            font-size: 1.12rem;
            line-height: 1.3;
            margin-bottom: 4px;
        }

        .story-main-title {
            font-family: var(--font-heading);
            font-size: 1.5rem;
            font-weight: 800;
            color: #232b1e;
            line-height: 1.25;
            margin: 0;
            letter-spacing: -0.015em;
        }

        .story-divider {
            height: 1px;
            background: rgba(139, 154, 110, 0.2);
            margin: 14px 0 16px 0;
            width: 100%;
        }

        .story-desc {
            font-size: 0.94rem;
            color: #55614e;
            line-height: 1.65;
            margin-bottom: 18px;
        }

        /* Highlight Subcard inside Text Content */
        .story-subcard {
            background: #faf8f5;
            border: 1px solid rgba(139, 154, 110, 0.22);
            border-left: 3px solid #8b9a6e;
            border-radius: 12px;
            padding: 12px 16px;
            text-align: left;
        }

        .story-subcard-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 4px;
            font-size: 0.82rem;
            font-weight: 700;
            color: #232b1e;
        }

        .story-subcard-badge {
            font-size: 0.68rem;
            padding: 2px 8px;
            border-radius: 10px;
            background: rgba(16, 185, 129, 0.12);
            color: #059669;
            font-weight: 700;
        }

        .story-subcard-desc {
            font-size: 0.8rem;
            color: #55614e;
            line-height: 1.5;
            margin: 0;
        }

        /* Visual Container Card on Opposite Side */
        .story-visual-wrap {
            position: relative;
            display: flex;
            align-items: center;
            z-index: 3;
            width: 100%;
        }

        /* Saat visual di kolom kiri (Step 2 & 4): merapat ke garis timeline (kanan) sejajar dengan teks */
        .storyline-row > .story-visual-wrap:nth-child(2) {
            justify-content: flex-end;
        }

        /* Saat visual di kolom kanan (Step 1 & 3): merapat ke garis timeline (kiri) sejajar dengan teks */
        .storyline-row > .story-visual-wrap:nth-child(3) {
            justify-content: flex-start;
        }

        .story-visual-card {
            position: relative;
            background: transparent;
            border-radius: 32px;
            display: flex;
            align-items: center;
            width: 100%;
            max-width: 295px;
            transition: transform 0.3s ease;
        }

        .storyline-row > .story-visual-wrap:nth-child(2) .story-visual-card {
            margin-left: auto;
            margin-right: 0;
            justify-content: flex-end;
        }

        .storyline-row > .story-visual-wrap:nth-child(3) .story-visual-card {
            margin-left: 0;
            margin-right: auto;
            justify-content: flex-start;
        }

        .story-visual-card:hover {
            transform: translateY(-4px);
        }

        /* Mockup phone cards inside */
        .feature-phone-card {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 295px;
            background: #ffffff;
            border-radius: 32px;
            border: 6px solid #ffffff;
            padding: 16px;
            box-shadow: 0 16px 36px rgba(35, 43, 30, 0.09), 0 2px 8px rgba(35, 43, 30, 0.04);
            outline: 1px solid #f0f3eb;
            transition: all 0.35s ease;
        }

        .donut-chart-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 12px 0 8px 0;
            overflow: visible;
        }
        .donut-chart-wrap svg {
            overflow: visible;
            display: block;
        }

        /* ==========================================================================
           5. WATCH VIDEO / DEMO BANNER (Wave Background matching Landing.jpg)
           ========================================================================== */
        .demo-banner-section {
            padding: 70px 0 0 0;
            position: relative;
            background: #ffffff;
            text-align: center;
        }

        .wave-purple-bg {
            background: var(--primary-gradient);
            padding: 90px 0 110px 0;
            margin-top: 40px;
            position: relative;
            clip-path: ellipse(115% 85% at 50% 85%);
            overflow: hidden;
        }

        .wave-triangle-left {
            top: 25%;
            left: 10%;
        }

        .wave-circle-right {
            top: 20%;
            right: 12%;
        }

        .video-card-container {
            max-width: 620px;
            margin: 0 auto;
            position: relative;
            z-index: 5;
        }

        .video-floating-card {
            background: #ffffff;
            border-radius: var(--radius-lg);
            padding: 32px;
            box-shadow: 0 25px 60px rgba(15, 23, 42, 0.25);
            text-align: center;
        }

        .video-card-title {
            font-family: var(--font-heading);
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-title);
            margin-bottom: 22px;
        }

        .play-button-circle {
            width: 66px;
            height: 66px;
            background: var(--primary-gradient);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.35rem;
            box-shadow: 0 8px 25px rgba(139, 154, 110, 0.45);
            transition: all 0.3s;
            margin-bottom: 22px;
            cursor: pointer;
        }

        .play-button-circle:hover {
            transform: scale(1.1);
            box-shadow: 0 12px 32px rgba(139, 154, 110, 0.6);
        }

        .video-preview-mock {
            background: #0f172a;
            border-radius: var(--radius-md);
            padding: 16px;
            color: #ffffff;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* ==========================================================================
           6. SHOWCASE / MODULES CAROUSEL STRIP (5 Mockup Screens matching Landing.jpg)
           ========================================================================== */
        .showcase-section {
            padding: 90px 0 70px 0;
            background: var(--bg-alt);
            border-radius: 48px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .showcase-slider-wrap {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin: 45px 0 25px 0;
            width: 100%;
            padding: 10px 0;
        }

        .showcase-phone-card {
            background: #ffffff;
            border-radius: 28px;
            border: 5px solid #ffffff;
            box-shadow: 0 8px 22px rgba(0, 0, 0, 0.06);
            outline: 1px solid #f1f0f7;
            padding: 22px 20px;
            text-align: left;
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .showcase-phone-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 36px rgba(139, 154, 110, 0.18);
            outline-color: var(--primary-purple);
        }

        .phone-speaker-pill {
            width: 44px;
            height: 4px;
            background: #e2e8f0;
            border-radius: 4px;
            margin: 0 auto 12px auto;
        }

        .slider-dots {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 15px;
        }

        .slider-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #cbd5e1;
            transition: all 0.2s;
        }

        .slider-dot.active {
            width: 22px;
            border-radius: 10px;
            background: var(--primary-purple);
        }

        .slider-dot.dot-cyan {
            background: var(--accent-cyan);
        }

        /* ==========================================================================
           7. TESTIMONIALS SECTION (Quote + 7 Circular Avatars matching Landing.jpg)
           ========================================================================== */
        .testimonials-section {
            padding: 95px 0;
            background: #ffffff;
            text-align: center;
        }

        .testimonial-quote-box {
            max-width: 700px;
            margin: 0 auto 35px auto;
        }

        .testimonial-quote-text {
            font-size: 1.15rem;
            font-style: italic;
            color: #475569;
            line-height: 1.75;
            margin-bottom: 22px;
        }

        .testimonial-author {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--primary-purple);
        }

        .testimonial-author span {
            font-weight: 400;
            color: var(--text-muted);
        }

        .testimonial-avatars-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-top: 25px;
            flex-wrap: wrap;
        }

        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            object-fit: cover;
            transition: all 0.25s;
            cursor: pointer;
            filter: grayscale(40%);
        }

        .author-avatar.active, .author-avatar:hover {
            filter: grayscale(0%);
            border-color: var(--primary-purple);
            transform: scale(1.2);
            box-shadow: 0 8px 20px rgba(139, 154, 110, 0.35);
        }

        /* ==========================================================================
           8. FAQ SECTION (Megaphone Illustration + Accordion matching Landing.jpg)
           ========================================================================== */
        .faq-section {
            padding: 95px 0;
            background: var(--bg-alt);
            border-radius: 48px;
            position: relative;
            overflow: hidden;
        }

        .faq-grid {
            display: grid;
            grid-template-columns: 0.9fr 1.1fr;
            gap: 60px;
            align-items: flex-start;
        }

        .faq-left-info {
            text-align: left;
        }

        .faq-left-title {
            font-family: var(--font-heading);
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--text-title);
            margin-bottom: 6px;
        }

        .faq-left-desc {
            font-size: 0.98rem;
            color: var(--text-body);
            margin: 18px 0 35px 0;
            line-height: 1.6;
            max-width: 420px;
        }

        .faq-mega-wrap {
            position: relative;
            width: 320px;
            max-width: 100%;
            height: 265px;
            margin-top: 20px;
        }

        .accordion-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .accordion-item {
            border-radius: var(--radius-sm);
            overflow: hidden;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            transition: border-color 0.3s cubic-bezier(0.16, 1, 0.3, 1),
                        box-shadow 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .accordion-item.active {
            border-color: rgba(139, 154, 110, 0.45);
            box-shadow: 0 8px 24px -4px rgba(139, 154, 110, 0.16);
        }

        .accordion-header {
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-heading);
            background: #ffffff;
            transition: background 0.35s cubic-bezier(0.16, 1, 0.3, 1),
                        color 0.3s ease;
            user-select: none;
        }

        .accordion-header i {
            font-size: 0.85rem;
            color: #94a3b8;
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1),
                        color 0.3s ease;
        }

        .accordion-item.active .accordion-header {
            background: var(--primary-purple);
            color: #ffffff;
        }

        .accordion-item.active .accordion-header i {
            color: #ffffff;
            transform: rotate(180deg);
        }

        .accordion-body {
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            padding: 0 20px;
            font-size: 0.92rem;
            color: #475569;
            line-height: 1.6;
            background: #ffffff;
            border-top: 1px solid transparent;
            transition: max-height 0.42s cubic-bezier(0.16, 1, 0.3, 1),
                        opacity 0.35s ease,
                        padding 0.35s cubic-bezier(0.16, 1, 0.3, 1),
                        border-color 0.3s ease;
        }

        .accordion-item.active .accordion-body {
            opacity: 1;
            padding: 18px 20px;
            border-top: 1px solid #f1f5f9;
        }

        /* ==========================================================================
           9. CLIENT / MARKETPLACE LOGOS STRIP (Matching Landing.jpg)
           ========================================================================== */
        .partners-section {
            padding: 55px 0;
            background: #ffffff;
            text-align: center;
            border-top: 1px solid var(--border-light);
            border-bottom: 1px solid var(--border-light);
        }

        .partners-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-title);
            margin-bottom: 28px;
        }

        .partners-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 36px;
            flex-wrap: wrap;
        }

        .partner-item {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 0.95rem;
            font-weight: 700;
            color: #64748b;
            padding: 8px 18px;
            border-radius: var(--radius-pill);
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            transition: all 0.2s;
        }

        .partner-item:hover {
            color: var(--primary-purple);
            border-color: var(--primary-purple);
            background: #ffffff;
            box-shadow: var(--shadow-sm);
        }

        /* ==========================================================================
           10. LATEST NEWS / BLOG SECTION (Matching Landing.jpg)
           ========================================================================== */
        .news-section {
            padding: 95px 0;
            background: #ffffff;
            position: relative;
        }

        .news-cyan-ring {
            top: 60px;
            right: 80px;
        }

        .news-triangle {
            top: 80px;
            left: 70px;
            border-bottom-color: rgba(139, 154, 110, 0.15);
        }

        .news-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            position: relative;
            z-index: 2;
        }

        .news-big-card {
            background: #ffffff;
            border: 1px solid rgba(234, 226, 214, 0.9);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: 0 10px 28px -4px rgba(35, 43, 30, 0.08), 0 4px 12px -2px rgba(35, 43, 30, 0.04);
            display: flex;
            flex-direction: column;
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1),
                        box-shadow 0.3s cubic-bezier(0.16, 1, 0.3, 1),
                        border-color 0.3s ease;
        }

        .news-big-card:hover {
            border-color: rgba(139, 154, 110, 0.5);
            transform: translateY(-5px);
            box-shadow: 0 20px 40px -6px rgba(35, 43, 30, 0.12), 0 8px 18px -4px rgba(139, 154, 110, 0.08);
        }

        .news-big-img {
            height: 220px;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #60a5fa;
            font-size: 3rem;
            position: relative;
        }

        .news-card-inner {
            padding: 24px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .news-badge {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--primary-purple);
            letter-spacing: 0.05em;
            margin-bottom: 8px;
        }

        .news-card-title {
            font-family: var(--font-heading);
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-title);
            line-height: 1.4;
            margin-bottom: 12px;
        }

        .news-card-desc {
            font-size: 0.88rem;
            color: var(--text-body);
            line-height: 1.58;
            margin-bottom: 16px;
            flex-grow: 1;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .news-read-more {
            font-size: 0.86rem;
            font-weight: 600;
            color: var(--primary-purple);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .news-stacked-col {
            display: flex;
            flex-direction: column;
            gap: 16px;
            justify-content: space-between;
        }

        .news-small-card {
            background: #ffffff;
            border: 1px solid rgba(234, 226, 214, 0.9);
            border-radius: var(--radius-lg);
            padding: 16px 20px;
            display: flex;
            gap: 16px;
            align-items: center;
            box-shadow: 0 10px 28px -4px rgba(35, 43, 30, 0.08), 0 4px 12px -2px rgba(35, 43, 30, 0.04);
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1),
                        box-shadow 0.3s cubic-bezier(0.16, 1, 0.3, 1),
                        border-color 0.3s ease;
        }

        .news-small-card:hover {
            border-color: rgba(139, 154, 110, 0.5);
            transform: translateY(-4px);
            box-shadow: 0 18px 38px -6px rgba(35, 43, 30, 0.12), 0 6px 16px -4px rgba(139, 154, 110, 0.08);
        }

        .news-small-thumb {
            width: 96px;
            height: 80px;
            flex-shrink: 0;
            border-radius: 12px;
            background: linear-gradient(135deg, #8b9a6e 0%, #5d6e42 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.6rem;
            overflow: hidden;
        }

        .news-small-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: inherit;
            display: block;
        }

        .news-small-thumb.thumb-cyan {
            background: linear-gradient(135deg, #718356 0%, #526338 100%);
        }

        .news-small-content {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            min-width: 0;
        }

        .news-small-title {
            font-family: var(--font-heading);
            font-size: 0.92rem;
            font-weight: 700;
            color: var(--text-title);
            line-height: 1.35;
            margin: 3px 0 6px 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .news-meta-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 6px;
            flex-wrap: wrap;
        }

        .news-meta-row .news-badge {
            margin-bottom: 0;
        }

        .news-date {
            font-size: 0.76rem;
            color: #94a3b8;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .news-card-title a,
        .news-small-title a {
            color: inherit;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .news-big-card:hover .news-card-title a,
        .news-small-card:hover .news-small-title a {
            color: var(--primary-purple);
        }

        .news-footer-action {
            margin-top: 45px;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .btn-view-all-blog {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 13px 32px;
            border-radius: 9999px;
            background: #ffffff;
            border: 1.5px solid var(--primary-purple);
            color: var(--primary-purple);
            font-family: var(--font-heading);
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.25s ease;
            box-shadow: 0 4px 14px rgba(139, 154, 110, 0.12);
        }

        .btn-view-all-blog:hover {
            background: var(--primary-purple);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(139, 154, 110, 0.25);
        }

        .btn-view-all-blog i {
            transition: transform 0.2s ease;
        }

        .btn-view-all-blog:hover i {
            transform: translateX(4px);
        }

        /* ==========================================================================
           11. BOTTOM CTA BANNER (Curved Purple Wave matching Landing.jpg)
           ========================================================================== */
        .bottom-cta-wave {
            background: var(--primary-gradient);
            padding: 95px 0 115px 0;
            text-align: center;
            color: #ffffff;
            clip-path: ellipse(115% 90% at 50% 90%);
        }

        .bottom-cta-title {
            font-family: var(--font-heading);
            font-size: clamp(1.8rem, 3.5vw, 2.5rem);
            font-weight: 800;
            margin-bottom: 28px;
            letter-spacing: -0.02em;
        }

        /* ==========================================================================
           12. FOOTER (Matching Image 2)
           ========================================================================== */
        .footer-light {
            background: #ffffff;
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

        .footer-status-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            color: #10b981;
            font-weight: 600;
            font-family: monospace, var(--font-main);
            letter-spacing: -0.01em;
        }

        .footer-nav-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .footer-nav-list a {
            color: #55614e;
            transition: color 0.2s ease, transform 0.2s ease;
            display: inline-block;
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

        .footer-bottom-note {
            font-size: 0.82rem;
            color: #828f7c;
            font-family: monospace, var(--font-main);
        }

        /* Responsive */
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
            .hero-section { padding-top: 105px; }
            .hero-bg-waves-wrapper { width: 100vw; opacity: 1; }
            .feature-left-wave-wrapper { width: 50vw; opacity: 1; }
            .feature-right-wave-wrapper { width: 45vw; opacity: 1; }
            .hero-grid { grid-template-columns: 1fr; gap: 40px; }
            .hero-content { text-align: center; }
            .hero-description { margin-left: auto; margin-right: auto; }
            .store-badges { justify-content: center; }
            .hero-illustration-wrap { margin-top: 25px; justify-content: center; }
            .storyline-spine { left: 24px; }
            .storyline-node { left: 24px; }
            .storyline-row { grid-template-columns: 1fr; gap: 40px; padding-left: 55px; margin-bottom: 70px; }
            .story-visual-wrap { justify-content: flex-start !important; }
            .story-visual-card { max-width: 295px; margin: 0 !important; }
            .feature-zigzag-row { grid-template-columns: 1fr; gap: 40px; text-align: center; }
            .feature-text-content { text-align: center; }
            .feature-title-wrap { justify-content: center; }
            .faq-grid { grid-template-columns: 1fr; gap: 40px; }
            .faq-mega-wrap { width: 260px; height: 215px; margin: 15px auto 0 auto; }
            .news-grid { grid-template-columns: 1fr; }
            .showcase-slider-wrap { grid-template-columns: repeat(2, 1fr); gap: 20px; }
            .showcase-section,
            .faq-section { border-radius: 36px; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 768px) {
            .brand-logo-img,
            .brand-logo-icon { height: 28px; }
            .brand-name-title { font-size: 1.2rem; letter-spacing: 0.14em; }
            .brand-name-sub { font-size: 0.44rem; letter-spacing: 0.24em; }
            .nav-links { display: none !important; }
            .mobile-toggle { display: inline-flex; margin-left: auto; }
            .metrics-grid { grid-template-columns: 1fr; gap: 30px; }
            .metric-col::after { display: none; }
            /* Standarisasi Gap Antar-Section Seragam Khusus Mode HP (Mobile: 90px total gap) */
            .hero-section {
                padding-top: 95px;
                padding-bottom: 45px;
                min-height: auto;
            }
            .hero-bg-waves-wrapper {
                min-height: auto;
            }

            .feature-section,
            .showcase-section,
            .news-section,
            .faq-section {
                padding: 45px 0;
            }

            .footer-light {
                padding-top: 45px;
                padding-bottom: 30px;
            }

            .storyline-container {
                margin-top: 30px;
                margin-bottom: 0;
                padding-bottom: 0;
            }

            /* Section Alur (Timeline): Visual/Gambar selalu di atas teks khusus mode HP */
            .storyline-row .story-visual-wrap {
                order: 1;
            }

            .storyline-row .story-paper-wrap {
                order: 2;
            }

            .showcase-slider-wrap {
                grid-template-columns: 1fr;
                gap: 16px;
                margin-top: 25px;
                margin-bottom: 0;
            }
            .showcase-section,
            .faq-section { border-radius: 24px; }
            .footer-grid { grid-template-columns: 1fr; }
            .feature-left-wave-wrapper { display: none !important; }

            /* Hero Text on Mobile: Warna cream palet (#f7f2eb) untuk headline & deskripsi */
            .hero-headline {
                color: var(--bg-cream, #f7f2eb);
            }

            .hero-headline span.highlight {
                color: #ffffff;
                background: none;
                -webkit-background-clip: initial;
                -webkit-text-fill-color: #ffffff;
                -webkit-text-stroke: none;
                text-stroke: none;
                font-weight: 700;
            }

            .hero-grid {
                gap: 20px;
            }

            .hero-description {
                color: var(--bg-cream, #f7f2eb);
                font-weight: 500;
                margin-bottom: 0;
            }

            .hero-illustration-wrap {
                margin-top: 0;
            }

            /* Mobile Dropdown Card matching Image 2 */
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
                letter-spacing: -0.01em;
            }

            .mobile-dropdown-item:hover,
            .mobile-dropdown-item:active,
            .mobile-dropdown-item.active {
                background: #f1f5f9;
            }

            .mobile-dropdown-item:hover .item-label,
            .mobile-dropdown-item:active .item-label,
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
           SCROLL-TRIGGERED REVEAL & DISAPPEAR ANIMATIONS ("Muncul & Hilang saat Scroll")
           ========================================================================== */
        .reveal-init {
            opacity: 0;
            transform: translateY(35px);
            transition: opacity 0.75s cubic-bezier(0.16, 1, 0.3, 1),
                        transform 0.75s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }

        .reveal-init.is-revealed {
            opacity: 1;
            transform: translateY(0);
        }

        .reveal-left {
            opacity: 0;
            transform: translateX(-40px);
            transition: opacity 0.75s cubic-bezier(0.16, 1, 0.3, 1),
                        transform 0.75s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }

        .reveal-left.is-revealed {
            opacity: 1;
            transform: translateX(0);
        }

        .reveal-right {
            opacity: 0;
            transform: translateX(40px);
            transition: opacity 0.75s cubic-bezier(0.16, 1, 0.3, 1),
                        transform 0.75s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }

        .reveal-right.is-revealed {
            opacity: 1;
            transform: translateX(0);
        }

        .reveal-scale {
            opacity: 0;
            transform: scale(0.92) translateY(20px);
            transition: opacity 0.75s cubic-bezier(0.16, 1, 0.3, 1),
                        transform 0.75s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }

        .reveal-scale.is-revealed {
            opacity: 1;
            transform: scale(1) translateY(0);
        }

        /* Timeline Node pop animation */
        .storyline-row.reveal-init .storyline-node {
            transform: translateX(-50%) scale(0.25);
            opacity: 0;
            transition: transform 0.55s cubic-bezier(0.16, 1, 0.3, 1) 0.15s,
                        opacity 0.55s ease 0.15s;
        }

        .storyline-row.reveal-init.is-revealed .storyline-node {
            transform: translateX(-50%) scale(1);
            opacity: 1;
        }

        /* Card Hovers preserved when revealed */
        .showcase-phone-card.reveal-init {
            box-shadow: 0 8px 22px rgba(0, 0, 0, 0.06);
            transition: opacity 0.75s cubic-bezier(0.16, 1, 0.3, 1),
                        transform 0.75s cubic-bezier(0.16, 1, 0.3, 1),
                        box-shadow 0.3s ease,
                        border-color 0.3s ease;
        }

        .showcase-phone-card.reveal-init.is-revealed:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.1);
        }

        .hero-illustration-card.reveal-scale.is-revealed:hover {
            transform: scale(1) translateY(-8px);
            box-shadow: 0 30px 65px -10px rgba(35, 43, 30, 0.22);
        }

        .news-big-card.reveal-left.is-revealed:hover {
            transform: translateY(-5px);
            border-color: rgba(139, 154, 110, 0.5);
            box-shadow: 0 20px 40px -6px rgba(35, 43, 30, 0.12), 0 8px 18px -4px rgba(139, 154, 110, 0.08);
        }

        /* Stagger Cascade Delays (active when entering view) */
        .reveal-delay-1.is-revealed { transition-delay: 0.08s; }
        .reveal-delay-2.is-revealed { transition-delay: 0.16s; }
        .reveal-delay-3.is-revealed { transition-delay: 0.24s; }
        .reveal-delay-4.is-revealed { transition-delay: 0.32s; }
        .reveal-delay-5.is-revealed { transition-delay: 0.40s; }

        @media (max-width: 768px) {
            .reveal-left, .reveal-right {
                transform: translateY(30px);
            }
            .reveal-left.is-revealed, .reveal-right.is-revealed {
                transform: translateY(0);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .reveal-init, .reveal-left, .reveal-right, .reveal-scale {
                opacity: 1 !important;
                transform: none !important;
                transition: none !important;
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
    </style>
</head>

<body>

    <!-- Top Loading Progress Bar -->
    <div id="page-progress-bar" class="page-progress-bar"></div>

    <!-- ==========================================================================
       1. NAVIGATION BAR (Seamless Transparent floating over Purple Wave)
       ========================================================================== -->
    <nav class="navbar-main" id="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <a href="#" class="brand-logo" title="Kembali ke atas">
                    <img src="<?= BASE_ASSET; ?>img/vendio-logo.png" alt="Vendio Logo" class="brand-logo-icon">
                    <div class="brand-name">
                        <span class="brand-name-title">VENDIO</span>
                        <span class="brand-name-sub">OMNICHANNEL ERP</span>
                    </div>
                </a>

                <ul class="nav-links">
                    <li><a href="#feature" class="nav-link">Fitur</a></li>
                    <li><a href="#showcase" class="nav-link">Cara Kerja</a></li>
                    <li><a href="<?= site_url('blog'); ?>" class="nav-link">Blog</a></li>
                    <li><a href="#faq" class="nav-link">FAQ</a></li>
                </ul>

                <button type="button" class="mobile-toggle" id="mobileMenuBtn" aria-label="Toggle Menu" aria-expanded="false">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Dropdown Card (matching Image 2) -->
        <div class="mobile-dropdown-card" id="mobileDropdownCard">
            <div class="mobile-dropdown-list">
                <a href="#feature" class="mobile-dropdown-item">
                    <span class="item-label">Fitur</span>
                </a>
                <a href="#showcase" class="mobile-dropdown-item">
                    <span class="item-label">Cara Kerja</span>
                </a>
                <a href="<?= site_url('blog'); ?>" class="mobile-dropdown-item">
                    <span class="item-label">Blog</span>
                </a>
                <a href="#faq" class="mobile-dropdown-item">
                    <span class="item-label">FAQ</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu Backdrop Overlay -->
    <div class="mobile-menu-backdrop" id="mobileMenuBackdrop"></div>

    <!-- Main Page Stage for Seamless Slide Transitions -->
    <div id="app-page-stage" class="app-page-stage">
        <div id="app-page-view" class="app-page-view" data-page="home">

    <!-- ==========================================================================
       2. HERO SECTION
       ========================================================================== -->
    <section class="hero-section">
        <!-- Organic Sweeping S-Curve Purple Wave Background matching Image 2 -->
        <div class="hero-bg-waves-wrapper">
            <svg class="hero-waves-svg" viewBox="0 0 900 850" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <!-- Main Vibrant Sage Olive Gradient matching Palette #8B9A6E -->
                    <linearGradient id="heroWaveGrad" x1="15%" y1="0%" x2="95%" y2="100%">
                        <stop offset="0%" stop-color="#8b9a6e" />
                        <stop offset="50%" stop-color="#708152" />
                        <stop offset="100%" stop-color="#55643b" />
                    </linearGradient>

                    <!-- Sand & Linen Secondary Layer matching Palette #EAE2D6 and #F7F2EB -->
                    <linearGradient id="lilacWaveGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#f7f2eb" />
                        <stop offset="100%" stop-color="#eae2d6" />
                    </linearGradient>

                    <!-- Realistic Elevation Shadow for Layered Depth -->
                    <filter id="waveElevation" x="-30%" y="-30%" width="160%" height="160%">
                        <feDropShadow dx="-14" dy="18" stdDeviation="20" flood-color="#3a4626" flood-opacity="0.25" />
                    </filter>
                </defs>

                <!-- 1. Underneath Lilac Accent Layer (Clean Parallel Offset Contour) -->
                <path d="M 320 0 
                         C 285 200, 175 360, 135 500 
                         C 100 625, 145 735, 275 765 
                         C 415 795, 595 735, 770 665 
                         L 900 625 L 900 0 Z" 
                      fill="url(#lilacWaveGrad)" />

                <!-- 2. Main Elevated Purple Wave with Drop Shadow onto Lilac & Page -->
                <path d="M 380 0 
                         C 345 190, 235 345, 195 485 
                         C 160 605, 205 705, 325 725 
                         C 455 745, 630 680, 810 615 
                         L 900 580 L 900 0 Z" 
                      fill="url(#heroWaveGrad)" 
                      filter="url(#waveElevation)" />

            </svg>
        </div>

        <div class="container">
            <!-- Decorative cyan ring on left -->
            <div class="cyan-ring hero-bottom-cyan-ring"></div>

            <div class="hero-grid">
                <!-- Left Content -->
                <div class="hero-content reveal-left">
                    <h1 class="hero-headline">
                        Satu Sistem ERP Terpusat untuk <span class="highlight">Seluruh Kanal Penjualan.</span>
                    </h1>
                    <p class="hero-description">
                        Sinkronisasi katalog produk, orkestrasi ribuan pesanan per menit, kontrol multi-gudang, dan rekonsiliasi finansial TikTok Shop, Tokopedia, serta Shopee dalam satu dashboard terintegrasi.
                    </p>

                </div>

                <!-- Right Hero ERP Isometric Illustration matching Image 2 & 3 -->
                <div class="hero-illustration-wrap">
                    <div class="hero-illustration-card reveal-scale">
                        <img src="<?= BASE_ASSET; ?>img/vendio-erp-isometric-hero.jpg?v=<?= time(); ?>" 
                             alt="Vendio Omnichannel ERP Illustration" 
                             class="hero-illustration-img">
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- ==========================================================================
       4. FEATURE SECTION - STORYLINE TIMELINE (Matching Image 2 Design + Image 1 Content)
       ========================================================================== -->
    <section class="feature-section" id="feature">
        <!-- 1. Left Organic Wave matching user sketch (Steps 1 - 3) -->
        <div class="feature-left-wave-wrapper" aria-hidden="true">
            <svg class="feature-left-wave-svg" viewBox="0 0 500 1200" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="featureLeftWaveGrad" x1="0%" y1="15%" x2="100%" y2="85%">
                        <stop offset="0%" stop-color="#8b9a6e" />
                        <stop offset="50%" stop-color="#708152" />
                        <stop offset="100%" stop-color="#55643b" />
                    </linearGradient>

                    <linearGradient id="featureLeftSandGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#f7f2eb" />
                        <stop offset="100%" stop-color="#eae2d6" />
                    </linearGradient>

                    <filter id="featureLeftElevation" x="-20%" y="-20%" width="150%" height="150%">
                        <feDropShadow dx="12" dy="16" stdDeviation="18" flood-color="#3a4626" flood-opacity="0.22" />
                    </filter>
                </defs>

                <!-- Underneath Sand Accent Layer (Parallel Contour matching Hero section thickness) -->
                <path d="M 0 10 
                         C 155 100, 240 220, 285 365 
                         C 335 500, 320 640, 270 765 
                         C 225 865, 245 965, 210 1045 
                         C 160 1115, 85 1160, 0 1170 Z" 
                      fill="url(#featureLeftSandGrad)" />

                <!-- Main Sage Green Elevated Wave -->
                <path d="M 0 40 
                         C 115 120, 185 240, 230 380 
                         C 275 515, 260 655, 215 780 
                         C 170 880, 190 980, 155 1060 
                         C 110 1130, 50 1170, 0 1180 Z" 
                      fill="url(#featureLeftWaveGrad)" 
                      filter="url(#featureLeftElevation)" />

            </svg>
        </div>

        <!-- 2. Bottom Right Wave matching user red line curve -->
        <div class="feature-right-wave-wrapper" aria-hidden="true">
            <svg class="feature-right-wave-svg" viewBox="0 0 340 680" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="featureRightWaveGrad" x1="20%" y1="0%" x2="90%" y2="100%">
                        <stop offset="0%" stop-color="#8b9a6e" />
                        <stop offset="50%" stop-color="#708152" />
                        <stop offset="100%" stop-color="#55643b" />
                    </linearGradient>

                    <linearGradient id="featureRightSandGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#f7f2eb" />
                        <stop offset="100%" stop-color="#eae2d6" />
                    </linearGradient>

                    <filter id="featureRightElevation" x="-25%" y="-25%" width="150%" height="150%">
                        <feDropShadow dx="-10" dy="-12" stdDeviation="16" flood-color="#3a4626" flood-opacity="0.22" />
                    </filter>
                </defs>

                <!-- Underneath Sand Accent Layer (Parallel Offset Contour matching Hero section thickness) -->
                <path d="M 340 0 
                         C 208 117, 98 204, 98 296 
                         C 98 398, 110 466, 142 515 
                         C 175 572, 227 662, 340 666 
                         L 340 0 Z" 
                      fill="url(#featureRightSandGrad)" />

                <!-- Main Sage Green Elevated Wave (Blunt Tumpul Bottom Scoop matching red stroke) -->
                <path d="M 340 0 
                         C 253 117, 143 204, 143 296 
                         C 143 398, 155 466, 187 515 
                         C 220 563, 267 631, 340 633 
                         L 340 0 Z" 
                      fill="url(#featureRightWaveGrad)" 
                      filter="url(#featureRightElevation)" />

            </svg>
        </div>

        <div class="container">
            <div class="section-header reveal-init" style="text-align: center; max-width: 820px; margin: 0 auto;">
                <h2 class="story-header-title">
                    Semua Kebutuhan Bisnis Ritel Modern dalam Satu Ekosistem.
                </h2>
                <div class="story-header-indicator"></div>
                <p class="story-header-subtitle">
                    Kombinasi kecepatan sinkronisasi e-commerce dengan ketahanan sistem ERP korporat untuk meminimalisasi kesalahan manusia dan efisiensi operasional skala besar.
                </p>
            </div>

            <!-- Storyline Timeline Wrapper -->
            <div class="storyline-container">
                <!-- Red Center Vertical Spine -->
                <div class="storyline-spine"></div>

                <!-- STEP 1: Text on Left, Visual on Right -->
                <div class="storyline-row reveal-init">
                    <div class="storyline-node"></div>

                    <!-- Left: Paper Text Card -->
                    <div class="story-paper-wrap">
                        <div class="story-paper-card">
                            <div class="story-category">Sync &amp; Master Data</div>
                            <h3 class="story-main-title">Unified Master Catalog &amp; Real-Time Stock Engine</h3>
                            <div class="story-divider"></div>
                            <p class="story-desc">
                                Cukup kelola satu master SKU produk di Vendio. Sistem secara otomatis memetakan judul, varian warna/ukuran, harga promosi, dan kuota stok ke seluruh toko TikTok Shop dan Tokopedia Anda dalam hitungan detik.
                            </p>
                            <div class="story-subcard">
                                <div class="story-subcard-header">
                                    <span><i class="fa-solid fa-lock" style="color: #8b9a6e; margin-right: 6px;"></i> Auto-Stock Locking Mechanism</span>
                                </div>
                                <p class="story-subcard-desc">
                                    Saat 1 unit terjual di sesi Live TikTok, kuota stok di Tokopedia langsung dikurangi seketika untuk mencegah pesanan ganda saat kuota habis.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Visual Container Card -->
                    <div class="story-visual-wrap">
                        <div class="story-visual-card">
                            <div class="feature-phone-card">
                                <div class="phone-speaker-pill" style="margin-bottom: 10px;"></div>
                                <div style="font-size: 0.72rem; font-weight: 700; color: #8b9a6e; text-transform: uppercase; margin-bottom: 6px;">Product Sales Stats</div>
                                
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px; margin-bottom: 10px;">
                                    <div style="background: #f8fafc; border-radius: 6px; padding: 6px 8px; font-size: 0.68rem;">
                                        <div style="color: #8b9a6e; font-weight: 800;">4321</div>
                                        <div style="color: #94a3b8; font-size: 0.62rem;">Followers</div>
                                    </div>
                                    <div style="background: #f8fafc; border-radius: 6px; padding: 6px 8px; font-size: 0.68rem;">
                                        <div style="color: #00cec9; font-weight: 800;">9876</div>
                                        <div style="color: #94a3b8; font-size: 0.62rem;">Electronics</div>
                                    </div>
                                    <div style="background: #f8fafc; border-radius: 6px; padding: 6px 8px; font-size: 0.68rem;">
                                        <div style="color: #f59e0b; font-weight: 800;">345</div>
                                        <div style="color: #94a3b8; font-size: 0.62rem;">Toys</div>
                                    </div>
                                    <div style="background: #f8fafc; border-radius: 6px; padding: 6px 8px; font-size: 0.68rem;">
                                        <div style="color: #10b981; font-weight: 800;">1025</div>
                                        <div style="color: #94a3b8; font-size: 0.62rem;">Vouchers</div>
                                    </div>
                                </div>

                                <!-- Donut Chart matching Image 1 -->
                                <div class="donut-chart-wrap">
                                    <svg width="110" height="110" viewBox="-3 -3 42 42" style="overflow: visible;">
                                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#f1f5f9" stroke-width="6"/>
                                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 11.25 26.96" fill="none" stroke="#00cec9" stroke-width="6" stroke-dasharray="35, 100"/>
                                        <path d="M29.25 29.0445 a 15.9155 15.9155 0 0 1 -22.5 0" fill="none" stroke="#c48a5e" stroke-width="6" stroke-dasharray="25, 100"/>
                                        <path d="M6.75 29.0445 a 15.9155 15.9155 0 0 1 0 -22.5" fill="none" stroke="#f59e0b" stroke-width="6" stroke-dasharray="20, 100"/>
                                        <path d="M6.75 6.5445 a 15.9155 15.9155 0 0 1 11.25 -4.46" fill="none" stroke="#8b9a6e" stroke-width="6" stroke-dasharray="20, 100"/>
                                    </svg>
                                </div>
                                <div style="text-align: center; font-size: 0.72rem; color: #10b981; font-weight: 700;">
                                    <i class="fa-solid fa-check-circle"></i> 100% Real-Time Synchronized
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 2: Visual on Left, Text on Right -->
                <div class="storyline-row reveal-init">
                    <div class="storyline-node"></div>

                    <!-- Left: Visual Container Card -->
                    <div class="story-visual-wrap">
                        <div class="story-visual-card">
                            <div class="feature-phone-card">
                                <div class="phone-speaker-pill" style="margin-bottom: 10px;"></div>
                                <div style="font-size: 0.72rem; font-weight: 700; color: #55643b; text-transform: uppercase; margin-bottom: 8px;">Batch Thermal Shipping</div>
                                
                                <div style="background: #ffffff; border: 1px dashed #cbd5e1; border-radius: 8px; padding: 10px; margin-bottom: 10px; text-align: center;">
                                    <div style="font-family: monospace; font-size: 0.66rem; font-weight: 700; color: #475569; letter-spacing: 2px; margin-bottom: 4px;">#VT-882941-TK</div>
                                    <div style="display: flex; justify-content: center; align-items: flex-end; gap: 3px; height: 28px; margin: 0 auto 6px auto;">
                                        <span style="width: 2px; height: 100%; background: #1e293b;"></span>
                                        <span style="width: 4px; height: 100%; background: #1e293b;"></span>
                                        <span style="width: 1px; height: 100%; background: #1e293b;"></span>
                                        <span style="width: 3px; height: 100%; background: #1e293b;"></span>
                                        <span style="width: 2px; height: 100%; background: #1e293b;"></span>
                                        <span style="width: 5px; height: 100%; background: #1e293b;"></span>
                                        <span style="width: 1px; height: 100%; background: #1e293b;"></span>
                                        <span style="width: 3px; height: 100%; background: #1e293b;"></span>
                                        <span style="width: 2px; height: 100%; background: #1e293b;"></span>
                                        <span style="width: 4px; height: 100%; background: #1e293b;"></span>
                                        <span style="width: 2px; height: 100%; background: #1e293b;"></span>
                                        <span style="width: 3px; height: 100%; background: #1e293b;"></span>
                                        <span style="width: 5px; height: 100%; background: #1e293b;"></span>
                                    </div>
                                    <div style="font-size: 0.65rem; color: #10b981; font-weight: 700;">
                                        <i class="fa-solid fa-print"></i> 128 Resi Siap Cetak (1-Klik)
                                    </div>
                                </div>

                                <div style="display: flex; flex-direction: column; gap: 5px; font-size: 0.7rem; margin-bottom: 8px;">
                                    <div style="display: flex; justify-content: space-between; padding: 5px 8px; background: #f8fafc; border-radius: 6px;">
                                        <span>SLK-DRESS-S</span>
                                        <span style="color: #8b9a6e; font-weight: 700;">12 Pcs (Rak A-04)</span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; padding: 5px 8px; background: #f8fafc; border-radius: 6px;">
                                        <span>OVR-HOODIE-M</span>
                                        <span style="color: #55643b; font-weight: 700;">8 Pcs (Rak B-12)</span>
                                    </div>
                                </div>

                                <div style="text-align: center; font-size: 0.68rem; color: #10b981; font-weight: 600;">
                                    <i class="fa-solid fa-barcode"></i> Verifikasi Scanner 99.9% Akurat
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Paper Text Card -->
                    <div class="story-paper-wrap">
                        <div class="story-paper-card">
                            <div class="story-category">Fulfillment &amp; Logistik</div>
                            <h3 class="story-main-title">Fulfillment Cepat &amp; Cetak Resi Massal</h3>
                            <div class="story-divider"></div>
                            <p class="story-desc">
                                Cetak ratusan label pengiriman termal dan lembar pengambilan (picking list) per kategori hanya dengan satu klik.
                            </p>
                            <div class="story-subcard">
                                <div class="story-subcard-header">
                                    <span><i class="fa-solid fa-check" style="color: #10b981; margin-right: 6px;"></i> Verifikasi Barcode Scanner</span>
                                </div>
                                <p class="story-subcard-desc">
                                    Mencegah salah kirim varian barang hingga 99.9%.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 3: Text on Left, Visual on Right -->
                <div class="storyline-row reveal-init">
                    <div class="storyline-node"></div>

                    <!-- Left: Paper Text Card -->
                    <div class="story-paper-wrap">
                        <div class="story-paper-card">
                            <div class="story-category">Multi-Warehouse Routing</div>
                            <h3 class="story-main-title">Manajemen Multi-Lokasi Gudang</h3>
                            <div class="story-divider"></div>
                            <p class="story-desc">
                                Distribusi stok ke gudang regional. Alokasi pesanan otomatis memilih gudang terdekat dengan pembeli guna memangkas ongkos kirim dan SLA pengiriman.
                            </p>
                            <div class="story-subcard">
                                <div class="story-subcard-header">
                                    <span><i class="fa-solid fa-boxes-stacked" style="color: #8b9a6e; margin-right: 6px;"></i> Transfer Order (TO) Terintegrasi</span>
                                </div>
                                <p class="story-subcard-desc">
                                    Pindahkan dan pantau mutasi inventori antar-gudang secara otomatis tanpa selisih fisik.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Visual Container Card -->
                    <div class="story-visual-wrap">
                        <div class="story-visual-card">
                            <div class="feature-phone-card">
                                <div class="phone-speaker-pill" style="margin-bottom: 10px;"></div>
                                <div style="font-size: 0.72rem; font-weight: 700; color: #55643b; text-transform: uppercase; margin-bottom: 6px;">In-Row Editable Cell</div>
                                
                                <div style="background: #f8fafc; border-radius: 6px; padding: 6px 10px; margin-bottom: 8px; font-size: 0.72rem; color: #94a3b8; display: flex; align-items: center; gap: 6px;">
                                    <i class="fa-solid fa-magnifying-glass"></i> Cari SKU Produk...
                                </div>

                                <div style="display: flex; flex-direction: column; gap: 6px; font-size: 0.72rem;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 6px; background: #ffffff; border-radius: 6px; border: 1px solid #f1f5f9;">
                                        <span>Gudang Jakarta</span>
                                        <span style="color: #8b9a6e; font-weight: 700;">8,420 Unit</span>
                                    </div>
                                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 6px; background: #ffffff; border-radius: 6px; border: 1px solid #f1f5f9;">
                                        <span>Hub Surabaya</span>
                                        <span style="color: #55643b; font-weight: 700;">3,150 Unit</span>
                                    </div>
                                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 6px; background: #ffffff; border-radius: 6px; border: 1px solid #f1f5f9;">
                                        <span>Hub Medan</span>
                                        <span style="color: #10b981; font-weight: 700;">1,890 Unit</span>
                                    </div>
                                </div>

                                <div style="margin-top: 10px; font-size: 0.72rem; color: #55643b; font-weight: 600; text-align: center;">
                                    <i class="fa-solid fa-route"></i> Auto-Routing Active
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 4: Visual on Left, Text on Right -->
                <div class="storyline-row reveal-init">
                    <div class="storyline-node"></div>

                    <!-- Left: Visual Container Card -->
                    <div class="story-visual-wrap">
                        <div class="story-visual-card">
                            <div class="feature-phone-card">
                                <div class="phone-speaker-pill" style="margin-bottom: 10px;"></div>
                                <div style="font-size: 0.72rem; font-weight: 700; color: #55643b; text-transform: uppercase; margin-bottom: 8px;">Settlement &amp; Rekonsiliasi</div>
                                
                                <div style="background: #f8fafc; border-radius: 8px; padding: 8px 10px; margin-bottom: 8px; font-size: 0.7rem;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 4px; color: #64748b;">
                                        <span>Gross GMV Order</span>
                                        <strong style="color: #1e293b;">Rp 142.850.000</strong>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 4px; color: #ef4444;">
                                        <span>Potongan Escrow MP</span>
                                        <strong>-Rp 9.280.000</strong>
                                    </div>
                                    <div style="border-top: 1px dashed #cbd5e1; padding-top: 4px; display: flex; justify-content: space-between; color: #059669; font-weight: 700;">
                                        <span>Net Payout Bank</span>
                                        <span>Rp 133.570.000</span>
                                    </div>
                                </div>

                                <div style="display: flex; flex-direction: column; gap: 5px; font-size: 0.7rem; margin-bottom: 8px;">
                                    <div style="display: flex; justify-content: space-between; padding: 4px 8px; background: #ffffff; border: 1px solid #f1f5f9; border-radius: 6px;">
                                        <span>Mutasi Bank Masuk</span>
                                        <span style="color: #10b981; font-weight: 700;">Match 100% ✓</span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; padding: 4px 8px; background: #ffffff; border: 1px solid #f1f5f9; border-radius: 6px;">
                                        <span>Audit HPP (COGS)</span>
                                        <span style="color: #8b9a6e; font-weight: 700;">Terkalkulasi Real-Time</span>
                                    </div>
                                </div>

                                <div style="text-align: center; font-size: 0.68rem; color: #10b981; font-weight: 600;">
                                    <i class="fa-solid fa-shield-check"></i> Akuntabel 100% • Zero Selisih
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Paper Text Card -->
                    <div class="story-paper-wrap">
                        <div class="story-paper-card">
                            <div class="story-category">Financial Settlement &amp; Audit</div>
                            <h3 class="story-main-title">Rekonsiliasi Keuangan &amp; Settlement Otomatis</h3>
                            <div class="story-divider"></div>
                            <p class="story-desc">
                                Audit otomatis seluruh potongan komisi marketplace, voucher platform, biaya logistik, hingga retur. Vendio mencocokkan setiap pesanan dengan mutasi bank sebenarnya tanpa lembar Excel manual.
                            </p>
                            <div class="story-subcard">
                                <div class="story-subcard-header">
                                    <span><i class="fa-solid fa-coins" style="color: #8b9a6e; margin-right: 6px;"></i> Audit HPP (COGS) &amp; Laba Bersih per Order Real-Time</span>
                                </div>
                                <p class="story-subcard-desc">
                                    Perhitungan profitabilitas bersih real-time per transaksi setelah dipotong beban operasional dan potongan komisi.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- ==========================================================================
       6. SHOWCASE / MODULES STRIP (Flowchart Data Matching Image 2 in Image 1 Style)
       ========================================================================== -->
    <section class="showcase-section" id="showcase">
        <div class="container">
            <div class="section-header reveal-init">
                <h2 class="section-title">Bagaimana Data Mengalir di Dalam Vendio ERP</h2>
                <div class="title-indicator"></div>
                <p class="section-subtitle">
                    Dari saat pesanan masuk di marketplace hingga barang sampai di tangan pelanggan dan tercatat di buku kas.
                </p>
            </div>

            <div class="showcase-slider-wrap">
                <!-- Langkah 01 -->
                <div class="showcase-phone-card reveal-init reveal-delay-1">
                    <div class="phone-speaker-pill"></div>
                    <div style="font-size: 0.72rem; font-weight: 700; color: #8b9a6e; text-transform: uppercase;">LANGKAH 01</div>
                    <div style="font-size: 0.98rem; font-weight: 700; color: #232b1e; margin: 6px 0 12px 0;">Omnichannel Ingestion</div>
                    <div style="background: #f8fafc; border: 1px solid #edf2f7; border-radius: 10px; padding: 14px; font-size: 0.8rem; color: #64748b; line-height: 1.6; flex-grow: 1;">
                        Webhook menangkap pesanan baru &amp; event pembayaran dari TikTok Shop dan Tokopedia secara real-time.
                    </div>
                </div>

                <!-- Langkah 02 -->
                <div class="showcase-phone-card reveal-init reveal-delay-2">
                    <div class="phone-speaker-pill"></div>
                    <div style="font-size: 0.72rem; font-weight: 700; color: #00cec9; text-transform: uppercase;">LANGKAH 02</div>
                    <div style="font-size: 0.98rem; font-weight: 700; color: #232b1e; margin: 6px 0 12px 0;">Inventory Allocation</div>
                    <div style="background: #f8fafc; border: 1px solid #edf2f7; border-radius: 10px; padding: 14px; font-size: 0.8rem; color: #64748b; line-height: 1.6; flex-grow: 1;">
                        Sistem mengunci stok, memotong kuota channel lain, dan menentukan gudang terdekat untuk pengiriman.
                    </div>
                </div>

                <!-- Langkah 03 -->
                <div class="showcase-phone-card reveal-init reveal-delay-3">
                    <div class="phone-speaker-pill"></div>
                    <div style="font-size: 0.72rem; font-weight: 700; color: #f59e0b; text-transform: uppercase;">LANGKAH 03</div>
                    <div style="font-size: 0.98rem; font-weight: 700; color: #232b1e; margin: 6px 0 12px 0;">Warehouse Execution</div>
                    <div style="background: #f8fafc; border: 1px solid #edf2f7; border-radius: 10px; padding: 14px; font-size: 0.8rem; color: #64748b; line-height: 1.6; flex-grow: 1;">
                        Tim gudang mencetak resi batch, scan barcode produk, dan melakukan handover ke kurir ekspedisi.
                    </div>
                </div>

                <!-- Langkah 04 -->
                <div class="showcase-phone-card reveal-init reveal-delay-4">
                    <div class="phone-speaker-pill"></div>
                    <div style="font-size: 0.72rem; font-weight: 700; color: #10b981; text-transform: uppercase;">LANGKAH 04</div>
                    <div style="font-size: 0.98rem; font-weight: 700; color: #232b1e; margin: 6px 0 12px 0;">Settlement Audit</div>
                    <div style="background: #f8fafc; border: 1px solid #edf2f7; border-radius: 10px; padding: 14px; font-size: 0.8rem; color: #64748b; line-height: 1.6; flex-grow: 1;">
                        Dana dicairkan marketplace ke rekening bank dan dicocokkan otomatis dengan laporan laba rugi.
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ==========================================================================
       8. BLOG & ARTIKEL SECTION (Terkoneksi Dinamis dengan Modul Blog)
       ========================================================================== -->
    <section class="news-section" id="blog">
        <div class="container">
            <div class="section-header reveal-init">
                <h2 class="section-title">Blog &amp; Artikel</h2>
                <div class="title-indicator"></div>
                <p class="section-subtitle">
                    Wawasan terkini seputar arsitektur omnichannel ERP, efisiensi gudang, dan strategi ritel modern.
                </p>
            </div>

            <?php
                // Query 4 artikel blog terbaru yang telah dipublish (1 headline + 3 baris di kolom kanan)
                $ci =& get_instance();
                if (!isset($ci->model_blog)) {
                    $ci->load->model('blog/model_blog');
                }
                $landing_blogs = [];
                if (isset($ci->model_blog)) {
                    $landing_blogs = $ci->model_blog->get('', '', 4);
                }

                $headline_blog = !empty($landing_blogs[0]) ? $landing_blogs[0] : null;
                $secondary_blogs = [];
                for ($i = 1; $i <= 3; $i++) {
                    if (!empty($landing_blogs[$i])) {
                        $secondary_blogs[] = $landing_blogs[$i];
                    }
                }
            ?>

            <div class="news-grid">
                <!-- Big Featured Card (Headline) -->
                <?php if ($headline_blog): 
                    $h_img = '';
                    if (!empty($headline_blog->image)) {
                        $imgs = explode(',', $headline_blog->image);
                        $h_img = trim($imgs[0]);
                    }
                    $h_has_file = !empty($h_img) && file_exists(FCPATH . 'uploads/blog/' . $h_img);
                    $h_img_url = $h_has_file ? BASE_URL . 'uploads/blog/' . $h_img : 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=700&q=80';
                    $h_excerpt = !empty($headline_blog->excerpt)
                        ? (strlen($headline_blog->excerpt) > 160 ? substr($headline_blog->excerpt, 0, 160) . '...' : $headline_blog->excerpt)
                        : (function_exists('character_limiter') 
                            ? character_limiter(strip_tags($headline_blog->content), 140) 
                            : (strlen(strip_tags($headline_blog->content)) > 140 ? substr(strip_tags($headline_blog->content), 0, 140) . '...' : strip_tags($headline_blog->content)));
                    $h_date = date('d M Y', strtotime(!empty($headline_blog->published_at) ? $headline_blog->published_at : ($headline_blog->created_at ?: 'now')));
                    $h_read_time = !empty($headline_blog->read_time) ? intval($headline_blog->read_time) : max(1, ceil(str_word_count(strip_tags($headline_blog->content)) / 200));
                ?>
                    <div class="news-big-card reveal-left">
                        <a href="<?= site_url('blog/' . $headline_blog->slug); ?>" class="news-big-img" style="text-decoration: none;">
                            <img src="<?= $h_img_url; ?>" alt="<?= _ent($headline_blog->title); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                        </a>
                        <div class="news-card-inner">
                            <div class="news-meta-row" style="flex-wrap: wrap; gap: 8px;">
                                <span class="news-badge"><?= !empty($headline_blog->category_name) ? _ent(strtoupper($headline_blog->category_name)) : 'HEADLINE BLOG'; ?></span>
                                <span class="news-date"><i class="fa-regular fa-calendar"></i> <?= $h_date; ?></span>
                                <span class="news-date"><i class="fa-regular fa-clock"></i> <?= $h_read_time; ?> mnt</span>
                            </div>
                            <h4 class="news-card-title">
                                <a href="<?= site_url('blog/' . $headline_blog->slug); ?>" style="color: inherit; text-decoration: none;">
                                    <?= _ent($headline_blog->title); ?>
                                </a>
                            </h4>
                            <p class="news-card-desc">
                                <?= $h_excerpt; ?>
                            </p>
                            <a href="<?= site_url('blog/' . $headline_blog->slug); ?>" class="news-read-more">
                                Baca Selengkapnya <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Fallback Big Card Jika Belum Ada Artikel -->
                    <div class="news-big-card reveal-left">
                        <div class="news-big-img">
                            <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=700&q=80" alt="Headline news" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div class="news-card-inner">
                            <div class="news-meta-row">
                                <span class="news-badge">HEADLINE BLOG</span>
                                <span class="news-date"><i class="fa-regular fa-calendar"></i> <?= date('d M Y'); ?></span>
                            </div>
                            <h4 class="news-card-title">Solusi Arsitektur Omnichannel Modern untuk Ritel Skala Besar</h4>
                            <p class="news-card-desc">
                                Solusi arsitektur micro-services dan buffer stok real-time untuk mempertahankan rating toko di marketplace saat ribuan checkout terjadi bersamaan.
                            </p>
                            <a href="<?= site_url('blog'); ?>" class="news-read-more">
                                Baca Selengkapnya <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Right Stacked Column (3 Baris Artikel) -->
                <div class="news-stacked-col reveal-right">
                    <?php if (!empty($secondary_blogs)): ?>
                        <?php foreach ($secondary_blogs as $idx => $s_item): 
                            $s_img = '';
                            if (!empty($s_item->image)) {
                                $s_imgs = explode(',', $s_item->image);
                                $s_img = trim($s_imgs[0]);
                            }
                            $s_has_file = !empty($s_img) && file_exists(FCPATH . 'uploads/blog/' . $s_img);
                            $s_img_url = $s_has_file ? BASE_URL . 'uploads/blog/' . $s_img : '';
                            $s_date = date('d M Y', strtotime(!empty($s_item->published_at) ? $s_item->published_at : ($s_item->created_at ?: 'now')));
                            $s_read_time = !empty($s_item->read_time) ? intval($s_item->read_time) : max(1, ceil(str_word_count(strip_tags($s_item->content)) / 200));
                        ?>
                            <div class="news-small-card">
                                <a href="<?= site_url('blog/' . $s_item->slug); ?>" class="news-small-thumb <?= ($idx % 2 == 1) ? 'thumb-cyan' : ''; ?>" style="text-decoration: none;">
                                    <?php if (!empty($s_img_url)): ?>
                                        <img src="<?= $s_img_url; ?>" alt="<?= _ent($s_item->title); ?>">
                                    <?php else: ?>
                                        <i class="fa-solid fa-newspaper"></i>
                                    <?php endif; ?>
                                </a>
                                <div class="news-small-content">
                                    <div class="news-meta-row" style="flex-wrap: wrap; gap: 6px;">
                                        <span class="news-badge"><?= !empty($s_item->category_name) ? _ent(strtoupper($s_item->category_name)) : 'ARTIKEL'; ?></span>
                                        <span class="news-date"><i class="fa-regular fa-calendar"></i> <?= $s_date; ?></span>
                                        <span class="news-date"><i class="fa-regular fa-clock"></i> <?= $s_read_time; ?> mnt</span>
                                    </div>
                                    <h5 class="news-small-title">
                                        <a href="<?= site_url('blog/' . $s_item->slug); ?>" style="color: inherit; text-decoration: none;">
                                            <?= _ent($s_item->title); ?>
                                        </a>
                                    </h5>
                                    <a href="<?= site_url('blog/' . $s_item->slug); ?>" class="news-read-more">
                                        Baca Selengkapnya <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <?php if (count($secondary_blogs) < 3): ?>
                            <?php for ($fb_idx = count($secondary_blogs); $fb_idx < 3; $fb_idx++): ?>
                                <!-- Card Eksplorasi Pelengkap jika database memiliki kurang dari 4 artikel -->
                                <div class="news-small-card">
                                    <a href="<?= site_url('blog'); ?>" class="news-small-thumb <?= ($fb_idx % 2 == 1) ? 'thumb-cyan' : ''; ?>" style="text-decoration: none;">
                                        <i class="fa-solid <?= ($fb_idx == 1) ? 'fa-book-open-reader' : 'fa-chart-pie'; ?>"></i>
                                    </a>
                                    <div class="news-small-content">
                                        <div class="news-meta-row">
                                            <span class="news-badge"><?= ($fb_idx == 1) ? 'EKSPLORASI' : 'INSIGHT'; ?></span>
                                            <span class="news-date"><i class="fa-regular fa-calendar"></i> <?= date('d M Y'); ?></span>
                                        </div>
                                        <h5 class="news-small-title">
                                            <a href="<?= site_url('blog'); ?>" style="color: inherit; text-decoration: none;">
                                                <?= ($fb_idx == 1) ? 'Jelajahi Wawasan &amp; Panduan Bisnis Omnichannel Lainnya' : 'Strategi Skalabilitas Bisnis dengan Ekosistem ERP Modern'; ?>
                                            </a>
                                        </h5>
                                        <a href="<?= site_url('blog'); ?>" class="news-read-more">
                                            Kunjungi Blog Vendio <i class="fa-solid fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        <?php endif; ?>

                    <?php else: ?>
                        <!-- Fallback 3 Card jika belum ada artikel sama sekali di database -->
                        <div class="news-small-card">
                            <div class="news-small-thumb">
                                <i class="fa-solid fa-chart-line"></i>
                            </div>
                            <div class="news-small-content">
                                <div class="news-meta-row">
                                    <span class="news-badge">STRATEGI</span>
                                    <span class="news-date"><i class="fa-regular fa-calendar"></i> <?= date('d M Y'); ?></span>
                                </div>
                                <h5 class="news-small-title">
                                    <a href="<?= site_url('blog'); ?>" style="color: inherit; text-decoration: none;">
                                        Optimalisasi Alur Distribusi Stok Multi-Gudang Terintegrasi
                                    </a>
                                </h5>
                                <a href="<?= site_url('blog'); ?>" class="news-read-more">
                                    Baca Selengkapnya <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>

                        <div class="news-small-card">
                            <div class="news-small-thumb thumb-cyan">
                                <i class="fa-solid fa-warehouse"></i>
                            </div>
                            <div class="news-small-content">
                                <div class="news-meta-row">
                                    <span class="news-badge">OPERASIONAL</span>
                                    <span class="news-date"><i class="fa-regular fa-calendar"></i> <?= date('d M Y'); ?></span>
                                </div>
                                <h5 class="news-small-title">
                                    <a href="<?= site_url('blog'); ?>" style="color: inherit; text-decoration: none;">
                                        Mencegah Risiko Overselling Saat Event Kampanye Marketplace
                                    </a>
                                </h5>
                                <a href="<?= site_url('blog'); ?>" class="news-read-more">
                                    Baca Selengkapnya <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>

                        <div class="news-small-card">
                            <div class="news-small-thumb">
                                <i class="fa-solid fa-network-wired"></i>
                            </div>
                            <div class="news-small-content">
                                <div class="news-meta-row">
                                    <span class="news-badge">TEKNOLOGI</span>
                                    <span class="news-date"><i class="fa-regular fa-calendar"></i> <?= date('d M Y'); ?></span>
                                </div>
                                <h5 class="news-small-title">
                                    <a href="<?= site_url('blog'); ?>" style="color: inherit; text-decoration: none;">
                                        Sinkronisasi Real-Time Katalog Produk Shopee &amp; TikTok Shop
                                    </a>
                                </h5>
                                <a href="<?= site_url('blog'); ?>" class="news-read-more">
                                    Baca Selengkapnya <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Tombol Aksi Menuju Halaman Blog -->
            <div class="news-footer-action reveal-init reveal-delay-2">
                <a href="<?= site_url('blog'); ?>" class="btn-view-all-blog">
                    Lihat Semua Blog &amp; Artikel <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>



    <!-- ==========================================================================
       9. FAQ SECTION (Megaphone Illustration + Accordion matching Landing.jpg)
       ========================================================================== -->
    <section class="faq-section" id="faq">
        <div class="container">
            <div class="faq-grid">
                <!-- Left Column -->
                <div class="faq-left-info reveal-left">
                    <h2 class="faq-left-title">FAQ</h2>
                    <div class="title-indicator left"></div>
                    <p class="faq-left-desc">
                        Pertanyaan umum seputar sinkronisasi marketplace, manajemen multi-gudang, dan rekonsiliasi finansial otomatis di platform Vendio.
                    </p>

                    <!-- Crisp Inline Megaphone Vector Illustration matching Landing.jpg -->
                    <div class="faq-mega-wrap reveal-scale reveal-delay-1">
                        <svg width="100%" height="100%" viewBox="0 0 240 200" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet">
                            <!-- Soft Background Blob -->
                            <circle cx="110" cy="110" r="75" fill="url(#megaBlobGrad)" opacity="0.25"/>
                            <circle cx="165" cy="55" r="22" fill="#8b9a6e" opacity="0.15"/>
                            <circle cx="55" cy="155" r="14" fill="#00cec9" opacity="0.2"/>
                            
                            <!-- Question Bubble -->
                            <rect x="145" y="32" width="40" height="30" rx="10" fill="#8b9a6e"/>
                            <polygon points="152,62 160,62 152,69" fill="#8b9a6e"/>
                            <text x="165" y="53" fill="#ffffff" font-family="'Poppins', sans-serif" font-weight="700" font-size="16" text-anchor="middle">?</text>

                            <!-- Sound waves -->
                            <path d="M 155 85 A 35 35 0 0 1 175 115" stroke="#00cec9" stroke-width="3" stroke-linecap="round" fill="none"/>
                            <path d="M 165 75 A 50 50 0 0 1 190 125" stroke="#8b9a6e" stroke-width="3" stroke-linecap="round" fill="none"/>

                            <!-- Megaphone Body -->
                            <g transform="rotate(-25 110 110)">
                                <!-- Cone -->
                                <polygon points="80,95 140,70 140,150 80,125" fill="url(#coneGrad)"/>
                                <!-- Back Cylinder -->
                                <rect x="55" y="95" width="25" height="30" rx="4" fill="#5d3ef2"/>
                                <!-- Handle -->
                                <rect x="68" y="125" width="12" height="35" rx="5" fill="#00cec9"/>
                                <!-- Mouth Ring -->
                                <ellipse cx="140" cy="110" rx="6" ry="40" fill="#38bdf8"/>
                            </g>

                            <!-- Gradients -->
                            <defs>
                                <linearGradient id="megaBlobGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#8b9a6e"/>
                                    <stop offset="100%" stop-color="#5d6e42"/>
                                </linearGradient>
                                <linearGradient id="coneGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#5d6e42"/>
                                    <stop offset="100%" stop-color="#8b9a6e"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                </div>

                <!-- Right Column (Accordion with First Item Active Purple matching Landing.jpg) -->
                <div class="accordion-list reveal-right">
                    <div class="accordion-item active">
                        <div class="accordion-header" onclick="toggleFaq(this)">
                            <span>Bagaimana Vendio mencegah terjadinya overselling saat event atau live streaming?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="accordion-body">
                            Vendio mengandalkan engine Virtual Inventory Buffer dengan latensi pembaruan stok di bawah 1,5 detik. Begitu ada 1 unit produk terjual di sesi Live TikTok Shop, kuota stok di Tokopedia, Shopee, dan channel lainnya langsung dipotong secara otomatis dan seketika untuk mencegah pesanan ganda.
                        </div>
                    </div>

                    <div class="accordion-item">
                        <div class="accordion-header" onclick="toggleFaq(this)">
                            <span>Apakah ada batasan jumlah akun toko marketplace, gudang, atau SKU produk?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="accordion-body">
                            Tidak ada batasan. Vendio dirancang dengan arsitektur multi-tenant dan multi-store skala enterprise, sehingga Anda bebas menghubungkan puluhan akun toko resmi, mengelola ratusan ribu SKU katalog produk, serta mengatur alur pengiriman di berbagai cabang gudang (multi-warehouse) dalam satu dashboard terintegrasi.
                        </div>
                    </div>

                    <div class="accordion-item">
                        <div class="accordion-header" onclick="toggleFaq(this)">
                            <span>Bagaimana proses rekonsiliasi keuangan dan audit potongan komisi marketplace?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="accordion-body">
                            Sistem audit otomatis Vendio mencocokkan setiap nomor pesanan dengan mutasi pencairan dana (escrow payout) yang masuk ke rekening bank Anda. Seluruh beban komisi platform, voucher marketplace, selisih ongkir, hingga transaksi retur langsung dikalkulasi secara transparan tanpa perlu rekap Excel manual.
                        </div>
                    </div>

                    <div class="accordion-item">
                        <div class="accordion-header" onclick="toggleFaq(this)">
                            <span>Apakah tim operasional gudang dapat mencetak resi pengiriman massal sekaligus?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="accordion-body">
                            Ya, sangat praktis. Vendio memiliki fitur Batch Fulfillment yang memungkinkan tim fulfillment mencetak 100+ label resi termal sekaligus dalam sekali klik, terintegrasi dengan fitur scan barcode produk untuk memverifikasi akurasi isi paket sebelum diserahkan ke kurir ekspedisi.
                        </div>
                    </div>

                    <div class="accordion-item">
                        <div class="accordion-header" onclick="toggleFaq(this)">
                            <span>Berapa lama proses implementasi dan integrasi toko ritel ke sistem Vendio?</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="accordion-body">
                            Integrasi akun toko resmi TikTok Shop dan Tokopedia dapat selesai hanya dalam beberapa menit melalui otorisasi Open API resmi. Untuk import master katalog dan pemetaan kuota gudang awal, tim onboarding kami siap mendampingi langsung hingga seluruh sistem siap beroperasi penuh.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ==========================================================================
       12. FOOTER (Matching Landing.jpg)
       ========================================================================== -->
    <footer class="footer-light">
        <div class="container">
            <div class="footer-grid reveal-init">
                <!-- Column 1: Brand Info -->
                <div>
                    <a href="#" class="brand-logo" style="margin-bottom: 6px; display: inline-flex; align-items: center; gap: 10px;" title="Kembali ke atas">
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
                        <li><a href="#feature">Sinkronisasi Katalog</a></li>
                        <li><a href="#feature">Orkestrasi Pesanan</a></li>
                        <li><a href="#feature">Multi-Gudang (WMS)</a></li>
                        <li><a href="#feature">Rekonsiliasi Finansial</a></li>
                        <li><a href="#feature">Audit &amp; Reporting</a></li>
                    </ul>
                </div>

                <!-- Column 3: KANAL INTEGRASI -->
                <div>
                    <h5 class="footer-col-title">KANAL INTEGRASI</h5>
                    <ul class="footer-nav-list">
                        <li><a href="#showcase">TikTok Shop Open API</a></li>
                        <li><a href="#showcase">Tokopedia Merchant Hub</a></li>
                        <li><a href="#showcase">Shopee Open Platform</a></li>
                        <li><a href="#showcase">Integrasi J&amp;T &amp; SiCepat</a></li>
                        <li><a href="#showcase">Accurate &amp; Jurnal ERP</a></li>
                    </ul>
                </div>

                <!-- Column 4: PERUSAHAAN & BLOG -->
                <div>
                    <h5 class="footer-col-title">PERUSAHAAN &amp; BLOG</h5>
                    <ul class="footer-nav-list">
                        <li><a href="<?= site_url('blog'); ?>">Vendio Tech Insights</a></li>
                        <li><a href="<?= site_url('blog'); ?>">Arsip Artikel Blog</a></li>
                        <li><a href="<?= $admin_url; ?>">Portal Login Admin</a></li>
                        <li><a href="#faq">Dokumentasi API</a></li>
                        <li><a href="#faq">Privasi &amp; Keamanan Data</a></li>
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

    <!-- INTERACTIVE JAVASCRIPT -->
    <script>
        // FAQ Accordion Toggle with Smooth Animation
        function toggleFaq(header) {
            const item = header.parentElement;
            const body = item.querySelector('.accordion-body');
            const isActive = item.classList.contains('active');
            const allItems = document.querySelectorAll('.accordion-item');

            // Tutup item lain yang sedang terbuka dengan animasi halus
            allItems.forEach(el => {
                if (el !== item && el.classList.contains('active')) {
                    const otherBody = el.querySelector('.accordion-body');
                    if (otherBody) {
                        otherBody.style.maxHeight = otherBody.scrollHeight + 'px';
                        otherBody.offsetHeight; // Force reflow
                        otherBody.style.maxHeight = '0px';
                    }
                    el.classList.remove('active');
                }
            });

            // Toggle item saat ini
            if (isActive) {
                if (body) {
                    body.style.maxHeight = body.scrollHeight + 'px';
                    body.offsetHeight; // Force reflow
                    body.style.maxHeight = '0px';
                }
                item.classList.remove('active');
            } else {
                item.classList.add('active');
                if (body) {
                    body.style.maxHeight = '0px';
                    body.offsetHeight; // Force reflow
                    body.style.maxHeight = (body.scrollHeight + 40) + 'px';
                }
            }
        }

        // Inisialisasi item FAQ yang aktif saat halaman dimuat
        function initFaqAccordion() {
            const activeItem = document.querySelector('.accordion-item.active');
            if (activeItem) {
                const activeBody = activeItem.querySelector('.accordion-body');
                if (activeBody) {
                    activeBody.style.maxHeight = (activeBody.scrollHeight + 40) + 'px';
                }
            }
        }
        window.addEventListener('load', initFaqAccordion);
        window.addEventListener('resize', initFaqAccordion);



        // ==========================================================================
        // Mobile Menu Dropdown Toggle (Matching Image 2 Design)
        // Handled centrally by vendio-page-transition.js (initMobileMenu)
        // ==========================================================================
        if (typeof window.initMobileMenu === 'function') {
            window.initMobileMenu();
        }

        // Active Nav Indicator on Scroll (ScrollSpy)
        const targetSections = document.querySelectorAll('section[id]');
        const menuLinks = document.querySelectorAll('.nav-link');
        const mobileLinks = document.querySelectorAll('.mobile-dropdown-item');

        function updateActiveNav() {
            let currentId = '';
            const scrollPos = window.scrollY + 180;

            targetSections.forEach(section => {
                const top = section.offsetTop;
                const height = section.offsetHeight;
                if (scrollPos >= top && scrollPos < top + height) {
                    currentId = section.getAttribute('id');
                }
            });

            menuLinks.forEach(link => {
                link.classList.remove('active');
                if (currentId && link.getAttribute('href') === '#' + currentId) {
                    link.classList.add('active');
                }
            });

            mobileLinks.forEach(link => {
                link.classList.remove('active');
                if (currentId && link.getAttribute('href') === '#' + currentId) {
                    link.classList.add('active');
                }
            });
        }

        window.addEventListener('scroll', updateActiveNav, { passive: true });
        window.addEventListener('load', updateActiveNav);

        // Smooth scroll to top when clicking brand logo without page refresh
        document.querySelectorAll('a.brand-logo').forEach(logo => {
            logo.addEventListener('click', function(e) {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                if (window.location.hash) {
                    history.pushState(null, null, window.location.pathname);
                }
            });
        });

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

        // ==========================================================================
        // Scroll-Triggered Reveal & Disappear Animation ("Muncul & Hilang saat Scroll")
        // ==========================================================================
        const revealElements = document.querySelectorAll('.reveal-init, .reveal-left, .reveal-right, .reveal-scale');

        if ('IntersectionObserver' in window) {
            const scrollObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-revealed');
                    } else {
                        // Muncul dan hilang saat scroll
                        entry.target.classList.remove('is-revealed');
                    }
                });
            }, {
                root: null,
                threshold: 0.12,
                rootMargin: '0px 0px -40px 0px'
            });

            revealElements.forEach(el => scrollObserver.observe(el));
        } else {
            // Fallback for older browsers
            revealElements.forEach(el => el.classList.add('is-revealed'));
        }
    </script>

    <!-- Seamless Page Transition Router -->
    <script src="<?= BASE_ASSET; ?>js/vendio-page-transition.js?v=<?= file_exists(FCPATH . 'asset/js/vendio-page-transition.js') ? filemtime(FCPATH . 'asset/js/vendio-page-transition.js') : time(); ?>"></script>
</body>
</html>
