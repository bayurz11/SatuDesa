<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Desa Mentuda')</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Swiper CSS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
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
    </style>
    @stack('styles')
</head>

<body class="bg-gray-50 flex flex-col min-h-screen" id="top">

    @include('layouts.nav')

    <main class="flex-grow">
        <div class="absolute top-0 left-0 w-32 h-32 bg-green-100 rounded-full blur-3xl opacity-40"></div>
        <div class="absolute bottom-0 right-0 w-40 h-40 bg-yellow-100 rounded-full blur-2xl opacity-40"></div>
        @yield('content')
    </main>

    <!-- Back to top Floating Button -->
    <button id="backToTop" type="button" aria-label="Kembali ke atas"
        class="fixed bottom-6 right-6 z-50 rounded-full bg-green-600 text-white shadow-lg ring-1 ring-black/5
               p-3 md:p-3.5 hover:bg-green-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-300
               opacity-0 scale-90 pointer-events-none transition duration-300">

        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 19.5V4.5m0 0l-6 6m6-6l6 6" />
        </svg>
    </button>


    @include('layouts.footer')


    <script>
        const navbar = document.getElementById("navbar");

        if (window.location.pathname === "/") {

            let lastScroll = 0;

            window.addEventListener("scroll", () => {
                let currentScroll = window.scrollY;

                if (currentScroll > 50) {
                    navbar.classList.remove("-translate-y-full");
                    navbar.classList.add("translate-y-0");
                } else {
                    navbar.classList.add("-translate-y-full");
                    navbar.classList.remove("translate-y-0");
                }
                lastScroll = currentScroll;
            });
        } else {
            // Halaman lain 
            navbar.classList.remove("-translate-y-full");
            navbar.classList.add("translate-y-0");
        }

        // Toggle Menu Mobile 
        const menuBtn = document.getElementById("menu-btn");
        const menu = document.getElementById("menu");

        if (menuBtn) {
            menuBtn.addEventListener("click", () => {
                menu.classList.toggle("hidden");
                menu.classList.toggle("flex");
            });
        }

        // Efek Count Up
        document.addEventListener("DOMContentLoaded", () => {
            const counters = document.querySelectorAll(".counter");

            counters.forEach(counter => {
                const target = +counter.getAttribute("data-target");
                const updateCount = () => {
                    const current = +counter.innerText.replace(/\D/g, "");
                    const increment = Math.ceil(target / 150);
                    if (current < target) {
                        counter.innerText = current + increment > target ? target : current + increment;
                        setTimeout(updateCount, 20);
                    } else {
                        counter.innerText = target;
                    }
                };
                updateCount();
            });
        });

        // Swiper.js Initialization
        var swiper = new Swiper(".mySwiper", {
            loop: true,
            autoHeight: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            grabCursor: true,
            slidesPerView: 1,
            spaceBetween: 20,
            breakpoints: {
                600: {
                    slidesPerView: 3
                },
                1024: {
                    slidesPerView: 4
                },
            },
        });
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
        });
        // Back to Top Button
        (() => {
            const btn = document.getElementById('backToTop');
            if (!btn) return;

            const showAfter = 400;
            let visible = false;

            const onScroll = () => {
                if (window.scrollY > showAfter && !visible) {
                    visible = true;
                    btn.classList.remove('opacity-0', 'scale-90', 'pointer-events-none');
                } else if (window.scrollY <= showAfter && visible) {
                    visible = false;
                    btn.classList.add('opacity-0', 'scale-90', 'pointer-events-none');
                }
            };
            window.addEventListener('scroll', onScroll, {
                passive: true
            });
            onScroll();

            const easeInOutCubic = t => t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;

            const scrollToTop = (duration = 600) => {

                const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                if (reduce) {
                    window.scrollTo({
                        top: 0
                    });
                    return;
                }

                const start = performance.now();
                const from = window.scrollY;

                const step = (now) => {
                    const elapsed = now - start;
                    const p = Math.min(1, elapsed / duration);
                    const eased = easeInOutCubic(p);
                    window.scrollTo(0, Math.floor(from * (1 - eased)));
                    if (p < 1) requestAnimationFrame(step);
                };
                requestAnimationFrame(step);
            };

            btn.addEventListener('click', (e) => {
                e.preventDefault();
                scrollToTop(700);
            });


            window.addEventListener('keydown', (e) => {
                if ((e.key === 'Home' || (e.key === 'ArrowUp' && (e.ctrlKey || e.metaKey)))) {
                    e.preventDefault();
                    scrollToTop(700);
                }
            });
        })();
    </script>

    <!-- Alpine.js (CDN) -->
    <script src="https://unpkg.com/alpinejs" defer></script>

    <!-- Swiper.js CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @stack('scripts')
</body>

</html>
