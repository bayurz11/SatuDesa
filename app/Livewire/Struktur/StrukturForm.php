<?php

namespace App\Livewire\Struktur;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Shared\Traits\WithAlerts;
use Illuminate\Support\Facades\Storage;
use App\Domains\Struktur\Models\Struktur;

class StrukturForm extends Component
{
    use WithFileUploads, WithAlerts;

    // Data
    public ?int $strukturId = null;
    public string $nama = '';
    public string $jabatan = '';
    public string $level = 'struktural'; // default
    public $foto;                        // UploadedFile|null
    public ?string $fotoLama = null;     // path lama (jika edit)
    public bool $is_active = true;

    // UI
    public bool $showModal = false;
    public bool $isEditing = false;

    protected $rules = [
        'nama'      => 'required|string|max:255',
        'jabatan'   => 'required|string|max:255',
        'level'     => 'required|in:pimpinan,struktural,kewilayahan',
        'foto'      => 'nullable|image|max:2048',
        'is_active' => 'boolean',
    ];

    protected $listeners = [
        'openStrukturForm' => 'openForm',
    ];

    public function openForm($id = null): void
    {
        $this->resetErrorBag();
        $this->resetValidation();

        if ($id) {
            $item = Struktur::findOrFail($id);

            $this->strukturId = $item->id;
            $this->nama       = (string) $item->nama;
            $this->jabatan    = (string) $item->jabatan;
            $this->level      = (string) $item->level;
            $this->fotoLama   = $item->foto;       // path relatif di disk public
            $this->is_active  = (bool) $item->is_active;

            $this->isEditing  = true;
        } else {
            $this->reset(['strukturId', 'nama', 'jabatan', 'foto', 'fotoLama', 'isEditing']);
            $this->level      = 'struktural'; // default sesuai legenda
            $this->is_active  = true;
        }

        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'nama'      => $this->nama,
            'jabatan'   => $this->jabatan,
            'level'     => $this->level,
            'is_active' => $this->is_active,
        ];

        // Handle upload foto jika ada
        if ($this->foto) {
            // Pastikan direktori tujuan ada
            Storage::disk('public_path')->makeDirectory('struktur');

            // Nama file unik
            $ext = strtolower($this->foto->getClientOriginalExtension() ?: 'jpg');
            $namaFile = Str::random(12) . '.' . $ext;

            // Simpan langsung ke public/storage/struktur (tanpa symlink)
            $relative = $this->foto->storeAs('struktur', $namaFile, 'public_path'); // hasil: "struktur/xxxx.jpg"

            // Simpan path yg siap dipakai asset()
            $data['foto'] = 'storage/' . ltrim($relative, '/'); // "storage/struktur/xxxx.jpg"

            // Hapus foto lama jika update
            if ($this->isEditing && $this->fotoLama) {
                // $this->fotoLama disimpan sebagai "storage/struktur/xxxx.jpg"
                $old = ltrim(str_replace('storage/', '', $this->fotoLama), '/'); // jadi "struktur/xxxx.jpg"
                if (Storage::disk('public_path')->exists($old)) {
                    Storage::disk('public_path')->delete($old);
                }
            }
        }

        if ($this->isEditing) {
            Struktur::findOrFail($this->strukturId)->update($data);
        } else {
            Struktur::create($data);
        }

        $this->showSuccessToast('Data saved successfully!');
        $this->dispatch('struktur:saved'); // untuk refresh list
        $this->closeModal();
    }

    public function closeModal(): void
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['strukturId', 'nama', 'jabatan', 'foto', 'fotoLama', 'isEditing', 'showModal']);
        $this->level     = 'struktural';
        $this->is_active = true;
    }

    public function render()
    {
        // Opsi level untuk select
        $levelOptions = [
            'pimpinan'    => 'Pimpinan',
            'struktural'  => 'Struktural',
            'kewilayahan' => 'Kewilayahan (RT/RW)',
        ];

        return view('livewire.struktur.struktur-form', compact('levelOptions'));
    }
}
