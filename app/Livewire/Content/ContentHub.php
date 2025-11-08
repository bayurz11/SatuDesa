<?php

namespace App\Livewire\Content;

use Livewire\Component;
use Livewire\WithPagination;
use App\Domains\Post\Models\Post;
use App\Domains\Category\Models\Category;

class ContentHub extends Component
{
    use WithPagination;

    /** @var 'announcement'|'news'|'potensi' */
    public string $mode = 'announcement';

    // Filter UI
    public ?string $q = null;
    public ?string $category = null;
    public int $perPage = 10;
    public string $sortField = 'published_at';
    public string $sortDirection = 'desc';

    /** Kontrol tampil/tidaknya pagination dari luar (default: true) */
    public bool $showPagination = true;

    protected $queryString = [
        'q'             => ['except' => null],
        'category'      => ['except' => null],
        'perPage'       => ['except' => 10],
        'sortField'     => ['except' => 'published_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function mount(string $mode = 'announcement', bool $showPagination = true): void
    {
        $this->mode = in_array($mode, ['announcement', 'news', 'potensi'], true) ? $mode : 'announcement';

        // page size default per mode
        $this->perPage = match ($this->mode) {
            'news', 'potensi' => 6,
            'announcement'    => 3,
            default           => 10,
        };

        /**
         * Otomatis sembunyikan pagination jika sedang di halaman '/'
         * (nama route kamu adalah '/', sesuai contoh).
         * Kalau kamu panggil komponen dengan ['showPagination' => false],
         * itu tetap diprioritaskan.
         */
        $autoHideOnHome = request()->routeIs('beranda');     // atau: request()->is('/')
        $this->showPagination = $showPagination && ! $autoHideOnHome;
    }

    public function updatingQ()
    {
        $this->resetPage();
    }
    public function updatingCategory()
    {
        $this->resetPage();
    }
    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        $allowed = ['published_at', 'created_at', 'title'];
        if (! in_array($field, $allowed, true)) return;

        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    protected function baseQuery()
    {
        $q = Post::query()
            ->with(['category:id,name,slug', 'tags:id,name,slug'])
            ->where('status', 'published')
            ->when($this->mode !== 'potensi', fn($x) => $x->where('content_type', $this->mode))
            ->when($this->mode === 'potensi', fn($x) => $x->where('content_type', 'potensi'))
            ->when($this->q, function ($x) {
                $term = "%{$this->q}%";
                $x->where(function ($w) use ($term) {
                    $w->where('title', 'like', $term)
                        ->orWhere('summary', 'like', $term)
                        ->orWhere('body_html', 'like', $term);
                });
            })
            ->when($this->category, fn($x) => $x->where('category_id', $this->category))
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy($this->sortField, $this->sortDirection);

        return $q;
    }

    public function render()
    {
        $categories = Category::orderBy('sort_order')->get(['id', 'name']);
        $items = $this->baseQuery()->paginate($this->perPage);

        [$title, $subtitle] = match ($this->mode) {
            'announcement' => ['Pengumuman', 'Informasi & agenda resmi desa'],
            'news'         => ['Berita Desa', 'Kabar terbaru seputar Desa Mentuda'],
            'potensi'      => ['Potensi Desa', 'Ekonomi, wisata, pertanian, perikanan & kreatif'],
            default        => ['Konten', ''],
        };

        return view('livewire.content.content-hub', compact('items', 'categories', 'title', 'subtitle'))
            ->with('showPagination', $this->showPagination);
    }
}
