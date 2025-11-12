@extends('layouts.app2')

@section('title', 'Layanan Masyarakat Desa')

@section('content')
    <section class="mx-auto max-w-7xl px-4 md:px-6 lg:px-8 py-10 md:py-14" data-aos="fade-up">

        {{-- Breadcrumb (selaras) --}}
        <nav class="mb-6 mt-8 md:mb-8 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2">
                <li><a href="{{ route('beranda') }}" class="hover:text-green-700">Beranda</a></li>
                <li aria-hidden="true">/</li>
                <li class="text-green-700 font-medium">Layanan Masyarakat</li>
            </ol>
        </nav>

        {{-- Heading (selaras) --}}
        <header class="text-center mb-10 md:mb-12">
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-green-700">
                Layanan Masyarakat Desa Mentuda
            </h1>
            <p class="mt-3 md:mt-4 text-gray-600 md:text-lg max-w-2xl mx-auto">
                Halaman ini sedang dalam pengembangan. Nantikan info layanan unggulan dan kemudahan akses bagi warga.
            </p>
        </header>

        <div class="grid gap-8 lg:grid-cols-3 items-start">
            {{-- KONTEN UTAMA --}}
            <article class="lg:col-span-2 space-y-8">

                {{-- Status Pengembangan --}}
                <div class="relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5">
                    <div class="p-6 md:p-8">
                        <div class="flex items-start gap-4">
                            <span
                                class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 ring-1 ring-amber-200 shrink-0">
                                <x-heroicon-o-cog-6-tooth class="size-7 text-amber-600" />
                            </span>
                            <div class="min-w-0">
                                <h2 class="text-lg md:text-xl font-semibold text-gray-900">Sedang Disiapkan</h2>
                                <p class="mt-1 text-gray-700">
                                    Kami sedang menyiapkan portal layanan terpadu: pengajuan surat, pengaduan warga, jadwal
                                    layanan,
                                    dan pelacakan status. Sementara, lihat pratayang tata letak layanan di bawah.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pratayang Katalog Layanan (statik) --}}
                <div>
                    <h3 class="mb-4 text-base md:text-lg font-semibold text-gray-900">Pratayang Layanan</h3>

                    <div class="grid gap-4 sm:grid-cols-2">
                        {{-- Kartu layanan 1 --}}
                        <a href="{{ route('public-login') }}"
                            class="group rounded-2xl bg-white shadow ring-1 ring-black/5 p-5 hover:shadow-md transition block">
                            <div class="flex items-start gap-3">
                                <span
                                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 ring-1 ring-green-200">
                                    <x-heroicon-o-document-text class="size-6 text-green-700" />
                                </span>
                                <div class="min-w-0">
                                    <h4 class="font-semibold text-gray-900">Administrasi Surat</h4>
                                    <p class="mt-1 text-sm text-gray-600 line-clamp-2">Pengajuan surat keterangan domisili,
                                        usaha, belum menikah, dan lainnya.</p>
                                    <span class="mt-2 inline-flex items-center gap-1 text-sm text-green-700">
                                        <x-heroicon-o-arrow-right class="size-4" /> Ajukan sekarang
                                    </span>
                                </div>
                            </div>
                        </a>

                        {{-- Kartu layanan 2 --}}
                        <a href="#"
                            class="group rounded-2xl bg-white shadow ring-1 ring-black/5 p-5 hover:shadow-md transition block">
                            <div class="flex items-start gap-3">
                                <span
                                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 ring-1 ring-green-200">
                                    <x-heroicon-o-megaphone class="size-6 text-green-700" />
                                </span>
                                <div class="min-w-0">
                                    <h4 class="font-semibold text-gray-900">Pengaduan Warga</h4>
                                    <p class="mt-1 text-sm text-gray-600 line-clamp-2">Sampaikan keluhan terkait lingkungan,
                                        fasilitas umum, atau layanan publik.</p>
                                    <span class="mt-2 inline-flex items-center gap-1 text-sm text-green-700">
                                        <x-heroicon-o-arrow-right class="size-4" /> Buat pengaduan
                                    </span>
                                </div>
                            </div>
                        </a>

                        {{-- Kartu layanan 3 --}}
                        <a href="#"
                            class="group rounded-2xl bg-white shadow ring-1 ring-black/5 p-5 hover:shadow-md transition block">
                            <div class="flex items-start gap-3">
                                <span
                                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 ring-1 ring-green-200">
                                    <x-heroicon-o-calendar-days class="size-6 text-green-700" />
                                </span>
                                <div class="min-w-0">
                                    <h4 class="font-semibold text-gray-900">Jadwal & Antrian</h4>
                                    <p class="mt-1 text-sm text-gray-600 line-clamp-2">Cek jadwal pelayanan, antrian RT/RW,
                                        dan kegiatan layanan keliling.</p>
                                    <span class="mt-2 inline-flex items-center gap-1 text-sm text-green-700">
                                        <x-heroicon-o-arrow-right class="size-4" /> Lihat jadwal
                                    </span>
                                </div>
                            </div>
                        </a>

                        {{-- Kartu layanan 4 --}}
                        <a href="#"
                            class="group rounded-2xl bg-white shadow ring-1 ring-black/5 p-5 hover:shadow-md transition block">
                            <div class="flex items-start gap-3">
                                <span
                                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 ring-1 ring-green-200">
                                    <x-heroicon-o-map-pin class="size-6 text-green-700" />
                                </span>
                                <div class="min-w-0">
                                    <h4 class="font-semibold text-gray-900">Layanan RT/RW</h4>
                                    <p class="mt-1 text-sm text-gray-600 line-clamp-2">Kontak pengurus wilayah, domisili
                                        RT/RW, dan jadwal posko.</p>
                                    <span class="mt-2 inline-flex items-center gap-1 text-sm text-green-700">
                                        <x-heroicon-o-arrow-right class="size-4" /> Hubungi RT/RW
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- CTA Bantuan --}}
                <div class="rounded-2xl border border-green-200 bg-green-50/60 p-5 md:p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                        <div>
                            <h3 class="text-base md:text-lg font-semibold text-gray-900">Butuh bantuan cepat?</h3>
                            <p class="text-sm text-gray-700">Hubungi admin layanan untuk panduan pengajuan.</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="#"
                                class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 transition">
                                <x-heroicon-o-chat-bubble-left-right class="size-4" /> Chat Admin
                            </a>
                            <a href="#"
                                class="inline-flex items-center gap-2 rounded-lg border border-green-600 px-4 py-2 text-sm font-medium text-green-700 hover:bg-green-600 hover:text-white transition">
                                <x-heroicon-o-inbox class="size-4" /> Kirim Pesan
                            </a>
                        </div>
                    </div>
                </div>

            </article>

            {{-- SIDEBAR (selaras gaya) --}}
            <aside class="space-y-6 lg:sticky lg:top-20">

                {{-- Jam Layanan --}}
                <div class="bg-white rounded-xl shadow p-4">
                    <h3 class="font-semibold text-gray-900 mb-3">Jam Layanan</h3>
                    <dl class="text-sm text-gray-700 space-y-2">
                        <div class="flex items-center justify-between">
                            <dt>Senin–Jumat</dt>
                            <dd>08.00–15.00</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt>Sabtu</dt>
                            <dd>09.00–12.00</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt>Minggu & Libur</dt>
                            <dd>Tutup</dd>
                        </div>
                    </dl>
                </div>

                {{-- Tautan Cepat --}}
                <div class="bg-white rounded-xl shadow p-4">
                    <h3 class="font-semibold text-gray-900 mb-3">Tautan Cepat</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="inline-flex items-center gap-2 text-green-700 hover:text-green-800">
                                <x-heroicon-o-document-plus class="size-4" /> Ajukan Surat</a></li>
                        <li><a href="#" class="inline-flex items-center gap-2 text-green-700 hover:text-green-800">
                                <x-heroicon-o-megaphone class="size-4" /> Buat Pengaduan</a></li>
                        <li><a href="#" class="inline-flex items-center gap-2 text-green-700 hover:text-green-800">
                                <x-heroicon-o-calendar-days class="size-4" /> Cek Jadwal</a></li>
                    </ul>
                </div>

                {{-- Tombol Kembali --}}
                <div class="bg-white rounded-xl shadow p-4">
                    <a href="#"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 transition">
                        <x-heroicon-o-arrow-left class="size-4" /> Kembali ke Beranda
                    </a>
                </div>
            </aside>
        </div>
    </section>
@endsection
