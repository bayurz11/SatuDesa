<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SatuDesa') }}</title>
    <meta name="title" content="Desa Mentuda | Website Resmi Desa Mentuda Kabupaten Lingga">
    <meta name="description"
        content="Website resmi Desa Mentuda, Kecamatan Lingga, Kabupaten Lingga. Informasi profil desa, berita, pengumuman, layanan publik, UMKM, potensi desa, APBDesa, data penduduk, dan galeri desa.">
    <meta name="keywords"
        content="Desa Mentuda, Website Desa Mentuda, Desa Mentuda Lingga, Kecamatan Lingga, Kabupaten Lingga, Kepulauan Riau, berita desa, pengumuman desa, layanan desa, UMKM Desa Mentuda, potensi desa, APBDesa Mentuda">
    <meta name="author" content="Pemerintah Desa Mentuda">
    <meta name="publisher" content="Pemerintah Desa Mentuda">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    <meta property="og:type" content="website">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="Desa Mentuda">
    <meta property="og:title" content="Desa Mentuda | Website Resmi Desa Mentuda Kabupaten Lingga">
    <meta property="og:description"
        content="Portal informasi resmi Desa Mentuda: profil desa, berita, pengumuman, layanan publik, UMKM, potensi desa, APBDesa, dan galeri.">
    <meta property="og:url" content="{{ url()->current() }}">
    <!-- Swiper CSS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "GovernmentOrganization",
    "name": "Pemerintah Desa Mentuda",
    "alternateName": "Desa Mentuda",
    "url": "{{ url('/') }}",
    "description": "Website resmi Desa Mentuda, Kecamatan Lingga, Kabupaten Lingga, Kepulauan Riau.",
    "address": {
        "@@type": "PostalAddress",
        "streetAddress": "Jl. Raya Desa Mentuda",
        "addressLocality": "Desa Mentuda",
        "addressRegion": "Kepulauan Riau",
        "addressCountry": "ID"
    }
}

</script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes bounceHigh {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(146%);
            }
        }

        .typing {
            overflow: hidden;

            border-right: 0.10em solid #327020;

            white-space: nowrap;

            display: inline-block;
            animation: typingLoop 6s steps(12, end) infinite;

        }


        @keyframes typingLoop {
            0% {
                width: 0;
                border-color: #327020;
            }


            50% {
                width: 12ch;
                border-color: #327020;
            }


            60% {
                border-color: transparent;
            }

            100% {
                width: 0;
                border-color: transparent;
            }

        }

        /* Efek kursor*/
        .typing::after {
            content: '';
            border-right: 0.10em solid #327020;
            animation: blink 0.75s step-end infinite;
        }

        @keyframes blink {
            50% {
                border-color: transparent;
            }
        }

        [x-cloak] {
            display: none !important;
        }

        @keyframes fadeUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-up {
            opacity: 0;
            animation: fadeUp 0.8s ease-out forwards;
        }

        /* Saat tombol expanded=true, putar chevron 180deg */
        [data-acc-btn][aria-expanded="true"] [data-chev] {
            transform: rotate(180deg);
        }

        /* (Opsional) kurangi animasi untuk pengguna reduce motion */
        @media (prefers-reduced-motion: reduce) {
            [data-chev] {
                transition: none !important;
            }
        }
    </style>
</head>

