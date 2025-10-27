<div>
    @if ($showModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-center justify-center overflow-y-auto"
            wire:click.self="closeModal">

            <div class="relative top-4 mx-auto w-full max-w-6xl p-4 border shadow-lg rounded-2xl bg-white">
                <div class=" overflow-hidden flex flex-col">

                    <!-- Header -->
                    <div class="flex justify-between items-center mb-4 border-b border-gray-200 pb-3">
                        <h3 class="text-xl font-semibold text-gray-900">
                            Sejarah
                        </h3>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Konten halaman publik -->
                    <div class="flex-grow rounded-xl overflow-hidden ring-1 ring-gray-100 shadow-sm" wire:ignore>
                        <iframe id="SejarahFrame" src="{{ route('sejarah') }}"
                            style="width: 100%; height: 600px; border: 0;" loading="lazy">
                        </iframe>
                    </div>

                    <!-- Footer -->
                    <div class="flex justify-end mt-4 border-t border-gray-200 pt-3">
                        <button wire:click="closeModal"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>a
        </div>
    @endif
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const iframe = document.getElementById('SejarahFrame');

        iframe.addEventListener('load', function() {
            try {
                // akses isi iframe
                const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;

                // sembunyikan elemen nav, header, dan footer
                const nav = iframeDoc.querySelector('nav');
                const header = iframeDoc.querySelector('header');
                const footer = iframeDoc.querySelector('footer');

                if (nav) nav.style.display = 'none';
                if (header) header.style.display = 'none';
                if (footer) footer.style.display = 'none';

                // hilangkan padding-top / margin-top jika layout menambahkan ruang
                iframeDoc.body.style.paddingTop = '0';
                iframeDoc.body.style.marginTop = '0';
            } catch (e) {
                console.warn('Tidak bisa akses isi iframe:', e);
            }
        });
    });
</script>
