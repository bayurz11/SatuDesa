<?php

namespace App\Livewire\Tag;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Domains\Post\Models\Tag;

class TagForm extends Component
{
    public bool $showModal = false;
    public bool $isEditing = false;

    public ?string $tagId = null; // ULID
    public string $name = '';
    public string $slug = '';
    public bool $is_active = true;

    protected $listeners = [
        // openTagForm
        'openTagForm' => 'openForm',
    ];

    public function openForm(?string $id = null): void
    {
        $this->resetValidation();

        if ($id) {
            $tag = Tag::findOrFail($id);
            $this->tagId     = $tag->id;
            $this->name      = $tag->name;
            $this->slug      = $tag->slug ?? '';
            $this->is_active = (bool) $tag->is_active;
            $this->isEditing = true;
        } else {
            $this->reset(['tagId', 'name', 'slug', 'is_active']);
            $this->is_active = true;
            $this->isEditing = false;
        }

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function updatedName(): void
    {
        if (blank($this->slug)) {
            $this->slug = Str::slug($this->name);
        }
    }

    protected function rules(): array
    {
        return [
            'name'      => ['required', 'string', 'max:60'],
            'slug'      => ['nullable', 'string', 'max:80', Rule::unique('tags', 'slug')->ignore($this->tagId)],
            'is_active' => ['boolean'],
        ];
    }

    protected array $messages = [
        'name.required' => 'Nama tag wajib diisi.',
        'name.max'      => 'Nama tag maksimal 60 karakter.',
        'slug.unique'   => 'Slug tag sudah digunakan.',
    ];

    public function save(): void
    {
        $data = $this->validate();

        if (blank($data['slug']) && filled($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        if ($this->isEditing) {
            Tag::findOrFail($this->tagId)->update($data);
            $this->dispatch('toast:success', message: 'Tag diperbarui!');
        } else {
            Tag::create($data);
            $this->dispatch('toast:success', message: 'Tag ditambahkan!');
        }

        $this->showModal = false;
        $this->dispatch('tag:saved'); // untuk refresh list
    }

    public function render()
    {
        return view('livewire.tag.tag-form');
    }
}
