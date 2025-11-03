@extends('layouts.app2')

@section('title', 'Visi & Misi')

@section('content')
    <section class="mx-auto max-w-7xl px-4 md:px-6 lg:px-8 py-10 md:py-14" data-aos="fade-up">

        {{-- Breadcrumb (selaras) --}}
        <nav class="mb-6 mt-8 md:mb-8 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2">
                <li><a href="{{ route('/') }}" class="hover:text-green-700">Beranda</a></li>
                <li aria-hidden="true">/</li>
                <li class="text-green-700 font-medium">Profil Desa</li>
                <li aria-hidden="true">/</li>
                <li class="text-green-700 font-medium">Visi &amp; Misi</li>
            </ol>
        </nav>

        {{-- Heading (selaras) --}}
        <header class="text-center mb-10 md:mb-12">
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-green-700">
                Visi &amp; Misi Desa Mentuda
            </h1>
            <p class="mt-3 md:mt-4 text-gray-600 md:text-lg max-w-2xl mx-auto">
                Komitmen Desa Mentuda untuk membangun masyarakat yang sejahtera, maju, dan berbudaya.
            </p>
        </header>

        <div class="grid gap-8 lg:grid-cols-3 items-start">
            {{-- KONTEN UTAMA --}}
            <article class="lg:col-span-2 space-y-8">

                {{-- Kartu Visi --}}
                <div class="relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5">
                    <div class="p-6 md:p-8">
                        <div class="flex items-center gap-3 mb-4">
                            <span
                                class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 ring-1 ring-green-200">
                                <x-heroicon-o-eye class="size-6 text-green-700" />
                            </span>
                            <h2 class="text-xl md:text-2xl font-semibold text-gray-900">Visi</h2>
                        </div>
                        <div class="mx-auto mb-6 h-1 w-20 rounded-full bg-green-600"></div>

                        <p class="text-gray-700 leading-relaxed md:text-lg">
                            {{ $visimisi->visi ?? 'Belum ada data visi yang aktif.' }}
                        </p>
                    </div>
                    {{-- Kartu Misi --}}
                    <div class="relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5">
                        <div class="p-6 md:p-8">
                            <div class="flex items-center gap-3 mb-4">
                                <span
                                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 ring-1 ring-green-200">
                                    <x-heroicon-o-flag class="size-6 text-green-700" />
                                </span>
                                <h2 class="text-xl md:text-2xl font-semibold text-gray-900">Misi</h2>
                            </div>
                            <div class="mx-auto mb-6 h-1 w-20 rounded-full bg-green-600"></div>

                            <ul class="grid gap-3 md:gap-4">
                                <li class="flex items-start gap-3">
                                    <x-heroicon-o-check-circle class="mt-0.5 size-5 text-green-600" />
                                    <span class="text-gray-700">Meningkatkan kualitas pendidikan, kesehatan, dan
                                        kesejahteraan
                                        masyarakat.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <x-heroicon-o-check-circle class="mt-0.5 size-5 text-green-600" />
                                    <span class="text-gray-700">Mengembangkan potensi pertanian, perikanan, dan pariwisata
                                        berbasis lokal.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <x-heroicon-o-check-circle class="mt-0.5 size-5 text-green-600" />
                                    <span class="text-gray-700">Membangun infrastruktur desa yang berkelanjutan dan ramah
                                        lingkungan.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <x-heroicon-o-check-circle class="mt-0.5 size-5 text-green-600" />
                                    <span class="text-gray-700">Menumbuhkan ekonomi kreatif dan UMKM masyarakat desa.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <x-heroicon-o-check-circle class="mt-0.5 size-5 text-green-600" />
                                    <span class="text-gray-700">Melestarikan budaya dan tradisi Desa Mentuda.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <x-heroicon-o-check-circle class="mt-0.5 size-5 text-green-600" />
                                    <span class="text-gray-700">Meningkatkan tata kelola pemerintahan desa yang transparan,
                                        akuntabel, dan partisipatif.</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Nilai Inti / Prinsip (opsional, selaras sistem kartu) --}}
                    {{-- <div class="grid gap-4 md:grid-cols-3 mt-2 mb-2">
                        <div class="rounded-xl border border-green-200 bg-green-50/60 p-4 shadow-sm">
                            <h3 class="font-semibold text-gray-900">Gotong Royong</h3>
                            <p class="mt-1 text-sm text-gray-700">Partisipasi aktif warga dalam pembangunan.</p>
                        </div>
                        <div class="rounded-xl border border-green-200 bg-green-50/60 p-4 shadow-sm">
                            <h3 class="font-semibold text-gray-900">Transparansi</h3>
                            <p class="mt-1 text-sm text-gray-700">Pengelolaan dana & program terbuka untuk publik.</p>
                        </div>
                        <div class="rounded-xl border border-green-200 bg-green-50/60 p-4 shadow-sm">
                            <h3 class="font-semibold text-gray-900">Keberlanjutan</h3>
                            <p class="mt-1 text-sm text-gray-700">Menjaga lingkungan untuk generasi mendatang.</p>
                        </div>
                    </div> --}}

            </article>

            {{-- SIDEBAR (opsional, konsisten gaya) --}}
            <aside class="space-y-6 lg:sticky lg:top-20">
                <div class="bg-white rounded-xl shadow p-4">
                    <h3 class="font-semibold text-gray-900 mb-3">Tautan Terkait</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="inline-flex items-center gap-2 text-green-700 hover:text-green-800">
                                <x-heroicon-o-user-group class="size-4" /> Struktur Organisasi</a></li>
                        <li><a href="#" class="inline-flex items-center gap-2 text-green-700 hover:text-green-800">
                                <x-heroicon-o-newspaper class="size-4" /> Berita Desa</a></li>
                        <li><a href="#" class="inline-flex items-center gap-2 text-green-700 hover:text-green-800">
                                <x-heroicon-o-map class="size-4" /> Profil Wilayah</a></li>
                    </ul>
                </div>

                <div class="bg-white rounded-xl shadow p-4">
                    <h3 class="font-semibold text-gray-900 mb-3">Kontak</h3>
                    <div class="text-sm text-gray-700 space-y-1">
                        <p>Jl. Raya Desa Mentuda, Kab. Lingga</p>
                        <p>Email: info@desamentuda.id</p>
                        <p>Telp: +62 812 3456 7890</p>
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection
