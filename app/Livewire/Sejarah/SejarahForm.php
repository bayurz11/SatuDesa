<?php

namespace App\Livewire\Sejarah;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Shared\Traits\WithAlerts;
use App\Domains\Sejarah\Models\Sejarah;
use Illuminate\Support\Facades\Storage;

class SejarahForm extends Component
{
    use WithFileUploads, WithAlerts;

    // properti utama (mirip VisiMisiForm)
    public ?int $sejarahId = null;
    public string $isi = '';
    public $gambar;
    public ?string $gambarLama = null;
    public ?string $tanggal = null;
    public bool $is_active = true;

    // state UI
    public bool $showModal = false;
    public bool $isEditing = false;

    // opsi editor (opsional, jika pakai CKEditor/Tiptap)
    public ?string $editorId = null;

    // rules pakai properti (bukan method) agar konsisten
    protected $rules = [
        'isi'       => 'required|string',
        'gambar'    => 'nullable|image|max:2048',
        'tanggal'   => 'nullable|date',
        'is_active' => 'boolean',
    ];

    // satu event saja seperti VisiMisiForm
    protected $listeners = ['openSejarahForm' => 'openForm'];

    public function render()
    {
        return view('livewire.sejarah.sejarah-form');
    }

    /** Buka modal: create (tanpa $id) atau edit (dengan $id) */
    public function openForm($id = null): void
    {
        // reset error/validasi
        $this->resetErrorBag();
        $this->resetValidation();

        // id editor baru (kalau pakai CKEditor/Tiptap)
        $this->editorId = 'editor-' . uniqid();

        if ($id) {
            // EDIT
            $item = Sejarah::findOrFail((int) $id);

            $this->sejarahId  = $item->id;
            $this->isi        = $item->isi ?? '';
            $this->gambarLama = $item->gambar;
            $this->tanggal    = $item->tanggal?->format('Y-m-d'); // aman kalau null
            $this->is_active  = (bool) $item->is_active;

            $this->isEditing  = true;
        } else {
            // CREATE
            $this->reset(['sejarahId', 'isi', 'gambar', 'gambarLama', 'isEditing']);
            $this->tanggal   = now()->format('Y-m-d');
            $this->is_active = true;
        }

        $this->showModal = true;

        // Jika Anda memang inisialisasi editor via JS, bolehlah dipanggil:
        // $this->dispatch('init-ckeditor', [
        //     'editorId'    => $this->editorId,
        //     'content'     => $this->isi,
        //     'componentId' => $this->getId(), // Livewire v3 sudah punya getId()
        // ]);
    }

    /** Simpan data */
    public function save(): void
    {
        $this->validate();

        // opsional: bersihkan tag kosong dari editor
        if (is_string($this->isi)) {
            $trim = trim($this->isi);
            if ($trim === '' || $trim === '<div><br></div>' || $trim === '<p><br></p>') {
                $this->isi = '';
            }
        }
        $this->validate(); // validasi ulang jika isi jadi kosong

        // boleh pakai whitelist tag kalau perlu
        $allowed  = '<b><strong><i><em><u><a><br><p><ul><ol><li>';
        $cleanIsi = strip_tags($this->isi, $allowed);

        $data = [
            'isi'       => $cleanIsi,
            'tanggal'   => $this->tanggal ?: now()->format('Y-m-d'),
            'is_active' => (bool) $this->is_active,
        ];

        if ($this->gambar) {
            $pathBaru = $this->gambar->store('sejarah', 'public');
            $data['gambar'] = $pathBaru;

            // hapus lama saat edit
            if ($this->isEditing && $this->gambarLama && Storage::disk('public')->exists($this->gambarLama)) {
                Storage::disk('public')->delete($this->gambarLama);
            }
            $this->gambarLama = $pathBaru;
        }

        if ($this->isEditing) {
            Sejarah::findOrFail($this->sejarahId)->update($data);
        } else {
            $item = Sejarah::create($data);
            $this->sejarahId = $item->id;
        }

        $this->showSuccessToast("Sejarah saved successfully!");
        $this->dispatch('$refresh');

        // Jika pakai editor, boleh dihancurkan:
        // $this->dispatch('destroy-ckeditor', ['editorId' => $this->editorId]);

        $this->closeModal(); // selaraskan dengan VisiMisiForm
    }

    /** Tutup modal */
    public function closeModal(): void
    {
        // Jika pakai editor:
        // $this->dispatch('destroy-ckeditor', ['editorId' => $this->editorId]);

        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset([
            'sejarahId',
            'isi',
            'gambar',
            'gambarLama',
            'tanggal',
            'isEditing',
            'showModal'
        ]);
        $this->is_active = true;
        // editorId boleh dibiarkan, akan diganti saat openForm berikutnya
    }
}
