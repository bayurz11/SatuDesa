@php
    $identity = array_replace(
        \App\Domains\Village\Models\VillageProfile::defaultOrganizationIdentityForVillage($village),
        $profile->organization_identity ?? []
    );
    $metaTitle = $identity['page_title'] ?? 'Struktur Organisasi Desa';
    $metaDescription = $identity['page_description'] ?? 'Susunan pemerintahan desa.';
    $resolveOrganizationPhotoUrl = function ($path) {
        if (! $path) {
            return asset('img/avatar-placeholder.png');
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, 'img/')) {
            return asset($path);
        }

        return \App\Support\UploadStorage::url($path);
    };
    $groupLabels = [
        'pimpinan' => 'Pimpinan',
        'mitra' => 'Mitra Desa',
        'sekretariat' => 'Sekretariat',
        'kaur' => 'Kaur',
        'kasi' => 'Kasi',
        'kadus' => 'Kepala Dusun',
    ];
    $positionOptions = collect($profile->organization_position_options ?? \App\Domains\Village\Models\VillageProfile::defaultOrganizationPositionOptions())
        ->keyBy('id');
    $members = collect($profile->organization_members ?? [])
        ->map(function ($member) use ($positionOptions, $groupLabels) {
            $option = $positionOptions->get($member['position_option_id'] ?? null, []);
            $member['position_label'] = $option['label'] ?? '-';
            $member['position_title'] = $option['title'] ?? '-';
            $member['group'] = $option['group'] ?? 'other';
            $member['group_label'] = $groupLabels[$member['group']] ?? 'Lainnya';
            $member['position_sort_order'] = $option['sort_order'] ?? 0;

            return $member;
        })
        ->sortBy([
            ['position_sort_order', 'asc'],
            ['sort_order', 'asc'],
            ['position_title', 'asc'],
        ])
        ->values();
    $headMember = $members->firstWhere('group', 'pimpinan');
    $partnerMember = $members->firstWhere('group', 'mitra');
    $secretaryMember = $members->firstWhere('group', 'sekretariat');
    $kaurItems = $members->where('group', 'kaur')->values();
    $kasiItems = $members->where('group', 'kasi')->values();
    $dusunItems = $members->where('group', 'kadus')->values();
    $hasOrganizationMembers = $members->isNotEmpty();
@endphp

@extends('layouts.public')

