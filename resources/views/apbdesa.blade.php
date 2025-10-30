@extends('layouts.app2')

@section('title', 'APBDes Desa ')

@section('content')
    <section class="mx-auto max-w-7xl px-4 md:px-6 lg:px-8 py-10 md:py-14" data-aos="fade-up">
        {{-- Breadcrumb --}}
        <nav class="mb-6 mt-6 md:mb-8 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2">
                <li><a href="{{ route('/') }}" class="hover:text-green-700">Beranda</a></li>
                <li aria-hidden="true">/</li>
                <li class="text-green-700 font-medium">APBDes</li>
            </ol>
        </nav>

        {{-- Heading --}}
        <header class="text-center mb-10 md:mb-12">
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-green-700">
                APBDes Desa Mentuda
            </h1>
            <p class="mt-3 md:mt-4 text-gray-600 md:text-lg max-w-3xl mx-auto">
                Ringkasan Anggaran Pendapatan dan Belanja Desa (APBDes) per tahun anggaran berikut, dilengkapi grafik
                serapan dan rincian akun.
            </p>
        </header>

        <div class="grid gap-8 lg:grid-cols-3 items-start">
            {{-- KONTEN UTAMA --}}
            <article class="lg:col-span-2 space-y-6">

                {{-- Kartu kontrol tahun + KPI --}}
                <div class="relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5">
                    <div
                        class="p-4 md:p-5 border-b border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                        <div class="flex items-start gap-3">
                            <span
                                class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 ring-1 ring-green-200 shrink-0">
                                <x-heroicon-o-banknotes class="size-6 text-green-700" />
                            </span>
                            <div>
                                <h2 class="text-lg md:text-xl font-semibold text-gray-900">Ringkasan APBDes</h2>
                                <p class="mt-1 text-gray-700 text-sm">Data dummy (statis) untuk contoh tampilan.</p>
                            </div>
                        </div>

                        {{-- Pilihan Tahun --}}
                        <div class="flex items-center gap-2">
                            <label for="tahunSelect" class="text-sm text-gray-600">Tahun:</label>
                            <select id="tahunSelect"
                                class="rounded-lg border-gray-300 text-sm focus:ring-green-600 focus:border-green-600">
                                <option value="2025" selected>2025</option>
                                <option value="2024">2024</option>
                            </select>
                        </div>
                    </div>

                    <div class="p-4 md:p-6">
                        {{-- KPI --}}
                        <div class="mb-4 grid gap-3 sm:grid-cols-4">
                            <div class="rounded-xl bg-green-50/60 p-4 ring-1 ring-green-200">
                                <p class="text-xs text-gray-600">Total APBDes</p>
                                <p id="kpiTotal" class="text-lg md:text-xl font-semibold text-gray-900">Rp -</p>
                            </div>
                            <div class="rounded-xl bg-emerald-50/60 p-4 ring-1 ring-emerald-200">
                                <p class="text-xs text-gray-600">Pendapatan</p>
                                <p id="kpiPendapatan" class="text-lg md:text-xl font-semibold text-gray-900">Rp -</p>
                            </div>
                            <div class="rounded-xl bg-amber-50/60 p-4 ring-1 ring-amber-200">
                                <p class="text-xs text-gray-600">Belanja</p>
                                <p id="kpiBelanja" class="text-lg md:text-xl font-semibold text-gray-900">Rp -</p>
                            </div>
                            <div class="rounded-xl bg-blue-50/60 p-4 ring-1 ring-blue-200">
                                <p class="text-xs text-gray-600">Serapan Belanja</p>
                                <p class="text-lg md:text-xl font-semibold text-gray-900"><span id="kpiSerap">-</span>%</p>
                            </div>
                        </div>

                        {{-- Progress Serapan --}}
                        <div class="mb-6">
                            <div class="flex justify-between text-xs text-gray-600 mb-1">
                                <span>Realisasi Belanja</span>
                                <span><span id="serapNow">-</span>%</span>
                            </div>
                            <div class="h-3 w-full bg-gray-100 rounded-full overflow-hidden ring-1 ring-gray-200">
                                <div id="serapBar" class="h-full bg-green-600 rounded-full transition-all duration-500"
                                    style="width:0%"></div>
                            </div>
                        </div>

                        {{-- Grafis: Pendapatan vs Belanja --}}
                        <div class="grid gap-6 lg:grid-cols-2">
                            <div class="rounded-2xl ring-1 ring-gray-100 p-4">
                                <h3 class="mb-3 text-sm font-semibold text-gray-900">Pendapatan per Sumber</h3>
                                <div class="h-[260px]"><canvas id="incomeChart"></canvas></div>
                            </div>
                            <div class="rounded-2xl ring-1 ring-gray-100 p-4">
                                <h3 class="mb-3 text-sm font-semibold text-gray-900">Belanja per Bidang</h3>
                                <div class="h-[260px]"><canvas id="spendChart"></canvas></div>
                            </div>
                        </div>

                        {{-- Grafis: Realisasi per Bulan --}}
                        <div class="mt-6 rounded-2xl ring-1 ring-gray-100 p-4">
                            <h3 class="mb-3 text-sm font-semibold text-gray-900">Realisasi Bulanan (Belanja)</h3>
                            <div class="h-[260px]"><canvas id="monthlyChart"></canvas></div>
                            <p class="mt-2 text-xs text-gray-500">*Realisasi bulanan adalah dummy untuk contoh visualisasi.
                            </p>
                        </div>

                        {{-- Tabel Rincian Akun (ringkas) --}}
                        <div class="mt-6 rounded-2xl ring-1 ring-gray-100 p-4">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-sm font-semibold text-gray-900">Rincian Anggaran (Top 8)</h3>
                                <div class="flex items-center gap-2">
                                    <a href="#"
                                        class="text-sm text-green-700 hover:text-green-800 underline underline-offset-2">Unduh
                                        Excel</a>
                                    <span class="text-gray-300">|</span>
                                    <a href="#"
                                        class="text-sm text-green-700 hover:text-green-800 underline underline-offset-2">Unduh
                                        PDF</a>
                                </div>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm">
                                    <thead>
                                        <tr class="text-left text-gray-600 border-b">
                                            <th class="py-2 pr-4">Kode</th>
                                            <th class="py-2 pr-4">Uraian</th>
                                            <th class="py-2 pr-4">Anggaran</th>
                                            <th class="py-2 pr-4">Realisasi</th>
                                            <th class="py-2 pr-4">% Serap</th>
                                        </tr>
                                    </thead>
                                    <tbody id="rincianBody" class="align-top">
                                        {{-- diisi via JS --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

            </article>

            {{-- SIDEBAR --}}
            <aside class="space-y-6 lg:sticky lg:top-20">
                <div class="bg-white rounded-xl shadow p-4">
                    <h3 class="font-semibold text-gray-900 mb-3">Informasi</h3>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-center gap-2"><x-heroicon-o-envelope class="size-4 text-green-700" />
                            desa@desamentuda.id</li>
                        <li class="flex items-center gap-2"><x-heroicon-o-phone class="size-4 text-green-700" /> +62 812
                            3456 7890</li>
                        <li class="flex items-center gap-2"><x-heroicon-o-document-text class="size-4 text-green-700" />
                            Perdes APBDes 2025</li>
                    </ul>
                </div>

                <div class="bg-white rounded-xl shadow p-4">
                    <h3 class="font-semibold text-gray-900 mb-3">Catatan</h3>
                    <p class="text-sm text-gray-700">
                        Data pada halaman ini bersifat simulasi (contoh). Untuk data resmi, gunakan dokumen Perdes dan
                        Laporan Realisasi APBDes.
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow p-4">
                    <a href="{{ route('/') }}"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 transition">
                        <x-heroicon-o-arrow-left class="size-4" /> Kembali ke Beranda
                    </a>
                </div>
            </aside>
        </div>
    </section>
@endsection

@push('scripts')
    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // ===== Dummy Data per Tahun =====
            const DATA = {
                2025: {
                    pendapatan: {
                        PAD: 150_000_000,
                        DanaDesa: 1_000_000_000,
                        AlokasiDanaDesa: 600_000_000,
                        BagiHasilPajakRetribusi: 120_000_000,
                        BantuanProvinsi: 200_000_000,
                        BantuanKabupaten: 100_000_000,
                    },
                    belanja: {
                        PenyelenggaraanPemerintahan: 500_000_000,
                        PembangunanDesa: 900_000_000,
                        PembinaanKemasyarakatan: 120_000_000,
                        PemberdayaanMasyarakat: 180_000_000,
                        PenanggulanganBencana: 70_000_000,
                    },
                    realisasiBelanjaBulanan: [60, 80, 95, 110, 130, 150, 170, 190, 205, 230, 255, 280], // jt
                    rincian: [{
                            kode: '1.1',
                            uraian: 'PAD - Hasil Usaha Desa',
                            anggaran: 100_000_000,
                            real: 65_000_000
                        },
                        {
                            kode: '1.2',
                            uraian: 'PAD - Lain-lain Pendapatan',
                            anggaran: 50_000_000,
                            real: 30_000_000
                        },
                        {
                            kode: '2.1',
                            uraian: 'Dana Desa - Reguler',
                            anggaran: 900_000_000,
                            real: 720_000_000
                        },
                        {
                            kode: '2.2',
                            uraian: 'Dana Desa - BLT',
                            anggaran: 100_000_000,
                            real: 95_000_000
                        },
                        {
                            kode: '3.1',
                            uraian: 'ADD - Operasional',
                            anggaran: 400_000_000,
                            real: 320_000_000
                        },
                        {
                            kode: '3.2',
                            uraian: 'ADD - Tunjangan',
                            anggaran: 200_000_000,
                            real: 150_000_000
                        },
                        {
                            kode: '4.1',
                            uraian: 'Belanja Pembangunan Jalan',
                            anggaran: 450_000_000,
                            real: 360_000_000
                        },
                        {
                            kode: '4.2',
                            uraian: 'Belanja Sarpras Pendidikan',
                            anggaran: 200_000_000,
                            real: 140_000_000
                        },
                    ]
                },
                2024: {
                    pendapatan: {
                        PAD: 120_000_000,
                        DanaDesa: 950_000_000,
                        AlokasiDanaDesa: 580_000_000,
                        BagiHasilPajakRetribusi: 100_000_000,
                        BantuanProvinsi: 150_000_000,
                        BantuanKabupaten: 80_000_000,
                    },
                    belanja: {
                        PenyelenggaraanPemerintahan: 480_000_000,
                        PembangunanDesa: 820_000_000,
                        PembinaanKemasyarakatan: 110_000_000,
                        PemberdayaanMasyarakat: 160_000_000,
                        PenanggulanganBencana: 60_000_000,
                    },
                    realisasiBelanjaBulanan: [50, 70, 85, 95, 115, 130, 150, 165, 180, 195, 210, 225],
                    rincian: [{
                            kode: '1.1',
                            uraian: 'PAD - Hasil Usaha Desa',
                            anggaran: 90_000_000,
                            real: 60_000_000
                        },
                        {
                            kode: '1.2',
                            uraian: 'PAD - Lain-lain Pendapatan',
                            anggaran: 30_000_000,
                            real: 20_000_000
                        },
                        {
                            kode: '2.1',
                            uraian: 'Dana Desa - Reguler',
                            anggaran: 850_000_000,
                            real: 700_000_000
                        },
                        {
                            kode: '2.2',
                            uraian: 'Dana Desa - BLT',
                            anggaran: 100_000_000,
                            real: 95_000_000
                        },
                        {
                            kode: '3.1',
                            uraian: 'ADD - Operasional',
                            anggaran: 380_000_000,
                            real: 300_000_000
                        },
                        {
                            kode: '3.2',
                            uraian: 'ADD - Tunjangan',
                            anggaran: 200_000_000,
                            real: 150_000_000
                        },
                        {
                            kode: '4.1',
                            uraian: 'Belanja Pembangunan Jalan',
                            anggaran: 400_000_000,
                            real: 320_000_000
                        },
                        {
                            kode: '4.2',
                            uraian: 'Belanja Sarpras Pendidikan',
                            anggaran: 180_000_000,
                            real: 120_000_000
                        },
                    ]
                }
            };

            // ===== Helpers =====
            const fmtIDR = v => new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(v);
            const sum = obj => Object.values(obj).reduce((a, b) => a + b, 0);

            // ===== DOM refs =====
            const tahunSelect = document.getElementById('tahunSelect');
            const kpiTotal = document.getElementById('kpiTotal');
            const kpiPendapatan = document.getElementById('kpiPendapatan');
            const kpiBelanja = document.getElementById('kpiBelanja');
            const kpiSerap = document.getElementById('kpiSerap');
            const serapBar = document.getElementById('serapBar');
            const serapNow = document.getElementById('serapNow');
            const rincianBody = document.getElementById('rincianBody');

            // ===== Charts =====
            let incomeChart, spendChart, monthlyChart;

            function render(year) {
                const d = DATA[year];

                const pendapatanTotal = sum(d.pendapatan);
                const belanjaTotal = sum(d.belanja);

                // KPI
                kpiTotal.textContent = fmtIDR(pendapatanTotal); // asumsi berimbang
                kpiPendapatan.textContent = fmtIDR(pendapatanTotal);
                kpiBelanja.textContent = fmtIDR(belanjaTotal);

                // Serapan (pakai rata-rata 12 bulan / estimasi)
                const realNow = d.realisasiBelanjaBulanan.at(-1) * 1_000_000; // jadi rupiah
                const serapPct = Math.min(100, Math.round((realNow / belanjaTotal) * 100));
                kpiSerap.textContent = serapPct;
                serapNow.textContent = serapPct;
                serapBar.style.width = serapPct + '%';

                // Charts data
                const incomeData = {
                    labels: Object.keys(d.pendapatan),
                    datasets: [{
                        data: Object.values(d.pendapatan),
                        borderWidth: 1
                    }]
                };

                const spendData = {
                    labels: Object.keys(d.belanja),
                    datasets: [{
                        data: Object.values(d.belanja),
                        borderWidth: 1
                    }]
                };

                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                const monthlyData = {
                    labels: months,
                    datasets: [{
                        type: 'bar',
                        label: 'Realisasi (juta)',
                        data: d.realisasiBelanjaBulanan,
                        borderWidth: 1
                    }]
                };

                // Render/Update Doughnut Pendapatan
                if (incomeChart) incomeChart.destroy();
                incomeChart = new Chart(document.getElementById('incomeChart'), {
                    type: 'doughnut',
                    data: incomeData,
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
                                    label: ctx => ` ${ctx.label}: ${fmtIDR(ctx.parsed)} `
                                }
                            }
                        }
                    }
                });

                // Render/Update Doughnut Belanja
                if (spendChart) spendChart.destroy();
                spendChart = new Chart(document.getElementById('spendChart'), {
                    type: 'doughnut',
                    data: spendData,
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
                                    label: ctx => ` ${ctx.label}: ${fmtIDR(ctx.parsed)} `
                                }
                            }
                        }
                    }
                });

                // Render/Update Bar Bulanan
                if (monthlyChart) monthlyChart.destroy();
                monthlyChart = new Chart(document.getElementById('monthlyChart'), {
                    type: 'bar',
                    data: monthlyData,
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

                // Tabel rincian
                rincianBody.innerHTML = '';
                d.rincian.forEach(r => {
                    const pct = r.anggaran ? Math.round(r.real / r.anggaran * 100) : 0;
                    rincianBody.insertAdjacentHTML('beforeend', `
        <tr class="border-b last:border-0">
          <td class="py-2 pr-4 text-gray-700">${r.kode}</td>
          <td class="py-2 pr-4 text-gray-900">${r.uraian}</td>
          <td class="py-2 pr-4 text-gray-900 font-medium">${fmtIDR(r.anggaran)}</td>
          <td class="py-2 pr-4 text-gray-900">${fmtIDR(r.real)}</td>
          <td class="py-2 pr-4">
            <div class="flex items-center gap-2">
              <span class="text-gray-800 font-medium">${pct}%</span>
              <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-green-600" style="width:${pct}%"></div>
              </div>
            </div>
          </td>
        </tr>
      `);
                });
            }

            // Init
            render(tahunSelect.value);
            tahunSelect.addEventListener('change', e => render(e.target.value));
        });
    </script>
@endpush
