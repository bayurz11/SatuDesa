<?php

namespace App\Livewire\VisiMisi;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Shared\Traits\WithAlerts;
use App\Domains\VisiMisi\Models\VisiMisi;
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
    public string $editorId;

    protected $rules = [
        'kategori' => 'required|string|in:visi,misi',
        'isi' => 'required|string',
        'gambar' => 'nullable|image|max:2048',
        'is_active' => 'boolean',
    ];

    protected $listeners = ['openVisiMisiForm' => 'openForm'];

    public function openForm($id = null)
    {
        $this->resetErrorBag();
        $this->editorId = 'editor-' . uniqid();

        if ($id) {
            $item = VisiMisi::findOrFail($id);
            $this->visiMisiId = $item->id;
            $this->kategori = $item->kategori;
            $this->isi = $item->isi;
            $this->gambarLama = $item->gambar;
            $this->is_active = $item->is_active;
            $this->isEditing = true;
        } else {
            $this->reset(['visiMisiId', 'isi', 'gambar', 'gambarLama', 'isEditing']);
        }

        $this->showModal = true;
    }


    public function save()
    {
        $this->validate();

        $data = [
            'kategori' => $this->kategori,
            'isi' => $this->isi,
            'is_active' => $this->is_active,
        ];

        if ($this->gambar) {
            $data['gambar'] = $this->gambar->store('visimisi', 'public');
        }

        $this->isEditing
            ? VisiMisi::findOrFail($this->visiMisiId)->update($data)
            : VisiMisi::create($data);

        $this->showSuccessToast("Data saved successfully!");
        $this->dispatch('$refresh');
        $this->closeModal(); // panggil langsung agar modal tertutup otomatis
    }

    /** Tutup modal */
    public function closeModal()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['visiMisiId', 'isi', 'gambar', 'gambarLama', 'isEditing']);
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.visi-misi.visi-misi-form');
    }
}
