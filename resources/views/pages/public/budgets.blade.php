@php
    $metaTitle = 'APBDesa';
    $metaDescription =
        'Warga dapat melihat ringkasan APBDesa, komposisi anggaran, realisasi, dan kegiatan keuangan desa secara lebih terbuka.';

    $summaryGradients = [
        'from-emerald-50 via-white to-lime-50 border-emerald-100',
        'from-sky-50 via-white to-cyan-50 border-sky-100',
        'from-amber-50 via-white to-orange-50 border-amber-100',
    ];

    $miniCardGradients = [
        'bg-[linear-gradient(135deg,_#ecfdf5_0%,_#d1fae5_100%)] border border-emerald-100',
        'bg-[linear-gradient(135deg,_#eff6ff_0%,_#dbeafe_100%)] border border-sky-100',
        'bg-[linear-gradient(135deg,_#fff7ed_0%,_#ffedd5_100%)] border border-amber-100',
        'bg-[linear-gradient(135deg,_#fdf4ff_0%,_#fae8ff_100%)] border border-fuchsia-100',
        'bg-[linear-gradient(135deg,_#eef2ff_0%,_#e0e7ff_100%)] border border-indigo-100',
    ];
@endphp

@extends('layouts.public')

@section('content')
    {{-- HERO --}}
    <section
        class="relative mt-16 overflow-hidden bg-[linear-gradient(135deg,_#052e16_0%,_#14532d_45%,_#166534_100%)] text-white">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.18),_transparent_30%)]">
        </div>
        <div class="absolute -left-20 top-20 h-72 w-72 rounded-full bg-emerald-300/10 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 h-80 w-80 rounded-full bg-cyan-300/10 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 pb-16 pt-8 sm:px-6 lg:px-8">
            <nav class="text-xs text-emerald-100/80" aria-label="Breadcrumb">
                <ol class="flex flex-wrap items-center gap-2">
                    <li>
                        <a href="{{ route('home') }}" class="transition hover:text-white">
                            Beranda
                        </a>
                    </li>
                    <li>/</li>
                    <li class="font-semibold text-white">APBDesa</li>
                </ol>
            </nav>

            <div class="public-sidebar-grid public-sidebar-grid--340 mt-6 lg:items-start">
                <div data-aos="fade-up">
                    <div class="flex flex-wrap items-center gap-3">
                        <span
                            class="inline-flex rounded-full bg-white/10 px-4 py-1.5 text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-50 ring-1 ring-white/15">
                            Transparansi APBDes
                        </span>

                        <span
                            class="inline-flex rounded-full bg-emerald-300/15 px-4 py-1.5 text-[11px] font-medium text-emerald-50 ring-1 ring-emerald-200/20">
                            {{ $fiscalYear?->title ?? 'Belum ada tahun anggaran' }}
                        </span>
                    </div>

                    <h1
                        class="mt-5 max-w-2xl text-2xl font-bold tracking-tight text-white sm:text-3xl lg:text-[2rem] lg:leading-tight">
                        Ringkasan Anggaran Desa
                    </h1>

                    <p class="mt-3 max-w-2xl text-sm leading-7 text-emerald-50/90">
                        Warga dapat melihat gambaran pendapatan, belanja, pembiayaan, serta perkembangan realisasi anggaran
                        desa secara terbuka, ringkas, dan mudah dipahami.
                    </p>

                    <div class="mt-7 grid gap-4 sm:grid-cols-3">
                        @foreach ($headlineMetrics as $metric)
                            <div class="rounded-[22px] border border-white/10 bg-gradient-to-br {{ $metric['tone'] }} p-5 shadow-lg shadow-black/5 backdrop-blur-md transition-all duration-300 hover:-translate-y-1 hover:bg-white/15 hover:shadow-xl"
                                data-aos="fade-up" data-aos-delay="{{ 50 + $loop->index * 70 }}">

                                <div class="flex items-center justify-between gap-3">
                                    <span
                                        class="rounded-full bg-white/15 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.18em] text-white/90">
                                        {{ $metric['label'] }}
                                    </span>

                                    <span class="h-2 w-2 rounded-full bg-emerald-300"></span>
                                </div>

                                <p class="mt-5 break-words text-lg font-bold tracking-tight text-white sm:text-xl">
                                    @if (is_numeric($metric['value']))
                                        Rp{{ number_format($metric['value'], 0, ',', '.') }}
                                    @else
                                        {{ $metric['value'] }}
                                    @endif
                                </p>

                                <p class="mt-2 text-xs leading-5 text-emerald-50/80">
                                    {{ $metric['label'] }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <aside
                    class="rounded-[24px] border border-white/10 bg-white/10 p-5 shadow-xl shadow-teal-950/20 backdrop-blur-xl transition-all duration-300 hover:-translate-y-1 hover:bg-white/15"
                    data-aos="fade-left">

                    <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-100">
                        Sekilas Anggaran
                    </p>

                    <div class="mt-4 space-y-3">
                        <div
                            class="flex items-start gap-3 rounded-2xl bg-white/5 px-4 py-3 ring-1 ring-white/10 transition hover:bg-white/10">
                            <span class="mt-1 h-2.5 w-2.5 shrink-0 rounded-full bg-lime-300"></span>
                            <p class="text-xs leading-6 text-white/90">
                                {{ $fiscalYear ? 'Ringkasan ini memakai data tahun anggaran ' . $fiscalYear->year : 'Data APBDesa belum tersedia dari panel admin.' }}
                            </p>
                        </div>

                        <div
                            class="flex items-start gap-3 rounded-2xl bg-white/5 px-4 py-3 ring-1 ring-white/10 transition hover:bg-white/10">
                            <span class="mt-1 h-2.5 w-2.5 shrink-0 rounded-full bg-cyan-300"></span>
                            <p class="text-xs leading-6 text-white/90">
                                {{ number_format($topBudgetLines->count(), 0, ',', '.') }} pos anggaran terbesar ditampilkan
                                agar warga cepat melihat prioritas belanja desa.
                            </p>
                        </div>

                        <div
                            class="flex items-start gap-3 rounded-2xl bg-white/5 px-4 py-3 ring-1 ring-white/10 transition hover:bg-white/10">
                            <span class="mt-1 h-2.5 w-2.5 shrink-0 rounded-full bg-amber-300"></span>
                            <p class="text-xs leading-6 text-white/90">
                                Data realisasi terbaru membantu masyarakat memantau penggunaan anggaran desa.
                            </p>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    {{-- CONTENT --}}
    <section class="relative z-10 bg-gradient-to-b from-emerald-50/60 via-white to-white">
        <div class="mx-auto mt-6 max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
            @if (!$fiscalYear)
                <div class="rounded-[24px] border border-gray-200 bg-white p-8 text-center shadow-xl shadow-gray-200/70"
                    data-aos="fade-up">

                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-emerald-100 text-2xl">
                        📊
                    </div>

                    <h3 class="mt-5 text-xl font-bold text-gray-900">
                        Belum ada data APBDesa
                    </h3>

                    <p class="mx-auto mt-3 max-w-2xl text-sm leading-7 text-gray-600">
                        Ringkasan publik akan tampil otomatis setelah tahun anggaran, akun, dan baris anggaran diisi dari
                        panel admin.
                    </p>
                </div>
            @else
                <main class="space-y-8">

                    {{-- SUMMARY CARD --}}
                    <section class="grid gap-5 md:grid-cols-3">
                        @foreach ($summaryByType as $summary)
                            @php
                                $percent =
                                    $summary['budget'] > 0
                                        ? min(100, round(($summary['realized'] / $summary['budget']) * 100, 1))
                                        : 0;
                            @endphp

                            <article
                                class="group relative -translate-y-14 overflow-hidden rounded-[24px] border bg-gradient-to-br {{ $summaryGradients[$loop->index % count($summaryGradients)] }} p-5 shadow-lg shadow-emerald-100/50 transition-all duration-300 hover:-translate-y-12 hover:shadow-2xl"
                                data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">

                                <div class="absolute -right-10 -top-10 h-28 w-28 rounded-full bg-white/50 blur-2xl"></div>

                                <div class="relative">
                                    <div class="flex items-center justify-between gap-3">
                                        <span
                                            class="rounded-full bg-white/75 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-emerald-700">
                                            {{ $summary['label'] }}
                                        </span>

                                        <span
                                            class="rounded-full bg-emerald-600 px-3 py-1 text-xs font-semibold text-white shadow-sm">
                                            {{ $percent }}%
                                        </span>
                                    </div>

                                    <div class="mt-5">
                                        <p class="text-xs font-medium uppercase tracking-wide text-gray-500">Total Anggaran
                                        </p>
                                        <p class="mt-2 break-words text-2xl font-bold tracking-tight text-gray-900">
                                            Rp{{ number_format($summary['budget'], 0, ',', '.') }}
                                        </p>
                                    </div>

                                    <div class="mt-5">
                                        <div
                                            class="mb-2 flex items-center justify-between text-xs font-semibold text-gray-600">
                                            <span>Progress Realisasi</span>
                                            <span>{{ $percent }}%</span>
                                        </div>

                                        <div class="h-3 overflow-hidden rounded-full bg-white/80">
                                            <div class="h-full rounded-full bg-gradient-to-r from-emerald-500 via-sky-500 to-amber-400 transition-all duration-700"
                                                style="width: {{ $percent }}%">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-5 grid grid-cols-2 gap-3">
                                        <div class="rounded-2xl bg-white/75 px-4 py-3 ring-1 ring-white/70">
                                            <span
                                                class="block text-[11px] font-semibold uppercase tracking-wide text-gray-500">
                                                Realisasi
                                            </span>
                                            <span class="mt-1 block text-sm font-bold text-gray-900">
                                                Rp{{ number_format($summary['realized'], 0, ',', '.') }}
                                            </span>
                                        </div>

                                        <div class="rounded-2xl bg-white/75 px-4 py-3 ring-1 ring-white/70">
                                            <span
                                                class="block text-[11px] font-semibold uppercase tracking-wide text-gray-500">
                                                Jumlah Pos
                                            </span>
                                            <span class="mt-1 block text-sm font-bold text-gray-900">
                                                {{ number_format($summary['line_count'], 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </section>

                    {{-- SUMBER DANA --}}
                    <section
                        class="overflow-hidden -mt-6 rounded-[24px] border border-emerald-100 bg-white shadow-xl shadow-emerald-100/70"
                        data-aos="fade-up">

                        <div
                            class="relative overflow-hidden border-b border-emerald-100 bg-gradient-to-br from-emerald-50 via-green-50 to-sky-50 px-6 py-7 sm:px-8 lg:px-10">
                            <div class="absolute -right-16 -top-16 h-56 w-56 rounded-full bg-emerald-200/40 blur-3xl"></div>
                            <div class="absolute -bottom-20 left-20 h-52 w-52 rounded-full bg-sky-200/40 blur-3xl"></div>

                            <div class="relative grid gap-6 lg:grid-cols-[minmax(0,1fr)_220px] lg:items-center">
                                <div>
                                    <span
                                        class="inline-flex rounded-full bg-emerald-100 px-4 py-1.5 text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-700">
                                        Sumber Dana
                                    </span>

                                    <h2 class="mt-4 text-xl font-bold tracking-tight text-gray-900 sm:text-2xl">
                                        Komposisi Anggaran per Sumber
                                    </h2>

                                    <p class="mt-3 max-w-3xl text-sm leading-7 text-gray-600">
                                        Warga dapat melihat sumber pendanaan utama desa, nilai anggaran, realisasi, dan
                                        jumlah pos secara jelas.
                                    </p>
                                </div>

                                <div
                                    class="rounded-[22px] bg-white/90 p-5 text-center shadow-lg ring-1 ring-emerald-100 transition hover:-translate-y-1 hover:shadow-xl">
                                    <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-gray-500">
                                        Total Sumber
                                    </p>

                                    <p class="mt-2 text-4xl font-bold text-emerald-700">
                                        {{ number_format($fundingSourceSummary->count(), 0, ',', '.') }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500">
                                        sumber dana
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-b from-white to-emerald-50/60 p-5 sm:p-7 lg:p-8">
                            <div class="grid gap-5 xl:grid-cols-2">
                                @forelse ($fundingSourceSummary as $item)
                                    @php
                                        $progress =
                                            $item['budget'] > 0
                                                ? min(100, round(($item['realized'] / $item['budget']) * 100, 1))
                                                : 0;
                                    @endphp

                                    <div class="group relative overflow-hidden rounded-[22px] border border-emerald-100 bg-white p-5 shadow-sm shadow-emerald-100/70 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-emerald-100"
                                        data-aos="fade-up" data-aos-delay="{{ min($loop->index * 60, 240) }}">

                                        <div class="absolute right-4 top-4">
                                            <span
                                                class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-600 text-[11px] font-bold text-white shadow-sm">
                                                #{{ $loop->iteration }}
                                            </span>
                                        </div>

                                        <div class="pr-12">
                                            <p class="text-base font-semibold text-gray-900">
                                                {{ $item['name'] }}
                                            </p>

                                            <p class="mt-1 text-xs text-gray-500">
                                                {{ number_format($item['count'], 0, ',', '.') }} pos anggaran tercatat
                                            </p>
                                        </div>

                                        <div class="mt-5">
                                            <div class="mb-2 flex items-center justify-between text-xs">
                                                <span class="font-semibold text-gray-600">Progress Realisasi</span>
                                                <span class="font-bold text-emerald-700">{{ $progress }}%</span>
                                            </div>

                                            <div class="h-3 overflow-hidden rounded-full bg-emerald-100">
                                                <div class="h-full rounded-full bg-gradient-to-r from-emerald-500 via-sky-500 to-amber-400 transition-all duration-700"
                                                    style="width: {{ $progress }}%">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-5 grid gap-3 sm:grid-cols-2">
                                            <div class="rounded-2xl bg-emerald-50 px-4 py-3">
                                                <span
                                                    class="block text-[11px] font-semibold uppercase tracking-wide text-gray-500">
                                                    Anggaran
                                                </span>

                                                <span class="mt-1 block break-words text-base font-semibold text-gray-900">
                                                    Rp{{ number_format($item['budget'], 0, ',', '.') }}
                                                </span>
                                            </div>

                                            <div class="rounded-2xl bg-sky-50 px-4 py-3">
                                                <span
                                                    class="block text-[11px] font-semibold uppercase tracking-wide text-gray-500">
                                                    Realisasi
                                                </span>

                                                <span class="mt-1 block break-words text-base font-semibold text-sky-700">
                                                    Rp{{ number_format($item['realized'], 0, ',', '.') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div
                                        class="col-span-full rounded-2xl border border-dashed border-gray-300 bg-gray-50 px-6 py-10 text-center text-sm text-gray-500">
                                        Belum ada data sumber dana yang ditampilkan.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </section>

                    {{-- POS ANGGARAN & SPP --}}
                    <section class="grid gap-6 lg:grid-cols-2">
                        <article
                            class="rounded-[24px] border border-gray-200 bg-white p-5 shadow-lg shadow-gray-200/60 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl"
                            data-aos="fade-up">

                            <span class="text-[11px] font-semibold uppercase tracking-[0.2em] text-green-700">
                                Pos Anggaran Utama
                            </span>

                            <h3 class="mt-2 text-xl font-bold text-gray-900">
                                Anggaran Terbesar
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-gray-500">
                                Daftar prioritas belanja dengan nilai anggaran terbesar.
                            </p>

                            <div class="mt-5 space-y-3">
                                @forelse ($topBudgetLines as $line)
                                    <div
                                        class="group rounded-2xl px-4 py-4 text-sm shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg {{ $miniCardGradients[$loop->index % count($miniCardGradients)] }}">
                                        <div class="flex items-start justify-between gap-4">
                                            <div>
                                                <p class="font-semibold text-gray-900">
                                                    {{ $line->account?->code }} - {{ $line->account?->name }}
                                                </p>

                                                <p class="mt-1 line-clamp-2 text-xs leading-6 text-gray-600">
                                                    {{ $line->description }}
                                                </p>
                                            </div>

                                            <span class="shrink-0 text-right text-sm font-semibold text-gray-900">
                                                Rp{{ number_format($line->amount, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                @empty
                                    <div
                                        class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 px-4 py-8 text-center text-sm text-gray-500">
                                        Belum ada pos anggaran utama.
                                    </div>
                                @endforelse
                            </div>
                        </article>

                        <article
                            class="rounded-[24px] border border-gray-200 bg-white p-5 shadow-lg shadow-gray-200/60 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl"
                            data-aos="fade-up" data-aos-delay="100">

                            <span class="text-[11px] font-semibold uppercase tracking-[0.2em] text-green-700">
                                SPP Terbaru
                            </span>

                            <h3 class="mt-2 text-xl font-bold text-gray-900">
                                Permintaan Pembayaran
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-gray-500">
                                Informasi permintaan pembayaran terbaru yang sudah dicatat.
                            </p>

                            <div class="mt-5 space-y-3">
                                @forelse ($latestPaymentRequests as $request)
                                    <div
                                        class="group rounded-2xl px-4 py-4 text-sm shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg {{ $miniCardGradients[$loop->index % count($miniCardGradients)] }}">
                                        <div class="flex items-start justify-between gap-4">
                                            <div>
                                                <p class="font-semibold text-gray-900">
                                                    {{ $request->request_number }}
                                                </p>

                                                <p class="mt-1 text-xs leading-6 text-gray-600">
                                                    {{ $request->payee_name }} •
                                                    {{ optional($request->request_date)->format('d M Y') }}
                                                </p>
                                            </div>

                                            <span class="shrink-0 text-right text-sm font-semibold text-gray-900">
                                                Rp{{ number_format($request->amount, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                @empty
                                    <div
                                        class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 px-4 py-8 text-center text-sm text-gray-500">
                                        Belum ada data SPP yang ditampilkan.
                                    </div>
                                @endforelse
                            </div>
                        </article>
                    </section>

                    {{-- REALISASI TABLE --}}
                    <section
                        class="overflow-hidden rounded-[24px] border border-gray-200 bg-white shadow-lg shadow-gray-200/60"
                        data-aos="fade-up">

                        <div class="border-b border-gray-100 bg-gradient-to-r from-emerald-50 to-sky-50 px-6 py-5">
                            <span class="text-[11px] font-semibold uppercase tracking-[0.2em] text-green-700">
                                Realisasi Terbaru
                            </span>

                            <div class="mt-3 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                                <h2 class="text-xl font-bold text-gray-900">
                                    Pergerakan Belanja yang Sudah Dicatat
                                </h2>

                                <p class="max-w-xl text-sm leading-6 text-gray-600">
                                    Ringkasan transaksi terbaru untuk membantu warga memahami perkembangan realisasi belanja
                                    desa.
                                </p>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-5 py-4 text-left text-[11px] font-semibold uppercase tracking-wide text-gray-600">
                                            Tanggal</th>
                                        <th
                                            class="px-5 py-4 text-left text-[11px] font-semibold uppercase tracking-wide text-gray-600">
                                            Referensi</th>
                                        <th
                                            class="px-5 py-4 text-left text-[11px] font-semibold uppercase tracking-wide text-gray-600">
                                            Pos</th>
                                        <th
                                            class="px-5 py-4 text-right text-[11px] font-semibold uppercase tracking-wide text-gray-600">
                                            Nilai</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-100 bg-white">
                                    @forelse ($latestRealizations as $item)
                                        <tr class="transition duration-200 hover:bg-emerald-50/60">
                                            <td class="px-5 py-4 text-sm text-gray-700">
                                                {{ optional($item->transaction_date)->format('d M Y') }}
                                            </td>

                                            <td class="px-5 py-4 text-sm font-semibold text-gray-800">
                                                {{ $item->reference_number }}
                                            </td>

                                            <td class="px-5 py-4 text-sm text-gray-700">
                                                {{ $item->budgetLine?->account?->code }} -
                                                {{ $item->budgetLine?->description }}
                                            </td>

                                            <td class="px-5 py-4 text-right text-sm font-semibold text-emerald-700">
                                                Rp{{ number_format($item->amount, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-5 py-10 text-center text-sm text-gray-500">
                                                Belum ada realisasi yang dapat ditampilkan.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </section>

                </main>
            @endif
        </div>
    </section>
@endsection
