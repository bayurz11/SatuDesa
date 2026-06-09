<div class="space-y-6">
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl">
        <div class="border-b border-gray-200 bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 px-6 py-6">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-purple-600 shadow-lg">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Dashboard APBDes</h2>
                        <p class="mt-1 text-sm text-gray-600">
                            Ringkasan ini memudahkan admin desa melihat struktur APBDes, posisi anggaran, dan capaian realisasi dalam satu halaman kerja.
                        </p>
                    </div>
                </div>
                <div class="rounded-2xl border border-blue-100 bg-white/90 px-5 py-4 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-blue-700">Cakupan Modul</p>
                    <p class="mt-2 text-sm font-semibold text-gray-900">Perencanaan, Operasional, dan Publikasi</p>
                    <p class="mt-1 text-sm text-gray-600">Tahun anggaran, sumber dana, akun, baris anggaran, realisasi, SPP, dan publikasi ringkas sudah disatukan ke modul APBDes.</p>
                </div>
            </div>
        </div>

        <div class="grid gap-2.5 px-5 py-4 md:grid-cols-2 xl:grid-cols-3">
            <div class="rounded-xl border border-blue-100 bg-gradient-to-br from-blue-50 to-white p-3.5 shadow-sm">
                <p class="text-xs font-medium text-gray-600 sm:text-sm">Tahun Anggaran</p>
                <p class="mt-2 text-lg font-bold leading-tight text-gray-900 sm:text-xl xl:text-2xl">{{ number_format($stats['fiscal_years'], 0, ',', '.') }}</p>
                <p class="mt-2 text-xs font-semibold text-blue-700 sm:text-sm">Draft dan aktif</p>
            </div>
            <div class="rounded-xl border border-indigo-100 bg-gradient-to-br from-indigo-50 to-white p-3.5 shadow-sm">
                <p class="text-xs font-medium text-gray-600 sm:text-sm">Tahun Aktif</p>
                <p class="mt-2 text-lg font-bold leading-tight text-gray-900 sm:text-xl xl:text-2xl">{{ number_format($stats['active_years'], 0, ',', '.') }}</p>
                <p class="mt-2 text-xs font-semibold text-indigo-700 sm:text-sm">Sedang berjalan</p>
            </div>
            <div class="rounded-xl border border-purple-100 bg-gradient-to-br from-purple-50 to-white p-3.5 shadow-sm">
                <p class="text-xs font-medium text-gray-600 sm:text-sm">Sumber Dana</p>
                <p class="mt-2 text-lg font-bold leading-tight text-gray-900 sm:text-xl xl:text-2xl">{{ number_format($stats['funding_sources'], 0, ',', '.') }}</p>
                <p class="mt-2 text-xs font-semibold text-purple-700 sm:text-sm">Referensi aktif</p>
            </div>
            <div class="rounded-xl border border-sky-100 bg-gradient-to-br from-sky-50 to-white p-3.5 shadow-sm">
                <p class="text-xs font-medium text-gray-600 sm:text-sm">Akun APBDes</p>
                <p class="mt-2 text-lg font-bold leading-tight text-gray-900 sm:text-xl xl:text-2xl">{{ number_format($stats['accounts'], 0, ',', '.') }}</p>
                <p class="mt-2 text-xs font-semibold text-sky-700 sm:text-sm">Struktur awal</p>
            </div>
            <div class="rounded-xl border border-amber-100 bg-gradient-to-br from-amber-50 to-white p-3.5 shadow-sm">
                <p class="text-xs font-medium text-gray-600 sm:text-sm">Total Anggaran</p>
                <p class="mt-2 break-all text-lg font-bold leading-tight tracking-tight text-gray-900 sm:text-xl xl:text-2xl">Rp{{ number_format($stats['total_budget'], 0, ',', '.') }}</p>
                <p class="mt-2 text-xs font-semibold text-amber-700 sm:text-sm">Akumulasi semua baris</p>
            </div>
            <div class="rounded-xl border border-indigo-100 bg-gradient-to-br from-indigo-50 to-white p-3.5 shadow-sm">
                <p class="text-xs font-medium text-gray-600 sm:text-sm">Total Realisasi</p>
                <p class="mt-2 break-all text-lg font-bold leading-tight tracking-tight text-gray-900 sm:text-xl xl:text-2xl">Rp{{ number_format($stats['total_realization'], 0, ',', '.') }}</p>
                <p class="mt-2 text-xs font-semibold text-indigo-700 sm:text-sm">Terpakai saat ini</p>
            </div>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl">
            <div class="border-b border-gray-200 bg-gradient-to-r from-slate-50 to-gray-50 px-6 py-5">
                <h3 class="text-lg font-bold text-gray-900">Ringkasan Struktur APBDes</h3>
                <p class="mt-1 text-sm text-gray-600">Pembagian utama mengikuti komponen APBDes: pendapatan, belanja, dan pembiayaan.</p>
            </div>
            <div class="grid gap-2.5 px-5 py-4">
                @foreach ($accountTypeSummary as $summary)
                    <div class="rounded-xl border border-gray-200 bg-gradient-to-br {{ $summary['type'] === 'pendapatan' ? 'from-emerald-50 to-white' : ($summary['type'] === 'belanja' ? 'from-sky-50 to-white' : 'from-amber-50 to-white') }} p-3.5 shadow-sm">
                        <p class="text-sm font-semibold text-gray-900">{{ $summary['label'] }}</p>
                        <p class="mt-3 break-all text-lg font-bold leading-tight tracking-tight text-gray-900 sm:text-xl xl:text-2xl">Rp{{ number_format($summary['amount'], 0, ',', '.') }}</p>
                        <div class="mt-3 space-y-1.5 text-xs text-gray-600 sm:text-sm">
                            <div class="flex items-center justify-between">
                                <span>Jumlah baris</span>
                                <span class="font-semibold text-gray-900">{{ number_format($summary['line_count'], 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span>Realisasi</span>
                                <span class="font-semibold text-gray-900">Rp{{ number_format($summary['realized_amount'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl">
            <div class="border-b border-gray-200 bg-gradient-to-r from-blue-50 to-purple-50 px-6 py-5">
                <h3 class="text-lg font-bold text-gray-900">Cakupan Pengelolaan</h3>
                <p class="mt-1 text-sm text-gray-600">Bagian ini menjadi rule pengerjaan APBDes. Menu berikutnya baru dibuka setelah tahap sebelumnya siap.</p>
            </div>
            <div class="space-y-3 px-6 py-6">
                @foreach ($workflowSections as $section)
                    <div class="flex items-start gap-3 rounded-2xl border {{ $section['is_unlocked'] ? 'border-blue-100 bg-gradient-to-r from-blue-50 to-white' : 'border-dashed border-gray-300 bg-gray-50' }} px-4 py-3 text-sm text-gray-700">
                        <span class="mt-0.5 inline-flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full {{ $section['is_complete'] ? 'bg-emerald-500' : ($section['is_unlocked'] ? 'bg-blue-500' : 'bg-gray-400') }} text-xs font-bold text-white">{{ $section['step'] }}</span>
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-gray-900">{{ $section['title'] }}</span>
                                <span class="rounded-full px-2 py-0.5 text-[11px] font-semibold {{ $section['is_unlocked'] ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ $section['is_unlocked'] ? 'Bisa Diakses' : 'Terkunci' }}
                                </span>
                            </div>
                            <p class="mt-1">{{ $section['description'] }}</p>
                            @if (!$section['is_unlocked'])
                                <p class="mt-2 text-xs font-medium text-amber-700">Prasyarat: {{ implode(', ', $section['missing_labels']) }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid gap-6">
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl">
            <div class="border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-5">
                <h3 class="text-lg font-bold text-gray-900">Tahun Anggaran</h3>
                <p class="mt-1 text-sm text-gray-600">Ringkasan tahun anggaran yang sudah tersedia sebagai basis pengelolaan APBDes.</p>
            </div>
            <div class="px-6 py-6">
                @forelse ($fiscalYears as $fiscalYear)
                    <div class="mb-2.5 rounded-xl border border-gray-200 bg-gradient-to-r from-white to-slate-50 p-3.5 shadow-sm last:mb-0">
                        <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                            <div>
                                <p class="text-base font-semibold text-gray-900">{{ $fiscalYear->title }}</p>
                                <p class="mt-1 text-sm text-gray-600">
                                    Tahun {{ $fiscalYear->year }} • Status {{ ucfirst($fiscalYear->status) }}
                                </p>
                            </div>
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $fiscalYear->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ $fiscalYear->status === 'active' ? 'Aktif' : 'Draft' }}
                            </span>
                        </div>
                        <div class="mt-3 grid gap-3 sm:grid-cols-3">
                            <div class="rounded-lg bg-emerald-50 px-3 py-2">
                                <p class="text-xs font-semibold uppercase tracking-wide text-emerald-700">Baris Anggaran</p>
                                <p class="mt-2 text-base font-bold text-gray-900 sm:text-lg xl:text-xl">{{ number_format($fiscalYear->budget_lines_count, 0, ',', '.') }}</p>
                            </div>
                            <div class="rounded-lg bg-sky-50 px-3 py-2">
                                <p class="text-xs font-semibold uppercase tracking-wide text-sky-700">Total Anggaran</p>
                                <p class="mt-2 break-all text-sm font-bold leading-tight text-gray-900 sm:text-base xl:text-lg">Rp{{ number_format($fiscalYear->budget_lines_sum_amount ?? 0, 0, ',', '.') }}</p>
                            </div>
                            <div class="rounded-lg bg-indigo-50 px-3 py-2">
                                <p class="text-xs font-semibold uppercase tracking-wide text-indigo-700">Realisasi</p>
                                <p class="mt-2 break-all text-sm font-bold leading-tight text-gray-900 sm:text-base xl:text-lg">Rp{{ number_format($fiscalYear->budget_lines_sum_realized_amount ?? 0, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 px-6 py-10 text-center">
                        <p class="text-lg font-semibold text-gray-900">Belum ada tahun anggaran</p>
                        <p class="mt-2 text-sm text-gray-600">Seeder referensi belum dijalankan atau data tahun anggaran belum dibuat.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl">
            <div class="border-b border-gray-200 bg-gradient-to-r from-cyan-50 to-teal-50 px-6 py-5">
                <h3 class="text-lg font-bold text-gray-900">Sumber Dana APBDes</h3>
                <p class="mt-1 text-sm text-gray-600">Daftar sumber dana inti yang sudah disiapkan untuk penyusunan anggaran.</p>
            </div>
            <div class="px-6 py-6">
                <div class="grid gap-3 md:grid-cols-2">
                    @foreach ($fundingSources as $source)
                        @php
                            $budgetAmount = (float) ($source->budget_lines_sum_amount ?? 0);
                            $realizedAmount = (float) ($source->budget_lines_sum_realized_amount ?? 0);
                            $progress = $budgetAmount > 0 ? min(100, round(($realizedAmount / $budgetAmount) * 100, 1)) : 0;
                        @endphp

                        <div class="rounded-xl border border-emerald-100 bg-gradient-to-r from-white via-teal-50/70 to-emerald-50 p-3.5 shadow-sm">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                <div>
                                    <p class="text-xl font-semibold text-gray-900">{{ $source->name }}</p>
                                    <p class="mt-1 text-xs uppercase tracking-wide text-teal-700">{{ $source->code }}</p>
                                </div>
                                <span class="inline-flex w-fit rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                    {{ number_format($source->budget_lines_count, 0, ',', '.') }} pos
                                </span>
                            </div>

                            <div class="mt-4 h-3 overflow-hidden rounded-full bg-emerald-100">
                                <div class="h-full rounded-full bg-gradient-to-r from-emerald-500 via-amber-400 to-orange-400" style="width: {{ $progress }}%"></div>
                            </div>

                            <div class="mt-4 grid gap-3 border-t border-emerald-100 pt-3 sm:grid-cols-3">
                                <div>
                                    <p class="text-xs uppercase tracking-wide text-gray-500">Anggaran</p>
                                    <p class="mt-1 break-all text-sm font-bold leading-tight tracking-tight text-gray-900 sm:text-base xl:text-lg">Rp{{ number_format($budgetAmount, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-wide text-gray-500">Realisasi</p>
                                    <p class="mt-1 break-all text-sm font-bold leading-tight tracking-tight text-sky-700 sm:text-base xl:text-lg">Rp{{ number_format($realizedAmount, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-wide text-gray-500">Serapan</p>
                                    <p class="mt-1 text-sm font-bold text-emerald-700 sm:text-base xl:text-lg">{{ rtrim(rtrim(number_format($progress, 1, '.', ''), '0'), '.') }}%</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
