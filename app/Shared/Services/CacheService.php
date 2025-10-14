<?php

namespace App\Shared\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class CacheService
{
    const DEFAULT_TTL = 3600;  // 1 hour
    const LONG_TTL    = 86400; // 24 hours
    const SHORT_TTL   = 300;   // 5 minutes

    /* ===========================
     |  USER / ROLE / PERMISSION
     |===========================*/
    public static function getUserRoles($userId, $ttl = self::DEFAULT_TTL)
    {
        return Cache::remember("user.{$userId}.roles", $ttl, function () use ($userId) {
            return \App\Domains\User\Models\User::find($userId)?->roles()->with('permissions')->get();
        });
    }

    public static function getUserPermissions($userId, $ttl = self::DEFAULT_TTL)
    {
        return Cache::remember("user.{$userId}.permissions", $ttl, function () use ($userId) {
            $user = \App\Domains\User\Models\User::find($userId);
            if (!$user) return collect();

            return $user->roles()
                ->with('permissions')
                ->get()
                ->pluck('permissions')
                ->flatten()
                ->where('is_active', true)
                ->unique('id')
                ->values();
        });
    }

    public static function getRolePermissions($roleId, $ttl = self::DEFAULT_TTL)
    {
        return Cache::remember("role.{$roleId}.permissions", $ttl, function () use ($roleId) {
            return \App\Domains\Role\Models\Role::find($roleId)?->permissions()->where('is_active', true)->get();
        });
    }

    public static function getActiveRoles($ttl = self::LONG_TTL)
    {
        return Cache::remember('roles.active', $ttl, function () {
            return \App\Domains\Role\Models\Role::where('is_active', true)
                ->orderBy('name')
                ->get();
        });
    }

    public static function getActivePermissions($ttl = self::LONG_TTL)
    {
        return Cache::remember('permissions.active', $ttl, function () {
            return \App\Domains\Permission\Models\Permission::where('is_active', true)
                ->orderBy('group')
                ->orderBy('name')
                ->get();
        });
    }

    public static function getPermissionsByGroup($ttl = self::LONG_TTL)
    {
        return Cache::remember('permissions.by_group', $ttl, function () {
            return \App\Domains\Permission\Models\Permission::where('is_active', true)
                ->orderBy('group')
                ->orderBy('name')
                ->get()
                ->groupBy('group');
        });
    }

    public static function clearUserCache($userId)
    {
        Cache::forget("user.{$userId}.roles");
        Cache::forget("user.{$userId}.permissions");
    }

    public static function clearRoleCache($roleId)
    {
        Cache::forget("role.{$roleId}.permissions");
        self::clearSystemCache();
    }

    public static function clearSystemCache()
    {
        Cache::forget('roles.active');
        Cache::forget('permissions.active');
        Cache::forget('permissions.by_group');
    }

    public static function clearAllUserCaches()
    {
        $pattern = 'user.*.roles';
        self::clearCacheByPattern($pattern);

        $pattern = 'user.*.permissions';
        self::clearCacheByPattern($pattern);
    }

    private static function clearCacheByPattern($pattern)
    {
        try {
            if (config('cache.default') === 'redis') {
                $prefix = config('cache.prefix') ? config('cache.prefix') . ':' : '';
                $keys = Redis::keys($prefix . $pattern);
                if (!empty($keys)) {
                    // phpredis menerima array keys
                    Redis::del($keys);
                }
            } else {
                // Fallback: driver non-redis tidak bisa pattern-delete
                Cache::flush();
            }
        } catch (\Exception $e) {
            Cache::flush();
        }
    }

    /* ===========================
     |  DASHBOARD
     |===========================*/
    public static function getDashboardStats($ttl = self::SHORT_TTL)
    {
        return Cache::remember('dashboard.stats', $ttl, function () {
            return [
                'total_users'        => \App\Domains\User\Models\User::count(),
                'active_users'       => \App\Domains\User\Models\User::where('is_active', true)->count(),
                'total_roles'        => \App\Domains\Role\Models\Role::count(),
                'active_roles'       => \App\Domains\Role\Models\Role::where('is_active', true)->count(),
                'total_permissions'  => \App\Domains\Permission\Models\Permission::count(),
                'recent_users'       => \App\Domains\User\Models\User::latest()->take(5)->get(),
            ];
        });
    }

    public static function clearDashboardCache()
    {
        Cache::forget('dashboard.stats');
    }

    /* ===========================
     |  SEJARAH (NEW)
     |===========================*/

    /** Helper: key detail & index */
    public static function keySejarahShow(int $id): string
    {
        return "sejarah.show.{$id}";
    }

    public static function keySejarahIndex(array $filters = []): string
    {
        ksort($filters);
        $hash = substr(sha1(json_encode($filters)), 0, 16);
        return "sejarah.index.{$hash}";
    }

    /**
     * Cache detail Sejarah by id.
     * Usage:
     *   CacheService::rememberSejarahShow($id, fn() => Sejarah::findOrFail($id));
     */
    public static function rememberSejarahShow(int $id, \Closure $resolver, int $ttl = self::DEFAULT_TTL)
    {
        $key = self::keySejarahShow($id);
        return Cache::remember($key, $ttl, $resolver);
    }

    /**
     * Cache list/pagination Sejarah (berbasis filters + halaman).
     * $filters contoh:
     *   ['q' => 'keyword', 'inactive' => false, 'sort' => 'created_at:desc', 'page' => 1, 'per_page' => 10]
     */
    public static function rememberSejarahIndex(array $filters, \Closure $resolver, int $ttl = self::DEFAULT_TTL)
    {
        $key = self::keySejarahIndex($filters);
        return Cache::remember($key, $ttl, $resolver);
    }

    /** Hapus cache detail item */
    public static function clearSejarahShow(int $id): void
    {
        Cache::forget(self::keySejarahShow($id));
    }

    /**
     * Hapus semua cache index Sejarah (semua halaman/filters).
     * - Redis: pattern delete "sejarah.index.*"
     * - Non-redis: Cache::flush() (fallback)
     */
    public static function clearSejarahIndex(): void
    {
        self::clearCacheByPattern('sejarah.index.*');
    }

    /**
     * Invalidate cache Sejarah.
     * - Jika $id diberikan: hapus detail item + seluruh index.
     * - Jika $id null: hanya hapus index (berguna setelah mass update).
     */
    public static function clearSejarahCache(int $id = null): void
    {
        if ($id !== null) {
            self::clearSejarahShow($id);
        }
        self::clearSejarahIndex();
    }
}
