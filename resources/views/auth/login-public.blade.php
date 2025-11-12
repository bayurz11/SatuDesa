@extends('layouts.app2')

@section('title', 'Masuk Layanan Publik')

@section('content')
    <style>
        input[type="date"] {
            color-scheme: light;
        }

        ::placeholder {
            color: #6b7280;
            opacity: 1;
        }

        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

        video {
            -webkit-transform: scaleX(-1);
            transform: scaleX(-1);
        }

        /* mirror camera for better UX */
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
                <li class="text-green-700 font-medium">Masuk</li>
                <li aria-hidden="true">/</li>
                <li class="text-green-700 font-medium">Pindai KTP</li>
            </ol>
        </nav>

        {{-- Heading --}}
        <header class="text-center mb-8 md:mb-12">
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-green-700">
                Verifikasi Warga dengan Pindai KTP
            </h1>
            <p class="mt-3 md:mt-4 text-gray-700 md:text-lg max-w-2xl mx-auto">
                Pilih metode <span class="font-semibold">Pindai KTP (kamera)</span> atau <span class="font-semibold">Unggah
                    Foto KTP</span>.
                Data akan dibaca (OCR) untuk mencocokkan <span class="font-semibold">NIK & Tanggal Lahir</span> sebelum
                masuk layanan publik.
            </p>
        </header>

        <div x-data="scanKTP()" x-init="init()" class="grid gap-8 lg:grid-cols-3 items-start">
            {{-- FORM CARD --}}
            <article class="lg:col-span-2 space-y-6">
                @if ($errors->any())
                    <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-red-800">
                        <div class="font-semibold mb-1">Ada kesalahan pada input Anda</div>
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="rounded-2xl bg-white shadow ring-1 ring-black/5">
                    {{-- Tabs --}}
                    <div class="border-b border-gray-100 px-4 md:px-6 pt-4">
                        <div class="flex rounded-xl bg-gray-50 p-1 ring-1 ring-black/5 w-full max-w-md">
                            {{-- Tab: Kamera --}}
                            <button type="button" @click="tab='kamera'"
                                :class="tab === 'kamera' ? 'bg-white text-green-700 shadow font-semibold' :
                                    'text-gray-600 hover:text-gray-900'"
                                class="flex-1 px-4 py-2.5 text-sm font-medium rounded-lg transition text-center">
                                Pindai KTP (Kamera)
                            </button>
                            {{-- Tab: Unggah --}}
                            <button type="button" @click="tab='unggah'"
                                :class="tab === 'unggah' ? 'bg-white text-green-700 shadow font-semibold' :
                                    'text-gray-600 hover:text-gray-900'"
                                class="flex-1 px-4 py-2.5 text-sm font-medium rounded-lg transition text-center">
                                Unggah Foto KTP
                            </button>
                        </div>
                    </div>

                    {{-- Panel: Pindai KTP (Kamera) --}}
                    <div x-show="tab==='kamera'" x-cloak class="p-6 md:p-8">
                        <form method="POST" action="#" class="space-y-6" @submit="prepareSubmit" novalidate>
                            @csrf

                            <div class="grid gap-4 md:grid-cols-2">
                                {{-- Kamera preview --}}
                                <div class="rounded-xl overflow-hidden ring-1 ring-black/5 bg-black/5">
                                    <div class="aspect-video bg-black/5 relative">
                                        <video x-ref="video" autoplay playsinline muted
                                            class="absolute inset-0 h-full w-full object-cover rounded-xl bg-black/10"></video>
                                        <img x-ref="snapshot" x-show="hasPhoto"
                                            class="absolute inset-0 h-full w-full object-cover rounded-xl" />
                                        <canvas x-ref="canvas"></canvas>
                                        <div class="absolute inset-x-0 bottom-0 p-2 text-center text-[11px] text-white/90 bg-gradient-to-t from-black/50 to-transparent"
                                            x-show="!hasPhoto">
                                            Posisikan KTP pada bingkai, hindari silau & blur
                                        </div>
                                    </div>

                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <button type="button" @click="startCamera"
                                            class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-3 py-2 text-sm font-medium text-white hover:bg-green-700 transition">
                                            <x-heroicon-o-camera class="size-4" /> Nyalakan Kamera
                                        </button>

                                        <button type="button" @click="capture" :disabled="!streaming"
                                            class="inline-flex items-center gap-2 rounded-lg bg-emerald-600/90 px-3 py-2 text-sm font-medium text-white hover:bg-emerald-700 disabled:opacity-50 transition">
                                            <x-heroicon-o-photo class="size-4" /> Ambil Foto
                                        </button>

                                        {{-- TOMBOL MATIKAN KAMERA --}}
                                        <button type="button" @click="stopCamera" :disabled="!streaming"
                                            class="inline-flex items-center gap-2 rounded-lg border border-red-600 px-3 py-2 text-sm font-medium text-red-700 hover:bg-red-600 hover:text-white disabled:opacity-50 transition">
                                            <x-heroicon-o-power class="size-4" /> Matikan Kamera
                                        </button>

                                        <button type="button" @click="retake" x-show="hasPhoto"
                                            class="inline-flex items-center gap-2 rounded-lg border border-green-600 px-3 py-2 text-sm font-medium text-green-700 hover:bg-green-600 hover:text-white transition">
                                            <x-heroicon-o-arrow-path class="size-4" /> Ulangi
                                        </button>
                                    </div>

                                    {{-- Status OCR kamera --}}
                                    <p class="mt-2 text-sm" :class="loadingOCR ? 'text-gray-600' : 'text-gray-500'">
                                        <span x-show="loadingOCR">⏳ <span x-text="msgOCR || 'Membaca KTP…'"></span></span>
                                        <span x-show="!loadingOCR && msgOCR" x-text="msgOCR"></span>
                                    </p>

                                    <p class="mt-2 text-xs text-gray-500">Tips: gunakan kamera belakang (facingMode:
                                        environment), pencahayaan cukup, dan luruskan kartu.</p>
                                </div>

                                {{-- Data yang dicocokkan --}}
                                <div class="space-y-4">
                                    <div>
                                        <label for="nik_kamera" class="block text-sm font-semibold text-gray-900">
                                            NIK <span class="text-red-600">*</span></label>
                                        <input type="text" id="nik_kamera" name="nik" x-model="form.nik"
                                            inputmode="numeric" pattern="[0-9]*" maxlength="16"
                                            class="mt-1 block w-full rounded-lg border border-transparent bg-white px-4 py-2.5 text-[15px] text-gray-900
                                                   placeholder:text-gray-500 shadow-md focus:border-green-500 focus:ring-2 focus:ring-green-300 focus:outline-none transition"
                                            placeholder="16 digit NIK" required>
                                    </div>
                                    <div>
                                        <label for="dob_kamera" class="block text-sm font-semibold text-gray-900">
                                            Tanggal Lahir <span class="text-red-600">*</span></label>
                                        <div class="relative mt-1">
                                            <span
                                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                                <x-heroicon-o-calendar class="size-4 text-gray-500" />
                                            </span>
                                            <input type="date" id="dob_kamera" name="tanggal_lahir"
                                                x-model="form.tanggal_lahir"
                                                class="block w-full rounded-lg border border-transparent bg-white pl-10 pr-3 py-2.5 text-[15px] text-gray-900
                                                       shadow-md focus:border-green-500 focus:ring-2 focus:ring-green-300 focus:outline-none transition"
                                                required>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="nama_kamera" class="block text-sm font-semibold text-gray-900">Nama
                                            Lengkap</label>
                                        <input type="text" id="nama_kamera" name="nama" x-model="form.nama"
                                            class="mt-1 block w-full rounded-lg border border-transparent bg-white px-4 py-2.5 text-[15px] text-gray-900
                                                   shadow-md focus:border-green-500 focus:ring-2 focus:ring-green-300 focus:outline-none transition"
                                            placeholder="(opsional) akan dicocokkan jika tersedia">
                                    </div>
                                    {{-- Base64 hasil capture --}}
                                    <input type="hidden" name="ktp_base64" x-model="form.base64">
                                </div>
                            </div>

                            {{-- Persetujuan --}}
                            <div class="flex items-start gap-3 text-sm text-gray-700">
                                <input id="agree_camera" name="agree" type="checkbox"
                                    class="mt-1 rounded border border-transparent bg-white text-green-600 shadow-md
                                           focus:ring-green-500 focus:ring-2 focus:outline-none"
                                    required>
                                <label for="agree_camera">
                                    Saya menyetujui <a href="#" class="text-green-700 hover:underline">Kebijakan
                                        Privasi</a> dan
                                    <a href="#" class="text-green-700 hover:underline">Syarat & Ketentuan</a>.
                                </label>
                            </div>

                            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-4">
                                <button type="submit"
                                    class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg bg-green-600 px-4 py-3 text-sm font-medium text-white hover:bg-green-700 transition"
                                    :disabled="!hasPhoto && !form.nik">
                                    <x-heroicon-o-finger-print class="size-4" /> Kirim & Verifikasi
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Panel: Unggah Foto KTP --}}
                    <div x-show="tab==='unggah'" x-cloak class="p-6 md:p-8">

                        <form method="POST" action="#" class="space-y-6" enctype="multipart/form-data" novalidate>
                            @csrf

                            <div class="grid gap-6 md:grid-cols-2">
                                <div>
                                    <label for="file_ktp" class="block text-sm font-semibold text-gray-900">
                                        Unggah Foto KTP <span class="text-red-600">*</span>
                                    </label>
                                    <input id="file_ktp" name="ktp_file" type="file"
                                        accept="image/*,application/pdf" @change="onFileChange"
                                        class="mt-1 block w-full rounded-lg border border-transparent bg-white px-4 py-2 text-[15px]
                                               shadow-md focus:border-green-500 focus:ring-2 focus:ring-green-300 focus:outline-none transition"
                                        capture="environment" required>
                                    <p class="mt-1 text-xs text-gray-500">jpg/png/pdf, maks. 4MB. Pastikan teks jelas &
                                        tidak blur.</p>
                                </div>

                                <div
                                    class="rounded-xl overflow-hidden ring-1 ring-black/5 min-h-48 bg-gray-50 flex items-center justify-center">
                                    <img x-ref="uploadPreview" alt="Pratinjau KTP" class="max-h-60 object-contain"
                                        style="display:none;">
                                    <p class="text-xs text-gray-500" x-show="!uploadHasPreview">Pratinjau akan tampil di
                                        sini</p>
                                </div>
                            </div>

                            {{-- Status OCR unggah --}}
                            <p class="mt-2 text-sm" :class="loadingOCR ? 'text-gray-600' : 'text-gray-500'">
                                <span x-show="loadingOCR">⏳ <span x-text="msgOCR || 'Membaca KTP…'"></span></span>
                                <span x-show="!loadingOCR && msgOCR" x-text="msgOCR"></span>
                            </p>

                            <div class="grid gap-4 md:grid-cols-3">
                                <div class="md:col-span-2">
                                    <label for="nik_upload" class="block text-sm font-semibold text-gray-900">
                                        NIK <span class="text-red-600">*</span></label>
                                    <input type="text" id="nik_upload" name="nik"
                                        class="mt-1 block w-full rounded-lg border border-transparent bg-white px-4 py-2.5 text-[15px] text-gray-900
                                                  placeholder:text-gray-500 shadow-md focus:border-green-500 focus:ring-2 focus:ring-green-300 focus:outline-none transition"
                                        placeholder="16 digit NIK" required>
                                </div>
                                <div>
                                    <label for="dob_upload" class="block text-sm font-semibold text-gray-900">
                                        Tanggal Lahir <span class="text-red-600">*</span></label>
                                    <input type="date" id="dob_upload" name="tanggal_lahir"
                                        class="mt-1 block w-full rounded-lg border border-transparent bg-white px-4 py-2.5 text-[15px] text-gray-900
                                                  shadow-md focus:border-green-500 focus:ring-2 focus:ring-green-300 focus:outline-none transition"
                                        required>
                                </div>
                                <div class="md:col-span-3">
                                    <label for="nama_upload" class="block text-sm font-semibold text-gray-900">Nama
                                        Lengkap</label>
                                    <input type="text" id="nama_upload" name="nama"
                                        class="mt-1 block w-full rounded-lg border border-transparent bg-white px-4 py-2.5 text-[15px] text-gray-900
                                                  shadow-md focus:border-green-500 focus:ring-2 focus:ring-green-300 focus:outline-none transition"
                                        placeholder="(opsional)">
                                </div>
                            </div>

                            <div class="flex items-start gap-3 text-sm text-gray-700">
                                <input id="agree_upload" name="agree" type="checkbox"
                                    class="mt-1 rounded border border-transparent bg-white text-green-600 shadow-md
                                           focus:ring-green-500 focus:ring-2 focus:outline-none"
                                    required>
                                <label for="agree_upload">
                                    Saya menyetujui <a href="#" class="text-green-700 hover:underline">Kebijakan
                                        Privasi</a> dan
                                    <a href="#" class="text-green-700 hover:underline">Syarat & Ketentuan</a>.
                                </label>
                            </div>

                            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-4">
                                <button type="submit"
                                    class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg bg-green-600 px-4 py-3 text-sm font-medium text-white hover:bg-green-700 transition">
                                    <x-heroicon-o-document-check class="size-4" /> Kirim & Verifikasi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </article>

            {{-- SIDEBAR --}}
            <aside class="space-y-6 lg:sticky lg:top-20">
                <div class="rounded-xl bg-white shadow p-5 ring-1 ring-black/5">
                    <div class="flex items-start gap-3">
                        <span
                            class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-green-50 ring-1 ring-green-200">
                            <x-heroicon-o-shield-check class="size-6 text-green-700" />
                        </span>
                        <div class="min-w-0">
                            <h3 class="font-semibold text-gray-900">Keamanan Data</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Foto KTP hanya digunakan untuk verifikasi identitas dan akan dihapus setelah proses selesai
                                sesuai Kebijakan Privasi.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl bg-white shadow p-5 ring-1 ring-black/5">
                    <h3 class="font-semibold text-gray-900 mb-2">Butuh Bantuan?</h3>
                    <ul class="text-sm text-gray-700 space-y-1">
                        <li>WhatsApp Admin: <a class="text-green-700 hover:underline"
                                href="https://wa.me/6281234567890">0812-3456-7890</a></li>
                        <li>Email: <a class="text-green-700 hover:underline"
                                href="mailto:admin@mentuda.go.id">admin@mentuda.go.id</a></li>
                    </ul>
                </div>

                <div class="bg-white rounded-xl shadow p-4">
                    <a href="{{ route('layanan') }}"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-green-600 px-4 py-2 text-sm font-medium text-green-700 hover:bg-green-600 hover:text-white transition">
                        <x-heroicon-o-arrow-left class="size-4" /> Kembali ke Layanan
                    </a>
                </div>
            </aside>
        </div>
    </section>

    {{-- Tesseract.js (OCR di browser) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js"></script>

    {{-- AlpineJS State & Camera + OCR Logic --}}
    <script>
        function scanKTP() {
            return {
                tab: 'kamera',
                streaming: false,
                hasPhoto: false,
                uploadHasPreview: false,
                streamRef: null,
                loadingOCR: false,
                msgOCR: '',
                form: {
                    nik: '',
                    tanggal_lahir: '',
                    nama: '',
                    base64: ''
                },

                init() {
                    // Matikan kamera otomatis saat pindah halaman/tab menutup
                    window.addEventListener('beforeunload', () => this.stopCamera());
                    document.addEventListener('visibilitychange', () => {
                        if (document.hidden) this.stopCamera();
                    });
                },

                async startCamera() {
                    try {
                        const constraints = {
                            audio: false,
                            video: {
                                facingMode: {
                                    ideal: 'environment'
                                },
                                width: {
                                    ideal: 1280
                                },
                                height: {
                                    ideal: 720
                                }
                            }
                        };
                        const stream = await navigator.mediaDevices.getUserMedia(constraints);
                        this.streamRef = stream;
                        const video = this.$refs.video;
                        video.srcObject = stream;
                        await video.play();
                        this.streaming = true;
                        this.hasPhoto = false;
                    } catch (e) {
                        alert('Tidak dapat mengakses kamera. Izinkan akses kamera atau gunakan metode unggah.');
                        console.error(e);
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
                    const snapshot = this.$refs.snapshot;

                    const w = video.videoWidth || 1280;
                    const h = video.videoHeight || 720;

                    canvas.width = w;
                    canvas.height = h;
                    const ctx = canvas.getContext('2d');
                    // un-mirror (video dimirror via CSS)
                    ctx.translate(w, 0);
                    ctx.scale(-1, 1);
                    ctx.drawImage(video, 0, 0, w, h);

                    const dataUrl = canvas.toDataURL('image/jpeg', 0.85);
                    this.form.base64 = dataUrl;
                    snapshot.src = dataUrl;
                    this.hasPhoto = true;

                    // OCR client-side dari kamera
                    this.runOCR(dataUrl, 'camera');
                },

                retake() {
                    this.hasPhoto = false;
                    this.form.base64 = '';
                    this.msgOCR = '';
                },

                onFileChange(e) {
                    const file = e.target.files?.[0];
                    if (!file) return;
                    if (file.size > 4 * 1024 * 1024) {
                        alert('Ukuran file melebihi 4MB');
                        e.target.value = '';
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = (ev) => {
                        this.$refs.uploadPreview.src = ev.target.result;
                        this.$refs.uploadPreview.style.display = 'block';
                        this.uploadHasPreview = true;

                        // OCR client-side dari unggah
                        this.runOCR(ev.target.result, 'upload'); // data URL
                    };
                    reader.readAsDataURL(file);
                },

                async runOCR(dataUrl, target) {
                    if (!window.Tesseract) {
                        this.msgOCR = 'OCR belum siap.';
                        return;
                    }
                    this.loadingOCR = true;
                    this.msgOCR = 'Membaca KTP…';

                    try {
                        const {
                            data
                        } = await Tesseract.recognize(dataUrl, 'eng');
                        const text = (data.text || '').replace(/\s+/g, ' ').trim();

                        // Ekstrak NIK (16 digit; toleransi spasi/titik/strip)
                        let nik = null;
                        const nikMatch = text.match(/(?:NIK|N0K|N1K)?[^0-9]*((?:\d[\s\.\-]*){16})/i);
                        if (nikMatch && nikMatch[1]) {
                            nik = nikMatch[1].replace(/\D+/g, '');
                            if (nik.length !== 16) nik = null;
                        }

                        // Ekstrak Tanggal Lahir (dd-mm-yyyy / dd/mm/yyyy / dd mm yyyy)
                        let dob = null;
                        const dobMatch = text.match(
                            /\b(0?[1-9]|[12][0-9]|3[01])[\-\/\s\.](0?[1-9]|1[0-2])[\-\/\s\.]((?:19|20)\d{2})\b/);
                        if (dobMatch) {
                            const d = String(dobMatch[1]).padStart(2, '0');
                            const m = String(dobMatch[2]).padStart(2, '0');
                            const y = String(dobMatch[3]);
                            dob = `${y}-${m}-${d}`;
                        }

                        // Ekstrak Nama (opsional)
                        let nama = null;
                        const upper = text.toUpperCase();
                        const namaMatch = upper.match(/\bNAMA(?: LENGKAP)?\s*[:\-]?\s*([A-Z\s\.'\-]{3,})/);
                        if (namaMatch && namaMatch[1]) {
                            nama = namaMatch[1].replace(/\s{2,}/g, ' ').trim();
                        }

                        if (target === 'camera') {
                            if (nik) this.form.nik = this.form.nik || nik;
                            if (dob) this.form.tanggal_lahir = this.form.tanggal_lahir || dob;
                            if (nama && !this.form.nama) this.form.nama = nama;
                        } else {
                            // target upload: isi langsung ke input upload
                            if (nik && !document.getElementById('nik_upload').value) {
                                document.getElementById('nik_upload').value = nik;
                            }
                            if (dob && !document.getElementById('dob_upload').value) {
                                document.getElementById('dob_upload').value = dob;
                            }
                            if (nama && !document.getElementById('nama_upload').value) {
                                document.getElementById('nama_upload').value = nama;
                            }
                        }

                        this.msgOCR = (nik || dob || nama) ?
                            'Data terisi dari hasil scan. Mohon periksa kembali.' :
                            'Tidak ditemukan NIK/TTL secara otomatis. Silakan isi manual.';
                    } catch (err) {
                        console.error(err);
                        this.msgOCR = 'OCR gagal. Silakan isi manual.';
                    } finally {
                        this.loadingOCR = false;
                    }
                },

                prepareSubmit() {
                    if (!this.form.base64 && !this.form.nik) {
                        alert('Ambil foto KTP atau isi NIK terlebih dahulu.');
                        return false;
                    }
                    this.stopCamera(); // matikan kamera saat submit
                    return true;
                }
            }
        }
    </script>
@endsection
