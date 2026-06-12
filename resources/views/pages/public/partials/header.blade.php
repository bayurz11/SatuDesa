<!-- Hero Section -->
<section
    class="relative min-h-screen flex flex-col items-center justify-center text-center pt-24 bg-cover bg-center bg-no-repeat"
    style="background-image: url('{{ asset('img/bg.jpg') }}');">

    <div class="absolute inset-0 bg-gradient-to-b from-white/70 via-white/100 to-transparent"></div>
    <div class="absolute inset-x-0 bottom-0 h-40 bg-gradient-to-b from-transparent to-white"></div>

    <div class="relative z-10 flex flex-col items-center">
        <img src="https://linggakab.go.id/resources/config/icon_256.png" alt="Logo Desa" class="w-28 mb-6"
            data-aos="fade-up">

        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 text-center mt-2 flex flex-col items-center">
            <h1 class="text-3xl md:text-4xl font-bold text-green-700" data-aos="fade-up" data-aos-delay="100">
                Desa Mentuda
            </h1>
            <p class="text-gray-800 mt-2 text-sm sm:text-base md:text-lg text-center" data-aos="fade-up"
                data-aos-delay="200">
                Selamat Datang Di Portal Pemerintahan Desa Mentuda
            </p>
        </div>

        <!-- Search Section -->
        <div class="relative z-30 w-full max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 mt-8" data-aos="fade-up"
            data-aos-delay="250">

            <div x-data="{
                open: false,
                selected: 'Semua Informasi',
                value: '',
                placeholders: {
                    all: 'Cari berita, pengumuman, layanan, UMKM...',
                    berita: 'Cari judul atau isi berita desa...',
                    pengumuman: 'Cari pengumuman desa...',
                    potensi: 'Cari potensi desa...',
                    umkm: 'Cari produk UMKM desa...',
                    apbdesa: 'Cari informasi APBDesa...',
                    layanan: 'Cari layanan desa...',
                    penduduk: 'Cari informasi data penduduk...'
                },
                get currentPlaceholder() {
                    return this.placeholders[this.value || 'all'];
                }
            }" class="relative">

                <form action="{{ route('public.search') }}" method="GET"
                    class="bg-white/90 backdrop-blur-md rounded-2xl shadow-xl ring-1 ring-gray-100 p-2 flex flex-col sm:flex-row gap-2">

                    <input type="hidden" name="category" :value="value">

                    <!-- Custom Select -->
                    <div class="relative sm:w-56">

                        <button type="button" @click="open=!open"
                            class="group w-full flex items-center justify-between rounded-xl border border-gray-200 bg-gray-50 px-5 py-3 text-sm font-semibold text-gray-700 transition-all duration-300 hover:bg-white hover:border-green-400 focus:ring-2 focus:ring-green-100">

                            <span x-text="selected"></span>

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 text-green-600 transition-transform duration-300"
                                :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19 9-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            @click.outside="open=false"
                            class="absolute left-0 top-[105%] z-50 w-full overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-2xl ring-1 ring-black/5">

                            <!-- Semua -->
                            <button type="button" @click="selected='Semua Informasi';value='';open=false"
                                class="flex w-full items-center gap-3 px-4 py-3 text-left text-sm font-medium transition hover:bg-green-50 hover:text-green-700">
                                <img src="https://img.icons8.com/color/48/menu.png" class="w-5 h-5" alt="">
                                Semua Informasi
                            </button>

                            <!-- Berita -->
                            <button type="button" @click="selected='Berita';value='berita';open=false"
                                class="flex w-full items-center gap-3 px-4 py-3 text-left text-sm font-medium transition hover:bg-green-50 hover:text-green-700">
                                <img src="https://img.icons8.com/color/48/news.png" class="w-5 h-5" alt="">
                                Berita
                            </button>

                            <!-- Pengumuman -->
                            <button type="button" @click="selected='Pengumuman';value='pengumuman';open=false"
                                class="flex w-full items-center gap-3 px-4 py-3 text-left text-sm font-medium transition hover:bg-green-50 hover:text-green-700">
                                <img src="https://img.icons8.com/color/48/megaphone.png" class="w-5 h-5" alt="">
                                Pengumuman
                            </button>

                            <!-- Potensi -->
                            <button type="button" @click="selected='Potensi Desa';value='potensi';open=false"
                                class="flex w-full items-center gap-3 px-4 py-3 text-left text-sm font-medium transition hover:bg-green-50 hover:text-green-700">
                                <img src="https://img.icons8.com/color/48/village.png" class="w-5 h-5" alt="">
                                Potensi Desa
                            </button>

                            <!-- UMKM -->
                            <button type="button" @click="selected='UMKM';value='umkm';open=false"
                                class="flex w-full items-center gap-3 px-4 py-3 text-left text-sm font-medium transition hover:bg-green-50 hover:text-green-700">
                                <img src="https://img.icons8.com/color/48/shop.png" class="w-5 h-5" alt="">
                                UMKM
                            </button>

                            <!-- APBDesa -->
                            <button type="button" @click="selected='APBDesa';value='apbdesa';open=false"
                                class="flex w-full items-center gap-3 px-4 py-3 text-left text-sm font-medium transition hover:bg-green-50 hover:text-green-700">
                                <img src="https://img.icons8.com/color/48/money-bag.png" class="w-5 h-5" alt="">
                                APBDesa
                            </button>

                            <!-- Layanan -->
                            <button type="button" @click="selected='Layanan Desa';value='layanan';open=false"
                                class="flex w-full items-center gap-3 px-4 py-3 text-left text-sm font-medium transition hover:bg-green-50 hover:text-green-700">
                                <img src="https://img.icons8.com/color/48/services.png" class="w-5 h-5" alt="">
                                Layanan Desa
                            </button>

                            <!-- Penduduk -->
                            <button type="button" @click="selected='Data Penduduk';value='penduduk';open=false"
                                class="flex w-full items-center gap-3 px-4 py-3 text-left text-sm font-medium transition hover:bg-green-50 hover:text-green-700">
                                <img src="https://img.icons8.com/color/48/combo-chart.png" class="w-5 h-5"
                                    alt="">
                                Data Penduduk
                            </button>

                        </div>
                    </div>

                    <!-- Search -->
                    <div class="relative flex-1">

                        <input type="text" name="q" placeholder="Cari berita, pengumuman, layanan, UMKM..."
                            :placeholder="currentPlaceholder"
                            class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 pl-11 text-sm text-gray-700 outline-none transition-all duration-300 focus:border-green-500 focus:ring-2 focus:ring-green-100">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" />
                        </svg>

                    </div>

                    <!-- Button -->
                    <button type="submit"
                        class="group inline-flex items-center justify-center gap-2 rounded-xl bg-green-700 px-6 py-3 text-sm font-semibold text-white shadow-md transition-all duration-300 hover:-translate-y-0.5 hover:bg-green-800 hover:shadow-xl active:scale-95">

                        Cari

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>

                    </button>

                </form>

            </div>
        </div>

        <div class="max-w-screen-lg mx-auto px-4 sm:px-6 lg:px-8 mt-8" data-aos="fade-up" data-aos-delay="300">
            <div class="flex flex-wrap justify-center gap-3 md:gap-4">
                <a href="{{ route('public.posts.index') }}"
                    class="group relative overflow-hidden bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 w-[72px] h-[72px] sm:w-[80px] sm:h-[80px] md:w-[88px] md:h-[88px] flex flex-col items-center justify-center hover:-translate-y-1.5 hover:shadow-lg hover:ring-green-200 active:scale-95 transition-all duration-300 cursor-pointer">
                    <span
                        class="absolute -left-10 top-0 h-full w-8 rotate-12 bg-green-100/70 blur-md transition-all duration-700 group-hover:left-[120%]"></span>
                    <img src="https://img.icons8.com/color/96/000000/news.png"
                        class="relative z-10 w-7 h-7 md:w-8 md:h-8 transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1 group-hover:rotate-6"
                        alt="Berita">
                    <p
                        class="relative z-10 mt-2 text-[9px] md:text-[10px] font-semibold text-gray-700 text-center group-hover:text-green-700 transition">
                        Berita
                    </p>
                </a>

                <a href="{{ route('public.village-map') }}"
                    class="group relative overflow-hidden bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 w-[72px] h-[72px] sm:w-[80px] sm:h-[80px] md:w-[88px] md:h-[88px] flex flex-col items-center justify-center hover:-translate-y-1.5 hover:shadow-lg hover:ring-green-200 active:scale-95 transition-all duration-300 cursor-pointer">
                    <span
                        class="absolute -left-10 top-0 h-full w-8 rotate-12 bg-green-100/70 blur-md transition-all duration-700 group-hover:left-[120%]"></span>
                    <img src="https://img.icons8.com/color/96/000000/worldwide-location.png"
                        class="relative z-10 w-7 h-7 md:w-8 md:h-8 transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1 group-hover:-rotate-6"
                        alt="Peta Desa">
                    <p
                        class="relative z-10 mt-2 text-[9px] md:text-[10px] font-semibold text-gray-700 text-center group-hover:text-green-700 transition">
                        Peta Desa
                    </p>
                </a>

                <a href="{{ route('public.organization-structure') }}"
                    class="group relative overflow-hidden bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 w-[72px] h-[72px] sm:w-[80px] sm:h-[80px] md:w-[88px] md:h-[88px] flex flex-col items-center justify-center hover:-translate-y-1.5 hover:shadow-lg hover:ring-green-200 active:scale-95 transition-all duration-300 cursor-pointer px-1">
                    <span
                        class="absolute -left-10 top-0 h-full w-8 rotate-12 bg-green-100/70 blur-md transition-all duration-700 group-hover:left-[120%]"></span>
                    <img src="https://img.icons8.com/color/96/000000/organization.png"
                        class="relative z-10 w-7 h-7 md:w-8 md:h-8 transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1 group-hover:rotate-6"
                        alt="Struktur Organisasi">
                    <p
                        class="relative z-10 mt-2 text-[8px] md:text-[9px] leading-tight font-semibold text-gray-700 text-center group-hover:text-green-700 transition">
                        Struktur Organisasi
                    </p>
                </a>

                <a href="{{ route('public.businesses.index') }}"
                    class="group relative overflow-hidden bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 w-[72px] h-[72px] sm:w-[80px] sm:h-[80px] md:w-[88px] md:h-[88px] flex flex-col items-center justify-center hover:-translate-y-1.5 hover:shadow-lg hover:ring-green-200 active:scale-95 transition-all duration-300 cursor-pointer">
                    <span
                        class="absolute -left-10 top-0 h-full w-8 rotate-12 bg-green-100/70 blur-md transition-all duration-700 group-hover:left-[120%]"></span>
                    <img src="https://img.icons8.com/color/96/000000/shop.png"
                        class="relative z-10 w-7 h-7 md:w-8 md:h-8 transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1 group-hover:-rotate-6"
                        alt="UMKM">
                    <p
                        class="relative z-10 mt-2 text-[9px] md:text-[10px] font-semibold text-gray-700 text-center group-hover:text-green-700 transition">
                        UMKM
                    </p>
                </a>

                <a href="{{ route('public.population.index') }}"
                    class="group relative overflow-hidden bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 w-[72px] h-[72px] sm:w-[80px] sm:h-[80px] md:w-[88px] md:h-[88px] flex flex-col items-center justify-center hover:-translate-y-1.5 hover:shadow-lg hover:ring-green-200 active:scale-95 transition-all duration-300 cursor-pointer px-1">
                    <span
                        class="absolute -left-10 top-0 h-full w-8 rotate-12 bg-green-100/70 blur-md transition-all duration-700 group-hover:left-[120%]"></span>
                    <img src="https://img.icons8.com/color/96/000000/combo-chart.png"
                        class="relative z-10 w-7 h-7 md:w-8 md:h-8 transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1 group-hover:rotate-6"
                        alt="Statistik Penduduk">
                    <p
                        class="relative z-10 mt-2 text-[8px] md:text-[9px] leading-tight font-semibold text-gray-700 text-center group-hover:text-green-700 transition">
                        Statistik Penduduk
                    </p>
                </a>

                <a href="{{ route('public.announcements.index') }}"
                    class="group relative overflow-hidden bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 w-[72px] h-[72px] sm:w-[80px] sm:h-[80px] md:w-[88px] md:h-[88px] flex flex-col items-center justify-center hover:-translate-y-1.5 hover:shadow-lg hover:ring-green-200 active:scale-95 transition-all duration-300 cursor-pointer">
                    <span
                        class="absolute -left-10 top-0 h-full w-8 rotate-12 bg-green-100/70 blur-md transition-all duration-700 group-hover:left-[120%]"></span>
                    <img src="https://img.icons8.com/color/96/000000/megaphone.png"
                        class="relative z-10 w-7 h-7 md:w-8 md:h-8 transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1 group-hover:-rotate-6"
                        alt="Pengumuman">
                    <p
                        class="relative z-10 mt-2 text-[9px] md:text-[10px] font-semibold text-gray-700 text-center group-hover:text-green-700 transition">
                        Pengumuman
                    </p>
                </a>

                <a href="{{ route('public.budgets.index') }}"
                    class="group relative overflow-hidden bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 w-[72px] h-[72px] sm:w-[80px] sm:h-[80px] md:w-[88px] md:h-[88px] flex flex-col items-center justify-center hover:-translate-y-1.5 hover:shadow-lg hover:ring-green-200 active:scale-95 transition-all duration-300 cursor-pointer">
                    <span
                        class="absolute -left-10 top-0 h-full w-8 rotate-12 bg-green-100/70 blur-md transition-all duration-700 group-hover:left-[120%]"></span>
                    <img src="https://img.icons8.com/color/96/000000/money-bag.png"
                        class="relative z-10 w-7 h-7 md:w-8 md:h-8 transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1 group-hover:rotate-6"
                        alt="APBDesa">
                    <p
                        class="relative z-10 mt-2 text-[9px] md:text-[10px] font-semibold text-gray-700 text-center group-hover:text-green-700 transition">
                        APBDesa
                    </p>
                </a>

                <a href="{{ route('public.potentials.index') }}"
                    class="group relative overflow-hidden bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 w-[72px] h-[72px] sm:w-[80px] sm:h-[80px] md:w-[88px] md:h-[88px] flex flex-col items-center justify-center hover:-translate-y-1.5 hover:shadow-lg hover:ring-green-200 active:scale-95 transition-all duration-300 cursor-pointer px-1">
                    <span
                        class="absolute -left-10 top-0 h-full w-8 rotate-12 bg-green-100/70 blur-md transition-all duration-700 group-hover:left-[120%]"></span>
                    <img src="https://img.icons8.com/color/96/000000/village.png"
                        class="relative z-10 w-7 h-7 md:w-8 md:h-8 transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1 group-hover:-rotate-6"
                        alt="Potensi Desa">
                    <p
                        class="relative z-10 mt-2 text-[8px] md:text-[9px] leading-tight font-semibold text-gray-700 text-center group-hover:text-green-700 transition">
                        Potensi Desa
                    </p>
                </a>
            </div>
        </div>
    </div>

    <div x-data="{ show: true }" x-init="window.addEventListener('scroll', () => { show = window.scrollY < 50 })" x-show="show" x-transition
        class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 md:bottom-8 md:right-8 lg:bottom-10 lg:right-10 z-10 flex flex-col items-center text-green-700">
        <span class="font-bold text-[10px] sm:text-xs tracking-widest mb-1 [writing-mode:vertical-rl]">SCROLL</span>

        <div class="w-4 h-8 sm:w-5 sm:h-10 border-2 border-green-700 rounded-full flex justify-center my-1">
            <div class="w-1 h-2 sm:h-3 bg-green-700 mt-1 rounded-full animate-[bounceHigh_1.5s_infinite]"></div>
        </div>

        <span class="font-bold text-[10px] sm:text-xs tracking-widest mt-1 [writing-mode:vertical-rl]">DOWN</span>
    </div>
</section>
