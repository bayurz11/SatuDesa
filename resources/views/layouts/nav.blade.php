<!-- Navbar -->
<nav id="navbar"
    class="fixed top-0 left-0 w-full z-50 bg-white/70 backdrop-blur-md shadow-sm -translate-y-full transform-gpu transition-transform duration-500">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between lg:justify-center">

        <!-- Logo (tetap) -->
        <a href="{{ route('/') }}" class="block md:block lg:hidden text-green-700 font-bold text-lg">
            Desa Mentuda
        </a>

        <!-- Hamburger (Mobile) -->
        <button id="menu-btn"
            class="md:hidden inline-flex items-center justify-center w-11 h-11 rounded-lg text-gray-700 hover:text-green-700 focus:outline-none focus:ring-2 focus:ring-green-600"
            aria-controls="mobile-menu" aria-expanded="false" aria-label="Toggle navigation">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Menu (DESKTOP: tetap seperti semula, hanya dibungkus hidden md:flex) -->
        <div id="menu-desktop" class="hidden md:h-10 md:flex flex-col md:flex-row md:items-center md:space-x-8">

            <a href="{{ route('/') }}"
                class="{{ Route::is('/') ? 'text-green-700 font-semibold' : 'text-gray-700 font-medium hover:text-green-700' }}">
                Beranda
            </a>

            <!-- Dropdown Profil Desa (desktop) -->
            <div class="relative group">
                <button
                    class="flex items-center font-medium {{ request()->is('sejarah') || request()->is('visi-misi') || request()->is('struktur-desa') || request()->is('potensi-desa') || request()->is('peta-desa') ? 'text-green-700' : 'text-gray-700 hover:text-green-700' }}">
                    Profil Desa
                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div
                    class="absolute left-0 mt-2 w-48 bg-white shadow-md rounded-md py-2 opacity-0 invisible group-hover:visible group-hover:opacity-100 transition-all duration-200 z-10">
                    <a href="{{ route('sejarah') }}"
                        class="block px-4 py-2 {{ Route::is('sejarah') ? 'bg-green-50 text-green-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">Sejarah</a>
                    <a href="{{ route('visi-misi') }}"
                        class="block px-4 py-2 {{ Route::is('visi-misi') ? 'bg-green-50 text-green-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">Visi
                        &amp; Misi</a>
                    <a href="{{ route('struktur-desa') }}"
                        class="block px-4 py-2 {{ Route::is('struktur-desa') ? 'bg-green-50 text-green-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">Struktur
                        Organisasi</a>
                    <a href="{{ route('potensi-desa') }}"
                        class="block px-4 py-2 {{ Route::is('potensi-desa') ? 'bg-green-50 text-green-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">Potensi
                        Desa</a>
                    <a href="{{ route('peta-desa') }}"
                        class="block px-4 py-2 {{ Route::is('peta-desa') ? 'bg-green-50 text-green-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">Peta
                        Desa</a>
                </div>
            </div>

            <!-- Dropdown Informasi (desktop) -->
            <div class="relative group">
                <button
                    class="text-gray-700 hover:text-green-700 flex items-center font-medium {{ request()->is('berita') || request()->is('data-penduduk') || request()->is('apbdesa') || request()->is('galeri') ? 'text-green-700' : 'text-gray-700 hover:text-green-700' }}">
                    Informasi
                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div
                    class="absolute left-0 mt-2 w-48 bg-white shadow-md rounded-md py-2 opacity-0 invisible group-hover:visible group-hover:opacity-100 transition-all duration-200 z-10">
                    <a href="{{ route('data-penduduk') }}"
                        class="block px-4 py-2 {{ Route::is('data-penduduk') ? 'bg-green-50 text-green-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">Data
                        Penduduk</a>
                    <a href="{{ route('apbdesa') }}"
                        class="block px-4 py-2 {{ Route::is('apbdesa') ? 'bg-green-50 text-green-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">APBDesa</a>
                    <a href="{{ route('berita') }}"
                        class="block px-4 py-2 {{ Route::is('berita') ? 'bg-green-50 text-green-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">Berita</a>
                    <a href="{{ route('pengumuman') }}"
                        class="block px-4 py-2 {{ Route::is('pengumuman') ? 'bg-green-50 text-green-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">Pengumuman</a>
                    <a href="{{ route('galeri') }}"
                        class="block px-4 py-2 {{ Route::is('galeri') ? 'bg-green-50 text-green-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">Galeri
                        Desa</a>
                </div>
            </div>

            <a href="{{ route('umkm') }}"
                class="{{ Route::is('umkm') ? 'text-green-700 font-semibold' : 'text-gray-700 font-medium hover:text-green-700' }}">UMKM</a>
            <a href="{{ route('layanan') }}"
                class="{{ Route::is('layanan') ? 'text-green-700 font-semibold' : 'text-gray-700 font-medium hover:text-green-700' }}">Layanan</a>
            <!-- Akhir: konten asli -->
        </div>
    </div>

    <!-- OVERLAY (mobile only) -->
    <div id="overlay"
        class="fixed inset-0 bg-black/45 opacity-0 pointer-events-none transition-opacity duration-200 md:hidden"
        role="presentation" aria-hidden="true"></div>

    <!-- MOBILE PANEL (aria dialog) -->
    <div id="mobile-menu"
        class="fixed top-0 left-0 right-0 translate-y-[-12px] opacity-0 pointer-events-none md:hidden
            bg-white/95 backdrop-blur shadow-xl transition-all duration-200 will-change-transform
            border-b border-gray-100"
        role="dialog" aria-modal="true" aria-labelledby="mobile-menu-title">

        <!-- Header sticky -->
        <div class="sticky top-0 bg-white/90 backdrop-blur border-b border-gray-100">
            <div class="px-4 pt-3 pb-2 flex items-center justify-between">
                <a href="{{ route('/') }}" class="block text-green-700 font-bold text-lg">
                    Desa Mentuda
                </a>

                <!-- Button close -->
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

        <!-- Isi menu -->
        <nav class="px-2 py-2 max-h-[80vh] overflow-y-auto" aria-label="Navigasi utama (mobile)">
            <ul class="divide-y divide-gray-100">

                {{-- BERANDA --}}
                <li>
                    <a href="{{ route('/') }}"
                        class="block px-3 py-3 rounded-lg hover:bg-gray-100
               {{ Route::is('/') ? 'bg-green-50 text-green-700 font-semibold' : 'text-gray-900' }}">
                        Beranda
                    </a>
                </li>

                {{-- PROFIL DESA --}}
                @php
                    $isProfilActive =
                        Route::is('sejarah') ||
                        Route::is('visi-misi') ||
                        Route::is('struktur-desa') ||
                        Route::is('peta-desa');
                @endphp
                <li class="pt-1">
                    <button
                        class="w-full flex items-center justify-between px-3 py-3 rounded-lg hover:bg-gray-100 transition {{ $isProfilActive ? 'bg-green-50 text-green-700 font-semibold' : 'text-gray-900' }}"
                        aria-expanded="{{ $isProfilActive ? 'true' : 'false' }}" aria-controls="acc-profil"
                        data-acc-btn>
                        <span class="font-medium">Profil Desa</span>
                        <svg class="w-4 h-4 transform transition-transform duration-200" data-chev viewBox="0 0 24 24"
                            fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div id="acc-profil"
                        class="{{ $isProfilActive ? 'max-h-[300px]' : 'max-h-0' }} overflow-hidden transition-[max-height] duration-300"
                        data-acc-panel>
                        <div class="pl-6 py-2 space-y-1">
                            <a href="{{ route('sejarah') }}"
                                class="block px-3 py-2 rounded hover:bg-gray-100 {{ Route::is('sejarah') ? 'bg-green-50 text-green-700 font-semibold' : '' }}">Sejarah</a>
                            <a href="{{ route('visi-misi') }}"
                                class="block px-3 py-2 rounded hover:bg-gray-100 {{ Route::is('visi-misi') ? 'bg-green-50 text-green-700 font-semibold' : '' }}">Visi
                                &amp; Misi</a>
                            <a href="{{ route('struktur-desa') }}"
                                class="block px-3 py-2 rounded hover:bg-gray-100 {{ Route::is('struktur-desa') ? 'bg-green-50 text-green-700 font-semibold' : '' }}">Struktur
                                Organisasi</a>
                            <a href="{{ route('peta-desa') }}"
                                class="block px-3 py-2 rounded hover:bg-gray-100 {{ Route::is('peta-desa') ? 'bg-green-50 text-green-700 font-semibold' : '' }}">Peta
                                Desa</a>
                        </div>
                    </div>
                </li>

                {{-- INFORMASI --}}
                @php
                    $isInfoActive =
                        Route::is('data-penduduk') ||
                        Route::is('apbdesa') ||
                        Route::is('potensi-desa') ||
                        Route::is('berita') ||
                        Route::is('pengumuman') ||
                        Route::is('galeri');
                @endphp
                <li class="pt-1">
                    <button
                        class="w-full flex items-center justify-between px-3 py-3 rounded-lg hover:bg-gray-100 transition {{ $isInfoActive ? 'bg-green-50 text-green-700 font-semibold' : 'text-gray-900' }}"
                        aria-expanded="{{ $isInfoActive ? 'true' : 'false' }}" aria-controls="acc-info" data-acc-btn>
                        <span class="font-medium">Informasi</span>
                        <svg class="w-4 h-4 transition-transform duration-200" data-chev viewBox="0 0 24 24"
                            fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>


                    <div id="acc-info"
                        class="{{ $isInfoActive ? 'max-h-[300px]' : 'max-h-0' }} overflow-hidden transition-[max-height] duration-300"
                        data-acc-panel>
                        <div class="pl-6 py-2 space-y-1">
                            <a href="{{ route('data-penduduk') }}"
                                class="block px-3 py-2 rounded hover:bg-gray-100 {{ Route::is('data-penduduk') ? 'bg-green-50 text-green-700 font-semibold' : '' }}">Data
                                Penduduk</a>
                            <a href="{{ route('apbdesa') }}"
                                class="block px-3 py-2 rounded hover:bg-gray-100 {{ Route::is('apbdesa') ? 'bg-green-50 text-green-700 font-semibold' : '' }}">APBDesa</a>
                            <a href="{{ route('potensi-desa') }}"
                                class="block px-3 py-2 rounded hover:bg-gray-100 {{ Route::is('potensi-desa') ? 'bg-green-50 text-green-700 font-semibold' : '' }}">Potensi
                                Desa</a>
                            <a href="{{ route('berita') }}"
                                class="block px-3 py-2 rounded hover:bg-gray-100 {{ Route::is('berita') ? 'bg-green-50 text-green-700 font-semibold' : '' }}">Berita</a>
                            <a href="{{ route('pengumuman') }}"
                                class="block px-3 py-2 rounded hover:bg-gray-100 {{ Route::is('pengumuman') ? 'bg-green-50 text-green-700 font-semibold' : '' }}">Pengumuman</a>
                            <a href="{{ route('galeri') }}"
                                class="block px-3 py-2 rounded hover:bg-gray-100 {{ Route::is('galeri') ? 'bg-green-50 text-green-700 font-semibold' : '' }}">Galeri
                                Desa</a>
                        </div>
                    </div>
                </li>

                {{-- UMKM --}}
                <li class="pt-1">
                    <a href="{{ route('umkm') }}"
                        class="block px-3 py-3 rounded-lg hover:bg-gray-100 {{ Route::is('umkm') ? 'bg-green-50 text-green-700 font-semibold' : 'text-gray-900' }}">
                        UMKM
                    </a>
                </li>

                {{-- LAYANAN --}}
                <li>
                    <a href="{{ route('layanan') }}"
                        class="block px-3 py-3 rounded-lg hover:bg-gray-100 {{ Route::is('layanan') ? 'bg-green-50 text-green-700 font-semibold' : 'text-gray-900' }}">
                        Layanan
                    </a>
                </li>

            </ul>
        </nav>


        <!-- Safe-area bottom spacer -->
        <div class="h-[env(safe-area-inset-bottom,0px)]"></div>
    </div>

</nav>
