<div class="space-y-6">
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl">
        <div class="border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-5">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Operasional APBDes</h3>
                    <p class="mt-1 max-w-3xl text-sm text-gray-600">
                        Gunakan alur sederhana ini: buat SPP, catat realisasi, lalu lanjutkan pembukuan kas, bank, dan pajak.
                    </p>
                </div>
                <div class="rounded-xl border border-blue-100 bg-white px-4 py-3 text-sm text-gray-600 shadow-sm">
                    <span class="font-semibold text-gray-900">Urutan kerja:</span> SPP -> Realisasi -> Buku Kas/Bank/Pajak
                </div>
            </div>
        </div>

        <div class="grid gap-3 px-5 py-5 sm:grid-cols-2 xl:grid-cols-5">
            <div class="rounded-xl border border-blue-100 bg-blue-50/70 px-4 py-3">
                <p class="text-xs font-semibold uppercase tracking-wide text-blue-700">SPP</p>
                <p class="mt-1 text-2xl font-bold text-gray-900">{{ number_format($stats['payment_requests'], 0, ',', '.') }}</p>
            </div>
            <div class="rounded-xl border border-purple-100 bg-purple-50/70 px-4 py-3">
                <p class="text-xs font-semibold uppercase tracking-wide text-purple-700">Realisasi</p>
                <p class="mt-1 text-2xl font-bold text-gray-900">{{ number_format($stats['realizations'], 0, ',', '.') }}</p>
            </div>
            <div class="rounded-xl border border-emerald-100 bg-emerald-50/70 px-4 py-3">
                <p class="text-xs font-semibold uppercase tracking-wide text-emerald-700">Buku Kas</p>
                <p class="mt-1 text-2xl font-bold text-gray-900">{{ number_format($stats['cash_books'], 0, ',', '.') }}</p>
            </div>
            <div class="rounded-xl border border-sky-100 bg-sky-50/70 px-4 py-3">
                <p class="text-xs font-semibold uppercase tracking-wide text-sky-700">Buku Bank</p>
                <p class="mt-1 text-2xl font-bold text-gray-900">{{ number_format($stats['bank_books'], 0, ',', '.') }}</p>
            </div>
            <div class="rounded-xl border border-amber-100 bg-amber-50/70 px-4 py-3">
                <p class="text-xs font-semibold uppercase tracking-wide text-amber-700">Buku Pajak</p>
                <p class="mt-1 text-2xl font-bold text-gray-900">{{ number_format($stats['tax_books'], 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl">
            <div class="border-b border-gray-200 px-6 py-5">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h4 class="text-base font-bold text-gray-900">Hasil SPP</h4>
                        <p class="mt-1 text-sm text-gray-600">Lihat dan kelola data SPP terbaru di sini.</p>
                    </div>
                    <button wire:click="openPaymentModal" type="button" class="module-primary-btn px-4 py-2 text-sm">
                        Tambah SPP
                    </button>
                </div>
            </div>
            <div class="grid gap-3 px-6 py-5 lg:grid-cols-2">
                @forelse ($paymentRequests as $record)
                    <div class="module-soft-card px-4 py-3">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-900">{{ $record->request_number }}</p>
                                <p class="mt-1 text-xs text-gray-500">{{ optional($record->request_date)->format('d M Y') }} - {{ $record->payee_name }}</p>
                                <p class="mt-2 text-sm font-semibold text-gray-900">Rp{{ number_format($record->amount, 0, ',', '.') }}</p>
                            </div>
                            <div class="flex gap-2">
                                <button wire:click="openPaymentModal({{ $record->id }})" type="button" class="module-edit-btn">Edit</button>
                                <button wire:click="confirmDeletePaymentRequest({{ $record->id }})" class="module-danger-btn">Hapus</button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-xl border border-dashed border-gray-300 px-4 py-6 text-center text-sm text-gray-500 lg:col-span-2">Belum ada data SPP.</div>
                @endforelse
            </div>
    </section>

    <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl">
            <div class="border-b border-gray-200 px-6 py-5">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h4 class="text-base font-bold text-gray-900">Hasil Realisasi</h4>
                        <p class="mt-1 text-sm text-gray-600">Daftar ringkas transaksi terbaru untuk edit cepat.</p>
                    </div>
                    <button wire:click="openRealizationModal" type="button" class="module-primary-btn px-4 py-2 text-sm">
                        Tambah Realisasi
                    </button>
                </div>
            </div>
            <div class="grid gap-3 px-6 py-5 lg:grid-cols-2">
                @forelse ($realizations as $record)
                    <div class="module-soft-card px-4 py-3">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-900">{{ $record->reference_number }}</p>
                                <p class="mt-1 text-xs text-gray-500">{{ optional($record->transaction_date)->format('d M Y') }} - {{ $record->budgetLine?->description }}</p>
                                <p class="mt-2 text-sm font-semibold text-gray-900">Rp{{ number_format($record->amount, 0, ',', '.') }}</p>
                            </div>
                            <div class="flex gap-2">
                                <button wire:click="openRealizationModal({{ $record->id }})" type="button" class="module-edit-btn">Edit</button>
                                <button wire:click="confirmDeleteRealization({{ $record->id }})" class="module-danger-btn">Hapus</button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-xl border border-dashed border-gray-300 px-4 py-6 text-center text-sm text-gray-500 lg:col-span-2">Belum ada data realisasi.</div>
                @endforelse
            </div>
    </section>

    <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl">
        <div class="border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-sky-50 px-6 py-5">
            <div class="flex flex-col gap-2 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-emerald-700">Langkah 3</p>
                    <h4 class="mt-1 text-lg font-bold text-gray-900">Pembukuan Operasional</h4>
                    <p class="mt-1 text-sm text-gray-600">Setelah realisasi tercatat, lanjutkan pencatatan ke buku kas, buku bank, dan buku pajak.</p>
                </div>
            </div>
        </div>

        <div class="grid gap-6 px-6 py-6 xl:grid-cols-3">
            <section class="rounded-2xl border border-emerald-100 bg-emerald-50/40">
                <div class="border-b border-emerald-100 px-5 py-4">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <h5 class="text-base font-bold text-gray-900">Buku Kas</h5>
                            <p class="mt-1 text-sm text-gray-600">Mutasi kas tunai desa.</p>
                        </div>
                        <button wire:click="openCashBookModal" type="button" class="module-primary-btn px-3 py-2 text-xs">Tambah Buku Kas</button>
                    </div>
                </div>
                <div class="space-y-4 px-5 py-4">
                    <div class="space-y-2">
                        @forelse ($cashBooks as $record)
                            <div class="module-soft-card px-4 py-3">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $record->reference_number }}</p>
                                        <p class="mt-1 text-xs text-gray-500">{{ optional($record->entry_date)->format('d M Y') }} - Saldo Rp{{ number_format($record->balance, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="flex gap-2">
                                        <button wire:click="openCashBookModal({{ $record->id }})" class="module-edit-btn">Edit</button>
                                        <button wire:click="confirmDeleteCashBook({{ $record->id }})" class="module-danger-btn">Hapus</button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-xl border border-dashed border-emerald-200 px-4 py-6 text-center text-sm text-gray-500">Belum ada entri buku kas.</div>
                        @endforelse
                    </div>
                </div>
            </section>

            <section class="rounded-2xl border border-sky-100 bg-sky-50/40">
                <div class="border-b border-sky-100 px-5 py-4">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <h5 class="text-base font-bold text-gray-900">Buku Bank</h5>
                            <p class="mt-1 text-sm text-gray-600">Mutasi rekening bank desa.</p>
                        </div>
                        <button wire:click="openBankBookModal" type="button" class="module-primary-btn px-3 py-2 text-xs">Tambah Buku Bank</button>
                    </div>
                </div>
                <div class="space-y-4 px-5 py-4">
                    <div class="space-y-2">
                        @forelse ($bankBooks as $record)
                            <div class="module-soft-card px-4 py-3">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $record->reference_number }}</p>
                                        <p class="mt-1 text-xs text-gray-500">{{ $record->bank_name ?: 'Bank belum diisi' }} - Saldo Rp{{ number_format($record->balance, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="flex gap-2">
                                        <button wire:click="openBankBookModal({{ $record->id }})" class="module-edit-btn">Edit</button>
                                        <button wire:click="confirmDeleteBankBook({{ $record->id }})" class="module-danger-btn">Hapus</button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-xl border border-dashed border-sky-200 px-4 py-6 text-center text-sm text-gray-500">Belum ada entri buku bank.</div>
                        @endforelse
                    </div>
                </div>
            </section>

            <section class="rounded-2xl border border-amber-100 bg-amber-50/40">
                <div class="border-b border-amber-100 px-5 py-4">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <h5 class="text-base font-bold text-gray-900">Buku Pajak</h5>
                            <p class="mt-1 text-sm text-gray-600">Pantau potongan dan setoran pajak.</p>
                        </div>
                        <button wire:click="openTaxBookModal" type="button" class="module-primary-btn px-3 py-2 text-xs">Tambah Buku Pajak</button>
                    </div>
                </div>
                <div class="space-y-4 px-5 py-4">
                    <div class="space-y-2">
                        @forelse ($taxBooks as $record)
                            <div class="module-soft-card px-4 py-3">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $record->tax_type }}</p>
                                        <p class="mt-1 text-xs text-gray-500">{{ $record->reference_number }} - Disetor Rp{{ number_format($record->remitted_amount, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="flex gap-2">
                                        <button wire:click="openTaxBookModal({{ $record->id }})" class="module-edit-btn">Edit</button>
                                        <button wire:click="confirmDeleteTaxBook({{ $record->id }})" class="module-danger-btn">Hapus</button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-xl border border-dashed border-amber-200 px-4 py-6 text-center text-sm text-gray-500">Belum ada entri buku pajak.</div>
                        @endforelse
                    </div>
                </div>
            </section>
        </div>
    </section>

    @if ($showPaymentModal)
    <div class="app-modal-overlay" data-modal-overlay>
        <div class="app-modal-shell">
            <div class="app-modal-panel max-w-4xl">
                <div class="border-b border-gray-200 px-6 py-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-blue-700">Langkah 1</p>
                            <h4 class="mt-1 text-lg font-bold text-gray-900">{{ $paymentRequestId ? 'Edit SPP' : 'Tambah SPP Baru' }}</h4>
                            <p class="mt-1 text-sm text-gray-600">Isi data permintaan pembayaran saat diperlukan.</p>
                        </div>
                        <button wire:click="closePaymentModal" type="button" class="module-neutral-btn px-4 py-2 text-sm">
                            Tutup
                        </button>
                    </div>
                </div>
                <div class="app-modal-body px-6 py-5">
            <form wire:submit="savePaymentRequest" class="space-y-4">
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tahun Anggaran</label>
                        <select wire:model="payment_fiscal_year_id" class="module-field mt-2 block w-full px-4 py-3 text-sm">
                            <option value="">Pilih tahun anggaran</option>
                            @foreach ($fiscalYears as $year)
                                <option value="{{ $year->id }}">{{ $year->title }}</option>
                            @endforeach
                        </select>
                        @error('payment_fiscal_year_id') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Baris Anggaran</label>
                        <select wire:model="payment_budget_line_id" class="module-field mt-2 block w-full px-4 py-3 text-sm">
                            <option value="">Pilih baris anggaran</option>
                            @foreach ($budgetLines as $line)
                                <option value="{{ $line->id }}">{{ $line->account?->code }} - {{ $line->description }}</option>
                            @endforeach
                        </select>
                        @error('payment_budget_line_id') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nomor SPP</label>
                        <input wire:model="request_number" type="text" class="module-field mt-2 block w-full px-4 py-3 text-sm">
                        @error('request_number') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal SPP</label>
                        <input wire:model="request_date" type="date" class="module-field mt-2 block w-full px-4 py-3 text-sm">
                        @error('request_date') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Penerima</label>
                        <input wire:model="payee_name" type="text" class="module-field mt-2 block w-full px-4 py-3 text-sm">
                        @error('payee_name') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nilai SPP</label>
                        <input wire:model="payment_amount" type="number" min="0" step="0.01" class="module-field mt-2 block w-full px-4 py-3 text-sm">
                        @error('payment_amount') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="grid gap-4 md:grid-cols-[minmax(0,1fr)_220px]">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                        <textarea wire:model="payment_description" rows="3" class="module-field mt-2 block w-full px-4 py-3 text-sm"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select wire:model="payment_status" class="module-field mt-2 block w-full px-4 py-3 text-sm">
                            <option value="draft">Draft</option>
                            <option value="submitted">Diajukan</option>
                            <option value="approved">Disetujui</option>
                            <option value="rejected">Ditolak</option>
                            <option value="paid">Dibayar</option>
                        </select>
                        @error('payment_status') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                        <div class="mt-4 flex gap-2">
                            <button wire:click="resetPaymentRequestForm" type="button" class="module-neutral-btn px-4 py-3 text-sm">Reset</button>
                            <button type="submit" class="module-primary-btn flex-1 px-4 py-3 text-sm">
                                {{ $paymentRequestId ? 'Simpan Perubahan SPP' : 'Simpan SPP' }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if ($showRealizationModal)
    <div class="app-modal-overlay" data-modal-overlay>
        <div class="app-modal-shell">
            <div class="app-modal-panel max-w-4xl">
                <div class="border-b border-gray-200 px-6 py-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-purple-700">Langkah 2</p>
                            <h4 class="mt-1 text-lg font-bold text-gray-900">{{ $realizationId ? 'Edit Realisasi' : 'Tambah Realisasi Baru' }}</h4>
                            <p class="mt-1 text-sm text-gray-600">Buka form ini saat ingin mencatat atau mengubah transaksi realisasi.</p>
                        </div>
                        <button wire:click="closeRealizationModal" type="button" class="module-neutral-btn px-4 py-2 text-sm">
                            Tutup
                        </button>
                    </div>
                </div>
                <div class="app-modal-body px-6 py-5">
            <form wire:submit="saveRealization" class="space-y-4">
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tahun Anggaran</label>
                        <select wire:model="realization_fiscal_year_id" class="module-field mt-2 block w-full px-4 py-3 text-sm">
                            <option value="">Pilih tahun anggaran</option>
                            @foreach ($fiscalYears as $year)
                                <option value="{{ $year->id }}">{{ $year->title }}</option>
                            @endforeach
                        </select>
                        @error('realization_fiscal_year_id') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Baris Anggaran</label>
                        <select wire:model="realization_budget_line_id" class="module-field mt-2 block w-full px-4 py-3 text-sm">
                            <option value="">Pilih baris anggaran</option>
                            @foreach ($budgetLines as $line)
                                <option value="{{ $line->id }}">{{ $line->account?->code }} - {{ $line->description }}</option>
                            @endforeach
                        </select>
                        @error('realization_budget_line_id') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nomor Referensi</label>
                        <input wire:model="reference_number" type="text" class="module-field mt-2 block w-full px-4 py-3 text-sm">
                        @error('reference_number') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Transaksi</label>
                        <input wire:model="transaction_date" type="date" class="module-field mt-2 block w-full px-4 py-3 text-sm">
                        @error('transaction_date') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="grid gap-4 md:grid-cols-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">SPP Terkait</label>
                        <select wire:model="realization_payment_request_id" class="module-field mt-2 block w-full px-4 py-3 text-sm">
                            <option value="">Tanpa SPP terkait</option>
                            @foreach ($paymentRequests as $record)
                                <option value="{{ $record->id }}">{{ $record->request_number }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Metode Bayar</label>
                        <select wire:model="payment_method" class="module-field mt-2 block w-full px-4 py-3 text-sm">
                            <option value="cash">Kas</option>
                            <option value="bank">Bank</option>
                            <option value="transfer">Transfer</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select wire:model="realization_status" class="module-field mt-2 block w-full px-4 py-3 text-sm">
                            <option value="draft">Draft</option>
                            <option value="posted">Posted</option>
                            <option value="verified">Terverifikasi</option>
                        </select>
                    </div>
                </div>
                <div class="grid gap-4 md:grid-cols-[minmax(0,1fr)_220px]">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                        <textarea wire:model="realization_description" rows="3" class="module-field mt-2 block w-full px-4 py-3 text-sm"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nilai Realisasi</label>
                        <input wire:model="realization_amount" type="number" min="0" step="0.01" class="module-field mt-2 block w-full px-4 py-3 text-sm">
                        @error('realization_amount') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                        <div class="mt-4 flex gap-2">
                            <button wire:click="resetRealizationForm" type="button" class="module-neutral-btn px-4 py-3 text-sm">Reset</button>
                            <button type="submit" class="module-primary-btn flex-1 px-4 py-3 text-sm">
                                {{ $realizationId ? 'Simpan Perubahan Realisasi' : 'Simpan Realisasi' }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if ($showCashBookModal)
    <div class="app-modal-overlay" data-modal-overlay>
        <div class="app-modal-shell">
            <div class="app-modal-panel max-w-3xl">
                <div class="border-b border-gray-200 px-6 py-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-emerald-700">Pembukuan</p>
                            <h4 class="mt-1 text-lg font-bold text-gray-900">{{ $cashBookId ? 'Edit Buku Kas' : 'Tambah Buku Kas' }}</h4>
                            <p class="mt-1 text-sm text-gray-600">Catat mutasi kas tunai desa dari realisasi yang sudah ada.</p>
                        </div>
                        <button wire:click="closeCashBookModal" type="button" class="rounded-xl border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">Tutup</button>
                    </div>
                </div>
                <div class="app-modal-body px-6 py-5">
                    <form wire:submit="saveCashBook" class="space-y-3">
                        <select wire:model="cash_fiscal_year_id" class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm shadow-sm">
                            <option value="">Pilih tahun anggaran</option>
                            @foreach ($fiscalYears as $year)
                                <option value="{{ $year->id }}">{{ $year->title }}</option>
                            @endforeach
                        </select>
                        <select wire:model="cash_realization_id" class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm shadow-sm">
                            <option value="">Pilih realisasi terkait</option>
                            @foreach ($realizations as $record)
                                <option value="{{ $record->id }}">{{ $record->reference_number }}</option>
                            @endforeach
                        </select>
                        <div class="grid gap-3 sm:grid-cols-2">
                            <input wire:model="cash_entry_date" type="date" class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm shadow-sm">
                            <input wire:model="cash_reference_number" type="text" placeholder="Nomor referensi" class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm shadow-sm">
                        </div>
                        <textarea wire:model="cash_description" rows="2" placeholder="Keterangan buku kas" class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm shadow-sm"></textarea>
                        <div class="grid gap-3 sm:grid-cols-3">
                            <input wire:model="cash_debit_amount" type="number" min="0" step="0.01" placeholder="Debit" class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm shadow-sm">
                            <input wire:model="cash_credit_amount" type="number" min="0" step="0.01" placeholder="Kredit" class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm shadow-sm">
                            <input wire:model="cash_balance" type="number" min="0" step="0.01" placeholder="Saldo" class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm shadow-sm">
                        </div>
                        <div class="flex gap-2">
                            <button wire:click="resetCashBookForm" type="button" class="rounded-xl border border-gray-300 px-4 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50">Reset</button>
                            <button type="submit" class="flex-1 rounded-xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700">
                                {{ $cashBookId ? 'Simpan Perubahan Buku Kas' : 'Simpan Buku Kas' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if ($showBankBookModal)
    <div class="app-modal-overlay" data-modal-overlay>
        <div class="app-modal-shell">
            <div class="app-modal-panel max-w-3xl">
                <div class="border-b border-gray-200 px-6 py-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sky-700">Pembukuan</p>
                            <h4 class="mt-1 text-lg font-bold text-gray-900">{{ $bankBookId ? 'Edit Buku Bank' : 'Tambah Buku Bank' }}</h4>
                            <p class="mt-1 text-sm text-gray-600">Catat mutasi rekening bank desa dengan format yang ringkas.</p>
                        </div>
                        <button wire:click="closeBankBookModal" type="button" class="rounded-xl border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">Tutup</button>
                    </div>
                </div>
                <div class="app-modal-body px-6 py-5">
                    <form wire:submit="saveBankBook" class="space-y-3">
                        <select wire:model="bank_fiscal_year_id" class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm shadow-sm">
                            <option value="">Pilih tahun anggaran</option>
                            @foreach ($fiscalYears as $year)
                                <option value="{{ $year->id }}">{{ $year->title }}</option>
                            @endforeach
                        </select>
                        <select wire:model="bank_realization_id" class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm shadow-sm">
                            <option value="">Pilih realisasi terkait</option>
                            @foreach ($realizations as $record)
                                <option value="{{ $record->id }}">{{ $record->reference_number }}</option>
                            @endforeach
                        </select>
                        <div class="grid gap-3 sm:grid-cols-2">
                            <input wire:model="bank_entry_date" type="date" class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm shadow-sm">
                            <input wire:model="bank_reference_number" type="text" placeholder="Nomor referensi" class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm shadow-sm">
                        </div>
                        <input wire:model="bank_name" type="text" placeholder="Nama bank" class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm shadow-sm">
                        <textarea wire:model="bank_description" rows="2" placeholder="Keterangan buku bank" class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm shadow-sm"></textarea>
                        <div class="grid gap-3 sm:grid-cols-3">
                            <input wire:model="bank_debit_amount" type="number" min="0" step="0.01" placeholder="Debit" class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm shadow-sm">
                            <input wire:model="bank_credit_amount" type="number" min="0" step="0.01" placeholder="Kredit" class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm shadow-sm">
                            <input wire:model="bank_balance" type="number" min="0" step="0.01" placeholder="Saldo" class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm shadow-sm">
                        </div>
                        <div class="flex gap-2">
                            <button wire:click="resetBankBookForm" type="button" class="rounded-xl border border-gray-300 px-4 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50">Reset</button>
                            <button type="submit" class="flex-1 rounded-xl bg-sky-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-sky-700">
                                {{ $bankBookId ? 'Simpan Perubahan Buku Bank' : 'Simpan Buku Bank' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if ($showTaxBookModal)
    <div class="app-modal-overlay" data-modal-overlay>
        <div class="app-modal-shell">
            <div class="app-modal-panel max-w-3xl">
                <div class="border-b border-gray-200 px-6 py-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-amber-700">Pembukuan</p>
                            <h4 class="mt-1 text-lg font-bold text-gray-900">{{ $taxBookId ? 'Edit Buku Pajak' : 'Tambah Buku Pajak' }}</h4>
                            <p class="mt-1 text-sm text-gray-600">Pantau potongan dan setoran pajak dari transaksi operasional.</p>
                        </div>
                        <button wire:click="closeTaxBookModal" type="button" class="rounded-xl border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">Tutup</button>
                    </div>
                </div>
                <div class="app-modal-body px-6 py-5">
                    <form wire:submit="saveTaxBook" class="space-y-3">
                        <select wire:model="tax_fiscal_year_id" class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm shadow-sm">
                            <option value="">Pilih tahun anggaran</option>
                            @foreach ($fiscalYears as $year)
                                <option value="{{ $year->id }}">{{ $year->title }}</option>
                            @endforeach
                        </select>
                        <select wire:model="tax_realization_id" class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm shadow-sm">
                            <option value="">Pilih realisasi terkait</option>
                            @foreach ($realizations as $record)
                                <option value="{{ $record->id }}">{{ $record->reference_number }}</option>
                            @endforeach
                        </select>
                        <div class="grid gap-3 sm:grid-cols-2">
                            <input wire:model="tax_entry_date" type="date" class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm shadow-sm">
                            <input wire:model="tax_reference_number" type="text" placeholder="Nomor referensi" class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm shadow-sm">
                        </div>
                        <input wire:model="tax_type" type="text" placeholder="Jenis pajak" class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm shadow-sm">
                        <textarea wire:model="tax_description" rows="2" placeholder="Keterangan buku pajak" class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm shadow-sm"></textarea>
                        <div class="grid gap-3 sm:grid-cols-3">
                            <input wire:model="tax_base_amount" type="number" min="0" step="0.01" placeholder="Dasar pajak" class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm shadow-sm">
                            <input wire:model="withheld_amount" type="number" min="0" step="0.01" placeholder="Dipungut" class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm shadow-sm">
                            <input wire:model="remitted_amount" type="number" min="0" step="0.01" placeholder="Disetor" class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm shadow-sm">
                        </div>
                        <select wire:model="tax_status" class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm shadow-sm">
                            <option value="withheld">Sudah Dipotong</option>
                            <option value="remitted">Sudah Disetor</option>
                        </select>
                        <div class="flex gap-2">
                            <button wire:click="resetTaxBookForm" type="button" class="rounded-xl border border-gray-300 px-4 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50">Reset</button>
                            <button type="submit" class="flex-1 rounded-xl bg-amber-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-amber-700">
                                {{ $taxBookId ? 'Simpan Perubahan Buku Pajak' : 'Simpan Buku Pajak' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
