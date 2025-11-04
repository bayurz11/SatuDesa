<?php

namespace App\Livewire\VisiMisi;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Shared\Traits\WithAlerts;
// perbaiki namespace & nama kelas model:
use App\Domains\Visimisi\Models\Visimisi;
use Illuminate\Support\Facades\Storage;

class VisiMisiForm extends Component
{
    use WithFileUploads, WithAlerts;

    public $visiMisiId;
    public $kategori = 'visi';
    public $isi;
    public $gambar;
    public $gambarLama;
    public $is_active = true;
    public $showModal = false;
    public $isEditing = false;

    // HINDARI typed property tanpa default. Bikin nullable atau beri default.
    public ?string $editorId = null;

    protected $rules = [
        'kategori'  => 'required|string|in:visi,misi',
        'isi'       => 'required|string',
        'gambar'    => 'nullable|image|max:2048',
        'is_active' => 'boolean',
    ];

    protected $listeners = ['openVisiMisiForm' => 'openForm'];

    public function openForm($id = null)
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->editorId = 'editor-' . uniqid();

        if ($id) {
            // pakai kelas yang benar
            $item = Visimisi::findOrFail($id);

            $this->visiMisiId = $item->id;
            $this->kategori   = $item->kategori;
            $this->isi        = $item->isi;
            $this->gambarLama = $item->gambar;

            // pastikan boolean (walau sudah casts, aman ditipekan lagi)
            $this->is_active  = (bool) $item->is_active;

            $this->isEditing  = true;
        } else {
            // reset field konten, tapi JANGAN reset is_active (biar default true)
            $this->reset(['visiMisiId', 'isi', 'gambar', 'gambarLama', 'isEditing']);
            $this->kategori  = 'visi';
            $this->is_active = true; // default saat create
        }

        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'kategori'  => $this->kategori,
            'isi'       => $this->isi,
            'is_active' => (bool) $this->is_active,
        ];

        if ($this->gambar) {
            $data['gambar'] = $this->gambar->store('visimisi', 'public');

            // jika edit dan ada gambar lama, hapus
            if ($this->isEditing && $this->gambarLama && Storage::disk('public')->exists($this->gambarLama)) {
                Storage::disk('public')->delete($this->gambarLama);
            }
        }

        if ($this->isEditing) {
            Visimisi::findOrFail($this->visiMisiId)->update($data);
        } else {
            Visimisi::create($data);
        }

        $this->showSuccessToast("Data saved successfully!");

        // Lebih baik broadcast event spesifik untuk refresh list
        $this->dispatch('visiMisiSaved');

        $this->closeModal();
    }

    public function closeModal()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['visiMisiId', 'isi', 'gambar', 'gambarLama', 'isEditing', 'showModal']);
        // biarkan is_active tetap default true untuk form berikutnya
        $this->is_active = true;
    }

    public function render()
    {
        return view('livewire.visi-misi.visi-misi-form');
    }
}
