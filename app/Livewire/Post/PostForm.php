<?php

namespace App\Livewire\Post;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Domains\Tag\Models\Tag;
use Illuminate\Validation\Rule;
use App\Domains\Post\Models\Post;
use App\Shared\Traits\WithAlerts;
use Illuminate\Support\Facades\Storage;
use App\Domains\Category\Models\Category;

class PostForm extends Component
{
    use WithFileUploads, WithAlerts;

    public bool $showModal = false;
    public bool $isEditing = false;

    // fields umum
    public ?string $postId = null;
    public ?string $category_id = null;
    public string $content_type = 'announcement';
    public string $title = '';
    public string $slug = '';
    public ?string $summary = null;
    public ?string $body_html = null;

    // announcement
    public ?string $location = null;
    public ?string $organizer = null;
    public ?string $start_at = null;
    public ?string $end_at = null;
    public bool $is_all_day = false;

    // news
    public ?string $author_name = null;
    public ?int $read_minutes = null;
    public ?string $source_url = null;

    // === POTENSI (kolom eksplisit) ===
    public ?string $potensi_category = null;
    public ?float  $latitude = null;
    public ?float  $longitude = null;
    public ?string $address = null;
    public ?string $contact_name = null;
    public ?string $contact_phone = null;
    public ?int    $price_min = null;
    public ?int    $price_max = null;
    public ?string $external_link = null;

    // === META fleksibel (opsional) ===
    public array $meta = [
        'gallery' => [],
        'tags'    => [],
    ];

    // media & publish
    public $cover;                     // UploadedFile|null
    public ?string $cover_path = null; // "covers/xxxx.jpg" (relatif dari public/)
    public string $status = 'draft';
    public ?string $published_at = null;

    // tags pivot
    public array $tag_ids = [];

    // editor
    public string $editorId = ''; // penanda stabil untuk trix

    protected $listeners = ['openPostForm' => 'openForm'];

    public function openForm(?string $id = null): void
    {
        $this->resetValidation();

        // set sekali setiap buka modal
        $this->editorId = $this->editorId ?: Str::random(8);

        if ($id) {
            $post = Post::with('tags:id')->findOrFail($id);

            $this->fill($post->only([
                'id',
                'category_id',
                'content_type',
                'title',
                'slug',
                'summary',
                'body_html',
                'location',
                'organizer',
                'author_name',
                'read_minutes',
                'source_url',
                'cover_path',
                'status',
            ]));

            // waktu & publish
            $this->postId       = $post->id;
            $this->is_all_day   = (bool) $post->is_all_day;
            $this->start_at     = optional($post->start_at)->format('Y-m-d\TH:i');
            $this->end_at       = optional($post->end_at)->format('Y-m-d\TH:i');
            $this->published_at = optional($post->published_at)->format('Y-m-d\TH:i');

            // potensi
            $this->potensi_category = $post->potensi_category;
            $this->latitude         = $post->latitude ? (float) $post->latitude : null;
            $this->longitude        = $post->longitude ? (float) $post->longitude : null;
            $this->address          = $post->address;
            $this->contact_name     = $post->contact_name;
            $this->contact_phone    = $post->contact_phone;
            $this->price_min        = $post->price_min;
            $this->price_max        = $post->price_max;
            $this->external_link    = $post->external_link;
            $this->meta             = array_merge($this->meta, $post->meta ?? []);

            // tags
            $this->tag_ids      = $post->tags->pluck('id')->all();
            $this->isEditing    = true;
        } else {
            $this->reset([
                'postId',
                'category_id',
                'content_type',
                'title',
                'slug',
                'summary',
                'body_html',
                'location',
                'organizer',
                'author_name',
                'read_minutes',
                'source_url',
                'cover',
                'cover_path',
                'status',
                'start_at',
                'end_at',
                'is_all_day',
                'published_at',
                'tag_ids',
                // potensi
                'potensi_category',
                'latitude',
                'longitude',
                'address',
                'contact_name',
                'contact_phone',
                'price_min',
                'price_max',
                'external_link',
                'meta',
            ]);
            $this->content_type = 'announcement';
            $this->status       = 'draft';
            $this->isEditing    = false;
            $this->meta         = ['gallery' => [], 'tags' => []];
        }

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->editorId = '';
    }

    public function updatedTitle(): void
    {
        if (blank($this->slug)) $this->slug = Str::slug($this->title);
    }

