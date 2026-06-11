@extends('layouts.app')

@section('content')
    @php
        $historyCards = old('history_cards', $historyCards ?? []);
        $timelineItems = old('history_timeline_items', $timelineItems ?? []);
        $publicHistoryUrl = route('public.history');
    @endphp

    <div class="space-y-8 animate-fadeInUp">
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-700 via-slate-800 to-slate-900 shadow-2xl">
            <div class="absolute inset-0 bg-white/5"></div>

            <div class="relative p-8 text-white">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                    <div class="max-w-3xl">
                        <span class="inline-flex items-center rounded-full bg-white/10 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-slate-100 ring-1 ring-white/15">
                            Profil Desa
                        </span>
                        <h1 class="mt-5 text-4xl font-bold">Sejarah Desa</h1>
                        <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-200">
                            Kelola judul, narasi utama, kartu sejarah, dan linimasa publik agar halaman sejarah desa
                            mudah diperbarui dari admin.
                        </p>
                    </div>

                    <div class="w-full max-w-sm rounded-2xl border border-white/10 bg-white/10 p-5 backdrop-blur">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-200">Ringkasan</p>
                        <div class="mt-4 space-y-3">
                            <div class="rounded-xl bg-white/10 px-4 py-3">
                                <p class="text-sm font-semibold text-white">Desa</p>
                                <p class="mt-1 text-sm text-slate-200">{{ $village->name }}</p>
                            </div>
                            <div class="rounded-xl bg-white/10 px-4 py-3">
                                <p class="text-sm font-semibold text-white">Preview Publik</p>
                                <a href="{{ $publicHistoryUrl }}" target="_blank" rel="noopener noreferrer"
                                    class="mt-1 inline-flex text-sm text-slate-100 underline underline-offset-4">
                                    Buka halaman publik
                                </a>
                            </div>
                            <div class="rounded-xl bg-white/10 px-4 py-3 text-sm text-slate-200">
                                Struktur form mengikuti pola halaman sejarah publik: hero, dua kartu sejarah, linimasa, dan catatan samping.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('village-histories.update') }}" class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_360px]">
            @csrf
            @method('PUT')

            <main class="space-y-8">
                <section class="module-panel">
                    <div class="module-panel-header px-6 py-6">
                        <div class="flex items-center justify-between gap-4 flex-col sm:flex-row">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">Identitas Halaman Publik</h2>
                                <p class="mt-1 text-sm text-gray-600">Bagian ini mengatur judul utama, deskripsi, badge hero, dan gambar sampul.</p>
                            </div>
                            @permission('village_histories.edit')
                                <button type="submit" class="module-primary-btn px-6 py-3 text-sm">Simpan Perubahan</button>
                            @endpermission
                        </div>
                    </div>

                    <div class="p-6 sm:p-8 grid gap-6 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700">Judul Halaman</label>
                            <input type="text" name="history_title" value="{{ old('history_title', $profile->history_title) }}"
                                class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                            @error('history_title')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700">Deskripsi Halaman</label>
                            <textarea name="history_description" rows="3" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ old('history_description', $profile->history_description) }}</textarea>
                            @error('history_description')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Badge Hero</label>
                            <input type="text" name="history_cover_badge" value="{{ old('history_cover_badge', $profile->history_cover_badge) }}"
                                class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                            @error('history_cover_badge')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Judul Hero</label>
                            <input type="text" name="history_cover_title" value="{{ old('history_cover_title', $profile->history_cover_title) }}"
                                class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                            @error('history_cover_title')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700">Path Gambar Hero</label>
                            <input type="text" name="history_cover_image_path" value="{{ old('history_cover_image_path', $profile->history_cover_image_path) }}"
                                class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" placeholder="contoh: img/bg.jpg">
                            @error('history_cover_image_path')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700">Narasi Pembuka</label>
                            <textarea name="history_intro_text" rows="5" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ old('history_intro_text', $profile->history_intro_text) }}</textarea>
                            @error('history_intro_text')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </section>

                <section class="module-panel">
                    <div class="module-panel-header px-6 py-5">
                        <h2 class="text-xl font-semibold text-gray-900">Kartu Sejarah</h2>
                        <p class="mt-1 text-sm text-gray-600">Dua kartu ini mengikuti pola `Awal Mula` dan `Perkembangan` pada halaman publik.</p>
                    </div>

                    <div class="p-6 sm:p-8 grid gap-6">
                        @foreach ($historyCards as $index => $card)
                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                                <h3 class="text-lg font-semibold text-gray-900">Kartu {{ $index + 1 }}</h3>
                                <div class="mt-5 grid gap-5 md:grid-cols-2">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700">Badge</label>
                                        <input type="text" name="history_cards[{{ $index }}][badge]" value="{{ $card['badge'] ?? '' }}"
                                            class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700">Ikon</label>
                                        <select name="history_cards[{{ $index }}][icon]" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                            @foreach (['home' => 'Home', 'building' => 'Building', 'spark' => 'Spark'] as $value => $label)
                                                <option value="{{ $value }}" @selected(($card['icon'] ?? 'home') === $value)>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700">Judul</label>
                                        <input type="text" name="history_cards[{{ $index }}][title]" value="{{ $card['title'] ?? '' }}"
                                            class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700">Deskripsi</label>
                                        <textarea name="history_cards[{{ $index }}][description]" rows="4" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ $card['description'] ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section class="module-panel">
                    <div class="module-panel-header px-6 py-5">
                        <h2 class="text-xl font-semibold text-gray-900">Linimasa Sejarah</h2>
                        <p class="mt-1 text-sm text-gray-600">Tiga item linimasa ini mengikuti struktur halaman publik saat ini.</p>
                    </div>

                    <div class="p-6 sm:p-8 grid gap-6">
                        <div class="grid gap-5 md:grid-cols-2">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Badge Linimasa</label>
                                <input type="text" name="history_timeline_badge" value="{{ old('history_timeline_badge', $profile->history_timeline_badge) }}"
                                    class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Judul Linimasa</label>
                                <input type="text" name="history_timeline_title" value="{{ old('history_timeline_title', $profile->history_timeline_title) }}"
                                    class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                            </div>
                        </div>

                        @foreach ($timelineItems as $index => $item)
                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                                <h3 class="text-lg font-semibold text-gray-900">Item Linimasa {{ $index + 1 }}</h3>
                                <div class="mt-5 grid gap-5 md:grid-cols-2">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700">Label</label>
                                        <input type="text" name="history_timeline_items[{{ $index }}][label]" value="{{ $item['label'] ?? '' }}"
                                            class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700">Ikon</label>
                                        <select name="history_timeline_items[{{ $index }}][icon]" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                            @foreach (['home' => 'Home', 'building' => 'Building', 'spark' => 'Spark'] as $value => $label)
                                                <option value="{{ $value }}" @selected(($item['icon'] ?? 'home') === $value)>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700">Judul</label>
                                        <input type="text" name="history_timeline_items[{{ $index }}][title]" value="{{ $item['title'] ?? '' }}"
                                            class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700">Deskripsi</label>
                                        <textarea name="history_timeline_items[{{ $index }}][desc]" rows="4" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ $item['desc'] ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section class="module-panel">
                    <div class="module-panel-header px-6 py-5">
                        <h2 class="text-xl font-semibold text-gray-900">Catatan Samping</h2>
                    </div>

                    <div class="p-6 sm:p-8 grid gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Judul Catatan</label>
                            <input type="text" name="history_sidebar_title" value="{{ old('history_sidebar_title', $profile->history_sidebar_title) }}"
                                class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Deskripsi Catatan</label>
                            <textarea name="history_sidebar_description" rows="4" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ old('history_sidebar_description', $profile->history_sidebar_description) }}</textarea>
                        </div>
                    </div>
                </section>
            </main>

            <aside class="space-y-8 lg:sticky lg:top-24 lg:self-start">
                <section class="module-panel">
                    <div class="module-panel-header px-6 py-5">
                        <h2 class="text-xl font-semibold text-gray-900">Preview Ringkas</h2>
                        <p class="mt-1 text-sm text-gray-600">Ringkasan ini mengikuti konten utama yang tampil di publik.</p>
                    </div>

                    <div class="p-6 space-y-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-700">Judul Publik</p>
                            <p class="mt-2 text-lg font-semibold text-gray-900">{{ old('history_title', $profile->history_title) }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-700">Deskripsi Publik</p>
                            <p class="mt-2 text-sm leading-6 text-gray-600">{{ old('history_description', $profile->history_description) }}</p>
                        </div>
                        <div class="rounded-2xl bg-blue-50 px-4 py-4 text-sm text-blue-800">
                            Kartu sejarah: <span class="font-semibold">{{ count($historyCards) }}</span><br>
                            Item linimasa: <span class="font-semibold">{{ count($timelineItems) }}</span>
                        </div>
                    </div>
                </section>

                <section class="module-panel p-6">
                    <h2 class="text-xl font-semibold text-gray-900">Pola Publik</h2>
                    <div class="mt-4 space-y-3 text-sm text-gray-600">
                        <div class="rounded-xl bg-gray-50 px-4 py-3">Hero publik mengambil judul, deskripsi, badge, gambar, dan narasi utama dari form ini.</div>
                        <div class="rounded-xl bg-gray-50 px-4 py-3">Dua kartu sejarah dan tiga item linimasa mengikuti struktur halaman publik saat ini.</div>
                        <div class="rounded-xl bg-gray-50 px-4 py-3">Catatan samping di kanan publik juga dapat diperbarui dari halaman admin ini.</div>
                    </div>
                </section>
            </aside>
        </form>
    </div>
@endsection
