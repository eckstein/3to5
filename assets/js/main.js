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
     * Initialize all components
     */
    function init() {
        initMobileNav();
        initSmoothScroll();
        initFaqAccordion();
        initHeaderScroll();
        initScrollAnimations();
    }

    // Run on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
