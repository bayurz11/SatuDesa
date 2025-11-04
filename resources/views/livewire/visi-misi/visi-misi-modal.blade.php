@if ($showModal)
    <div class="fixed inset-0 z-[9999]">
        {{-- BACKDROP (klik di mana saja untuk tutup) --}}
        <div class="absolute inset-0 bg-gray-600/60" wire:click="closeModal"></div>

        {{-- PANEL --}}
        <div class="absolute inset-0 flex items-center justify-center overflow-y-auto">
            <div class="relative mx-auto w-full max-w-6xl p-4">
                <div class="relative rounded-2xl bg-white shadow ring-1 ring-black/5 z-10">
                    {{-- Header --}}
                    <div class="flex justify-between items-center mb-4 border-b border-gray-200 pb-3 px-4 pt-4">
                        <h3 class="text-xl font-semibold text-gray-900">Visi &amp; Misi Desa Mentuda</h3>
                        <button type="button" wire:click="closeModal"
                            class="text-gray-400 hover:text-gray-600 relative z-20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    {{-- Konten --}}
                    <div class="rounded-xl overflow-hidden ring-1 ring-gray-100 shadow-sm relative z-10">
                        <iframe id="visiMisiFrame" wire:ignore src="{{ route('visi-misi') }}"
                            style="width:100%; height:600px; border:0;" loading="lazy" class="block"></iframe>
                    </div>

                    {{-- Footer --}}
                    <div class="flex justify-end mt-4 border-t border-gray-200 pt-3 px-4 pb-4">
                        <button type="button" wire:click="closeModal"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@push('scripts')
    <script>
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                @this.call('closeModal');
            }
        });
    </script>
@endpush
