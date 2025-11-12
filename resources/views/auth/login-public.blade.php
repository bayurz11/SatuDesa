@extends('layouts.app2')

@section('title', 'Masuk Layanan Publik')

@section('content')
    <style>
        input[type="date"] {
            color-scheme: light;
        }

        /* datepicker lebih kontras */
        ::placeholder {
            color: #6b7280;
            opacity: 1;
        }

        /* placeholder = text-gray-500 */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>

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
            <p class="mt-3 md:mt-4 text-gray-700 md:text-lg max-w-2xl mx-auto">
                Pilih <span class="font-semibold">Masuk Warga (NIK)</span> atau <span class="font-semibold">Daftar
                    Warga</span> bila belum punya akun.
            </p>
        </header>

        <div x-data="{ tab: 'warga' }" class="grid gap-8 lg:grid-cols-3 items-start">
            {{-- FORM CARD --}}
            <article class="lg:col-span-2 space-y-6">
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

                <div class="rounded-2xl bg-white shadow ring-1 ring-black/5">
                    {{-- Tabs --}}
                    <div class="border-b border-gray-100 px-4 md:px-6 pt-4">
                        <div class="inline-flex rounded-xl bg-gray-50 p-1 ring-1 ring-black/5">
                            <button type="button" @click="tab='warga'"
                                :class="tab === 'warga' ? 'bg-white text-green-700 shadow' :
                                    'text-gray-700 hover:text-gray-900'"
                                class="px-4 py-2.5 text-sm font-medium rounded-lg transition">
                                Masuk Warga (NIK)
                            </button>
                            <button type="button" @click="tab='daftar-warga'"
                                :class="tab === 'daftar-warga' ? 'bg-white text-green-700 shadow' :
                                    'text-gray-700 hover:text-gray-900'"
                                class="px-4 py-2.5 text-sm font-medium rounded-lg transition">
                                Daftar Warga
                            </button>
                        </div>
                    </div>

                    {{-- Panel: Masuk Warga (NIK) --}}
                    <div x-show="tab==='warga'" x-cloak class="p-6 md:p-8">
                        <form method="POST" action="{{ route('public-login') }}" class="space-y-6" novalidate>
                            @csrf

                            <div class="grid gap-6 sm:grid-cols-2">
                                {{-- NIK --}}
                                <div class="sm:col-span-2">
                                    <label for="nik"
                                        class="flex items-center gap-1 text-sm font-semibold text-gray-900">
                                        NIK <span class="text-red-600" title="Wajib">*</span>
                                    </label>
                                    <div class="relative mt-1">
                                        <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="16"
                                            name="nik" id="nik" value="{{ old('nik') }}"
                                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-[15px] text-gray-900
                                                      placeholder:text-gray-500 focus:border-green-600 focus:ring-2 focus:ring-green-200"
                                            placeholder="Masukkan 16 digit NIK" required aria-describedby="nik_help">
                                    </div>
                                    <p id="nik_help" class="mt-1 text-xs text-gray-600">
                                        Gunakan NIK sesuai KTP. Angka saja, tanpa spasi/tanda.
                                    </p>
                                    @error('nik')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Tanggal Lahir --}}
                                <div>
                                    <label for="tanggal_lahir"
                                        class="flex items-center gap-1 text-sm font-semibold text-gray-900">
                                        Tanggal Lahir <span class="text-red-600">*</span>
                                    </label>
                                    <div class="relative mt-1">
                                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <x-heroicon-o-calendar class="size-4 text-gray-500" />
                                        </span>
                                        <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                            value="{{ old('tanggal_lahir') }}"
                                            class="block w-full rounded-lg border border-gray-300 bg-white pl-10 pr-3 py-2.5 text-[15px] text-gray-900
                                                      focus:border-green-600 focus:ring-2 focus:ring-green-200"
                                            required>
                                    </div>
                                    @error('tanggal_lahir')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- No. HP (opsional) --}}
                                <div>
                                    <label for="phone" class="text-sm font-semibold text-gray-900">No. HP
                                        (opsional)</label>
                                    <div class="relative mt-1">
                                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <x-heroicon-o-phone class="size-4 text-gray-500" />
                                        </span>
                                        <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                                            class="block w-full rounded-lg border border-gray-300 bg-white pl-10 pr-3 py-2.5 text-[15px] text-gray-900
                                                      placeholder:text-gray-500 focus:border-green-600 focus:ring-2 focus:ring-green-200"
                                            placeholder="08xxxxxxxxxx">
                                    </div>
                                    @error('phone')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Persetujuan --}}
                            <div class="flex items-start gap-3 text-sm text-gray-700">
                                <input id="agree" name="agree" type="checkbox"
                                    class="mt-1 rounded border-gray-300 text-green-600 focus:ring-green-500" required>
                                <label for="agree">
                                    Saya menyetujui
                                    <a href="#" class="text-green-700 hover:underline">Kebijakan Privasi</a>
                                    dan
                                    <a href="#" class="text-green-700 hover:underline">Syarat & Ketentuan</a>.
                                </label>
                            </div>
                            @error('agree')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror

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

                    {{-- Panel: Daftar Warga --}}
                    <div x-show="tab==='daftar-warga'" x-cloak class="p-6 md:p-8" x-data="{
                        showPwd: false,
                        showPwd2: false,
                        pwd: '',
                        strength() {
                            let s = 0;
                            if (this.pwd.length >= 8) s++;
                            if (/[A-Z]/.test(this.pwd)) s++;
                            if (/[a-z]/.test(this.pwd)) s++;
                            if (/[0-9]/.test(this.pwd)) s++;
                            if (/[^A-Za-z0-9]/.test(this.pwd)) s++;
                            return s;
                        }
                    }">
                        <form method="POST" action="#" class="space-y-6" enctype="multipart/form-data" novalidate>
                            @csrf

                            <div class="grid gap-6 sm:grid-cols-2">
                                {{-- NIK --}}
                                <div class="sm:col-span-2">
                                    <label for="reg_nik"
                                        class="flex items-center gap-1 text-sm font-semibold text-gray-900">
                                        NIK <span class="text-red-600">*</span>
                                    </label>
                                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="16"
                                        name="nik" id="reg_nik" value="{{ old('nik') }}"
                                        class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-[15px] text-gray-900
                                                  placeholder:text-gray-500 focus:border-green-600 focus:ring-2 focus:ring-green-200"
                                        placeholder="16 digit NIK" required>
                                    @error('nik')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Nama --}}
                                <div class="sm:col-span-2">
                                    <label for="reg_name"
                                        class="flex items-center gap-1 text-sm font-semibold text-gray-900">
                                        Nama Lengkap <span class="text-red-600">*</span>
                                    </label>
                                    <input type="text" name="name" id="reg_name" value="{{ old('name') }}"
                                        class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-[15px] text-gray-900
                                                  focus:border-green-600 focus:ring-2 focus:ring-green-200"
                                        placeholder="Sesuai KTP" required>
                                    @error('name')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Tanggal Lahir --}}
                                <div>
                                    <label for="reg_tanggal_lahir"
                                        class="flex items-center gap-1 text-sm font-semibold text-gray-900">
                                        Tanggal Lahir <span class="text-red-600">*</span>
                                    </label>
                                    <div class="relative mt-1">
                                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <x-heroicon-o-calendar class="size-4 text-gray-500" />
                                        </span>
                                        <input type="date" name="tanggal_lahir" id="reg_tanggal_lahir"
                                            value="{{ old('tanggal_lahir') }}"
                                            class="block w-full rounded-lg border border-gray-300 bg-white pl-10 pr-3 py-2.5 text-[15px] text-gray-900
                                                      focus:border-green-600 focus:ring-2 focus:ring-green-200"
                                            required>
                                    </div>
                                    @error('tanggal_lahir')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- No. HP --}}
                                <div>
                                    <label for="reg_phone" class="text-sm font-semibold text-gray-900">No. HP <span
                                            class="text-red-600">*</span></label>
                                    <div class="relative mt-1">
                                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <x-heroicon-o-phone class="size-4 text-gray-500" />
                                        </span>
                                        <input type="tel" name="phone" id="reg_phone" value="{{ old('phone') }}"
                                            class="block w-full rounded-lg border border-gray-300 bg-white pl-10 pr-3 py-2.5 text-[15px] text-gray-900
                                                      placeholder:text-gray-500 focus:border-green-600 focus:ring-2 focus:ring-green-200"
                                            placeholder="08xxxxxxxxxx" required>
                                    </div>
                                    @error('phone')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="sm:col-span-2">
                                    <label for="reg_email"
                                        class="flex items-center gap-1 text-sm font-semibold text-gray-900">
                                        Email <span class="text-red-600">*</span>
                                    </label>
                                    <input type="email" name="email" id="reg_email" value="{{ old('email') }}"
                                        class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-[15px] text-gray-900
                                                  placeholder:text-gray-500 focus:border-green-600 focus:ring-2 focus:ring-green-200"
                                        placeholder="nama@email.com" required>
                                    @error('email')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Password --}}
                                <div class="sm:col-span-2">
                                    <label for="reg_password"
                                        class="flex items-center gap-1 text-sm font-semibold text-gray-900">
                                        Kata Sandi <span class="text-red-600">*</span>
                                    </label>
                                    <div class="mt-1 relative">
                                        <input :type="showPwd ? 'text' : 'password'" x-model="pwd" name="password"
                                            id="reg_password"
                                            class="block w-full rounded-lg border border-gray-300 bg-white pr-10 px-4 py-2.5 text-[15px] text-gray-900
                                                      placeholder:text-gray-500 focus:border-green-600 focus:ring-2 focus:ring-green-200"
                                            placeholder="Min. 8 karakter" required>
                                        <button type="button" @click="showPwd=!showPwd"
                                            class="absolute inset-y-0 right-0 px-3 text-gray-500 hover:text-gray-700"
                                            aria-label="Toggle password visibility">
                                            <x-heroicon-o-eye class="size-5" x-show="!showPwd" />
                                            <x-heroicon-o-eye-slash class="size-5" x-show="showPwd" />
                                        </button>
                                    </div>
                                    {{-- Strength meter --}}
                                    <div class="mt-2">
                                        <div
                                            class="h-2 w-full rounded-full bg-gray-200 overflow-hidden ring-1 ring-black/5">
                                            <div class="h-2"
                                                :class="[
                                                    strength() <= 1 ? 'bg-red-500' :
                                                    strength() == 2 ? 'bg-orange-500' :
                                                    strength() == 3 ? 'bg-yellow-500' :
                                                    strength() == 4 ? 'bg-lime-500' : 'bg-green-600'
                                                ]"
                                                :style="`width:${Math.min(strength(),5)/5*100}%`"></div>
                                        </div>
                                        <p class="mt-1 text-xs text-gray-600">Gunakan huruf besar/kecil, angka, & simbol.
                                        </p>
                                    </div>
                                    @error('password')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Konfirmasi Password --}}
                                <div class="sm:col-span-2" x-data>
                                    <label for="reg_password_confirmation"
                                        class="flex items-center gap-1 text-sm font-semibold text-gray-900">
                                        Konfirmasi Kata Sandi <span class="text-red-600">*</span>
                                    </label>
                                    <div class="mt-1 relative">
                                        <input :type="$root.showPwd2 ? 'text' : 'password'" name="password_confirmation"
                                            id="reg_password_confirmation"
                                            class="block w-full rounded-lg border border-gray-300 bg-white pr-10 px-4 py-2.5 text-[15px] text-gray-900
                                                      focus:border-green-600 focus:ring-2 focus:ring-green-200"
                                            required>
                                        <button type="button" @click="$root.showPwd2=!$root.showPwd2"
                                            class="absolute inset-y-0 right-0 px-3 text-gray-500 hover:text-gray-700"
                                            aria-label="Toggle confirm password visibility">
                                            <x-heroicon-o-eye class="size-5" x-show="!$root.showPwd2" />
                                            <x-heroicon-o-eye-slash class="size-5" x-show="$root.showPwd2" />
                                        </button>
                                    </div>
                                </div>

                                {{-- (Opsional) Upload KTP --}}
                                <div class="sm:col-span-2">
                                    <label for="ktp" class="text-sm font-semibold text-gray-900">Upload KTP
                                        (opsional)</label>
                                    <input type="file" name="ktp" id="ktp" accept="image/*,application/pdf"
                                        class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-[15px]
                                                  focus:border-green-600 focus:ring-2 focus:ring-green-200">
                                    <p class="mt-1 text-xs text-gray-600">jpg/png/pdf, maks. 2MB.</p>
                                    @error('ktp')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Persetujuan --}}
                            <div class="flex items-start gap-3 text-sm text-gray-700">
                                <input id="agree_warga" name="agree_warga" type="checkbox"
                                    class="mt-1 rounded border-gray-300 text-green-600 focus:ring-green-500" required>
                                <label for="agree_warga">
                                    Saya menyetujui <a href="#" class="text-green-700 hover:underline">Kebijakan
                                        Privasi</a> dan
                                    <a href="#" class="text-green-700 hover:underline">Syarat & Ketentuan</a>.
                                </label>
                            </div>
                            @error('agree_warga')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror

                            <div class="flex items-center justify-between gap-4">
                                <a href="{{ route('layanan') }}"
                                    class="inline-flex items-center gap-2 rounded-lg border border-green-600 px-4 py-2 text-sm font-medium text-green-700 hover:bg-green-600 hover:text-white transition">
                                    <x-heroicon-o-arrow-left class="size-4" /> Kembali
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 transition">
                                    <x-heroicon-o-user-plus class="size-4" /> Daftarkan Akun Warga
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </article>

            {{-- SIDEBAR --}}
            <aside class="space-y-6 lg:sticky lg:top-20">
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

                <div class="rounded-xl bg-white shadow p-5 ring-1 ring-black/5">
                    <h3 class="font-semibold text-gray-900 mb-2">Butuh Bantuan?</h3>
                    <ul class="text-sm text-gray-700 space-y-1">
                        <li>WhatsApp Admin: <a class="text-green-700 hover:underline"
                                href="https://wa.me/6281234567890">0812-3456-7890</a></li>
                        <li>Email: <a class="text-green-700 hover:underline"
                                href="mailto:admin@mentuda.go.id">admin@mentuda.go.id</a></li>
                    </ul>
                </div>

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
