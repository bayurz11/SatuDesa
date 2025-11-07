<?php

namespace App\Livewire\Category;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Domains\Category\Models\Category;

class CategoryForm extends Component
{
    // UI state
    public bool $showModal = false;
    public bool $isEditing = false;

    // Data
    public ?string $categoryId = null; // ULID
    public string $name = '';
    public string $slug = '';
    public ?string $description = null;
    public bool $is_active = true;
    public int $sort_order = 0;

    protected $listeners = [
        'openCategoryForm' => 'showModal',
    ];

    public function showModal(?string $id = null): void
    {
        $this->resetValidation();

        if ($id) {
            $cat = Category::findOrFail($id);
            $this->categoryId  = $cat->id;
            $this->name        = $cat->name;
            $this->slug        = $cat->slug ?? '';
            $this->description = $cat->description;
            $this->is_active   = (bool) $cat->is_active;
            $this->sort_order  = (int)  $cat->sort_order;
            $this->isEditing   = true;
        } else {
            $this->reset(['categoryId', 'name', 'slug', 'description', 'is_active', 'sort_order']);
            $this->is_active   = true;
            $this->sort_order  = 0;
            $this->isEditing   = false;
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
            'name'        => ['required', 'string', 'max:120'],
            'slug'        => ['nullable', 'string', 'max:140', Rule::unique('post_categories', 'slug')->ignore($this->categoryId)],
            'description' => ['nullable', 'string'],
            'is_active'   => ['boolean'],
            'sort_order'  => ['integer', 'min:0', 'max:65535'],
        ];
    }

    protected array $messages = [
        'name.required' => 'Nama kategori wajib diisi.',
        'name.max'      => 'Nama kategori maksimal 120 karakter.',
        'slug.unique'   => 'Slug sudah digunakan.',
    ];

    public function save(): void
    {
        $data = $this->validate();

        if (blank($data['slug']) && filled($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        if ($this->isEditing) {
            Category::findOrFail($this->categoryId)->update($data);
            // Livewire v3 DOM event
            $this->dispatch('toast:success', message: 'Kategori diperbarui!');
        } else {
            Category::create($data);
            $this->dispatch('toast:success', message: 'Kategori ditambahkan!');
        }

        $this->showModal = false;
        // refresh list
        $this->dispatch('post-category:saved');
    }

    public function render()
    {
        return view('livewire.category.category-form');
    }
}
