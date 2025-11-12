@extends('layouts.app2')

@section('title', 'Masuk Layanan Publik')

@section('content')
    <section class="mx-auto max-w-7xl px-4 md:px-6 lg:px-8 py-10 md:py-14" data-aos="fade-up">
        {{-- Breadcrumb --}}
        <nav class="mb-6 mt-8 md:mb-8 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2">
                <li><a href="{{ route('beranda') }}" class="hover:text-green-700">Beranda</a></li>
                <li aria-hidden="true">/</li>
                <li class="text-green-700 font-medium">Masuk</li>
            </ol>
        </nav>

        {{-- Heading --}}
        <header class="text-center mb-8 md:mb-12">
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-green-700">
                Masuk Layanan Publik Desa Mentuda
            </h1>
            <p class="mt-3 md:mt-4 text-gray-600 md:text-lg max-w-2xl mx-auto">
                Pratayang statis halaman masuk untuk <span class="font-semibold">Warga</span>.
                Fitur autentikasi akan diaktifkan kemudian.
            </p>
        </header>

        <div class="grid gap-8 lg:grid-cols-3 items-start">
            {{-- KARTU: Warga --}}
            <article class="lg:col-span-2">
                <div class="rounded-2xl bg-white shadow ring-1 ring-black/5 p-6 md:p-8">
                    {{-- Judul kartu --}}
                    <h2 class="text-lg md:text-xl font-semibold text-gray-900">Masuk sebagai Warga</h2>
                    <p class="mt-1 text-sm text-gray-600">Gunakan NIK dan tanggal lahir untuk verifikasi (contoh tampilan).
                    </p>

                    {{-- Form (statis / non-aktif) --}}
                    <div class="mt-6 space-y-5">
                        <div class="grid gap-5 sm:grid-cols-2">
                            {{-- NIK --}}
                            <div class="sm:col-span-2">
                                <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                                <div class="mt-1 relative">
                                    <span
                                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                        <x-heroicon-o-identification class="size-5" />
                                    </span>
                                    <input type="text" id="nik" placeholder="16 digit NIK"
                                        class="block w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 pl-10 bg-gray-50"
                                        disabled>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Angka saja, tanpa spasi atau tanda.</p>
                            </div>

                            {{-- Tanggal Lahir --}}
                            <div>
                                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal
                                    Lahir</label>
                                <div class="mt-1 relative">
                                    <span
                                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                        <x-heroicon-o-calendar-days class="size-5" />
                                    </span>
                                    <input type="text" id="tanggal_lahir" placeholder="yyyy-mm-dd"
                                        class="block w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 pl-10 bg-gray-50"
                                        disabled>
                                </div>
                            </div>

                            {{-- No. HP (opsional) --}}
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">No. HP
                                    (opsional)</label>
                                <div class="mt-1 relative">
                                    <span
                                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                        <x-heroicon-o-phone class="size-5" />
                                    </span>
                                    <input type="text" id="phone" placeholder="08xxxxxxxxxx"
                                        class="block w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 pl-10 bg-gray-50"
                                        disabled>
                                </div>
                            </div>
                        </div>

                        {{-- Persetujuan (statis) --}}
                        <div class="flex items-start gap-3 text-sm text-gray-600">
                            <input type="checkbox" class="mt-1 rounded border-gray-300 text-green-600 focus:ring-green-500"
                                disabled>
                            <span>
                                Saya menyetujui
                                <a href="#" class="text-green-700 hover:underline">Kebijakan
                                    Privasi</a>
                                dan
                                <a href="#" class="text-green-700 hover:underline">Syarat &
                                    Ketentuan</a>.
                            </span>
                        </div>

                        <div class="flex items-center justify-between gap-4">
                            <a href="{{ route('beranda') }}"
                                class="inline-flex items-center gap-2 rounded-lg border border-green-600 px-4 py-2 text-sm font-medium text-green-700 hover:bg-green-600 hover:text-white transition">
                                <x-heroicon-o-arrow-left class="size-4" /> Kembali
                            </a>
                            <button type="button" disabled aria-disabled="true"
                                class="inline-flex items-center gap-2 rounded-lg bg-green-600/60 px-4 py-2 text-sm font-medium text-white cursor-not-allowed">
                                <x-heroicon-o-lock-closed class="size-4" /> Masuk (non-aktif)
                            </button>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span class="bg-white px-3 text-xs uppercase tracking-wide text-gray-500">atau</span>
                        </div>
                    </div>

                    {{-- Google Login (statis) --}}
                    <div>
                        <a href="#" aria-disabled="true"
                            class="w-full inline-flex items-center justify-center gap-3 rounded-lg ring-1 ring-black/10 px-4 py-2.5 text-sm bg-gray-50 cursor-not-allowed">
                            {{-- Google SVG --}}
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="h-5 w-5" aria-hidden="true">
                                <path fill="#FFC107"
                                    d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12   s5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24s8.955,20,20,20   s20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z" />
                                <path fill="#FF3D00"
                                    d="M6.306,14.691l6.571,4.819C14.655,16.108,18.961,13,24,13c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657   C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z" />
                                <path fill="#4CAF50"
                                    d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.191-5.238C29.211,35.091,26.715,36,24,36c-5.192,0-9.607-3.317-11.267-7.946   l-6.553,5.047C9.488,39.556,16.227,44,24,44z" />
                                <path fill="#1976D2"
                                    d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-3.994,5.571c0,0,0,0,0,0l6.191,5.238   C35.271,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z" />
                            </svg>
                            <span class="font-medium">Masuk dengan Google (non-aktif)</span>
                        </a>
                        <p class="mt-2 text-xs text-gray-500">Ini hanya contoh tampilan. Integrasi Google akan diaktifkan
                            kemudian.</p>
                    </div>
                </div>
            </article>

            {{-- SIDEBAR --}}
            <aside class="space-y-6 lg:sticky lg:top-20">
                {{-- Info Keamanan --}}
                <div class="rounded-xl bg-white shadow p-5 ring-1 ring-black/5">
                    <div class="flex items-start gap-3">
                        <span
                            class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-green-50 ring-1 ring-green-200">
                            <x-heroicon-o-shield-check class="size-6 text-green-700" />
                        </span>
                        <div class="min-w-0">
                            <h3 class="font-semibold text-gray-900">Keamanan Data</h3>
                            <p class="mt-1 text-sm text-gray-600">Data pribadi dilindungi dan hanya digunakan untuk
                                verifikasi layanan publik.</p>
                        </div>
                    </div>
                </div>

                {{-- Kontak Bantuan --}}
                <div class="rounded-xl bg-white shadow p-5 ring-1 ring-black/5">
                    <h3 class="font-semibold text-gray-900 mb-2">Butuh Bantuan?</h3>
                    <ul class="text-sm text-gray-700 space-y-1">
                        <li>WhatsApp Admin: <a class="text-green-700 hover:underline"
                                href="https://wa.me/6281234567890">0812-3456-7890</a></li>
                        <li>Email: <a class="text-green-700 hover:underline"
                                href="mailto:admin@mentuda.go.id">admin@mentuda.go.id</a></li>
                    </ul>
                </div>

                {{-- Kembali --}}
                <div class="bg-white rounded-xl shadow p-4">
                    <a href="{{ route('layanan') }}"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-green-600 px-4 py-2 text-sm font-medium text-green-700 hover:bg-green-600 hover:text-white transition">
                        <x-heroicon-o-arrow-left class="size-4" /> Kembali ke Layanan
                    </a>
                </div>
            </aside>
        </div>
    </section>
@endsection
