<?php

namespace App\Livewire\Struktur;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Shared\Traits\WithAlerts;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
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

    /** Daftar jabatan -> level */
    public array $jabatanOptions = [
        // Pimpinan
        'Kepala Desa' => 'pimpinan',

        // Sekretariat
        'Sekretaris Desa'            => 'struktural',
        'Kaur Keuangan'              => 'struktural',
        'Kaur Umum & Perencanaan'    => 'struktural',

        // Seksi
        'Kasi Pemerintahan'          => 'struktural',
        'Kasi Kesejahteraan'         => 'struktural',
        'Kasi Pelayanan'             => 'struktural',

        // Kewilayahan
        'Kepala Dusun Mentuda'           => 'kewilayahan',
        'Kepala Dusun Pulun & Jelutung'  => 'kewilayahan',
        'Kepala Dusun Tembok & Mentengah' => 'kewilayahan',
    ];

    protected $listeners = [
        'openStrukturForm' => 'openForm',
    ];

    /** Rules dinamis agar validasi jabatan sesuai daftar */
    protected function rules(): array
    {
        return [
            'nama'      => 'required|string|max:255',
            'jabatan'   => ['required', \Illuminate\Validation\Rule::in(array_keys($this->jabatanOptions))],
            'level'     => ['required', \Illuminate\Validation\Rule::in(['pimpinan', 'struktural', 'kewilayahan'])],
            'foto'      => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ];
    }

    // Autoset level begitu jabatan dipilih
    public function updatedJabatan($value): void
    {
        if (isset($this->jabatanOptions[$value])) {
            $this->level = $this->jabatanOptions[$value];
        }
    }

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
            $this->fotoLama   = $item->foto;       // path relatif disimpan, contoh: "storage/struktur/xxxx.jpg"
            $this->is_active  = (bool) $item->is_active;

            $this->isEditing  = true;
        } else {
            $this->reset(['strukturId', 'nama', 'jabatan', 'foto', 'fotoLama', 'isEditing']);
            $this->level      = 'struktural'; // default
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
            $relative = $this->foto->storeAs('struktur', $namaFile, 'public_path'); // "struktur/xxxx.jpg"

            // Simpan path yg siap dipakai asset(): "storage/struktur/xxxx.jpg"
            $data['foto'] = 'storage/' . ltrim($relative, '/');

            // Hapus foto lama jika update
            if ($this->isEditing && $this->fotoLama) {
                // $this->fotoLama berupa "storage/struktur/xxxx.jpg"
                $old = ltrim(str_replace('storage/', '', $this->fotoLama), '/'); // "struktur/xxxx.jpg"
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
        // Opsi level untuk select (jika tetap ditampilkan)
        $levelOptions = [
            'pimpinan'    => 'Pimpinan',
            'struktural'  => 'Struktural',
            'kewilayahan' => 'Kewilayahan (RT/RW)',
        ];

        // Kirim daftar opsi jabatan ke Blade
        $jabatanOptions = array_keys($this->jabatanOptions);

        return view('livewire.struktur.struktur-form', compact('levelOptions', 'jabatanOptions'));
    }
}
