@extends('layouts.app')

@section('content')
    @php
        $stats = \App\Services\CacheService::getDashboardStats();
        $systemHealth = \App\Services\CacheService::getSystemHealth();
        $monthlyLetterCounts = \Illuminate\Support\Facades\DB::table('letter_requests')
            ->selectRaw('YEAR(submitted_at) as year_number, MONTH(submitted_at) as month_number, COUNT(*) as total')
            ->whereNotNull('submitted_at')
            ->groupByRaw('YEAR(submitted_at), MONTH(submitted_at)')
            ->pluck('total', 'year_number');

        $monthlyLetterMap = \Illuminate\Support\Facades\DB::table('letter_requests')
            ->selectRaw('YEAR(submitted_at) as year_number, MONTH(submitted_at) as month_number, COUNT(*) as total')
            ->whereNotNull('submitted_at')
            ->groupByRaw('YEAR(submitted_at), MONTH(submitted_at)')
            ->get()
            ->mapWithKeys(fn ($item) => [sprintf('%04d-%02d', $item->year_number, $item->month_number) => (int) $item->total]);

        $monthlyComplaintMap = \Illuminate\Support\Facades\DB::table('complaints')
            ->selectRaw('YEAR(submitted_at) as year_number, MONTH(submitted_at) as month_number, COUNT(*) as total')
            ->whereNotNull('submitted_at')
            ->groupByRaw('YEAR(submitted_at), MONTH(submitted_at)')
            ->get()
            ->mapWithKeys(fn ($item) => [sprintf('%04d-%02d', $item->year_number, $item->month_number) => (int) $item->total]);

        $serviceTrendSets['monthly'] = collect(range(5, 0))
            ->map(function ($offset) use ($monthlyLetterMap, $monthlyComplaintMap) {
                $date = now()->copy()->startOfMonth()->subMonths($offset);
                $key = $date->format('Y-m');

                return [
                    'label' => $date->translatedFormat('M'),
                    'letters' => $monthlyLetterMap[$key] ?? 0,
                    'complaints' => $monthlyComplaintMap[$key] ?? 0,
                ];
            })
            ->values()
            ->all();

        $weeklyLetterMap = \Illuminate\Support\Facades\DB::table('letter_requests')
            ->selectRaw('DATE(submitted_at) as submitted_date, COUNT(*) as total')
            ->where('submitted_at', '>=', now()->copy()->startOfDay()->subDays(41))
            ->groupByRaw('DATE(submitted_at)')
            ->get()
            ->mapWithKeys(fn ($item) => [$item->submitted_date => (int) $item->total]);

        $weeklyComplaintMap = \Illuminate\Support\Facades\DB::table('complaints')
            ->selectRaw('DATE(submitted_at) as submitted_date, COUNT(*) as total')
            ->where('submitted_at', '>=', now()->copy()->startOfDay()->subDays(41))
            ->groupByRaw('DATE(submitted_at)')
            ->get()
            ->mapWithKeys(fn ($item) => [$item->submitted_date => (int) $item->total]);

        $serviceTrendSets['weekly'] = collect(range(5, 0))
            ->map(function ($offset) use ($weeklyLetterMap, $weeklyComplaintMap) {
                $weekStart = now()->copy()->startOfWeek()->subWeeks($offset);
                $weekDates = collect(range(0, 6))->map(fn ($dayOffset) => $weekStart->copy()->addDays($dayOffset)->toDateString());

                return [
                    'label' => 'W' . (6 - $offset),
                    'letters' => $weekDates->sum(fn ($date) => $weeklyLetterMap[$date] ?? 0),
                    'complaints' => $weekDates->sum(fn ($date) => $weeklyComplaintMap[$date] ?? 0),
                ];
            })
            ->values()
            ->all();

        $recentAuditLogs = \App\Domains\Audit\Models\AuditLog::query()
            ->with('user:id,name,email')
            ->latest('logged_at')
            ->take(5)
            ->get();

        $contentStats = [
            'total_posts' => \App\Domains\Post\Models\Post::count(),
            'published_posts' => \App\Domains\Post\Models\Post::where('status', 'published')->count(),
            'total_potentials' => \App\Domains\Potential\Models\Potential::count(),
            'featured_potentials' => \App\Domains\Potential\Models\Potential::where('is_featured', true)->count(),
            'published_potentials' => \App\Domains\Potential\Models\Potential::where('status', 'published')->count(),
        ];

        $contentTrendSets['monthly'] = collect(range(5, 0))
            ->map(function ($offset) {
                $start = now()->copy()->startOfMonth()->subMonths($offset);
                $end = $start->copy()->endOfMonth();

                return [
                    'label' => $start->translatedFormat('M'),
                    'posts' => \App\Domains\Analytics\Models\PostView::query()
                        ->whereBetween('viewed_at', [$start, $end])
                        ->distinct('visitor_token')
                        ->count('visitor_token'),
                    'potentials' => \App\Domains\Analytics\Models\WebsiteVisit::query()
                        ->where('path', '/potensi-desa')
                        ->whereBetween('visited_at', [$start, $end])
                        ->distinct('visitor_token')
                        ->count('visitor_token'),
                ];
            })
            ->values()
            ->all();

        $contentTrendSets['weekly'] = collect(range(5, 0))
            ->map(function ($offset) {
                $weekStart = now()->copy()->startOfWeek()->subWeeks($offset);
                $weekEnd = $weekStart->copy()->endOfWeek();

                return [
                    'label' => 'W' . (6 - $offset),
                    'posts' => \App\Domains\Analytics\Models\PostView::query()
                        ->whereBetween('viewed_at', [$weekStart, $weekEnd])
                        ->distinct('visitor_token')
                        ->count('visitor_token'),
                    'potentials' => \App\Domains\Analytics\Models\WebsiteVisit::query()
                        ->where('path', '/potensi-desa')
                        ->whereBetween('visited_at', [$weekStart, $weekEnd])
                        ->distinct('visitor_token')
                        ->count('visitor_token'),
                ];
            })
            ->values()
            ->all();

        $topViewedPost = \App\Domains\Post\Models\Post::query()
            ->select('posts.id', 'posts.title', 'posts.slug')
            ->leftJoin('post_views', 'post_views.post_id', '=', 'posts.id')
            ->groupBy('posts.id', 'posts.title', 'posts.slug')
            ->orderByRaw('COUNT(DISTINCT post_views.visitor_token) DESC')
            ->orderByDesc('posts.published_at')
            ->first();

        $topViewedPostReaders = $topViewedPost
            ? \App\Domains\Analytics\Models\PostView::query()
                ->where('post_id', $topViewedPost->id)
                ->distinct('visitor_token')
                ->count('visitor_token')
            : 0;
    @endphp
    <div class="space-y-8 animate-fadeInUp">
        <!-- Modern Welcome Section with Glassmorphism -->
        <div
            class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 rounded-2xl shadow-2xl overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 bg-white/10 backdrop-blur-sm">
                <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent"></div>
                <div class="absolute top-0 left-0 w-full h-full">
                    <div class="absolute top-1/4 left-1/4 w-32 h-32 bg-white/10 rounded-full blur-xl"></div>
                    <div class="absolute bottom-1/4 right-1/4 w-24 h-24 bg-white/20 rounded-full blur-lg"></div>
                </div>
            </div>

            <div class="relative p-8 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h1
                            class="text-4xl font-bold mb-3 bg-gradient-to-r from-white to-blue-100 bg-clip-text text-transparent">
                            Welcome back, {{ auth()->user()->name }}!
                        </h1>
                        <p class="text-xl text-blue-100 mb-4">Here's what's happening with your system today.</p>
                        <div class="flex items-center space-x-4 text-sm text-blue-200">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ now()->format('l, F j, Y') }}
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $systemHealth['label'] }}
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="group relative bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-200 hover:shadow-2xl hover:border-orange-300 transition-all duration-300 transform hover:-translate-y-1 animate-slideInRight"
                style="animation-delay: 0.05s">
                <div class="absolute inset-0 bg-gradient-to-br from-orange-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A3.375 3.375 0 0011.25 11.625v2.625m8.25 0v3a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-3m13.5 0H6m13.5 0a2.25 2.25 0 00-2.25-2.25H8.25A2.25 2.25 0 006 14.25" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-600 mb-1">Total Artikel</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ number_format($contentStats['total_posts']) }}</p>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-orange-500 rounded-full"></div>
                                    <span class="text-sm text-orange-600 font-semibold">{{ $contentStats['published_posts'] }} publish</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="group relative bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-200 hover:shadow-2xl hover:border-rose-300 transition-all duration-300 transform hover:-translate-y-1 animate-slideInRight"
                style="animation-delay: 0.1s">
                <div class="absolute inset-0 bg-gradient-to-br from-rose-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gradient-to-br from-rose-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-600 mb-1">Draft Artikel</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ number_format(max($contentStats['total_posts'] - $contentStats['published_posts'], 0)) }}</p>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-rose-500 rounded-full"></div>
                                    <span class="text-sm text-rose-600 font-semibold">Menunggu publikasi</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="group relative bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-200 hover:shadow-2xl hover:border-emerald-300 transition-all duration-300 transform hover:-translate-y-1 animate-slideInRight"
                style="animation-delay: 0.15s">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21c4.97-4.97 7.5-8.328 7.5-10.5a7.5 7.5 0 1 0-15 0c0 2.172 2.53 5.53 7.5 10.5Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12.75a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-600 mb-1">Total Potensi</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ number_format($contentStats['total_potentials']) }}</p>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                                    <span class="text-sm text-emerald-600 font-semibold">{{ $contentStats['featured_potentials'] }} unggulan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="group relative bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-200 hover:shadow-2xl hover:border-cyan-300 transition-all duration-300 transform hover:-translate-y-1 animate-slideInRight"
                style="animation-delay: 0.2s">
                <div class="absolute inset-0 bg-gradient-to-br from-cyan-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-600 mb-1">Potensi Publish</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ number_format($contentStats['published_potentials']) }}</p>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-cyan-500 rounded-full"></div>
                                    <span class="text-sm text-cyan-600 font-semibold">Siap tampil publik</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modern Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Users Card -->
            <div class="group relative bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-200 hover:shadow-2xl hover:border-blue-300 transition-all duration-300 transform hover:-translate-y-1 animate-slideInRight"
                style="animation-delay: 0.1s">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-blue-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">

                                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                        </svg>

                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-600 mb-1">Total Users</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_users']) }}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                    <span class="text-sm text-green-600 font-semibold">{{ $stats['active_users'] }}
                                        active</span>
                                </div>
                                <div class="flex items-center text-xs text-gray-500">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                    +12% this month
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Roles Card -->
            <div class="group relative bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-200 hover:shadow-2xl hover:border-green-300 transition-all duration-300 transform hover:-translate-y-1 animate-slideInRight"
                style="animation-delay: 0.2s">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-green-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-600 mb-1">Total Roles</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_roles']) }}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                    <span class="text-sm text-green-600 font-semibold">{{ $stats['active_roles'] }}
                                        active</span>
                                </div>
                                <div class="flex items-center text-xs text-gray-500">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    All secure
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Permissions Card -->
            <div class="group relative bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-200 hover:shadow-2xl hover:border-purple-300 transition-all duration-300 transform hover:-translate-y-1 animate-slideInRight"
                style="animation-delay: 0.3s">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-purple-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-600 mb-1">Permissions</p>
                                    <p class="text-2xl font-bold text-gray-900">
                                        {{ number_format($stats['total_permissions']) }}</p>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                                    <span class="text-sm text-purple-600 font-semibold">System wide</span>
                                </div>
                                <div class="flex items-center text-xs text-gray-500">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                        </path>
                                    </svg>
                                    Protected
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Your Roles Card -->
            <div class="group relative bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-200 hover:shadow-2xl hover:border-yellow-300 transition-all duration-300 transform hover:-translate-y-1 animate-slideInRight"
                style="animation-delay: 0.4s">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-yellow-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-600 mb-1">Your Roles</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ auth()->user()->roles->count() }}</p>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                                    <span class="text-sm text-yellow-600 font-semibold">Personal</span>
                                </div>
                                <div class="flex items-center text-xs text-gray-500">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                    {{ auth()->user()->name }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-slate-50 via-orange-50 to-emerald-50 px-6 py-5 border-b border-gray-200">
                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Tren Berita Desa & Potensi Desa</h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Pengunjung unik pada detail berita dan halaman potensi desa dalam tampilan mingguan atau bulanan.
                        </p>
                        <p class="mt-2 text-xs font-medium text-slate-500">
                            Artikel terbanyak dibaca:
                            <span class="font-semibold text-slate-700">
                                {{ $topViewedPost?->title ? \Illuminate\Support\Str::limit($topViewedPost->title, 48) : 'Belum ada data' }}
                            </span>
                            @if ($topViewedPost)
                                <span class="text-orange-600">({{ $topViewedPostReaders }} pembaca unik)</span>
                            @endif
                        </p>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <button type="button" data-content-range="monthly"
                            class="content-range-toggle inline-flex items-center rounded-full border border-orange-200 bg-white px-4 py-2 text-sm font-semibold text-orange-700 shadow-sm transition hover:border-orange-300 hover:bg-orange-50">
                            Bulanan
                        </button>
                        <button type="button" data-content-range="weekly"
                            class="content-range-toggle inline-flex items-center rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
                            Mingguan
                        </button>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 gap-4 xl:grid-cols-[minmax(0,1fr)_300px]">
                    <div class="rounded-2xl border border-slate-200 bg-gradient-to-br from-white via-slate-50 to-orange-50/60 p-4">
                        <div class="mb-4 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                            <div class="flex flex-wrap items-center gap-2">
                                <button type="button" data-content-series="posts"
                                    class="content-series-toggle inline-flex items-center gap-2 rounded-full border border-orange-200 bg-orange-50 px-4 py-2 text-sm font-semibold text-orange-700 transition hover:bg-orange-100">
                                    <span class="h-2.5 w-2.5 rounded-full bg-orange-500"></span>
                                    Artikel
                                </button>
                                <button type="button" data-content-series="potentials"
                                    class="content-series-toggle inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-100">
                                    <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                                    Potensi Desa
                                </button>
                            </div>
                            <div class="text-xs font-medium uppercase tracking-[0.24em] text-slate-400">
                                Klik legenda untuk tampilkan atau sembunyikan seri
                            </div>
                        </div>

                        <div class="relative overflow-hidden rounded-2xl border border-white/80 bg-white/70 p-3 shadow-inner shadow-slate-100">
                            <svg id="dashboard-content-chart" viewBox="0 0 860 360" class="w-full h-auto"></svg>

                            <div id="dashboard-content-tooltip"
                                class="pointer-events-none absolute hidden min-w-52 rounded-2xl border border-slate-200 bg-white/95 px-4 py-3 shadow-2xl backdrop-blur-sm">
                                <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400"
                                    data-content-tooltip-label></div>
                                <div class="mt-3 flex items-center justify-between gap-4 text-sm">
                                    <span class="text-slate-600">Artikel</span>
                                    <span class="font-semibold text-orange-600" data-content-tooltip-posts></span>
                                </div>
                                <div class="mt-1 flex items-center justify-between gap-4 text-sm">
                                    <span class="text-slate-600">Potensi</span>
                                    <span class="font-semibold text-emerald-600" data-content-tooltip-potentials></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 xl:grid-cols-1">
                        <div class="rounded-2xl border border-orange-100 bg-gradient-to-br from-orange-50 to-white p-5 shadow-sm">
                            <div class="text-xs font-semibold uppercase tracking-[0.2em] text-orange-500">Pembaca Artikel</div>
                            <div class="mt-2 text-3xl font-bold text-slate-900" data-content-summary-posts>0</div>
                            <div class="mt-1 text-sm text-slate-500">Jumlah pembaca unik detail berita pada periode aktif.</div>
                        </div>
                        <div class="rounded-2xl border border-emerald-100 bg-gradient-to-br from-emerald-50 to-white p-5 shadow-sm">
                            <div class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-500">Akses Potensi</div>
                            <div class="mt-2 text-3xl font-bold text-slate-900" data-content-summary-potentials>0</div>
                            <div class="mt-1 text-sm text-slate-500">Jumlah pengunjung unik halaman potensi desa pada periode aktif.</div>
                        </div>
                        <div class="rounded-2xl border border-amber-100 bg-gradient-to-br from-amber-50 to-white p-5 shadow-sm">
                            <div class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-500">Puncak Akses</div>
                            <div class="mt-2 text-xl font-bold text-slate-900" data-content-summary-peak-label>-</div>
                            <div class="mt-1 text-sm text-amber-700">
                                <span data-content-summary-peak-value>0</span>
                                pengunjung tertinggi pada seri yang aktif.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-slate-50 via-blue-50 to-cyan-50 px-6 py-5 border-b border-gray-200">
                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Tren Layanan Desa</h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Ringkasan layanan surat dan pengaduan dengan tampilan mingguan atau bulanan.
                        </p>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <button type="button" data-chart-range="monthly"
                            class="dashboard-range-toggle inline-flex items-center rounded-full border border-blue-200 bg-white px-4 py-2 text-sm font-semibold text-blue-700 shadow-sm transition hover:border-blue-300 hover:bg-blue-50">
                            Bulanan
                        </button>
                        <button type="button" data-chart-range="weekly"
                            class="dashboard-range-toggle inline-flex items-center rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
                            Mingguan
                        </button>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 gap-4 xl:grid-cols-[minmax(0,1fr)_300px]">
                    <div
                        class="rounded-2xl border border-slate-200 bg-gradient-to-br from-white via-slate-50 to-blue-50/60 p-4">
                        <div class="mb-4 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                            <div class="flex flex-wrap items-center gap-2">
                                <button type="button" data-chart-series="letters"
                                    class="dashboard-series-toggle inline-flex items-center gap-2 rounded-full border border-blue-200 bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-100">
                                    <span class="h-2.5 w-2.5 rounded-full bg-blue-500"></span>
                                    Surat
                                </button>
                                <button type="button" data-chart-series="complaints"
                                    class="dashboard-series-toggle inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-100">
                                    <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                                    Pengaduan
                                </button>
                            </div>
                            <div class="text-xs font-medium uppercase tracking-[0.24em] text-slate-400">
                                Klik legenda untuk tampilkan atau sembunyikan seri
                            </div>
                        </div>

                        <div
                            class="relative overflow-hidden rounded-2xl border border-white/80 bg-white/70 p-3 shadow-inner shadow-slate-100">
                            <svg id="dashboard-service-chart" viewBox="0 0 860 360" class="w-full h-auto"></svg>

                            <div id="dashboard-chart-tooltip"
                                class="pointer-events-none absolute hidden min-w-52 rounded-2xl border border-slate-200 bg-white/95 px-4 py-3 shadow-2xl backdrop-blur-sm">
                                <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400"
                                    data-tooltip-label></div>
                                <div class="mt-3 flex items-center justify-between gap-4 text-sm">
                                    <span class="text-slate-600">Surat</span>
                                    <span class="font-semibold text-blue-600" data-tooltip-letters></span>
                                </div>
                                <div class="mt-1 flex items-center justify-between gap-4 text-sm">
                                    <span class="text-slate-600">Pengaduan</span>
                                    <span class="font-semibold text-emerald-600" data-tooltip-complaints></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 xl:grid-cols-1">
                        <div
                            class="rounded-2xl border border-blue-100 bg-gradient-to-br from-blue-50 to-white p-5 shadow-sm">
                            <div class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-500">Total Surat</div>
                            <div class="mt-2 text-3xl font-bold text-slate-900" data-summary-letters>0</div>
                            <div class="mt-1 text-sm text-slate-500">Total volume layanan surat pada periode aktif.</div>
                        </div>
                        <div
                            class="rounded-2xl border border-emerald-100 bg-gradient-to-br from-emerald-50 to-white p-5 shadow-sm">
                            <div class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-500">Total Pengaduan
                            </div>
                            <div class="mt-2 text-3xl font-bold text-slate-900" data-summary-complaints>0</div>
                            <div class="mt-1 text-sm text-slate-500">Jumlah pengaduan yang masuk pada periode aktif.</div>
                        </div>
                        <div
                            class="rounded-2xl border border-amber-100 bg-gradient-to-br from-amber-50 to-white p-5 shadow-sm">
                            <div class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-500">Puncak Volume
                            </div>
                            <div class="mt-2 text-xl font-bold text-slate-900" data-summary-peak-label>-</div>
                            <div class="mt-1 text-sm text-amber-700">
                                <span data-summary-peak-value>0</span>
                                layanan tertinggi pada seri yang aktif.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modern Quick Actions & Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Modern Quick Actions -->
            <div class="lg:col-span-1">
                <div class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-5 border-b border-gray-200">
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
                        </div>
                    </div>
                    <div class="p-6 space-y-3">
                        @permission('posts.create')
                            <a href="{{ route('posts.index') }}"
                                class="group w-full flex items-center px-4 py-4 text-sm font-medium text-gray-700 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl hover:from-blue-100 hover:to-blue-200 transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                <div
                                    class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-4 group-hover:shadow-lg transition-shadow duration-300">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900 group-hover:text-blue-800">Tambah Berita</p>
                                    <p class="text-xs text-gray-500 group-hover:text-blue-600">Kelola artikel dan publikasi berita</p>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 transform group-hover:translate-x-1 transition-all duration-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </a>
                        @endpermission

                        @permission('posts.view')
                            <a href="{{ route('potentials.index') }}"
                                class="group w-full flex items-center px-4 py-4 text-sm font-medium text-gray-700 bg-gradient-to-r from-green-50 to-green-100 rounded-xl hover:from-green-100 hover:to-green-200 transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                <div
                                    class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-4 group-hover:shadow-lg transition-shadow duration-300">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900 group-hover:text-green-800">Potensi Desa</p>
                                    <p class="text-xs text-gray-500 group-hover:text-green-600">Kelola potensi unggulan desa</p>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-green-600 transform group-hover:translate-x-1 transition-all duration-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </a>
                        @endpermission

                        <!-- System Status -->
                        <div
                            class="group w-full flex items-center px-4 py-4 text-sm font-medium text-gray-700 bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">System Status</p>
                                <div class="flex items-center space-x-2 mt-1">
                                    <div
                                        class="w-2 h-2 rounded-full {{ $systemHealth['color'] === 'green' ? 'bg-green-500 animate-pulse' : ($systemHealth['color'] === 'yellow' ? 'bg-yellow-500' : 'bg-red-500') }}">
                                    </div>
                                    <p
                                        class="text-xs font-medium {{ $systemHealth['color'] === 'green' ? 'text-green-600' : ($systemHealth['color'] === 'yellow' ? 'text-yellow-600' : 'text-red-600') }}">
                                        {{ $systemHealth['summary'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modern Recent Audit Notifications -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-5 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div
                                    class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">

                                    <svg class="h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Notifikasi Audit Terbaru</h3>
                            </div>
                            <div class="flex items-center space-x-2 text-sm text-gray-500">
                                <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                                <span>Live updates</span>
                            </div>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse ($recentAuditLogs as $auditLog)
                            <div class="px-6 py-4 hover:bg-gray-50 transition-colors duration-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="relative">
                                            <div
                                                class="w-12 h-12 bg-gradient-to-br from-blue-400 to-purple-500 rounded-xl flex items-center justify-center shadow-lg">
                                                <span
                                                    class="text-sm font-bold text-white">{{ substr($auditLog->entity_type ?: 'LG', 0, 2) }}</span>
                                            </div>
                                            <div
                                                class="absolute -bottom-1 -right-1 w-4 h-4 {{ in_array($auditLog->level, ['warning', 'error', 'critical', 'alert', 'emergency']) ? 'bg-red-500' : 'bg-green-500' }} rounded-full border-2 border-white">
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-semibold text-gray-900">
                                                {{ \Illuminate\Support\Str::limit($auditLog->message, 70) }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                {{ $auditLog->user?->name ?? $auditLog->user_email ?? 'Sistem' }}
                                            </p>
                                            <div class="flex items-center space-x-2 mt-1">
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $auditLog->entity_type ?: 'System' }}
                                                </span>
                                                @if ($auditLog->action)
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-600">
                                                        {{ str($auditLog->action)->replace('_', ' ')->title() }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end space-y-1">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ in_array($auditLog->level, ['warning', 'error', 'critical', 'alert', 'emergency']) ? 'bg-red-100 text-red-800 shadow-red-100' : 'bg-green-100 text-green-800 shadow-green-100' }} shadow-sm">
                                            {{ strtoupper($auditLog->level) }}
                                        </span>
                                        <span class="text-xs text-gray-500 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ optional($auditLog->logged_at)->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-10 text-center text-sm text-gray-500">
                                Belum ada notifikasi audit terbaru.
                            </div>
                        @endforelse
                    </div>
                    @permission('system.logs')
                        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-blue-50 border-t border-gray-100">
                            <a href="{{ route('audit-logs.index') }}"
                                class="group flex items-center justify-center text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors duration-200">
                                <span>Lihat semua notifikasi audit</span>
                                <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform duration-200"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        </div>
                    @endpermission
                </div>
            </div>
        </div>
    </div>
    <script>
        (() => {
            const datasets = @json($contentTrendSets);
            const svg = document.getElementById('dashboard-content-chart');
            const tooltip = document.getElementById('dashboard-content-tooltip');
            if (!svg || !tooltip) {
                return;
            }

            const state = {
                range: 'monthly',
                visible: {
                    posts: true,
                    potentials: true,
                },
            };

            const seriesConfig = {
                posts: {
                    label: 'Artikel',
                    color: '#f97316',
                    softColor: '#fed7aa',
                },
                potentials: {
                    label: 'Potensi',
                    color: '#10b981',
                    softColor: '#a7f3d0',
                },
            };

            const rangeButtons = Array.from(document.querySelectorAll('[data-content-range]'));
            const seriesButtons = Array.from(document.querySelectorAll('[data-content-series]'));
            const summaryPosts = document.querySelector('[data-content-summary-posts]');
            const summaryPotentials = document.querySelector('[data-content-summary-potentials]');
            const summaryPeakLabel = document.querySelector('[data-content-summary-peak-label]');
            const summaryPeakValue = document.querySelector('[data-content-summary-peak-value]');

            function createSvgElement(tag, attributes = {}) {
                const element = document.createElementNS('http://www.w3.org/2000/svg', tag);
                Object.entries(attributes).forEach(([key, value]) => element.setAttribute(key, value));
                return element;
            }

            function getActiveSeriesKeys() {
                return Object.keys(state.visible).filter((key) => state.visible[key]);
            }

            function updateRangeButtons() {
                rangeButtons.forEach((button) => {
                    const active = button.dataset.contentRange === state.range;
                    button.classList.toggle('border-orange-200', active);
                    button.classList.toggle('bg-orange-600', active);
                    button.classList.toggle('text-white', active);
                    button.classList.toggle('shadow-lg', active);
                    button.classList.toggle('border-slate-200', !active);
                    button.classList.toggle('bg-white', !active);
                    button.classList.toggle('text-slate-600', !active);
                });
            }

            function updateSeriesButtons() {
                seriesButtons.forEach((button) => {
                    const series = button.dataset.contentSeries;
                    const active = state.visible[series];
                    const config = seriesConfig[series];
                    button.style.borderColor = active ? config.softColor : '#e2e8f0';
                    button.style.backgroundColor = active ? config.softColor : '#f8fafc';
                    button.style.color = active ? config.color : '#64748b';
                    button.style.opacity = active ? '1' : '0.72';
                });
            }

            function getPeakEntry(data) {
                const activeSeries = getActiveSeriesKeys();
                let peak = {
                    label: '-',
                    value: 0,
                };

                data.forEach((entry) => {
                    activeSeries.forEach((series) => {
                        if (entry[series] > peak.value) {
                            peak = {
                                label: entry.label,
                                value: entry[series],
                            };
                        }
                    });
                });

                return peak;
            }

            function updateSummary(data) {
                const postTotal = data.reduce((sum, entry) => sum + entry.posts, 0);
                const potentialTotal = data.reduce((sum, entry) => sum + entry.potentials, 0);
                const peak = getPeakEntry(data);

                if (summaryPosts) {
                    summaryPosts.textContent = postTotal;
                }

                if (summaryPotentials) {
                    summaryPotentials.textContent = potentialTotal;
                }

                if (summaryPeakLabel) {
                    summaryPeakLabel.textContent = peak.label;
                }

                if (summaryPeakValue) {
                    summaryPeakValue.textContent = peak.value;
                }
            }

            function showTooltip(event, entry) {
                tooltip.querySelector('[data-content-tooltip-label]').textContent = entry.label;
                tooltip.querySelector('[data-content-tooltip-posts]').textContent = entry.posts;
                tooltip.querySelector('[data-content-tooltip-potentials]').textContent = entry.potentials;
                tooltip.classList.remove('hidden');
                moveTooltip(event);
            }

            function moveTooltip(event) {
                const container = tooltip.parentElement.getBoundingClientRect();
                const tooltipWidth = tooltip.offsetWidth || 208;
                const tooltipHeight = tooltip.offsetHeight || 96;
                const left = Math.min(Math.max(event.clientX - container.left + 16, 12), container.width - tooltipWidth - 12);
                const top = Math.min(Math.max(event.clientY - container.top - tooltipHeight - 14, 12), container.height - tooltipHeight - 12);

                tooltip.style.left = `${left}px`;
                tooltip.style.top = `${top}px`;
            }

            function hideTooltip() {
                tooltip.classList.add('hidden');
            }

            function renderChart() {
                const data = datasets[state.range] ?? [];
                const activeSeries = getActiveSeriesKeys();
                const width = 860;
                const height = 360;
                const padding = { top: 30, right: 24, bottom: 46, left: 58 };
                const plotWidth = width - padding.left - padding.right;
                const plotHeight = height - padding.top - padding.bottom;
                const maxValue = Math.max(1, ...data.flatMap((entry) => activeSeries.map((series) => entry[series])));
                const roundedMax = Math.max(4, Math.ceil(maxValue / 4) * 4);
                const ticks = [0, 0.25, 0.5, 0.75, 1].map((ratio) => Math.round(roundedMax * ratio));

                svg.innerHTML = '';
                updateSummary(data);

                ticks.forEach((tick) => {
                    const y = padding.top + plotHeight - (tick / roundedMax) * plotHeight;
                    svg.appendChild(createSvgElement('line', {
                        x1: padding.left,
                        y1: y,
                        x2: width - padding.right,
                        y2: y,
                        stroke: '#e2e8f0',
                        'stroke-dasharray': '4 8',
                    }));

                    const tickLabel = createSvgElement('text', {
                        x: padding.left - 12,
                        y: y + 4,
                        'text-anchor': 'end',
                        'font-size': '11',
                        fill: '#64748b',
                    });
                    tickLabel.textContent = String(tick);
                    svg.appendChild(tickLabel);
                });

                svg.appendChild(createSvgElement('line', {
                    x1: padding.left,
                    y1: padding.top,
                    x2: padding.left,
                    y2: height - padding.bottom,
                    stroke: '#cbd5e1',
                }));
                svg.appendChild(createSvgElement('line', {
                    x1: padding.left,
                    y1: height - padding.bottom,
                    x2: width - padding.right,
                    y2: height - padding.bottom,
                    stroke: '#cbd5e1',
                }));

                const pointCount = Math.max(data.length - 1, 1);
                const pointsBySeries = {};

                data.forEach((entry, index) => {
                    const x = padding.left + (plotWidth / pointCount) * index;
                    const label = createSvgElement('text', {
                        x,
                        y: height - 16,
                        'text-anchor': 'middle',
                        'font-size': '11',
                        fill: '#64748b',
                    });
                    label.textContent = entry.label;
                    svg.appendChild(label);

                    activeSeries.forEach((series) => {
                        const y = padding.top + plotHeight - (entry[series] / roundedMax) * plotHeight;
                        pointsBySeries[series] ??= [];
                        pointsBySeries[series].push({ x, y, entry });
                    });
                });

                activeSeries.forEach((series) => {
                    const config = seriesConfig[series];
                    const seriesPoints = pointsBySeries[series] ?? [];
                    const pathPoints = seriesPoints.map((point) => `${point.x},${point.y}`).join(' ');

                    svg.appendChild(createSvgElement('polyline', {
                        fill: 'none',
                        stroke: config.color,
                        'stroke-width': '4',
                        'stroke-linecap': 'round',
                        'stroke-linejoin': 'round',
                        points: pathPoints,
                    }));

                    const peakPoint = seriesPoints.reduce((carry, point) => {
                        if (!carry || point.entry[series] > carry.entry[series]) {
                            return point;
                        }
                        return carry;
                    }, null);

                    seriesPoints.forEach((point) => {
                        svg.appendChild(createSvgElement('circle', {
                            cx: point.x,
                            cy: point.y,
                            r: 9,
                            fill: '#ffffff',
                            stroke: config.color,
                            'stroke-width': '3',
                        }));

                        svg.appendChild(createSvgElement('circle', {
                            cx: point.x,
                            cy: point.y,
                            r: 4,
                            fill: config.color,
                        }));

                        const hotspot = createSvgElement('circle', {
                            cx: point.x,
                            cy: point.y,
                            r: 16,
                            fill: 'transparent',
                            style: 'cursor:pointer',
                        });
                        hotspot.addEventListener('mouseenter', (event) => showTooltip(event, point.entry));
                        hotspot.addEventListener('mousemove', moveTooltip);
                        hotspot.addEventListener('mouseleave', hideTooltip);
                        svg.appendChild(hotspot);
                    });

                    if (peakPoint) {
                        const peakValue = peakPoint.entry[series];
                        const peakLabel = createSvgElement('g');
                        peakLabel.appendChild(createSvgElement('rect', {
                            x: peakPoint.x - 28,
                            y: peakPoint.y - 42,
                            width: 56,
                            height: 24,
                            rx: 12,
                            fill: config.color,
                            opacity: '0.12',
                        }));
                        const text = createSvgElement('text', {
                            x: peakPoint.x,
                            y: peakPoint.y - 26,
                            'text-anchor': 'middle',
                            'font-size': '11',
                            'font-weight': '700',
                            fill: config.color,
                        });
                        text.textContent = String(peakValue);
                        peakLabel.appendChild(text);
                        svg.appendChild(peakLabel);
                    }
                });
            }

            rangeButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    state.range = button.dataset.contentRange;
                    updateRangeButtons();
                    renderChart();
                });
            });

            seriesButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    const series = button.dataset.contentSeries;
                    const activeSeries = getActiveSeriesKeys();
                    if (activeSeries.length === 1 && state.visible[series]) {
                        return;
                    }

                    state.visible[series] = !state.visible[series];
                    updateSeriesButtons();
                    renderChart();
                });
            });

            updateRangeButtons();
            updateSeriesButtons();
            renderChart();
        })();

        (() => {
            const datasets = @json($serviceTrendSets);
            const svg = document.getElementById('dashboard-service-chart');
            const tooltip = document.getElementById('dashboard-chart-tooltip');
            if (!svg || !tooltip) {
                return;
            }

            const state = {
                range: 'monthly',
                visible: {
                    letters: true,
                    complaints: true,
                },
            };

            const seriesConfig = {
                letters: {
                    label: 'Surat',
                    color: '#3b82f6',
                    softColor: '#dbeafe',
                },
                complaints: {
                    label: 'Pengaduan',
                    color: '#10b981',
                    softColor: '#d1fae5',
                },
            };

            const rangeButtons = Array.from(document.querySelectorAll('[data-chart-range]'));
            const seriesButtons = Array.from(document.querySelectorAll('[data-chart-series]'));
            const summaryLetters = document.querySelector('[data-summary-letters]');
            const summaryComplaints = document.querySelector('[data-summary-complaints]');
            const summaryPeakLabel = document.querySelector('[data-summary-peak-label]');
            const summaryPeakValue = document.querySelector('[data-summary-peak-value]');

            function setAttributes(element, attributes) {
                Object.entries(attributes).forEach(([key, value]) => {
                    element.setAttribute(key, value);
                });
            }

            function createSvgElement(tag, attributes = {}) {
                const element = document.createElementNS('http://www.w3.org/2000/svg', tag);
                setAttributes(element, attributes);
                return element;
            }

            function updateRangeButtons() {
                rangeButtons.forEach((button) => {
                    const active = button.dataset.chartRange === state.range;
                    button.classList.toggle('border-blue-200', active);
                    button.classList.toggle('bg-blue-600', active);
                    button.classList.toggle('text-white', active);
                    button.classList.toggle('shadow-lg', active);
                    button.classList.toggle('border-slate-200', !active);
                    button.classList.toggle('bg-white', !active);
                    button.classList.toggle('text-slate-600', !active);
                });
            }

            function updateSeriesButtons() {
                seriesButtons.forEach((button) => {
                    const series = button.dataset.chartSeries;
                    const active = state.visible[series];
                    const config = seriesConfig[series];
                    button.style.borderColor = active ? config.softColor : '#e2e8f0';
                    button.style.backgroundColor = active ? config.softColor : '#f8fafc';
                    button.style.color = active ? config.color : '#64748b';
                    button.style.opacity = active ? '1' : '0.72';
                });
            }

            function getActiveSeriesKeys() {
                return Object.keys(state.visible).filter((key) => state.visible[key]);
            }

            function getPeakEntry(data) {
                const activeSeries = getActiveSeriesKeys();
                let peak = {
                    label: '-',
                    value: 0,
                };

                data.forEach((entry) => {
                    activeSeries.forEach((series) => {
                        if (entry[series] > peak.value) {
                            peak = {
                                label: entry.label,
                                value: entry[series],
                            };
                        }
                    });
                });

                return peak;
            }

            function updateSummary(data) {
                const lettersTotal = data.reduce((sum, entry) => sum + entry.letters, 0);
                const complaintsTotal = data.reduce((sum, entry) => sum + entry.complaints, 0);
                const peak = getPeakEntry(data);

                if (summaryLetters) {
                    summaryLetters.textContent = lettersTotal;
                }

                if (summaryComplaints) {
                    summaryComplaints.textContent = complaintsTotal;
                }

                if (summaryPeakLabel) {
                    summaryPeakLabel.textContent = peak.label;
                }

                if (summaryPeakValue) {
                    summaryPeakValue.textContent = peak.value;
                }
            }

            function showTooltip(event, entry) {
                tooltip.querySelector('[data-tooltip-label]').textContent = entry.label;
                tooltip.querySelector('[data-tooltip-letters]').textContent = entry.letters;
                tooltip.querySelector('[data-tooltip-complaints]').textContent = entry.complaints;
                tooltip.classList.remove('hidden');
                moveTooltip(event);
            }

            function moveTooltip(event) {
                const container = tooltip.parentElement.getBoundingClientRect();
                const tooltipWidth = tooltip.offsetWidth || 208;
                const tooltipHeight = tooltip.offsetHeight || 96;
                const left = Math.min(
                    Math.max(event.clientX - container.left + 16, 12),
                    container.width - tooltipWidth - 12
                );
                const top = Math.min(
                    Math.max(event.clientY - container.top - tooltipHeight - 14, 12),
                    container.height - tooltipHeight - 12
                );

                tooltip.style.left = `${left}px`;
                tooltip.style.top = `${top}px`;
            }

            function hideTooltip() {
                tooltip.classList.add('hidden');
            }

            function renderChart() {
                const data = datasets[state.range] ?? [];
                const activeSeries = getActiveSeriesKeys();
                const width = 860;
                const height = 360;
                const padding = {
                    top: 30,
                    right: 24,
                    bottom: 46,
                    left: 58,
                };
                const plotWidth = width - padding.left - padding.right;
                const plotHeight = height - padding.top - padding.bottom;
                const maxValue = Math.max(
                    1,
                    ...data.flatMap((entry) => activeSeries.map((series) => entry[series]))
                );
                const roundedMax = Math.max(4, Math.ceil(maxValue / 4) * 4);
                const ticks = [0, 0.25, 0.5, 0.75, 1].map((ratio) => Math.round(roundedMax * ratio));

                svg.innerHTML = '';
                updateSummary(data);

                ticks.forEach((tick) => {
                    const y = padding.top + plotHeight - (tick / roundedMax) * plotHeight;
                    svg.appendChild(createSvgElement('line', {
                        x1: padding.left,
                        y1: y,
                        x2: width - padding.right,
                        y2: y,
                        stroke: '#e2e8f0',
                        'stroke-dasharray': '4 8',
                    }));
                    const tickLabel = createSvgElement('text', {
                        x: padding.left - 12,
                        y: y + 4,
                        'text-anchor': 'end',
                        'font-size': '11',
                        fill: '#64748b',
                    });
                    tickLabel.textContent = String(tick);
                    svg.appendChild(tickLabel);
                });

                svg.appendChild(createSvgElement('line', {
                    x1: padding.left,
                    y1: padding.top,
                    x2: padding.left,
                    y2: height - padding.bottom,
                    stroke: '#cbd5e1',
                }));
                svg.appendChild(createSvgElement('line', {
                    x1: padding.left,
                    y1: height - padding.bottom,
                    x2: width - padding.right,
                    y2: height - padding.bottom,
                    stroke: '#cbd5e1',
                }));

                const pointCount = Math.max(data.length - 1, 1);
                const pointsBySeries = {};

                data.forEach((entry, index) => {
                    const x = padding.left + (plotWidth / pointCount) * index;
                    const label = createSvgElement('text', {
                        x,
                        y: height - 16,
                        'text-anchor': 'middle',
                        'font-size': '11',
                        fill: '#64748b',
                    });
                    label.textContent = entry.label;
                    svg.appendChild(label);

                    activeSeries.forEach((series) => {
                        const y = padding.top + plotHeight - (entry[series] / roundedMax) * plotHeight;
                        pointsBySeries[series] ??= [];
                        pointsBySeries[series].push({
                            x,
                            y,
                            entry,
                        });
                    });
                });

                activeSeries.forEach((series) => {
                    const config = seriesConfig[series];
                    const seriesPoints = pointsBySeries[series] ?? [];
                    const pathPoints = seriesPoints.map((point) => `${point.x},${point.y}`).join(' ');

                    svg.appendChild(createSvgElement('polyline', {
                        fill: 'none',
                        stroke: config.color,
                        'stroke-width': '4',
                        'stroke-linecap': 'round',
                        'stroke-linejoin': 'round',
                        points: pathPoints,
                    }));

                    const peakPoint = seriesPoints.reduce((carry, point) => {
                        if (!carry || point.entry[series] > carry.entry[series]) {
                            return point;
                        }
                        return carry;
                    }, null);

                    seriesPoints.forEach((point) => {
                        svg.appendChild(createSvgElement('circle', {
                            cx: point.x,
                            cy: point.y,
                            r: 9,
                            fill: '#ffffff',
                            stroke: config.color,
                            'stroke-width': '3',
                        }));

                        svg.appendChild(createSvgElement('circle', {
                            cx: point.x,
                            cy: point.y,
                            r: 4,
                            fill: config.color,
                        }));

                        const hotspot = createSvgElement('circle', {
                            cx: point.x,
                            cy: point.y,
                            r: 16,
                            fill: 'transparent',
                            style: 'cursor:pointer',
                        });
                        hotspot.addEventListener('mouseenter', (event) => showTooltip(event, point
                            .entry));
                        hotspot.addEventListener('mousemove', moveTooltip);
                        hotspot.addEventListener('mouseleave', hideTooltip);
                        svg.appendChild(hotspot);
                    });

                    if (peakPoint) {
                        const peakValue = peakPoint.entry[series];
                        const peakLabel = createSvgElement('g');
                        peakLabel.appendChild(createSvgElement('rect', {
                            x: peakPoint.x - 28,
                            y: peakPoint.y - 42,
                            width: 56,
                            height: 24,
                            rx: 12,
                            fill: config.color,
                            opacity: '0.12',
                        }));
                        const text = createSvgElement('text', {
                            x: peakPoint.x,
                            y: peakPoint.y - 26,
                            'text-anchor': 'middle',
                            'font-size': '11',
                            'font-weight': '700',
                            fill: config.color,
                        });
                        text.textContent = String(peakValue);
                        peakLabel.appendChild(text);
                        svg.appendChild(peakLabel);
                    }
                });
            }

            rangeButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    state.range = button.dataset.chartRange;
                    updateRangeButtons();
                    renderChart();
                });
            });

            seriesButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    const series = button.dataset.chartSeries;
                    const activeSeries = getActiveSeriesKeys();
                    if (activeSeries.length === 1 && state.visible[series]) {
                        return;
                    }

                    state.visible[series] = !state.visible[series];
                    updateSeriesButtons();
                    renderChart();
                });
            });

            updateRangeButtons();
            updateSeriesButtons();
            renderChart();
        })();
    </script>
@endsection
