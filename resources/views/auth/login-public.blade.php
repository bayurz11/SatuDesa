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
                Akses pengajuan surat, pengaduan, dan pelacakan status. Pilih metode masuk sebagai Warga (NIK) atau
                Admin/Operator.
            </p>
        </header>

        <div x-data="{ tab: 'warga' }" class="grid gap-8 lg:grid-cols-3 items-start">
            {{-- FORM --}}
            <article class="lg:col-span-2 space-y-6">
                {{-- Alert error global --}}
                @if ($errors->any())
                    <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-red-800">
                        <div class="font-semibold mb-1">Ada kesalahan pada input Anda</div>
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Tabs --}}
                <div class="rounded-2xl bg-white shadow ring-1 ring-black/5">
                    <div class="border-b border-gray-100 px-4 md:px-6 pt-4">
                        <div class="inline-flex rounded-xl bg-gray-50 p-1 ring-1 ring-black/5">
                            <button type="button" @click="tab='warga'"
                                :class="tab === 'warga' ? 'bg-white text-green-700 shadow' :
                                    'text-gray-600 hover:text-gray-900'"
                                class="px-4 py-2.5 text-sm font-medium rounded-lg transition">
                                Masuk Warga (NIK)
                            </button>
                            <button type="button" @click="tab='admin'"
                                :class="tab === 'admin' ? 'bg-white text-green-700 shadow' :
                                    'text-gray-600 hover:text-gray-900'"
                                class="px-4 py-2.5 text-sm font-medium rounded-lg transition">
                                Admin / Operator
                            </button>
                        </div>
                    </div>

                    {{-- Panel: Warga --}}
                    <div x-show="tab==='warga'" x-cloak class="p-6 md:p-8">
                        {{-- NOTE: pakai route yang benar sesuai definisi kamu.
                         Jika route kamu = public-login => ganti ke route('public-login')
                         Jika mengikuti saran saya => route('public.login.warga') --}}
                        <form method="POST" action="{{ route('public.login.warga') }}" class="space-y-5" novalidate>
                            @csrf

                            <div class="grid gap-5 sm:grid-cols-2">
                                {{-- NIK --}}
                                <div class="sm:col-span-2">
                                    <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="16" name="nik"
                                        id="nik" value="{{ old('nik') }}" autofocus
                                        class="mt-1 block w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                                        placeholder="16 digit NIK" required>
                                    @error('nik')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Gunakan NIK sesuai KTP. Angka saja, tanpa
                                        spasi/tanda.</p>
                                </div>

                                {{-- Tanggal Lahir --}}
                                <div>
                                    <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal
                                        Lahir</label>
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                        value="{{ old('tanggal_lahir') }}"
                                        class="mt-1 block w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                                        required>
                                    @error('tanggal_lahir')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- No. HP (opsional) --}}
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">No. HP
                                        (opsional)</label>
                                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                                        class="mt-1 block w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                                        placeholder="08xxxxxxxxxx">
                                    @error('phone')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Persetujuan --}}
                            <div class="flex items-start gap-3 text-sm text-gray-600">
                                <input id="agree" name="agree" type="checkbox"
                                    class="mt-1 rounded border-gray-300 text-green-600 focus:ring-green-500" required>
                                <label for="agree">
                                    Saya menyetujui
                                    <a href="{{ route('kebijakan-privasi') }}"
                                        class="text-green-700 hover:underline">Kebijakan Privasi</a>
                                    dan
                                    <a href="{{ route('syarat-ketentuan') }}" class="text-green-700 hover:underline">Syarat
                                        & Ketentuan</a>.
                                </label>
                            </div>
                            @error('agree')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror

                            {{-- (Opsional) Captcha --}}
                            {{-- @captchaView --}}

                            <div class="flex items-center justify-between gap-4">
                                <a href="{{ route('layanan') }}"
                                    class="inline-flex items-center gap-2 rounded-lg border border-green-600 px-4 py-2 text-sm font-medium text-green-700 hover:bg-green-600 hover:text-white transition">
                                    <x-heroicon-o-arrow-left class="size-4" /> Kembali
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 transition">
                                    <x-heroicon-o-lock-closed class="size-4" /> Masuk sebagai Warga
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Panel: Admin --}}
                    <div x-show="tab==='admin'" x-cloak class="p-6 md:p-8">
                        <form method="POST" action="{{ route('login') }}" class="space-y-5" novalidate>
                            @csrf

                            <div class="grid gap-5 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                                        class="mt-1 block w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                                        placeholder="nama@email.com" required>
                                    @error('email')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="sm:col-span-2" x-data="{ show: false }">
                                    <label for="password" class="block text-sm font-medium text-gray-700">Kata
                                        Sandi</label>
                                    <div class="mt-1 relative">
                                        <input :type="show ? 'text' : 'password'" name="password" id="password"
                                            class="block w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 pr-10"
                                            required>
                                        <button type="button" @click="show=!show"
                                            class="absolute inset-y-0 right-0 px-3 text-gray-500 hover:text-gray-700"
                                            aria-label="Toggle password visibility">
                                            <x-heroicon-o-eye class="size-5" x-show="!show" />
                                            <x-heroicon-o-eye-slash class="size-5" x-show="show" />
                                        </button>
                                    </div>
                                    <div class="mt-2 flex items-center justify-between text-sm">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="checkbox" name="remember"
                                                class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                                            <span>Ingat saya</span>
                                        </label>
                                        @if (Route::has('password.request'))
                                            <a class="text-green-700 hover:underline"
                                                href="{{ route('password.request') }}">
                                                Lupa kata sandi?
                                            </a>
                                        @endif
                                    </div>
                                    @error('password')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex items-center justify-between gap-4">
                                <a href="{{ route('beranda') }}"
                                    class="inline-flex items-center gap-2 rounded-lg border border-green-600 px-4 py-2 text-sm font-medium text-green-700 hover:bg-green-600 hover:text-white transition">
                                    <x-heroicon-o-arrow-left class="size-4" /> Kembali
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 transition">
                                    <x-heroicon-o-arrow-right-on-rectangle class="size-4" /> Masuk Admin
                                </button>
                            </div>
                        </form>

                        {{-- Single Sign-On placeholder --}}
                        <div class="mt-6 border-t pt-6">
                            <p class="text-sm text-gray-600 mb-3">Atau masuk dengan</p>
                            <div class="flex flex-wrap gap-2">
                                <a href="#"
                                    class="inline-flex items-center justify-center gap-2 rounded-lg ring-1 ring-black/10 px-4 py-2 text-sm hover:bg-gray-50">
                                    <x-heroicon-o-key class="size-4" /> SSO Pemda (coming soon)
                                </a>
                            </div>
                        </div>
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
