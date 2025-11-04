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

    // Data
    public ?int $sejarahId = null;
    public string $isi = '';
    public $gambar;
    public ?string $gambarLama = null;
    public ?string $tanggal = null;
    public bool $is_active = true;

    // UI state
    public bool $showModal = false;
    public bool $isEditing = false;

    // Editor
    public ?string $editorId = null;

    protected $rules = [
        'isi'       => 'required|string',
        'gambar'    => 'nullable|image|max:2048',
        'tanggal'   => 'nullable|date',
        'is_active' => 'boolean',
    ];

    protected $listeners = ['openSejarahForm' => 'openForm'];

    public function render()
    {
        return view('livewire.sejarah.sejarah-form');
    }

    /** Create/Edit entry point (sama seperti VisiMisiForm) */
    public function openForm($id = null): void
    {
        $this->resetErrorBag();
        $this->resetValidation();

        $this->editorId = 'editor-' . uniqid();

        if ($id) {
            // EDIT
            $item = Sejarah::findOrFail((int) $id);

            $this->sejarahId  = $item->id;
            $this->isi        = $item->isi ?? '';
            $this->gambarLama = $item->gambar;
            $this->tanggal    = $item->tanggal?->format('Y-m-d');
            $this->is_active  = (bool) $item->is_active;

            $this->isEditing  = true;
        } else {
            // CREATE
            $this->reset(['sejarahId', 'isi', 'gambar', 'gambarLama', 'isEditing']);
            $this->tanggal   = now()->format('Y-m-d');
            $this->is_active = true;
        }

        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        // Guard editor kosong
        if (is_string($this->isi)) {
            $trim = trim($this->isi);
            if ($trim === '' || $trim === '<div><br></div>' || $trim === '<p><br></p>') {
                $this->isi = '';
            }
        }
        $this->validate();

        // Sanitasi (opsional)
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
        $this->dispatch('sejarah:saved');

        $this->closeModal();
    }

    public function closeModal(): void
    {
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
        // $editorId akan diganti saat openForm berikutnya
    }
}
