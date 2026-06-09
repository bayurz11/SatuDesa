@php
    $metaTitle = $potential->title;
    $metaDescription = $potential->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($potential->content), 160);
@endphp

@extends('layouts.public')

@section('content')
    <style>
        .potential-content .ql-ui {
            display: none;
        }
    </style>

    <section
        class="relative mt-16 overflow-hidden bg-[linear-gradient(135deg,_#052e16_0%,_#14532d_45%,_#166534_100%)] text-white">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.16),_transparent_30%)]">
        </div>

        <div class="relative mx-auto max-w-7xl px-4 pb-20 pt-10 sm:px-6 lg:px-8">
            <nav class="text-sm text-emerald-100/80" aria-label="Breadcrumb">
                <ol class="flex flex-wrap items-center gap-2">
                    <li><a href="{{ route('home') }}" class="transition hover:text-white">Beranda</a></li>
                    <li>/</li>
                    <li><a href="{{ route('public.potentials.index') }}" class="transition hover:text-white">Potensi Desa</a>
                    </li>
                    <li>/</li>
                    <li class="line-clamp-1 font-semibold text-white">{{ $potential->title }}</li>
                </ol>
            </nav>

            <div class="mt-8 grid gap-8 lg:grid-cols-[minmax(0,1fr)_330px] lg:items-end">
                <div class="max-w-4xl" data-aos="fade-up" data-aos-duration="700">
                    <div class="flex flex-wrap items-center gap-3">
                        @if ($potential->category)
                            <span
                                class="inline-flex items-center rounded-full bg-white/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-emerald-50 ring-1 ring-white/15">
                                {{ $potential->category->name }}
                            </span>
                        @endif

                        @if ($potential->potential_type)
                            <span
                                class="inline-flex items-center rounded-full bg-lime-300/15 px-4 py-1 text-xs font-semibold text-lime-50 ring-1 ring-lime-100/20">
                                {{ $potential->potential_type }}
                            </span>
                        @endif
                    </div>

                    <h1 class="mt-6 text-4xl font-bold tracking-tight sm:text-5xl sm:leading-tight">
                        {{ $potential->title }}
                    </h1>

                    @if ($potential->excerpt)
                        <p class="mt-4 max-w-3xl text-sm leading-7 text-emerald-50/90 sm:text-base">
                            {{ $potential->excerpt }}
                        </p>
                    @endif

                    <div class="mt-8 grid gap-4 sm:grid-cols-3">
                        <div class="rounded-[24px] border border-white/10 bg-white/10 p-4 backdrop-blur transition duration-300 hover:-translate-y-1 hover:bg-white/15"
                            data-aos="zoom-in" data-aos-delay="50" data-aos-duration="600">

                            <div class="flex items-center gap-3">
                                <div class="flex h-11 w-11 items-center justify-center  text-white/90">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                    </svg>
                                </div>

                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-100">
                                        Lokasi
                                    </p>
                                    <p class="mt-1 text-sm font-bold text-white">
                                        {{ $potential->location_name ?: $potential->village->name ?? 'Desa Mentuda' }}
                                    </p>
                                </div>
                            </div>

                        </div>

                        <div class="rounded-[24px] border border-white/10 bg-white/10 p-4 backdrop-blur transition duration-300 hover:-translate-y-1 hover:bg-white/15"
                            data-aos="zoom-in" data-aos-delay="120" data-aos-duration="600">

                            <div class="flex items-center gap-3">
                                <div class="flex h-11 w-11 items-center justify-center  text-white/90">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
                                    </svg>
                                </div>

                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-100">
                                        Status
                                    </p>
                                    <p class="mt-1 text-sm font-bold text-white">
                                        {{ $potential->development_status ?: 'Dalam tahap pengembangan' }}
                                    </p>
                                </div>
                            </div>

                        </div>

                        <div class="rounded-[24px] border border-white/10 bg-white/10 p-4 backdrop-blur transition duration-300 hover:-translate-y-1 hover:bg-white/15"
                            data-aos="zoom-in" data-aos-delay="190" data-aos-duration="600">

                            <div class="flex items-center gap-3">
                                <div class="flex h-11 w-11 items-center justify-center text-white/90">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </div>

                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-100">
                                        Publikasi
                                    </p>
                                    <p class="mt-1 text-sm font-bold text-white">
                                        {{ optional($potential->published_at)->translatedFormat('d F Y') }}
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="rounded-[32px] border border-white/10 bg-white/10 p-6 backdrop-blur-xl shadow-2xl shadow-green-950/20 transition duration-300 hover:-translate-y-1 hover:bg-white/15"
                    data-aos="fade-left" data-aos-duration="750" data-aos-delay="120">
                    <div class="flex flex-wrap items-center gap-2">
                        <span
                            class="inline-flex items-center rounded-full bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-emerald-100 ring-1 ring-white/10">
                            Ringkasan Potensi
                        </span>

                    </div>

                    <div class="mt-6">

                        @if ($potential->contact_person || $potential->contact_phone)
                            <p class="mb-3 text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-100/90">
                                Kontak
                            </p>

                            @if ($potential->contact_phone)
                                <a href="https://wa.me/{{ preg_replace('/\D+/', '', $potential->contact_phone) }}"
                                    target="_blank" rel="noopener noreferrer"
                                    class="group flex w-full items-center justify-between rounded-2xl bg-[#25D366] px-5 py-4 transition-all duration-300 hover:-translate-y-1 hover:bg-[#20bd5a] hover:shadow-xl hover:shadow-black/20">

                                    <!-- Kiri -->
                                    <div class="flex items-center gap-4">

                                        <div
                                            class="flex h-12 w-12 items-center justify-center rounded-full bg-white/15 transition-all duration-300 group-hover:scale-105">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white"
                                                viewBox="0 0 24 24" fill="currentColor">
                                                <path
                                                    d="M20.52 3.48A11.86 11.86 0 0 0 12.07 0C5.49 0 .15 5.34.15 11.92c0 2.1.55 4.15 1.6 5.96L0 24l6.28-1.65a11.88 11.88 0 0 0 5.79 1.48h.01c6.58 0 11.92-5.34 11.92-11.92 0-3.18-1.24-6.17-3.48-8.43ZM12.08 21.8h-.01a9.87 9.87 0 0 1-5.04-1.38l-.36-.21-3.72.98.99-3.63-.23-.37a9.86 9.86 0 0 1-1.51-5.27c0-5.45 4.43-9.88 9.88-9.88 2.64 0 5.12 1.03 6.98 2.9a9.8 9.8 0 0 1 2.89 6.98c0 5.45-4.43 9.88-9.87 9.88Zm5.42-7.4c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.47-.89-.79-1.49-1.76-1.66-2.06-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.18.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48s1.07 2.88 1.22 3.08c.15.2 2.1 3.2 5.08 4.48.71.31 1.26.49 1.69.63.71.23 1.36.2 1.87.12.57-.08 1.76-.72 2.01-1.42.25-.7.25-1.3.17-1.42-.07-.13-.27-.2-.57-.35Z" />
                                            </svg>
                                        </div>

                                        <div>
                                            <p class="text-lg font-bold leading-none text-white">
                                                {{ $potential->contact_person ?: 'Admin Desa' }}
                                            </p>

                                            <p class="mt-1 text-sm text-white/85">
                                                {{ $potential->contact_phone }}
                                            </p>
                                        </div>

                                    </div>

                                </a>
                            @else
                                <div class="rounded-2xl bg-white/10 px-5 py-4 text-white/90">
                                    {{ $potential->contact_person ?: 'Belum ada informasi kontak.' }}
                                </div>
                            @endif
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="relative z-10 mx-auto -mt-10 max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_340px]">
            <main class="space-y-8">
                <article class="overflow-hidden rounded-[32px] border border-gray-200 bg-white shadow-xl shadow-gray-200/70"
                    data-aos="fade-up" data-aos-duration="750">
                    <div class="relative overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200">
                        @if ($potential->cover_image_url)
                            <img src="{{ $potential->cover_image_url }}"
                                alt="{{ $potential->cover_image_alt ?: $potential->title }}"
                                class="max-h-[520px] w-full object-cover">
                        @else
                            <div
                                class="flex min-h-[360px] items-end bg-[linear-gradient(160deg,_#14532d_0%,_#15803d_48%,_#65a30d_100%)] p-8 text-white">
                                <div class="max-w-3xl">
                                    <span
                                        class="inline-flex rounded-full bg-white/15 px-4 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-white/90 ring-1 ring-white/20">
                                        Potensi Desa Mentuda
                                    </span>
                                    <h2 class="mt-4 text-3xl font-bold leading-tight">
                                        {{ $potential->title }}
                                    </h2>
                                    <p class="mt-3 text-sm leading-7 text-white/85">
                                        Potensi ini menjadi bagian penting dari pengembangan dan penguatan identitas Desa
                                        Mentuda.
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if ($potential->cover_image_caption)
                        <p class="border-b border-gray-100 bg-gray-50 px-6 py-3 text-center text-sm text-gray-500">
                            {{ $potential->cover_image_caption }}
                        </p>
                    @endif

                    <div class="p-6 sm:p-10">
                        <div
                            class="potential-content prose prose-lg max-w-none prose-headings:font-bold prose-headings:text-gray-900 prose-p:leading-8 prose-p:text-gray-700 prose-a:text-green-700 prose-strong:text-gray-900 prose-ul:list-disc prose-li:marker:text-green-600 prose-blockquote:border-l-4 prose-blockquote:border-green-700 prose-blockquote:bg-green-50 prose-blockquote:px-5 prose-blockquote:py-3">
                            {!! $potential->content !!}
                        </div>
                    </div>
                </article>

                <section
                    class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-green-100/70 sm:p-8"
                    data-aos="fade-up" data-aos-duration="700" data-aos-delay="80">
                    <span class="text-xs font-semibold uppercase tracking-[0.24em] text-green-700">Fasilitas</span>
                    <h3 class="mt-3 text-2xl font-bold text-gray-900">Fasilitas dan dukungan yang tersedia</h3>
                    <div
                        class="potential-content mt-4 prose prose-sm max-w-none prose-p:text-gray-600 prose-li:text-gray-600 prose-ul:list-disc prose-li:marker:text-green-600">
                        {!! $potential->facilities ?: '<p>Informasi fasilitas belum tersedia.</p>' !!}
                    </div>
                </section>

                <section
                    class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-green-100/70 sm:p-8"
                    data-aos="fade-up" data-aos-duration="700" data-aos-delay="140">
                    <span class="text-xs font-semibold uppercase tracking-[0.24em] text-green-700">Peluang</span>
                    <h3 class="mt-3 text-2xl font-bold text-gray-900">Peluang pengembangan ke depan</h3>
                    <div
                        class="potential-content mt-4 prose prose-sm max-w-none prose-p:text-gray-600 prose-li:text-gray-600 prose-ul:list-disc prose-li:marker:text-green-600">
                        {!! $potential->opportunities ?: '<p>Peluang pengembangan belum tersedia.</p>' !!}
                    </div>
                </section>

                <section class="rounded-[32px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60 sm:p-8"
                    data-aos="fade-up" data-aos-duration="750" data-aos-delay="180">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                        <div class="max-w-3xl">
                            <span class="text-xs font-semibold uppercase tracking-[0.24em] text-green-700">Informasi
                                Lokasi</span>
                            <h3 class="mt-3 text-2xl font-bold text-gray-900">Lokasi dan akses informasi</h3>
                            <p class="mt-4 text-sm leading-7 text-gray-600">
                                Informasi berikut membantu pengunjung mengenali lokasi potensi, titik koordinat, dan
                                kontak yang dapat dihubungi untuk kebutuhan informasi lebih lanjut.
                            </p>
                        </div>
                    </div>

                    <div class="mt-8 grid gap-4 md:grid-cols-3">
                        <div class="rounded-3xl border border-gray-200 bg-gray-50 px-5 py-5 transition duration-300 hover:-translate-y-1 hover:border-green-200 hover:bg-green-50/70"
                            data-aos="zoom-in" data-aos-delay="60" data-aos-duration="600">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gray-500">Alamat</p>
                            <p class="mt-3 text-sm leading-6 text-gray-700">
                                {{ $potential->address ?: 'Alamat potensi belum tersedia.' }}
                            </p>
                        </div>
                        <div class="rounded-3xl border border-gray-200 bg-gray-50 px-5 py-5 transition duration-300 hover:-translate-y-1 hover:border-green-200 hover:bg-green-50/70"
                            data-aos="zoom-in" data-aos-delay="120" data-aos-duration="600">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gray-500">Koordinat</p>
                            <p class="mt-3 text-sm leading-6 text-gray-700">
                                {{ $potential->latitude && $potential->longitude ? $potential->latitude . ', ' . $potential->longitude : 'Koordinat belum tersedia.' }}
                            </p>
                        </div>
                        <div class="rounded-3xl border border-gray-200 bg-gray-50 px-5 py-5 transition duration-300 hover:-translate-y-1 hover:border-green-200 hover:bg-green-50/70"
                            data-aos="zoom-in" data-aos-delay="180" data-aos-duration="600">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gray-500">Kontak</p>
                            <p class="mt-3 text-sm leading-6 text-gray-700">
                                {{ $potential->contact_person ?: 'Kontak belum tersedia.' }}
                                @if ($potential->contact_phone)
                                    <br>{{ $potential->contact_phone }}
                                @endif
                            </p>
                        </div>
                    </div>
                </section>
            </main>

            <aside class="space-y-6 lg:sticky lg:top-24 lg:self-start">
                <div class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-gray-200/80"
                    data-aos="fade-left" data-aos-duration="700" data-aos-delay="100">
                    <h2 class="text-lg font-bold text-gray-900">Informasi Potensi</h2>
                    <dl class="mt-5 space-y-5 text-sm">
                        <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-4">
                            <dt class="font-semibold text-emerald-700">Kategori</dt>
                            <dd class="mt-2 text-emerald-950">{{ $potential->category->name ?? 'Potensi Desa' }}</dd>
                        </div>
                        <div class="rounded-2xl border border-amber-100 bg-amber-50 px-4 py-4">
                            <dt class="font-semibold text-amber-700">Jenis Potensi</dt>
                            <dd class="mt-2 text-amber-950">{{ $potential->potential_type ?: '-' }}</dd>
                        </div>
                        <div class="rounded-2xl border border-sky-100 bg-sky-50 px-4 py-4">
                            <dt class="font-semibold text-sky-700">Wilayah</dt>
                            <dd class="mt-2 text-sky-950">{{ $potential->village->name ?? 'Desa Mentuda' }}</dd>
                        </div>
                        <div class="rounded-2xl border border-fuchsia-100 bg-fuchsia-50 px-4 py-4">
                            <dt class="font-semibold text-fuchsia-700">Status Pengembangan</dt>
                            <dd class="mt-2 text-fuchsia-950">{{ $potential->development_status ?: 'Belum diperbarui' }}
                            </dd>
                        </div>
                    </dl>
                </div>

                @if ($relatedPotentials->isNotEmpty())
                    <div class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-green-100/70"
                        data-aos="fade-left" data-aos-duration="700" data-aos-delay="160">
                        <h2 class="text-lg font-bold text-gray-900">Potensi Terkait</h2>

                        <div class="mt-5 space-y-4">
                            @foreach ($relatedPotentials as $relatedPotential)
                                <a href="{{ route('public.potentials.show', $relatedPotential->slug) }}"
                                    class="group flex gap-4 rounded-2xl bg-white p-3 shadow-sm ring-1 ring-gray-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:ring-green-200">
                                    <img src="{{ $relatedPotential->cover_image_url ?: asset('img/bg.jpg') }}"
                                        alt="{{ $relatedPotential->cover_image_alt ?: $relatedPotential->title }}"
                                        class="h-20 w-24 shrink-0 rounded-xl object-cover transition-transform duration-300 group-hover:scale-105">

                                    <div class="min-w-0">
                                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-green-700">
                                            {{ $relatedPotential->category->name ?? 'Potensi Desa' }}
                                        </p>
                                        <h3
                                            class="mt-1 line-clamp-2 text-sm font-bold leading-snug text-gray-900 transition-colors duration-300 group-hover:text-green-700 md:text-base">
                                            {{ $relatedPotential->title }}
                                        </h3>
                                        <p class="mt-2 line-clamp-2 text-xs leading-5 text-gray-500">
                                            {{ \Illuminate\Support\Str::limit(strip_tags($relatedPotential->excerpt ?: $relatedPotential->content), 85) }}
                                        </p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="rounded-[28px] bg-gradient-to-br from-green-700 via-green-800 to-emerald-900 p-6 text-white shadow-lg shadow-green-900/20 transition duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-green-900/30"
                    data-aos="fade-left" data-aos-duration="700" data-aos-delay="220">
                    <h2 class="text-lg font-bold">Jelajahi potensi Desa Mentuda</h2>
                    <p class="mt-3 text-sm leading-6 text-white/85">
                        Setiap potensi desa dapat dikembangkan menjadi sumber informasi publik, promosi wilayah, dan
                        penguatan ekonomi lokal secara berkelanjutan.
                    </p>
                    <a href="{{ route('public.potentials.index') }}"
                        class="mt-6 inline-flex items-center rounded-full bg-white px-4 py-2 text-sm font-semibold text-green-800 transition duration-300 hover:translate-x-1 hover:bg-emerald-50">
                        Kembali ke Daftar Potensi
                    </a>
                </div>
            </aside>
        </div>
    </section>
@endsection