    protected function rules(): array
    {
        return [
            'category_id'  => ['nullable', 'string'],
            'content_type' => ['required', Rule::in(['announcement', 'news', 'potensi'])],
            'title'        => ['required', 'string', 'max:200'],
            'slug'         => ['nullable', 'string', 'max:220', Rule::unique('posts', 'slug')->ignore($this->postId)],
            'summary'      => ['nullable', 'string'],
            'body_html'    => ['nullable', 'string'],

            // announcement
            'location'     => ['nullable', 'string', 'max:200'],
            'organizer'    => ['nullable', 'string', 'max:160'],
            'start_at'     => ['nullable', 'date'],
            'end_at'       => ['nullable', 'date', 'after_or_equal:start_at'],
            'is_all_day'   => ['boolean'],

            // news
            'author_name'  => ['nullable', 'string', 'max:160'],
            'read_minutes' => ['nullable', 'integer', 'min:0'],
            'source_url'   => ['nullable', 'url'],

            // potensi
            'potensi_category' => [Rule::requiredIf(fn() => $this->content_type === 'potensi'), 'nullable', 'string', 'max:100'],
            'latitude'         => ['nullable', 'numeric', 'between:-90,90'],
            'longitude'        => ['nullable', 'numeric', 'between:-180,180'],
            'address'          => ['nullable', 'string', 'max:200'],
            'contact_name'     => ['nullable', 'string', 'max:160'],
            'contact_phone'    => ['nullable', 'string', 'max:40'],
            'price_min'        => ['nullable', 'integer', 'min:0'],
            'price_max'        => ['nullable', 'integer', 'min:0', 'gte:price_min'],
            'external_link'    => ['nullable', 'url'],

            // meta opsional
            'meta'             => ['array'],
            'meta.gallery'     => ['array'],
            'meta.gallery.*'   => ['string', 'max:255'],
            'meta.tags'        => ['array'],
            'meta.tags.*'      => ['string', 'max:40'],

            // publish & tag & cover
            'status'       => ['required', Rule::in(['draft', 'scheduled', 'published', 'archived'])],
            'published_at' => ['nullable', 'date'],
            'tag_ids'      => ['array'],
            'tag_ids.*'    => ['string'],
            'cover'        => ['nullable', 'image', 'max:4096'],
        ];
    }

    public function save(): void
    {
        $data = $this->validate();

        if (blank($data['slug']) && filled($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // upload cover ke public/covers → simpan path relatif "covers/xxx.jpg"
        if ($this->cover) {
            Storage::disk('public_path')->makeDirectory('covers');

            $ext      = strtolower($this->cover->getClientOriginalExtension() ?: 'jpg');
            $namaFile = Str::random(16) . '.' . $ext;

            $relative = $this->cover->storeAs('covers', $namaFile, 'public_path'); // "covers/xxx.jpg"
            $data['cover_path'] = $relative;

            if ($this->isEditing && $this->cover_path) {
                $old = ltrim($this->cover_path, '/');
                if (Storage::disk('public_path')->exists($old)) {
                    Storage::disk('public_path')->delete($old);
                }
            }
        }

        // normalisasi tanggal
        $data['start_at']     = $this->start_at ?: null;
        $data['end_at']       = $this->end_at ?: null;
        $data['published_at'] = $this->published_at ?: null;

        // set kolom POTENSI
        $data['potensi_category'] = $this->potensi_category ?: null;
        $data['latitude']         = $this->latitude ?: null;
        $data['longitude']        = $this->longitude ?: null;
        $data['address']          = $this->address ?: null;
        $data['contact_name']     = $this->contact_name ?: null;
        $data['contact_phone']    = $this->contact_phone ?: null;
        $data['price_min']        = $this->price_min ?: null;
        $data['price_max']        = $this->price_max ?: null;
        $data['external_link']    = $this->external_link ?: null;

        // meta fleksibel
        $data['meta'] = $this->meta;

        if ($this->isEditing) {
            $post = Post::findOrFail($this->postId);
            $post->update($data);
        } else {
            $post = Post::create($data);
        }

        $post->tags()->sync($this->tag_ids ?? []);

        $this->showSuccessToast($this->isEditing ? 'Post diperbarui!' : 'Post ditambahkan!');
        $this->showModal = false;
        $this->editorId  = '';
        $this->dispatch('post:saved');
    }

    public function render()
    {
        $categories = Category::orderBy('name')->get(['id', 'name']);
        $tags       = Tag::active()->orderBy('name')->get(['id', 'name']);
        return view('livewire.post.post-form', compact('categories', 'tags'));
    }
}
