@php
    $isHome = request()->routeIs('home');
    $isProfile = request()->routeIs('public.history') || request()->routeIs('public.vision-mission') || request()->routeIs('public.organization-structure') || request()->routeIs('public.village-map');
    $isHistory = request()->routeIs('public.history');
    $isVisionMission = request()->routeIs('public.vision-mission');
    $isOrganizationStructure = request()->routeIs('public.organization-structure');
    $isVillageMap = request()->routeIs('public.village-map');
    $isPotentials = request()->routeIs('public.potentials.*');
    $isPosts = request()->routeIs('public.posts.*');
    $isPopulation = request()->routeIs('public.population.*');
    $isBudgets = request()->routeIs('public.budgets.*');
    $isAnnouncements = request()->routeIs('public.announcements.*');
    $isGalleries = request()->routeIs('public.galleries.*');
    $isBusinesses = request()->routeIs('public.businesses.*');
    $isServices = request()->routeIs('public.services.*');
    $isInformation = $isPosts || $isPotentials || $isPopulation || $isBudgets || $isAnnouncements || $isGalleries;
@endphp

<nav id="navbar"
    class="fixed top-0 left-0 w-full z-50 bg-white/70 backdrop-blur-md shadow-sm -translate-y-full transform-gpu transition-transform duration-500">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between lg:justify-center">

        <!-- Logo -->
        <a href="{{ route('home') }}" class="block md:block lg:hidden text-green-700 font-bold text-lg">
            Desa Mentuda
        </a>

        <!-- Hamburger Mobile -->
        <button id="menu-btn"
            class="md:hidden inline-flex items-center justify-center w-11 h-11 rounded-lg text-gray-700 hover:text-green-700 focus:outline-none focus:ring-2 focus:ring-green-600"
            aria-controls="mobile-menu" aria-expanded="false" aria-label="Toggle navigation">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Menu Desktop -->
        <div id="menu-desktop" class="hidden md:h-10 md:flex flex-col md:flex-row md:items-center md:space-x-8">
            <a href="{{ route('home') }}"
                class="{{ $isHome ? 'text-green-700' : 'text-gray-700 hover:text-green-700' }} font-medium transition">
                Beranda
            </a>

            <div class="group relative" data-desktop-dropdown>
                <button type="button"
                    aria-expanded="false"
                    class="{{ $isProfile ? 'text-green-700' : 'text-gray-700 hover:text-green-700' }} flex items-center font-medium transition cursor-pointer"
                    data-desktop-dropdown-btn>
                    Profil Desa
                    <svg class="ml-1 h-4 w-4 transition-transform duration-200" data-chev fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div
                    class="absolute left-0 mt-2 w-48 rounded-md bg-white py-2 shadow-md opacity-0 invisible pointer-events-none translate-y-2 transition-all duration-200 z-10 group-hover:visible group-hover:opacity-100 group-hover:pointer-events-auto group-hover:translate-y-0"
                    data-desktop-dropdown-panel>
                    <a href="{{ route('public.history') }}"
                        class="{{ $isHistory ? 'bg-green-50 text-green-700' : 'text-gray-700 hover:bg-gray-100' }} block px-4 py-2">
                        Sejarah
                    </a>
                    <a href="{{ route('public.vision-mission') }}"
                        class="{{ $isVisionMission ? 'bg-green-50 text-green-700' : 'text-gray-700 hover:bg-gray-100' }} block px-4 py-2">
                        Visi &amp; Misi
                    </a>
                    <a href="{{ route('public.organization-structure') }}"
                        class="{{ $isOrganizationStructure ? 'bg-green-50 text-green-700' : 'text-gray-700 hover:bg-gray-100' }} block px-4 py-2">
                        Struktur Organisasi
                    </a>
                    <a href="{{ route('public.village-map') }}"
                        class="{{ $isVillageMap ? 'bg-green-50 text-green-700' : 'text-gray-700 hover:bg-gray-100' }} block px-4 py-2">
                        Peta Desa
                    </a>
                </div>
            </div>

            <div class="group relative" data-desktop-dropdown>
                <button type="button"
                    aria-expanded="false"
                    class="{{ $isInformation ? 'text-green-700' : 'text-gray-700 hover:text-green-700' }} flex items-center font-medium transition cursor-pointer"
                    data-desktop-dropdown-btn>
                    Informasi
                    <svg class="ml-1 h-4 w-4 transition-transform duration-200" data-chev fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div
                    class="absolute left-0 mt-2 w-48 rounded-md bg-white py-2 shadow-md opacity-0 invisible pointer-events-none translate-y-2 transition-all duration-200 z-10 group-hover:visible group-hover:opacity-100 group-hover:pointer-events-auto group-hover:translate-y-0"
                    data-desktop-dropdown-panel>
                    <a href="{{ route('public.population.index') }}"
                        class="{{ $isPopulation ? 'bg-green-50 text-green-700' : 'text-gray-700 hover:bg-gray-100' }} block px-4 py-2">
                        Data Penduduk
                    </a>
                    <a href="{{ route('public.budgets.index') }}"
                        class="{{ $isBudgets ? 'bg-green-50 text-green-700' : 'text-gray-700 hover:bg-gray-100' }} block px-4 py-2">
                        APBDesa
                    </a>
                    <a href="{{ route('public.potentials.index') }}"
                        class="{{ $isPotentials ? 'bg-green-50 text-green-700' : 'text-gray-700 hover:bg-gray-100' }} block px-4 py-2">
                        Potensi Desa
                    </a>
                    <a href="{{ route('public.posts.index') }}"
                        class="{{ $isPosts ? 'bg-green-50 text-green-700' : 'text-gray-700 hover:bg-gray-100' }} block px-4 py-2">
                        Berita
                    </a>
                    <a href="{{ route('public.announcements.index') }}"
                        class="{{ $isAnnouncements ? 'bg-green-50 text-green-700' : 'text-gray-700 hover:bg-gray-100' }} block px-4 py-2">
                        Pengumuman
                    </a>
                    <a href="{{ route('public.galleries.index') }}"
                        class="{{ $isGalleries ? 'bg-green-50 text-green-700' : 'text-gray-700 hover:bg-gray-100' }} block px-4 py-2">
                        Galeri Desa
                    </a>
                </div>
            </div>

            <a href="{{ route('public.businesses.index') }}"
                class="{{ $isBusinesses ? 'text-green-700' : 'text-gray-700 hover:text-green-700' }} font-medium transition">UMKM</a>
            <a href="{{ route('public.services.index') }}"
                class="{{ $isServices ? 'text-green-700' : 'text-gray-700 hover:text-green-700' }} font-medium transition">Layanan</a>
        </div>
    </div>

    <div id="overlay"
        class="fixed inset-0 bg-black/45 opacity-0 pointer-events-none transition-opacity duration-200 md:hidden"
        role="presentation" aria-hidden="true"></div>

    <div id="mobile-menu"
        class="fixed top-0 left-0 right-0 translate-y-[-12px] opacity-0 pointer-events-none md:hidden bg-white/95 backdrop-blur shadow-xl transition-all duration-200 will-change-transform border-b border-gray-100"
        role="dialog" aria-modal="true" aria-labelledby="mobile-menu-title">
        <div class="sticky top-0 bg-white/90 backdrop-blur border-b border-gray-100">
            <div class="px-4 pt-3 pb-2 flex items-center justify-between">
                <a href="{{ route('home') }}" class="block text-green-700 font-bold text-lg">Desa Mentuda</a>

                <button id="menu-close"
                    class="inline-flex items-center justify-center w-11 h-11 rounded-lg text-gray-600 hover:text-green-700 focus:outline-none focus:ring-2 focus:ring-green-600"
                    aria-label="Tutup menu">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <nav class="px-2 py-2 max-h-[80vh] overflow-y-auto" aria-label="Navigasi utama mobile">
            <ul class="divide-y divide-gray-100">
                <li>
                    <a href="{{ route('home') }}"
                        class="{{ $isHome ? 'bg-green-50 text-green-700' : 'hover:bg-gray-100 text-gray-900' }} block px-3 py-3 rounded-lg transition">
                        Beranda
                    </a>
                </li>
                <li class="pt-1">
                    <button
                        class="{{ $isProfile ? 'bg-green-50 text-green-700' : 'hover:bg-gray-100 text-gray-900' }} w-full flex items-center justify-between px-3 py-3 rounded-lg transition"
                        aria-expanded="false" aria-controls="acc-profil" data-acc-btn>
                        <span class="font-medium">Profil Desa</span>
                        <svg class="w-4 h-4 transform transition-transform duration-200" data-chev viewBox="0 0 24 24"
                            fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div id="acc-profil" class="max-h-0 overflow-hidden transition-[max-height] duration-300"
                        data-acc-panel>
                        <div class="pl-6 py-2 space-y-1">
                            <a href="{{ route('public.history') }}"
                                class="{{ $isHistory ? 'bg-green-50 text-green-700' : 'hover:bg-gray-100' }} block px-3 py-2 rounded transition">
                                Sejarah
                            </a>
                            <a href="{{ route('public.vision-mission') }}"
                                class="{{ $isVisionMission ? 'bg-green-50 text-green-700' : 'hover:bg-gray-100' }} block px-3 py-2 rounded transition">
                                Visi &amp; Misi
                            </a>
                            <a href="{{ route('public.organization-structure') }}"
                                class="{{ $isOrganizationStructure ? 'bg-green-50 text-green-700' : 'hover:bg-gray-100' }} block px-3 py-2 rounded transition">
                                Struktur Organisasi
                            </a>
                            <a href="{{ route('public.village-map') }}"
                                class="{{ $isVillageMap ? 'bg-green-50 text-green-700' : 'hover:bg-gray-100' }} block px-3 py-2 rounded transition">
                                Peta Desa
                            </a>
                        </div>
                    </div>
                </li>
                <li class="pt-1">
                    <button
                        class="{{ $isInformation ? 'bg-green-50 text-green-700' : 'hover:bg-gray-100 text-gray-900' }} w-full flex items-center justify-between px-3 py-3 rounded-lg transition"
                        aria-expanded="false" aria-controls="acc-info" data-acc-btn>
                        <span class="font-medium">Informasi</span>
                        <svg class="w-4 h-4 transition-transform duration-200" data-chev viewBox="0 0 24 24"
                            fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div id="acc-info" class="max-h-0 overflow-hidden transition-[max-height] duration-300"
                        data-acc-panel>
                        <div class="pl-6 py-2 space-y-1">
                            <a href="{{ route('public.population.index') }}"
                                class="{{ $isPopulation ? 'bg-green-50 text-green-700' : 'hover:bg-gray-100' }} block px-3 py-2 rounded transition">
                                Data Penduduk
                            </a>
                            <a href="{{ route('public.budgets.index') }}"
                                class="{{ $isBudgets ? 'bg-green-50 text-green-700' : 'hover:bg-gray-100' }} block px-3 py-2 rounded transition">
                                APBDesa
                            </a>
                            <a href="{{ route('public.potentials.index') }}"
                                class="{{ $isPotentials ? 'bg-green-50 text-green-700' : 'hover:bg-gray-100' }} block px-3 py-2 rounded transition">
                                Potensi Desa
                            </a>
                            <a href="{{ route('public.posts.index') }}"
                                class="{{ $isPosts ? 'bg-green-50 text-green-700' : 'hover:bg-gray-100' }} block px-3 py-2 rounded transition">
                                Berita
                            </a>
                            <a href="{{ route('public.announcements.index') }}"
                                class="{{ $isAnnouncements ? 'bg-green-50 text-green-700' : 'hover:bg-gray-100' }} block px-3 py-2 rounded transition">
                                Pengumuman
                            </a>
                            <a href="{{ route('public.galleries.index') }}"
                                class="{{ $isGalleries ? 'bg-green-50 text-green-700' : 'hover:bg-gray-100' }} block px-3 py-2 rounded transition">
                                Galeri Desa
                            </a>
                        </div>
                    </div>
                </li>
                <li class="pt-1">
                    <a href="{{ route('public.businesses.index') }}"
                        class="{{ $isBusinesses ? 'bg-green-50 text-green-700' : 'hover:bg-gray-100 text-gray-900' }} block px-3 py-3 rounded-lg transition">UMKM</a>
                </li>
                <li>
                    <a href="{{ route('public.services.index') }}"
                        class="{{ $isServices ? 'bg-green-50 text-green-700' : 'hover:bg-gray-100 text-gray-900' }} block px-3 py-3 rounded-lg transition">Layanan</a>
                </li>
            </ul>
        </nav>

        <div class="h-[env(safe-area-inset-bottom,0px)]"></div>
    </div>
</nav>
