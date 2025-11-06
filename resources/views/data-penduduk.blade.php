@extends('layouts.app2')

@section('title', 'Data Penduduk')

@section('content')
    <section class="mx-auto max-w-7xl px-4 md:px-6 lg:px-8 py-10 md:py-14 overflow-x-hidden" data-aos="fade-up">
        {{-- Breadcrumb --}}
        <nav class="mb-6 mt-8 md:mb-8 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2">
                <li><a href="{{ route('/') }}" class="hover:text-green-700">Beranda</a></li>
                <li aria-hidden="true">/</li>
                <li class="text-green-700 font-medium">Informasi</li>
                <li aria-hidden="true">/</li>
                <li class="text-green-700 font-medium">Data Penduduk</li>
            </ol>
        </nav>

        {{-- Heading --}}
        <header class="text-center mb-10 md:mb-12">
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-green-700">
                Data Penduduk Desa Mentuda
            </h1>
            <p class="mt-3 md:mt-4 text-gray-600 md:text-lg max-w-2xl mx-auto">
                Ringkasan jumlah dan sebaran penduduk berdasarkan jenis kelamin, kelompok umur, agama, dan pekerjaan.
            </p>
        </header>

        <div class="grid gap-8 lg:grid-cols-3 items-start">
            {{-- KONTEN UTAMA --}}
            <article class="lg:col-span-2 space-y-8">

                {{-- Kartu Data Penduduk --}}
                <div class="relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5 min-w-0">
                    <div class="p-4 md:p-5 border-b border-gray-100">
                        <div class="flex items-start gap-3">
                            <span
                                class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 ring-1 ring-green-200 shrink-0">
                                <x-heroicon-o-user-group class="size-6 text-green-700" />
                            </span>
                            <div class="min-w-0">
                                <h2 class="text-lg md:text-xl font-semibold text-gray-900">Ringkasan Demografi</h2>
                                <p class="mt-1 text-gray-700 text-sm">Data statis contoh penduduk Desa Mentuda (dummy data).
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 md:p-8">
                        {{-- KPI Ringkas --}}
                        <div class="mb-4 grid gap-3 sm:grid-cols-3 min-w-0">
                            <div class="rounded-xl bg-green-50/60 p-4 ring-1 ring-green-200">
                                <p class="text-xs text-gray-600">Total Penduduk</p>
                                <p id="kpiTotalPenduduk" class="text-xl font-semibold text-gray-900">2,485</p>
                            </div>
                            <div class="rounded-xl bg-emerald-50/60 p-4 ring-1 ring-emerald-200">
                                <p class="text-xs text-gray-600">Laki-laki</p>
                                <p id="kpiMale" class="text-xl font-semibold text-gray-900">1,280</p>
                            </div>
                            <div class="rounded-xl bg-amber-50/60 p-4 ring-1 ring-amber-200">
                                <p class="text-xs text-gray-600">Perempuan</p>
                                <p id="kpiFemale" class="text-xl font-semibold text-gray-900">1,205</p>
                            </div>
                        </div>

                        {{-- Chart: Umur & Jenis Kelamin --}}
                        <div class="grid gap-6 lg:grid-cols-2 min-w-0">
                            <div class="rounded-2xl ring-1 ring-gray-100 p-4 min-w-0">
                                <h3 class="mb-3 text-sm font-semibold text-gray-900">Penduduk per Kelompok Umur</h3>
                                <div class="relative h-[220px] sm:h-[260px]">
                                    <canvas id="ageChart" class="absolute inset-0 !w-full !h-full block"></canvas>
                                </div>
                            </div>
                            <div class="rounded-2xl ring-1 ring-gray-100 p-4 min-w-0">
                                <h3 class="mb-3 text-sm font-semibold text-gray-900">Distribusi Jenis Kelamin</h3>
                                <div class="relative h-[220px] sm:h-[260px]">
                                    <canvas id="genderChart" class="absolute inset-0 !w-full !h-full block"></canvas>
                                </div>
                            </div>
                        </div>

                        {{-- Chart: Agama & Pekerjaan --}}
                        <div class="mt-6 grid gap-6 lg:grid-cols-2 min-w-0">
                            <div class="rounded-2xl ring-1 ring-gray-100 p-4 min-w-0">
                                <h3 class="mb-3 text-sm font-semibold text-gray-900">Distribusi Agama</h3>
                                <div class="relative h-[220px] sm:h-[260px]">
                                    <canvas id="religionChart" class="absolute inset-0 !w-full !h-full block"></canvas>
                                </div>
                            </div>
                            <div class="rounded-2xl ring-1 ring-gray-100 p-4 min-w-0">
                                <h3 class="mb-3 text-sm font-semibold text-gray-900">Distribusi Pekerjaan</h3>
                                <div class="relative h-[220px] sm:h-[260px]">
                                    <canvas id="jobChart" class="absolute inset-0 !w-full !h-full block"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 rounded-xl bg-gray-50 p-4 ring-1 ring-gray-200 text-xs text-gray-600">
                            Sumber: Data simulasi — bukan data resmi (contoh tampilan chart).
                        </div>
                    </div>
                </div>

            </article>

            {{-- SIDEBAR --}}
            <aside class="space-y-6 lg:sticky lg:top-20 min-w-0">
                <div class="bg-white rounded-xl shadow p-4">
                    <h3 class="font-semibold text-gray-900 mb-3">Informasi</h3>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-center gap-2"><x-heroicon-o-envelope class="size-4 text-green-700" />
                            desa@desamentuda.id</li>
                        <li class="flex items-center gap-2"><x-heroicon-o-phone class="size-4 text-green-700" /> +62 812
                            3456 7890</li>
                        <li class="flex items-center gap-2"><x-heroicon-o-map-pin class="size-4 text-green-700" /> Balai
                            Desa Mentuda</li>
                    </ul>
                </div>
                <div class="bg-white rounded-xl shadow p-4">
                    <h3 class="font-semibold text-gray-900 mb-3">Tautan Terkait</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('struktur-desa') }}"
                                class="inline-flex items-center gap-2 text-green-700 hover:text-green-800">
                                <x-heroicon-o-user-group class="size-4" /> Struktur Organisasi</a></li>
                        <li><a href="{{ route('pengumuman') }}"
                                class="inline-flex items-center gap-2 text-green-700 hover:text-green-800">
                                <x-heroicon-o-calendar class="size-4" /> Agenda Desa</a></li>
                        <li><a href="{{ route('berita') }}"
                                class="inline-flex items-center gap-2 text-green-700 hover:text-green-800">
                                <x-heroicon-o-newspaper class="size-4" /> Berita Desa</a></li>
                    </ul>
                </div>
                <div class="bg-white rounded-xl shadow p-4">
                    <h4 class="font-semibold text-gray-900 mb-3">Berita Terbaru</h4>
                    <div class="space-y-3">
                        {{-- Item 1 --}}
                        <a href="#" class="flex items-center gap-3 rounded-lg p-2 hover:bg-gray-50 transition">
                            <img src="{{ asset('public/img/potensi1.jpg') }}" alt="Thumb berita"
                                class="h-16 w-20 rounded-md object-cover ring-1 ring-black/5" loading="lazy"
                                decoding="async">
                            <div class="min-w-0">
                                <h5 class="text-sm font-medium text-gray-900 line-clamp-2 hover:text-green-700">
                                    Pembangunan Balai Desa Mentuda Resmi Dimulai
                                </h5>
                                <div class="mt-1 flex items-center gap-3 text-xs text-gray-500">
                                    <span class="inline-flex items-center gap-1"><x-heroicon-o-tag class="size-4" />
                                        Berita</span>
                                    <time class="inline-flex items-center gap-1"><x-heroicon-o-clock class="size-4" />
                                        12-12-2024</time>
                                </div>
                            </div>
                        </a>
                        {{-- Item 2 --}}
                        <a href="#" class="flex items-center gap-3 rounded-lg p-2 hover:bg-gray-50 transition">
                            <img src="{{ asset('public/img/potensi2.jpg') }}" alt="Thumb berita"
                                class="h-16 w-20 rounded-md object-cover ring-1 ring-black/5" loading="lazy"
                                decoding="async">
                            <div class="min-w-0">
                                <h5 class="text-sm font-medium text-gray-900 line-clamp-2 hover:text-green-700">
                                    Tradisi Adat Tetap Dilestarikan di Era Modern
                                </h5>
                                <div class="mt-1 flex items-center gap-3 text-xs text-gray-500">
                                    <span class="inline-flex items-center gap-1"><x-heroicon-o-tag class="size-4" />
                                        Budaya</span>
                                    <time class="inline-flex items-center gap-1"><x-heroicon-o-clock class="size-4" />
                                        12-12-2024</time>
                                </div>
                            </div>
                        </a>
                        {{-- Item 3 --}}
                        <a href="#" class="flex items-center gap-3 rounded-lg p-2 hover:bg-gray-50 transition">
                            <img src="{{ asset('public/img/potensi1.jpg') }}" alt="Thumb berita"
                                class="h-16 w-20 rounded-md object-cover ring-1 ring-black/5" loading="lazy"
                                decoding="async">
                            <div class="min-w-0">
                                <h5 class="text-sm font-medium text-gray-900 line-clamp-2 hover:text-green-700">
                                    Pelatihan UMKM Dorong Perekonomian Lokal
                                </h5>
                                <div class="mt-1 flex items-center gap-3 text-xs text-gray-500">
                                    <span class="inline-flex items-center gap-1"><x-heroicon-o-tag class="size-4" />
                                        UMKM</span>
                                    <time class="inline-flex items-center gap-1"><x-heroicon-o-clock class="size-4" />
                                        12-12-2024</time>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const total = 2485;
            const male = 1280;
            const female = 1205;

            // ===== Chart: Umur =====
            new Chart(document.getElementById('ageChart'), {
                type: 'bar',
                data: {
                    labels: ['0–5', '6–12', '13–18', '19–30', '31–45', '46–60', '61+'],
                    datasets: [{
                        label: 'Jumlah Penduduk',
                        data: [230, 340, 290, 460, 560, 360, 245],
                        backgroundColor: '#16a34a80',
                        borderColor: '#16a34a',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: v => v.toLocaleString('id-ID')
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            // ===== Chart: Gender =====
            new Chart(document.getElementById('genderChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Laki-laki', 'Perempuan'],
                    datasets: [{
                        data: [male, female],
                        backgroundColor: ['#22c55e', '#f59e0b'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '60%',
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: ctx => {
                                    const val = ctx.parsed;
                                    const pct = (val / total * 100).toFixed(1);
                                    return `${ctx.label}: ${val.toLocaleString('id-ID')} jiwa (${pct}%)`;
                                }
                            }
                        }
                    }
                }
            });

            // ===== Chart: Agama =====
            const religion = {
                labels: ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya'],
                data: [2200, 120, 80, 30, 25, 10, 20]
            };
            new Chart(document.getElementById('religionChart'), {
                type: 'doughnut',
                data: {
                    labels: religion.labels,
                    datasets: [{
                        data: religion.data,
                        backgroundColor: ['#22c55e', '#3b82f6', '#eab308', '#f97316', '#ef4444',
                            '#a855f7', '#9ca3af'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '55%',
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: ctx => {
                                    const totalRel = religion.data.reduce((a, b) => a + b, 0);
                                    const val = ctx.parsed;
                                    const pct = (val / totalRel * 100).toFixed(1);
                                    return `${ctx.label}: ${val.toLocaleString('id-ID')} (${pct}%)`;
                                }
                            }
                        }
                    }
                }
            });

            // ===== Chart: Pekerjaan =====
            const jobs = {
                labels: ['Petani', 'Nelayan', 'Pedagang', 'PNS/Guru/Nakes', 'Karyawan Swasta', 'Wirausaha',
                    'Pelajar/Mahasiswa', 'IRT', 'Lainnya'
                ],
                data: [520, 430, 210, 95, 180, 140, 360, 300, 250]
            };
            new Chart(document.getElementById('jobChart'), {
                type: 'bar',
                data: {
                    labels: jobs.labels,
                    datasets: [{
                        label: 'Jumlah',
                        data: jobs.data,
                        backgroundColor: '#16a34a80',
                        borderColor: '#16a34a',
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                callback: v => v.toLocaleString('id-ID')
                            }
                        },
                        y: {
                            ticks: {
                                autoSkip: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>
@endpush
