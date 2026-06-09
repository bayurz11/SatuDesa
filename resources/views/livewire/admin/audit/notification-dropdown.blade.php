<div class="relative" wire:poll.20s>
    <button type="button" wire:click="toggleDropdown"
        class="relative inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white p-2.5 text-gray-400 shadow-sm transition hover:border-blue-200 hover:text-blue-600 hover:shadow-md {{ $open || request()->routeIs('audit-logs.*') ? 'border-blue-200 text-blue-600 ring-2 ring-blue-100' : '' }}"
        title="Notifikasi Audit">
        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
        </svg>

        @if ($unreadCount > 0)
            <span
                class="absolute -right-1 -top-1 inline-flex min-h-[1.1rem] min-w-[1.1rem] items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-semibold text-white">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </span>
        @endif
    </button>

    @if ($open)
        <div class="absolute right-0 z-50 mt-3 w-[24rem] overflow-hidden rounded-3xl border border-blue-100 bg-white shadow-2xl">
            <div class="border-b border-slate-100 bg-gradient-to-r from-slate-50 to-blue-50 px-5 py-4">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Notifikasi Audit</p>
                        <h3 class="mt-1 text-base font-semibold text-slate-900">Ringkasan perubahan terbaru</h3>
                        <p class="mt-1 text-xs text-slate-500">
                            {{ $unreadCount > 0 ? $unreadCount . ' notifikasi belum dibaca' : 'Semua notifikasi sudah dibaca' }}
                        </p>
                    </div>

                    <button type="button" wire:click="closeDropdown"
                        class="rounded-full p-2 text-slate-400 transition hover:bg-white hover:text-slate-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="max-h-[24rem] overflow-y-auto px-3 py-3">
                @forelse ($logs as $log)
                    <button type="button" wire:click="markAsRead({{ $log->id }})"
                        class="block w-full rounded-2xl px-4 py-3 text-left transition hover:bg-slate-50">
                        <div class="flex items-start gap-3">
                            <span class="mt-1 h-2.5 w-2.5 flex-shrink-0 rounded-full {{ $log->is_read ? 'bg-slate-200' : 'bg-red-500' }}"></span>

                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2">
                                    @if ($log->entity_type)
                                        <span class="inline-flex items-center rounded-full border border-blue-200 bg-blue-50 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-[0.16em] text-blue-700">
                                            {{ $log->entity_type }}
                                        </span>
                                    @endif
                                    <span class="text-[11px] text-slate-400">{{ optional($log->logged_at)->diffForHumans() }}</span>
                                </div>
                                <p class="mt-1 line-clamp-2 text-sm font-medium text-slate-800">
                                    {{ \Illuminate\Support\Str::limit($log->message, 88) }}
                                </p>
                                <p class="mt-1 text-xs text-slate-500">
                                    {{ $log->user?->name ?? $log->user_email ?? 'Sistem' }}
                                    @if ($log->action)
                                        • {{ str($log->action)->replace('_', ' ')->title() }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </button>
                @empty
                    <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-8 text-center">
                        <p class="text-sm font-medium text-slate-700">Belum ada notifikasi audit.</p>
                        <p class="mt-1 text-xs text-slate-500">Aktivitas perubahan aplikasi akan muncul di sini.</p>
                    </div>
                @endforelse
            </div>

            <div class="border-t border-slate-100 bg-slate-50 px-4 py-3">
                <div class="flex items-center gap-3">
                    <button type="button" wire:click="markAllAsRead"
                        class="inline-flex flex-1 items-center justify-center rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:border-slate-300 hover:bg-slate-100">
                        Tandai Dibaca
                    </button>
                    <a href="{{ route('audit-logs.index') }}"
                        class="inline-flex flex-1 items-center justify-center rounded-2xl bg-blue-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-blue-700">
                        Lihat Semua
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
