<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$is_logged_in = function_exists('app') && isset(app()->aauth) && app()->aauth->is_loggedin();
$user_name = $is_logged_in ? get_user_data('full_name') : '';
$admin_url = $is_logged_in ? site_url('administrator/dashboard') : site_url('administrator/login');
$admin_btn_text = $is_logged_in ? 'Buka Dashboard ERP' : 'Masuk ke Sistem';
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vendio | Enterprise Omnichannel Commerce & ERP Platform</title>
    <meta name="description" content="Platform Omnichannel ERP terpadu untuk sinkronisasi katalog TikTok Shop, Tokopedia, Shopee, orkestrasi pesanan, multi-gudang, dan rekonsiliasi finansial otomatis.">
    <meta name="keywords" content="omnichannel ERP, tiktok shop sync, tokopedia sync, inventory management, retail ERP, marketplace reconciliation">
    <meta name="author" content="Vendio Tech">

    <!-- Modern Typography: Plus Jakarta Sans & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* ==========================================================================
           VENDIO DESIGN SYSTEM - REFINED TECH & ENTERPRISE ERP PALETTE
           ========================================================================== */
        :root {
            --bg-canvas: #090d16;
            --bg-surface: #0f1626;
            --bg-surface-elevated: #162035;
            --bg-card: rgba(18, 26, 44, 0.78);
            --bg-card-hover: rgba(24, 35, 60, 0.9);
            
            --border-subtle: rgba(255, 255, 255, 0.08);
            --border-medium: rgba(255, 255, 255, 0.14);
            --border-focus: rgba(99, 102, 241, 0.5);

            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            
            --accent-brand: #3b82f6;
            --accent-brand-hover: #2563eb;
            --accent-teal: #0ea5e9;
            --accent-emerald: #10b981;
            --accent-amber: #f59e0b;
            --accent-purple: #8b5cf6;

            --font-sans: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --font-mono: 'JetBrains Mono', monospace;
            
            --shadow-subtle: 0 4px 20px -2px rgba(0, 0, 0, 0.35);
            --shadow-elevated: 0 20px 40px -15px rgba(0, 0, 0, 0.6);
            --radius-md: 10px;
            --radius-lg: 16px;
            --radius-xl: 24px;
        }

        /* Reset & Global */
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            font-size: 16px;
            scroll-behavior: smooth;
            background-color: var(--bg-canvas);
            color: var(--text-primary);
        }

        body {
            font-family: var(--font-sans);
            background-color: var(--bg-canvas);
            color: var(--text-primary);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
            background-image: 
                radial-gradient(ellipse 80% 50% at 50% -20%, rgba(59, 130, 246, 0.15), transparent),
                radial-gradient(circle at 100% 40%, rgba(16, 185, 129, 0.05), transparent 400px),
                radial-gradient(circle at 0% 70%, rgba(99, 102, 241, 0.06), transparent 500px);
            background-attachment: fixed;
        }

        a {
            color: inherit;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        button {
            font-family: inherit;
            cursor: pointer;
            border: none;
            outline: none;
        }

        .container {
            width: 100%;
            max-width: 1240px;
            margin-left: auto;
            margin-right: auto;
            padding-left: 24px;
            padding-right: 24px;
        }

        /* Typography Utilities */
        .font-mono { font-family: var(--font-mono); }
        .text-gradient {
            background: linear-gradient(135deg, #ffffff 30%, #94a3b8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .text-gradient-accent {
            background: linear-gradient(135deg, #60a5fa 0%, #34d399 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* ==========================================================================
           HEADER & TOP TELEMETRY
           ========================================================================== */
        .top-telemetry-bar {
            background: rgba(15, 23, 42, 0.85);
            border-bottom: 1px solid var(--border-subtle);
            font-size: 0.78rem;
            color: var(--text-muted);
            padding: 8px 0;
            backdrop-filter: blur(10px);
        }

        .telemetry-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .telemetry-left, .telemetry-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .status-dot-pulse {
            display: inline-block;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background-color: var(--accent-emerald);
            box-shadow: 0 0 8px var(--accent-emerald);
            animation: pulse-dot 2s infinite ease-in-out;
            margin-right: 6px;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(0.85); }
        }

        .navbar-main {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(9, 13, 22, 0.88);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-subtle);
            padding: 16px 0;
            transition: all 0.3s ease;
        }

        .nav-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 800;
            font-size: 1.35rem;
            letter-spacing: -0.02em;
        }

        .brand-symbol {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #1e293b, #0f172a);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #60a5fa;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .brand-badge {
            font-family: var(--font-mono);
            font-size: 0.65rem;
            background: rgba(59, 130, 246, 0.12);
            color: #60a5fa;
            border: 1px solid rgba(59, 130, 246, 0.25);
            padding: 2px 7px;
            border-radius: 6px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-left: 6px;
            font-weight: 600;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 32px;
            list-style: none;
        }

        .nav-link {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-link:hover {
            color: var(--text-primary);
        }

        .nav-badge-pill {
            font-size: 0.65rem;
            padding: 1px 6px;
            border-radius: 10px;
            background: rgba(16, 185, 129, 0.12);
            color: #34d399;
            font-weight: 600;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .btn-nav-ghost {
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--text-primary);
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .btn-nav-ghost:hover {
            background: rgba(255, 255, 255, 0.06);
        }

        .btn-nav-primary {
            font-size: 0.88rem;
            font-weight: 600;
            background: #ffffff;
            color: #090d16;
            padding: 9px 20px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            box-shadow: 0 2px 10px rgba(255, 255, 255, 0.1);
        }

        .btn-nav-primary:hover {
            background: #e2e8f0;
            transform: translateY(-1px);
        }

        .mobile-toggle {
            display: none;
            background: none;
            color: var(--text-primary);
            font-size: 1.3rem;
        }

        /* ==========================================================================
           HERO SECTION
           ========================================================================== */
        .hero-section {
            padding: 80px 0 60px;
            position: relative;
            text-align: center;
        }

        .hero-badge-container {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(22, 32, 53, 0.8);
            border: 1px solid var(--border-medium);
            padding: 6px 16px;
            border-radius: 30px;
            font-size: 0.8rem;
            color: var(--text-secondary);
            margin-bottom: 28px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        }

        .hero-title {
            font-size: clamp(2.4rem, 5vw, 3.8rem);
            font-weight: 800;
            letter-spacing: -0.03em;
            line-height: 1.15;
            max-width: 960px;
            margin: 0 auto 24px;
        }

        .hero-desc {
            font-size: clamp(1.05rem, 2vw, 1.25rem);
            color: var(--text-secondary);
            max-width: 720px;
            margin: 0 auto 36px;
            font-weight: 400;
            line-height: 1.6;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 50px;
        }

        .btn-hero-primary {
            background: linear-gradient(180deg, #3b82f6 0%, #2563eb 100%);
            color: #ffffff;
            font-weight: 600;
            font-size: 1rem;
            padding: 14px 28px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 20px -2px rgba(37, 99, 235, 0.45);
            transition: all 0.2s;
        }

        .btn-hero-primary:hover {
            background: linear-gradient(180deg, #60a5fa 0%, #2563eb 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -2px rgba(37, 99, 235, 0.6);
        }

        .btn-hero-secondary {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-medium);
            color: var(--text-primary);
            font-weight: 600;
            font-size: 1rem;
            padding: 14px 28px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            backdrop-filter: blur(10px);
            transition: all 0.2s;
        }

        .btn-hero-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.25);
            transform: translateY(-1px);
        }

        /* Hero Stats Strip */
        .hero-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            max-width: 980px;
            margin: 0 auto;
            border-top: 1px solid var(--border-subtle);
            border-bottom: 1px solid var(--border-subtle);
            padding: 24px 0;
        }

        .hero-stat-item {
            text-align: center;
            padding: 8px;
        }

        .hero-stat-value {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--text-primary);
            font-family: var(--font-mono);
            letter-spacing: -0.02em;
        }

        .hero-stat-label {
            font-size: 0.82rem;
            color: var(--text-muted);
            margin-top: 4px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        /* ==========================================================================
           HERO INTERACTIVE COMMAND CENTER (ERP UI MOCKUP)
           ========================================================================== */
        .mockup-container {
            margin: 60px auto 0;
            max-width: 1140px;
            position: relative;
        }

        .mockup-glow {
            position: absolute;
            top: -20px;
            left: 5%;
            right: 5%;
            height: 120px;
            background: radial-gradient(ellipse at center, rgba(59, 130, 246, 0.25), transparent 70%);
            filter: blur(40px);
            z-index: 1;
            pointer-events: none;
        }

        .erp-mockup-frame {
            position: relative;
            z-index: 2;
            background: #0d1320;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: var(--radius-lg);
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.8);
            overflow: hidden;
            text-align: left;
        }

        /* Mockup Top Navigation Bar */
        .mockup-top-bar {
            background: #111827;
            padding: 12px 18px;
            border-bottom: 1px solid var(--border-subtle);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .mockup-dots {
            display: flex;
            gap: 6px;
        }

        .mockup-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }
        .dot-red { background: #ef4444; }
        .dot-yellow { background: #f59e0b; }
        .dot-green { background: #10b981; }

        .mockup-channel-indicators {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.76rem;
            font-family: var(--font-mono);
        }

        .channel-pill {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-subtle);
            padding: 3px 10px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Mockup Tab Controls */
        .mockup-tabs-bar {
            display: flex;
            background: rgba(15, 23, 42, 0.7);
            border-bottom: 1px solid var(--border-subtle);
            overflow-x: auto;
        }

        .mockup-tab-btn {
            padding: 12px 20px;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-muted);
            background: transparent;
            border-bottom: 2px solid transparent;
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            transition: all 0.2s;
        }

        .mockup-tab-btn:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.02);
        }

        .mockup-tab-btn.active {
            color: #60a5fa;
            border-bottom-color: #3b82f6;
            background: rgba(59, 130, 246, 0.06);
        }

        /* Mockup Content Panels */
        .mockup-body {
            padding: 24px;
            background: #090e17;
            min-height: 380px;
        }

        .tab-panel {
            display: none;
            animation: fadeInPanel 0.3s ease forwards;
        }

        .tab-panel.active {
            display: block;
        }

        @keyframes fadeInPanel {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Mockup Data Tables */
        .mockup-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.84rem;
        }

        .mockup-table th {
            text-align: left;
            padding: 10px 14px;
            background: #111827;
            color: var(--text-muted);
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--border-subtle);
        }

        .mockup-table td {
            padding: 12px 14px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            color: var(--text-secondary);
            vertical-align: middle;
        }

        .mockup-table tr:hover td {
            background: rgba(255, 255, 255, 0.02);
            color: var(--text-primary);
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.72rem;
            font-weight: 600;
        }
        .badge-live { background: rgba(16, 185, 129, 0.12); color: #34d399; }
        .badge-sync { background: rgba(59, 130, 246, 0.12); color: #60a5fa; }
        .badge-wait { background: rgba(245, 158, 11, 0.12); color: #fbbf24; }

        /* ==========================================================================
           LOGOS / CHANNELS SECTION
           ========================================================================== */
        .ecosystem-section {
            padding: 60px 0;
            border-bottom: 1px solid var(--border-subtle);
        }

        .section-label {
            text-align: center;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-muted);
            margin-bottom: 24px;
            font-family: var(--font-mono);
        }

        .ecosystem-grid {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 36px;
            flex-wrap: wrap;
            opacity: 0.75;
        }

        .ecosystem-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--text-secondary);
            padding: 10px 18px;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--border-subtle);
            border-radius: 8px;
            transition: all 0.2s;
        }

        .ecosystem-item:hover {
            opacity: 1;
            border-color: var(--border-medium);
            color: var(--text-primary);
            transform: translateY(-2px);
        }

        /* ==========================================================================
           BENTO GRID - ERP CAPABILITIES
           ========================================================================== */
        .bento-section {
            padding: 100px 0;
            position: relative;
        }

        .section-header {
            text-align: center;
            max-width: 760px;
            margin: 0 auto 60px;
        }

        .section-badge {
            display: inline-block;
            font-family: var(--font-mono);
            font-size: 0.75rem;
            font-weight: 600;
            color: #60a5fa;
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.25);
            padding: 4px 12px;
            border-radius: 20px;
            margin-bottom: 16px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .section-title {
            font-size: clamp(2rem, 3.5vw, 2.6rem);
            font-weight: 800;
            letter-spacing: -0.02em;
            margin-bottom: 16px;
            line-height: 1.25;
        }

        .section-subtitle {
            font-size: 1.05rem;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        .bento-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 24px;
        }

        .bento-card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-lg);
            padding: 32px;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            backdrop-filter: blur(12px);
        }

        .bento-card:hover {
            border-color: var(--border-medium);
            background: var(--bg-card-hover);
            transform: translateY(-3px);
            box-shadow: var(--shadow-elevated);
        }

        .col-span-8 { grid-column: span 8; }
        .col-span-4 { grid-column: span 4; }
        .col-span-6 { grid-column: span 6; }
        .col-span-12 { grid-column: span 12; }

        .bento-icon-box {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid var(--border-subtle);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #60a5fa;
            margin-bottom: 20px;
        }

        .bento-card-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--text-primary);
            letter-spacing: -0.01em;
        }

        .bento-card-desc {
            font-size: 0.92rem;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .bento-visual-slot {
            background: #090e18;
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            padding: 16px;
            font-family: var(--font-mono);
            font-size: 0.78rem;
        }

        /* ==========================================================================
           ARCHITECTURE FLOW (ERP PIPELINE)
           ========================================================================== */
        .arch-section {
            padding: 80px 0;
            background: rgba(15, 22, 38, 0.5);
            border-top: 1px solid var(--border-subtle);
            border-bottom: 1px solid var(--border-subtle);
        }

        .flow-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            position: relative;
        }

        .flow-card {
            background: #0b111e;
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-md);
            padding: 24px 20px;
            position: relative;
        }

        .flow-step-num {
            font-family: var(--font-mono);
            font-size: 0.72rem;
            color: #60a5fa;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 12px;
        }

        .flow-card-title {
            font-size: 1.05rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .flow-card-desc {
            font-size: 0.85rem;
            color: var(--text-muted);
            line-height: 1.5;
        }

        /* ==========================================================================
           INTERACTIVE CALCULATOR
           ========================================================================== */
        .calc-section {
            padding: 100px 0;
        }

        .calc-box {
            background: linear-gradient(145deg, #101827, #0b101b);
            border: 1px solid var(--border-medium);
            border-radius: var(--radius-xl);
            padding: 44px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
            box-shadow: var(--shadow-elevated);
        }

        .slider-group {
            margin-bottom: 24px;
        }

        .slider-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .slider-val-badge {
            color: #60a5fa;
            font-family: var(--font-mono);
        }

        input[type=range] {
            width: 100%;
            height: 6px;
            background: #1e293b;
            border-radius: 4px;
            outline: none;
            -webkit-appearance: none;
        }

        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #3b82f6;
            cursor: pointer;
            box-shadow: 0 0 10px rgba(59, 130, 246, 0.8);
            border: 2px solid #ffffff;
        }

        .calc-result-card {
            background: #090d16;
            border: 1px solid var(--border-medium);
            border-radius: var(--radius-lg);
            padding: 30px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .calc-metric {
            border-bottom: 1px solid var(--border-subtle);
            padding-bottom: 14px;
        }
        .calc-metric:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .calc-metric-val {
            font-size: 2rem;
            font-weight: 800;
            color: #34d399;
            font-family: var(--font-mono);
        }

        .calc-metric-lbl {
            font-size: 0.82rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        /* ==========================================================================
           BLOG & INSIGHTS SECTION (Prepared for future blog integration)
           ========================================================================== */
        .blog-section {
            padding: 100px 0;
            background: rgba(13, 19, 32, 0.5);
            border-top: 1px solid var(--border-subtle);
        }

        .blog-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
        }

        .blog-card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-lg);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: all 0.25s ease;
        }

        .blog-card:hover {
            border-color: var(--border-medium);
            transform: translateY(-4px);
            box-shadow: var(--shadow-elevated);
        }

        .blog-card-header {
            padding: 24px 24px 16px;
        }

        .blog-tag {
            font-family: var(--font-mono);
            font-size: 0.7rem;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            background: rgba(99, 102, 241, 0.15);
            color: #818cf8;
            display: inline-block;
            margin-bottom: 12px;
        }

        .blog-card-title {
            font-size: 1.15rem;
            font-weight: 700;
            line-height: 1.4;
            color: var(--text-primary);
            margin-bottom: 10px;
        }

        .blog-card-title:hover {
            color: #60a5fa;
        }

        .blog-card-excerpt {
            font-size: 0.88rem;
            color: var(--text-secondary);
            line-height: 1.6;
            padding: 0 24px 20px;
            flex-grow: 1;
        }

        .blog-card-footer {
            padding: 16px 24px;
            background: rgba(0, 0, 0, 0.2);
            border-top: 1px solid rgba(255, 255, 255, 0.04);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        /* ==========================================================================
           FINAL CTA & FOOTER
           ========================================================================== */
        .cta-section {
            padding: 80px 0;
            position: relative;
        }

        .cta-card {
            background: radial-gradient(circle at 50% 0%, #1e293b, #0f172a);
            border: 1px solid var(--border-medium);
            border-radius: var(--radius-xl);
            padding: 60px 32px;
            text-align: center;
            position: relative;
            box-shadow: var(--shadow-elevated);
        }

        .cta-title {
            font-size: clamp(2rem, 3.5vw, 2.8rem);
            font-weight: 800;
            letter-spacing: -0.02em;
            margin-bottom: 16px;
        }

        .cta-subtitle {
            font-size: 1.1rem;
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto 36px;
        }

        /* Footer */
        .footer-main {
            background: #060910;
            border-top: 1px solid var(--border-subtle);
            padding: 60px 0 30px;
            font-size: 0.88rem;
            color: var(--text-muted);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 48px;
        }

        .footer-col-title {
            color: var(--text-primary);
            font-weight: 600;
            font-size: 0.92rem;
            margin-bottom: 16px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .footer-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .footer-links a:hover {
            color: var(--text-primary);
        }

        .footer-bottom {
            padding-top: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        /* Responsive Breakpoints */
        @media (max-width: 992px) {
            .hero-stats-grid { grid-template-columns: repeat(2, 1fr); }
            .col-span-8, .col-span-4, .col-span-6 { grid-column: span 12; }
            .flow-grid { grid-template-columns: repeat(2, 1fr); }
            .calc-box { grid-template-columns: 1fr; }
            .blog-grid { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 768px) {
            .nav-links, .nav-actions { display: none; }
            .mobile-toggle { display: block; }
            .flow-grid { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; }
            .hero-stats-grid { grid-template-columns: 1fr 1fr; gap: 8px; }
            .calc-box { padding: 24px; }
        }
    </style>
</head>

<body>

    <!-- Top Telemetry Strip -->
    <div class="top-telemetry-bar">
        <div class="container">
            <div class="telemetry-inner">
                <div class="telemetry-left">
                    <span><span class="status-dot-pulse"></span><strong>Vendio Core Engine v2.4</strong> — Sinkronisasi Multi-Channel Aktif</span>
                    <span style="color: var(--border-medium);">|</span>
                    <span class="font-mono" style="font-size: 0.72rem;"><i class="fa-solid fa-bolt" style="color: #fbbf24;"></i> Latensi Webhook: 142ms</span>
                </div>
                <div class="telemetry-right font-mono" style="font-size: 0.72rem;">
                    <span><i class="fa-solid fa-shield-halved" style="color: #34d399;"></i> RBAC Aauth Terproteksi</span>
                    <span><i class="fa-solid fa-server" style="color: #60a5fa;"></i> Uptime 99.98%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <nav class="navbar-main" id="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <a href="<?= site_url(); ?>" class="brand-logo">
                    <div class="brand-symbol">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <span>VENDIO<span class="brand-badge">OMNICHANNEL ERP</span></span>
                </a>

                <ul class="nav-links">
                    <li><a href="#modules" class="nav-link">Fitur ERP</a></li>
                    <li><a href="#channels" class="nav-link">Marketplace</a></li>
                    <li><a href="#architecture" class="nav-link">Arsitektur Data</a></li>
                    <li><a href="#calculator" class="nav-link">Kalkulator Efisiensi</a></li>
                    <li>
                        <a href="<?= site_url('blog'); ?>" class="nav-link">
                            Insights Blog
                            <span class="nav-badge-pill">Baru</span>
                        </a>
                    </li>
                </ul>

                <div class="nav-actions">
                    <?php if ($is_logged_in): ?>
                        <a href="<?= $admin_url; ?>" class="btn-nav-primary">
                            <i class="fa-solid fa-user-circle"></i> <?= _ent($user_name ?: 'Admin'); ?> &nbsp;→
                        </a>
                    <?php else: ?>
                        <a href="<?= site_url('administrator/login'); ?>" class="btn-nav-ghost">Masuk</a>
                        <a href="<?= site_url('administrator/login'); ?>" class="btn-nav-primary">
                            Mulai Sekarang &nbsp;→
                        </a>
                    <?php endif; ?>
                </div>

                <button class="mobile-toggle" id="mobileMenuBtn" aria-label="Toggle Menu">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <header class="hero-section">
        <div class="container">
            <div class="hero-badge-container">
                <span class="status-dot-pulse"></span>
                <span>Arsitektur Omnichannel Ritel Skala Enterprise</span>
                <span style="color: #60a5fa;">• Zero-Overselling Engine</span>
            </div>

            <h1 class="hero-title">
                Satu Sistem <span class="text-gradient">ERP Terpusat</span> untuk Seluruh Kanal Penjualan.
            </h1>

            <p class="hero-desc">
                Sinkronisasi katalog produk, orkestrasi ribuan pesanan per menit, kontrol multi-gudang, dan rekonsiliasi finansial TikTok Shop, Tokopedia, serta Shopee dalam satu dashboard terintegrasi.
            </p>

            <div class="hero-actions">
                <a href="<?= $admin_url; ?>" class="btn-hero-primary">
                    <i class="fa-solid fa-gauge-high"></i> <?= $admin_btn_text; ?>
                </a>
                <a href="#demo-preview" class="btn-hero-secondary">
                    <i class="fa-solid fa-play"></i> Lihat Simulasi Console
                </a>
            </div>

            <!-- Stats Bar -->
            <div class="hero-stats-grid">
                <div class="hero-stat-item">
                    <div class="hero-stat-value">&lt; 1.5s</div>
                    <div class="hero-stat-label">Latensi Sinkronisasi Stok</div>
                </div>
                <div class="hero-stat-item">
                    <div class="hero-stat-value">99.98%</div>
                    <div class="hero-stat-label">Tingkat Akurasi Order</div>
                </div>
                <div class="hero-stat-item">
                    <div class="hero-stat-value">0%</div>
                    <div class="hero-stat-label">Insiden Overselling</div>
                </div>
                <div class="hero-stat-item">
                    <div class="hero-stat-value">12x</div>
                    <div class="hero-stat-label">Lebih Cepat Rekonsiliasi</div>
                </div>
            </div>

            <!-- INTERACTIVE PRODUCT MOCKUP CONSOLE -->
            <div class="mockup-container" id="demo-preview">
                <div class="mockup-glow"></div>
                <div class="erp-mockup-frame">
                    <!-- Top Bar -->
                    <div class="mockup-top-bar">
                        <div class="mockup-dots">
                            <span class="mockup-dot dot-red"></span>
                            <span class="mockup-dot dot-yellow"></span>
                            <span class="mockup-dot dot-green"></span>
                        </div>
                        <div class="mockup-channel-indicators">
                            <div class="channel-pill">
                                <i class="fa-brands fa-tiktok" style="color: #ffffff;"></i> TikTok Shop: <strong style="color: #34d399;">LIVE</strong>
                            </div>
                            <div class="channel-pill">
                                <i class="fa-solid fa-bag-shopping" style="color: #03ac0e;"></i> Tokopedia: <strong style="color: #34d399;">CONNECTED</strong>
                            </div>
                            <div class="channel-pill" style="display: none;" id="pill-shopee">
                                <i class="fa-solid fa-store" style="color: #ee4d2d;"></i> Shopee Hub: <strong>ACTIVE</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Interactive Mockup Tabs -->
                    <div class="mockup-tabs-bar">
                        <button class="mockup-tab-btn active" onclick="switchMockupTab(event, 'tab-catalog')">
                            <i class="fa-solid fa-boxes-stacked"></i> 1. Katalog & Stok Sinkron
                        </button>
                        <button class="mockup-tab-btn" onclick="switchMockupTab(event, 'tab-orders')">
                            <i class="fa-solid fa-cart-flatbed"></i> 2. Orkestrasi Pesanan
                        </button>
                        <button class="mockup-tab-btn" onclick="switchMockupTab(event, 'tab-warehouse')">
                            <i class="fa-solid fa-warehouse"></i> 3. Multi-Gudang ERP
                        </button>
                        <button class="mockup-tab-btn" onclick="switchMockupTab(event, 'tab-finance')">
                            <i class="fa-solid fa-scale-balanced"></i> 4. Rekonsiliasi & Settlement
                        </button>
                    </div>

                    <!-- Mockup Tab Body Content -->
                    <div class="mockup-body">
                        <!-- Panel 1: Catalog -->
                        <div class="tab-panel active" id="tab-catalog">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                                <span style="font-weight: 600; font-size: 0.9rem; color: var(--text-primary);">
                                    <i class="fa-solid fa-arrows-rotate" style="color: #3b82f6;"></i> Matrix Multi-Channel Inventory Buffer
                                </span>
                                <span class="font-mono" style="font-size: 0.74rem; color: #10b981;">
                                    ● 1,420 SKU Terpetakan Sempurna
                                </span>
                            </div>
                            <table class="mockup-table">
                                <thead>
                                    <tr>
                                        <th>Master SKU</th>
                                        <th>Nama Produk</th>
                                        <th>Kanal Listing</th>
                                        <th>Total Stok</th>
                                        <th>Alokasi Gudang</th>
                                        <th>Status Sinkron</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="font-mono" style="color: #93c5fd;">APL-MBP-14-M3</td>
                                        <td style="font-weight: 600; color: #f8fafc;">MacBook Pro 14 M3 512GB Space Gray</td>
                                        <td>
                                            <span class="badge-status badge-sync"><i class="fa-brands fa-tiktok"></i> TikTok</span>
                                            <span class="badge-status badge-live"><i class="fa-solid fa-bag-shopping"></i> Tokopedia</span>
                                        </td>
                                        <td class="font-mono" style="font-weight: 600;">148 Unit</td>
                                        <td style="font-size: 0.78rem;">JKT-HUB (100) • SBY-01 (48)</td>
                                        <td><span class="badge-status badge-live">100% Synced</span></td>
                                    </tr>
                                    <tr>
                                        <td class="font-mono" style="color: #93c5fd;">SAM-S24U-256</td>
                                        <td style="font-weight: 600; color: #f8fafc;">Galaxy S24 Ultra Titanium Gray</td>
                                        <td>
                                            <span class="badge-status badge-sync"><i class="fa-brands fa-tiktok"></i> TikTok</span>
                                            <span class="badge-status badge-live"><i class="fa-solid fa-bag-shopping"></i> Tokopedia</span>
                                        </td>
                                        <td class="font-mono" style="font-weight: 600;">85 Unit</td>
                                        <td style="font-size: 0.78rem;">JKT-HUB (50) • BDG-02 (35)</td>
                                        <td><span class="badge-status badge-live">100% Synced</span></td>
                                    </tr>
                                    <tr>
                                        <td class="font-mono" style="color: #93c5fd;">LOG-MXM3S-GRY</td>
                                        <td style="font-weight: 600; color: #f8fafc;">Logitech MX Master 3S Wireless Mouse</td>
                                        <td>
                                            <span class="badge-status badge-sync"><i class="fa-brands fa-tiktok"></i> TikTok</span>
                                        </td>
                                        <td class="font-mono" style="font-weight: 600;">320 Unit</td>
                                        <td style="font-size: 0.78rem;">JKT-CENTRAL (320)</td>
                                        <td><span class="badge-status badge-live">100% Synced</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Panel 2: Orders -->
                        <div class="tab-panel" id="tab-orders">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                                <span style="font-weight: 600; font-size: 0.9rem; color: var(--text-primary);">
                                    <i class="fa-solid fa-bolt" style="color: #f59e0b;"></i> Live Stream Order Ingestion (Auto-AWB Dispatch)
                                </span>
                                <span class="font-mono" style="font-size: 0.74rem; color: #60a5fa;">
                                    ● 48 Pesanan Baru dalam 10 Menit Terakhir
                                </span>
                            </div>
                            <table class="mockup-table">
                                <thead>
                                    <tr>
                                        <th>Order ID Marketplace</th>
                                        <th>Platform</th>
                                        <th>Penerima</th>
                                        <th>Total Transaksi</th>
                                        <th>Kurir & No. Resi</th>
                                        <th>Status ERP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="font-mono">#5789230198421</td>
                                        <td><span class="badge-status badge-sync"><i class="fa-brands fa-tiktok"></i> TikTok</span></td>
                                        <td>Dimas Pratama (Surabaya)</td>
                                        <td class="font-mono" style="font-weight: 600;">Rp 28.499.000</td>
                                        <td class="font-mono" style="font-size: 0.76rem;">J&T Cargo • <span style="color:#60a5fa;">JT992810928</span></td>
                                        <td><span class="badge-status badge-live">Awaiting Collection</span></td>
                                    </tr>
                                    <tr>
                                        <td class="font-mono">#TKP-9920194881</td>
                                        <td><span class="badge-status badge-live"><i class="fa-solid fa-bag-shopping"></i> Tokopedia</span></td>
                                        <td>Siti Sarah (Jakarta Barat)</td>
                                        <td class="font-mono" style="font-weight: 600;">Rp 1.650.000</td>
                                        <td class="font-mono" style="font-size: 0.76rem;">SiCepat Reg • <span style="color:#60a5fa;">00481928410</span></td>
                                        <td><span class="badge-status badge-sync">Packing Verified</span></td>
                                    </tr>
                                    <tr>
                                        <td class="font-mono">#5789230198533</td>
                                        <td><span class="badge-status badge-sync"><i class="fa-brands fa-tiktok"></i> TikTok</span></td>
                                        <td>Budi Santoso (Medan)</td>
                                        <td class="font-mono" style="font-weight: 600;">Rp 5.200.000</td>
                                        <td class="font-mono" style="font-size: 0.76rem;">JNE Trucking • <span style="color:#60a5fa;">JNE88201941</span></td>
                                        <td><span class="badge-status badge-wait">Auto-Routing Warehouse</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Panel 3: Warehouse -->
                        <div class="tab-panel" id="tab-warehouse">
                            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 20px;">
                                <div style="background: #111827; padding: 18px; border-radius: 8px; border: 1px solid var(--border-subtle);">
                                    <div style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase;">Gudang Utama Cakung (JKT)</div>
                                    <div class="font-mono" style="font-size: 1.4rem; font-weight: 700; color: #f8fafc; margin: 6px 0;">8,420 Unit</div>
                                    <div style="font-size: 0.74rem; color: #10b981;">● Kapasitas Terpakai 68% • 12 Picker Aktif</div>
                                </div>
                                <div style="background: #111827; padding: 18px; border-radius: 8px; border: 1px solid var(--border-subtle);">
                                    <div style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase;">Hub Surabaya Rungkut (SBY)</div>
                                    <div class="font-mono" style="font-size: 1.4rem; font-weight: 700; color: #f8fafc; margin: 6px 0;">3,150 Unit</div>
                                    <div style="font-size: 0.74rem; color: #10b981;">● Kapasitas Terpakai 42% • 6 Picker Aktif</div>
                                </div>
                                <div style="background: #111827; padding: 18px; border-radius: 8px; border: 1px solid var(--border-subtle);">
                                    <div style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase;">Fulfillment Medan Amplas (MDN)</div>
                                    <div class="font-mono" style="font-size: 1.4rem; font-weight: 700; color: #f8fafc; margin: 6px 0;">1,890 Unit</div>
                                    <div style="font-size: 0.74rem; color: #fbbf24;">▲ Transfer Stok Masuk: +500 Unit</div>
                                </div>
                            </div>
                            <div class="bento-visual-slot">
                                <i class="fa-solid fa-circle-nodes" style="color: #60a5fa;"></i> <strong>Dynamic SLA Optimization:</strong> Pesanan dengan tujuan Jawa Timur otomatis dialihkan ke Hub Surabaya tanpa intervensi manual, menghemat ongkos kirim hingga 34% dan memangkas waktu kirim 1 hari kerja.
                            </div>
                        </div>

                        <!-- Panel 4: Finance -->
                        <div class="tab-panel" id="tab-finance">
                            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
                                <div>
                                    <div style="font-weight: 600; font-size: 0.9rem; margin-bottom: 12px; color: var(--text-primary);">
                                        Audit Rekonsiliasi Escrow & Potongan Fee Marketplace Otomatis
                                    </div>
                                    <table class="mockup-table">
                                        <thead>
                                            <tr>
                                                <th>Batch Payout</th>
                                                <th>Gross Sales</th>
                                                <th>Marketplace Admin & Tax</th>
                                                <th>Net Settlement Bank</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="font-mono">SETTL-TT-2026-0929</td>
                                                <td class="font-mono">Rp 142.500.000</td>
                                                <td class="font-mono" style="color: #f87171;">- Rp 11.400.000 (8%)</td>
                                                <td class="font-mono" style="font-weight: 700; color: #34d399;">Rp 131.100.000</td>
                                                <td><span class="badge-status badge-live">Verified BCA</span></td>
                                            </tr>
                                            <tr>
                                                <td class="font-mono">SETTL-TKP-2026-0928</td>
                                                <td class="font-mono">Rp 98.200.000</td>
                                                <td class="font-mono" style="color: #f87171;">- Rp 6.874.000 (7%)</td>
                                                <td class="font-mono" style="font-weight: 700; color: #34d399;">Rp 91.326.000</td>
                                                <td><span class="badge-status badge-live">Verified Mandiri</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div style="background: #111827; padding: 20px; border-radius: 8px; border: 1px solid var(--border-subtle); display: flex; flex-direction: column; justify-content: space-between;">
                                    <div>
                                        <div style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase;">Saldo Belum Cair (Unsettled Escrow)</div>
                                        <div class="font-mono" style="font-size: 1.6rem; font-weight: 800; color: #fbbf24; margin: 10px 0;">Rp 44.890.000</div>
                                        <div style="font-size: 0.78rem; color: var(--text-secondary); line-height: 1.4;">
                                            12 Pesanan dalam proses pengiriman kurir. Estimasi pencairan: 24 - 48 jam setelah paket diterima customer.
                                        </div>
                                    </div>
                                    <div style="margin-top: 16px; font-size: 0.75rem; color: #10b981; font-family: var(--font-mono);">
                                        <i class="fa-solid fa-check-double"></i> 0 Selisih Pembukuan Akuntansi
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- INTEGRATED MARKETPLACES STRIP -->
    <section class="ecosystem-section" id="channels">
        <div class="container">
            <div class="section-label">Terhubung Langsung Melalui Official Open API & Webhook Engine</div>
            <div class="ecosystem-grid">
                <div class="ecosystem-item">
                    <i class="fa-brands fa-tiktok" style="font-size: 1.2rem;"></i> TikTok Shop
                </div>
                <div class="ecosystem-item">
                    <i class="fa-solid fa-bag-shopping" style="color: #03ac0e; font-size: 1.2rem;"></i> Tokopedia
                </div>
                <div class="ecosystem-item">
                    <i class="fa-solid fa-store" style="color: #ee4d2d; font-size: 1.2rem;"></i> Shopee Sync
                </div>
                <div class="ecosystem-item">
                    <i class="fa-solid fa-box-open" style="color: #002f6c; font-size: 1.2rem;"></i> Lazada Partner
                </div>
                <div class="ecosystem-item">
                    <i class="fa-solid fa-truck-fast" style="color: #f59e0b; font-size: 1.2rem;"></i> Ekspedisi 3PL (J&T, SiCepat, JNE)
                </div>
                <div class="ecosystem-item">
                    <i class="fa-solid fa-calculator" style="color: #6366f1; font-size: 1.2rem;"></i> Integrasi Jurnal & Accurate
                </div>
            </div>
        </div>
    </section>

    <!-- CORE ERP CAPABILITIES (BENTO GRID) -->
    <section class="bento-section" id="modules">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">MODUL ERP OMNICHANNEL</span>
                <h2 class="section-title">Semua Kebutuhan Bisnis Ritel Modern dalam Satu Ekosistem.</h2>
                <p class="section-subtitle">
                    Kombinasi kecepatan sinkronisasi e-commerce dengan ketahanan sistem ERP korporat untuk meminimalisasi kesalahan manusia dan efisiensi operasional skala besar.
                </p>
            </div>

            <div class="bento-grid">
                <!-- Card 1: Master Catalog -->
                <div class="bento-card col-span-8">
                    <div>
                        <div class="bento-icon-box">
                            <i class="fa-solid fa-cubes-stacked"></i>
                        </div>
                        <h3 class="bento-card-title">Unified Master Catalog & Real-Time Stock Engine</h3>
                        <p class="bento-card-desc">
                            Cukup kelola satu master SKU produk di Vendio. Sistem secara otomatis memetakan judul, varian warna/ukuran, harga promosi, dan kuota stok ke seluruh toko TikTok Shop dan Tokopedia Anda dalam hitungan detik.
                        </p>
                    </div>
                    <div class="bento-visual-slot">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <span style="color: #60a5fa;"><i class="fa-solid fa-lock"></i> Auto-Stock Locking Mechanism</span>
                            <span class="badge-status badge-live">Zero Latency</span>
                        </div>
                        <p style="color: var(--text-muted); font-size: 0.74rem;">
                            Saat 1 unit terjual di sesi Live TikTok, kuota stok di Tokopedia langsung dikurangi seketika untuk mencegah pesanan ganda saat kuota habis.
                        </p>
                    </div>
                </div>

                <!-- Card 2: Batch Fulfillment -->
                <div class="bento-card col-span-4">
                    <div>
                        <div class="bento-icon-box">
                            <i class="fa-solid fa-barcode"></i>
                        </div>
                        <h3 class="bento-card-title">Fulfillment Cepat & Cetak Resi Massal</h3>
                        <p class="bento-card-desc">
                            Cetak ratusan label pengiriman termal dan lembar pengambilan (picking list) per kategori hanya dengan satu klik.
                        </p>
                    </div>
                    <div class="bento-visual-slot">
                        <div style="color: #34d399; margin-bottom: 4px;">✔ Verifikasi Barcode Scanner</div>
                        <div style="color: var(--text-muted); font-size: 0.72rem;">Mencegah salah kirim varian barang hingga 99.9%</div>
                    </div>
                </div>

                <!-- Card 3: Multi-Gudang -->
                <div class="bento-card col-span-4">
                    <div>
                        <div class="bento-icon-box">
                            <i class="fa-solid fa-network-wired"></i>
                        </div>
                        <h3 class="bento-card-title">Manajemen Multi-Lokasi Gudang</h3>
                        <p class="bento-card-desc">
                            Distribusi stok ke gudang regional. Alokasi pesanan otomatis memilih gudang terdekat dengan pembeli guna memangkas ongkos kirim dan SLA pengiriman.
                        </p>
                    </div>
                    <div class="bento-visual-slot">
                        <span style="color: #fbbf24;">Transfer Order (TO) Terintegrasi</span>
                    </div>
                </div>

                <!-- Card 4: Financial Reconciliation -->
                <div class="bento-card col-span-8">
                    <div>
                        <div class="bento-icon-box">
                            <i class="fa-solid fa-coins"></i>
                        </div>
                        <h3 class="bento-card-title">Rekonsiliasi Keuangan & Settlement Otomatis</h3>
                        <p class="bento-card-desc">
                            Audit otomatis seluruh potongan komisi marketplace, voucher platform, biaya logistik, hingga retur. Vendio mencocokkan setiap pesanan dengan mutasi bank sebenarnya tanpa lembar Excel manual.
                        </p>
                    </div>
                    <div class="bento-visual-slot">
                        <div style="display: flex; justify-content: space-between;">
                            <span>Audit HPP (COGS) & Laba Bersih per Order Real-Time</span>
                            <span style="color: #34d399;">Akuntabel 100%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ARCHITECTURE / WORKFLOW SECTION -->
    <section class="arch-section" id="architecture">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">ALUR DATA & ARSITEKTUR</span>
                <h2 class="section-title">Bagaimana Data Mengalir di Dalam Vendio ERP</h2>
                <p class="section-subtitle">
                    Dari saat pesanan masuk di marketplace hingga barang sampai di tangan pelanggan dan tercatat di buku kas.
                </p>
            </div>

            <div class="flow-grid">
                <div class="flow-card">
                    <div class="flow-step-num">Langkah 01</div>
                    <h4 class="flow-card-title">Omnichannel Ingestion</h4>
                    <p class="flow-card-desc">
                        Webhook menangkap pesanan baru & event pembayaran dari TikTok Shop dan Tokopedia secara real-time.
                    </p>
                </div>
                <div class="flow-card">
                    <div class="flow-step-num">Langkah 02</div>
                    <h4 class="flow-card-title">Inventory Allocation</h4>
                    <p class="flow-card-desc">
                        Sistem mengunci stok, memotong kuota channel lain, dan menentukan gudang terdekat untuk pengiriman.
                    </p>
                </div>
                <div class="flow-card">
                    <div class="flow-step-num">Langkah 03</div>
                    <h4 class="flow-card-title">Warehouse Execution</h4>
                    <p class="flow-card-desc">
                        Tim gudang mencetak resi batch, scan barcode produk, dan melakukan handover ke kurir ekspedisi.
                    </p>
                </div>
                <div class="flow-card">
                    <div class="flow-step-num">Langkah 04</div>
                    <h4 class="flow-card-title">Settlement Audit</h4>
                    <p class="flow-card-desc">
                        Dana dicairkan marketplace ke rekening bank dan dicocokkan otomatis dengan laporan laba rugi.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- INTERACTIVE ROI / EFFICIENCY CALCULATOR -->
    <section class="calc-section" id="calculator">
        <div class="container">
            <div class="calc-box">
                <div>
                    <span class="section-badge">SIMULASI EFISIENSI OPERASIONAL</span>
                    <h3 style="font-size: 2rem; font-weight: 800; margin-bottom: 14px; letter-spacing: -0.02em;">
                        Hitung Waktu & Biaya yang Dihemat dengan Vendio
                    </h3>
                    <p style="color: var(--text-secondary); margin-bottom: 32px; font-size: 0.95rem;">
                        Sesuaikan volume transaksi harian dan jumlah channel untuk melihat proyeksi peningkatan efisiensi tim Anda.
                    </p>

                    <div class="slider-group">
                        <div class="slider-header">
                            <span>Pesanan Harian (Rata-rata)</span>
                            <span class="slider-val-badge" id="lbl-orders">500 pesanan/hari</span>
                        </div>
                        <input type="range" id="input-orders" min="50" max="5000" step="50" value="500" oninput="calculateSavings()">
                    </div>

                    <div class="slider-group">
                        <div class="slider-header">
                            <span>Jumlah Channel Toko Aktif</span>
                            <span class="slider-val-badge" id="lbl-channels">3 Channel</span>
                        </div>
                        <input type="range" id="input-channels" min="1" max="10" step="1" value="3" oninput="calculateSavings()">
                    </div>
                </div>

                <div class="calc-result-card">
                    <div class="calc-metric">
                        <div class="calc-metric-val" id="calc-hours">120 Jam</div>
                        <div class="calc-metric-lbl">Waktu Operasional Manual Dihemat / Bulan</div>
                    </div>
                    <div class="calc-metric">
                        <div class="calc-metric-val" id="calc-cancellation">0 Kasus</div>
                        <div class="calc-metric-lbl">Potensi Pembatalan Akibat Stok Kosong</div>
                    </div>
                    <div class="calc-metric">
                        <div class="calc-metric-val" id="calc-roi">3.8x</div>
                        <div class="calc-metric-lbl">Percepatan Pemrosesan Pesanan ke Kurir</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- BLOG & TECH INSIGHTS (Prepared for future blog expansion) -->
    <section class="blog-section" id="insights">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 48px; flex-wrap: wrap; gap: 20px;">
                <div>
                    <span class="section-badge">VENDIO TECH INSIGHTS</span>
                    <h2 class="section-title" style="margin-bottom: 8px;">Artikel & Best Practices Ritel</h2>
                    <p class="section-subtitle">Strategi scale-up e-commerce, arsitektur multi-channel, dan manajemen rantai pasok.</p>
                </div>
                <div>
                    <a href="<?= site_url('blog'); ?>" class="btn-hero-secondary" style="padding: 10px 20px; font-size: 0.9rem;">
                        Kunjungi Halaman Blog <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="blog-grid">
                <!-- Article 1 -->
                <article class="blog-card">
                    <div class="blog-card-header">
                        <span class="blog-tag">MANAJEMEN STOK</span>
                        <h3 class="blog-card-title">
                            <a href="<?= site_url('blog'); ?>">Mencegah Bencana Overselling saat Mega Campaign TikTok Shop & Tokopedia</a>
                        </h3>
                    </div>
                    <p class="blog-card-excerpt">
                        Pelajari bagaimana sistem buffer inventory dinamis dan asynchronous lock mechanism melindungi reputasi toko dari pinalti pembatalan pesanan otomatis.
                    </p>
                    <div class="blog-card-footer">
                        <span><i class="fa-regular fa-clock"></i> 5 menit baca</span>
                        <span>Tim Engineering Vendio</span>
                    </div>
                </article>

                <!-- Article 2 -->
                <article class="blog-card">
                    <div class="blog-card-header">
                        <span class="blog-tag" style="background: rgba(16, 185, 129, 0.15); color: #34d399;">KEUANGAN & AUDIT</span>
                        <h3 class="blog-card-title">
                            <a href="<?= site_url('blog'); ?>">Membedah Rekonsiliasi Finansial Marketplace: Mengapa Payout Sering Selisih?</a>
                        </h3>
                    </div>
                    <p class="blog-card-excerpt">
                        Panduan praktis mengurai komponen potongan komisi platform, subsidi voucher ongkir, dan retur COD agar laporan laba rugi bulanan akurat 100%.
                    </p>
                    <div class="blog-card-footer">
                        <span><i class="fa-regular fa-clock"></i> 7 menit baca</span>
                        <span>Finance Research Group</span>
                    </div>
                </article>

                <!-- Article 3 -->
                <article class="blog-card">
                    <div class="blog-card-header">
                        <span class="blog-tag" style="background: rgba(245, 158, 11, 0.15); color: #fbbf24;">GUDANG & LOGISTIK</span>
                        <h3 class="blog-card-title">
                            <a href="<?= site_url('blog'); ?>">Arsitektur Multi-Warehouse: Cara Menekan Biaya Logistik Hingga 28%</a>
                        </h3>
                    </div>
                    <p class="blog-card-excerpt">
                        Strategi cerdas membagi inventori ke beberapa hub logistik lokal di Indonesia untuk mempercepat waktu sampai ke pembeli dalam kurun kurang dari 24 jam.
                    </p>
                    <div class="blog-card-footer">
                        <span><i class="fa-regular fa-clock"></i> 6 menit baca</span>
                        <span>Supply Chain Lead</span>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- FINAL CALL TO ACTION -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-card">
                <h2 class="cta-title">Siap Mengotomasi Operasional Omnichannel Anda?</h2>
                <p class="cta-subtitle">
                    Tinggalkan input manual satu per satu. Kelola seluruh katalog, pesanan, dan keuangan toko Anda dalam satu sistem terintegrasi.
                </p>
                <div style="display: flex; justify-content: center; gap: 16px; flex-wrap: wrap;">
                    <a href="<?= $admin_url; ?>" class="btn-hero-primary" style="font-size: 1.05rem; padding: 15px 34px;">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i> <?= $admin_btn_text; ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer-main">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <div class="brand-logo" style="margin-bottom: 16px;">
                        <div class="brand-symbol" style="width: 32px; height: 32px; font-size: 0.9rem;">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>
                        <span>VENDIO<span class="brand-badge">ERP</span></span>
                    </div>
                    <p style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.6; max-width: 320px; margin-bottom: 20px;">
                        Platform ERP dan orkestrasi omnichannel enterprise untuk seller ritel, brand distributor, dan pelaku e-commerce skala bertumbuh di Indonesia.
                    </p>
                    <div class="font-mono" style="font-size: 0.76rem; color: #34d399;">
                        ● All Systems Operational • v2.4.0
                    </div>
                </div>

                <div>
                    <h5 class="footer-col-title">Modul ERP</h5>
                    <ul class="footer-links">
                        <li><a href="#modules">Sinkronisasi Katalog</a></li>
                        <li><a href="#modules">Orkestrasi Pesanan</a></li>
                        <li><a href="#modules">Multi-Gudang (WMS)</a></li>
                        <li><a href="#modules">Rekonsiliasi Finansial</a></li>
                        <li><a href="#modules">Audit & Reporting</a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="footer-col-title">Kanal Integrasi</h5>
                    <ul class="footer-links">
                        <li><a href="#channels">TikTok Shop Open API</a></li>
                        <li><a href="#channels">Tokopedia Merchant Hub</a></li>
                        <li><a href="#channels">Shopee Open Platform</a></li>
                        <li><a href="#channels">Integrasi J&T & SiCepat</a></li>
                        <li><a href="#channels">Accurate & Jurnal ERP</a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="footer-col-title">Perusahaan & Blog</h5>
                    <ul class="footer-links">
                        <li><a href="<?= site_url('blog'); ?>">Vendio Tech Insights</a></li>
                        <li><a href="<?= site_url('blog'); ?>">Arsip Artikel Blog</a></li>
                        <li><a href="<?= $admin_url; ?>">Portal Login Admin</a></li>
                        <li><a href="#">Dokumentasi API</a></li>
                        <li><a href="#">Privasi & Keamanan Data</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <div>
                    &copy; <?= date('Y'); ?> Vendio Omnichannel Platform. Hak Cipta Dilindungi Undang-Undang.
                </div>
                <div class="font-mono" style="font-size: 0.78rem;">
                    Dibangun dengan arsitektur micro-services aman dan scalable.
                </div>
            </div>
        </div>
    </footer>

    <!-- INTERACTIVE SCRIPTS -->
    <script>
        // Tab Switcher in Interactive Mockup
        function switchMockupTab(event, tabId) {
            const tabs = document.querySelectorAll('.mockup-tab-btn');
            const panels = document.querySelectorAll('.tab-panel');

            tabs.forEach(tab => tab.classList.remove('active'));
            panels.forEach(panel => panel.classList.remove('active'));

            event.currentTarget.classList.add('active');
            const activePanel = document.getElementById(tabId);
            if (activePanel) {
                activePanel.classList.add('active');
            }
        }

        // Efficiency Calculator
        function calculateSavings() {
            const orders = parseInt(document.getElementById('input-orders').value) || 500;
            const channels = parseInt(document.getElementById('input-channels').value) || 3;

            document.getElementById('lbl-orders').innerText = orders.toLocaleString('id-ID') + ' pesanan/hari';
            document.getElementById('lbl-channels').innerText = channels + ' Channel';

            // Calculations
            // Base manual processing time: 1.5 minutes per order across multiple channels
            const hoursSavedPerMonth = Math.round((orders * 1.8 * channels * 30) / 60 / 6);
            document.getElementById('calc-hours').innerText = hoursSavedPerMonth.toLocaleString('id-ID') + ' Jam';

            // Potential cancellation prevention
            const potentialCancellations = Math.round(orders * 0.04 * 30);
            document.getElementById('calc-cancellation').innerText = '0 Kasus (' + potentialCancellations.toLocaleString('id-ID') + ' dicegah)';

            // Speed multiplier
            const speedMultiplier = (channels >= 4) ? '4.5x' : '3.8x';
            document.getElementById('calc-roi').innerText = speedMultiplier;
        }

        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', function() {
                const navLinks = document.querySelector('.nav-links');
                if (navLinks.style.display === 'flex') {
                    navLinks.style.display = 'none';
                } else {
                    navLinks.style.display = 'flex';
                    navLinks.style.flexDirection = 'column';
                    navLinks.style.position = 'absolute';
                    navLinks.style.top = '100%';
                    navLinks.style.left = '0';
                    navLinks.style.width = '100%';
                    navLinks.style.background = '#090d16';
                    navLinks.style.padding = '20px';
                    navLinks.style.borderBottom = '1px solid rgba(255,255,255,0.1)';
                }
            });
        }
    </script>
</body>
</html>