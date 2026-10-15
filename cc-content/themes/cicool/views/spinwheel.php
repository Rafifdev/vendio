<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$is_logged_in = function_exists('app') && isset(app()->aauth) && app()->aauth->is_loggedin();
$user_name = $is_logged_in ? get_user_data('full_name') : 'Mitra Vendio';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Vendio Lucky Wheel | Hadiah &amp; Reward Eksklusif Mitra</title>
    <meta name="description" content="Putar roda keberuntungan Vendio Lucky Wheel dan raih berbagai reward eksklusif untuk akselerasi bisnis omnichannel Anda.">
    <meta name="robots" content="noindex, nofollow">

    <!-- Google Fonts: Plus Jakarta Sans & Poppins (Matching Landing Page) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Vendio Brand Typography (Impact BC & Vladivostok) -->
    <link rel="stylesheet" href="<?= BASE_ASSET; ?>fonts/vendio-brand-fonts.css">

    <style>
        /* ==========================================================================
           VENDIO BRAND PALETTE (WARM CREAM, SAND & OLIVE SAGE)
           Matched with home.php / landing page design tokens
           ========================================================================== */
        :root {
            --bg-body: #f7f2eb;
            --bg-alt: #f7f2eb;
            --bg-cream: #f7f2eb;
            --bg-sand: #eae2d6;
            --bg-card: #ffffff;
            --bg-card-hover: #faf6f0;
            
            --primary-purple: #8b9a6e;
            --primary-purple-hover: #77855b;
            --primary-gradient: linear-gradient(135deg, #8b9a6e 0%, #5d6e42 100%);
            --primary-soft-gradient: linear-gradient(135deg, rgba(139, 154, 110, 0.12) 0%, rgba(234, 226, 214, 0.45) 100%);
            
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
            --shadow-card: 0 14px 38px -5px rgba(35, 43, 30, 0.07), 0 4px 14px -2px rgba(139, 154, 110, 0.04);
            
            --radius-md: 14px;
            --radius-lg: 20px;
            --radius-xl: 28px;

            --font-main: 'Plus Jakarta Sans', sans-serif;
            --font-heading: 'Poppins', sans-serif;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-main);
            background-color: var(--bg-body);
            color: var(--text-body);
            min-height: 100vh;
            overflow-x: hidden;
            background-image: 
                radial-gradient(circle at 50% 0%, rgba(139, 154, 110, 0.14) 0%, transparent 50%),
                radial-gradient(circle at 85% 30%, rgba(234, 226, 214, 0.6) 0%, transparent 45%),
                radial-gradient(circle at 15% 70%, rgba(217, 155, 67, 0.08) 0%, transparent 40%),
                linear-gradient(180deg, #ffffff 0%, #f7f2eb 40%, #f3eee6 100%);
            background-attachment: fixed;
            position: relative;
        }

        /* Clean Background (No busy dots) */
        .relative-container {
            position: relative;
            z-index: 1;
        }

        /* ==========================================================================
           NAVBAR (Vendio Light Glassmorphism)
           ========================================================================== */
        .spin-nav {
            padding: 14px 24px;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border-light);
            box-shadow: 0 4px 20px -2px rgba(35, 43, 30, 0.05);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .spin-nav-container {
            max-width: 1280px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: inherit;
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

        .event-tag {
            background: rgba(139, 154, 110, 0.14);
            border: 1px solid rgba(139, 154, 110, 0.35);
            color: var(--primary-purple-hover);
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            padding: 4px 10px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .event-tag-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--primary-purple);
            box-shadow: 0 0 8px var(--primary-purple);
            animation: pulseDot 1.8s infinite;
        }

        @keyframes pulseDot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(1.3); }
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-audio-toggle {
            background: #ffffff;
            border: 1px solid var(--border-light);
            color: var(--text-title);
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.95rem;
            box-shadow: 0 2px 6px rgba(35, 43, 30, 0.04);
        }

        .btn-audio-toggle:hover {
            background: var(--bg-alt);
            border-color: var(--primary-purple);
            transform: scale(1.04);
        }

        .spins-chip {
            background: var(--primary-gradient);
            border: 1px solid rgba(139, 154, 110, 0.4);
            padding: 6px 14px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 700;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 16px -2px rgba(139, 154, 110, 0.35);
        }

        .spins-count-badge {
            background: #ffffff;
            color: var(--text-title);
            font-weight: 900;
            border-radius: 6px;
            padding: 2px 7px;
            font-size: 0.82rem;
            line-height: 1.2;
        }

        /* ==========================================================================
           MAIN ARENA & HERO (Clean Layout)
           ========================================================================== */
        .main-arena {
            max-width: 1280px;
            margin: 0 auto;
            padding: 44px 24px 64px 24px;
        }

        .spin-hero-header {
            text-align: center;
            max-width: 760px;
            margin: 0 auto 36px auto;
        }

        .spin-main-title {
            font-family: var(--font-heading);
            font-size: 2.6rem;
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -0.5px;
            margin-bottom: 12px;
            color: var(--text-title);
        }

        .spin-main-title span {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .spin-main-desc {
            font-size: 1.02rem;
            color: var(--text-body);
            line-height: 1.6;
        }

        /* 2-Column Grid */
        .arena-grid {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 32px;
            align-items: start;
        }

        @media (max-width: 992px) {
            .arena-grid {
                grid-template-columns: 1fr;
                gap: 36px;
            }
            .spin-main-title {
                font-size: 2rem;
            }
        }

        /* ==========================================================================
           WHEEL STAGE CARD (WHITE CARD WITH WARM SHADOW)
           ========================================================================== */
        .wheel-stage-card {
            background: var(--bg-card);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-xl);
            padding: 36px 24px;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            box-shadow: var(--shadow-card);
            overflow: hidden;
        }

        .wheel-stage-card::before {
            content: '';
            position: absolute;
            top: -100px;
            left: 50%;
            transform: translateX(-50%);
            width: 320px;
            height: 320px;
            background: radial-gradient(circle, rgba(139, 154, 110, 0.16) 0%, transparent 70%);
            pointer-events: none;
            filter: blur(36px);
            z-index: 0;
        }

        /* The Wheel Apparatus (Keep wheel size and placement intact) */
        .wheel-apparatus {
            position: relative;
            width: 440px;
            height: 440px;
            margin: 16px 0 24px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            user-select: none;
        }

        @media (max-width: 520px) {
            .wheel-apparatus {
                width: 330px;
                height: 330px;
            }
        }

        /* Outer Glow Rim framing the intact colorful wheel */
        .wheel-outer-rim {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 12px solid #232b1e;
            box-shadow: 
                0 0 0 3px rgba(139, 154, 110, 0.45),
                0 14px 40px rgba(35, 43, 30, 0.2),
                inset 0 0 16px rgba(0, 0, 0, 0.6);
            pointer-events: none;
            z-index: 2;
        }

        .led-lights-ring {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            pointer-events: none;
            z-index: 3;
        }

        .led-dot {
            position: absolute;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #FDE047;
            box-shadow: 0 0 8px #FDE047;
            transform: translate(-50%, -50%);
            transition: all 0.3s ease;
        }

        .led-dot.glow-alt {
            background: #06B6D4;
            box-shadow: 0 0 10px #06B6D4;
        }

        /* Wheel Canvas (Intact) */
        #wheelCanvas {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            cursor: pointer;
            transition: transform 0.05s ease-out;
            z-index: 1;
        }

        /* Pointer / Stopper Arrow (Intact) */
        .wheel-pointer-wrap {
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
            pointer-events: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            filter: drop-shadow(0 6px 12px rgba(35, 43, 30, 0.35));
        }

        .wheel-pointer {
            width: 38px;
            height: 48px;
            background: linear-gradient(180deg, #FDE047 0%, #D97706 70%, #78350F 100%);
            clip-path: polygon(50% 100%, 0 0, 100% 0);
            border-radius: 4px;
            position: relative;
            transform-origin: 50% 0%;
            transition: transform 0.08s ease;
        }

        .wheel-pointer.is-ticking {
            transform: rotate(-14deg);
        }

        .wheel-pointer-pin {
            position: absolute;
            top: 4px;
            left: 50%;
            transform: translateX(-50%);
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #FFFFFF;
            box-shadow: 0 0 8px rgba(255, 255, 255, 0.9);
        }

        /* Center Hub Button (Intact) */
        .wheel-center-hub {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 96px;
            height: 96px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FDE047 0%, #F59E0B 50%, #B45309 100%);
            box-shadow: 
                0 0 0 6px #232b1e,
                0 0 0 10px rgba(245, 158, 11, 0.5),
                0 8px 24px rgba(0, 0, 0, 0.4);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 5;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            user-select: none;
            border: none;
            outline: none;
        }

        .wheel-center-hub:hover:not(:disabled) {
            transform: translate(-50%, -50%) scale(1.06);
            box-shadow: 
                0 0 0 6px #232b1e,
                0 0 0 12px rgba(245, 158, 11, 0.85),
                0 0 30px rgba(253, 224, 71, 0.75),
                0 12px 32px rgba(245, 158, 11, 0.6);
        }

        .wheel-center-hub:active:not(:disabled) {
            transform: translate(-50%, -50%) scale(0.96);
        }

        .wheel-center-hub:disabled {
            filter: grayscale(0.5);
            cursor: not-allowed;
            opacity: 0.85;
        }

        .hub-text-spin {
            font-family: var(--font-heading);
            font-weight: 900;
            font-size: 1.18rem;
            color: #1A0E00;
            letter-spacing: 1px;
            line-height: 1;
        }

        .hub-subtext {
            font-size: 0.62rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #78350F;
            margin-top: 3px;
        }

        .pulse-ring {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 110px;
            height: 110px;
            border-radius: 50%;
            border: 2px solid rgba(245, 158, 11, 0.7);
            animation: pulseRing 2s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
            pointer-events: none;
            z-index: 4;
        }

        @keyframes pulseRing {
            0% { transform: translate(-50%, -50%) scale(0.9); opacity: 0.8; }
            100% { transform: translate(-50%, -50%) scale(1.5); opacity: 0; }
        }

        /* Quick Controls below wheel */
        .stage-quick-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            justify-content: center;
            margin-top: 10px;
            flex-wrap: wrap;
        }

        .btn-stage-action {
            background: #ffffff;
            border: 1px solid var(--border-light);
            color: var(--text-title);
            padding: 10px 18px;
            border-radius: var(--radius-md);
            font-size: 0.84rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(35, 43, 30, 0.04);
        }

        .btn-stage-action:hover {
            background: var(--bg-alt);
            border-color: var(--primary-purple);
            color: var(--primary-purple-hover);
        }

        .btn-stage-action.btn-accent {
            background: var(--primary-gradient);
            border-color: transparent;
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(139, 154, 110, 0.25);
        }

        .btn-stage-action.btn-accent:hover {
            opacity: 0.94;
            transform: translateY(-2px);
            color: #ffffff;
        }

        /* ==========================================================================
           RIGHT DASHBOARD COLUMN
           ========================================================================== */
        .spin-dashboard {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .dash-card {
            background: var(--bg-card);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-xl);
            padding: 22px 24px;
            box-shadow: var(--shadow-card);
        }

        .dash-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border-light);
        }

        .dash-card-title {
            font-family: var(--font-heading);
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-title);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dash-card-title i {
            color: var(--primary-purple);
        }

        /* Status & User Card */
        .status-metric-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .metric-box {
            background: var(--bg-alt);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-md);
            padding: 14px;
            text-align: center;
        }

        .metric-label {
            font-size: 0.74rem;
            color: var(--text-muted);
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .metric-value {
            font-family: var(--font-heading);
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-title);
        }

        .metric-value.highlight-gold {
            color: var(--primary-purple);
        }

        .metric-value.highlight-emerald {
            color: var(--accent-blue);
        }

        /* Prize Catalog Showcase */
        .prize-catalog-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            max-height: 290px;
            overflow-y: auto;
            padding-right: 4px;
        }

        .prize-catalog-grid::-webkit-scrollbar {
            width: 5px;
        }
        .prize-catalog-grid::-webkit-scrollbar-thumb {
            background: #d5cbbf;
            border-radius: 4px;
        }

        .prize-item-chip {
            background: #fdfbf9;
            border: 1px solid var(--border-light);
            border-radius: 12px;
            padding: 10px 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s ease;
            position: relative;
        }

        .prize-item-chip:hover {
            background: var(--bg-alt);
            border-color: var(--primary-purple);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(35, 43, 30, 0.05);
        }

        .prize-chip-icon {
            font-size: 1.3rem;
            line-height: 1;
            flex-shrink: 0;
        }

        .prize-chip-info {
            min-width: 0;
            flex: 1;
        }

        .prize-chip-name {
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--text-title);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .prize-chip-tier {
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .tier-legendary { color: #d99b43; }
        .tier-epic { color: #5d6e42; }
        .tier-rare { color: #8b9a6e; }
        .tier-special { color: #c48a5e; }

        /* Session Win History */
        .history-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
            max-height: 180px;
            overflow-y: auto;
            padding-right: 4px;
        }

        .history-list::-webkit-scrollbar {
            width: 4px;
        }
        .history-list::-webkit-scrollbar-thumb {
            background: #d5cbbf;
            border-radius: 4px;
        }

        .history-item {
            background: var(--bg-alt);
            border: 1px solid var(--border-light);
            border-radius: 10px;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.8rem;
        }

        .history-item-left {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .history-item-name {
            font-weight: 700;
            color: var(--text-title);
        }

        .history-item-code {
            font-family: monospace;
            background: rgba(139, 154, 110, 0.15);
            color: var(--primary-purple-hover);
            border: 1px solid rgba(139, 154, 110, 0.35);
            padding: 2px 7px;
            border-radius: 4px;
            font-size: 0.74rem;
            font-weight: 700;
            cursor: pointer;
        }

        .history-empty {
            text-align: center;
            padding: 24px 12px;
            color: var(--text-muted);
            font-size: 0.84rem;
        }

        /* ==========================================================================
           DUAL-LAYER CONFETTI & CELEBRATION WINNER MODAL
           The modal sits BETWEEN the back plane (blur 1.5px) and front plane
           ========================================================================== */
        .scrim {
            position: fixed;
            inset: 0;
            background: rgba(20, 10, 50, 0.58);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 90;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .scrim.is-active {
            opacity: 1;
            pointer-events: auto;
        }

        .layer {
            position: fixed;
            inset: 0;
            width: 100vw;
            height: 100vh;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.25s ease;
        }
        .layer.is-active {
            opacity: 1;
        }

        .confetti-back-layer {
            z-index: 95;
            filter: blur(1.5px);
            -webkit-filter: blur(1.5px);
        }

        .win-modal-wrapper {
            position: fixed;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 100;
            pointer-events: none;
            padding: 20px;
            opacity: 0;
            transition: opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .win-modal-wrapper.is-active {
            opacity: 1;
            pointer-events: auto;
        }

        .win-modal-card {
            background: #ffffff;
            border: 2px solid var(--border-light);
            border-radius: var(--radius-xl);
            width: 100%;
            max-width: 480px;
            padding: 38px 32px;
            text-align: center;
            position: relative;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.35);
            transform: scale(0.9) translateY(24px);
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            pointer-events: auto;
        }
        .win-modal-wrapper.is-active .win-modal-card {
            transform: scale(1) translateY(0);
        }

        .confetti-front-layer {
            z-index: 105;
        }

        .win-modal-icon-wrap {
            width: 92px;
            height: 92px;
            border-radius: 50%;
            margin: 0 auto 16px auto;
            background: #f0ebe2;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 18px rgba(35, 43, 30, 0.08);
            animation: bounceWin 2.5s infinite ease-in-out;
        }

        .win-modal-icon-box {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.65rem;
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
        }

        @keyframes bounceWin {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        .win-modal-badge {
            background: rgba(139, 154, 110, 0.14);
            border: 1px solid rgba(139, 154, 110, 0.4);
            color: var(--primary-purple-hover);
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 4px 12px;
            border-radius: 999px;
            display: inline-block;
            margin-bottom: 8px;
        }

        .win-modal-title {
            font-family: var(--font-heading);
            font-size: 1.85rem;
            font-weight: 800;
            color: var(--text-title);
            margin-bottom: 6px;
        }

        .win-modal-desc {
            font-size: 0.92rem;
            color: var(--text-body);
            margin-bottom: 22px;
            line-height: 1.5;
        }

        .win-code-box {
            background: var(--bg-alt);
            border: 1.5px dashed var(--primary-purple);
            border-radius: 14px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .win-code-label {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-align: left;
            font-weight: 600;
        }

        .win-code-text {
            font-family: monospace;
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text-title);
            letter-spacing: 1px;
        }

        .btn-copy-code {
            background: var(--primary-purple);
            border: none;
            color: #ffffff;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-copy-code:hover {
            background: var(--primary-purple-hover);
        }

        .win-modal-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .btn-primary-claim {
            background: var(--primary-gradient);
            color: #ffffff;
            border: none;
            padding: 14px 20px;
            border-radius: 14px;
            font-family: var(--font-heading);
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s ease;
            box-shadow: 0 8px 24px rgba(139, 154, 110, 0.35);
            text-decoration: none;
        }

        .btn-primary-claim:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(139, 154, 110, 0.5);
            color: #ffffff;
        }

        .btn-close-modal {
            background: var(--bg-alt);
            border: 1px solid var(--border-light);
            color: var(--text-body);
            padding: 12px;
            border-radius: 12px;
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-close-modal:hover {
            background: var(--bg-sand);
            color: var(--text-title);
        }

        .btn-confetti-corner {
            position: absolute;
            top: 18px;
            right: 18px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f7f2eb;
            border: 1px solid #e4dcce;
            color: var(--primary-purple-hover);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 2px 8px rgba(35, 43, 30, 0.06);
            z-index: 10;
        }
        .btn-confetti-corner:hover {
            background: #ffffff;
            color: #d97706;
            border-color: #d99b43;
            transform: scale(1.1) rotate(12deg);
            box-shadow: 0 4px 14px rgba(217, 155, 67, 0.25);
        }
        .btn-confetti-corner:active {
            transform: scale(0.94);
        }

        /* Toast notification */
        .toast-notify {
            position: fixed;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background: var(--text-title);
            color: #ffffff;
            padding: 10px 22px;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 700;
            box-shadow: 0 8px 24px rgba(35, 43, 30, 0.3);
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 200;
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            pointer-events: none;
        }

        .toast-notify.is-show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }

        /* Confetti Canvas handled via .layer and dual-layer architecture */

        /* Footer Branding */
        .spin-footer {
            margin-top: 40px;
            padding: 24px 0;
            border-top: 1px solid var(--border-light);
            text-align: center;
            font-size: 0.82rem;
            color: var(--text-muted);
        }
    </style>
</head>
<body>
    <div class="relative-container">
        <!-- Top Nav -->
        <nav class="spin-nav">
            <div class="spin-nav-container">
                <a href="<?= site_url('spinwheel'); ?>" class="brand-logo" title="Vendio Omnichannel ERP">
                    <img src="<?= BASE_ASSET; ?>img/vendio-logo.png" alt="Vendio Logo" class="brand-logo-icon">
                    <div class="brand-name">
                        <span class="brand-name-title">VENDIO</span>
                        <span class="brand-name-sub">OMNICHANNEL ERP</span>
                    </div>
                </a>

                <div class="nav-actions">
                    <button id="audioToggleBtn" class="btn-audio-toggle" title="Toggle Suara Audio" aria-label="Toggle Audio">
                        <i class="fa-solid fa-volume-high"></i>
                    </button>
                    <div class="spins-chip">
                        <i class="fa-solid fa-bolt"></i>
                        <span>Sisa Kesempatan:</span>
                        <span id="navSpinsCount" class="spins-count-badge">3</span>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content Arena -->
        <main class="main-arena">
            <!-- Hero Header (Clean) -->
            <header class="spin-hero-header">
                <h1 class="spin-main-title">Vendio <span>Lucky Wheel</span> of Fortune</h1>
                <p class="spin-main-desc">
                    Putar roda keberuntungan dan dapatkan hadiah langsung: diskon langganan ERP, saldo operasional, gratis setup multi-gudang, hingga paket integrasi marketplace.
                </p>
            </header>

            <!-- 2-Column Arena Layout -->
            <div class="arena-grid">
                <!-- Left: The Interactive Wheel Stage -->
                <section class="wheel-stage-card">
                    <!-- The Wheel Apparatus -->
                    <div class="wheel-apparatus">
                        <!-- Top Pointer/Needle with tick animation -->
                        <div class="wheel-pointer-wrap">
                            <div id="wheelPointer" class="wheel-pointer">
                                <div class="wheel-pointer-pin"></div>
                            </div>
                        </div>

                        <!-- Outer Rim with LED Bulbs -->
                        <div class="wheel-outer-rim">
                            <div id="ledLightsRing" class="led-lights-ring"></div>
                        </div>

                        <!-- Canvas Wheel (Intact as requested) -->
                        <canvas id="wheelCanvas" width="800" height="800"></canvas>

                        <!-- Pulsing Glow Ring around Center -->
                        <div class="pulse-ring"></div>

                        <!-- Center Spin Trigger Button (Hub - Intact) -->
                        <button id="spinBtn" class="wheel-center-hub" aria-label="Putar Spin Wheel">
                            <span class="hub-text-spin">SPIN</span>
                            <span class="hub-subtext">GRATIS</span>
                        </button>
                    </div>

                    <!-- Quick Action Buttons Below Wheel -->
                    <div class="stage-quick-actions">
                        <button id="btnResetSpins" class="btn-stage-action btn-accent" title="Reset kesempatan putar untuk pengujian demo">
                            <i class="fa-solid fa-rotate-left"></i>
                            <span>Tambah Kesempatan (+3 Spin)</span>
                        </button>
                        <button id="btnOpenRules" class="btn-stage-action">
                            <i class="fa-regular fa-circle-question"></i>
                            <span>Syarat &amp; Ketentuan</span>
                        </button>
                    </div>
                </section>

                <!-- Right: Companion Dashboard -->
                <aside class="spin-dashboard">
                    <!-- Card 1: Status & Metric Box -->
                    <div class="dash-card">
                        <div class="dash-card-header">
                            <h3 class="dash-card-title">
                                <i class="fa-solid fa-award"></i>
                                Status Mitra &amp; Tiket
                            </h3>
                            <span class="event-tag"><i class="fa-solid fa-circle-check"></i> Terverifikasi</span>
                        </div>
                        <div class="status-metric-grid">
                            <div class="metric-box">
                                <div class="metric-label">Sisa Kesempatan</div>
                                <div id="metricSpinsLeft" class="metric-value highlight-gold">3x</div>
                            </div>
                            <div class="metric-box">
                                <div class="metric-label">Total Hadiah Diraih</div>
                                <div id="metricWonCount" class="metric-value highlight-emerald">0</div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Prize Pool Catalog -->
                    <div class="dash-card">
                        <div class="dash-card-header">
                            <h3 class="dash-card-title">
                                <i class="fa-solid fa-gift"></i>
                                Katalog Hadiah Tersedia
                            </h3>
                            <span style="font-size: 0.74rem; font-weight: 600; color: var(--text-muted);">8 Pilihan Hadiah</span>
                        </div>
                        <div class="prize-catalog-grid" id="prizeCatalogList">
                            <!-- Populated dynamically via JS from prize configuration -->
                        </div>
                    </div>

                    <!-- Card 3: Session Win History -->
                    <div class="dash-card">
                        <div class="dash-card-header">
                            <h3 class="dash-card-title">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                                Riwayat Hadiah Anda
                            </h3>
                            <span id="historyCountBadge" style="font-size: 0.74rem; font-weight: 700; color: var(--primary-purple-hover);">0 Hadiah</span>
                        </div>
                        <div class="history-list" id="historyListContainer">
                            <div class="history-empty" id="historyEmptyState">
                                <i class="fa-solid fa-box-open" style="font-size: 1.8rem; opacity: 0.4; margin-bottom: 8px; display: block;"></i>
                                Belum ada hadiah yang dimenangkan.<br>Klik tombol <strong>SPIN</strong> untuk mulai memutar!
                            </div>
                        </div>
                    </div>
                </aside>
            </div>

            <!-- Footer -->
            <footer class="spin-footer">
                <p>&copy; <?= date('Y'); ?> Vendio Omnichannel Platform. Halaman khusus program loyalitas mitra resmi.</p>
                <p style="margin-top: 4px; font-size: 0.75rem; color: #828f7c;">
                    Integrasi backend siap dihubungkan melalui interface <code>window.VendioSpinWheel</code>.
                </p>
            </footer>
        </main>
    </div>

    <!-- Scrim (Dark blurred backdrop behind back confetti) -->
    <div id="modalScrim" class="scrim"></div>

    <!-- Dual-Layer Confetti: BACK PLANE (Behind modal card, blur: 1.5px) -->
    <canvas id="confettiBackCanvas" class="layer confetti-back-layer"></canvas>

    <!-- Celebration Winner Modal Dialog (Between the two confetti planes) -->
    <div id="winModal" class="win-modal-wrapper" role="dialog" aria-modal="true">
        <div class="win-modal-card">
            <!-- Confetti Replay Button in Top-Right Corner -->
            <button id="btnReplayConfetti" type="button" class="btn-confetti-corner" title="Mainkan Ulang Confetti" aria-label="Replay Confetti">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5.8 11.3 2 22l10.7-3.79Z"/>
                    <path d="M4 3h.01"/>
                    <path d="M22 8h.01"/>
                    <path d="M15 2h.01"/>
                    <path d="M22 20h.01"/>
                    <path d="m22 2-2.24.75a2.9 2.9 0 0 0-1.96 3.12v0c.1.86-.57 1.63-1.45 1.63h-.38c-.86 0-1.6.6-1.76 1.44L14 10"/>
                    <path d="m22 13-.82-.33c-.86-.34-1.82.2-1.98 1.11v0c-.11.63-.7 1.06-1.33.98l-.56-.07"/>
                    <path d="m14 19 2.53-.45c.82-.15 1.5.47 1.41 1.3v0c-.07.64.38 1.22 1.02 1.31L20 21.3"/>
                </svg>
            </button>

            <div id="modalWinIcon" class="win-modal-icon-wrap">
                <div class="win-modal-icon-box"><i class="fa-solid fa-arrows-rotate"></i></div>
            </div>
            <span class="win-modal-badge" id="modalWinTier">REWARD BONUS</span>
            <h2 class="win-modal-title" id="modalWinTitle">Bonus +1 Spin</h2>
            <p class="win-modal-desc" id="modalWinDesc">
                Tambahan 1 kesempatan memutar kembali roda keberuntungan!
            </p>

            <div class="win-code-box">
                <div style="text-align: left;">
                    <div class="win-code-label">KODE KLAIM HADIAH</div>
                    <div class="win-code-text" id="modalWinCode">VND - BONUSSPIN</div>
                </div>
                <button id="btnCopyCode" class="btn-copy-code" title="Salin Kode Voucher">
                    <i class="fa-regular fa-copy"></i>
                    <span>Salin</span>
                </button>
            </div>

            <div class="win-modal-actions">
                <a id="btnClaimWhatsApp" href="#" target="_blank" class="btn-primary-claim">
                    <i class="fa-brands fa-whatsapp" style="font-size: 1.2rem;"></i>
                    <span>Klaim Hadiah Sekarang</span>
                </a>
                <button id="btnCloseModal" class="btn-close-modal">
                    Tutup &amp; Lanjut Putar
                </button>
            </div>
        </div>
    </div>

    <!-- Dual-Layer Confetti: FRONT PLANE (In front of modal card, crisp foreground) -->
    <canvas id="confettiFrontCanvas" class="layer confetti-front-layer"></canvas>

    <!-- Toast Notification -->
    <div id="toastNotify" class="toast-notify">
        <i class="fa-solid fa-circle-check"></i>
        <span id="toastText">Kode hadiah berhasil disalin ke clipboard!</span>
    </div>

    <!-- Spin Wheel Logic & Synth Engine -->
    <script>
    /**
     * ============================================================================
     * VENDIO SPIN WHEEL FRONTEND CONTROLLER
     * Designed for easy backend integration by future developers.
     * Hooks:
     * - window.VendioSpinWheel.onSpinStart()
     * - window.VendioSpinWheel.onSpinComplete(prize, remainingSpins)
     * ============================================================================
     */
    (function() {
        'use strict';

        // 1. Data Konfigurasi 8 Hadiah (Prize Pool - Intact)
        const PRIZES = [
            {
                id: 1,
                name: 'Voucher ERP 50%',
                shortLabel: 'VOUCHER 50%',
                icon: '🎁',
                tier: 'rare',
                tierLabel: 'Rare',
                desc: 'Diskon 50% biaya berlangganan paket ERP Cloud Vendio selama 1 tahun.',
                code: 'VND-ERP50',
                color1: '#059669',
                color2: '#10B981',
                textColor: '#FFFFFF',
                probability: 15
            },
            {
                id: 2,
                name: 'Saldo Rp 500.000',
                shortLabel: 'SALDO 500RB',
                icon: '💎',
                tier: 'legendary',
                tierLabel: 'Legendary',
                desc: 'Saldo kredit operasional langsung masuk ke akun balance Vendio Anda.',
                code: 'VND-CASH500',
                color1: '#B45309',
                color2: '#F59E0B',
                textColor: '#1A0E00',
                probability: 5
            },
            {
                id: 3,
                name: 'Free Integrasi 1 Bln',
                shortLabel: 'FREE INTEGRASI',
                icon: '🚀',
                tier: 'epic',
                tierLabel: 'Epic',
                desc: 'Bebas biaya kuota koneksi marketplace TikTok Shop & Tokopedia selama 1 bulan.',
                code: 'VND-INTG1M',
                color1: '#0369A1',
                color2: '#06B6D4',
                textColor: '#FFFFFF',
                probability: 20
            },
            {
                id: 4,
                name: 'Setup Multi-Gudang',
                shortLabel: 'MULTI-GUDANG',
                icon: '📦',
                tier: 'epic',
                tierLabel: 'Epic',
                desc: 'Layanan konsultasi dan setup pemetaan multi-gudang gratis dari tim ahli.',
                code: 'VND-WMSVIP',
                color1: '#4338CA',
                color2: '#6366F1',
                textColor: '#FFFFFF',
                probability: 15
            },
            {
                id: 5,
                name: 'Cashback 25%',
                shortLabel: 'CASHBACK 25%',
                icon: '⚡',
                tier: 'rare',
                tierLabel: 'Rare',
                desc: 'Cashback 25% untuk perpanjangan langganan modul integrasi apa pun.',
                code: 'VND-CB25',
                color1: '#6D28D9',
                color2: '#8B5CF6',
                textColor: '#FFFFFF',
                probability: 15
            },
            {
                id: 6,
                name: 'Merchandise Vendio',
                shortLabel: 'MERCHANDISE',
                icon: '🎟️',
                tier: 'special',
                tierLabel: 'Special',
                desc: 'Paket merchandise eksklusif: Hoodie, Polo Shirt, dan Tumbler stainless steel.',
                code: 'VND-MERCH',
                color1: '#BE123C',
                color2: '#F43F5E',
                textColor: '#FFFFFF',
                probability: 10
            },
            {
                id: 7,
                name: 'Tiket VIP Summit',
                shortLabel: 'VIP SUMMIT',
                icon: '🌟',
                tier: 'epic',
                tierLabel: 'Epic',
                desc: 'Akses lounge VIP dan dinner eksklusif di Vendio Seller Summit 2026.',
                code: 'VND-SUMMIT26',
                color1: '#0F766E',
                color2: '#14B8A6',
                textColor: '#FFFFFF',
                probability: 10
            },
            {
                id: 8,
                name: 'Bonus +1 Spin',
                shortLabel: 'BONUS +1 SPIN',
                icon: '🔄',
                tier: 'special',
                tierLabel: 'Bonus',
                desc: 'Tambahan 1 kesempatan memutar kembali roda keberuntungan!',
                code: 'VND-BONUSSPIN',
                color1: '#78350F',
                color2: '#D97706',
                textColor: '#FFFFFF',
                probability: 10
            }
        ];

        // 2. Audio Synthesizer Engine (Web Audio API - 100% Reliable, Zero Dependency)
        let audioCtx = null;
        let isAudioMuted = false;

        function getAudioContext() {
            if (!audioCtx) {
                const AudioContextClass = window.AudioContext || window.webkitAudioContext;
                if (AudioContextClass) {
                    audioCtx = new AudioContextClass();
                }
            }
            if (audioCtx && audioCtx.state === 'suspended') {
                audioCtx.resume();
            }
            return audioCtx;
        }

        function playTickSound() {
            if (isAudioMuted) return;
            const ctx = getAudioContext();
            if (!ctx) return;

            const osc = ctx.createOscillator();
            const gain = ctx.createGain();

            osc.type = 'triangle';
            osc.frequency.setValueAtTime(620, ctx.currentTime);
            osc.frequency.exponentialRampToValueAtTime(140, ctx.currentTime + 0.04);

            gain.gain.setValueAtTime(0.18, ctx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.04);

            osc.connect(gain);
            gain.connect(ctx.destination);

            osc.start();
            osc.stop(ctx.currentTime + 0.045);
        }

        function playWhooshSound() {
            if (isAudioMuted) return;
            const ctx = getAudioContext();
            if (!ctx) return;

            const osc = ctx.createOscillator();
            const gain = ctx.createGain();

            osc.type = 'sine';
            osc.frequency.setValueAtTime(220, ctx.currentTime);
            osc.frequency.exponentialRampToValueAtTime(540, ctx.currentTime + 0.35);

            gain.gain.setValueAtTime(0.2, ctx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.4);

            osc.connect(gain);
            gain.connect(ctx.destination);

            osc.start();
            osc.stop(ctx.currentTime + 0.45);
        }

        function playWinFanfare() {
            if (isAudioMuted) return;
            const ctx = getAudioContext();
            if (!ctx) return;

            const notes = [523.25, 659.25, 783.99, 1046.50]; // C5, E5, G5, C6 (Major Chord Arpeggio)
            notes.forEach((freq, idx) => {
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();

                const startTime = ctx.currentTime + (idx * 0.12);
                osc.type = 'triangle';
                osc.frequency.setValueAtTime(freq, startTime);

                gain.gain.setValueAtTime(0.22, startTime);
                gain.gain.exponentialRampToValueAtTime(0.001, startTime + 0.6);

                osc.connect(gain);
                gain.connect(ctx.destination);

                osc.start(startTime);
                osc.stop(startTime + 0.65);
            });
        }

        // 3. State Management
        let remainingSpins = 3;
        let isSpinning = false;
        let currentRotation = 0; // in radians
        let wonHistory = [];
        let lastPegIndex = -1;

        // Canvas & DOM Elements
        const canvas = document.getElementById('wheelCanvas');
        const ctx = canvas.getContext('2d');
        const spinBtn = document.getElementById('spinBtn');
        const wheelPointer = document.getElementById('wheelPointer');
        const ledRing = document.getElementById('ledLightsRing');
        const navSpinsCount = document.getElementById('navSpinsCount');
        const metricSpinsLeft = document.getElementById('metricSpinsLeft');
        const metricWonCount = document.getElementById('metricWonCount');
        const prizeCatalogList = document.getElementById('prizeCatalogList');
        const historyListContainer = document.getElementById('historyListContainer');
        const historyCountBadge = document.getElementById('historyCountBadge');
        const historyEmptyState = document.getElementById('historyEmptyState');
        const btnResetSpins = document.getElementById('btnResetSpins');
        const btnOpenRules = document.getElementById('btnOpenRules');
        const audioToggleBtn = document.getElementById('audioToggleBtn');

        // Modal & Dual-Layer Confetti Elements
        const modalScrim = document.getElementById('modalScrim');
        const confettiBackCanvas = document.getElementById('confettiBackCanvas');
        const winModal = document.getElementById('winModal');
        const confettiFrontCanvas = document.getElementById('confettiFrontCanvas');
        const modalWinIcon = document.getElementById('modalWinIcon');
        const modalWinTier = document.getElementById('modalWinTier');
        const modalWinTitle = document.getElementById('modalWinTitle');
        const modalWinDesc = document.getElementById('modalWinDesc');
        const modalWinCode = document.getElementById('modalWinCode');
        const btnCopyCode = document.getElementById('btnCopyCode');
        const btnClaimWhatsApp = document.getElementById('btnClaimWhatsApp');
        const btnCloseModal = document.getElementById('btnCloseModal');
        const btnReplayConfetti = document.getElementById('btnReplayConfetti');
        const toastNotify = document.getElementById('toastNotify');
        const toastText = document.getElementById('toastText');

        // 4. Render LED Bulbs Around the Rim
        function setupLedLights() {
            if (!ledRing) return;
            ledRing.innerHTML = '';
            const totalLeds = 24;
            const radiusPercent = 48.2; // place along outer rim

            for (let i = 0; i < totalLeds; i++) {
                const angle = (i / totalLeds) * (Math.PI * 2);
                const x = 50 + radiusPercent * Math.cos(angle);
                const y = 50 + radiusPercent * Math.sin(angle);

                const dot = document.createElement('div');
                dot.className = 'led-dot' + (i % 2 === 1 ? ' glow-alt' : '');
                dot.style.left = x + '%';
                dot.style.top = y + '%';
                dot.id = 'led-' + i;
                ledRing.appendChild(dot);
            }
        }

        let ledChaseIndex = 0;
        setInterval(() => {
            const totalLeds = 24;
            ledChaseIndex = (ledChaseIndex + 1) % totalLeds;
            const dots = ledRing.querySelectorAll('.led-dot');
            dots.forEach((dot, idx) => {
                const diff = (idx - ledChaseIndex + totalLeds) % totalLeds;
                if (diff < 4) {
                    dot.style.opacity = '1';
                    dot.style.transform = 'translate(-50%, -50%) scale(1.4)';
                } else {
                    dot.style.opacity = isSpinning ? '0.4' : '0.8';
                    dot.style.transform = 'translate(-50%, -50%) scale(1)';
                }
            });
        }, 120);

        // 5. Populate Prize Catalog
        function populatePrizeCatalog() {
            if (!prizeCatalogList) return;
            prizeCatalogList.innerHTML = '';

            PRIZES.forEach(p => {
                const item = document.createElement('div');
                item.className = 'prize-item-chip';
                item.innerHTML = `
                    <div class="prize-chip-icon">${p.icon}</div>
                    <div class="prize-chip-info">
                        <div class="prize-chip-name">${p.name}</div>
                        <div class="prize-chip-tier tier-${p.tier}">${p.tierLabel}</div>
                    </div>
                `;
                prizeCatalogList.appendChild(item);
            });
        }

        // 6. Draw Wheel Canvas (High-Res - Intact)
        const numSegments = PRIZES.length;
        const segmentAngle = (2 * Math.PI) / numSegments;

        function drawWheel(rotation = 0) {
            const width = canvas.width;
            const height = canvas.height;
            const center = width / 2;
            const radius = center - 20;

            ctx.clearRect(0, 0, width, height);
            ctx.save();
            ctx.translate(center, center);
            ctx.rotate(rotation);

            // Draw each slice
            for (let i = 0; i < numSegments; i++) {
                const p = PRIZES[i];
                const startAngle = i * segmentAngle;
                const endAngle = startAngle + segmentAngle;

                // Slice path
                ctx.beginPath();
                ctx.moveTo(0, 0);
                ctx.arc(0, 0, radius, startAngle, endAngle);
                ctx.closePath();

                // Gradient fill
                const midAngle = startAngle + segmentAngle / 2;
                const gx = Math.cos(midAngle) * radius;
                const gy = Math.sin(midAngle) * radius;
                const grad = ctx.createLinearGradient(0, 0, gx, gy);
                grad.addColorStop(0, p.color1);
                grad.addColorStop(1, p.color2);
                ctx.fillStyle = grad;
                ctx.fill();

                // Slice border divider
                ctx.strokeStyle = 'rgba(255, 255, 255, 0.22)';
                ctx.lineWidth = 3;
                ctx.stroke();

                // Silver peg at the rim
                const pegX = Math.cos(startAngle) * (radius - 8);
                const pegY = Math.sin(startAngle) * (radius - 8);
                ctx.beginPath();
                ctx.arc(pegX, pegY, 5, 0, Math.PI * 2);
                ctx.fillStyle = '#FFFFFF';
                ctx.shadowColor = 'rgba(0, 0, 0, 0.6)';
                ctx.shadowBlur = 4;
                ctx.fill();
                ctx.shadowBlur = 0;

                // Draw Text and Icon inside segment
                ctx.save();
                ctx.rotate(startAngle + segmentAngle / 2);
                ctx.textAlign = 'right';
                ctx.textBaseline = 'middle';

                // Emoji / Icon
                ctx.font = '32px "Segoe UI Emoji", "Apple Color Emoji", sans-serif';
                ctx.fillText(p.icon, radius - 26, 0);

                // Label Text
                ctx.fillStyle = p.textColor;
                ctx.font = 'bold 20px "Outfit", "Plus Jakarta Sans", sans-serif';
                ctx.shadowColor = 'rgba(0,0,0,0.45)';
                ctx.shadowBlur = 4;
                ctx.fillText(p.shortLabel, radius - 74, 0);
                ctx.shadowBlur = 0;

                ctx.restore();
            }

            // Inner Metallic Track Ring
            ctx.beginPath();
            ctx.arc(0, 0, 110, 0, Math.PI * 2);
            ctx.fillStyle = '#0F172A';
            ctx.fill();
            ctx.strokeStyle = 'rgba(245, 158, 11, 0.5)';
            ctx.lineWidth = 4;
            ctx.stroke();

            ctx.restore();
        }

        // 7. Update UI Counts & Badges
        function updateUIState() {
            if (navSpinsCount) navSpinsCount.textContent = remainingSpins;
            if (metricSpinsLeft) metricSpinsLeft.textContent = remainingSpins + 'x';
            if (metricWonCount) metricWonCount.textContent = wonHistory.length;
            if (historyCountBadge) historyCountBadge.textContent = wonHistory.length + ' Hadiah';

            if (spinBtn) {
                if (remainingSpins <= 0) {
                    spinBtn.disabled = true;
                    spinBtn.querySelector('.hub-text-spin').textContent = 'HABIS';
                    spinBtn.querySelector('.hub-subtext').textContent = '0 TIKET';
                } else if (!isSpinning) {
                    spinBtn.disabled = false;
                    spinBtn.querySelector('.hub-text-spin').textContent = 'SPIN';
                    spinBtn.querySelector('.hub-subtext').textContent = 'GRATIS';
                }
            }
        }

        // 8. Add Win to Session History
        function recordWin(prize) {
            wonHistory.unshift({
                ...prize,
                time: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })
            });

            if (historyEmptyState) historyEmptyState.style.display = 'none';
            if (historyListContainer) {
                const item = document.createElement('div');
                item.className = 'history-item';
                item.innerHTML = `
                    <div class="history-item-left">
                        <span>${prize.icon}</span>
                        <div>
                            <div class="history-item-name">${prize.name}</div>
                            <small style="color: #828f7c;">Pukul ${wonHistory[0].time}</small>
                        </div>
                    </div>
                    <span class="history-item-code" title="Klik untuk salin">${prize.code}</span>
                `;
                item.querySelector('.history-item-code').addEventListener('click', () => {
                    copyToClipboard(prize.code);
                });
                historyListContainer.insertBefore(item, historyListContainer.firstChild);
            }
            updateUIState();
        }

        // 9. Toast Notification Helper
        function showToast(message) {
            if (!toastNotify) return;
            toastText.textContent = message;
            toastNotify.classList.add('is-show');
            setTimeout(() => {
                toastNotify.classList.remove('is-show');
            }, 3000);
        }

        function copyToClipboard(text) {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(() => {
                    showToast('Kode ' + text + ' berhasil disalin!');
                });
            } else {
                const ta = document.createElement('textarea');
                ta.value = text;
                document.body.appendChild(ta);
                ta.select();
                document.execCommand('copy');
                document.body.removeChild(ta);
                showToast('Kode ' + text + ' berhasil disalin!');
            }
        }

        // 10. The Spin Animation Engine
        function spinWheel(targetPrizeIndex = null) {
            if (isSpinning || remainingSpins <= 0) return;

            // Pick winner if not predetermined
            if (targetPrizeIndex === null) {
                const totalWeight = PRIZES.reduce((sum, p) => sum + p.probability, 0);
                let rand = Math.random() * totalWeight;
                targetPrizeIndex = 0;
                for (let i = 0; i < PRIZES.length; i++) {
                    if (rand < PRIZES[i].probability) {
                        targetPrizeIndex = i;
                        break;
                    }
                    rand -= PRIZES[i].probability;
                }
            }

            remainingSpins--;
            isSpinning = true;
            updateUIState();

            playWhooshSound();

            if (window.VendioSpinWheel && typeof window.VendioSpinWheel.onSpinStart === 'function') {
                try { window.VendioSpinWheel.onSpinStart(); } catch(e) { console.error(e); }
            }

            const pointerAngle = -Math.PI / 2;
            const targetSegmentCenter = (targetPrizeIndex + 0.5) * segmentAngle;
            
            const fullSpins = 6 + Math.floor(Math.random() * 2);
            const extraJitter = (Math.random() - 0.5) * (segmentAngle * 0.55);

            const currentNormalized = currentRotation % (2 * Math.PI);
            const desiredLanding = pointerAngle - targetSegmentCenter + extraJitter;
            const deltaRotation = (fullSpins * 2 * Math.PI) + (desiredLanding - currentNormalized);
            const startRotation = currentRotation;
            const finalRotation = startRotation + deltaRotation;

            const duration = 5200; // ms
            const startTime = performance.now();

            function animate(now) {
                const elapsed = now - startTime;
                const progress = Math.min(elapsed / duration, 1);

                const easeOut = 1 - Math.pow(1 - progress, 4.2);
                currentRotation = startRotation + (deltaRotation * easeOut);

                drawWheel(currentRotation);

                const effectiveRot = currentRotation - pointerAngle;
                const currentPeg = Math.floor(effectiveRot / segmentAngle);
                if (currentPeg !== lastPegIndex) {
                    lastPegIndex = currentPeg;
                    playTickSound();
                    if (wheelPointer) {
                        wheelPointer.classList.add('is-ticking');
                        setTimeout(() => wheelPointer.classList.remove('is-ticking'), 60);
                    }
                }

                if (progress < 1) {
                    requestAnimationFrame(animate);
                } else {
                    isSpinning = false;
                    currentRotation = finalRotation;
                    drawWheel(currentRotation);

                    const wonPrize = PRIZES[targetPrizeIndex];

                    if (wonPrize.id === 8) {
                        remainingSpins++;
                    }

                    recordWin(wonPrize);
                    updateUIState();
                    triggerCelebration(wonPrize);

                    if (window.VendioSpinWheel && typeof window.VendioSpinWheel.onSpinComplete === 'function') {
                        try { window.VendioSpinWheel.onSpinComplete(wonPrize, remainingSpins); } catch(e) { console.error(e); }
                    }
                }
            }

            requestAnimationFrame(animate);
        }

        // 11. Dual-Layer Confetti Physics Engine (Matching Image 2)
        // Back plane: parade-paper flutter (blur: 1.5px, 4.2s).
        // Front plane: cannon burst -> flutter over card (sharp, 3.4s).
        // Particle types: wavy streamers, double rings, curved arcs, tumbling flecks.
        class DualLayerConfettiEngine {
            constructor(backCanvas, frontCanvas) {
                this.backCanvas = backCanvas;
                this.frontCanvas = frontCanvas;
                this.backCtx = backCanvas ? backCanvas.getContext('2d') : null;
                this.frontCtx = frontCanvas ? frontCanvas.getContext('2d') : null;
                this.backParticles = [];
                this.frontParticles = [];
                this.animId = null;
                this.isRunning = false;

                // Palette from Image 2
                this.colors = [
                    '#FA686C', // Coral Pink
                    '#330094', // Deep Indigo
                    '#3D26AE', // Royal Violet
                    '#FA8785', // Soft Salmon
                    '#FFFFFF', // Pure White
                    '#F59E0B', // Golden Yellow
                    '#8B9A6E'  // Vendio Olive Accent
                ];

                this.resize = this.resize.bind(this);
                window.addEventListener('resize', this.resize);
                this.resize();
            }

            resize() {
                if (!this.backCanvas || !this.frontCanvas) return;
                this.dpr = Math.min(window.devicePixelRatio || 1, 2);
                const w = window.innerWidth;
                const h = window.innerHeight;

                this.backCanvas.width = w * this.dpr;
                this.backCanvas.height = h * this.dpr;
                this.frontCanvas.width = w * this.dpr;
                this.frontCanvas.height = h * this.dpr;

                this.backCtx.setTransform(this.dpr, 0, 0, this.dpr, 0, 0);
                this.frontCtx.setTransform(this.dpr, 0, 0, this.dpr, 0, 0);
            }

            createParticle(originX, originY, isFront) {
                const rand = Math.random();
                let type;
                if (rand < 0.24) {
                    type = 'streamer'; // Wavy ribbon
                } else if (rand < 0.48) {
                    type = 'ring';     // Hollow circle or double ring
                } else if (rand < 0.68) {
                    type = 'arc';      // Curved stroke
                } else {
                    type = 'fleck';    // Tumbling paper chip
                }

                // Randomize burst direction and speed
                const angle = -Math.PI / 2 + (Math.random() - 0.5) * (Math.PI * 0.92);
                const speed = isFront 
                    ? (Math.random() * 14 + 10) // Front: energetic burst
                    : (Math.random() * 11 + 6);  // Back: parade float

                const color = this.colors[Math.floor(Math.random() * this.colors.length)];

                return {
                    type: type,
                    isFront: isFront,
                    x: originX + (Math.random() - 0.5) * 80,
                    y: originY + (Math.random() - 0.5) * 40,
                    vx: Math.cos(angle) * speed * (Math.random() > 0.5 ? 1 : -1) * 0.95,
                    vy: Math.sin(angle) * speed,
                    drag: isFront ? 0.965 : 0.96,
                    gravity: type === 'streamer' ? 0.26 : (type === 'ring' ? 0.30 : 0.34),
                    color: color,
                    alpha: 1,
                    decay: isFront ? (Math.random() * 0.0035 + 0.0035) : (Math.random() * 0.0028 + 0.003),
                    life: 0,
                    maxLife: isFront ? 210 : 255,

                    // Streamer (wavy ribbon)
                    ribbonLength: Math.random() * 45 + 55,
                    waves: Math.random() * 1.5 + 2,
                    amplitude: Math.random() * 10 + 12,
                    phase: Math.random() * Math.PI * 2,
                    phaseSpeed: (Math.random() * 0.08 + 0.04) * (Math.random() > 0.5 ? 1 : -1),
                    strokeWidth: Math.random() * 2.5 + 3.5,

                    // Ring / Double ring
                    radius: Math.random() * 10 + 9,
                    hasInner: Math.random() > 0.45,
                    tiltX: Math.random() * Math.PI,
                    tiltY: Math.random() * Math.PI,
                    vTiltX: (Math.random() * 0.08 + 0.03),
                    vTiltY: (Math.random() * 0.06 + 0.02),

                    // Arc (crescent)
                    arcRadius: Math.random() * 12 + 10,
                    arcSweep: Math.random() * 1.4 + 1.2,

                    // Fleck (tumbling paper chip)
                    w: Math.random() * 8 + 10,
                    h: Math.random() * 10 + 12,
                    skew: (Math.random() - 0.5) * 6,
                    flipAngle: Math.random() * Math.PI,
                    vFlip: Math.random() * 0.12 + 0.05,

                    // Rotation & horizontal sway
                    rotation: Math.random() * Math.PI * 2,
                    vRot: (Math.random() - 0.5) * 0.08,
                    swayPhase: Math.random() * Math.PI * 2,
                    swaySpeed: Math.random() * 0.06 + 0.03,
                    swayAmp: Math.random() * 1.2 + 0.6
                };
            }

            fire() {
                const w = window.innerWidth;
                const h = window.innerHeight;
                const originX = w / 2;
                const originY = h * 0.45;

                // Reset existing particles
                this.backParticles = [];
                this.frontParticles = [];

                // Back plane: parade flutter (50 items)
                for (let i = 0; i < 50; i++) {
                    this.backParticles.push(this.createParticle(originX, originY, false));
                }

                // Front plane: cannon burst (staggered by 120ms, 65 items)
                setTimeout(() => {
                    if (!this.isRunning) return;
                    for (let i = 0; i < 65; i++) {
                        this.frontParticles.push(this.createParticle(originX, originY, true));
                    }
                }, 120);

                if (!this.isRunning) {
                    this.isRunning = true;
                    this.loop();
                }
            }

            stop() {
                this.isRunning = false;
                if (this.animId) {
                    cancelAnimationFrame(this.animId);
                    this.animId = null;
                }
                const w = window.innerWidth;
                const h = window.innerHeight;
                if (this.backCtx) this.backCtx.clearRect(0, 0, w, h);
                if (this.frontCtx) this.frontCtx.clearRect(0, 0, w, h);
                this.backParticles = [];
                this.frontParticles = [];
            }

            updateAndDrawParticles(particles, ctx) {
                if (!ctx) return 0;
                let aliveCount = 0;
                const h = window.innerHeight;

                for (let i = 0; i < particles.length; i++) {
                    const p = particles[i];
                    p.life++;

                    if (p.alpha <= 0.01 || p.y > h + 130 || p.life > p.maxLife) {
                        continue;
                    }

                    aliveCount++;

                    // Physics update
                    p.vx *= p.drag;
                    p.vy += p.gravity;
                    p.x += p.vx + Math.sin(p.swayPhase) * p.swayAmp;
                    p.y += p.vy;

                    p.rotation += p.vRot;
                    p.phase += p.phaseSpeed;
                    p.swayPhase += p.swaySpeed;
                    p.tiltX += p.vTiltX;
                    p.tiltY += p.vTiltY;
                    p.flipAngle += p.vFlip;

                    if (p.life > p.maxLife * 0.7) {
                        p.alpha -= p.decay * 2.5;
                    }
                    const currentAlpha = Math.max(0, Math.min(p.alpha, 1));

                    ctx.save();
                    ctx.globalAlpha = currentAlpha;

                    if (p.type === 'streamer') {
                        // Smooth Wavy Ribbon
                        ctx.translate(p.x, p.y);
                        ctx.rotate(p.rotation);
                        ctx.beginPath();
                        ctx.lineWidth = p.strokeWidth;
                        ctx.strokeStyle = p.color;
                        ctx.lineCap = 'round';
                        ctx.lineJoin = 'round';

                        const steps = 18;
                        for (let s = 0; s <= steps; s++) {
                            const t = s / steps;
                            const px = Math.sin(t * Math.PI * p.waves + p.phase) * p.amplitude;
                            const py = (t - 0.5) * p.ribbonLength;
                            if (s === 0) ctx.moveTo(px, py);
                            else ctx.lineTo(px, py);
                        }
                        ctx.stroke();

                    } else if (p.type === 'ring') {
                        // Hollow Ring / Double Concentric Ring
                        ctx.translate(p.x, p.y);
                        ctx.rotate(p.rotation);
                        ctx.scale(Math.cos(p.tiltX), Math.sin(p.tiltY));
                        ctx.beginPath();
                        ctx.lineWidth = 3.5;
                        ctx.strokeStyle = p.color;
                        ctx.arc(0, 0, p.radius, 0, Math.PI * 2);
                        ctx.stroke();

                        if (p.hasInner) {
                            ctx.beginPath();
                            ctx.lineWidth = 2.4;
                            ctx.arc(0, 0, p.radius * 0.54, 0, Math.PI * 2);
                            ctx.stroke();
                        }

                    } else if (p.type === 'arc') {
                        // Curved Arc Stroke
                        ctx.translate(p.x, p.y);
                        ctx.rotate(p.rotation);
                        ctx.scale(Math.cos(p.tiltX), 1);
                        ctx.beginPath();
                        ctx.lineWidth = 3.2;
                        ctx.strokeStyle = p.color;
                        ctx.lineCap = 'round';
                        ctx.arc(0, 0, p.arcRadius, 0, p.arcSweep);
                        ctx.stroke();

                    } else {
                        // 3D Flipping Paper Fleck
                        ctx.translate(p.x, p.y);
                        ctx.rotate(p.rotation);
                        const scaleY = Math.cos(p.flipAngle);
                        ctx.scale(1, scaleY);
                        ctx.fillStyle = p.color;
                        ctx.beginPath();
                        ctx.moveTo(-p.w / 2, -p.h / 2 + p.skew);
                        ctx.lineTo(p.w / 2, -p.h / 2 - p.skew);
                        ctx.lineTo(p.w / 2 + p.skew, p.h / 2);
                        ctx.lineTo(-p.w / 2 - p.skew, p.h / 2);
                        ctx.closePath();
                        ctx.fill();
                    }

                    ctx.restore();
                }

                return aliveCount;
            }

            loop() {
                if (!this.isRunning) return;

                const w = window.innerWidth;
                const h = window.innerHeight;

                if (this.backCtx) this.backCtx.clearRect(0, 0, w, h);
                if (this.frontCtx) this.frontCtx.clearRect(0, 0, w, h);

                const backAlive = this.updateAndDrawParticles(this.backParticles, this.backCtx);
                const frontAlive = this.updateAndDrawParticles(this.frontParticles, this.frontCtx);

                if (backAlive === 0 && frontAlive === 0 && this.frontParticles.length > 0) {
                    this.stop();
                } else {
                    this.animId = requestAnimationFrame(() => this.loop());
                }
            }
        }

        // Initialize Confetti Engine
        const confettiEngine = new DualLayerConfettiEngine(confettiBackCanvas, confettiFrontCanvas);

        // Modal Open / Close Helpers
        function openWinnerModal() {
            if (modalScrim) modalScrim.classList.add('is-active');
            if (confettiBackCanvas) confettiBackCanvas.classList.add('is-active');
            if (winModal) winModal.classList.add('is-active');
            if (confettiFrontCanvas) confettiFrontCanvas.classList.add('is-active');
        }

        function closeWinnerModal() {
            if (modalScrim) modalScrim.classList.remove('is-active');
            if (confettiBackCanvas) confettiBackCanvas.classList.remove('is-active');
            if (winModal) winModal.classList.remove('is-active');
            if (confettiFrontCanvas) confettiFrontCanvas.classList.remove('is-active');
            if (confettiEngine) confettiEngine.stop();
        }

        // 12. Trigger Celebration Dialog Modal
        function triggerCelebration(prize) {
            playWinFanfare();

            // Prize Icon formatting matching Image 1
            if (prize.id === 8) {
                // Bonus +1 Spin with reload icon
                modalWinIcon.innerHTML = '<div class="win-modal-icon-box"><i class="fa-solid fa-arrows-rotate"></i></div>';
            } else if (prize.id === 1) {
                modalWinIcon.innerHTML = '<div class="win-modal-icon-box" style="background: linear-gradient(135deg, #10B981, #059669);"><i class="fa-solid fa-ticket"></i></div>';
            } else if (prize.id === 2) {
                modalWinIcon.innerHTML = '<div class="win-modal-icon-box" style="background: linear-gradient(135deg, #F59E0B, #B45309);"><i class="fa-solid fa-wallet"></i></div>';
            } else if (prize.id === 3) {
                modalWinIcon.innerHTML = '<div class="win-modal-icon-box" style="background: linear-gradient(135deg, #06B6D4, #0369A1);"><i class="fa-solid fa-network-wired"></i></div>';
            } else if (prize.id === 4) {
                modalWinIcon.innerHTML = '<div class="win-modal-icon-box" style="background: linear-gradient(135deg, #6366F1, #4338CA);"><i class="fa-solid fa-warehouse"></i></div>';
            } else if (prize.id === 5) {
                modalWinIcon.innerHTML = '<div class="win-modal-icon-box" style="background: linear-gradient(135deg, #8B5CF6, #6D28D9);"><i class="fa-solid fa-bolt"></i></div>';
            } else if (prize.id === 6) {
                modalWinIcon.innerHTML = '<div class="win-modal-icon-box" style="background: linear-gradient(135deg, #F43F5E, #BE123C);"><i class="fa-solid fa-shirt"></i></div>';
            } else if (prize.id === 7) {
                modalWinIcon.innerHTML = '<div class="win-modal-icon-box" style="background: linear-gradient(135deg, #14B8A6, #0F766E);"><i class="fa-solid fa-crown"></i></div>';
            } else {
                modalWinIcon.innerHTML = '<div class="win-modal-icon-box">' + (prize.icon || '🎁') + '</div>';
            }

            modalWinTier.textContent = 'REWARD ' + prize.tierLabel.toUpperCase();
            modalWinTitle.textContent = prize.name;
            modalWinDesc.textContent = prize.desc;
            modalWinCode.textContent = prize.code;

            const waMsg = encodeURIComponent(
                'Halo Tim Vendio, saya telah memutar Vendio Lucky Wheel dan memenangkan: ' + prize.name + 
                ' dengan Kode Klaim: ' + prize.code + '. Mohon bantuannya untuk proses aktivasi reward saya. Terima kasih!'
            );
            btnClaimWhatsApp.href = 'https://wa.me/6281234567890?text=' + waMsg;

            setTimeout(() => {
                openWinnerModal();
                confettiEngine.fire();
            }, 300);
        }

        // Global fire helper matching snippet
        window.fire = function() {
            if (confettiEngine) {
                confettiEngine.fire();
            }
        };

        // 13. Event Listeners
        if (spinBtn) {
            spinBtn.addEventListener('click', () => {
                getAudioContext();
                spinWheel();
            });
        }

        if (canvas) {
            canvas.addEventListener('click', () => {
                getAudioContext();
                spinWheel();
            });
        }

        if (btnResetSpins) {
            btnResetSpins.addEventListener('click', () => {
                remainingSpins += 3;
                updateUIState();
                showToast('Berhasil menambahkan 3 kesempatan putar!');
            });
        }

        if (btnOpenRules) {
            btnOpenRules.addEventListener('click', () => {
                showToast('Aturan: 1 kode klaim berlaku untuk 1 akun pengguna terdaftar.');
            });
        }

        if (btnCloseModal) {
            btnCloseModal.addEventListener('click', closeWinnerModal);
        }

        if (winModal) {
            winModal.addEventListener('click', (e) => {
                if (e.target === winModal) {
                    closeWinnerModal();
                }
            });
        }

        if (modalScrim) {
            modalScrim.addEventListener('click', closeWinnerModal);
        }

        if (btnReplayConfetti) {
            btnReplayConfetti.addEventListener('click', () => {
                window.fire();
            });
        }

        if (btnCopyCode) {
            btnCopyCode.addEventListener('click', () => {
                copyToClipboard(modalWinCode.textContent);
            });
        }

        if (audioToggleBtn) {
            audioToggleBtn.addEventListener('click', () => {
                isAudioMuted = !isAudioMuted;
                audioToggleBtn.innerHTML = isAudioMuted ? '<i class="fa-solid fa-volume-xmark"></i>' : '<i class="fa-solid fa-volume-high"></i>';
                showToast(isAudioMuted ? 'Suara audio dimatikan' : 'Suara audio diaktifkan');
            });
        }

        // 14. Initialize Wheel on Mount
        setupLedLights();
        populatePrizeCatalog();
        drawWheel(0);
        updateUIState();

        // 15. Export Global Interface for Future Backend Developers
        window.VendioSpinWheel = {
            prizes: PRIZES,
            getRemainingSpins: () => remainingSpins,
            setRemainingSpins: (count) => { remainingSpins = count; updateUIState(); },
            spin: (prizeIndex) => spinWheel(prizeIndex),
            onSpinStart: null,
            onSpinComplete: null
        };

    })();
    </script>
</body>
</html>
