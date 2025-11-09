@extends('layouts.app')

@section('content')
    <div class="space-y-8 animate-fadeInUp">
        <!-- Modern Welcome Section with Glassmorphism -->
        <div
            class="relative bg-gradient-to-br from-green-400 via-green-600 to-green-800 rounded-2xl shadow-2xl overflow-hidden">
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
                            class="text-4xl font-bold mb-3 bg-gradient-to-r from-white to-green-100 bg-clip-text text-transparent">
                            Welcome back, {{ auth()->user()->name }}!
                        </h1>
                        <p class="text-xl text-green-100 mb-4">Here's what's happening with your system today.</p>
                        <div class="flex items-center space-x-4 text-sm text-green-200">
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
                                System Online
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

        <!-- Modern Stats Cards -->
        @php
            use Illuminate\Support\Facades\Cache;
            use App\Domains\Post\Models\Post;

            // Ambil statistik global (jika ada)
            $stats = \App\Shared\Services\CacheService::getDashboardStats();

            // Ambil data per content_type + status (cache 1 detik)
            $postStats = Cache::remember('dashboard:post_stats', now()->addSeconds(1), function () {
                return Post::query()
                    ->whereNotNull('content_type')
                    ->whereNull('deleted_at')
                    ->selectRaw(
                        "
            content_type,
            SUM(CASE WHEN status = 'published' THEN 1 ELSE 0 END) AS published,
            SUM(CASE WHEN status != 'published' OR status IS NULL THEN 1 ELSE 0 END) AS unpublished
        ",
                    )
                    ->groupBy('content_type')
                    ->get()
                    ->mapWithKeys(
                        fn($row) => [
                            $row->content_type => [
                                'published' => (int) $row->published,
                                'unpublished' => (int) $row->unpublished,
                                'total' => (int) $row->published + (int) $row->unpublished,
                            ],
                        ],
                    )
                    ->toArray();
            });

            // Normalisasi alias (untuk variasi nama)
            $newsKey =
                $postStats['news'] ?? ($postStats['berita'] ?? ['published' => 0, 'unpublished' => 0, 'total' => 0]);
            $announcementKey =
                $postStats['announcement'] ??
                ($postStats['pengumuman'] ?? ['published' => 0, 'unpublished' => 0, 'total' => 0]);
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- Total Berita Card -->
            <div class="group relative bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-200 hover:shadow-2xl hover:border-yellow-300 transition-all duration-300 transform hover:-translate-y-1 animate-slideInRight"
                style="animation-delay: 0.1s">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-yellow-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-600 mb-1">Total Berita</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ number_format($newsKey['total']) }}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></div>
                                    <span class="text-sm text-yellow-600 font-semibold"> Published:
                                        {{ $newsKey['published'] }} • Unpublished: {{ $newsKey['unpublished'] }}</span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Pengumuman Card -->
            <div class="group relative bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-200 hover:shadow-2xl hover:border-pink-300 transition-all duration-300 transform hover:-translate-y-1 animate-slideInRight"
                style="animation-delay: 0.2s">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-pink-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 0 8.835-2.535m0 0A23.74 23.74 0 0 0 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 0 1 0 3.46" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-600 mb-1">Total Pengumuman</p>
                                    <p class="text-2xl font-bold text-gray-900">
                                        {{ number_format($announcementKey['total']) }}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-pink-500 rounded-full"></div>
                                    <span class="text-sm text-pink-600 font-semibold">Published:
                                        {{ $announcementKey['published'] }} • Unpublished:
                                        {{ $announcementKey['unpublished'] }}</span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Penduduk Card -->
            <div class="group relative bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-200 hover:shadow-2xl hover:border-blue-300 transition-all duration-300 transform hover:-translate-y-1 animate-slideInRight"
                style="animation-delay: 0.3s">
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
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-600 mb-1">Total Penduduk</p>
                                    <p class="text-2xl font-bold text-gray-900">
                                        6000</p>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                    <span class="text-sm text-blue-600 font-semibold">System wide</span>
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

            <!-- Total Kepala Keluarga Card -->
            <div class="group relative bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-200 hover:shadow-2xl hover:border-green-300 transition-all duration-300 transform hover:-translate-y-1 animate-slideInRight"
                style="animation-delay: 0.4s">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-green-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-500 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-600 mb-1">Total KK</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ auth()->user()->roles->count() }}</p>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                    <span class="text-sm text-green-600 font-semibold">Personal</span>
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
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-600 mb-1">Total Pengguna</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_users']) }}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                                    <span class="text-sm text-blue-600 font-semibold">{{ $stats['active_users'] }}
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

        <!-- Modern Quick Actions & Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Modern Quick Actions -->
            <div class="lg:col-span-1">
                <div class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-5 border-b border-gray-200">
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 bg-gradient-to-br from-green-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
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
                        @permission('users.create')
                            <a href="{{ route('users.index') }}"
                                class="group w-full flex items-center px-4 py-4 text-sm font-medium text-gray-700 bg-gradient-to-r from-green-50 to-green-100 rounded-xl hover:from-green-100 hover:to-green-200 transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                <div
                                    class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-4 group-hover:shadow-lg transition-shadow duration-300">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900 group-hover:text-green-800">Add New User</p>
                                    <p class="text-xs text-gray-500 group-hover:text-green-600">Create and manage users</p>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-green-600 transform group-hover:translate-x-1 transition-all duration-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </a>
                        @endpermission

                        @permission('roles.create')
                            <a href="{{ route('roles.index') }}"
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
                                    <p class="font-semibold text-gray-900 group-hover:text-green-800">Create Role</p>
                                    <p class="text-xs text-gray-500 group-hover:text-green-600">Manage roles & permissions</p>
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
                                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                    <p class="text-xs text-green-600 font-medium">All systems operational</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modern Recent Users -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-5 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div
                                    class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Recent Users</h3>
                            </div>
                            <div class="flex items-center space-x-2 text-sm text-gray-500">
                                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                <span>Live updates</span>
                            </div>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @foreach ($stats['recent_users'] as $user)
                            <div class="px-6 py-4 hover:bg-gray-50 transition-colors duration-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="relative">
                                            <div
                                                class="w-12 h-12 bg-gradient-to-br from-green-400 to-purple-500 rounded-xl flex items-center justify-center shadow-lg">
                                                <span
                                                    class="text-sm font-bold text-white">{{ substr($user->name, 0, 2) }}</span>
                                            </div>
                                            @if ($user->is_active)
                                                <div
                                                    class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white">
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-semibold text-gray-900">{{ $user->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                            <div class="flex items-center space-x-2 mt-1">
                                                @foreach ($user->roles->take(2) as $role)
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-green-100 text-green-800">
                                                        {{ $role->display_name }}
                                                    </span>
                                                @endforeach
                                                @if ($user->roles->count() > 2)
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-600">
                                                        +{{ $user->roles->count() - 2 }} more
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end space-y-1">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $user->is_active ? 'bg-green-100 text-green-800 shadow-green-100' : 'bg-red-100 text-red-800 shadow-red-100' }} shadow-sm">
                                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                        <span class="text-xs text-gray-500 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $user->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @permission('users.view')
                        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-green-50 border-t border-gray-100">
                            <a href="{{ route('users.index') }}"
                                class="group flex items-center justify-center text-sm font-semibold text-green-600 hover:text-green-800 transition-colors duration-200">
                                <span>View all users</span>
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
@endsection
