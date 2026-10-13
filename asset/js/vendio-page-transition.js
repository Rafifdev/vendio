/**
 * Vendio Omnichannel - Smooth Seamless Page & Pagination Transition Router
 * Provides SPA-like buttery smooth slide transitions:
 * 1. Between Landing Page and Blog Page (full view slide)
 * 2. Between Blog Pagination & Categories (in-page grid slide, no full reload)
 * Always fetches live fresh content (bypasses cache) so newly created/updated articles appear instantly.
 */
(function() {
    'use strict';

    let isTransitioning = false;
    let observerInstance = null;
    let currentActiveUrl = window.location.href;

    // Check if a URL points to an article detail page (e.g. /blog/panduan-migrasi-... or /blog/read/...)
    function isArticleDetailPage(urlObj) {
        if (!urlObj || !urlObj.pathname) return false;
        const path = urlObj.pathname.replace(/\/+$/, '');
        const segments = path.split('/').filter(Boolean);
        const blogIdx = segments.indexOf('blog');
        if (blogIdx === -1) return false;

        // If there is nothing after 'blog', it is the listing page (/blog)
        if (segments.length <= blogIdx + 1) return false;

        const sub = segments[blogIdx + 1];
        // Non-article subpaths: index (pagination), category (filter), tag (filter)
        if (sub === 'index' || sub === 'category' || sub === 'tag') {
            return false;
        }

        // Any other subpath after /blog is an article slug or detail page
        return true;
    }

    // Get page navigation hierarchy depth for natural slide direction:
    // 0: Home/Landing, 1: Blog Index, 2: Article Detail
    function getPageDepth(urlObj) {
        if (!urlObj || !urlObj.pathname) return 0;
        if (isArticleDetailPage(urlObj)) return 2;
        if (urlObj.pathname.includes('/blog')) return 1;
        return 0;
    }

    // Create / get the top progress bar
    function getProgressBar() {
        let bar = document.getElementById('page-progress-bar');
        if (!bar) {
            bar = document.createElement('div');
            bar.id = 'page-progress-bar';
            bar.className = 'page-progress-bar';
            document.body.prepend(bar);
        }
        return bar;
    }

    function startProgress() {
        const bar = getProgressBar();
        bar.style.transition = 'width 0.3s ease, opacity 0.2s ease';
        bar.style.opacity = '1';
        bar.style.width = '25%';
        setTimeout(() => {
            if (isTransitioning) bar.style.width = '70%';
        }, 120);
    }

    function endProgress() {
        const bar = getProgressBar();
        bar.style.width = '100%';
        setTimeout(() => {
            bar.style.opacity = '0';
            setTimeout(() => {
                bar.style.transition = 'none';
                bar.style.width = '0%';
            }, 250);
        }, 180);
    }

    // Update active nav indicators
    function updateNavbarActive(urlStr) {
        try {
            const url = new URL(urlStr, window.location.origin);
            const isBlog = url.pathname.includes('/blog');

            const navLinks = document.querySelectorAll('.nav-link');
            const mobileItems = document.querySelectorAll('.mobile-dropdown-item');

            navLinks.forEach(link => link.classList.remove('active'));
            mobileItems.forEach(item => item.classList.remove('active'));

            if (isBlog) {
                navLinks.forEach(link => {
                    const href = link.getAttribute('href') || '';
                    if (href.includes('blog')) link.classList.add('active');
                });
                mobileItems.forEach(item => {
                    const href = item.getAttribute('href') || '';
                    if (href.includes('blog')) item.classList.add('active');
                });
            } else {
                if (typeof window.updateActiveNav === 'function') {
                    window.updateActiveNav();
                }
            }
        } catch (e) {
            // Ignore error
        }
    }

    // -------------------------------------------------------------------------
    // Core Shared Interactive Functions
    // -------------------------------------------------------------------------
    let blogRevealObserver = null;

    function initBlogAnimations() {
        const cards = document.querySelectorAll('.blog-card');
        if (!cards || cards.length === 0) return;

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

                        // Clear transition-delay after entrance completes so hover is snappy
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
                    // Cards in viewport or near top are revealed immediately
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

        // Guaranteed safety reveal timeout: all cards must be visible within 250ms
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

    function handleNavbarFloatingState() {
        const navbar = document.getElementById('navbar');
        if (!navbar) return;
        if (window.scrollY > 30) {
            navbar.classList.add('is-scrolled');
        } else {
            navbar.classList.remove('is-scrolled');
        }
    }
    window.handleNavbarFloatingState = handleNavbarFloatingState;

    function initMobileMenu() {
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileDropdownCard = document.getElementById('mobileDropdownCard');
        const mobileMenuBackdrop = document.getElementById('mobileMenuBackdrop');

        function toggleMobileMenu(open) {
            if (!mobileDropdownCard || !mobileMenuBtn) return;
            const isCurrentlyOpen = mobileDropdownCard.classList.contains('is-open');
            const shouldOpen = (typeof open === 'boolean') ? open : !isCurrentlyOpen;

            if (shouldOpen) {
                mobileDropdownCard.classList.add('is-open');
                if (mobileMenuBackdrop) mobileMenuBackdrop.classList.add('is-open');
                mobileMenuBtn.innerHTML = '<i class="fa-solid fa-xmark"></i>';
                mobileMenuBtn.setAttribute('aria-expanded', 'true');
            } else {
                mobileDropdownCard.classList.remove('is-open');
                if (mobileMenuBackdrop) mobileMenuBackdrop.classList.remove('is-open');
                mobileMenuBtn.innerHTML = '<i class="fa-solid fa-bars"></i>';
                mobileMenuBtn.setAttribute('aria-expanded', 'false');
            }
        }
        window.toggleMobileMenu = toggleMobileMenu;

        if (mobileMenuBtn && !mobileMenuBtn._hasMenuBound) {
            mobileMenuBtn._hasMenuBound = true;
            mobileMenuBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                toggleMobileMenu();
            });
        }

        if (mobileMenuBackdrop && !mobileMenuBackdrop._hasMenuBound) {
            mobileMenuBackdrop._hasMenuBound = true;
            mobileMenuBackdrop.addEventListener('click', function(e) {
                e.preventDefault();
                toggleMobileMenu(false);
            });
        }

        document.querySelectorAll('.mobile-dropdown-item').forEach(item => {
            if (!item._hasMenuBound) {
                item._hasMenuBound = true;
                item.addEventListener('click', function() {
                    toggleMobileMenu(false);
                });
            }
        });

        // Global Outside Click and Resize handler (attached only once)
        if (!window._hasMobileMenuOutsideBound) {
            window._hasMobileMenuOutsideBound = true;
            document.addEventListener('click', function(e) {
                const card = document.getElementById('mobileDropdownCard');
                const btn = document.getElementById('mobileMenuBtn');
                if (card && card.classList.contains('is-open')) {
                    if (!card.contains(e.target) && (!btn || !btn.contains(e.target))) {
                        if (typeof window.toggleMobileMenu === 'function') {
                            window.toggleMobileMenu(false);
                        }
                    }
                }
            });

            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    if (typeof window.toggleMobileMenu === 'function') {
                        window.toggleMobileMenu(false);
                    }
                }
            });
        }
    }
    window.initMobileMenu = initMobileMenu;

    function initFaqAccordion() {
        const activeItem = document.querySelector('.accordion-item.active');
        if (activeItem) {
            const activeBody = activeItem.querySelector('.accordion-body');
            if (activeBody) {
                activeBody.style.maxHeight = (activeBody.scrollHeight + 40) + 'px';
            }
        }
    }
    window.initFaqAccordion = initFaqAccordion;

    function toggleFaq(header) {
        if (!header) return;
        const item = header.parentElement;
        if (!item) return;
        const body = item.querySelector('.accordion-body');
        const isActive = item.classList.contains('active');
        const allItems = document.querySelectorAll('.accordion-item');

        allItems.forEach(el => {
            if (el !== item && el.classList.contains('active')) {
                const otherBody = el.querySelector('.accordion-body');
                if (otherBody) {
                    otherBody.style.maxHeight = otherBody.scrollHeight + 'px';
                    otherBody.offsetHeight;
                    otherBody.style.maxHeight = '0px';
                }
                el.classList.remove('active');
            }
        });

        if (isActive) {
            if (body) {
                body.style.maxHeight = body.scrollHeight + 'px';
                body.offsetHeight;
                body.style.maxHeight = '0px';
            }
            item.classList.remove('active');
        } else {
            item.classList.add('active');
            if (body) {
                body.style.maxHeight = '0px';
                body.offsetHeight;
                body.style.maxHeight = (body.scrollHeight + 40) + 'px';
            }
        }
    }
    window.toggleFaq = toggleFaq;

    function updateActiveNav() {
        const targetSections = document.querySelectorAll('section[id]');
        if (!targetSections.length) return;
        const menuLinks = document.querySelectorAll('.nav-link');
        const mobileLinks = document.querySelectorAll('.mobile-dropdown-item');

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
    window.updateActiveNav = updateActiveNav;

    // Helper to evaluate any inline scripts inside injected view
    function executeViewScripts(container) {
        if (!container) return;
        const scripts = container.querySelectorAll('script');
        scripts.forEach(oldScript => {
            const newScript = document.createElement('script');
            Array.from(oldScript.attributes).forEach(attr => {
                newScript.setAttribute(attr.name, attr.value);
            });
            newScript.textContent = oldScript.textContent;
            oldScript.parentNode.replaceChild(newScript, oldScript);
        });
    }

    // Re-initialize interactive scripts on the current active view
    function initCurrentPageScripts() {
        const currentView = document.getElementById('app-page-view');
        const pageType = currentView ? currentView.getAttribute('data-page') : '';

        // 1. Mobile Menu & Navbar Floating State
        initMobileMenu();
        handleNavbarFloatingState();

        // 2. Landing Page Specific Features
        if (pageType === 'home' || document.querySelector('.hero-section')) {
            initFaqAccordion();

            // Re-init reveal animations
            if (observerInstance) {
                observerInstance.disconnect();
                observerInstance = null;
            }
            const revealElements = document.querySelectorAll('.reveal-init, .reveal-left, .reveal-right, .reveal-scale');
            if ('IntersectionObserver' in window && revealElements.length > 0) {
                observerInstance = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-revealed');
                        } else {
                            entry.target.classList.remove('is-revealed');
                        }
                    });
                }, {
                    root: null,
                    threshold: 0.12,
                    rootMargin: '0px 0px -40px 0px'
                });
                revealElements.forEach(el => observerInstance.observe(el));
            } else {
                revealElements.forEach(el => el.classList.add('is-revealed'));
            }

            updateActiveNav();
        }

        // 3. Blog Page Specific Features (Cards Reveal & Entrance animations)
        if (pageType === 'blog' || document.getElementById('blog-grid')) {
            initBlogAnimations();
        }

        // 4. Blog Detail Specific Features (Interactive Table of Contents)
        if (pageType === 'blog-detail' || document.getElementById('article-toc-sidebar')) {
            if (typeof window.initArticleTOC === 'function') {
                window.initArticleTOC();
            }
        }
    }

    // =========================================================================
    // In-Page Blog Pagination & Filter Transition (Smooth Grid Slide)
    // =========================================================================
    async function navigateBlogPagination(targetUrl, linkElement, pushHistory = true) {
        if (isTransitioning) return;

        const blogGrid = document.getElementById('blog-grid');
        const paginationWrap = document.getElementById('blog-pagination');
        if (!blogGrid) {
            navigateTo(targetUrl, { pushHistory: pushHistory });
            return;
        }

        isTransitioning = true;
        startProgress();

        // Determine target page vs current page
        const activeItem = document.querySelector('.pagination-wrap li.active');
        const currentPage = activeItem ? (parseInt(activeItem.textContent.trim()) || 1) : 1;

        let targetPage = 1;
        if (linkElement && linkElement.getAttribute('data-ci-pagination-page')) {
            targetPage = parseInt(linkElement.getAttribute('data-ci-pagination-page')) || 1;
        } else {
            const match = targetUrl.match(/\/blog\/index\/(\d+)/);
            if (match) {
                targetPage = Math.floor(parseInt(match[1]) / 9) + 1;
            }
        }

        const direction = targetPage >= currentPage ? 'forward' : 'backward';

        // Phase 1: Slide out the blog grid smoothly
        blogGrid.classList.remove('grid-slide-in-right', 'grid-slide-in-left', 'grid-slide-out-left', 'grid-slide-out-right');
        blogGrid.classList.add(direction === 'forward' ? 'grid-slide-out-left' : 'grid-slide-out-right');

        // Smoothly scroll to the top of blog content area so user sees top cards
        const contentArea = document.getElementById('blog-content-area');
        if (contentArea) {
            const topPos = contentArea.getBoundingClientRect().top + window.pageYOffset - 90;
            window.scrollTo({ top: Math.max(0, topPos), behavior: 'smooth' });
        }

        // Always append fresh cache-busting timestamp param
        const fetchUrl = new URL(targetUrl, window.location.origin);
        fetchUrl.searchParams.set('_vts', Date.now());

        try {
            const [_, response] = await Promise.all([
                new Promise(resolve => setTimeout(resolve, 240)),
                fetch(fetchUrl.toString(), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    cache: 'no-store'
                })
            ]);

            if (!response.ok) throw new Error('HTTP ' + response.status);

            const htmlText = await response.text();
            const parser = new DOMParser();
            const newDoc = parser.parseFromString(htmlText, 'text/html');

            const newGrid = newDoc.getElementById('blog-grid');
            const newPagination = newDoc.getElementById('blog-pagination');
            const newCatStrip = newDoc.querySelector('.category-filter-strip');
            const curCatStrip = document.querySelector('.category-filter-strip');
            const newSearchInfo = newDoc.querySelector('.search-info-bar');
            const curSearchInfo = document.querySelector('.search-info-bar');

            if (newGrid && blogGrid) {
                blogGrid.innerHTML = newGrid.innerHTML;
            }
            if (newPagination && paginationWrap) {
                paginationWrap.innerHTML = newPagination.innerHTML;
            } else if (!newPagination && paginationWrap) {
                paginationWrap.innerHTML = '';
            }
            if (newCatStrip && curCatStrip) {
                curCatStrip.innerHTML = newCatStrip.innerHTML;
            }
            if (newSearchInfo && curSearchInfo) {
                curSearchInfo.replaceWith(newSearchInfo.cloneNode(true));
            } else if (!newSearchInfo && curSearchInfo) {
                curSearchInfo.remove();
            } else if (newSearchInfo && !curSearchInfo) {
                const mainContainer = document.querySelector('.blog-main-content .container');
                if (mainContainer && blogGrid) {
                    mainContainer.insertBefore(newSearchInfo.cloneNode(true), blogGrid);
                }
            }

            // Update title if present
            if (newDoc.title) document.title = newDoc.title;

            // Trigger smooth staggered reveal animation on the fresh cards
            initBlogAnimations();

            // Phase 2: Slide in the new grid smoothly
            blogGrid.classList.remove('grid-slide-out-left', 'grid-slide-out-right');
            blogGrid.classList.add(direction === 'forward' ? 'grid-slide-in-right' : 'grid-slide-in-left');

            // Update browser address bar and history
            if (pushHistory) {
                history.pushState({ url: targetUrl, isBlogPagination: true, page: targetPage }, newDoc.title, targetUrl);
            }
            currentActiveUrl = targetUrl;

            endProgress();

            setTimeout(() => {
                blogGrid.classList.remove('grid-slide-in-right', 'grid-slide-in-left');
                initBlogAnimations();
                isTransitioning = false;
            }, 340);

        } catch (err) {
            console.error('Pagination transition error, falling back to full navigation:', err);
            endProgress();
            window.location.href = targetUrl;
        }
    }

    // =========================================================================
    // Full Page Slide Transition (Between Landing and Blog)
    // =========================================================================
    async function navigateTo(targetUrl, options = {}) {
        if (isTransitioning) return;

        // Use currentActiveUrl to know what is currently displayed in the DOM
        const activeUrl = currentActiveUrl || window.location.href;
        const targetObj = new URL(targetUrl, window.location.origin);
        const activeObj = new URL(activeUrl, window.location.origin);

        // Normalize paths (removing trailing slash differences)
        const normPath = p => p.replace(/\/+$/, '') || '/';
        const isSamePath = normPath(targetObj.pathname) === normPath(activeObj.pathname) && 
                           targetObj.search === activeObj.search;

        // If target is on the exact same page with a hash
        if (isSamePath) {
            if (targetObj.hash) {
                const el = document.querySelector(targetObj.hash);
                if (el) {
                    el.scrollIntoView({ behavior: 'smooth' });
                }
            } else {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
            if (options.pushHistory !== false && targetObj.hash) {
                history.pushState(null, '', targetObj.href);
            }
            currentActiveUrl = targetUrl;
            return;
        }

        isTransitioning = true;
        startProgress();

        // Determine transition direction based on hierarchy depth:
        let direction = options.direction;
        if (!direction) {
            const activeDepth = getPageDepth(activeObj);
            const targetDepth = getPageDepth(targetObj);

            if (targetDepth > activeDepth) {
                direction = 'forward'; // Slide left into deeper view
            } else if (targetDepth < activeDepth) {
                direction = 'backward'; // Slide right back to parent view
            } else if (options.isPopState) {
                direction = 'backward';
            } else {
                direction = 'forward';
            }
        }

        const currentView = document.getElementById('app-page-view');
        if (!currentView) {
            window.location.href = targetUrl;
            return;
        }

        // Close mobile dropdown if open
        if (typeof window.toggleMobileMenu === 'function') {
            window.toggleMobileMenu(false);
        }

        // Phase 1: Slide Out current view
        currentView.classList.remove('slide-in-right', 'slide-in-left', 'slide-out-left', 'slide-out-right');
        currentView.classList.add(direction === 'forward' ? 'slide-out-left' : 'slide-out-right');

        // Always append fresh cache-busting timestamp param to ensure latest updates
        const fetchUrl = new URL(targetUrl, window.location.origin);
        fetchUrl.searchParams.set('_vts', Date.now());

        try {
            // Concurrent: wait minimum 240ms for slide-out animation, while live fetch runs
            const [_, response] = await Promise.all([
                new Promise(resolve => setTimeout(resolve, 240)),
                fetch(fetchUrl.toString(), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    cache: 'no-store'
                })
            ]);

            if (!response.ok) {
                throw new Error('HTTP ' + response.status);
            }

            const htmlText = await response.text();
            const parser = new DOMParser();
            const newDoc = parser.parseFromString(htmlText, 'text/html');

            const newPageView = newDoc.getElementById('app-page-view');
            if (!newPageView) {
                // Remove transition classes before navigating away to avoid dirty BFCache state
                currentView.classList.remove('slide-out-left', 'slide-out-right', 'slide-in-right', 'slide-in-left');
                currentView.style.opacity = '';
                currentView.style.transform = '';
                currentView.style.pointerEvents = '';
                window.location.href = targetUrl;
                return;
            }

            // Update document title
            if (newDoc.title) {
                document.title = newDoc.title;
            }

            // 1. Ensure all <link rel="stylesheet"> from newDoc are present in <head>
            newDoc.querySelectorAll('link[rel="stylesheet"]').forEach(link => {
                const href = link.getAttribute('href');
                if (href && !document.querySelector(`link[href="${href}"]`)) {
                    document.head.appendChild(link.cloneNode(true));
                }
            });

            // 2. Swap page-specific stylesheets so destination styles apply BEFORE rendering
            const pageStyleIds = ['vendio-home-styles', 'vendio-blog-styles', 'vendio-article-styles'];
            let incomingStyle = null;
            for (const sId of pageStyleIds) {
                const s = newDoc.getElementById(sId);
                if (s) {
                    incomingStyle = s;
                    break;
                }
            }

            if (incomingStyle) {
                // Remove previous page-specific styles to prevent conflicting rules
                pageStyleIds.forEach(sId => {
                    const oldEl = document.getElementById(sId);
                    if (oldEl) oldEl.remove();
                });
                document.head.appendChild(incomingStyle.cloneNode(true));
            } else {
                newDoc.querySelectorAll('style[id]').forEach(st => {
                    if (st.id && !document.getElementById(st.id)) {
                        document.head.appendChild(st.cloneNode(true));
                    }
                });
            }

            // 3. Swap Navbar if destination page has its own navbar (e.g. .article-nav vs .navbar-main)
            const newNavbar = newDoc.getElementById('navbar') || newDoc.querySelector('.article-nav');
            const curNavbar = document.getElementById('navbar') || document.querySelector('.article-nav');
            if (newNavbar && curNavbar) {
                curNavbar.replaceWith(newNavbar.cloneNode(true));
            }

            // 4. Replace page content
            currentView.innerHTML = newPageView.innerHTML;
            currentView.setAttribute('data-page', newPageView.getAttribute('data-page') || '');

            // Position scroll before slide in
            if (targetObj.hash) {
                const targetEl = document.querySelector(targetObj.hash);
                if (targetEl) {
                    targetEl.scrollIntoView({ behavior: 'instant' });
                } else {
                    window.scrollTo(0, 0);
                }
            } else {
                window.scrollTo(0, 0);
            }

            // Re-execute any inline scripts inside the new view & prime animations immediately
            executeViewScripts(currentView);
            initCurrentPageScripts();

            // Phase 2: Slide In new view
            currentView.classList.remove('slide-out-left', 'slide-out-right');
            currentView.classList.add(direction === 'forward' ? 'slide-in-right' : 'slide-in-left');

            // Update Browser Address Bar & History State
            if (options.pushHistory !== false) {
                history.pushState({ url: targetUrl, direction: direction }, newDoc.title, targetUrl);
            }
            currentActiveUrl = targetUrl;

            // Update Navbar Active State
            updateNavbarActive(targetUrl);

            // Complete progress bar
            endProgress();

            // Re-bind interactive components on new DOM once transition completes
            setTimeout(() => {
                currentView.classList.remove('slide-in-right', 'slide-in-left');
                initCurrentPageScripts();
                isTransitioning = false;
            }, 360);

        } catch (err) {
            console.error('Seamless transition failed, falling back to full navigation:', err);
            endProgress();
            if (currentView) {
                currentView.classList.remove('slide-out-left', 'slide-out-right', 'slide-in-right', 'slide-in-left');
                currentView.style.opacity = '';
                currentView.style.transform = '';
                currentView.style.pointerEvents = '';
            }
            window.location.href = targetUrl;
        }
    }

    // Intercept Internal Link Clicks
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (!link) return;

        // Ignore modified clicks (Ctrl, Cmd, middle click, etc.)
        if (e.ctrlKey || e.metaKey || e.shiftKey || e.altKey || e.button !== 0) return;
        if (link.target && link.target !== '_self') return;
        if (link.hasAttribute('download')) return;

        const href = link.getAttribute('href');
        if (!href || href.startsWith('javascript:') || href.startsWith('mailto:') || href.startsWith('tel:')) return;

        let url;
        try {
            url = new URL(link.href, window.location.origin);
        } catch (err) {
            return;
        }

        // Only handle internal domain links
        if (url.origin !== window.location.origin) return;

        // Let administrator pages load normally
        if (url.pathname.includes('/administrator')) return;

        // Check if target is home, landing sections, or blog
        const isLandingOrBlog = url.pathname.includes('/vendio-develop');
        if (!isLandingOrBlog) return;

        const currentView = document.getElementById('app-page-view');
        const isCurrentlyHome = currentView && currentView.getAttribute('data-page') === 'home';
        const isCurrentlyBlog = currentView && (currentView.getAttribute('data-page') === 'blog' || document.getElementById('blog-grid'));
        const isGoingToHome = !url.pathname.includes('/blog') && (!url.hash || url.hash === '#');

        // Check if this is a pagination click inside the blog page
        const isPaginationLink = link.closest('.pagination-wrap') || link.hasAttribute('data-ci-pagination-page');
        if (isPaginationLink && isCurrentlyBlog) {
            e.preventDefault();
            navigateBlogPagination(link.href, link);
            return;
        }

        // Check if this is a category chip click inside the blog page
        if (link.classList.contains('cat-chip') && isCurrentlyBlog) {
            e.preventDefault();
            const strip = link.closest('.category-filter-strip');
            if (strip) {
                strip.querySelectorAll('.cat-chip').forEach(c => c.classList.remove('active'));
                link.classList.add('active');
            }
            navigateBlogPagination(link.href, link);
            return;
        }

        // If clicking brand-logo on landing page, smooth scroll to top
        if (link.classList.contains('brand-logo') && isCurrentlyHome && isGoingToHome) {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
            return;
        }

        // In-page hash links (e.g. #feature on home, #heading-1 in blog detail)
        if (url.hash && url.pathname.replace(/\/+$/, '') === window.location.pathname.replace(/\/+$/, '')) {
            const targetEl = document.querySelector(url.hash);
            if (targetEl) {
                e.preventDefault();
                targetEl.scrollIntoView({ behavior: 'smooth' });
                history.replaceState(null, '', url.hash);
                return;
            }
        }

        // Full Page Transition between Home and Blog
        e.preventDefault();
        navigateTo(link.href);
    });

    // Intercept Blog Search Form Submission
    document.addEventListener('submit', function(e) {
        const form = e.target.closest('form');
        if (!form) return;

        const action = form.getAttribute('action') || window.location.href;
        let actionUrl;
        try {
            actionUrl = new URL(action, window.location.origin);
        } catch (err) {
            return;
        }

        // Intercept search submissions to blog
        if (actionUrl.pathname.includes('/blog')) {
            e.preventDefault();
            const formData = new FormData(form);
            const params = new URLSearchParams();
            for (const [key, value] of formData.entries()) {
                if (value.trim()) params.set(key, value);
            }
            const queryPart = params.toString() ? '?' + params.toString() : '';
            const targetSearchUrl = actionUrl.origin + actionUrl.pathname + queryPart;

            const currentView = document.getElementById('app-page-view');
            const isCurrentlyBlog = currentView && (currentView.getAttribute('data-page') === 'blog' || document.getElementById('blog-grid'));

            if (isCurrentlyBlog) {
                navigateBlogPagination(targetSearchUrl, null);
            } else {
                navigateTo(targetSearchUrl, { direction: 'forward' });
            }
        }
    });

    // Handle Browser Back / Forward buttons (popstate)
    window.addEventListener('popstate', function(e) {
        const targetUrl = window.location.href;
        let targetObj;
        try {
            targetObj = new URL(targetUrl, window.location.origin);
        } catch (err) {
            window.location.reload();
            return;
        }

        // Administrator pages use normal browser navigation
        if (targetObj.pathname.includes('/administrator')) {
            window.location.reload();
            return;
        }

        const currentView = document.getElementById('app-page-view');
        if (currentView) {
            currentView.classList.remove('slide-out-left', 'slide-out-right', 'slide-in-right', 'slide-in-left');
            currentView.style.opacity = '';
            currentView.style.transform = '';
            currentView.style.pointerEvents = '';
        }

        const activeUrl = currentActiveUrl || window.location.href;
        const activeObj = new URL(activeUrl, window.location.origin);

        const isCurrentlyBlogGrid = currentView && (currentView.getAttribute('data-page') === 'blog' || document.getElementById('blog-grid'));
        const isTargetBlogGrid = targetObj.pathname.includes('/blog') && !isArticleDetailPage(targetObj);

        // In-page pagination back/forward inside blog listing
        if (isCurrentlyBlogGrid && isTargetBlogGrid && (e.state?.isBlogPagination || activeObj.pathname.includes('/blog/index/') || targetObj.pathname.includes('/blog/index/'))) {
            isTransitioning = false;
            navigateBlogPagination(targetUrl, null, false);
            return;
        }

        isTransitioning = false;
        navigateTo(targetUrl, { pushHistory: false, isPopState: true });
    });

    // Reset any transition states if page is restored from BFCache (Back-Forward cache)
    window.addEventListener('pageshow', function(event) {
        currentActiveUrl = window.location.href;
        isTransitioning = false;
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
        endProgress();
        initCurrentPageScripts();
        if (typeof window.initBlogAnimations === 'function') {
            window.initBlogAnimations();
        }
    });

    // Passive scroll listener for navbar floating island and scrollspy
    window.addEventListener('scroll', function() {
        handleNavbarFloatingState();
        const currentView = document.getElementById('app-page-view');
        if (currentView && currentView.getAttribute('data-page') === 'home') {
            updateActiveNav();
        }
    }, { passive: true });

    // Initial load setup
    function onInitialLoad() {
        currentActiveUrl = window.location.href;
        initCurrentPageScripts();
    }

    if (document.readyState === 'loading') {
        window.addEventListener('DOMContentLoaded', onInitialLoad);
    } else {
        onInitialLoad();
    }

    // Expose API if needed globally
    window.VendioRouter = {
        navigateTo: navigateTo,
        navigatePagination: navigateBlogPagination,
        initScripts: initCurrentPageScripts
    };

})();
