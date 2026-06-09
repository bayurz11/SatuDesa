<?php

namespace App\Livewire\Admin\Audit;

use App\Domains\Audit\Models\AuditLog;
use App\Domains\Audit\Models\AuditLogRead;
use App\Shared\Traits\WithAlerts;
use Livewire\Attributes\On;
use Livewire\Component;

class NotificationDropdown extends Component
{
    use WithAlerts;

    public bool $open = false;

    #[On('postSaved')]
    #[On('potentialSaved')]
    #[On('userSaved')]
    #[On('roleSaved')]
    public function refreshNotifications(): void
    {
        // Trigger component re-render after CRUD activity.
    }

    public function toggleDropdown(): void
    {
        $this->open = ! $this->open;
    }

    public function closeDropdown(): void
    {
        $this->open = false;
    }

    protected function visibleEntities(): ?array
    {
        $user = auth()->user();

        if (! $user || ! $user->hasPermission('system.logs')) {
            return [];
        }

        if ($user->hasRole('super-admin')) {
            return null;
        }

        $entities = [];

        if ($user->hasAnyPermission(['posts.view', 'post_categories.view'])) {
            $entities = [...$entities, 'Post', 'PostCategory', 'Potential'];
        }

        if ($user->hasPermission('users.view')) {
            $entities[] = 'User';
        }

        if ($user->hasAnyPermission(['roles.view', 'permissions.view'])) {
            $entities = [...$entities, 'Role', 'Permission'];
        }

        return array_values(array_unique($entities));
    }

    protected function visibleLogIds()
    {
        $visibleEntities = $this->visibleEntities();

        return AuditLog::query()
            ->when($visibleEntities !== null, function ($query) use ($visibleEntities) {
                $query->where(function ($subQuery) use ($visibleEntities) {
                    $subQuery->whereIn('entity_type', $visibleEntities)
                        ->orWhereNull('entity_type');
                });
            })
            ->pluck('id');
    }

    public function markAllAsRead(): void
    {
        $user = auth()->user();

        if (! $user || ! $user->hasPermission('system.logs')) {
            return;
        }

        $timestamp = now();
        $existingReadIds = AuditLogRead::query()
            ->where('user_id', $user->id)
            ->pluck('audit_log_id');

        $rows = $this->visibleLogIds()
            ->diff($existingReadIds)
            ->map(fn ($auditLogId) => [
                'audit_log_id' => $auditLogId,
                'user_id' => $user->id,
                'read_at' => $timestamp,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ])
            ->values()
            ->all();

        if ($rows !== []) {
            AuditLogRead::insertOrIgnore($rows);
        }

        $this->showSuccessToast('Semua notifikasi berhasil ditandai dibaca.');
    }

    public function markAsRead(int $auditLogId): void
    {
        $user = auth()->user();

        if (! $user || ! $user->hasPermission('system.logs')) {
            return;
        }

        AuditLogRead::updateOrCreate(
            [
                'audit_log_id' => $auditLogId,
                'user_id' => $user->id,
            ],
            [
                'read_at' => now(),
            ]
        );
    }

    public function render()
    {
        $user = auth()->user();
        $visibleEntities = $this->visibleEntities();

        $logsQuery = AuditLog::query()
            ->with('user:id,name,email')
            ->when($visibleEntities !== null, function ($query) use ($visibleEntities) {
                $query->where(function ($subQuery) use ($visibleEntities) {
                    $subQuery->whereIn('entity_type', $visibleEntities)
                        ->orWhereNull('entity_type');
                });
            });

        $logs = (clone $logsQuery)
            ->withExists([
                'reads as is_read' => fn ($query) => $query->where('user_id', $user?->id),
            ])
            ->latest('logged_at')
            ->limit(6)
            ->get();

        $unreadCount = (clone $logsQuery)
            ->whereDoesntHave('reads', fn ($query) => $query->where('user_id', $user?->id))
            ->count();

        return view('livewire.admin.audit.notification-dropdown', compact('logs', 'unreadCount'));
    }
}
