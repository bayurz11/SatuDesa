<?php

namespace App\Livewire\Content;

use Livewire\Component;
use Livewire\WithPagination;
use App\Domains\Post\Models\Post;
use App\Domains\Category\Models\Category;
use Illuminate\Support\Str;

class ContentHub extends Component
{
    use WithPagination;

    public string $mode = 'announcement';

    public string $search = '';
    public ?string $category = null;
    public ?string $potensiCategory = null; // ★ filter kategori potensi
    public int $perPage = 10;
    public string $sortField = 'published_at';
    public string $sortDirection = 'desc';

    /** Bisa di-set dari luar; default true */
    public bool $showPagination = true;

    /** 🔦 Khusus beranda: featured + 4 lainnya (tanpa paginasi) */
    public bool $homeSpotlight = false;
    public int $spotlightLimit = 5; // featured + 4

    protected $queryString = [
        'search'        => ['except' => ''],
        'category'      => ['except' => null],
        'potensiCategory' => ['except' => null], // ★
        'perPage'       => ['except' => 10],
        'sortField'     => ['except' => 'published_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    /** Reset page saat filter berubah */
    public function updatingSearch()
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
    public function updatingPotensiCategory()
    {
        $this->resetPage();
    } // ★

    public function sortBy(string $field): void
    {
        $allowed = ['published_at', 'created_at', 'title'];
        if (!in_array($field, $allowed, true)) return;

        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function paginationView()
    {
        return 'livewire.content.pagination.pagination';
    }

    protected function baseQuery()
    {
        return Post::query()
            ->with(['category:id,name,slug', 'tags:id,name,slug'])
            ->where('status', 'published')
            ->when($this->mode !== 'potensi', fn($q) => $q->where('content_type', $this->mode))
            ->when($this->mode === 'potensi', fn($q) => $q->where('content_type', 'potensi'))

            // 🔎 search
            ->when($this->search, function ($q) {
                // pakai scope search() jika ada
                if (method_exists(Post::query()->getModel(), 'scopeSearch')) {
                    $q->search($this->search);
                    return;
                }
                $t = '%' . $this->search . '%';
                $q->where(function ($w) use ($t) {
                    $w->where('title', 'like', $t)
                        ->orWhere('summary', 'like', $t)
                        ->orWhere('body_html', 'like', $t)
                        ->orWhereHas('tags', fn($tq) => $tq->where('name', 'like', $t))
                        ->orWhereHas('category', fn($cq) => $cq->where('name', 'like', $t));
                });

                // ★ untuk potensi: ikut cari di field potensi (jika ada di DB)
                if ($this->mode === 'potensi') {
                    $q->orWhere('potensi_category', 'like', $t)
                        ->orWhere('lokasi', 'like', $t)
                        ->orWhere('potensi_detail->deskripsi', 'like', $t)
                        ->orWhere('potensi_detail->subjudul', 'like', $t);
                }
            })

            // kategori umum
            ->when($this->category, fn($q) => $q->where('category_id', $this->category))

            // ★ filter kategori potensi spesifik
            ->when($this->mode === 'potensi' && $this->potensiCategory, function ($q) {
                $q->where('potensi_category', $this->potensiCategory);
            })

            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function mount(string $mode = 'announcement', bool $showPagination = true): void
    {
        $this->mode = in_array($mode, ['announcement', 'news', 'potensi'], true) ? $mode : 'announcement';

        $this->perPage = match ($this->mode) {
            'news', 'potensi' => 6, // sedikit dinaikkan untuk grid potensi
            'announcement'    => 5,
            default           => 6,
        };

        if (request()->filled('q') && empty($this->search)) {
            $this->search = (string) request()->query('q');
        }

        $isHome = request()->routeIs('beranda'); // sesuaikan jika beda
        // ✅ Spotlight hanya untuk beranda + mode news
        $this->homeSpotlight = $isHome && $this->mode === 'news';

        $this->showPagination = $showPagination && ! $this->homeSpotlight;
    }

    public function render()
    {
        // daftar kategori umum
        $categories = Category::orderBy('sort_order')->get(['id', 'name']);

        // ★ daftar kategori potensi unik untuk dropdown:
        $potensiCategories = [];
        if ($this->mode === 'potensi') {
            $potensiCategories = cache()->remember('potensi:categories', 300, function () {
                return Post::query()
                    ->where('content_type', 'potensi')
                    ->whereNotNull('potensi_category')
                    ->where('potensi_category', '!=', '')
                    ->distinct()
                    ->orderBy('potensi_category')
                    ->pluck('potensi_category')
                    ->toArray();
            });
        }

        // ✅ Spotlight (beranda + news)
        $spotlight = $this->homeSpotlight
            ? cache()->remember(
                "home:spotlight:{$this->mode}:{$this->spotlightLimit}:" . md5($this->search . '|' . $this->category),
                60,
                fn() => (clone $this->baseQuery())->take($this->spotlightLimit)->get()
            )
            : collect();

        $items = $this->homeSpotlight
            ? collect()
            : $this->baseQuery()->paginate($this->perPage);

        [$title, $subtitle] = match ($this->mode) {
            'announcement' => ['Pengumuman', 'Informasi & agenda resmi desa'],
            'news'         => ['Berita Desa', 'Kabar terbaru seputar Desa Mentuda'],
            'potensi'      => ['Potensi Desa', 'Ekonomi, wisata, pertanian, perikanan & kreatif'],
            default        => ['Konten', ''],
        };

        return view('livewire.content.content-hub', [
            'items'             => $items,
            'spotlight'         => $spotlight,
            'categories'        => $categories,
            'potensiCategories' => $potensiCategories, // ★
            'title'             => $title,
            'subtitle'          => $subtitle,
        ])
            ->with('showPagination', $this->showPagination)
            ->with('homeSpotlight', $this->homeSpotlight)
            ->with('mode', $this->mode);
    }
}