@section('content')
    <section class="relative mt-16 overflow-hidden bg-gradient-to-br from-green-950 via-green-900 to-emerald-800 text-white">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.16),_transparent_32%)]"></div>

        <div class="relative mx-auto max-w-7xl px-4 pb-20 pt-10 sm:px-6 lg:px-8">
            <nav class="text-sm text-emerald-100/80" aria-label="Breadcrumb" data-aos="fade-down">
                <ol class="flex flex-wrap items-center gap-2">
                    <li><a href="{{ route('home') }}" class="transition hover:text-white">Beranda</a></li>
                    <li>/</li>
                    <li>Profil Desa</li>
                    <li>/</li>
                    <li class="font-semibold text-white">Struktur Organisasi</li>
                </ol>
            </nav>

            <div class="max-w-4xl" data-aos="fade-up">
                <h1 class="mt-5 max-w-2xl text-2xl font-bold tracking-tight text-white sm:text-3xl lg:text-[2rem] lg:leading-tight">
                    {{ $identity['page_title'] }}
                </h1>

                <p class="mt-3 max-w-xl text-sm leading-7 text-emerald-50/90">
                    {{ $identity['page_description'] }}
                </p>
            </div>
        </div>
    </section>

    <section class="relative z-10 mx-auto -mt-10 max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
        <div class="public-sidebar-grid public-sidebar-grid--320">
            <main class="space-y-8">
                <section data-aos="fade-up" data-aos-delay="100"
                    class="overflow-hidden rounded-[32px] border border-gray-200 bg-white p-5 shadow-lg shadow-gray-200/70 sm:p-7">
                    <div class="text-center">
                        <span class="inline-flex items-center rounded-full bg-green-50 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-green-700 ring-1 ring-green-100">
                            {{ $identity['section_badge'] }}
                        </span>

                        <h2 class="mt-4 text-2xl font-bold text-gray-900 sm:text-3xl">
                            {{ $identity['section_title'] }}
                        </h2>

                        <p class="mx-auto mt-3 max-w-2xl text-sm leading-7 text-gray-600">
                            {{ $identity['section_description'] }}
                        </p>
                    </div>

                    <div class="mt-10">
                        @if (! $hasOrganizationMembers)
                            <div class="rounded-[28px] border border-dashed border-green-200 bg-gradient-to-br from-green-50 to-white p-8 text-center">
                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-green-700 ring-1 ring-green-100 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6a3 3 0 110 6 3 3 0 010-6zM5 21a7 7 0 0114 0" />
                                    </svg>
                                </div>
                                <h3 class="mt-5 text-xl font-bold text-gray-900">Struktur Organisasi Belum Lengkap</h3>
                                <p class="mx-auto mt-3 max-w-2xl text-sm leading-7 text-gray-600">
                                    Data perangkat dan susunan organisasi desa belum diisi seluruhnya. Halaman ini akan menampilkan bagan organisasi publik setelah admin melengkapi datanya.
                                </p>
                            </div>
                        @else
                        <div class="grid items-center gap-6 lg:grid-cols-[1fr_auto_1fr]">
                            <div></div>

                            @if ($headMember)
                                <div data-aos="zoom-in" data-aos-delay="200"
                                    class="mx-auto flex w-full max-w-sm items-center gap-4 rounded-[24px] border-t-4 border-green-700 bg-white p-5 shadow-lg shadow-gray-200/70 ring-1 ring-gray-100">
                                    <img src="{{ $resolveOrganizationPhotoUrl($headMember['photo_path'] ?? null) }}"
                                        alt="{{ $headMember['position_label'] }}"
                                        class="h-14 w-14 shrink-0 rounded-full border-4 border-green-50 object-cover">

                                    <div class="min-w-0 text-left">
                                        <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-green-700">
                                            {{ $headMember['position_label'] }}
                                        </p>
                                        <h3 class="mt-1 truncate text-base font-bold text-gray-900">
                                            {{ $headMember['position_title'] }}
                                        </h3>
                                        <p class="mt-1 truncate text-xs text-gray-500">
                                            {{ $headMember['name'] }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                            @if ($partnerMember)
                                <div data-aos="fade-left" data-aos-delay="250"
                                    class="mx-auto flex w-full max-w-xs items-center gap-3 rounded-[20px] border border-green-100 bg-green-50 p-4 shadow-sm">
                                    <img src="{{ $resolveOrganizationPhotoUrl($partnerMember['photo_path'] ?? null) }}"
                                        alt="{{ $partnerMember['position_label'] }}"
                                        class="h-12 w-12 shrink-0 rounded-full border-4 border-white object-cover">

                                    <div class="min-w-0">
                                        <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-green-700">
                                            {{ $partnerMember['position_label'] }}
                                        </p>
                                        <h4 class="mt-1 truncate text-sm font-bold text-gray-900">
                                            {{ $partnerMember['position_title'] }}
                                        </h4>
                                        <p class="mt-1 truncate text-xs text-gray-500">
                                            {{ $partnerMember['name'] }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if ($secretaryMember)
                            <div class="mx-auto my-6 h-10 w-px bg-green-200"></div>

                            <div data-aos="fade-up" data-aos-delay="300"
                                class="mx-auto flex w-full max-w-sm items-center gap-4 rounded-[22px] border border-gray-200 bg-white p-5 shadow-md shadow-gray-200/60 transition duration-300 hover:-translate-y-1 hover:border-green-200 hover:shadow-lg hover:shadow-green-100/60">
                                <img src="{{ $resolveOrganizationPhotoUrl($secretaryMember['photo_path'] ?? null) }}"
                                    alt="{{ $secretaryMember['position_label'] }}"
                                    class="h-12 w-12 shrink-0 rounded-full border-4 border-green-50 object-cover">

                                <div class="min-w-0 text-left">
                                    <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-green-700">
                                        {{ $secretaryMember['position_label'] }}
                                    </p>
                                    <h4 class="mt-1 truncate text-base font-bold text-gray-900">
                                        {{ $secretaryMember['position_title'] }}
                                    </h4>
                                    <p class="mt-1 truncate text-xs text-gray-500">
                                        {{ $secretaryMember['name'] }}
                                    </p>
                                </div>
                            </div>
                        @endif

                        @php
                            $memberGroups = [
                                ['items' => $kaurItems, 'delay' => 350, 'bg' => 'bg-white', 'border' => 'border-green-50'],
                                ['items' => $kasiItems, 'delay' => 450, 'bg' => 'bg-white', 'border' => 'border-green-50'],
                                ['items' => $dusunItems, 'delay' => 550, 'bg' => 'bg-gray-50/70', 'border' => 'border-white'],
                            ];
                        @endphp

                        <div class="space-y-10 {{ $secretaryMember ? 'mt-6' : 'mt-10' }}">
                            @foreach ($memberGroups as $groupIndex => $group)
                                @if ($group['items']->isNotEmpty())
                                    <div class="grid gap-5 md:grid-cols-3">
                                        @foreach ($group['items'] as $index => $item)
                                            <div data-aos="fade-up" data-aos-delay="{{ $group['delay'] + $index * 80 }}"
                                                class="group flex min-h-[112px] items-center gap-4 rounded-[22px] border border-gray-200 {{ $group['bg'] }} p-5 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-green-200 hover:bg-white hover:shadow-lg hover:shadow-green-100/60">
                                                <img src="{{ $resolveOrganizationPhotoUrl($item['photo_path'] ?? null) }}"
                                                    alt="{{ $item['position_title'] }}"
                                                    class="h-12 w-12 shrink-0 rounded-full border-4 {{ $group['border'] }} object-cover">

                                                <div class="min-w-0 text-left">
                                                    <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-green-700">
                                                        {{ $item['position_label'] }}
                                                    </p>
                                                    <h4 class="mt-1 text-sm font-bold leading-snug text-gray-900">
                                                        {{ $item['position_title'] }}
                                                    </h4>
                                                    <p class="mt-1 truncate text-xs text-gray-500">
                                                        {{ $item['name'] }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    @if (! $loop->last)
                                        <div class="mx-auto h-px max-w-3xl bg-gradient-to-r from-transparent via-green-200 to-transparent"></div>
                                    @endif
                                @endif
                            @endforeach
                        </div>

                        <div class="mt-10 rounded-2xl bg-green-50 px-4 py-3 text-sm leading-6 text-green-800 ring-1 ring-green-100">
                            {{ $identity['note'] ?: 'Bagan ini akan terus diperbarui mengikuti penugasan dan susunan organisasi desa yang aktif.' }}
                        </div>
                        @endif
                    </div>
                </section>
            </main>

            <aside class="space-y-6 lg:sticky lg:top-24 lg:self-start">
                @include('pages.public.partials.profile-sidebar-nav', ['active' => 'organization-structure', 'delay' => 200])

                <div data-aos="fade-left" data-aos-delay="300"
                    class="relative overflow-hidden rounded-[28px] bg-gradient-to-br from-green-700 via-green-800 to-emerald-900 p-6 text-white shadow-lg shadow-green-900/20">
                    <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-white/10"></div>
                    <div class="absolute -bottom-12 -left-12 h-36 w-36 rounded-full bg-black/10"></div>

                    <div class="relative">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-white/15 text-white ring-1 ring-white/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6a3 3 0 110 6 3 3 0 010-6zM5 21a7 7 0 0114 0" />
                            </svg>
                        </div>

                        <h2 class="text-lg font-bold">{{ $identity['sidebar_title'] ?: 'Informasi Struktur Desa' }}</h2>

                        <p class="mt-3 text-sm leading-6 text-white/85">
                            {{ $identity['sidebar_description'] ?: 'Panel ini akan menampilkan catatan singkat mengenai susunan organisasi, fungsi, dan pembagian peran perangkat desa.' }}
                        </p>
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection
