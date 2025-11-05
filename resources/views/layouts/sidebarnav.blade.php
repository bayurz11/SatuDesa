<nav class="mt-8 px-4">
    <div class="space-y-2">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('dashboard') ? 'bg-white bg-opacity-20 text-white' : 'text-green-100 hover:bg-white hover:bg-opacity-10 hover:text-white' }} transition-colors duration-200">

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="h-5 w-5 mr-3">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
            </svg>

            Dashboard
        </a>
        <p class="px-4 text-xs font-semibold text-green-200 uppercase tracking-wider">PROFIL & DATA DESA</p>
        <!-- Profil Desa Dropdown -->
        @php
            $profilActive = request()->routeIs('profil.*');
            $informasiActive = request()->routeIs('informasi.*');
            $pendudukActive = request()->routeIs('penduduk.*');

            $activeMenuInitial = $profilActive
                ? 'profil'
                : ($informasiActive
                    ? 'informasi'
                    : ($pendudukActive
                        ? 'penduduk'
                        : ''));
        @endphp

        <nav x-data="{
            activeMenu: @js($activeMenuInitial),
            ids: $id('accordion', 3) // x-id (butuh Alpine v3.10+)
        }" class="space-y-1">
            {{-- ======================= PROFIL DESA ======================== --}}
            @permission('profil.view')
                <div class="relative">
                    <button @click="activeMenu = (activeMenu === 'profil' ? '' : 'profil')"
                        :aria-expanded="(activeMenu === 'profil').toString()" :aria-controls="ids[0]"
                        class="group relative flex w-full items-center rounded-lg px-4 py-3 text-sm font-medium transition-colors duration-200 {{ $profilActive ? ' text-white' : 'text-green-100 hover:bg-white hover:bg-opacity-10 hover:text-white' }}"
                        type="button">
                        @if ($profilActive)
                            <span class="absolute left-0 top-1/2 h-6 w-1 -translate-y-1/2 rounded-r bg-emerald-400"></span>
                        @endif

                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        <span>Profil Desa</span>

                        <svg :class="{ 'rotate-180': activeMenu === 'profil' }"
                            class="ml-auto h-4 w-4 transform transition-transform duration-200" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div :id="ids[0]" id="menu-profil" x-show="activeMenu === 'profil'" x-collapse
                        class="mt-1 pl-10 space-y-1 overflow-hidden">
                        <a href="{{ route('profil.sejarah-desa') }}"
                            class="block rounded-md px-4 py-2 text-sm {{ request()->routeIs('profil.sejarah-desa') ? 'bg-white bg-opacity-20 text-white' : 'text-green-100 hover:bg-white hover:bg-opacity-10 hover:text-white' }}">
                            Sejarah Desa
                        </a>
                        <a href="{{ route('profil.visi-misi') }}"
                            class="block rounded-md px-4 py-2 text-sm {{ request()->routeIs('profil.visi-misi') ? 'bg-white bg-opacity-20 text-white' : 'text-green-100 hover:bg-white hover:bg-opacity-10 hover:text-white' }}">
                            Visi &amp; Misi
                        </a>
                        <a href="{{ route('profil.struktur-organisasi') }}"
                            class="block rounded-md px-4 py-2 text-sm {{ request()->routeIs('profil.struktur') ? 'bg-white bg-opacity-20 text-white' : 'text-green-100 hover:bg-white hover:bg-opacity-10 hover:text-white' }}">
                            Struktur Organisasi
                        </a>
                        <a href="#"
                            class="block rounded-md px-4 py-2 text-sm {{ request()->routeIs('profil.potensi') ? 'bg-white bg-opacity-20 text-white' : 'text-green-100 hover:bg-white hover:bg-opacity-10 hover:text-white' }}">
                            Potensi Desa
                        </a>
                    </div>
                </div>
            @endpermission

            {{-- =======================INFORMASI ======================== --}}
            @permission('informasi.view')
                <div class="relative">
                    <button @click="activeMenu = (activeMenu === 'informasi' ? '' : 'informasi')"
                        :aria-expanded="(activeMenu === 'informasi').toString()" :aria-controls="ids[1]"
                        class="group flex items-center w-full px-4 py-3 text-sm font-medium rounded-lg {{ $informasiActive ? 'bg-white bg-opacity-20 text-white' : 'text-green-100 hover:bg-white hover:bg-opacity-10 hover:text-white' }} transition-colors duration-200"
                        type="button">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 0 8.835-2.535m0 0A23.74 23.74 0 0 0 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 0 1 0 3.46" />
                        </svg>
                        Informasi

                        <svg :class="{ 'rotate-180': activeMenu === 'informasi' }"
                            class="ml-auto h-4 w-4 transform transition-transform duration-200" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div :id="ids[1]" x-show="activeMenu === 'informasi'" x-collapse
                        class="mt-1 pl-10 space-y-1 overflow-hidden">
                        <a href="#"
                            class="block px-4 py-2 text-sm rounded-md {{ request()->routeIs('informasi.berita') ? 'bg-white bg-opacity-20 text-white' : 'text-green-100 hover:bg-white hover:bg-opacity-10 hover:text-white' }}">
                            Berita
                        </a>
                        <a href="#"
                            class="block px-4 py-2 text-sm rounded-md {{ request()->routeIs('informasi.pengumuman') ? 'bg-white bg-opacity-20 text-white' : 'text-green-100 hover:bg-white hover:bg-opacity-10 hover:text-white' }}">
                            Pengumuman
                        </a>
                        <a href="#"
                            class="block px-4 py-2 text-sm rounded-md {{ request()->routeIs('informasi.galeri') ? 'bg-white bg-opacity-20 text-white' : 'text-green-100 hover:bg-white hover:bg-opacity-10 hover:text-white' }}">
                            Galeri Desa
                        </a>
                    </div>
                </div>
            @endpermission

            {{-- ======================= KEPENDUDUKAN  ======================== --}}
            @permission('penduduk.view')
                <div class="relative">
                    <button @click="activeMenu = (activeMenu === 'penduduk' ? '' : 'penduduk')"
                        :aria-expanded="(activeMenu === 'penduduk').toString()" :aria-controls="ids[2]"
                        class="group flex items-center w-full px-4 py-3 text-sm font-medium rounded-lg {{ $pendudukActive ? 'bg-white bg-opacity-20 text-white' : 'text-green-100 hover:bg-white hover:bg-opacity-10 hover:text-white' }} transition-colors duration-200"
                        type="button">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                        Kependudukan

                        <svg :class="{ 'rotate-180': activeMenu === 'penduduk' }"
                            class="ml-auto h-4 w-4 transform transition-transform duration-200" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div :id="ids[2]" x-show="activeMenu === 'penduduk'" x-collapse
                        class="mt-1 pl-10 space-y-1 overflow-hidden">
                        <a href="#"
                            class="block px-4 py-2 text-sm rounded-md {{ request()->routeIs('penduduk.data') ? 'bg-white bg-opacity-20 text-white' : 'text-green-100 hover:bg-white hover:bg-opacity-10 hover:text-white' }}">
                            Data Penduduk
                        </a>
                        <a href="#"
                            class="block px-4 py-2 text-sm rounded-md {{ request()->routeIs('penduduk.keluarga') ? 'bg-white bg-opacity-20 text-white' : 'text-green-100 hover:bg-white hover:bg-opacity-10 hover:text-white' }}">
                            Kartu Keluarga
                        </a>
                        <a href="#"
                            class="block px-4 py-2 text-sm rounded-md {{ request()->routeIs('penduduk.mutasi') ? 'bg-white bg-opacity-20 text-white' : 'text-green-100 hover:bg-white hover:bg-opacity-10 hover:text-white' }}">
                            Mutasi Penduduk
                        </a>
                        <a href="#"
                            class="block px-4 py-2 text-sm rounded-md {{ request()->routeIs('penduduk.laporan') ? 'bg-white bg-opacity-20 text-white' : 'text-green-100 hover:bg-white hover:bg-opacity-10 hover:text-white' }}">
                            Laporan Penduduk
                        </a>
                    </div>
                </div>
            @endpermission
        </nav>



        <p class="px-4 text-xs font-semibold text-green-200 uppercase tracking-wider">Account Settings</p>
        <!-- User Management -->
        @permission('users.view')
            <a href="{{ route('users.index') }}"
                class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('users.*') ? 'bg-white bg-opacity-20 text-white' : 'text-green-100 hover:bg-white hover:bg-opacity-10 hover:text-white' }} transition-colors duration-200">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>

                Pengguna
            </a>
        @endpermission

        <!-- Role Management -->
        @permission('roles.view')
            <a href="{{ route('roles.index') }}"
                class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('roles.*') ? 'bg-white bg-opacity-20 text-white' : 'text-green-100 hover:bg-white hover:bg-opacity-10 hover:text-white' }} transition-colors duration-200">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                    </path>
                </svg>
                Roles & Permissions
            </a>
        @endpermission

        {{-- <!-- Account Settings -->
        <div class="pt-4 mt-4 border-t border-green-400 border-opacity-30">
            <p class="px-4 text-xs font-semibold text-green-200 uppercase tracking-wider">Account</p>
            <div class="mt-2 space-y-2">
                <a href="{{ route('profile.index') }}"
                    class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('profile.*') ? 'bg-white bg-opacity-20 text-white' : 'text-green-100 hover:bg-white hover:bg-opacity-10 hover:text-white' }} transition-colors duration-200">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Profile Settings
                </a>
            </div>
        </div> --}}


</nav>
