/**
 * 3 to 5 Theme - Main JavaScript
 *
 * @package 3to5
 */

(function() {
    'use strict';

    /**
     * Mobile Navigation Toggle
     */
    function initMobileNav() {
        const toggle = document.querySelector('.menu-toggle');
        const nav = document.querySelector('.main-navigation');

        if (!toggle || !nav) return;

        toggle.addEventListener('click', function() {
            const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
            toggle.setAttribute('aria-expanded', !isExpanded);
            nav.classList.toggle('is-active');
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!nav.contains(e.target) && !toggle.contains(e.target)) {
                toggle.setAttribute('aria-expanded', 'false');
                nav.classList.remove('is-active');
            }
        });

        // Close menu when pressing Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && nav.classList.contains('is-active')) {
                toggle.setAttribute('aria-expanded', 'false');
                nav.classList.remove('is-active');
                toggle.focus();
            }
        });
    }

    /**
     * Smooth Scroll for Anchor Links
     */
    function initSmoothScroll() {
        const links = document.querySelectorAll('a[href^="#"]');

        links.forEach(function(link) {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');

                if (href === '#') return;

                const target = document.querySelector(href);
                if (!target) return;

                e.preventDefault();

                // Close mobile menu if open
                const nav = document.querySelector('.main-navigation');
                const toggle = document.querySelector('.menu-toggle');
                if (nav && nav.classList.contains('is-active')) {
                    nav.classList.remove('is-active');
                    toggle.setAttribute('aria-expanded', 'false');
                }

                // Calculate offset for fixed header
                const header = document.querySelector('.site-header');
                const headerHeight = header ? header.offsetHeight : 0;
                const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - headerHeight;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });

                // Update focus for accessibility
                target.setAttribute('tabindex', '-1');
                target.focus({ preventScroll: true });
            });
        });
    }

    /**
     * FAQ Accordion
     */
    function initFaqAccordion() {
        const faqItems = document.querySelectorAll('.faq-item');

        faqItems.forEach(function(item) {
            const question = item.querySelector('.faq-item__question');
            const answer = item.querySelector('.faq-item__answer');

            if (!question || !answer) return;

            question.addEventListener('click', function() {
                const isExpanded = this.getAttribute('aria-expanded') === 'true';

                // Close all other FAQ items
                faqItems.forEach(function(otherItem) {
                    if (otherItem !== item) {
                        otherItem.classList.remove('is-active');
                        const otherQuestion = otherItem.querySelector('.faq-item__question');
                        const otherAnswer = otherItem.querySelector('.faq-item__answer');
                        if (otherQuestion) otherQuestion.setAttribute('aria-expanded', 'false');
                        if (otherAnswer) otherAnswer.setAttribute('aria-hidden', 'true');
                    }
                });

                // Toggle current item
                item.classList.toggle('is-active');
                this.setAttribute('aria-expanded', !isExpanded);
                answer.setAttribute('aria-hidden', isExpanded);
            });
        });
    }

    /**
     * Header Scroll Effect
     */
    function initHeaderScroll() {
        const header = document.querySelector('.site-header');
        if (!header) return;

        let lastScroll = 0;

        window.addEventListener('scroll', function() {
            const currentScroll = window.pageYOffset;

            // Add shadow when scrolled
            if (currentScroll > 10) {
                header.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.15)';
            } else {
                header.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
            }

            lastScroll = currentScroll;
        }, { passive: true });
    }

    /**
     * Animate elements on scroll
     */
    function initScrollAnimations() {
        // Only run if IntersectionObserver is supported
        if (!('IntersectionObserver' in window)) return;

        const animatedElements = document.querySelectorAll('.reason-card, .action-step, .location-card');

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        animatedElements.forEach(function(el) {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
    }

    /**
     * Email Opt-in Modal
     */
    function initEmailModal() {
        const modal = document.getElementById('email-modal');
        if (!modal) return;

        const openButtons = document.querySelectorAll('[data-open-email-modal]');
        const closeButtons = document.querySelectorAll('[data-close-email-modal]');

        function openModal() {
            modal.classList.add('is-active');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';

            // Focus the close button for accessibility
            const closeBtn = modal.querySelector('.email-modal__close');
            if (closeBtn) {
                closeBtn.focus();
            }
        }

        function closeModal() {
            modal.classList.remove('is-active');
            modal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        // Open modal buttons
        openButtons.forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                openModal();
            });
        });

        // Close modal buttons and overlay
        closeButtons.forEach(function(btn) {
            btn.addEventListener('click', function() {
                closeModal();
            });
        });

        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.classList.contains('is-active')) {
                closeModal();
            }
        });

        // Trap focus inside modal when open
        modal.addEventListener('keydown', function(e) {
            if (e.key !== 'Tab') return;

            const focusableElements = modal.querySelectorAll(
                'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
            );
            const firstElement = focusableElements[0];
            const lastElement = focusableElements[focusableElements.length - 1];

            if (e.shiftKey) {
                if (document.activeElement === firstElement) {
                    lastElement.focus();
                    e.preventDefault();
                }
            } else {
                if (document.activeElement === lastElement) {
                    firstElement.focus();
                    e.preventDefault();
                }
            }
        });
    }

    /**
     * Quotes Carousel
     */
    function initQuotesCarousel() {
        const carousel = document.querySelector('.quotes__carousel');
        if (!carousel) return;

        const track = carousel.querySelector('.quotes__track');
        const nav = document.querySelector('.quotes__nav');
        if (!track) return;

        const prevBtn = nav ? nav.querySelector('.quotes__arrow--prev') : null;
        const nextBtn = nav ? nav.querySelector('.quotes__arrow--next') : null;
        const dotsContainer = nav ? nav.querySelector('.quotes__dots') : null;
        const totalQuotes = nav ? parseInt(nav.dataset.totalQuotes, 10) : 0;

        let currentDotCount = 0;

        // Check if mobile
        function isMobile() {
            return window.innerWidth <= 768;
        }

        // Get cards per page based on viewport
        function getCardsPerPage() {
            return isMobile() ? 1 : 2;
        }

        // Get card width including gap
        function getScrollAmount() {
            const card = track.querySelector('.quote-card');
            if (!card) return 0;
            const style = getComputedStyle(track);
            const gap = parseFloat(style.gap) || 16;
            return (card.offsetWidth + gap) * getCardsPerPage();
        }

        // Get total pages
        function getTotalPages() {
            return Math.ceil(totalQuotes / getCardsPerPage());
        }

        // Get current page based on scroll position
        function getCurrentPage() {
            const scrollAmount = getScrollAmount();
            if (scrollAmount === 0) return 0;
            return Math.round(track.scrollLeft / scrollAmount);
        }

        // Generate dots based on viewport
        function generateDots() {
            if (!dotsContainer) return;

            const totalPages = getTotalPages();
            if (totalPages === currentDotCount) return; // No change needed

            currentDotCount = totalPages;
            dotsContainer.innerHTML = '';

            for (let i = 0; i < totalPages; i++) {
                const dot = document.createElement('button');
                dot.type = 'button';
                dot.className = 'quotes__dot' + (i === 0 ? ' is-active' : '');
                dot.dataset.page = i;
                dot.setAttribute('aria-label', 'Go to page ' + (i + 1));
                dot.addEventListener('click', function() {
                    scrollToPage(parseInt(this.dataset.page, 10));
                });
                dotsContainer.appendChild(dot);
            }
        }

        // Update active dot and button states
        function updateState() {
            const currentPage = getCurrentPage();
            const maxScroll = track.scrollWidth - track.clientWidth;

            // Update dots
            const dots = dotsContainer ? dotsContainer.querySelectorAll('.quotes__dot') : [];
            dots.forEach(function(dot, index) {
                dot.classList.toggle('is-active', index === currentPage);
            });

            // Update button states
            if (prevBtn) {
                prevBtn.disabled = track.scrollLeft <= 0;
            }
            if (nextBtn) {
                const dots = dotsContainer ? dotsContainer.querySelectorAll('.quotes__dot') : [];
                nextBtn.disabled = track.scrollLeft >= maxScroll - 5; // 5px tolerance
            }
        }

        // Scroll to specific page
        function scrollToPage(page) {
            const scrollAmount = getScrollAmount();
            track.scrollTo({
                left: page * scrollAmount,
                behavior: 'smooth'
            });
        }

        // Previous button
        if (prevBtn) {
            prevBtn.addEventListener('click', function() {
                const currentPage = getCurrentPage();
                if (currentPage > 0) {
                    scrollToPage(currentPage - 1);
                }
            });
        }

        // Next button
        if (nextBtn) {
            nextBtn.addEventListener('click', function() {
                const currentPage = getCurrentPage();
                const maxPage = getTotalPages() - 1;
                if (currentPage < maxPage) {
                    scrollToPage(currentPage + 1);
                }
            });
        }

        // Update state on scroll
        let scrollTimeout;
        track.addEventListener('scroll', function() {
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(updateState, 50);
        }, { passive: true });

        // Update on resize (regenerate dots if needed)
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                generateDots();
                updateState();
            }, 100);
        }, { passive: true });

        // Initial setup
        generateDots();
        updateState();
    }

    /**
     * Initialize all components
     */
    function init() {
        initMobileNav();
        initSmoothScroll();
        initFaqAccordion();
        initHeaderScroll();
        initScrollAnimations();
        initEmailModal();
        initQuotesCarousel();
    }

    // Run on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
