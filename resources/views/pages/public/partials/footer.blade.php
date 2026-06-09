@php
    $isHome = request()->routeIs('home');
    $isVisionMission = request()->routeIs('public.vision-mission');
    $isOrganizationStructure = request()->routeIs('public.organization-structure');
    $isVillageMap = request()->routeIs('public.village-map');
    $isHistory = request()->routeIs('public.history');
    $isPotentials = request()->routeIs('public.potentials.*');
    $isPosts = request()->routeIs('public.posts.*');
    $isAnnouncements = request()->routeIs('public.announcements.*');
    $isPopulation = request()->routeIs('public.population.*');
    $isBudgets = request()->routeIs('public.budgets.*');
    $isBusinesses = request()->routeIs('public.businesses.*');
    $isServices = request()->routeIs('public.services.*');
@endphp

<footer class="bg-green-800 text-white" role="contentinfo">
    <div class="mx-auto max-w-7xl px-4 md:px-6 lg:px-8 py-12">
        <div class="grid gap-10 md:gap-8 md:grid-cols-12">
            <section class="md:col-span-5">
                <h2 class="text-xl font-semibold tracking-tight">Desa Mentuda</h2>
                <p class="mt-3 text-sm leading-relaxed text-white/80">
                    Bagian dari Kabupaten Lingga. Kami berkomitmen memberikan pelayanan terbaik serta transparansi
                    informasi bagi masyarakat.
                </p>

                <address class="not-italic mt-5 space-y-1 text-sm text-white/80">
                    <p>Jl. Raya Desa Mentuda, Kab. Lingga</p>
                    <p>
                        Email:
                        <a href="mailto:info@desamentuda.id"
                            class="underline decoration-white/30 hover:decoration-yellow-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-300 rounded">
                            info@desamentuda.id
                        </a>
                    </p>
                    <p>
                        Telp:
                        <a href="#"
                            class="underline decoration-white/30 hover:decoration-yellow-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-300 rounded">
                            +62 812 3456 7890
                        </a>
                    </p>
                </address>

                <div class="mt-4 flex gap-4" aria-label="Sosial media">
                    <a href="https://www.facebook.com/DesaMentuda/" target="_blank" aria-label="Facebook"
                        class="p-2 rounded-lg hover:bg-white/10 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-300 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M22 12.06C22 6.505 17.523 2 12 2S2 6.505 2 12.06c0 5.017 3.657 9.175 8.438 9.94v-7.03H7.898v-2.91h2.54V9.845c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.196 2.238.196v2.46h-1.26c-1.243 0-1.63.776-1.63 1.57v1.884h2.773l-.443 2.91h-2.33v7.03C18.343 21.235 22 17.077 22 12.06z" />
                        </svg>
                    </a>

                    <a href="#" aria-label="Twitter"
                        class="p-2 rounded-lg hover:bg-white/10 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-300 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M19.633 7.997c.013.18.013.36.013.54 0 5.494-4.183 11.828-11.828 11.828-2.35 0-4.532-.69-6.367-1.878.33.038.647.051.99.051 1.94 0 3.726-.66 5.147-1.77a4.168 4.168 0 01-3.89-2.89c.254.038.508.064.775.064.37 0 .74-.051 1.086-.141a4.16 4.16 0 01-3.337-4.083v-.051c.546.304 1.18.49 1.853.515a4.153 4.153 0 01-1.856-3.461c0-.763.204-1.456.558-2.066a11.817 11.817 0 008.574 4.35 4.694 4.694 0 01-.102-.953 4.16 4.16 0 017.197-2.844 8.14 8.14 0 002.64-1.006 4.182 4.182 0 01-1.829 2.3 8.33 8.33 0 002.394-.65 8.989 8.989 0 01-2.09 2.164z" />
                        </svg>
                    </a>

                    <a href="#" aria-label="Instagram"
                        class="p-2 rounded-lg hover:bg-white/10 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-300 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M7 2h10a5 5 0 015 5v10a5 5 0 01-5 5H7a5 5 0 01-5-5V7a5 5 0 015-5zm0 2a3 3 0 00-3 3v10a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H7zm5 3.5a5.5 5.5 0 110 11 5.5 5.5 0 010-11zm0 2a3.5 3.5 0 100 7 3.5 3.5 0 000-7zM18 6.25a1.25 1.25 0 110 2.5 1.25 1.25 0 010-2.5z" />
                        </svg>
                    </a>
                </div>
            </section>

            <nav class="md:col-span-7 grid grid-cols-2 sm:grid-cols-3 gap-8" aria-label="Navigasi footer">
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-white/90">Umum</h3>
                    <ul class="mt-3 space-y-2 text-sm">
                        <li>
                            <a href="{{ route('home') }}"
                                class="{{ $isHome ? 'text-yellow-300' : 'text-white/80 hover:text-yellow-300' }} rounded px-1 transition">
                                Beranda
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('public.businesses.index') }}"
                                class="{{ $isBusinesses ? 'text-yellow-300' : 'text-white/80 hover:text-yellow-300' }} rounded px-1 transition">
                                UMKM
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('public.services.index') }}"
                                class="{{ $isServices ? 'text-yellow-300' : 'text-white/80 hover:text-yellow-300' }} rounded px-1 transition">
                                Layanan
                            </a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-white/90">Profil Desa</h3>
                    <ul class="mt-3 space-y-2 text-sm">
                        <li>
                            <a href="{{ route('public.history') }}"
                                class="{{ $isHistory ? 'text-yellow-300' : 'text-white/80 hover:text-yellow-300' }} rounded px-1 transition">
                                Sejarah
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('public.vision-mission') }}"
                                class="{{ $isVisionMission ? 'text-yellow-300' : 'text-white/80 hover:text-yellow-300' }} rounded px-1 transition">
                                Visi &amp; Misi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('public.organization-structure') }}"
                                class="{{ $isOrganizationStructure ? 'text-yellow-300' : 'text-white/80 hover:text-yellow-300' }} rounded px-1 transition">
                                Struktur
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('public.village-map') }}"
                                class="{{ $isVillageMap ? 'text-yellow-300' : 'text-white/80 hover:text-yellow-300' }} rounded px-1 transition">
                                Peta Desa
                            </a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-white/90">Informasi</h3>
                    <ul class="mt-3 space-y-2 text-sm">
                        <li>
                            <a href="{{ route('public.population.index') }}"
                                class="{{ $isPopulation ? 'text-yellow-300' : 'text-white/80 hover:text-yellow-300' }} rounded px-1 transition">
                                Data Penduduk
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('public.budgets.index') }}"
                                class="{{ $isBudgets ? 'text-yellow-300' : 'text-white/80 hover:text-yellow-300' }} rounded px-1 transition">
                                APBDesa
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('public.potentials.index') }}"
                                class="{{ $isPotentials ? 'text-yellow-300' : 'text-white/80 hover:text-yellow-300' }} rounded px-1 transition">
                                Potensi Desa
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('public.posts.index') }}"
                                class="{{ $isPosts ? 'text-yellow-300' : 'text-white/80 hover:text-yellow-300' }} rounded px-1 transition">
                                Berita
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('public.announcements.index') }}"
                                class="{{ $isAnnouncements ? 'text-yellow-300' : 'text-white/80 hover:text-yellow-300' }} rounded px-1 transition">
                                Pengumuman
                            </a>
                        </li>
                        <li><a href="#" class="text-white/80 hover:text-yellow-300 rounded px-1">Galeri</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div
            class="mx-auto max-w-7xl px-4 md:px-6 lg:px-8 py-4 text-center md:text-left text-sm text-white/80 flex flex-col md:flex-row items-center md:justify-between gap-3">
            <span>
                &copy; <span id="currentYear"></span> Desa Mentuda. All Rights Reserved.
            </span>

            <div class="flex items-center gap-3">
                <span class="hidden md:inline-block">&bull;</span>
                <span>
                    Developed by
                    <a href="#"
                        class="text-yellow-300 hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-300 rounded">
                        Bayu Rez
                    </a>
                </span>
            </div>
        </div>
    </div>
</footer>
