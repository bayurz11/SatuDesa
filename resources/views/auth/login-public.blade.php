@extends('layouts.app2')

@section('title', 'Daftar Akun Warga - Layanan Publik')

@section('content')
    <style>
        input[type="date"] {
            color-scheme: light;
        }

        ::placeholder {
            color: #6b7280;
            opacity: 1;
        }

        video {
            transform: none;
            -webkit-transform: none;
        }

        video.mirror {
            transform: scaleX(-1);
            -webkit-transform: scaleX(-1);
        }

        canvas {
            display: none;
        }
    </style>

    <section class="mx-auto max-w-7xl px-4 md:px-6 lg:px-8 py-10 md:py-14" data-aos="fade-up">
        {{-- Breadcrumb --}}
        <nav class="mb-6 mt-8 md:mb-8 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2">
                <li><a href="{{ route('beranda') }}" class="hover:text-green-700">Beranda</a></li>
                <li aria-hidden="true">/</li>
                <li class="text-green-700 font-medium">Daftar Akun</li>
            </ol>
        </nav>

        {{-- Heading --}}
        <header class="text-center mb-8 md:mb-12">
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-green-700">
                Registrasi Akun Warga
            </h1>
            <p class="mt-3 md:mt-4 text-gray-700 md:text-lg max-w-2xl mx-auto">
                Silakan pindai atau unggah foto KTP Anda. Sistem akan membaca data otomatis, lalu isi nomor HP dan PIN untuk
                pendaftaran akun pertama.
            </p>
        </header>

        <div x-data="scanKTP()" x-init="init()" class="grid gap-8 lg:grid-cols-3 items-start">
            {{-- FORM CARD --}}
            <article class="lg:col-span-2 space-y-6">
                <div class="rounded-2xl bg-white shadow ring-1 ring-black/5">
                    <div class="border-b border-gray-100 px-4 md:px-6 pt-4">
                        <div class="flex rounded-xl bg-gray-50 p-1 ring-1 ring-black/5 w-full max-w-md">
                            <button type="button" @click="tab='kamera'"
                                :class="tab === 'kamera' ? 'bg-white text-green-700 shadow font-semibold' :
                                    'text-gray-600 hover:text-gray-900'"
                                class="flex-1 px-4 py-2.5 text-sm font-medium rounded-lg transition text-center">
                                Pindai KTP (Kamera)
                            </button>
                            <button type="button" @click="tab='unggah'"
                                :class="tab === 'unggah' ? 'bg-white text-green-700 shadow font-semibold' :
                                    'text-gray-600 hover:text-gray-900'"
                                class="flex-1 px-4 py-2.5 text-sm font-medium rounded-lg transition text-center">
                                Unggah Foto KTP
                            </button>
                        </div>
                    </div>

                    {{-- Panel Pindai --}}
                    <div x-show="tab==='kamera'" x-cloak class="p-6 md:p-8">
                        <form method="POST" action="#" class="space-y-6" @submit="prepareSubmit" novalidate>
                            @csrf

                            {{-- Kamera --}}
                            <div class="rounded-xl overflow-hidden ring-1 ring-black/5 bg-black/5 relative aspect-video">
                                <video x-ref="video" playsinline muted
                                    class="absolute inset-0 w-full h-full object-cover rounded-xl bg-black/10"></video>
                                <img x-ref="snapshot" x-show="hasPhoto"
                                    class="absolute inset-0 h-full w-full object-cover rounded-xl" />
                                <canvas x-ref="canvas"></canvas>

                                <div class="absolute inset-x-0 bottom-0 p-2 text-center text-[11px] text-white/90 bg-gradient-to-t from-black/50 to-transparent"
                                    x-show="!hasPhoto">
                                    Posisikan KTP Anda di bingkai, hindari silau & blur
                                </div>
                            </div>

                            {{-- Tombol Kamera --}}
                            <div class="mt-3 flex flex-wrap gap-2">
                                <button type="button" @click="startCamera" :disabled="streaming"
                                    class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-3 py-2 text-sm font-medium text-white hover:bg-green-700 disabled:opacity-50 transition">
                                    <x-heroicon-o-camera class="size-4" /> Nyalakan Kamera
                                </button>

                                <button type="button" @click="capture" :disabled="!streaming"
                                    class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-3 py-2 text-sm font-medium text-white hover:bg-emerald-700 disabled:opacity-50 transition">
                                    <x-heroicon-o-photo class="size-4" /> Ambil Foto
                                </button>

                                <button type="button" @click="retake" x-show="hasPhoto"
                                    class="inline-flex items-center gap-2 rounded-lg border border-green-600 px-3 py-2 text-sm font-medium text-green-700 hover:bg-green-600 hover:text-white transition">
                                    <x-heroicon-o-arrow-path class="size-4" /> Ulangi
                                </button>
                            </div>

                            {{-- Data hasil OCR --}}
                            <p class="mt-2 text-sm text-gray-600"><span x-text="msgOCR"></span></p>

                            <div class="grid gap-4 md:grid-cols-2">
                                <div class="md:col-span-2">
                                    <label class="text-sm font-semibold text-gray-900">NIK</label>
                                    <input type="text" x-model="form.nik" maxlength="16"
                                        class="mt-1 block w-full rounded-lg bg-white px-4 py-2.5 text-[15px] text-gray-900 shadow-md focus:ring-2 focus:ring-green-300 focus:outline-none transition"
                                        placeholder="16 digit NIK" required>
                                </div>

                                <div>
                                    <label class="text-sm font-semibold text-gray-900">Tanggal Lahir</label>
                                    <input type="date" x-model="form.tanggal_lahir"
                                        class="mt-1 block w-full rounded-lg bg-white px-4 py-2.5 text-[15px] text-gray-900 shadow-md focus:ring-2 focus:ring-green-300 focus:outline-none transition"
                                        required>
                                </div>

                                <div>
                                    <label class="text-sm font-semibold text-gray-900">Nama Lengkap</label>
                                    <input type="text" x-model="form.nama"
                                        class="mt-1 block w-full rounded-lg bg-white px-4 py-2.5 text-[15px] text-gray-900 shadow-md focus:ring-2 focus:ring-green-300 focus:outline-none transition">
                                </div>

                                <div>
                                    <label class="text-sm font-semibold text-gray-900">No. HP / Email</label>
                                    <input type="text" x-model="form.kontak"
                                        class="mt-1 block w-full rounded-lg bg-white px-4 py-2.5 text-[15px] text-gray-900 shadow-md focus:ring-2 focus:ring-green-300 focus:outline-none transition"
                                        placeholder="08xxxx / email@example.com" required>
                                </div>

                                <div>
                                    <label class="text-sm font-semibold text-gray-900">PIN (6 Digit)</label>
                                    <input type="password" x-model="form.pin" maxlength="6"
                                        class="mt-1 block w-full rounded-lg bg-white px-4 py-2.5 text-[15px] text-gray-900 shadow-md focus:ring-2 focus:ring-green-300 focus:outline-none transition"
                                        placeholder="******" required>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 text-sm text-gray-700">
                                <input id="agree" type="checkbox" class="mt-1 rounded text-green-600 shadow-md"
                                    required>
                                <label for="agree">
                                    Saya menyetujui <a href="#" class="text-green-700 hover:underline">Kebijakan
                                        Privasi</a>
                                    dan <a href="#" class="text-green-700 hover:underline">Syarat & Ketentuan</a>.
                                </label>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit"
                                    class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-3 text-sm font-medium text-white hover:bg-green-700 transition">
                                    <x-heroicon-o-user-plus class="size-4" /> Daftar Akun
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </article>

            {{-- Sidebar --}}
            <aside class="space-y-6 lg:sticky lg:top-20">
                <div class="rounded-xl bg-white shadow p-5 ring-1 ring-black/5">
                    <div class="flex items-start gap-3">
                        <x-heroicon-o-shield-check class="size-6 text-green-700" />
                        <div>
                            <h3 class="font-semibold text-gray-900">Keamanan Data</h3>
                            <p class="mt-1 text-sm text-gray-600">Data dan foto KTP hanya digunakan untuk verifikasi awal.
                                Semua file akan dihapus otomatis setelah verifikasi selesai.</p>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </section>

    {{-- OCR & Kamera --}}
    <script defer src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js"></script>
    <script>
        function scanKTP() {
            return {
                tab: 'kamera',
                streaming: false,
                hasPhoto: false,
                streamRef: null,
                msgOCR: '',
                form: {
                    nik: '',
                    tanggal_lahir: '',
                    nama: '',
                    kontak: '',
                    pin: '',
                    base64: ''
                },

                init() {
                    window.addEventListener('beforeunload', () => this.stopCamera());
                },

                async startCamera() {
                    try {
                        this.stopCamera();
                        const stream = await navigator.mediaDevices.getUserMedia({
                            video: {
                                facingMode: {
                                    ideal: 'environment'
                                },
                                width: 1280,
                                height: 720
                            },
                            audio: false
                        });
                        this.$refs.video.srcObject = stream;
                        await this.$refs.video.play();
                        this.streamRef = stream;
                        this.streaming = true;
                        this.hasPhoto = false;
                    } catch {
                        alert('Tidak dapat mengakses kamera. Izinkan akses kamera.');
                    }
                },

                stopCamera() {
                    if (this.streamRef) {
                        this.streamRef.getTracks().forEach(t => t.stop());
                        this.streamRef = null;
                        this.streaming = false;
                    }
                },

                capture() {
                    if (!this.streaming) return;
                    const video = this.$refs.video;
                    const canvas = this.$refs.canvas;
                    const ctx = canvas.getContext('2d');
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    ctx.drawImage(video, 0, 0);
                    const dataUrl = canvas.toDataURL('image/jpeg', 0.85);
                    this.form.base64 = dataUrl;
                    this.$refs.snapshot.src = dataUrl;
                    this.hasPhoto = true;
                    this.stopCamera();
                    this.runOCR(dataUrl);
                },

                retake() {
                    this.hasPhoto = false;
                    this.msgOCR = '';
                    this.form.base64 = '';
                    this.startCamera();
                },

                async runOCR(dataUrl) {
                    this.msgOCR = '⏳ Membaca KTP...';
                    const {
                        data
                    } = await Tesseract.recognize(dataUrl, 'eng');
                    const text = data.text.replace(/\s+/g, ' ');

                    const nik = text.match(/(\d{16})/);
                    if (nik) this.form.nik = nik[1];
                    const ttl = text.match(/\b(0[1-9]|[12][0-9]|3[01])[\-\/.](0[1-9]|1[0-2])[\-\/.](19|20)\d{2}\b/);
                    if (ttl) {
                        const [d, m, y] = ttl[0].split(/[.\-\/]/);
                        this.form.tanggal_lahir = `${y}-${m}-${d}`;
                    }
                    const nm = text.match(/NAMA\s*[:\-]?\s*([A-Z\s]+)/i);
                    if (nm) this.form.nama = nm[1].trim();

                    this.msgOCR = '✅ Data berhasil dibaca. Silakan periksa kembali.';
                },

                prepareSubmit() {
                    if (!this.form.nik || !this.form.pin) {
                        alert('Lengkapi NIK dan PIN untuk registrasi.');
                        return false;
                    }
                    alert('Registrasi berhasil! (simulasi)');
                    return true;
                }
            }
        }
    </script>
@endsection
