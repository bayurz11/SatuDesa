@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        @if ($currentSection === 'overview')
            <livewire:admin.budgets.budget-dashboard />
        @endif

        <div class="space-y-6">
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl">
                <div class="border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-5">
                    <h2 class="text-lg font-bold text-gray-900">Tahapan Pengerjaan APBDes</h2>
                    <p class="mt-1 text-sm text-gray-600">Setiap menu dipisah dan dibuka berurutan sesuai fondasi data yang harus diselesaikan lebih dulu.</p>
                </div>

                <div class="grid gap-3 px-5 py-5 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($workflowSections as $section)
                        @php
                            $isActive = $currentSection === $section['slug'];
                            $isLocked = !$section['is_unlocked'];
                        @endphp

                        @if ($isLocked)
                            <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-4 py-4 opacity-80">
                                <div class="flex items-start gap-3">
                                    <span class="inline-flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-gray-300 text-sm font-bold text-white">
                                        {{ $section['step'] }}
                                    </span>
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2">
                                            <p class="text-sm font-semibold text-gray-800">{{ $section['short_title'] }}</p>
                                            <span class="rounded-full bg-amber-100 px-2 py-0.5 text-[11px] font-semibold text-amber-700">Terkunci</span>
                                        </div>
                                        <p class="mt-1 text-xs text-gray-600">{{ $section['description'] }}</p>
                                        <p class="mt-2 text-xs font-medium text-amber-700">
                                            Selesaikan lebih dulu: {{ implode(', ', $section['missing_labels']) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <a href="{{ route($section['route_name']) }}"
                                class="block rounded-xl border px-4 py-4 transition-all duration-200 {{ $isActive ? 'border-blue-500 bg-gradient-to-r from-blue-50 to-indigo-50 shadow-md' : 'border-gray-200 bg-white hover:border-blue-300 hover:bg-blue-50/60' }}">
                                <div class="flex items-start gap-3">
                                    <span class="inline-flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full text-sm font-bold {{ $section['is_complete'] ? 'bg-emerald-500 text-white' : 'bg-blue-500 text-white' }}">
                                        {{ $section['step'] }}
                                    </span>
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2">
                                            <p class="text-sm font-semibold text-gray-900">{{ $section['short_title'] }}</p>
                                            <span class="rounded-full px-2 py-0.5 text-[11px] font-semibold {{ $section['is_complete'] ? 'bg-emerald-100 text-emerald-700' : 'bg-sky-100 text-sky-700' }}">
                                                {{ $section['is_complete'] ? 'Siap' : 'Tahap Aktif' }}
                                            </span>
                                        </div>
                                        <p class="mt-1 text-xs text-gray-600">{{ $section['description'] }}</p>
                                    </div>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="space-y-6">
                @if ($currentSection !== 'overview')
                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl">
                        <div class="bg-gradient-to-r from-slate-50 to-blue-50 px-6 py-6">
                            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-blue-700">Tahap {{ $sectionMeta['step'] }}</p>
                                    <h2 class="mt-2 text-2xl font-bold text-gray-900">{{ $sectionMeta['title'] }}</h2>
                                    <p class="mt-2 max-w-3xl text-sm text-gray-600">{{ $sectionMeta['description'] }}</p>
                                </div>
                                <div class="rounded-2xl border border-blue-100 bg-white/90 px-5 py-4 shadow-sm">
                                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-blue-700">Rule Pengerjaan</p>
                                    <p class="mt-2 text-sm font-semibold text-gray-900">
                                        Tahap ini hanya bisa diakses setelah {{ count($sectionMeta['requirement_labels']) > 0 ? implode(', ', $sectionMeta['requirement_labels']) : 'menu dasar APBDes tersedia' }}.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($currentSection === 'fiscal-years')
                    <livewire:admin.budgets.fiscal-year-manager />
                @elseif ($currentSection === 'funding-sources')
                    <livewire:admin.budgets.funding-source-manager />
                @elseif ($currentSection === 'accounts')
                    <livewire:admin.budgets.account-manager />
                @elseif ($currentSection === 'budget-lines')
                    <livewire:admin.budgets.budget-line-manager />
                @elseif ($currentSection === 'operations')
                    <livewire:admin.budgets.operations-board />
                @else
                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl">
                        <div class="border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-cyan-50 px-6 py-5">
                            <h3 class="text-lg font-bold text-gray-900">Rule Akses APBDes</h3>
                            <p class="mt-1 text-sm text-gray-600">Urutan menu mengikuti tahapan kerja agar input data tidak lompat dan saling bergantung dengan benar.</p>
                        </div>

                        <div class="grid gap-4 px-6 py-6 md:grid-cols-2">
                            @foreach ($workflowSections as $section)
                                @continue($section['slug'] === 'overview')

                                <div class="rounded-2xl border border-gray-200 bg-gradient-to-br from-white to-slate-50 p-5 shadow-sm">
                                    <div class="flex items-center justify-between gap-3">
                                        <div>
                                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-blue-700">Tahap {{ $section['step'] }}</p>
                                            <p class="mt-2 text-base font-semibold text-gray-900">{{ $section['title'] }}</p>
                                        </div>
                                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $section['is_unlocked'] ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                            {{ $section['is_unlocked'] ? 'Bisa Diakses' : 'Menunggu Tahap Sebelumnya' }}
                                        </span>
                                    </div>
                                    <p class="mt-3 text-sm text-gray-600">{{ $section['description'] }}</p>
                                    <p class="mt-3 text-sm font-medium text-gray-800">
                                        @if (count($section['requirements']) === 0)
                                            Tahap awal. Bisa langsung dikerjakan.
                                        @else
                                            Prasyarat: {{ implode(', ', $section['requirement_labels']) }}.
                                        @endif
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
