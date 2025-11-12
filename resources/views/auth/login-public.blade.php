@extends('layouts.app2')

@section('title', 'Layanan Publik Warga')

@section('content')
    <style>
        input[type="date"] {
            color-scheme: light;
        }

        ::placeholder {
            color: #6b7280;
            opacity: 1;
        }

        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

        video {
            transform: none;
        }

        video.mirror {
            transform: scaleX(-1);
        }

        canvas {
            display: none;
        }
    </style>

    <section class="mx-auto max-w-6xl px-4 md:px-6 lg:px-8 py-10 md:py-14" data-aos="fade-up">
        {{-- Heading --}}
        <header class="text-center mb-8 md:mb-12">
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-green-700">
                Portal Warga Desa Mentuda
            </h1>
            <p class="mt-3 text-gray-600 max-w-2xl mx-auto">
                Masuk dengan NIK & PIN atau daftar akun baru dengan memindai / mengunggah KTP Anda.
            </p>
        </header>

        {{-- Main --}}
        <div x-data="loginWarga()" x-init="init()"
            class="max-w-4xl mx-auto bg-white rounded-2xl shadow ring-1 ring-black/5 overflow-hidden">
            {{-- Tabs --}}
            <div class="border-b border-gray-100 px-4 md:px-6 pt-4">
                <div class="grid grid-cols-2 rounded-xl bg-gray-50 p-1 ring-1 ring-black/5">
                    <button @click="tab='masuk'"
                        :class="tab === 'masuk' ? 'bg-white text-green-700 shadow font-semibold' :
                            'text-gray-600 hover:text-gray-900'"
                        class="px-4 py-2.5 text-sm font-medium rounded-lg transition text-center">
                        Masuk Warga (NIK)
                    </button>
                    <button @click="tab='daftar'"
                        :class="tab === 'daftar' ? 'bg-white text-green-700 shadow font-semibold' :
                            'text-gray-600 hover:text-gray-900'"
                        class="px-4 py-2.5 text-sm font-medium rounded-lg transition text-center">
                        Daftar Warga Baru
                    </button>
                </div>
            </div>

            {{-- Panel: Login --}}
            <div x-show="tab==='masuk'" x-cloak class="p-6 md:p-8">
                <form method="POST" action="#" class="space-y-5" @submit.prevent="doLogin">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-900">NIK</label>
                        <input type="text" x-model="login.nik" maxlength="16" inputmode="numeric"
                            class="mt-1 w-full rounded-lg bg-white px-4 py-2.5 text-gray-900 shadow-md focus:ring-2 focus:ring-green-300 outline-none transition"
                            placeholder="Masukkan NIK Anda" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900">PIN</label>
                        <input type="password" x-model="login.pin" maxlength="6"
                            class="mt-1 w-full rounded-lg bg-white px-4 py-2.5 text-gray-900 shadow-md focus:ring-2 focus:ring-green-300 outline-none transition"
                            placeholder="6 digit PIN" required>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 justify-between sm:items-center mt-6">
                        <button type="submit"
                            class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg bg-green-600 px-4 py-3 text-sm font-medium text-white hover:bg-green-700 transition">
                            <x-heroicon-o-lock-closed class="size-4" /> Masuk sebagai Warga
                        </button>
                    </div>
                </form>
            </div>

            {{-- Panel: Registrasi --}}
            <div x-show="tab==='daftar'" x-cloak class="p-6 md:p-8">
                <form method="POST" action="#" class="space-y-6" @submit.prevent="doRegister">
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
                            Arahkan KTP ke kamera belakang dan ambil foto
                        </div>
                    </div>

                    {{-- Tombol Kamera --}}
                    <div class="mt-3 flex flex-wrap gap-2">
                        <button type="button" @click="startCamera" :disabled="streaming"
                            class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-3 py-2 text-sm font-medium text-white hover:bg-green-700 disabled:opacity-50">
                            <x-heroicon-o-camera class="size-4" /> Nyalakan Kamera
                        </button>

                        <button type="button" @click="capture" :disabled="!streaming"
                            class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-3 py-2 text-sm font-medium text-white hover:bg-emerald-700 disabled:opacity-50">
                            <x-heroicon-o-photo class="size-4" /> Ambil Foto
                        </button>

                        <button type="button" @click="retake" x-show="hasPhoto"
                            class="inline-flex items-center gap-2 rounded-lg border border-green-600 px-3 py-2 text-sm font-medium text-green-700 hover:bg-green-600 hover:text-white transition">
                            <x-heroicon-o-arrow-path class="size-4" /> Ulangi
                        </button>
                    </div>

                    <p class="text-sm text-gray-600"><span x-text="msgOCR"></span></p>

                    {{-- Data --}}
                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-900">NIK</label>
                            <input type="text" x-model="reg.nik" maxlength="16" inputmode="numeric"
                                class="mt-1 block w-full rounded-lg bg-white px-4 py-2.5 text-gray-900 shadow-md focus:ring-2 focus:ring-green-300 outline-none transition"
                                placeholder="16 digit NIK" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-900">Tanggal Lahir</label>
                            <input type="date" x-model="reg.tanggal_lahir"
                                class="mt-1 w-full rounded-lg bg-white px-4 py-2.5 text-gray-900 shadow-md focus:ring-2 focus:ring-green-300 outline-none transition"
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-900">Nama Lengkap</label>
                            <input type="text" x-model="reg.nama"
                                class="mt-1 w-full rounded-lg bg-white px-4 py-2.5 text-gray-900 shadow-md focus:ring-2 focus:ring-green-300 outline-none transition"
                                placeholder="Nama sesuai KTP">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-900">No. HP / Email</label>
                            <input type="text" x-model="reg.kontak"
                                class="mt-1 w-full rounded-lg bg-white px-4 py-2.5 text-gray-900 shadow-md focus:ring-2 focus:ring-green-300 outline-none transition"
                                placeholder="08xxxx / email@example.com" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-900">PIN (6 Digit)</label>
                            <input type="password" x-model="reg.pin" maxlength="6"
                                class="mt-1 w-full rounded-lg bg-white px-4 py-2.5 text-gray-900 shadow-md focus:ring-2 focus:ring-green-300 outline-none transition"
                                placeholder="******" required>
                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-3 text-sm font-medium text-white hover:bg-green-700 transition">
                            <x-heroicon-o-user-plus class="size-4" /> Daftar Warga
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    {{-- OCR --}}
    <script defer src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js"></script>
    <script>
        function loginWarga() {
            return {
                tab: 'masuk',
                streaming: false,
                hasPhoto: false,
                msgOCR: '',
                streamRef: null,
                login: {
                    nik: '',
                    pin: ''
                },
                reg: {
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
                    const v = this.$refs.video,
                        c = this.$refs.canvas,
                        ctx = c.getContext('2d');
                    c.width = v.videoWidth;
                    c.height = v.videoHeight;
                    ctx.drawImage(v, 0, 0);
                    const dataUrl = c.toDataURL('image/jpeg', 0.85);
                    this.reg.base64 = dataUrl;
                    this.$refs.snapshot.src = dataUrl;
                    this.hasPhoto = true;
                    this.stopCamera();
                    this.runOCR(dataUrl);
                },

                retake() {
                    this.hasPhoto = false;
                    this.msgOCR = '';
                    this.reg.base64 = '';
                    this.startCamera();
                },

                async runOCR(dataUrl) {
                    this.msgOCR = '⏳ Membaca KTP...';
                    const {
                        data
                    } = await Tesseract.recognize(dataUrl, 'eng');
                    const text = data.text.replace(/\s+/g, ' ');
                    const nik = text.match(/(\d{16})/);
                    if (nik) this.reg.nik = nik[1];
                    const ttl = text.match(/\b(0[1-9]|[12][0-9]|3[01])[\-\/.](0[1-9]|1[0-2])[\-\/.](19|20)\d{2}\b/);
                    if (ttl) {
                        const [d, m, y] = ttl[0].split(/[.\-\/]/);
                        this.reg.tanggal_lahir = `${y}-${m}-${d}`;
                    }
                    const nm = text.match(/NAMA\s*[:\-]?\s*([A-Z\s]+)/i);
                    if (nm) this.reg.nama = nm[1].trim();
                    this.msgOCR = '✅ Data berhasil dibaca. Periksa kembali sebelum daftar.';
                },

                doLogin() {
                    if (!this.login.nik || !this.login.pin) {
                        alert('Masukkan NIK dan PIN.');
                        return;
                    }
                    alert(`Login sukses (simulasi)\nNIK: ${this.login.nik}`);
                },

                doRegister() {
                    if (!this.reg.nik || !this.reg.pin) {
                        alert('Lengkapi NIK dan PIN untuk registrasi.');
                        return;
                    }
                    alert(`Registrasi berhasil (simulasi)\nNIK: ${this.reg.nik}`);
                },
            };
        }
    </script>
@endsection
