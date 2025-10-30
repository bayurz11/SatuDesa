 <!-- Navbar -->
 <nav id="navbar"
     class="fixed top-0 left-0 w-full z-50 bg-white/70 backdrop-blur-md shadow-sm -translate-y-full transition-transform duration-500">
     <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between lg:justify-center">

         <!-- Logo (hanya mobile & tablet) -->
         <a href="{{ route('/') }}" class="block md:block lg:hidden text-green-700 font-bold text-lg">
             Desa Mentuda
         </a>

         <!-- Hamburger (Mobile) -->
         <button id="menu-btn" class="md:hidden text-gray-700 hover:text-green-700 focus:outline-none">
             <!-- icon garis 3 -->
             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
             </svg>
         </button>

         <!-- Menu -->
         <div id="menu"
             class="hidden h-auto md:h-10 md:flex flex-col md:flex-row md:items-center md:space-x-8 space-y-4 md:space-y-0 absolute md:static top-full left-0 w-full md:w-auto bg-white/90 md:bg-transparent shadow-md md:shadow-none p-4 md:p-0">

             <a href="{{ route('/') }}"
                 class="{{ Route::is('/') ? 'text-green-700 font-semibold' : 'text-gray-700 font-medium hover:text-green-700' }}">
                 Beranda
             </a>

             <!-- Dropdown Profil Desa -->
             <div class="relative group">
                 <button
                     class="flex items-center font-medium {{ request()->is('sejarah') || request()->is('visi-misi') || request()->is('struktur-desa') || request()->is('potensi-desa') || request()->is('peta-desa') ? 'text-green-700' : 'text-gray-700 hover:text-green-700' }}">
                     Profil Desa
                     <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                     </svg>
                 </button>
                 <!-- Dropdown Menu -->
                 <div
                     class="absolute left-0 mt-2 w-48 bg-white shadow-md rounded-md py-2 opacity-0 invisible group-hover:visible group-hover:opacity-100 transition-all duration-200 z-10">
                     <a href="{{ route('sejarah') }}"
                         class="block px-4 py-2 {{ Route::is('sejarah') ? 'bg-green-50 text-green-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                         Sejarah
                     </a>
                     <a href="{{ route('visi-misi') }}"
                         class="block px-4 py-2 {{ Route::is('visi-misi') ? 'bg-green-50 text-green-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">Visi
                         &
                         Misi</a>
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

             <!-- Dropdown Informasi -->
             <div class="relative group">
                 <button
                     class="text-gray-700 hover:text-green-700 flex items-center font-medium  {{ request()->is('berita') || request()->is('data-penduduk') || request()->is('pengumuman') || request()->is('galeri') ? 'text-green-700' : 'text-gray-700 hover:text-green-700' }}">
                     Informasi
                     <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                     </svg>
                 </button>
                 <!-- Dropdown Menu -->
                 <div
                     class="absolute left-0 mt-2 w-48 bg-white shadow-md rounded-md py-2 opacity-0 invisible group-hover:visible group-hover:opacity-100 transition-all duration-200 z-10">
                     <a href="{{ route('data-penduduk') }}"
                         class="block px-4 py-2 {{ Route::is('data-penduduk') ? 'bg-green-50 text-green-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                         Data Penduduk
                     </a>
                     <a href="{{ route('berita') }}"
                         class="block px-4 py-2 {{ Route::is('berita') ? 'bg-green-50 text-green-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                         Berita
                     </a>
                     <a href="{{ route('pengumuman') }}"
                         class="block px-4 py-2 {{ Route::is('pengumuman') ? 'bg-green-50 text-green-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                         Pengumuman
                     </a>
                     <a href="{{ route('galeri') }}"
                         class="block px-4 py-2 {{ Route::is('galeri') ? 'bg-green-50 text-green-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                         Galeri Desa
                     </a>

                 </div>
             </div>

             <a href="{{ route('umkm') }}"
                 class="{{ Route::is('umkm') ? 'text-green-700 font-semibold' : 'text-gray-700 font-medium hover:text-green-700' }}">UMKM</a>
             <a href="{{ route('layanan') }}"
                 class="{{ Route::is('layanan') ? 'text-green-700 font-semibold' : 'text-gray-700 font-medium hover:text-green-700' }}">Layanan</a>
         </div>

     </div>
 </nav>
