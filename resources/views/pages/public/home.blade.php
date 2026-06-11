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
    <link rel="icon" href="{{ asset('favicon-16x16.png') }}" sizes="any">
    <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">

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

<body class="bg-gray-50 flex flex-col min-h-screen antialiased overflow-x-hidden" id="top">
    @include('pages.public.partials.main-nav')

    <main class="flex-grow">
        <div class="absolute top-0 left-0 w-32 h-32 bg-green-100 rounded-full blur-3xl opacity-40"></div>
        <div class="absolute bottom-0 right-0 w-40 h-40 bg-yellow-100 rounded-full blur-2xl opacity-40"></div>

        @include('pages.public.partials.header')

        <!-- Population Administration Section -->
        <section class="max-w-6xl mx-auto px-4 py-12" data-aos="fade-up">
            <!-- Header -->
            <header class="mx-auto mb-12 max-w-3xl text-center">

                <span
                    class="mb-4 inline-flex items-center gap-2 rounded-full bg-green-100 px-4 py-1.5 text-xs font-semibold text-green-700 ring-1 ring-green-200 transition-all duration-300 hover:bg-green-700 hover:text-white hover:shadow-lg">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke="currentColor" class="w-4 h-4 transition-transform duration-300 group-hover:rotate-12">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                    </svg>

                    Data Kependudukan Desa

                </span>

                <h2 class="text-2xl font-bold tracking-tight text-gray-900 md:text-3xl">
                    Administrasi
                    <span class="text-green-700">Penduduk</span>
                </h2>

                <p class="mt-5 text-sm leading-relaxed text-gray-600 md:text-base">
                    Menyajikan ringkasan administrasi dan statistik kependudukan desa berdasarkan data
                    penduduk yang dikelola dari panel admin, sehingga informasi publik tetap relevan,
                    ringkas, dan mudah dipantau warga.
                </p>

            </header>

            <!-- Statistik -->
            <div class="grid grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4 lg:gap-5 mt-10" data-aos="fade-up"
                data-aos-delay="300">

                <!-- Total Penduduk -->
                <div
                    class="group relative overflow-hidden bg-green-700 rounded-2xl shadow-md p-3 sm:p-4 min-h-[105px] flex flex-col items-center justify-center text-center hover:-translate-y-1 hover:bg-green-800 hover:shadow-xl active:scale-95 transition-all duration-300">

                    <span
                        class="absolute -left-10 top-0 h-full w-8 rotate-12 bg-white/20 blur-md transition-all duration-700 group-hover:left-[120%]"></span>

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="relative z-10 w-7 h-7 sm:w-8 sm:h-8 text-white mb-2 transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1 group-hover:rotate-6"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                    </svg>

                    <p class="relative z-10 counter text-lg sm:text-xl md:text-2xl font-bold text-white"
                        data-target="{{ $totalCitizens }}">0</p>
                    <span class="relative z-10 mt-1 text-[10px] sm:text-xs text-white/80 leading-tight">
                        Total Penduduk
                    </span>
                </div>

                <!-- Kartu Keluarga -->
                <div
                    class="group relative overflow-hidden bg-green-700 rounded-2xl shadow-md p-3 sm:p-4 min-h-[105px] flex flex-col items-center justify-center text-center hover:-translate-y-1 hover:bg-green-800 hover:shadow-xl active:scale-95 transition-all duration-300">

                    <span
                        class="absolute -left-10 top-0 h-full w-8 rotate-12 bg-white/20 blur-md transition-all duration-700 group-hover:left-[120%]"></span>

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="relative z-10 w-7 h-7 sm:w-8 sm:h-8 text-white mb-2 transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1 group-hover:-rotate-6"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205 3 1m1.5.5-1.5-.5M6.75 7.364V3h-3v18m3-13.636 10.5-3.819" />
                    </svg>

                    <p class="relative z-10 counter text-lg sm:text-xl md:text-2xl font-bold text-white"
                        data-target="{{ $totalHouseholds }}">0</p>
                    <span class="relative z-10 mt-1 text-[10px] sm:text-xs text-white/80 leading-tight">
                        Kartu Keluarga
                    </span>
                </div>

                <!-- Laki-Laki -->
                <div
                    class="group relative overflow-hidden bg-green-700 rounded-2xl shadow-md p-3 sm:p-4 min-h-[105px] flex flex-col items-center justify-center text-center hover:-translate-y-1 hover:bg-green-800 hover:shadow-xl active:scale-95 transition-all duration-300">

                    <span
                        class="absolute -left-10 top-0 h-full w-8 rotate-12 bg-white/20 blur-md transition-all duration-700 group-hover:left-[120%]"></span>

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="relative z-10 w-7 h-7 sm:w-8 sm:h-8 text-white mb-2 transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1 group-hover:rotate-6"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>

                    <p class="relative z-10 counter text-lg sm:text-xl md:text-2xl font-bold text-white"
                        data-target="{{ $maleCitizens }}">0</p>
                    <span class="relative z-10 mt-1 text-[10px] sm:text-xs text-white/80 leading-tight">
                        Laki-Laki
                    </span>
                </div>

                <!-- Perempuan -->
                <div
                    class="group relative overflow-hidden bg-green-700 rounded-2xl shadow-md p-3 sm:p-4 min-h-[105px] flex flex-col items-center justify-center text-center hover:-translate-y-1 hover:bg-green-800 hover:shadow-xl active:scale-95 transition-all duration-300">

                    <span
                        class="absolute -left-10 top-0 h-full w-8 rotate-12 bg-white/20 blur-md transition-all duration-700 group-hover:left-[120%]"></span>

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="relative z-10 w-7 h-7 sm:w-8 sm:h-8 text-white mb-2 transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1 group-hover:-rotate-6"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>

                    <p class="relative z-10 counter text-lg sm:text-xl md:text-2xl font-bold text-white"
                        data-target="{{ $femaleCitizens }}">0</p>
                    <span class="relative z-10 mt-1 text-[10px] sm:text-xs text-white/80 leading-tight">
                        Perempuan
                    </span>
                </div>

                <!-- Dusun -->
                <div
                    class="group relative overflow-hidden bg-green-700 rounded-2xl shadow-md p-3 sm:p-4 min-h-[105px] flex flex-col items-center justify-center text-center hover:-translate-y-1 hover:bg-green-800 hover:shadow-xl active:scale-95 transition-all duration-300">

                    <span
                        class="absolute -left-10 top-0 h-full w-8 rotate-12 bg-white/20 blur-md transition-all duration-700 group-hover:left-[120%]"></span>

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="relative z-10 w-7 h-7 sm:w-8 sm:h-8 text-white mb-2 transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1 group-hover:rotate-6"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>

                    <p class="relative z-10 counter text-lg sm:text-xl md:text-2xl font-bold text-white"
                        data-target="{{ $totalHamlets }}">0</p>
                    <span class="relative z-10 mt-1 text-[10px] sm:text-xs text-white/80 leading-tight">
                        Dusun Terdata
                    </span>
                </div>

                <!-- Penduduk Aktif -->
                <div
                    class="group relative overflow-hidden bg-green-700 rounded-2xl shadow-md p-3 sm:p-4 min-h-[105px] flex flex-col items-center justify-center text-center hover:-translate-y-1 hover:bg-green-800 hover:shadow-xl active:scale-95 transition-all duration-300">

                    <span
                        class="absolute -left-10 top-0 h-full w-8 rotate-12 bg-white/20 blur-md transition-all duration-700 group-hover:left-[120%]"></span>

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="relative z-10 w-7 h-7 sm:w-8 sm:h-8 text-white mb-2 transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1 group-hover:rotate-6"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M22 10.5h-6m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM4 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 10.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                    </svg>

                    <p class="relative z-10 counter text-lg sm:text-xl md:text-2xl font-bold text-white"
                        data-target="{{ $activeCitizens }}">0</p>
                    <span class="relative z-10 mt-1 text-[10px] sm:text-xs text-white/80 leading-tight">
                        Penduduk Aktif
                    </span>
                </div>

            </div>

            <div class="mt-8 flex justify-center" data-aos="fade-up" data-aos-delay="350">
                <a href="{{ route('public.population.index') }}"
                    class="group inline-flex items-center gap-2 rounded-full border border-green-200 bg-white px-5 py-3 text-sm font-semibold text-green-700 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-green-700 hover:bg-green-700 hover:text-white hover:shadow-lg">
                    <span>Lihat Statistik Penduduk Lengkap</span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>
        </section>

        <!-- Potensi Desa Section -->
        <section class="relative overflow-hidden bg-gradient-to-b from-gray-50 via-white to-green-50 px-4 py-15"
            data-aos="fade-up" data-aos-delay="300">

            <div class="relative mx-auto max-w-7xl">

                <!-- Header -->
                <header class="mx-auto mb-12 max-w-3xl text-center">
                    <span
                        class="mb-4 inline-flex items-center gap-2 rounded-full bg-green-100 px-4 py-1.5 text-xs font-semibold text-green-700 ring-1 ring-green-200 transition-all duration-300 hover:bg-green-700 hover:text-white hover:shadow-lg">
                        <span>✨</span>
                        Potensi Unggulan Desa
                    </span>

                    <h2 class="text-2xl font-bold tracking-tight text-gray-900 md:text-3xl">
                        Jelajahi Potensi
                        <span class="text-green-700">Desa Mentuda</span>
                    </h2>

                    <p class="mt-5 text-sm leading-relaxed text-gray-600 md:text-base">
                        Temukan potensi alam, budaya, UMKM, pertanian, perikanan, dan lingkungan yang menjadi kekuatan
                        Desa
                        Mentuda untuk mendukung kesejahteraan masyarakat.
                    </p>
                </header>

                <!-- Featured Card -->
                <article
                    class="group relative mb-8 overflow-hidden rounded-[2rem] bg-white shadow-xl ring-1 ring-gray-100 transition-all duration-500 hover:-translate-y-1 hover:shadow-2xl hover:ring-green-200 lg:grid lg:grid-cols-12">

                    <span
                        class="pointer-events-none absolute -left-24 top-0 z-20 h-full w-16 rotate-12 bg-white/30 blur-xl transition-all duration-1000 group-hover:left-[120%]">
                    </span>

                    <a href="{{ route('public.potentials.index') }}"
                        class="relative min-h-[320px] overflow-hidden lg:col-span-7 lg:min-h-[460px] block">
                        <img src="{{ $homeFeaturedPotential?->cover_image_url ?: asset('public/img/bg.jpg') }}"
                            alt="{{ $homeFeaturedPotential?->cover_image_alt ?: ($homeFeaturedPotential?->title ?: 'Potensi Desa Mentuda') }}"
                            class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-110">

                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/45 to-black/10 transition-all duration-500 group-hover:from-black/95 group-hover:via-black/50">
                        </div>

                        <div class="absolute left-6 right-6 bottom-6 text-white md:left-8 md:right-8 md:bottom-8">
                            <span
                                class="inline-flex items-center gap-2 rounded-full bg-white/20 px-3 py-1.5 text-xs font-semibold text-white backdrop-blur ring-1 ring-white/30 transition-all duration-300 group-hover:-translate-y-1 group-hover:bg-green-600 group-hover:shadow-lg">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.8" stroke="currentColor"
                                    class="w-4 h-4 transition-all duration-300 group-hover:scale-110 group-hover:rotate-12">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>

                                <span>{{ $homeFeaturedPotential?->location_name ?: ($homeFeaturedPotential?->village?->name ?: 'Desa Mentuda') }}</span>

                            </span>

                            <h3
                                class="mt-4 text-2xl font-bold leading-tight md:text-4xl transition-all duration-300 group-hover:translate-x-1">
                                {{ $homeFeaturedPotential?->title ?: 'Potensi Lokal yang Siap Dikembangkan' }}
                            </h3>

                            <p class="mt-3 max-w-2xl text-sm leading-relaxed text-white/85">
                                {{ \Illuminate\Support\Str::limit(strip_tags($homeFeaturedPotential?->excerpt ?: 'Desa Mentuda memiliki kekayaan alam, budaya, ekonomi, dan lingkungan yang dapat menjadi daya tarik serta peluang pengembangan desa.'), 180) }}
                            </p>
                        </div>
                    </a>

                    <div class="relative flex flex-col justify-center p-6 md:p-8 lg:col-span-5 lg:p-10">
                        <span
                            class="mb-4 inline-flex w-fit items-center gap-2 rounded-full bg-green-50 px-3 py-1.5 text-xs font-semibold text-green-700 ring-1 ring-green-200 transition-all duration-300 group-hover:bg-green-700 group-hover:text-white">
                            Sorotan Desa
                        </span>

                        <h3 class="text-2xl font-bold leading-tight text-gray-900 md:text-3xl">
                            {{ $homeFeaturedPotential?->potential_type ?: ($homeFeaturedPotential?->category?->name ?: 'Alam, UMKM, Budaya, Pertanian, dan Perikanan') }}
                        </h3>

                        <p class="mt-4 text-sm leading-relaxed text-gray-600 md:text-base">
                            {{ \Illuminate\Support\Str::limit(strip_tags($homeFeaturedPotential?->opportunities ?: 'Section ini membantu pengunjung melihat potensi Desa Mentuda dengan lebih mudah melalui kategori, pencarian, dan kartu informasi yang menarik.'), 230) }}
                        </p>

                        <div class="mt-7 grid grid-cols-2 gap-3">
                            <div
                                class="group/item rounded-2xl bg-green-50 p-4 transition-all duration-300 hover:-translate-y-1 hover:bg-green-700 hover:shadow-lg">
                                <p class="text-xl transition-transform duration-300 group-hover/item:scale-125">🌿</p>
                                <p class="mt-2 text-sm font-bold text-gray-900 group-hover/item:text-white">Wisata Alam
                                </p>
                                <p class="mt-1 text-xs text-gray-500 group-hover/item:text-white/80">Potensi destinasi
                                    lokal</p>
                            </div>

                            <div
                                class="group/item rounded-2xl bg-yellow-50 p-4 transition-all duration-300 hover:-translate-y-1 hover:bg-yellow-500 hover:shadow-lg">
                                <p class="text-xl transition-transform duration-300 group-hover/item:scale-125">🛍️</p>
                                <p class="mt-2 text-sm font-bold text-gray-900 group-hover/item:text-white">UMKM Desa
                                </p>
                                <p class="mt-1 text-xs text-gray-500 group-hover/item:text-white/80">Produk masyarakat
                                </p>
                            </div>

                            <div
                                class="group/item rounded-2xl bg-blue-50 p-4 transition-all duration-300 hover:-translate-y-1 hover:bg-blue-600 hover:shadow-lg">
                                <p class="text-xl transition-transform duration-300 group-hover/item:scale-125">🐟</p>
                                <p class="mt-2 text-sm font-bold text-gray-900 group-hover/item:text-white">Perikanan
                                </p>
                                <p class="mt-1 text-xs text-gray-500 group-hover/item:text-white/80">Hasil laut desa
                                </p>
                            </div>

                            <div
                                class="group/item rounded-2xl bg-emerald-50 p-4 transition-all duration-300 hover:-translate-y-1 hover:bg-emerald-600 hover:shadow-lg">
                                <p class="text-xl transition-transform duration-300 group-hover/item:scale-125">🎭</p>
                                <p class="mt-2 text-sm font-bold text-gray-900 group-hover/item:text-white">Budaya</p>
                                <p class="mt-1 text-xs text-gray-500 group-hover/item:text-white/80">Kearifan lokal</p>
                            </div>
                        </div>

                        <div class="mt-8 flex flex-col gap-3 sm:flex-row">

                            <!-- Button Primary -->
                            <a href="{{ route('public.potentials.index') }}"
                                class="group/btn relative overflow-hidden inline-flex items-center justify-center gap-2 rounded-xl bg-green-700 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-green-700/20 transition-all duration-300 hover:-translate-y-1 hover:bg-green-800 hover:shadow-2xl active:scale-95">

                                <!-- Shine Effect -->
                                <span
                                    class="absolute -left-16 top-0 h-full w-10 rotate-12 bg-white/20 blur-md transition-all duration-700 group-hover/btn:left-[120%]">
                                </span>

                                <span class="relative z-10">
                                    Jelajahi Potensi
                                </span>

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="relative z-10 w-4 h-4 transition-transform duration-300 group-hover/btn:translate-x-1"
                                    fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                </svg>

                            </a>

                            <!-- Button Secondary -->
                            <a href="{{ route('public.potentials.index') }}"
                                class="group/map inline-flex items-center justify-center gap-2 rounded-xl border border-green-700 bg-white px-6 py-3 text-sm font-semibold text-green-700 transition-all duration-300 hover:-translate-y-1 hover:bg-green-700 hover:text-white hover:shadow-xl active:scale-95">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 transition-all duration-300 group-hover/map:scale-110 group-hover/map:-rotate-12"
                                    fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 20.25 3.75 18V5.25L9 7.5m0 12.75 6-2.25m-6 2.25V7.5m6 10.5 5.25 2.25V7.5L15 5.25m0 12.75V5.25m-6 2.25L15 5.25" />
                                </svg>

                                <span>Lihat Detail</span>

                            </a>

                        </div>
                    </div>
                </article>
            </div>
        </section>

        <!-- Berita Desa Section -->
        @if ($homeFeaturedPost || $homeNewsPosts->isNotEmpty())
            <section
                class="relative overflow-hidden bg-gradient-to-b from-white via-gray-50 to-white px-4 py-16 md:py-20"
                data-aos="fade-up">
                <div class="mx-auto max-w-6xl">

                    <!-- Header -->
                    <header class="mx-auto mb-12 max-w-3xl text-center">
                        <span
                            class="mb-4 inline-flex items-center gap-2 rounded-full bg-green-100 px-4 py-1.5 text-xs font-semibold text-green-700 ring-1 ring-green-200 transition-all duration-300 hover:bg-green-700 hover:text-white hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
                            </svg>
                            Informasi Terkini
                        </span>

                        <h2 class="text-2xl font-bold tracking-tight text-gray-900 md:text-3xl">
                            Berita
                            <span class="text-green-700">Desa Mentuda</span>
                        </h2>

                        <p class="mt-4 text-sm leading-relaxed text-gray-600 md:text-base">
                            Informasi terbaru seputar kegiatan desa, pembangunan, pelayanan masyarakat, UMKM,
                            dan agenda resmi Pemerintah Desa Mentuda.
                        </p>
                    </header>

                    <div class="grid grid-cols-1 gap-8 lg:grid-cols-12 lg:items-stretch">

                        <!-- Berita Utama -->
                        @if ($homeFeaturedPost)
                            <article
                                class="group relative min-h-[420px] overflow-hidden rounded-[2rem] bg-white shadow-xl ring-1 ring-gray-100 transition-all duration-500 hover:-translate-y-1 hover:shadow-2xl hover:ring-green-200 lg:col-span-8 lg:h-full lg:min-h-0">

                                <!-- Shine Effect -->
                                <span
                                    class="pointer-events-none absolute -left-24 top-0 z-20 h-full w-16 rotate-12 bg-white/30 blur-xl transition-all duration-1000 group-hover:left-[120%]">
                                </span>

                                <a href="{{ route('public.posts.show', $homeFeaturedPost->slug) }}"
                                    class="relative block h-full min-h-[420px] w-full overflow-hidden lg:min-h-0">

                                    <img src="{{ $homeFeaturedPost->cover_image_url ?: asset('public/img/bg.jpg') }}"
                                        alt="{{ $homeFeaturedPost->cover_image_alt ?: $homeFeaturedPost->title }}"
                                        class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-110">

                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/45 to-black/10 transition-all duration-500 group-hover:from-black/95 group-hover:via-black/50">
                                    </div>

                                    <div
                                        class="absolute bottom-6 left-6 right-6 text-white md:bottom-8 md:left-8 md:right-8">

                                        <div class="mb-4 flex flex-wrap items-center gap-3">
                                            <span
                                                class="inline-flex items-center gap-2 rounded-full bg-white/20 px-3 py-1.5 text-xs font-semibold text-white backdrop-blur ring-1 ring-white/30 transition-all duration-300 group-hover:-translate-y-1 group-hover:bg-green-600 group-hover:shadow-lg">

                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="w-4 h-4 transition-all duration-300 group-hover:scale-110 group-hover:rotate-12"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581a2.25 2.25 0 0 0 3.182 0l4.318-4.318a2.25 2.25 0 0 0 0-3.182L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                                </svg>

                                                <span>{{ $homeFeaturedPost->category->name ?? 'Berita Desa' }}</span>
                                            </span>

                                            <span class="inline-flex items-center gap-1.5 text-sm text-white/90">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 6v6l4 2m6-2a10 10 0 1 1-20 0 10 10 0 0 1 20 0Z" />
                                                </svg>
                                                {{ optional($homeFeaturedPost->published_at)->format('d-m-Y') }}
                                            </span>
                                        </div>

                                        <h3
                                            class="max-w-3xl text-2xl font-bold leading-tight transition-all duration-300 group-hover:translate-x-1 md:text-4xl">
                                            {{ $homeFeaturedPost->title }}
                                        </h3>

                                        <p class="mt-3 max-w-2xl text-sm leading-relaxed text-white/85">
                                            {{ $homeFeaturedPost->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($homeFeaturedPost->content), 180) }}
                                        </p>
                                    </div>
                                </a>
                            </article>
                        @endif

                        <!-- Daftar Berita -->
                        <div
                            class="flex h-full flex-col gap-4 {{ $homeFeaturedPost ? 'lg:col-span-4' : 'lg:col-span-12' }}">

                            @foreach ($homeNewsPosts as $homeNewsPost)
                                <a href="{{ route('public.posts.show', $homeNewsPost->slug) }}"
                                    class="group relative flex flex-1 gap-4 overflow-hidden rounded-3xl bg-white p-4 shadow-lg ring-1 ring-gray-100 transition-all duration-500 hover:-translate-y-1 hover:shadow-2xl hover:ring-green-200 active:scale-[0.99]">

                                    <!-- Shine Effect -->
                                    <span
                                        class="pointer-events-none absolute -left-16 top-0 h-full w-10 rotate-12 bg-white/20 blur-md transition-all duration-700 group-hover:left-[120%]">
                                    </span>

                                    <div class="relative h-24 w-28 shrink-0 overflow-hidden rounded-2xl">
                                        <img src="{{ $homeNewsPost->cover_image_url ?: asset('public/img/bg.jpg') }}"
                                            alt="{{ $homeNewsPost->cover_image_alt ?: $homeNewsPost->title }}"
                                            class="h-full w-full object-cover transition-all duration-700 group-hover:scale-110">

                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent opacity-70 transition-all duration-500 group-hover:from-black/50">
                                        </div>
                                    </div>

                                    <div class="flex min-w-0 flex-col justify-center">
                                        <h3
                                            class="line-clamp-2 text-sm font-bold leading-snug text-gray-900 transition-all duration-300 group-hover:translate-x-1 group-hover:text-green-700 md:text-base">
                                            {{ $homeNewsPost->title }}
                                        </h3>

                                        <div
                                            class="mt-3 flex flex-wrap items-center gap-3 text-xs text-gray-500 transition-all duration-300 group-hover:text-gray-700">
                                            <span class="inline-flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-3.5 w-3.5 transition-transform duration-300 group-hover:rotate-12"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581a2.25 2.25 0 0 0 3.182 0l4.318-4.318a2.25 2.25 0 0 0 0-3.182L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                                </svg>
                                                {{ $homeNewsPost->category->name ?? 'Berita Desa' }}
                                            </span>

                                            <span class="inline-flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 6v6l4 2m6-2a10 10 0 1 1-20 0 10 10 0 0 1 20 0Z" />
                                                </svg>
                                                {{ optional($homeNewsPost->published_at)->format('d-m-Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Button Bottom -->
                    <div class="mt-10 text-center">
                        <a href="{{ route('public.posts.index') }}"
                            class="group relative inline-flex items-center gap-2 overflow-hidden rounded-full border border-green-700 px-6 py-3 text-sm font-semibold text-green-700 transition-all duration-300 hover:-translate-y-1 hover:bg-green-700 hover:text-white hover:shadow-lg active:scale-95">

                            <span
                                class="absolute -left-16 top-0 h-full w-12 rotate-12 bg-white/20 blur-md transition-all duration-700 group-hover:left-[120%]">
                            </span>

                            <span class="relative z-10">Lihat Semua Berita</span>

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="relative z-10 w-4 h-4 transition-transform duration-300 group-hover:translate-x-1"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>

                </div>
            </section>
        @endif

        <!-- Pengumuman Desa -->
        <section class="relative overflow-hidden bg-gradient-to-b from-white via-gray-50 to-white py-20"
            data-aos="fade-up">

            <div class="max-w-6xl mx-auto px-4">

                <!-- Header -->
                <header class="mx-auto mb-10 max-w-3xl text-center">
                    <span
                        class="mb-4 inline-flex items-center gap-2 rounded-full bg-green-100 px-4 py-1.5 text-xs font-semibold text-green-700 ring-1 ring-green-200 transition-all duration-300 hover:bg-green-700 hover:text-white hover:shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9a6 6 0 0 0-12 0v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a3 3 0 1 1-5.714 0" />
                        </svg>
                        Informasi Resmi Desa
                    </span>

                    <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-gray-900">
                        Pengumuman
                        <span class="text-green-700">Desa Mentuda</span>
                    </h2>

                    <p class="mt-4 text-sm md:text-base leading-relaxed text-gray-600">
                        Menyajikan informasi, agenda kegiatan, pelayanan publik, serta
                        pengumuman resmi Pemerintah Desa Mentuda yang diperbarui secara berkala.
                    </p>
                </header>

                <!-- List Pengumuman -->
                <div class="mx-auto max-w-5xl space-y-4">

                    @forelse ($homeAnnouncements as $homeAnnouncement)
                        <article
                            class="group relative overflow-hidden rounded-2xl bg-white p-4 md:p-5 shadow-sm ring-1 ring-gray-200 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:ring-green-200"
                            data-aos="fade-up" data-aos-delay="{{ 60 + $loop->index * 70 }}">

                            <!-- Shine effect card -->
                            <span
                                class="pointer-events-none absolute -left-20 top-0 h-full w-14 rotate-12 bg-green-100/80 blur-xl transition-all duration-700 group-hover:left-[120%]">
                            </span>

                            <div
                                class="relative z-10 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

                                <!-- Left -->
                                <div class="flex gap-4">

                                    <!-- Date -->
                                    <div
                                        class="shrink-0 w-16 h-16 rounded-2xl bg-green-50 text-green-700 ring-1 ring-green-200 flex flex-col items-center justify-center transition-all duration-300 group-hover:bg-green-700 group-hover:text-white group-hover:ring-green-700 group-hover:scale-105 group-hover:shadow-lg">
                                        <span
                                            class="text-[10px] font-semibold uppercase">{{ optional($homeAnnouncement->announcement_date)->translatedFormat('M') }}</span>
                                        <strong
                                            class="text-xl leading-none">{{ optional($homeAnnouncement->announcement_date)->format('d') }}</strong>
                                        <span
                                            class="text-[10px] font-semibold">{{ optional($homeAnnouncement->announcement_date)->format('Y') }}</span>
                                    </div>

                                    <!-- Content -->
                                    <div class="min-w-0">

                                        <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500">

                                            <span
                                                class="inline-flex items-center gap-1 rounded-full bg-green-50 px-3 py-1 font-semibold text-green-700 ring-1 ring-green-200 transition-all duration-300 group-hover:bg-green-700 group-hover:text-white group-hover:ring-green-700">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="w-3.5 h-3.5 transition-transform duration-300 group-hover:rotate-12"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9a6 6 0 0 0-12 0v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a3 3 0 1 1-5.714 0" />
                                                </svg>
                                                {{ $homeAnnouncement->category?->name ?? 'Pengumuman' }}
                                            </span>

                                            @if ($homeAnnouncement->is_featured)
                                                <span
                                                    class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-3 py-1 font-semibold text-amber-700 ring-1 ring-amber-200 transition-all duration-300 group-hover:bg-amber-700 group-hover:text-black group-hover:ring-amber-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="w-3.5 h-3.5 transition-transform duration-300 group-hover:rotate-12"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="1.8">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
                                                    </svg>

                                                    Prioritas
                                                </span>
                                            @endif

                                            <span
                                                class="inline-flex items-center gap-1 transition-colors duration-300 group-hover:text-gray-700">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="w-3.5 h-3.5 transition-transform duration-300 group-hover:scale-110"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 6v6l4 2m6-2a10 10 0 1 1-20 0 10 10 0 0 1 20 0Z" />
                                                </svg>
                                                {{ optional($homeAnnouncement->announcement_date)->translatedFormat('d F Y') }}
                                            </span>

                                            <span class="hidden">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="w-3.5 h-3.5 transition-transform duration-300 group-hover:scale-110"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 6v6l4 2m6-2a10 10 0 1 1-20 0 10 10 0 0 1 20 0Z" />
                                                </svg>
                                                20 November 2025 • 00:17
                                            </span>

                                        </div>

                                        <h3
                                            class="mt-2 text-lg font-bold text-gray-900 transition-all duration-300 group-hover:text-green-700 group-hover:translate-x-1">
                                            {{ $homeAnnouncement->title }}
                                        </h3>

                                        <p
                                            class="mt-2 text-sm leading-relaxed text-gray-600 line-clamp-2 transition-colors duration-300 group-hover:text-gray-700">
                                            {{ $homeAnnouncement->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($homeAnnouncement->content), 150) }}
                                        </p>

                                        <div class="mt-3 flex flex-wrap gap-4 text-xs text-gray-500">

                                            <span
                                                class="inline-flex items-center gap-1 transition-colors duration-300 group-hover:text-green-700">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="w-3.5 h-3.5 transition-transform duration-300 group-hover:-translate-y-0.5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>

                                                {{ optional($homeAnnouncement->event_at)->format('H:i') ?: 'Publikasi aktif' }}
                                            </span>

                                            @if ($homeAnnouncement->event_location)
                                                <span
                                                    class="inline-flex items-center gap-1 transition-colors duration-300 group-hover:text-gray-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="1.8">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                                    </svg>
                                                    {{ $homeAnnouncement->event_location }}
                                                </span>
                                            @endif

                                            <span
                                                class="inline-flex items-center gap-1 transition-colors duration-300 group-hover:text-green-700">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="w-3.5 h-3.5 transition-transform duration-300 group-hover:scale-110"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a8.25 8.25 0 0 1 15 0" />
                                                </svg>
                                                {{ $homeAnnouncement->author?->name ?? 'Pemerintah Desa Mentuda' }}
                                            </span>

                                        </div>

                                    </div>
                                </div>

                                <!-- Button -->
                                <a href="{{ route('public.announcements.show', $homeAnnouncement->slug) }}"
                                    class="group/btn relative overflow-hidden inline-flex shrink-0 items-center gap-2 rounded-xl bg-green-700 px-5 py-3 text-sm font-semibold text-white shadow-md transition-all duration-300 hover:-translate-y-1 hover:bg-green-800 hover:shadow-xl active:scale-95">

                                    <span
                                        class="absolute -left-12 top-0 h-full w-10 rotate-12 bg-white/20 blur-md transition-all duration-700 group-hover/btn:left-[120%]">
                                    </span>

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="relative z-10 w-4 h-4 transition-transform duration-300 group-hover/btn:scale-110 group-hover/btn:rotate-12"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                    </svg>

                                    <span class="relative z-10">Baca Selengkapnya</span>
                                </a>

                            </div>
                        </article>
                    @empty
                        <div
                            class="rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-10 text-center text-sm text-gray-500">
                            Pengumuman resmi akan tampil di sini setelah admin mempublikasikannya.
                        </div>
                    @endforelse

                </div>

                <!-- Button Bottom -->
                <div class="mt-10 text-center">
                    <a href="{{ route('public.announcements.index') }}"
                        class="group relative overflow-hidden inline-flex items-center gap-2 rounded-full border border-green-700 px-6 py-3 text-sm font-semibold text-green-700 transition-all duration-300 hover:-translate-y-1 hover:bg-green-700 hover:text-white hover:shadow-lg active:scale-95">

                        <span
                            class="absolute -left-16 top-0 h-full w-12 rotate-12 bg-white/20 blur-md transition-all duration-700 group-hover:left-[120%]">
                        </span>

                        <span class="relative z-10">Lihat Semua Pengumuman</span>

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="relative z-10 w-4 h-4 transition-transform duration-300 group-hover:translate-x-1"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>

            </div>
        </section>

    </main>

    <!-- Floating Action Buttons -->
    <div class="fixed bottom-5 right-4 z-50 flex flex-col items-end gap-3 sm:bottom-6 sm:right-6">

        <!-- WhatsApp -->
        <a href="https://wa.me/6281234567890" tooltip="Hubungi admin kami" target="_blank" rel="noopener noreferrer"
            aria-label="WhatsApp"
            class="fab-action group relative flex h-12 w-12 items-center justify-center rounded-full
        bg-green-500 text-white shadow-xl shadow-green-600/30 transition-all duration-300
        hover:-translate-y-1 hover:scale-105 sm:h-14 sm:w-14">

            <!-- Radar Effect -->
            <span class="absolute inset-0 rounded-full bg-green-400/40 animate-[radar_1.8s_ease-out_infinite]"></span>
            <span
                class="absolute inset-0 rounded-full bg-green-400/30 animate-[radar_1.8s_ease-out_infinite_0.5s]"></span>

            <!-- Inner Glow -->
            <span class="absolute inset-0 rounded-full bg-gradient-to-br from-white/25 to-transparent"></span>

            <!-- Icon -->
            <svg xmlns="http://www.w3.org/2000/svg"
                class="relative z-10 h-6 w-6 transition-transform duration-300 group-hover:rotate-12 group-hover:scale-110 sm:h-7 sm:w-7"
                viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M20.52 3.48A11.86 11.86 0 0 0 12.07 0C5.49 0 .15 5.34.15 11.92c0 2.1.55 4.15 1.6 5.96L0 24l6.28-1.65a11.88 11.88 0 0 0 5.79 1.48h.01c6.58 0 11.92-5.34 11.92-11.92 0-3.18-1.24-6.17-3.48-8.43ZM12.08 21.8h-.01a9.87 9.87 0 0 1-5.04-1.38l-.36-.21-3.72.98.99-3.63-.23-.37a9.86 9.86 0 0 1-1.51-5.27c0-5.45 4.43-9.88 9.88-9.88 2.64 0 5.12 1.03 6.98 2.9a9.8 9.8 0 0 1 2.89 6.98c0 5.45-4.43 9.88-9.87 9.88Zm5.42-7.4c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.47-.89-.79-1.49-1.76-1.66-2.06-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.18.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48s1.07 2.88 1.22 3.08c.15.2 2.1 3.2 5.08 4.48.71.31 1.26.49 1.69.63.71.23 1.36.2 1.87.12.57-.08 1.76-.72 2.01-1.42.25-.7.25-1.3.17-1.42-.07-.13-.27-.2-.57-.35Z" />
            </svg>
        </a>

        <!-- Back To Top With Circular Progress -->
        <button id="backToTop" type="button" aria-label="Kembali ke atas"
            class="relative flex h-12 w-12 items-center justify-center rounded-full bg-white text-green-600
        shadow-xl shadow-green-900/10 ring-1 ring-green-100 transition-all duration-300
        hover:-translate-y-1 hover:scale-105 hover:text-green-700 sm:h-14 sm:w-14">

            <!-- Circular Progress -->
            <svg class="absolute inset-0 h-full w-full -rotate-90" viewBox="0 0 56 56">
                <circle cx="28" cy="28" r="25" fill="none" stroke="rgba(34,197,94,0.15)"
                    stroke-width="3" />
                <circle id="scrollProgressCircle" cx="28" cy="28" r="25" fill="none"
                    stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-dasharray="157"
                    stroke-dashoffset="157" />
            </svg>

            <!-- Icon -->
            <svg xmlns="http://www.w3.org/2000/svg"
                class="relative z-10 h-5 w-5 transition-transform duration-300 group-hover:-translate-y-1 sm:h-6 sm:w-6"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 19.5V4.5m0 0l-6 6m6-6l6 6" />
            </svg>
        </button>
    </div>

    <style>
        @keyframes radar {
            0% {
                transform: scale(1);
                opacity: .55;
            }

            70% {
                transform: scale(1.9);
                opacity: 0;
            }

            100% {
                transform: scale(1.9);
                opacity: 0;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const backToTop = document.getElementById('backToTop');
            const progressCircle = document.getElementById('scrollProgressCircle');
            const radius = 25;
            const circumference = 2 * Math.PI * radius;

            progressCircle.style.strokeDasharray = circumference;
            progressCircle.style.strokeDashoffset = circumference;

            function updateScrollProgress() {
                const scrollTop = window.scrollY;
                const docHeight = document.documentElement.scrollHeight - window.innerHeight;
                const progress = docHeight > 0 ? scrollTop / docHeight : 0;
                const offset = circumference - progress * circumference;

                progressCircle.style.strokeDashoffset = offset;
            }

            window.addEventListener('scroll', updateScrollProgress);
            updateScrollProgress();

            backToTop.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });
    </script>

    @include('pages.public.partials.footer')

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
        (() => {
            const menuBtn = document.getElementById('menu-btn');
            const menuClose = document.getElementById('menu-close');
            const overlay = document.getElementById('overlay');
            const panel = document.getElementById('mobile-menu');
            const accBtns = document.querySelectorAll('[data-acc-btn]');
            const accPanels = document.querySelectorAll('[data-acc-panel]');
            const chevIcons = document.querySelectorAll('[data-chev]');
            let lastFocused = null;

            const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const openDuration = prefersReduced ? 0 : 200;

            const setAria = (expanded) => {
                menuBtn?.setAttribute('aria-expanded', String(expanded));
                panel?.setAttribute('aria-hidden', String(!expanded));
                overlay?.setAttribute('aria-hidden', String(!expanded));
            };

            const trapFocus = (e) => {
                if (!panel || panel.classList.contains('pointer-events-none')) return;
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

                // fokus ke tombol close atau link pertama
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

                // tutup semua accordion + reset ikon
                accBtns.forEach((b) => b.setAttribute('aria-expanded', 'false'));
                accPanels.forEach((p) => p.style.maxHeight = 0);
                chevIcons.forEach((c) => c.dataset.open = 'false');

                document.removeEventListener('keydown', trapFocus);
                // kembalikan fokus ke pemicu
                lastFocused?.focus();
            };

            // Toggle
            menuBtn?.addEventListener('click', () => {
                const expanded = menuBtn.getAttribute('aria-expanded') === 'true';
                expanded ? closeMenu() : openMenu();
            });
            menuClose?.addEventListener('click', closeMenu);
            overlay?.addEventListener('click', closeMenu);

            // ESC
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeMenu();
            });

            // Klik di luar panel (header kosong/area putih atas)
            document.addEventListener('mousedown', (e) => {
                if (!panel || panel.classList.contains('pointer-events-none')) return;
                const within = panel.contains(e.target) || (menuBtn && menuBtn.contains(e.target));
                if (!within) closeMenu();
            });

            // Accordion (single open)
            accBtns.forEach((btn) => {
                const pid = btn.getAttribute('aria-controls');
                const pnl = document.getElementById(pid);
                const chev = btn.querySelector('[data-chev]');
                btn.addEventListener('click', () => {
                    const isOpen = btn.getAttribute('aria-expanded') === 'true';
                    // tutup semua
                    accBtns.forEach((b) => b.setAttribute('aria-expanded', 'false'));
                    accPanels.forEach((p) => p.style.maxHeight = 0);
                    chevIcons.forEach((c) => c.dataset.open = 'false');

                    if (!isOpen) {
                        btn.setAttribute('aria-expanded', 'true');
                        pnl.style.maxHeight = pnl.scrollHeight + 'px';
                        if (chev) chev.dataset.open = 'true';
                    }
                });
            });

        })();

        // Efek Count Up
        document.addEventListener("DOMContentLoaded", () => {
            const counters = document.querySelectorAll(".counter");
            const formatter = new Intl.NumberFormat("id-ID");

            counters.forEach(counter => {
                const target = +counter.getAttribute("data-target");
                const updateCount = () => {
                    const current = +counter.innerText.replace(/\D/g, "");
                    const increment = Math.ceil(target / 150);
                    if (current < target) {
                        const nextValue = current + increment > target ? target : current + increment;
                        counter.innerText = formatter.format(nextValue);
                        setTimeout(updateCount, 20);
                    } else {
                        counter.innerText = formatter.format(target);
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
        window.addEventListener('load', () => {
            if (typeof AOS === 'undefined') {
                return;
            }

            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true,
            });

            AOS.refresh();
        });
        // Back to Top Button
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

                    waBtn.classList.remove('opacity-0', 'scale-90', 'pointer-events-none');
                    waBtn.classList.add('opacity-100', 'scale-100');

                } else if (window.scrollY <= showAfter && visible) {
                    visible = false;

                    btn.classList.add('opacity-0', 'scale-90', 'pointer-events-none');
                    btn.classList.remove('opacity-100', 'scale-100');

                    waBtn.classList.add('opacity-0', 'scale-90', 'pointer-events-none');
                    waBtn.classList.remove('opacity-100', 'scale-100');
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
        document.getElementById('currentYear').textContent = new Date().getFullYear();
    </script>
    <!-- Alpine.js (CDN) -->
    <script src="https://unpkg.com/alpinejs" defer></script>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>

    <!-- Swiper.js CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

</body>

</html>
