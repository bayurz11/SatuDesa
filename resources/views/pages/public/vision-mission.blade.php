@php
    $metaTitle = 'Visi & Misi Desa';
    $metaDescription = 'Halaman visi dan misi Desa Mentuda versi statis untuk kebutuhan desain.';
@endphp

@extends('layouts.public')

@section('content')
    <section class="relative overflow-hidden bg-gradient-to-br from-green-950 via-green-900 to-emerald-800 text-white mt-16">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.16),_transparent_32%)]"></div>

        <div class="relative mx-auto max-w-7xl px-4 pb-20 pt-10 sm:px-6 lg:px-8">
            <nav class="text-sm text-emerald-100/80" aria-label="Breadcrumb">
                <ol class="flex flex-wrap items-center gap-2">
                    <li><a href="{{ route('home') }}" class="transition hover:text-white">Beranda</a></li>
                    <li>/</li>
                    <li>Profil Desa</li>
                    <li>/</li>
                    <li class="font-semibold text-white">Visi &amp; Misi</li>
                </ol>
            </nav>

            <div class="mt-8 max-w-4xl">
                <span
                    class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.24em] text-emerald-100 ring-1 ring-white/15">
                    Profil Desa
                </span>

                <h1 class="mt-6 text-4xl font-bold tracking-tight sm:text-5xl">
                    Visi &amp; Misi Desa Mentuda
                </h1>

                <p class="mt-4 max-w-2xl text-sm leading-7 text-emerald-50/90 sm:text-base">
                    Halaman ini disiapkan sebagai ruang desain untuk menampilkan arah pembangunan desa,
                    cita-cita jangka panjang, dan nilai-nilai pelayanan masyarakat.
                </p>
            </div>
        </div>
    </section>

    <section class="mx-auto -mt-10 max-w-7xl px-4 pb-20 sm:px-6 lg:px-8 relative z-10">
        <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_320px]">
            <main class="space-y-8">
                <article class="rounded-[32px] border border-gray-200 bg-white p-8 shadow-lg shadow-gray-200/70">
                    <span class="text-xs font-semibold uppercase tracking-[0.24em] text-green-700">Visi Desa</span>
                    <h2 class="mt-3 text-3xl font-bold tracking-tight text-gray-900">
                        Mewujudkan Desa Mentuda yang Maju, Mandiri, Sejahtera, dan Berdaya Saing
                    </h2>
                    <p class="mt-5 text-sm leading-8 text-gray-600 sm:text-base">
                        Visi ini menjadi landasan besar dalam penyusunan kebijakan, pelayanan publik,
                        penguatan ekonomi lokal, dan pembangunan sosial budaya masyarakat desa.
                    </p>
                </article>

                <section class="rounded-[32px] border border-gray-200 bg-white p-8 shadow-md shadow-gray-200/60">
                    <span class="text-xs font-semibold uppercase tracking-[0.24em] text-green-700">Misi Desa</span>
                    <div class="mt-6 grid gap-5">
                        <div class="rounded-2xl bg-green-50 p-5">
                            <h3 class="text-lg font-bold text-gray-900">1. Meningkatkan kualitas pelayanan publik</h3>
                            <p class="mt-2 text-sm leading-7 text-gray-600">
                                Menghadirkan pelayanan yang cepat, terbuka, ramah, dan berbasis kebutuhan masyarakat.
                            </p>
                        </div>

                        <div class="rounded-2xl bg-white ring-1 ring-gray-100 p-5">
                            <h3 class="text-lg font-bold text-gray-900">2. Mengembangkan ekonomi masyarakat desa</h3>
                            <p class="mt-2 text-sm leading-7 text-gray-600">
                                Mendorong pertumbuhan UMKM, pemanfaatan potensi lokal, dan peluang usaha berbasis desa.
                            </p>
                        </div>

                        <div class="rounded-2xl bg-white ring-1 ring-gray-100 p-5">
                            <h3 class="text-lg font-bold text-gray-900">3. Memperkuat pembangunan sosial dan budaya</h3>
                            <p class="mt-2 text-sm leading-7 text-gray-600">
                                Menjaga nilai gotong royong, harmoni sosial, serta identitas budaya masyarakat desa.
                            </p>
                        </div>

                        <div class="rounded-2xl bg-white ring-1 ring-gray-100 p-5">
                            <h3 class="text-lg font-bold text-gray-900">4. Mendorong tata kelola pemerintahan yang transparan</h3>
                            <p class="mt-2 text-sm leading-7 text-gray-600">
                                Memastikan informasi publik mudah diakses dan pembangunan desa berjalan akuntabel.
                            </p>
                        </div>
                    </div>
                </section>
            </main>

            <aside class="space-y-6 lg:sticky lg:top-24 lg:self-start">
                <div class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60">
                    <h2 class="text-lg font-bold text-gray-900">Bagian Profil</h2>
                    <div class="mt-5 space-y-3">
                        <a href="{{ route('public.history') }}"
                            class="flex items-center justify-between rounded-2xl border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-700 transition hover:border-green-200 hover:bg-green-50 hover:text-green-700">
                            <span>Sejarah Desa</span>
                            <span>&rarr;</span>
                        </a>
                        <a href="{{ route('public.vision-mission') }}"
                            class="flex items-center justify-between rounded-2xl bg-green-700 px-4 py-3 text-sm font-semibold text-white">
                            <span>Visi &amp; Misi</span>
                            <span>&rarr;</span>
                        </a>
                        <a href="{{ route('public.organization-structure') }}"
                            class="flex items-center justify-between rounded-2xl border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-700 transition hover:border-green-200 hover:bg-green-50 hover:text-green-700">
                            <span>Struktur Organisasi</span>
                            <span>&rarr;</span>
                        </a>
                        <a href="{{ route('public.village-map') }}"
                            class="flex items-center justify-between rounded-2xl border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-700 transition hover:border-green-200 hover:bg-green-50 hover:text-green-700">
                            <span>Peta Desa</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection
