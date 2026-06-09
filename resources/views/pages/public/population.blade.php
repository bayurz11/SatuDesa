@php
    $metaTitle = 'Statistik Penduduk';
    $metaDescription =
        'Lihat ringkasan statistik penduduk desa untuk membantu warga memahami komposisi keluarga, wilayah, pendidikan, dan kondisi kependudukan secara singkat.';
    $genderTotal = max($maleCitizens + $femaleCitizens, 1);
    $hamletMaxCitizens = max($hamletStats->max('citizens') ?? 1, 1);
    $miniCardGradients = [
        'bg-[linear-gradient(135deg,_#ecfdf5_0%,_#d1fae5_100%)] border border-emerald-100 hover:border-emerald-200 hover:shadow-emerald-100/80',
        'bg-[linear-gradient(135deg,_#eff6ff_0%,_#dbeafe_100%)] border border-sky-100 hover:border-sky-200 hover:shadow-sky-100/80',
        'bg-[linear-gradient(135deg,_#fff7ed_0%,_#ffedd5_100%)] border border-amber-100 hover:border-amber-200 hover:shadow-amber-100/80',
        'bg-[linear-gradient(135deg,_#fdf4ff_0%,_#fae8ff_100%)] border border-fuchsia-100 hover:border-fuchsia-200 hover:shadow-fuchsia-100/80',
        'bg-[linear-gradient(135deg,_#fefce8_0%,_#fef3c7_100%)] border border-yellow-100 hover:border-yellow-200 hover:shadow-yellow-100/80',
        'bg-[linear-gradient(135deg,_#eef2ff_0%,_#e0e7ff_100%)] border border-indigo-100 hover:border-indigo-200 hover:shadow-indigo-100/80',
    ];
@endphp

@extends('layouts.public')