<body class="bg-gray-50 flex min-h-screen flex-col antialiased overflow-x-hidden" id="top">
    @include('pages.public.partials.main-nav')

    <main class="flex-grow">
        <div class="absolute top-0 left-0 w-32 h-32 bg-green-100 rounded-full blur-3xl opacity-40"></div>
        <div class="absolute bottom-0 right-0 w-40 h-40 bg-yellow-100 rounded-full blur-2xl opacity-40"></div>
        @yield('content')
    </main>

    <div class="fixed bottom-6 right-6 z-50 flex flex-col gap-3">
        <a href="https://wa.me/6281234567890" target="_blank" aria-label="WhatsApp"
            class="group relative rounded-full bg-green-600 text-white shadow-lg ring-1 ring-black/5
           p-3 md:p-3.5 hover:bg-green-700 focus:outline-none
           focus-visible:ring-2 focus-visible:ring-green-300
           opacity-0 scale-90 pointer-events-none transition-all duration-300">
            <span
                class="absolute inset-0 rounded-full bg-white/20 scale-0 group-hover:scale-100 transition-transform duration-500"></span>

            <svg xmlns="http://www.w3.org/2000/svg"
                class="relative z-10 h-6 w-6 transition-transform duration-300 group-hover:rotate-12 group-hover:scale-110"
                viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M20.52 3.48A11.86 11.86 0 0 0 12.07 0C5.49 0 .15 5.34.15 11.92c0 2.1.55 4.15 1.6 5.96L0 24l6.28-1.65a11.88 11.88 0 0 0 5.79 1.48h.01c6.58 0 11.92-5.34 11.92-11.92 0-3.18-1.24-6.17-3.48-8.43ZM12.08 21.8h-.01a9.87 9.87 0 0 1-5.04-1.38l-.36-.21-3.72.98.99-3.63-.23-.37a9.86 9.86 0 0 1-1.51-5.27c0-5.45 4.43-9.88 9.88-9.88 2.64 0 5.12 1.03 6.98 2.9a9.8 9.8 0 0 1 2.89 6.98c0 5.45-4.43 9.88-9.87 9.88Zm5.42-7.4c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.47-.89-.79-1.49-1.76-1.66-2.06-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.18.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48s1.07 2.88 1.22 3.08c.15.2 2.1 3.2 5.08 4.48.71.31 1.26.49 1.69.63.71.23 1.36.2 1.87.12.57-.08 1.76-.72 2.01-1.42.25-.7.25-1.3.17-1.42-.07-.13-.27-.2-.57-.35Z" />
            </svg>

            <span
                class="absolute right-14 top-1/2 -translate-y-1/2 whitespace-nowrap rounded-lg bg-gray-900 px-3 py-1.5 text-xs font-semibold text-white opacity-0 transition-all duration-300 group-hover:opacity-100 group-hover:right-16">
                Hubungi kami untuk informasi lebih lanjut
            </span>
        </a>

        <button id="backToTop" type="button" aria-label="Kembali ke atas"
            class="group relative rounded-full bg-green-600 text-white shadow-lg ring-1 ring-black/5
           p-3 md:p-3.5 hover:bg-green-700 focus:outline-none
           focus-visible:ring-2 focus-visible:ring-yellow-300
           opacity-0 scale-90 pointer-events-none transition-all duration-300">
            <span
                class="absolute inset-0 rounded-full bg-white/20 scale-0 group-hover:scale-100 transition-transform duration-500"></span>

            <svg xmlns="http://www.w3.org/2000/svg"
                class="relative z-10 h-5 w-5 md:h-6 md:w-6 transition-transform duration-300 group-hover:-translate-y-1"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M12 19.5V4.5m0 0l-6 6m6-6l6 6" />
            </svg>
        </button>
    </div>

    @include('pages.public.partials.footer')

    <script>
        const navbar = document.getElementById('navbar');

        if (navbar) {
            if (window.location.pathname === '/') {
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 50) {
                        navbar.classList.remove('-translate-y-full');
                        navbar.classList.add('translate-y-0');
                    } else {
                        navbar.classList.add('-translate-y-full');
                        navbar.classList.remove('translate-y-0');
                    }
                });
            } else {
                navbar.classList.remove('-translate-y-full');
                navbar.classList.add('translate-y-0');
            }
        }

        (() => {
            const menuBtn = document.getElementById('menu-btn');
            const menuClose = document.getElementById('menu-close');
            const overlay = document.getElementById('overlay');
            const panel = document.getElementById('mobile-menu');
            const accBtns = document.querySelectorAll('[data-acc-btn]');
            const accPanels = document.querySelectorAll('[data-acc-panel]');
            const chevIcons = document.querySelectorAll('[data-chev]');
            let lastFocused = null;

            if (!menuBtn || !panel || !overlay) {
                return;
            }

            const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const openDuration = prefersReduced ? 0 : 200;

            const setAria = (expanded) => {
                menuBtn.setAttribute('aria-expanded', String(expanded));
                panel.setAttribute('aria-hidden', String(!expanded));
                overlay.setAttribute('aria-hidden', String(!expanded));
            };

            const trapFocus = (e) => {
                if (panel.classList.contains('pointer-events-none')) return;
                const focusables = panel.querySelectorAll('a, button, [tabindex]:not([tabindex="-1"])');
                if (!focusables.length) return;

                const first = focusables[0];
                const last = focusables[focusables.length - 1];

                if (e.key === 'Tab') {
                    if (e.shiftKey && document.activeElement === first) {
                        e.preventDefault();
                        last.focus();
                    } else if (!e.shiftKey && document.activeElement === last) {
                        e.preventDefault();
                        first.focus();
                    }
                }
            };

            const openMenu = () => {
                lastFocused = document.activeElement;
                document.body.classList.add('overflow-hidden');
                panel.classList.remove('pointer-events-none', 'opacity-0');
                overlay.classList.remove('pointer-events-none', 'opacity-0');
                panel.style.transform = 'translateY(0)';
                setAria(true);

                const focusTarget = panel.querySelector('#menu-close') || panel.querySelector('a,button');
                setTimeout(() => focusTarget?.focus(), 10);
                document.addEventListener('keydown', trapFocus);
            };

            const closeMenu = () => {
                document.body.classList.remove('overflow-hidden');
                panel.classList.add('opacity-0');
                overlay.classList.add('opacity-0');
                panel.style.transform = 'translateY(-12px)';

                setTimeout(() => {
                    panel.classList.add('pointer-events-none');
                    overlay.classList.add('pointer-events-none');
                }, openDuration);

                setAria(false);
                accBtns.forEach((button) => button.setAttribute('aria-expanded', 'false'));
                accPanels.forEach((accPanel) => accPanel.style.maxHeight = 0);
                chevIcons.forEach((icon) => icon.dataset.open = 'false');
                document.removeEventListener('keydown', trapFocus);
                lastFocused?.focus();
            };

            menuBtn.addEventListener('click', () => {
                const expanded = menuBtn.getAttribute('aria-expanded') === 'true';
                expanded ? closeMenu() : openMenu();
            });

            menuClose?.addEventListener('click', closeMenu);
            overlay.addEventListener('click', closeMenu);

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeMenu();
            });

            document.addEventListener('mousedown', (e) => {
                if (panel.classList.contains('pointer-events-none')) return;
                const within = panel.contains(e.target) || menuBtn.contains(e.target);
                if (!within) closeMenu();
            });

            accBtns.forEach((button) => {
                const panelId = button.getAttribute('aria-controls');
                const accPanel = document.getElementById(panelId);
                button.addEventListener('click', () => {
                    const isOpen = button.getAttribute('aria-expanded') === 'true';
                    accBtns.forEach((item) => item.setAttribute('aria-expanded', 'false'));
                    accPanels.forEach((item) => item.style.maxHeight = 0);
                    chevIcons.forEach((item) => item.dataset.open = 'false');

                    if (!isOpen && accPanel) {
                        button.setAttribute('aria-expanded', 'true');
                        accPanel.style.maxHeight = accPanel.scrollHeight + 'px';
                    }
                });
            });
        })();

        (() => {
            const btn = document.getElementById('backToTop');
            const waBtn = document.querySelector('a[aria-label="WhatsApp"]');
            if (!btn) return;

            const showAfter = 400;
            let visible = false;

            const onScroll = () => {
                if (window.scrollY > showAfter && !visible) {
                    visible = true;
                    btn.classList.remove('opacity-0', 'scale-90', 'pointer-events-none');
                    btn.classList.add('opacity-100', 'scale-100');
                    waBtn?.classList.remove('opacity-0', 'scale-90', 'pointer-events-none');
                    waBtn?.classList.add('opacity-100', 'scale-100');
                } else if (window.scrollY <= showAfter && visible) {
                    visible = false;
                    btn.classList.add('opacity-0', 'scale-90', 'pointer-events-none');
                    btn.classList.remove('opacity-100', 'scale-100');
                    waBtn?.classList.add('opacity-0', 'scale-90', 'pointer-events-none');
                    waBtn?.classList.remove('opacity-100', 'scale-100');
                }
            };

            window.addEventListener('scroll', onScroll, {
                passive: true
            });
            onScroll();

            btn.addEventListener('click', (e) => {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth',
                });
            });
        })();

        const currentYear = document.getElementById('currentYear');
        if (currentYear) {
            currentYear.textContent = new Date().getFullYear();
        }

        window.addEventListener('load', () => {
            if (typeof AOS === 'undefined') {
                return;
            }

            AOS.init({
                duration: 700,
                easing: 'ease-out-cubic',
                once: true,
                offset: 80,
            });

            AOS.refresh();
        });
    </script>

    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    @stack('scripts')
</body>

</html>
