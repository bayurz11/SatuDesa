<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class CacheService
{
    const DEFAULT_TTL = 3600; // 1 hour
    const LONG_TTL = 86400; // 24 hours
    const SHORT_TTL = 300; // 5 minutes

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
            if (!$user) {
                return collect();
            }

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
                $keys = Redis::keys(config('cache.prefix') . ':' . $pattern);
                if (!empty($keys)) {
                    Redis::del($keys);
                }
            } else {
                // For other cache drivers, we'll need to clear all cache
                Cache::flush();
            }
        } catch (\Exception $e) {
            // Fallback to cache flush if pattern deletion fails
            Cache::flush();
        }
    }

    public static function getDashboardStats($ttl = self::SHORT_TTL)
    {
        return Cache::remember('dashboard.stats', $ttl, function () {
            return [
                'total_users' => \App\Domains\User\Models\User::count(),
                'active_users' => \App\Domains\User\Models\User::where('is_active', true)->count(),
                'total_roles' => \App\Domains\Role\Models\Role::count(),
                'active_roles' => \App\Domains\Role\Models\Role::where('is_active', true)->count(),
                'total_permissions' => \App\Domains\Permission\Models\Permission::count(),
                'recent_users' => \App\Domains\User\Models\User::latest()->take(5)->get(),
            ];
        });
    }

    public static function getSystemHealth($ttl = 60): array
    {
        return Cache::remember('dashboard.system_health', $ttl, function () {
            $checks = [
                'database' => self::checkDatabaseHealth(),
                'cache' => self::checkCacheHealth(),
                'session' => self::checkSessionHealth(),
            ];

            $failedChecks = collect($checks)->filter(fn (array $check) => ! $check['ok']);

            if ($failedChecks->count() === count($checks)) {
                $status = 'offline';
                $label = 'System Offline';
                $color = 'red';
            } elseif ($failedChecks->isNotEmpty()) {
                $status = 'degraded';
                $label = 'System Degraded';
                $color = 'yellow';
            } else {
                $status = 'online';
                $label = 'System Online';
                $color = 'green';
            }

            return [
                'status' => $status,
                'label' => $label,
                'color' => $color,
                'checks' => $checks,
                'summary' => $failedChecks->isEmpty()
                    ? 'All systems operational'
                    : 'Issue detected in: '.$failedChecks->keys()->implode(', '),
            ];
        });
    }

    public static function clearDashboardCache()
    {
        Cache::forget('dashboard.stats');
        Cache::forget('dashboard.system_health');
    }

    private static function checkDatabaseHealth(): array
    {
        try {
            DB::select('select 1');

            return ['ok' => true, 'label' => 'Database connected'];
        } catch (\Throwable $e) {
            return ['ok' => false, 'label' => 'Database unavailable'];
        }
    }

    private static function checkCacheHealth(): array
    {
        try {
            $key = 'health-check:cache';
            Cache::put($key, 'ok', 30);
            $value = Cache::get($key);
            Cache::forget($key);

            return [
                'ok' => $value === 'ok',
                'label' => $value === 'ok' ? 'Cache responding' : 'Cache unavailable',
            ];
        } catch (\Throwable $e) {
            return ['ok' => false, 'label' => 'Cache unavailable'];
        }
    }

    private static function checkSessionHealth(): array
    {
        $driver = config('session.driver', 'unknown');

        return [
            'ok' => ! empty($driver) && $driver !== 'array',
            'label' => 'Session driver: '.$driver,
        ];
    }
}
