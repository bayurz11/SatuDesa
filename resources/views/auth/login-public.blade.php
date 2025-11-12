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
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-green-700">Masuk Layanan Publik Desa Mentuda
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
                                :class="tab === 'warga' ? 'bg-white text-green-700 shadow' : 'text-gray-600 hover:text-gray-900'"
                                class="px-4 py-2.5 text-sm font-medium rounded-lg transition">
                                Masuk Warga (NIK)
                            </button>
                            <button type="button" @click="tab='admin'"
                                :class="tab === 'admin' ? 'bg-white text-green-700 shadow' : 'text-gray-600 hover:text-gray-900'"
                                class="px-4 py-2.5 text-sm font-medium rounded-lg transition">
                                Admin / Operator
                            </button>
                        </div>
                    </div>


                    {{-- Panel: Warga --}}
                    <div x-show="tab==='warga'" x-cloak class="p-6 md:p-8">
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


                            @endsection
