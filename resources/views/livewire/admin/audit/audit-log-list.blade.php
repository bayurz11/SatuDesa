<div class="space-y-6">
    <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 px-6 py-6 text-white">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-blue-200">Audit & Notifikasi</p>
                    <h1 class="mt-2 text-2xl font-semibold">Riwayat Perubahan Aplikasi</h1>
                    <p class="mt-2 max-w-2xl text-sm text-blue-100/90">
                        Pantau aksi create, update, publish, delete, perubahan status, dan aktivitas penting lain sesuai akses role dan permission Anda.
                    </p>
                </div>
            </div>
        </div>

        <div class="grid gap-4 border-t border-slate-100 bg-slate-50/80 px-6 py-5 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Total Log</p>
                <p class="mt-3 text-3xl font-semibold text-slate-900">{{ number_format($stats['total']) }}</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Hari Ini</p>
                <p class="mt-3 text-3xl font-semibold text-slate-900">{{ number_format($stats['today']) }}</p>
            </div>
            <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-500">Perlu Perhatian</p>
                <p class="mt-3 text-3xl font-semibold text-amber-900">{{ number_format($stats['warnings']) }}</p>
            </div>
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-500">Aksi Pengguna</p>
                <p class="mt-3 text-3xl font-semibold text-emerald-900">{{ number_format($stats['user_actions']) }}</p>
            </div>
        </div>
    </section>

    <section class="rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-6 py-5">
            <div class="grid gap-4 lg:grid-cols-[minmax(0,1.3fr)_220px_180px_auto]">
                <div>
                    <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Cari Aktivitas</label>
                    <input wire:model.live.debounce.300ms="search" type="text"
                        placeholder="Cari pesan, email, entity, atau aksi..."
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-100">
                </div>
                <div>
                    <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Kategori</label>
                    <select wire:model.live="category"
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-100">
                        <option value="">Semua kategori</option>
                        @foreach ($categories as $item)
                            <option value="{{ $item }}">{{ str($item)->replace('_', ' ')->title() }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Level</label>
                    <select wire:model.live="level"
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-100">
                        <option value="">Semua level</option>
                        @foreach ($levels as $item)
                            <option value="{{ $item }}">{{ strtoupper($item) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button wire:click="clearFilters" type="button"
                        class="inline-flex w-full items-center justify-center rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-600 transition hover:border-slate-300 hover:bg-slate-50">
                        Reset Filter
                    </button>
                </div>
            </div>
        </div>

        <div class="space-y-4 p-6">
            @forelse ($logs as $log)
                @php
                    $levelClasses = match ($log->level) {
                        'emergency', 'alert', 'critical', 'error' => 'border-red-200 bg-red-50 text-red-700',
                        'warning' => 'border-amber-200 bg-amber-50 text-amber-700',
                        'notice' => 'border-sky-200 bg-sky-50 text-sky-700',
                        default => 'border-emerald-200 bg-emerald-50 text-emerald-700',
                    };
                @endphp

                <article class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-semibold {{ $levelClasses }}">
                                {{ strtoupper($log->level) }}
                            </span>
                            <span class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-medium text-slate-600">
                                {{ str($log->category)->replace('_', ' ')->title() }}
                            </span>
                            @if ($log->entity_type)
                                <span class="inline-flex items-center rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700">
                                    {{ $log->entity_type }}{{ $log->entity_id ? ' #' . $log->entity_id : '' }}
                                </span>
                            @endif
                        </div>

                        <h3 class="mt-4 text-base font-semibold text-slate-900">{{ $log->message }}</h3>

                        <div class="mt-3 grid gap-3 text-sm text-slate-600 md:grid-cols-2 xl:grid-cols-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Pelaku</p>
                                <p class="mt-1">{{ $log->user?->name ?? $log->user_email ?? 'Sistem' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Aksi</p>
                                <p class="mt-1">{{ $log->action ? str($log->action)->replace('_', ' ')->title() : '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Metode</p>
                                <p class="mt-1">{{ $log->method ?: '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Waktu</p>
                                <p class="mt-1">{{ optional($log->logged_at)->format('d M Y H:i') }}</p>
                            </div>
                        </div>

                        @if (($log->context['data'] ?? null) || $log->url || $log->ip_address)
                            <div class="mt-4 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                @if ($log->url)
                                    <p class="mb-2 text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">URL</p>
                                    <p class="mb-3 break-all text-sm text-slate-600">{{ $log->url }}</p>
                                @endif

                                @if ($log->ip_address)
                                    <p class="mb-2 text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">IP Address</p>
                                    <p class="mb-3 text-sm text-slate-600">{{ $log->ip_address }}</p>
                                @endif

                                @if ($log->context['data'] ?? null)
                                    <p class="mb-2 text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Detail Perubahan</p>
                                    <pre class="overflow-x-auto rounded-2xl bg-slate-900 p-4 text-xs leading-6 text-slate-100">{{ json_encode($log->context['data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}</pre>
                                @endif
                            </div>
                        @endif
                    </div>
                </article>
            @empty
                <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 px-6 py-14 text-center">
                    <h3 class="text-lg font-semibold text-slate-900">Belum ada data audit</h3>
                    <p class="mt-2 text-sm text-slate-500">Aktivitas perubahan akan muncul di sini setelah pengguna melakukan aksi pada aplikasi.</p>
                </div>
            @endforelse
        </div>

        @if ($logs->hasPages())
            <div class="border-t border-slate-100 px-6 py-4">
                {{ $logs->links() }}
            </div>
        @endif
    </section>
</div>
