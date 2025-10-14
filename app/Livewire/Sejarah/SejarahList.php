<?php

namespace App\Livewire\Sejarah;

use Livewire\Component;
use Livewire\WithPagination;
use App\Shared\Traits\WithAlerts;
use App\Shared\Services\CacheService;
use App\Shared\Services\LoggerService;
use App\Domains\Sejarah\Models\Sejarah;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SejarahList extends Component
{
    use WithPagination, WithAlerts;

    /** UI state */
    public string $search = '';
    public bool $showInactive = false;
    public int $perPage = 10;
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';

    /** Guards */
    protected array $allowedSorts = ['isi', 'created_at', 'updated_at', 'is_active'];
    protected array $allowedPerPage = [10, 25, 50];

    /** Keep URL in sync */
    protected $queryString = [
        'search'        => ['except' => ''],
        'showInactive'  => ['except' => false],
        'perPage'       => ['except' => 10],
        'sortField'     => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function mount(): void
    {
        if (!in_array($this->sortField, $this->allowedSorts, true)) $this->sortField = 'created_at';
        $this->sortDirection = strtolower($this->sortDirection) === 'asc' ? 'asc' : 'desc';
        if (!in_array($this->perPage, $this->allowedPerPage, true)) $this->perPage = 10;
    }

    /** Pagination resets ketika filter berubah */
    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    public function updatingShowInactive(): void
    {
        $this->resetPage();
    }
    public function updatingPerPage(): void
    {
        if (!in_array($this->perPage, $this->allowedPerPage, true)) $this->perPage = 10;
        $this->resetPage();
    }

    /** Sorting */
    public function sortBy(string $field): void
    {
        if (!in_array($field, $this->allowedSorts, true)) return;

        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    /** Toggle aktif/nonaktif — terima id/array/model */
    public function toggleSejarahStatus($payload): void
    {
        [$sejarah] = $this->normalizeSejarahPayload($payload);

        $oldStatus = (bool) $sejarah->is_active;
        $newStatus = !$oldStatus;

        $sejarah->update(['is_active' => $newStatus]);

        LoggerService::logUserAction(
            'toggle_status',
            'Sejarah',
            $sejarah->getKey(),
            [
                'old_status'  => $oldStatus,
                'new_status'  => $newStatus,
                'isi_preview' => Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($sejarah->isi))), 80),
            ]
        );

        CacheService::clearSejarahCache($sejarah->getKey());
        CacheService::clearDashboardCache();

        $this->resetPage();
        $this->dispatch('$refresh');
        $this->showSuccessToast('Sejarah ' . ($newStatus ? 'activated' : 'deactivated') . ' successfully!');
    }


    // /** Step 2: dieksekusi setelah user menekan "Yes" di modal konfirmasi */
    public function performDeleteSejarah($payload = null): void
    {
        [$sejarah] = $this->normalizeSejarahPayload($payload);

        LoggerService::logUserAction(
            'delete',
            'Sejarah',
            $sejarah->getKey(),
            [
                'deleted_isi_preview' => Str::limit(
                    trim(preg_replace('/\s+/', ' ', strip_tags($sejarah->isi))),
                    120
                ),
                'deleted_tanggal' => optional($sejarah->tanggal)->toDateString(),
                'deleted_gambar'  => $sejarah->gambar,
            ],
            'warning'
        );

        CacheService::clearSejarahCache($sejarah->getKey());
        CacheService::clearDashboardCache();

        if ($sejarah->gambar && Storage::disk('public')->exists($sejarah->gambar)) {
            Storage::disk('public')->delete($sejarah->gambar);
        }

        $sejarah->delete();

        $this->resetPage();
        $this->dispatch('$refresh');
        $this->showSuccessToast('Sejarah deleted successfully!');
    }

    /**
     * Helper normalizer: (Sejarah|int|array) => [Sejarah $model]
     * Menoleransi variasi key: sejarahId | id | sejarah_id
     */
    protected function normalizeSejarahPayload($payload): array
    {
        if ($payload instanceof Sejarah) {
            return [$payload->withoutRelations()];
        }

        if (is_numeric($payload)) {
            return [Sejarah::findOrFail((int) $payload)];
        }

        if (is_array($payload)) {
            $id = (int) ($payload['sejarahId'] ?? $payload['id'] ?? $payload['sejarah_id'] ?? 0);
            return [Sejarah::findOrFail($id)];
        }

        abort(422, 'Invalid payload.');
    }

    /** Query dasar */
    protected function baseQuery()
    {
        return Sejarah::query()
            ->select(['id', 'isi', 'gambar', 'is_active', 'created_at', 'updated_at'])
            ->when($this->search !== '', function ($query) {
                $term = trim($this->search);
                $query->where(function ($q) use ($term) {
                    $q->where('isi', 'like', "%{$term}%")
                        ->orWhere('gambar', 'like', "%{$term}%");
                });
            })
            ->when(!$this->showInactive, fn($q) => $q->where('is_active', true));
    }

    public function render()
    {
        if (!in_array($this->sortField, $this->allowedSorts, true)) $this->sortField = 'created_at';
        $this->sortDirection = $this->sortDirection === 'asc' ? 'asc' : 'desc';
        if (!in_array($this->perPage, $this->allowedPerPage, true)) $this->perPage = 10;

        $sejarah = $this->baseQuery()
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.sejarah.sejarah-list', compact('sejarah'));
    }
}
