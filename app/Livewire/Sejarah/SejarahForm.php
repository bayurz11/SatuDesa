<?php

namespace App\Livewire\Sejarah;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Shared\Traits\WithAlerts;
use App\Domains\Sejarah\Models\Sejarah;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SejarahForm extends Component
{
    use WithFileUploads, WithAlerts;

    public ?int $sejarahId = null;
    public string $isi = '';
    public $gambar;
    public ?string $gambarLama = null;
    public ?string $tanggal = null;
    public bool $showModal = false;
    public bool $isEditing = false;
    public bool $is_active = true;

    public string $wrapId;
    public string $editorId;

    protected $listeners = [
        'openSejarahCreateForm' => 'openCreate',
        'openSejarahForm'       => 'openEdit',
        'openSejarahEditForm'   => 'openEdit',
    ];

    protected function rules(): array
    {
        return [
            'isi'       => 'required|string',
            'gambar'    => 'nullable|image|max:2048',
            'tanggal'   => 'nullable|date',
            'is_active' => 'boolean',
        ];
    }

    public function mount($sejarahId = null, $id = null): void
    {
        $this->refreshDomIds();
        $chosenId = $sejarahId ?? $id;

        if ($chosenId) {
            $this->loadSejarah((int) $chosenId);
            $this->isEditing = true;
        } else {
            $this->tanggal = now()->format('Y-m-d');
        }
    }

    public function render()
    {
        return view('livewire.sejarah.sejarah-form');
    }

    private function refreshDomIds(): void
    {
        $base = 'sejarah-' . Str::uuid()->toString();
        $this->wrapId = "tiptap-wrap-$base";
        $this->editorId = "tiptap-editor-$base";
    }

    private function componentKey(): string
    {
        if (method_exists($this, 'getId')) return (string) $this->getId();
        return (string) (property_exists($this, 'id') ? $this->id : spl_object_id($this));
    }

    public function openCreate(): void
    {
        $this->resetForm();
        $this->refreshDomIds();
        $this->showModal = true;

        $this->dispatch('init-ckeditor', [
            'wrapId'      => $this->wrapId,
            'editorId'    => $this->editorId,
            'content'     => $this->isi,
            'componentId' => $this->componentKey(),
        ]);
    }

    public function openEdit($payload = null): void
    {
        $this->resetForm();
        $id = is_array($payload) ? (int) ($payload['sejarahId'] ?? 0) : (int) $payload;
        if ($id) {
            $this->loadSejarah($id);
            $this->isEditing = true;
        }

        $this->refreshDomIds();
        $this->showModal = true;

        $this->dispatch('init-ckeditor', [
            'wrapId'      => $this->wrapId,
            'editorId'    => $this->editorId,
            'content'     => $this->isi,
            'componentId' => $this->componentKey(),
        ]);
    }

    public function closeModal(): void
    {
        $this->showModal = false;

        $this->dispatch('destroy-ckeditor', [
            'wrapId'   => $this->wrapId,
            'editorId' => $this->editorId,
        ]);

        $this->resetForm();
        $this->refreshDomIds();
    }

    private function resetForm(): void
    {
        $this->resetErrorBag();
        $this->sejarahId  = null;
        $this->isi        = '';
        $this->gambar     = null;
        $this->gambarLama = null;
        $this->tanggal    = now()->format('Y-m-d');
        $this->is_active  = true;
        $this->isEditing  = false;
    }

    private function loadSejarah(int $id): void
    {
        $s = Sejarah::findOrFail($id);

        $this->sejarahId  = $s->id;
        $this->isi        = $s->isi ?? '';
        $this->tanggal    = optional($s->tanggal)->format('Y-m-d');
        $this->is_active  = (bool) $s->is_active;
        $this->gambarLama = $s->gambar;
    }

    public function save(): void
    {
        $this->validate();

        if (is_string($this->isi)) {
            $trim = trim($this->isi);
            if ($trim === '' || $trim === '<div><br></div>' || $trim === '<p><br></p>') {
                $this->isi = '';
            }
        }

        $this->validate(); // 'isi' => 'required|string'

        $allowed  = '<b><strong><i><em><u><a><br><p><ul><ol><li>';
        $cleanIsi = strip_tags($this->isi, $allowed);

        $data = [
            'isi'       => $cleanIsi,
            'tanggal'   => $this->tanggal ?: now()->format('Y-m-d'),
            'is_active' => $this->is_active,
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
            $s = Sejarah::create($data);
            $this->sejarahId = $s->id;
        }

        $this->dispatch('$refresh');
        $this->dispatch('destroy-ckeditor', [
            'wrapId'   => $this->wrapId,
            'editorId' => $this->editorId,
        ]);

        $this->showSuccessToast("Sejarah saved successfully!");
        $this->resetForm();
        $this->refreshDomIds();
        $this->showModal = false;
    }
}
