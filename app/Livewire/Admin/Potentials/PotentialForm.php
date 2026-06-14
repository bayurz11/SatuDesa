<?php

namespace App\Livewire\Admin\Potentials;

use App\Livewire\Concerns\AuthorizesPermissions;
use App\Domains\Potential\Models\Potential;
use App\Domains\Potential\Models\PotentialCategory;
use App\Domains\Village\Models\Village;
use App\Services\LoggerService;
use App\Shared\Traits\WithAlerts;
use App\Support\StoredContentSanitizer;
use App\Support\UploadStorage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class PotentialForm extends Component
{
    use WithAlerts, WithFileUploads, AuthorizesPermissions;

    public $potentialId;
    public $village_id = '';
    public $category_id = '';
    public $title = '';
    public $slug = '';
    public $excerpt = '';
    public $content = '';
    public $cover_image = null;
    public $existing_cover_image_url = null;
    public $cover_image_alt = '';
    public $cover_image_caption = '';
    public $is_featured = false;
    public $potential_type = '';
    public $location_name = '';
    public $address = '';
    public $latitude = '';
    public $longitude = '';
    public $contact_person = '';
    public $contact_phone = '';
    public $facilities = '';
    public $opportunities = '';
    public $development_status = '';
    public $sort_order = 0;
    public $status = 'draft';
    public $published_at = '';
    public $showModal = false;
    public $isEditing = false;

    protected function rules()
    {
        return [
            'village_id' => 'required|exists:villages,id',
            'category_id' => 'nullable|exists:potential_categories,id',
            'title' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('potentials', 'slug')->ignore($this->potentialId),
            ],
            'excerpt' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:4096',
            'cover_image_alt' => 'nullable|string|max:255',
            'cover_image_caption' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'potential_type' => 'nullable|string|max:100',
            'location_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:2000',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'facilities' => 'nullable|string|max:2000',
            'opportunities' => 'nullable|string|max:2000',
            'development_status' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|in:draft,review,published',
            'published_at' => 'nullable|date',
        ];
    }

    public function mount($potentialId = null): void
    {
        $this->authorizePermission('system.settings');
        $this->village_id = (string) Village::query()->orderBy('name')->value('id');

        if (filled($potentialId)) {
            $this->loadPotential((int) $potentialId);
        }
    }

    public function updatedTitle($value): void
    {
        $this->slug = Str::slug($value);
        $this->cover_image_alt = $this->cover_image_alt ?: $value;
    }

    public function loadPotential(int $potentialId): void
    {
        $this->authorizePermission('system.settings');
        $potential = Potential::findOrFail($potentialId);

        $this->potentialId = $potential->id;
        $this->village_id = (string) $potential->village_id;
        $this->category_id = $potential->category_id ? (string) $potential->category_id : '';
        $this->title = $potential->title;
        $this->slug = $potential->slug;
        $this->excerpt = $potential->excerpt ?? '';
        $this->content = $potential->editor_content;
        $this->cover_image = null;
        $this->existing_cover_image_url = $potential->cover_image_url;
        $this->cover_image_alt = $potential->cover_image_alt ?? '';
        $this->cover_image_caption = $potential->cover_image_caption ?? '';
        $this->is_featured = (bool) $potential->is_featured;
        $this->potential_type = $potential->potential_type ?? '';
        $this->location_name = $potential->location_name ?? '';
        $this->address = $potential->address ?? '';
        $this->latitude = $potential->latitude ? (string) $potential->latitude : '';
        $this->longitude = $potential->longitude ? (string) $potential->longitude : '';
        $this->contact_person = $potential->contact_person ?? '';
        $this->contact_phone = $potential->contact_phone ?? '';
        $this->facilities = $potential->editor_facilities;
        $this->opportunities = $potential->editor_opportunities;
        $this->development_status = $potential->development_status ?? '';
        $this->sort_order = (int) $potential->sort_order;
        $this->status = $potential->status;
        $this->published_at = $potential->published_at?->format('Y-m-d\TH:i') ?? '';
        $this->isEditing = true;
    }

    #[On('openPotentialForm')]
    public function openModal($potentialId = null): void
    {
        $this->authorizePermission('system.settings');
        $this->resetForm();

        if (filled($potentialId)) {
            $this->loadPotential((int) $potentialId);
        }

        $this->showModal = true;
    }

    #[On('editPotential')]
    public function editPotential($potentialId = null): void
    {
        $this->openModal($potentialId);
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->potentialId = null;
        $this->village_id = (string) Village::query()->orderBy('name')->value('id');
        $this->category_id = '';
        $this->title = '';
        $this->slug = '';
        $this->excerpt = '';
        $this->content = '';
        $this->cover_image = null;
        $this->existing_cover_image_url = null;
        $this->cover_image_alt = '';
        $this->cover_image_caption = '';
        $this->is_featured = false;
        $this->potential_type = '';
        $this->location_name = '';
        $this->address = '';
        $this->latitude = '';
        $this->longitude = '';
        $this->contact_person = '';
        $this->contact_phone = '';
        $this->facilities = '';
        $this->opportunities = '';
        $this->development_status = '';
        $this->sort_order = 0;
        $this->status = 'draft';
        $this->published_at = '';
        $this->showModal = false;
        $this->isEditing = false;
        $this->resetErrorBag();
    }

    public function save(): void
    {
        $this->authorizePermission('system.settings');
        $this->slug = Str::slug($this->slug ?: $this->title);
        $this->validate();

        $potential = $this->isEditing ? Potential::findOrFail($this->potentialId) : new Potential();
        $coverImagePath = $potential->cover_image_path;

        if ($this->cover_image) {
            if ($coverImagePath) {
                Storage::disk(UploadStorage::disk())->delete($coverImagePath);
            }

            $coverImagePath = $this->cover_image->store('potentials/covers', UploadStorage::disk());
        }

        $publishedAt = $this->status === 'published'
            ? ($this->published_at ?: now()->format('Y-m-d\TH:i'))
            : null;

        $payload = [
            'village_id' => (int) $this->village_id,
            'category_id' => $this->category_id !== '' ? (int) $this->category_id : null,
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'content_raw' => $this->content,
            'content_safe' => StoredContentSanitizer::clean($this->content),
            'cover_image_path' => $coverImagePath,
            'cover_image_alt' => $this->cover_image_alt ?: $this->title,
            'cover_image_caption' => $this->cover_image_caption,
            'is_featured' => (bool) $this->is_featured,
            'potential_type' => $this->potential_type,
            'location_name' => $this->location_name,
            'address' => $this->address,
            'latitude' => $this->latitude !== '' ? $this->latitude : null,
            'longitude' => $this->longitude !== '' ? $this->longitude : null,
            'contact_person' => $this->contact_person,
            'contact_phone' => $this->contact_phone,
            'facilities' => $this->facilities,
            'facilities_raw' => $this->facilities,
            'facilities_safe' => StoredContentSanitizer::clean($this->facilities),
            'opportunities' => $this->opportunities,
            'opportunities_raw' => $this->opportunities,
            'opportunities_safe' => StoredContentSanitizer::clean($this->opportunities),
            'development_status' => $this->development_status,
            'sort_order' => (int) ($this->sort_order ?: 0),
            'status' => $this->status,
            'published_at' => $publishedAt,
        ];

        if ($this->isEditing) {
            $potential->update($payload);
        } else {
            $potential = Potential::create($payload);
        }

        LoggerService::logUserAction($this->isEditing ? 'update' : 'create', 'Potential', $potential->id, [
            'potential_title' => $potential->title,
            'status' => $potential->status,
            'is_featured' => (bool) $potential->is_featured,
        ]);

        $this->showSuccessToast($this->isEditing ? 'Potensi desa berhasil diperbarui.' : 'Potensi desa berhasil dibuat.');

        $this->closeModal();
        $this->dispatch('potentialSaved');
    }

    public function render()
    {
        $this->authorizePermission('system.settings');
        $villages = Village::query()->orderBy('name')->get(['id', 'name']);
        $categories = PotentialCategory::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('livewire.admin.potentials.potential-form', compact('villages', 'categories'));
    }
}
