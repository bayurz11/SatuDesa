@php
    $metaTitle = 'Struktur Organisasi Desa';
    $metaDescription = 'Halaman struktur organisasi Desa Mentuda versi statis untuk kebutuhan desain.';
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
                    <li class="font-semibold text-white">Struktur Organisasi</li>
                </ol>
            </nav>

            <div class="mt-8 max-w-4xl">
                <span
                    class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.24em] text-emerald-100 ring-1 ring-white/15">
                    Profil Desa
                </span>

                <h1 class="mt-6 text-4xl font-bold tracking-tight sm:text-5xl">
                    Struktur Organisasi Desa Mentuda
                </h1>

                <p class="mt-4 max-w-2xl text-sm leading-7 text-emerald-50/90 sm:text-base">
                    Halaman ini disiapkan sebagai rancangan visual struktur organisasi pemerintahan desa.
                </p>
            </div>
        </div>
    </section>

    <section class="mx-auto -mt-10 max-w-7xl px-4 pb-20 sm:px-6 lg:px-8 relative z-10">
        <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_320px]">
            <main class="space-y-8">
                <section class="rounded-[32px] border border-gray-200 bg-white p-8 shadow-lg shadow-gray-200/70">
                    <div class="text-center">
                        <span class="text-xs font-semibold uppercase tracking-[0.24em] text-green-700">Bagan Organisasi</span>
                        <h2 class="mt-3 text-3xl font-bold text-gray-900">Susunan Pemerintahan Desa</h2>
                    </div>

                    <div class="mt-8 space-y-6">
                        <div class="mx-auto max-w-md rounded-3xl bg-green-700 p-6 text-center text-white shadow-lg">
                            <p class="text-sm uppercase tracking-[0.24em] text-green-100">Kepala Desa</p>
                            <h3 class="mt-2 text-2xl font-bold">Nama Kepala Desa</h3>
                        </div>

                        <div class="mx-auto h-10 w-px bg-green-200"></div>

                        <div class="grid gap-5 md:grid-cols-3">
                            <div class="rounded-2xl border border-gray-200 bg-white p-5 text-center shadow-sm">
                                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-green-700">Sekretariat</p>
                                <h4 class="mt-2 text-lg font-bold text-gray-900">Sekretaris Desa</h4>
                            </div>
                            <div class="rounded-2xl border border-gray-200 bg-white p-5 text-center shadow-sm">
                                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-green-700">Pelaksana</p>
                                <h4 class="mt-2 text-lg font-bold text-gray-900">Kasi Pemerintahan</h4>
                            </div>
                            <div class="rounded-2xl border border-gray-200 bg-white p-5 text-center shadow-sm">
                                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-green-700">Pelaksana</p>
                                <h4 class="mt-2 text-lg font-bold text-gray-900">Kasi Pelayanan</h4>
                            </div>
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
                            class="flex items-center justify-between rounded-2xl border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-700 transition hover:border-green-200 hover:bg-green-50 hover:text-green-700">
                            <span>Visi &amp; Misi</span>
                            <span>&rarr;</span>
                        </a>
                        <a href="{{ route('public.organization-structure') }}"
                            class="flex items-center justify-between rounded-2xl bg-green-700 px-4 py-3 text-sm font-semibold text-white">
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
