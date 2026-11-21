(function () {
    'use strict';

    window.appReady = true;

    /* ---------------------------------------------------------------
       Mobile navigation
       --------------------------------------------------------------- */
    var nav = document.querySelector('[data-globalnav]');
    var toggle = document.querySelector('[data-globalnav-toggle]');
    var desktop = window.matchMedia('(min-width: 834px)');

    function setMenu(open) {
        if (!nav || !toggle) return;
        nav.classList.toggle('is-open', open);
        document.body.classList.toggle('nav-open', open);
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
    }

    if (toggle) {
        toggle.addEventListener('click', function () {
            setMenu(!nav.classList.contains('is-open'));
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && nav.classList.contains('is-open')) {
                setMenu(false);
                toggle.focus();
            }
        });

        var onChange = function (event) {
            if (event.matches) setMenu(false);
        };

        if (desktop.addEventListener) {
            desktop.addEventListener('change', onChange);
        } else if (desktop.addListener) {
            desktop.addListener(onChange);
        }
    }

    /* ---------------------------------------------------------------
       Scroll reveal
       --------------------------------------------------------------- */
    var items = document.querySelectorAll('[data-reveal]');

    function showAll() {
        for (var i = 0; i < items.length; i++) {
            items[i].classList.add('is-visible');
        }
    }

    if (!('IntersectionObserver' in window)) {
        showAll();
    } else {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { rootMargin: '0px 0px -8% 0px', threshold: 0.12 });

        for (var j = 0; j < items.length; j++) {
            observer.observe(items[j]);
        }
    }

    /* ---------------------------------------------------------------
       Confirm before archiving a task
       --------------------------------------------------------------- */
    document.addEventListener('submit', function (event) {
        var form = event.target;
        var message = form.getAttribute('data-confirm');

        if (message && !window.confirm(message)) {
            event.preventDefault();
        }
    });

    /* ---------------------------------------------------------------
       Flash ribbon fades out after a few seconds
       --------------------------------------------------------------- */
    var ribbon = document.querySelector('.ribbon:not(.ribbon--error)');

    if (ribbon) {
        setTimeout(function () {
            ribbon.style.transition = 'opacity .6s ease, margin-top .6s ease';
            ribbon.style.opacity = '0';
            ribbon.style.marginTop = '-' + ribbon.offsetHeight + 'px';
        }, 4000);
    }
})();