@section('content')
    <section
        class="relative mt-16 overflow-hidden bg-[linear-gradient(135deg,_#052e16_0%,_#14532d_45%,_#166534_100%)] text-white">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.18),_transparent_28%)]">
        </div>
        <div class="absolute -left-20 top-24 h-64 w-64 rounded-full bg-emerald-400/10 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 h-72 w-72 rounded-full bg-lime-300/10 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 pb-20 pt-10 sm:px-6 lg:px-8">
            <nav class="text-sm text-emerald-100/80" aria-label="Breadcrumb">
                <ol class="flex flex-wrap items-center gap-2">
                    <li><a href="{{ route('home') }}" class="transition hover:text-white">Beranda</a></li>
                    <li>/</li>
                    <li class="font-semibold text-white">Statistik Penduduk</li>
                </ol>
            </nav>

            <div class="mt-8 grid gap-8 lg:grid-cols-[minmax(0,1fr)_360px] lg:items-start">
                <div class="max-w-4xl" data-aos="fade-up">
                    <div class="flex flex-wrap items-center gap-3">
                        <span
                            class="inline-flex items-center rounded-full bg-white/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-emerald-50 ring-1 ring-white/15">
                            Data Warga Desa
                        </span>
                        <span
                            class="inline-flex items-center rounded-full bg-emerald-300/15 px-4 py-1 text-xs font-semibold text-emerald-50 ring-1 ring-emerald-200/20">
                            Ringkasan Terbuka
                        </span>
                    </div>

                    <h1
                        class="mt-5 max-w-2xl text-2xl font-bold tracking-tight text-white sm:text-3xl lg:text-[2rem] lg:leading-tight">
                        Gambaran Penduduk Desa
                    </h1>

                    <p class="mt-3 max-w-2xl text-sm leading-7 text-emerald-50/90">
                        Warga dapat melihat ringkasan jumlah penduduk, sebaran keluarga, komposisi wilayah, pendidikan,
                        agama, dan kondisi kependudukan dalam tampilan yang lebih mudah dipahami.
                    </p>

                    <div class="mt-8 grid gap-4 sm:grid-cols-3">

                        {{-- Total Penduduk --}}
                        <div class="group relative overflow-hidden rounded-[24px] border border-white/10 bg-white/10 p-5 shadow-lg shadow-black/10 backdrop-blur-xl transition-all duration-300 hover:-translate-y-1 hover:bg-white/15 hover:shadow-2xl"
                            data-aos="fade-up" data-aos-delay="50">

                            <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-white/10 blur-2xl"></div>

                            <div class="relative">
                                <div class="flex items-center justify-between">
                                    <span
                                        class="rounded-full bg-white/15 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.18em] text-emerald-50 ring-1 ring-white/10">
                                        Penduduk
                                    </span>

                                    <span
                                        class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-300/15 ring-1 ring-emerald-200/20">
                                        <span class="h-2.5 w-2.5 rounded-full bg-emerald-300"></span>
                                    </span>
                                </div>

                                <p class="mt-5 text-3xl font-bold tracking-tight text-white">
                                    {{ number_format($totalCitizens, 0, ',', '.') }}
                                </p>

                                <p class="mt-3 text-xs leading-5 text-emerald-50/80">
                                    Total Penduduk
                                </p>
                            </div>
                        </div>

                        {{-- Kartu Keluarga --}}
                        <div class="group relative overflow-hidden rounded-[24px] border border-white/10 bg-white/10 p-5 shadow-lg shadow-black/10 backdrop-blur-xl transition-all duration-300 hover:-translate-y-1 hover:bg-white/15 hover:shadow-2xl"
                            data-aos="fade-up" data-aos-delay="100">

                            <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-white/10 blur-2xl"></div>

                            <div class="relative">
                                <div class="flex items-center justify-between">
                                    <span
                                        class="rounded-full bg-white/15 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.18em] text-emerald-50 ring-1 ring-white/10">
                                        KK
                                    </span>

                                    <span
                                        class="flex h-8 w-8 items-center justify-center rounded-full bg-sky-300/15 ring-1 ring-sky-200/20">
                                        <span class="h-2.5 w-2.5 rounded-full bg-sky-300"></span>
                                    </span>
                                </div>

                                <p class="mt-5 text-3xl font-bold tracking-tight text-white">
                                    {{ number_format($totalHouseholds, 0, ',', '.') }}
                                </p>


                                <p class="mt-3 text-xs leading-5 text-emerald-50/80">
                                    Kartu Keluarga
                                </p>
                            </div>
                        </div>

                        {{-- Dusun --}}
                        <div class="group relative overflow-hidden rounded-[24px] border border-white/10 bg-white/10 p-5 shadow-lg shadow-black/10 backdrop-blur-xl transition-all duration-300 hover:-translate-y-1 hover:bg-white/15 hover:shadow-2xl"
                            data-aos="fade-up" data-aos-delay="150">

                            <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-white/10 blur-2xl"></div>

                            <div class="relative">
                                <div class="flex items-center justify-between">
                                    <span
                                        class="rounded-full bg-white/15 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.18em] text-emerald-50 ring-1 ring-white/10">
                                        Dusun
                                    </span>

                                    <span
                                        class="flex h-8 w-8 items-center justify-center rounded-full bg-amber-300/15 ring-1 ring-amber-200/20">
                                        <span class="h-2.5 w-2.5 rounded-full bg-amber-300"></span>
                                    </span>
                                </div>

                                <p class="mt-5 text-3xl font-bold tracking-tight text-white">
                                    {{ number_format($totalHamlets, 0, ',', '.') }}
                                </p>


                                <p class="mt-3 text-xs leading-5 text-emerald-50/80">
                                    Dusun Terdata
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="rounded-[32px] border border-white/10 bg-white/10 p-6 backdrop-blur-xl shadow-2xl shadow-green-950/20 transition duration-300 hover:-translate-y-1 hover:bg-white/15"
                    data-aos="fade-left">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-emerald-100">Sekilas Hari Ini</p>
                    <h2 class="mt-3 text-2xl font-bold text-white">Ringkasan Warga</h2>
                    <div class="mt-5 grid gap-3">
                        <div class="flex items-start gap-3 rounded-2xl bg-white/5 px-4 py-3 ring-1 ring-white/10 transition duration-300 hover:bg-white/10"
                            data-aos="fade-left" data-aos-delay="70">
                            <span class="mt-1 h-2.5 w-2.5 flex-shrink-0 rounded-full bg-lime-300"></span>
                            <span class="text-sm text-white/90">{{ number_format($activeCitizens, 0, ',', '.') }} warga
                                tercatat aktif di desa</span>
                        </div>
                        <div class="flex items-start gap-3 rounded-2xl bg-white/5 px-4 py-3 ring-1 ring-white/10 transition duration-300 hover:bg-white/10"
                            data-aos="fade-left" data-aos-delay="120">
                            <span class="mt-1 h-2.5 w-2.5 flex-shrink-0 rounded-full bg-lime-300"></span>
                            <span class="text-sm text-white/90">{{ number_format($maleCitizens, 0, ',', '.') }} laki-laki
                                dan {{ number_format($femaleCitizens, 0, ',', '.') }} perempuan tersebar di seluruh
                                dusun</span>
                        </div>
                        <div class="flex items-start gap-3 rounded-2xl bg-white/5 px-4 py-3 ring-1 ring-white/10 transition duration-300 hover:bg-white/10"
                            data-aos="fade-left" data-aos-delay="170">
                            <span class="mt-1 h-2.5 w-2.5 flex-shrink-0 rounded-full bg-lime-300"></span>
                            <span class="text-sm text-white/90">
                                {{ $lastUpdated ? 'Data terakhir diperbarui pada ' . \Illuminate\Support\Carbon::parse($lastUpdated)->locale('id')->translatedFormat('d F Y H:i') : 'Data penduduk masih menunggu pembaruan' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="relative z-10 mx-auto -mt-10 max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
        @if ($totalCitizens === 0)
            <div class="rounded-[32px] border border-gray-200 bg-white p-8 text-center shadow-md shadow-gray-200/60"
                data-aos="fade-up">
                <h3 class="text-2xl font-bold text-gray-900">Belum ada data penduduk</h3>
                <p class="mx-auto mt-4 max-w-2xl text-sm leading-7 text-gray-600">
                    Statistik publik akan tampil otomatis setelah data penduduk dan kartu keluarga diisi dari panel admin
                    desa.
                </p>
            </div>
        @else
            <main class="space-y-8">
                <section class="grid gap-6 md:grid-cols-3">
                    <article
                        class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-gray-200/80"
                        data-aos="fade-up">
                        <span class="text-xs font-semibold uppercase tracking-[0.24em] text-green-700">Komposisi
                            Gender</span>
                        <div class="mt-4 space-y-4">
                            <div>
                                <div class="flex items-center justify-between text-sm text-gray-600">
                                    <span>Laki-laki</span>
                                    <span>{{ number_format($maleCitizens, 0, ',', '.') }}</span>
                                </div>
                                <div class="mt-2 h-3 overflow-hidden rounded-full bg-sky-100">
                                    <div class="h-full rounded-full bg-sky-500"
                                        style="width: {{ round(($maleCitizens / $genderTotal) * 100, 1) }}%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex items-center justify-between text-sm text-gray-600">
                                    <span>Perempuan</span>
                                    <span>{{ number_format($femaleCitizens, 0, ',', '.') }}</span>
                                </div>
                                <div class="mt-2 h-3 overflow-hidden rounded-full bg-pink-100">
                                    <div class="h-full rounded-full bg-pink-500"
                                        style="width: {{ round(($femaleCitizens / $genderTotal) * 100, 1) }}%"></div>
                                </div>
                            </div>
                        </div>
                    </article>

                    <article
                        class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-gray-200/80"
                        data-aos="fade-up" data-aos-delay="100">
                        <span class="text-xs font-semibold uppercase tracking-[0.24em] text-green-700">Kelompok
                            Usia</span>
                        <div class="mt-4 space-y-3">
                            @foreach ($ageGroups as $label => $total)
                                <div
                                    class="flex items-center justify-between rounded-2xl px-4 py-3 text-sm text-gray-700 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg {{ $miniCardGradients[$loop->index % count($miniCardGradients)] }}">
                                    <span>{{ $label }}</span>
                                    <span
                                        class="font-semibold text-gray-900">{{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    </article>

                    <article
                        class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-gray-200/80"
                        data-aos="fade-up" data-aos-delay="150">
                        <span class="text-xs font-semibold uppercase tracking-[0.24em] text-green-700">Wilayah
                            Administratif</span>
                        <div class="mt-4 space-y-3">
                            @foreach ($areaStats as $item)
                                <div
                                    class="flex items-center justify-between rounded-2xl px-4 py-3 text-sm text-gray-700 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg {{ $miniCardGradients[$loop->index % count($miniCardGradients)] }}">
                                    <span>{{ $item['label'] }}</span>
                                    <span
                                        class="font-semibold text-gray-900">{{ number_format($item['total'], 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    </article>
                </section>

                <section
                    class="overflow-hidden rounded-[24px] border border-emerald-100 bg-white shadow-xl shadow-emerald-100/70"
                    data-aos="fade-up">

                    {{-- HEADER --}}
                    <div
                        class="relative overflow-hidden border-b border-emerald-100 bg-gradient-to-br from-emerald-50 via-green-50 to-sky-50 px-6 py-7 sm:px-8 lg:px-10">
                        <div class="absolute -right-16 -top-16 h-56 w-56 rounded-full bg-emerald-200/40 blur-3xl"></div>
                        <div class="absolute -bottom-20 left-20 h-52 w-52 rounded-full bg-sky-200/40 blur-3xl"></div>

                        <div class="relative grid gap-6 lg:grid-cols-[minmax(0,1fr)_220px] lg:items-center">
                            <div>
                                <span
                                    class="inline-flex rounded-full bg-emerald-100 px-4 py-1.5 text-[10px] font-semibold uppercase tracking-[0.2em] text-emerald-700">
                                    Sebaran Wilayah
                                </span>

                                <h2 class="mt-4 text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                                    Penduduk per Dusun
                                </h2>

                                <p class="mt-3 max-w-5xl text-sm leading-7 text-gray-600">
                                    Bagian ini membantu warga melihat dusun mana yang memiliki jumlah keluarga
                                    dan penduduk lebih banyak, sehingga gambaran sebaran warga terasa lebih dekat
                                    dengan kondisi lapangan.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- CONTENT --}}
                    <div class="bg-gradient-to-b from-white to-emerald-50/60 p-5 sm:p-7 lg:p-8">
                        <div class="grid gap-5 xl:grid-cols-2">
                            @foreach ($hamletStats as $hamletIndex => $hamlet)
                                @php
                                    $progress =
                                        $hamletMaxCitizens > 0
                                            ? min(100, round(($hamlet['citizens'] / $hamletMaxCitizens) * 100, 1))
                                            : 0;
                                @endphp

                                <div class="group relative overflow-hidden rounded-[22px] border border-emerald-100 bg-white p-5 shadow-sm shadow-emerald-100/70 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-emerald-100"
                                    data-aos="fade-up" data-aos-delay="{{ min($hamletIndex * 60, 240) }}">

                                    <div class="absolute right-4 top-4">
                                        <span
                                            class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-600 text-[11px] font-bold text-white shadow-sm">
                                            #{{ $loop->iteration }}
                                        </span>
                                    </div>

                                    <div class="pr-12">
                                        <p class="text-base font-semibold text-gray-900">
                                            {{ $hamlet['name'] }}
                                        </p>

                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ number_format($hamlet['households'], 0, ',', '.') }} KK tercatat
                                        </p>
                                    </div>

                                    <div class="mt-5">
                                        <div class="mb-2 flex items-center justify-between text-xs">
                                            <span class="font-semibold text-gray-600">Sebaran Penduduk</span>
                                            <span class="font-bold text-emerald-700">{{ $progress }}%</span>
                                        </div>

                                        <div class="h-3 overflow-hidden rounded-full bg-emerald-100">
                                            <div class="h-full rounded-full bg-gradient-to-r from-emerald-500 via-sky-500 to-amber-400 transition-all duration-700"
                                                style="width: {{ $progress }}%">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-5 grid gap-3 sm:grid-cols-3">
                                        <div class="rounded-2xl bg-emerald-50 px-4 py-3">
                                            <span
                                                class="block text-[11px] font-semibold uppercase tracking-wide text-gray-500">
                                                Jiwa
                                            </span>

                                            <span class="mt-1 block text-base font-semibold text-gray-900">
                                                {{ number_format($hamlet['citizens'], 0, ',', '.') }}
                                            </span>
                                        </div>

                                        <div class="rounded-2xl bg-sky-50 px-4 py-3">
                                            <span
                                                class="block text-[11px] font-semibold uppercase tracking-wide text-gray-500">
                                                Laki-laki
                                            </span>

                                            <span class="mt-1 block text-base font-semibold text-sky-700">
                                                {{ number_format($hamlet['male'], 0, ',', '.') }}
                                            </span>
                                        </div>

                                        <div class="rounded-2xl bg-pink-50 px-4 py-3">
                                            <span
                                                class="block text-[11px] font-semibold uppercase tracking-wide text-gray-500">
                                                Perempuan
                                            </span>

                                            <span class="mt-1 block text-base font-semibold text-pink-700">
                                                {{ number_format($hamlet['female'], 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>

                <section class="grid gap-6 md:grid-cols-3" data-aos="fade-up">
                    <article
                        class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-gray-200/80"
                        data-aos="fade-up">
                        <span class="text-xs font-semibold uppercase tracking-[0.24em] text-green-700">Agama</span>
                        <div class="mt-4 space-y-3">
                            @foreach ($religionStats as $item)
                                <div
                                    class="flex items-center justify-between rounded-2xl px-4 py-3 text-sm text-gray-700 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg {{ $miniCardGradients[$loop->index % count($miniCardGradients)] }}">
                                    <span>{{ $item['label'] }}</span>
                                    <span
                                        class="font-semibold text-gray-900">{{ number_format($item['total'], 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    </article>
                    <article
                        class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-gray-200/80"
                        data-aos="fade-up" data-aos-delay="100">
                        <span class="text-xs font-semibold uppercase tracking-[0.24em] text-green-700">Pendidikan
                            Terakhir</span>
                        <div class="mt-4 space-y-3">
                            @foreach ($educationStats as $item)
                                <div
                                    class="flex items-center justify-between rounded-2xl px-4 py-3 text-sm text-gray-700 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg {{ $miniCardGradients[$loop->index % count($miniCardGradients)] }}">
                                    <span>{{ $item['label'] }}</span>
                                    <span
                                        class="font-semibold text-gray-900">{{ number_format($item['total'], 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    </article>
                    <article
                        class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-gray-200/80"
                        data-aos="fade-up" data-aos-delay="150">
                        <span class="text-xs font-semibold uppercase tracking-[0.24em] text-green-700">Pekerjaan
                            Dominan</span>
                        <div class="mt-4 space-y-3">
                            @foreach ($occupationStats as $item)
                                <div
                                    class="flex items-center justify-between rounded-2xl px-4 py-3 text-sm text-gray-700 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg {{ $miniCardGradients[$loop->index % count($miniCardGradients)] }}">
                                    <span>{{ $item['label'] }}</span>
                                    <span
                                        class="font-semibold text-gray-900">{{ number_format($item['total'], 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    </article>
                </section>
            </main>

            </div>
        @endif
    </section>
@endsection
