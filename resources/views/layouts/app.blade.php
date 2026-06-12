<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SatuDesa') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
    <style>
        .sidebar-gradient {
            background: linear-gradient(180deg, #1e3a8a 0%, #1e40af 42%, #2563eb 100%);
        }

        .navbar-gradient {
            background: linear-gradient(90deg, #ffffff 0%, #eff6ff 100%);
        }

        .sidebar-toggle {
            transition: all 0.3s ease;
        }

        .sidebar-hidden {
            transform: translateX(-100%);
        }

        .main-content-expanded {
            margin-left: 0;
        }

        @media (min-width: 768px) {
            .sidebar-toggle {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 16rem;
            }
        }

        /* Modern Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out;
        }

        .animate-slideInRight {
            animation: slideInRight 0.4s ease-out;
        }

        /* Glassmorphism Effects */
        .glass {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        /* Modern Shadow Effects */
        .shadow-modern {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .shadow-modern-lg {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Hover Glow Effects */
        .hover-glow {
            transition: all 0.3s ease;
        }

        .hover-glow:hover {
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.4);
        }

        /* Modern Loading Spinner */
        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #2563eb;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(45deg, #2563eb, #1e40af);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(45deg, #1d4ed8, #1e3a8a);
        }

        body.modal-open {
            overflow: hidden;
        }

        .app-modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 80;
            overflow-y: auto;
            background: rgba(15, 23, 42, 0.45);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .app-modal-shell {
            display: flex;
            min-height: 100%;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .app-modal-panel {
            display: flex;
            max-height: calc(100vh - 2rem);
            width: 100%;
            flex-direction: column;
            overflow: hidden;
            border-radius: 1rem;
            border: 1px solid #e2e8f0;
            background: #fff;
            box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.28);
        }

        .app-modal-panel>form {
            display: flex;
            min-height: 0;
            max-height: inherit;
            width: 100%;
            flex: 1 1 auto;
            flex-direction: column;
            overflow: hidden;
        }

        .app-modal-body {
            min-height: 0;
            flex: 1 1 auto;
            overflow-y: auto;
            overscroll-behavior: contain;
        }

        .app-modal-footer {
            position: sticky;
            bottom: 0;
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            border-top: 1px solid #e2e8f0;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        .module-panel {
            overflow: hidden;
            border: 1px solid #e5e7eb;
            border-radius: 1rem;
            background: #fff;
            box-shadow: 0 18px 40px -18px rgba(15, 23, 42, 0.28);
        }

        .module-panel-header {
            border-bottom: 1px solid #e5e7eb;
            background: linear-gradient(90deg, #eff6ff 0%, #eef2ff 52%, #faf5ff 100%);
        }

        .module-soft-card {
            border: 1px solid #e5e7eb;
            border-radius: 0.95rem;
            background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
            transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease, background-color 0.22s ease;
        }

        .module-soft-card:hover {
            transform: translateY(-1px);
            border-color: #bfdbfe;
            box-shadow: 0 14px 30px -18px rgba(37, 99, 235, 0.35);
        }

        .profile-module-hero {
            overflow: hidden;
            border: 1px solid #e2e8f0;
            border-radius: 1.75rem;
            background: linear-gradient(90deg, #ffffff 0%, #f8fbff 45%, #eef2ff 100%);
            box-shadow: 0 18px 40px -18px rgba(15, 23, 42, 0.18);
        }

        .profile-module-kicker {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.24em;
            text-transform: uppercase;
            color: #1d4ed8;
        }

        .profile-module-heading {
            margin-top: 0.5rem;
            font-size: 2.35rem;
            line-height: 1.05;
            font-weight: 800;
            color: #0f172a;
        }

        .profile-module-copy {
            margin-top: 0.9rem;
            max-width: 42rem;
            font-size: 0.95rem;
            line-height: 1.9;
            color: #475569;
        }

        .profile-module-stat {
            border: 1px solid #e2e8f0;
            border-radius: 1.1rem;
            background: #fff;
            padding: 1rem 1.15rem;
            box-shadow: 0 10px 24px -18px rgba(15, 23, 42, 0.2);
        }

        .profile-module-stat-label {
            font-size: 0.78rem;
            font-weight: 600;
            color: #64748b;
        }

        .profile-module-stat-value {
            margin-top: 0.45rem;
            font-size: 1.95rem;
            line-height: 1;
            font-weight: 800;
            color: #0f172a;
        }

        .profile-module-stat-note {
            margin-top: 0.65rem;
            font-size: 0.82rem;
            font-weight: 600;
        }

        .profile-module-section-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #0f172a;
        }

        .profile-module-section-copy {
            margin-top: 0.3rem;
            font-size: 0.9rem;
            line-height: 1.75;
            color: #64748b;
        }

        .profile-module-table thead th {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: #64748b;
        }

        .module-primary-btn {
            border-radius: 0.9rem;
            background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 12px 24px -14px rgba(37, 99, 235, 0.55);
            transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease;
        }

        .module-primary-btn:hover {
            transform: translateY(-1px);
            filter: brightness(0.98);
            box-shadow: 0 16px 30px -16px rgba(37, 99, 235, 0.62);
        }

        .module-neutral-btn {
            border: 1px solid #d1d5db;
            border-radius: 0.85rem;
            background: #fff;
            color: #374151;
            font-weight: 600;
            transition: background-color 0.2s ease, border-color 0.2s ease, transform 0.2s ease;
        }

        .module-neutral-btn:hover {
            transform: translateY(-1px);
            border-color: #cbd5e1;
            background: #f8fafc;
        }

        .module-edit-btn,
        .module-danger-btn {
            border-radius: 0.75rem;
            padding: 0.55rem 0.9rem;
            font-size: 0.75rem;
            font-weight: 700;
            transition: transform 0.2s ease, background-color 0.2s ease, box-shadow 0.2s ease;
        }

        .module-edit-btn {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .module-edit-btn:hover {
            transform: translateY(-1px);
            background: #dbeafe;
            box-shadow: 0 10px 20px -16px rgba(37, 99, 235, 0.6);
        }

        .module-danger-btn {
            background: #fef2f2;
            color: #dc2626;
        }

        .module-danger-btn:hover {
            transform: translateY(-1px);
            background: #fee2e2;
            box-shadow: 0 10px 20px -16px rgba(220, 38, 38, 0.5);
        }

        .module-search-input,
        .module-field {
            border: 1px solid #d1d5db;
            border-radius: 0.9rem;
            background: #fff;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
        }

        .module-search-input:focus,
        .module-field:focus {
            outline: none;
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
        }

        .module-table-head {
            background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
        }

        .module-table-row {
            transition: background-color 0.2s ease, transform 0.2s ease;
        }

        .module-table-row:hover {
            background: linear-gradient(90deg, #eff6ff 0%, #faf5ff 100%);
        }

        .leaflet-container {
            z-index: 0;
        }

        .leaflet-container img,
        .leaflet-container svg,
        .leaflet-container canvas {
            max-width: none !important;
            max-height: none !important;
        }

        @media (min-width: 640px) {
            .app-modal-shell {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50">
    @auth
        @php
            $currentUser = auth()->user();
            $userAvatarUrl = $currentUser->avatar_url;
            $userInitials = strtoupper(substr($currentUser->name, 0, 2));
            $canViewPosts = $currentUser->hasPermission('posts.view');
            $canViewAnnouncements = $currentUser->hasPermission('announcements.view');
            $canViewGalleries = $currentUser->hasPermission('galleries.view');
            $canViewPostCategories = $currentUser->hasPermission('post_categories.view');
            $hasNewsAccess = $canViewPosts || $canViewPostCategories;
            $hasAnnouncementAccess = $canViewAnnouncements;
            $canViewPotentials = $canViewPosts;
            $canViewBudgets = $currentUser->hasPermission('budgets.view');
            $budgetWorkflowSections = $canViewBudgets ? \App\Support\ApbdesWorkflow::sections() : [];
            $canViewCitizens = $currentUser->hasAnyPermission([
                'citizens.view',
                'citizen_births.view',
                'citizen_arrivals.view',
                'citizen_deaths.view',
                'households.view',
                'hamlets.view',
                'rws.view',
                'rts.view',
                'users.view',
            ]);
            $canViewUsers = $currentUser->hasPermission('users.view');
            $canViewRoles = $currentUser->hasAnyPermission(['roles.view', 'permissions.view']);
            $canViewAuditLogs = $currentUser->hasPermission('system.logs');
            $canViewVillageMap = $currentUser->hasPermission('village_maps.view');
            $canViewVillageHistory = $currentUser->hasPermission('village_histories.view');
            $canViewVillageVisionMission = $currentUser->hasPermission('village_vision_missions.view');
            $canViewVillageOrganization = $currentUser->hasPermission('village_organizations.view');
            $canViewVillageProfile = $canViewVillageMap || $canViewVillageHistory || $canViewVillageVisionMission || $canViewVillageOrganization;
            $hasSettingsAccess = $canViewUsers || $canViewRoles || $canViewAuditLogs || $canViewVillageOrganization;
            $profileMenuOpen = request()->routeIs('village-maps.*') || request()->routeIs('village-histories.*') || request()->routeIs('village-vision-missions.*') || request()->routeIs('village-organizations.*');
            $newsMenuOpen = request()->routeIs('posts.*') || request()->routeIs('post-categories.*');
            $announcementMenuOpen = request()->routeIs('announcements.*');
            $galleryMenuOpen = request()->routeIs('galleries.*');
            $budgetMenuOpen = request()->routeIs('budgets.*');
            $populationMenuOpen =
                request()->routeIs('citizens.*') ||
                request()->routeIs('citizen-births.*') ||
                request()->routeIs('citizen-arrivals.*') ||
                request()->routeIs('citizen-deaths.*') ||
                request()->routeIs('households.*') ||
                request()->routeIs('hamlets.*') ||
                request()->routeIs('rws.*') ||
                request()->routeIs('rts.*');
            $settingsMenuOpen =
                request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('audit-logs.*') || request()->routeIs('settings.organization-positions.*');
        @endphp
        <div class="min-h-screen">
            <!-- Sidebar -->
            <div id="sidebar"
                class="sidebar-toggle fixed inset-y-0 left-0 z-50 flex h-screen w-64 flex-col overflow-hidden sidebar-gradient shadow-xl transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
                <!-- Sidebar Header -->
                <div class="flex items-center justify-center h-16 px-4 bg-black/20">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        </div>
                        <span class="ml-3 text-white font-bold text-lg">{{ config('app.name', 'SatuDesa') }}</span>
                    </div>
                </div>

                <!-- Sidebar Navigation -->
                <nav class="mt-8 flex-1 overflow-y-auto px-4 pb-6">
                    <div class="space-y-2">
                        <!-- Dashboard -->
                        <a href="{{ route('dashboard') }}"
                            class="group flex items-center rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-white/20 text-white shadow-lg shadow-black/10' : 'text-blue-100 hover:bg-white/10 hover:text-white hover:translate-x-1 hover:shadow-lg hover:shadow-black/10' }} transition-all duration-200">

                            <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                            </svg>

                            Dashboard
                        </a>

                        @if ($canViewVillageProfile)
                            <div class="rounded-2xl {{ $profileMenuOpen ? 'bg-white/10' : '' }}" data-sidebar-dropdown>
                                <button type="button"
                                    class="flex w-full items-center rounded-xl px-4 py-3 text-left text-sm font-medium transition-all duration-200 {{ $profileMenuOpen ? 'text-white shadow-lg shadow-black/10' : 'text-blue-100 hover:bg-white/10 hover:text-white hover:shadow-lg hover:shadow-black/10' }}"
                                    data-sidebar-dropdown-trigger aria-expanded="{{ $profileMenuOpen ? 'true' : 'false' }}">
                                    <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 21a8.966 8.966 0 0 1-5.002-1.516A8.966 8.966 0 0 1 3 12c0-2.487 1.01-4.738 2.64-6.36A8.966 8.966 0 0 1 12 3c2.487 0 4.738 1.01 6.36 2.64A8.966 8.966 0 0 1 21 12a8.966 8.966 0 0 1-1.516 5.002A8.966 8.966 0 0 1 12 21Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 8.25c-1.243 0-2.25 1.12-2.25 2.5s1.007 2.5 2.25 2.5 2.25-1.12 2.25-2.5-1.007-2.5-2.25-2.5Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M7.5 18c.785-1.63 2.467-2.75 4.5-2.75s3.715 1.12 4.5 2.75" />
                                    </svg>
                                    <span class="flex-1">Profil Desa</span>
                                    <svg class="h-4 w-4 flex-shrink-0 transition-transform duration-200 {{ $profileMenuOpen ? 'rotate-180' : '' }}"
                                        data-sidebar-dropdown-chevron fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div class="{{ $profileMenuOpen ? 'block' : 'hidden' }} px-2 pb-2"
                                    data-sidebar-dropdown-panel>
                                    <div class="space-y-1 border-l border-white/15 pl-4">
                                        @if ($canViewVillageHistory)
                                            <a href="{{ route('village-histories.index') }}"
                                                class="group flex items-center rounded-xl px-4 py-2.5 text-sm font-normal text-white transition-all duration-200 {{ request()->routeIs('village-histories.*') ? 'bg-white/24 shadow-sm shadow-black/10' : 'hover:bg-white/12 hover:translate-x-1 hover:shadow-sm hover:shadow-black/10' }}">
                                                <span
                                                    class="mr-3 h-2.5 w-2.5 flex-shrink-0 rounded-full transition-all duration-200 {{ request()->routeIs('village-histories.*') ? 'bg-white ring-4 ring-white/10' : 'bg-white/80 group-hover:bg-white group-hover:ring-4 group-hover:ring-white/10' }}"></span>
                                                Sejarah Desa
                                            </a>
                                        @endif
                                        @if ($canViewVillageVisionMission)
                                            <a href="{{ route('village-vision-missions.index') }}"
                                                class="group flex items-center rounded-xl px-4 py-2.5 text-sm font-normal text-white transition-all duration-200 {{ request()->routeIs('village-vision-missions.*') ? 'bg-white/24 shadow-sm shadow-black/10' : 'hover:bg-white/12 hover:translate-x-1 hover:shadow-sm hover:shadow-black/10' }}">
                                                <span
                                                    class="mr-3 h-2.5 w-2.5 flex-shrink-0 rounded-full transition-all duration-200 {{ request()->routeIs('village-vision-missions.*') ? 'bg-white ring-4 ring-white/10' : 'bg-white/80 group-hover:bg-white group-hover:ring-4 group-hover:ring-white/10' }}"></span>
                                                Visi &amp; Misi
                                            </a>
                                        @endif
                                        @if ($canViewVillageMap)
                                            <a href="{{ route('village-maps.index') }}"
                                                class="group flex items-center rounded-xl px-4 py-2.5 text-sm font-normal text-white transition-all duration-200 {{ request()->routeIs('village-maps.*') ? 'bg-white/24 shadow-sm shadow-black/10' : 'hover:bg-white/12 hover:translate-x-1 hover:shadow-sm hover:shadow-black/10' }}">
                                                <span
                                                    class="mr-3 h-2.5 w-2.5 flex-shrink-0 rounded-full transition-all duration-200 {{ request()->routeIs('village-maps.*') ? 'bg-white ring-4 ring-white/10' : 'bg-white/80 group-hover:bg-white group-hover:ring-4 group-hover:ring-white/10' }}"></span>
                                                Peta Desa
                                            </a>
                                        @endif
                                        @if ($canViewVillageOrganization)
                                            <a href="{{ route('village-organizations.index') }}"
                                                class="group flex items-center rounded-xl px-4 py-2.5 text-sm font-normal text-white transition-all duration-200 {{ request()->routeIs('village-organizations.*') ? 'bg-white/24 shadow-sm shadow-black/10' : 'hover:bg-white/12 hover:translate-x-1 hover:shadow-sm hover:shadow-black/10' }}">
                                                <span
                                                    class="mr-3 h-2.5 w-2.5 flex-shrink-0 rounded-full transition-all duration-200 {{ request()->routeIs('village-organizations.*') ? 'bg-white ring-4 ring-white/10' : 'bg-white/80 group-hover:bg-white group-hover:ring-4 group-hover:ring-white/10' }}"></span>
                                                Struktur Organisasi
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($hasNewsAccess)
                            <div class="rounded-2xl {{ $newsMenuOpen ? 'bg-white/10' : '' }}" data-sidebar-dropdown>
                                <button type="button"
                                    class="flex w-full items-center rounded-xl px-4 py-3 text-left text-sm font-medium transition-all duration-200 {{ $newsMenuOpen ? 'text-white shadow-lg shadow-black/10' : 'text-blue-100 hover:bg-white/10 hover:text-white hover:shadow-lg hover:shadow-black/10' }}"
                                    data-sidebar-dropdown-trigger aria-expanded="{{ $newsMenuOpen ? 'true' : 'false' }}">
                                    <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                                    </svg>
                                    <span class="flex-1">Berita</span>
                                    <svg class="h-4 w-4 flex-shrink-0 transition-transform duration-200 {{ $newsMenuOpen ? 'rotate-180' : '' }}"
                                        data-sidebar-dropdown-chevron fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div class="{{ $newsMenuOpen ? 'block' : 'hidden' }} px-2 pb-2"
                                    data-sidebar-dropdown-panel>
                                    <div class="space-y-1 border-l border-white/15 pl-4">
                                        @if ($canViewPosts)
                                            <a href="{{ route('posts.index') }}"
                                                class="group flex items-center rounded-xl px-4 py-2.5 text-sm font-normal text-white transition-all duration-200 {{ request()->routeIs('posts.*') ? 'bg-white/24 shadow-sm shadow-black/10' : 'hover:bg-white/12 hover:translate-x-1 hover:shadow-sm hover:shadow-black/10' }}">
                                                <span
                                                    class="mr-3 h-2.5 w-2.5 flex-shrink-0 rounded-full transition-all duration-200 {{ request()->routeIs('posts.*') ? 'bg-white ring-4 ring-white/10' : 'bg-white/80 group-hover:bg-white group-hover:ring-4 group-hover:ring-white/10' }}"></span>
                                                Artikel Berita
                                            </a>
                                        @endif
                                        @if ($canViewPostCategories)
                                            <a href="{{ route('post-categories.index') }}"
                                                class="group flex items-center rounded-xl px-4 py-2.5 text-sm font-normal text-white transition-all duration-200 {{ request()->routeIs('post-categories.*') ? 'bg-white/24 shadow-sm shadow-black/10' : 'hover:bg-white/12 hover:translate-x-1 hover:shadow-sm hover:shadow-black/10' }}">
                                                <span
                                                    class="mr-3 h-2.5 w-2.5 flex-shrink-0 rounded-full transition-all duration-200 {{ request()->routeIs('post-categories.*') ? 'bg-white ring-4 ring-white/10' : 'bg-white/80 group-hover:bg-white group-hover:ring-4 group-hover:ring-white/10' }}"></span>
                                                Kategori Berita
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($hasAnnouncementAccess)
                            <a href="{{ route('announcements.index') }}"
                                class="group flex items-center rounded-xl px-4 py-3 text-sm font-medium {{ $announcementMenuOpen ? 'bg-white/20 text-white shadow-lg shadow-black/10' : 'text-blue-100 hover:bg-white/10 hover:text-white hover:translate-x-1 hover:shadow-lg hover:shadow-black/10' }} transition-all duration-200">
                                <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
                                </svg>
                                Pengumuman
                            </a>
                        @endif

                        @if ($canViewGalleries)
                            <a href="{{ route('galleries.index') }}"
                                class="group flex items-center rounded-xl px-4 py-3 text-sm font-medium {{ $galleryMenuOpen ? 'bg-white/20 text-white shadow-lg shadow-black/10' : 'text-blue-100 hover:bg-white/10 hover:text-white hover:translate-x-1 hover:shadow-lg hover:shadow-black/10' }} transition-all duration-200">
                                <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 15.75V6A2.25 2.25 0 0 1 4.5 3.75h15A2.25 2.25 0 0 1 21.75 6v9.75A2.25 2.25 0 0 1 19.5 18H4.5a2.25 2.25 0 0 1-2.25-2.25Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l2.409 2.409a2.25 2.25 0 0 0 3.182 0l3.409-3.409a2.25 2.25 0 0 1 2.159-.591" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10.5 8.25h.008v.008H10.5V8.25Z" />
                                </svg>
                                Galeri Desa
                            </a>
                        @endif

                        @if ($canViewPotentials)
                            <a href="{{ route('potentials.index') }}"
                                class="group flex items-center rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('potentials.*') ? 'bg-white/20 text-white shadow-lg shadow-black/10' : 'text-blue-100 hover:bg-white/10 hover:text-white hover:translate-x-1 hover:shadow-lg hover:shadow-black/10' }} transition-all duration-200">
                                <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 21c4.97-4.97 7.5-8.328 7.5-10.5a7.5 7.5 0 1 0-15 0c0 2.172 2.53 5.53 7.5 10.5Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 12.75a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z" />
                                </svg>
                                Potensi Desa
                            </a>
                        @endif

                        @if ($canViewBudgets)
                            <div class="rounded-2xl {{ $budgetMenuOpen ? 'bg-white/10' : '' }}" data-sidebar-dropdown>
                                <button type="button"
                                    class="flex w-full items-center rounded-xl px-4 py-3 text-left text-sm font-medium transition-all duration-200 {{ $budgetMenuOpen ? 'text-white shadow-lg shadow-black/10' : 'text-blue-100 hover:bg-white/10 hover:text-white hover:shadow-lg hover:shadow-black/10' }}"
                                    data-sidebar-dropdown-trigger aria-expanded="{{ $budgetMenuOpen ? 'true' : 'false' }}">
                                    <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                                    </svg>
                                    <span class="flex-1">APBDes</span>
                                    <svg class="h-4 w-4 flex-shrink-0 transition-transform duration-200 {{ $budgetMenuOpen ? 'rotate-180' : '' }}"
                                        data-sidebar-dropdown-chevron fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div class="{{ $budgetMenuOpen ? 'block' : 'hidden' }} px-2 pb-2"
                                    data-sidebar-dropdown-panel>
                                    <div class="space-y-1 border-l border-white/15 pl-4">
                                        @foreach ($budgetWorkflowSections as $budgetSection)
                                            @php
                                                $isLockedBudgetSection = !$budgetSection['is_unlocked'];
                                                $isActiveBudgetSection = request()->routeIs(
                                                    $budgetSection['route_name'],
                                                );
                                            @endphp

                                            @if ($isLockedBudgetSection)
                                                <div
                                                    class="flex items-center rounded-xl px-4 py-2.5 text-sm font-normal text-blue-100/70">
                                                    <span
                                                        class="mr-3 h-2.5 w-2.5 flex-shrink-0 rounded-full bg-white/40"></span>
                                                    <span class="flex-1">{{ $budgetSection['short_title'] }}</span>
                                                    <span
                                                        class="rounded-full bg-white/10 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-blue-100/80">Lock</span>
                                                </div>
                                            @else
                                                <a href="{{ route($budgetSection['route_name']) }}"
                                                    class="group flex items-center rounded-xl px-4 py-2.5 text-sm font-normal text-white transition-all duration-200 {{ $isActiveBudgetSection ? 'bg-white/24 shadow-sm shadow-black/10' : 'hover:bg-white/12 hover:translate-x-1 hover:shadow-sm hover:shadow-black/10' }}">
                                                    <span
                                                        class="mr-3 h-2.5 w-2.5 flex-shrink-0 rounded-full transition-all duration-200 {{ $isActiveBudgetSection ? 'bg-white ring-4 ring-white/10' : 'bg-white/80 group-hover:bg-white group-hover:ring-4 group-hover:ring-white/10' }}"></span>
                                                    {{ $budgetSection['short_title'] }}
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($canViewCitizens)
                            <div class="rounded-2xl {{ $populationMenuOpen ? 'bg-white/10' : '' }}" data-sidebar-dropdown>
                                <button type="button"
                                    class="flex w-full items-center rounded-xl px-4 py-3 text-left text-sm font-medium transition-all duration-200 {{ $populationMenuOpen ? 'text-white shadow-lg shadow-black/10' : 'text-blue-100 hover:bg-white/10 hover:text-white hover:shadow-lg hover:shadow-black/10' }}"
                                    data-sidebar-dropdown-trigger
                                    aria-expanded="{{ $populationMenuOpen ? 'true' : 'false' }}">
                                    <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                    </svg>

                                    <span class="flex-1">Administrasi Penduduk</span>
                                    <svg class="h-4 w-4 flex-shrink-0 transition-transform duration-200 {{ $populationMenuOpen ? 'rotate-180' : '' }}"
                                        data-sidebar-dropdown-chevron fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div class="{{ $populationMenuOpen ? 'block' : 'hidden' }} px-2 pb-2"
                                    data-sidebar-dropdown-panel>
                                    <div class="space-y-1 border-l border-white/15 pl-4">
                                        @if ($currentUser->hasAnyPermission(['citizens.view', 'users.view']))
                                            <a href="{{ route('citizens.index') }}"
                                                class="group flex items-center rounded-xl px-4 py-2.5 text-sm font-normal text-white transition-all duration-200 {{ request()->routeIs('citizens.*') ? 'bg-white/24 shadow-sm shadow-black/10' : 'hover:bg-white/12 hover:translate-x-1 hover:shadow-sm hover:shadow-black/10' }}">
                                                <span
                                                    class="mr-3 h-2.5 w-2.5 flex-shrink-0 rounded-full transition-all duration-200 {{ request()->routeIs('citizens.*') ? 'bg-white ring-4 ring-white/10' : 'bg-white/80 group-hover:bg-white group-hover:ring-4 group-hover:ring-white/10' }}"></span>
                                                Data Penduduk
                                            </a>
                                        @endif
                                        @if ($currentUser->hasPermission('citizen_births.view'))
                                            <a href="{{ route('citizen-births.index') }}"
                                                class="group flex items-center rounded-xl px-4 py-2.5 text-sm font-normal text-white transition-all duration-200 {{ request()->routeIs('citizen-births.*') ? 'bg-white/24 shadow-sm shadow-black/10' : 'hover:bg-white/12 hover:translate-x-1 hover:shadow-sm hover:shadow-black/10' }}">
                                                <span
                                                    class="mr-3 h-2.5 w-2.5 flex-shrink-0 rounded-full transition-all duration-200 {{ request()->routeIs('citizen-births.*') ? 'bg-white ring-4 ring-white/10' : 'bg-white/80 group-hover:bg-white group-hover:ring-4 group-hover:ring-white/10' }}"></span>
                                                Kelahiran
                                            </a>
                                        @endif
                                        @if ($currentUser->hasPermission('citizen_arrivals.view'))
                                            <a href="{{ route('citizen-arrivals.index') }}"
                                                class="group flex items-center rounded-xl px-4 py-2.5 text-sm font-normal text-white transition-all duration-200 {{ request()->routeIs('citizen-arrivals.*') ? 'bg-white/24 shadow-sm shadow-black/10' : 'hover:bg-white/12 hover:translate-x-1 hover:shadow-sm hover:shadow-black/10' }}">
                                                <span
                                                    class="mr-3 h-2.5 w-2.5 flex-shrink-0 rounded-full transition-all duration-200 {{ request()->routeIs('citizen-arrivals.*') ? 'bg-white ring-4 ring-white/10' : 'bg-white/80 group-hover:bg-white group-hover:ring-4 group-hover:ring-white/10' }}"></span>
                                                Pindah Datang
                                            </a>
                                        @endif
                                        @if ($currentUser->hasPermission('citizen_deaths.view'))
                                            <a href="{{ route('citizen-deaths.index') }}"
                                                class="group flex items-center rounded-xl px-4 py-2.5 text-sm font-normal text-white transition-all duration-200 {{ request()->routeIs('citizen-deaths.*') ? 'bg-white/24 shadow-sm shadow-black/10' : 'hover:bg-white/12 hover:translate-x-1 hover:shadow-sm hover:shadow-black/10' }}">
                                                <span
                                                    class="mr-3 h-2.5 w-2.5 flex-shrink-0 rounded-full transition-all duration-200 {{ request()->routeIs('citizen-deaths.*') ? 'bg-white ring-4 ring-white/10' : 'bg-white/80 group-hover:bg-white group-hover:ring-4 group-hover:ring-white/10' }}"></span>
                                                Kematian
                                            </a>
                                        @endif
                                        @if ($currentUser->hasPermission('households.view'))
                                            <a href="{{ route('households.index') }}"
                                                class="group flex items-center rounded-xl px-4 py-2.5 text-sm font-normal text-white transition-all duration-200 {{ request()->routeIs('households.*') ? 'bg-white/24 shadow-sm shadow-black/10' : 'hover:bg-white/12 hover:translate-x-1 hover:shadow-sm hover:shadow-black/10' }}">
                                                <span
                                                    class="mr-3 h-2.5 w-2.5 flex-shrink-0 rounded-full transition-all duration-200 {{ request()->routeIs('households.*') ? 'bg-white ring-4 ring-white/10' : 'bg-white/80 group-hover:bg-white group-hover:ring-4 group-hover:ring-white/10' }}"></span>
                                                Kartu Keluarga
                                            </a>
                                        @endif
                                        @if ($currentUser->hasPermission('hamlets.view'))
                                            <a href="{{ route('hamlets.index') }}"
                                                class="group flex items-center rounded-xl px-4 py-2.5 text-sm font-normal text-white transition-all duration-200 {{ request()->routeIs('hamlets.*') ? 'bg-white/24 shadow-sm shadow-black/10' : 'hover:bg-white/12 hover:translate-x-1 hover:shadow-sm hover:shadow-black/10' }}">
                                                <span
                                                    class="mr-3 h-2.5 w-2.5 flex-shrink-0 rounded-full transition-all duration-200 {{ request()->routeIs('hamlets.*') ? 'bg-white ring-4 ring-white/10' : 'bg-white/80 group-hover:bg-white group-hover:ring-4 group-hover:ring-white/10' }}"></span>
                                                Dusun
                                            </a>
                                        @endif
                                        @if ($currentUser->hasPermission('rws.view'))
                                            <a href="{{ route('rws.index') }}"
                                                class="group flex items-center rounded-xl px-4 py-2.5 text-sm font-normal text-white transition-all duration-200 {{ request()->routeIs('rws.*') ? 'bg-white/24 shadow-sm shadow-black/10' : 'hover:bg-white/12 hover:translate-x-1 hover:shadow-sm hover:shadow-black/10' }}">
                                                <span
                                                    class="mr-3 h-2.5 w-2.5 flex-shrink-0 rounded-full transition-all duration-200 {{ request()->routeIs('rws.*') ? 'bg-white ring-4 ring-white/10' : 'bg-white/80 group-hover:bg-white group-hover:ring-4 group-hover:ring-white/10' }}"></span>
                                                RW
                                            </a>
                                        @endif
                                        @if ($currentUser->hasPermission('rts.view'))
                                            <a href="{{ route('rts.index') }}"
                                                class="group flex items-center rounded-xl px-4 py-2.5 text-sm font-normal text-white transition-all duration-200 {{ request()->routeIs('rts.*') ? 'bg-white/24 shadow-sm shadow-black/10' : 'hover:bg-white/12 hover:translate-x-1 hover:shadow-sm hover:shadow-black/10' }}">
                                                <span
                                                    class="mr-3 h-2.5 w-2.5 flex-shrink-0 rounded-full transition-all duration-200 {{ request()->routeIs('rts.*') ? 'bg-white ring-4 ring-white/10' : 'bg-white/80 group-hover:bg-white group-hover:ring-4 group-hover:ring-white/10' }}"></span>
                                                RT
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($hasSettingsAccess)
                            <div class="rounded-2xl {{ $settingsMenuOpen ? 'bg-white/10' : '' }}" data-sidebar-dropdown>
                                <button type="button"
                                    class="flex w-full items-center rounded-xl px-4 py-3 text-left text-sm font-medium transition-all duration-200 {{ $settingsMenuOpen ? 'text-white shadow-lg shadow-black/10' : 'text-blue-100 hover:bg-white/10 hover:text-white hover:shadow-lg hover:shadow-black/10' }}"
                                    data-sidebar-dropdown-trigger
                                    aria-expanded="{{ $settingsMenuOpen ? 'true' : 'false' }}">
                                    <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>

                                    <span class="flex-1">Settings</span>
                                    <svg class="h-4 w-4 flex-shrink-0 transition-transform duration-200 {{ $settingsMenuOpen ? 'rotate-180' : '' }}"
                                        data-sidebar-dropdown-chevron fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div class="{{ $settingsMenuOpen ? 'block' : 'hidden' }} px-2 pb-2"
                                    data-sidebar-dropdown-panel>
                                    <div class="space-y-1 border-l border-white/15 pl-4">
                                        @if ($canViewUsers)
                                            <a href="{{ route('users.index') }}"
                                                class="group flex items-center rounded-xl px-4 py-2.5 text-sm font-normal text-white transition-all duration-200 {{ request()->routeIs('users.*') ? 'bg-white/24 shadow-sm shadow-black/10' : 'hover:bg-white/12 hover:translate-x-1 hover:shadow-sm hover:shadow-black/10' }}">
                                                <span
                                                    class="mr-3 h-2.5 w-2.5 flex-shrink-0 rounded-full transition-all duration-200 {{ request()->routeIs('users.*') ? 'bg-white ring-4 ring-white/10' : 'bg-white/80 group-hover:bg-white group-hover:ring-4 group-hover:ring-white/10' }}"></span>
                                                User
                                            </a>
                                        @endif
                                        @if ($canViewRoles)
                                            <a href="{{ route('roles.index') }}"
                                                class="group flex items-center rounded-xl px-4 py-2.5 text-sm font-normal text-white transition-all duration-200 {{ request()->routeIs('roles.*') ? 'bg-white/24 shadow-sm shadow-black/10' : 'hover:bg-white/12 hover:translate-x-1 hover:shadow-sm hover:shadow-black/10' }}">
                                                <span
                                                    class="mr-3 h-2.5 w-2.5 flex-shrink-0 rounded-full transition-all duration-200 {{ request()->routeIs('roles.*') ? 'bg-white ring-4 ring-white/10' : 'bg-white/80 group-hover:bg-white group-hover:ring-4 group-hover:ring-white/10' }}"></span>
                                                Role Permission
                                            </a>
                                        @endif
                                        @if ($canViewAuditLogs)
                                            <a href="{{ route('audit-logs.index') }}"
                                                class="group flex items-center rounded-xl px-4 py-2.5 text-sm font-normal text-white transition-all duration-200 {{ request()->routeIs('audit-logs.*') ? 'bg-white/24 shadow-sm shadow-black/10' : 'hover:bg-white/12 hover:translate-x-1 hover:shadow-sm hover:shadow-black/10' }}">
                                                <span
                                                    class="mr-3 h-2.5 w-2.5 flex-shrink-0 rounded-full transition-all duration-200 {{ request()->routeIs('audit-logs.*') ? 'bg-white ring-4 ring-white/10' : 'bg-white/80 group-hover:bg-white group-hover:ring-4 group-hover:ring-white/10' }}"></span>
                                                Notifikasi Audit
                                            </a>
                                        @endif
                                        @if ($canViewVillageOrganization)
                                            <a href="{{ route('settings.organization-positions.index') }}"
                                                class="group flex items-center rounded-xl px-4 py-2.5 text-sm font-normal text-white transition-all duration-200 {{ request()->routeIs('settings.organization-positions.*') ? 'bg-white/24 shadow-sm shadow-black/10' : 'hover:bg-white/12 hover:translate-x-1 hover:shadow-sm hover:shadow-black/10' }}">
                                                <span
                                                    class="mr-3 h-2.5 w-2.5 flex-shrink-0 rounded-full transition-all duration-200 {{ request()->routeIs('settings.organization-positions.*') ? 'bg-white ring-4 ring-white/10' : 'bg-white/80 group-hover:bg-white group-hover:ring-4 group-hover:ring-white/10' }}"></span>
                                                Master Jabatan
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </nav>

                <!-- User Profile Section -->
                <div class="shrink-0 border-t border-white/10 bg-black/10 p-4">
                    <div class="rounded-lg bg-white/10 p-3">
                        <div class="flex items-center">
                            <img src="{{ $userAvatarUrl ?? '' }}" alt="{{ $currentUser->name }}" data-user-avatar-image
                                class="h-8 w-8 rounded-full object-cover ring-2 ring-white/30 {{ $userAvatarUrl ? '' : 'hidden' }}">
                            <div data-user-avatar-fallback
                                class="w-8 h-8 bg-white rounded-full flex items-center justify-center {{ $userAvatarUrl ? 'hidden' : '' }}">
                                <span class="text-xs font-bold text-blue-600"
                                    data-user-initials>{{ $userInitials }}</span>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-white truncate" data-user-name>{{ $currentUser->name }}
                                </p>
                                <p class="text-xs text-blue-200 truncate" data-user-email>{{ $currentUser->email }}</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="mt-3" id="logout-form">
                            @csrf
                            <button type="button" onclick="confirmLogout()"
                                class="w-full flex items-center justify-center rounded-md bg-white/10 px-3 py-2 text-sm font-medium text-blue-100 transition-colors duration-200 hover:bg-white/20">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div id="main-content" class="main-content transition-all duration-300 ease-in-out">
                <!-- Top Navigation Bar -->
                <nav class="navbar-gradient shadow-sm border-b border-gray-200">
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <!-- Mobile menu button -->
                                <button id="sidebar-toggle" type="button"
                                    class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h16"></path>
                                    </svg>
                                </button>

                                <!-- Breadcrumb -->
                                <nav class="ml-4 md:ml-0">
                                    <ol class="flex items-center space-x-2 text-sm">
                                        <li>
                                            <div class="flex items-center">

                                                <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                    stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                                                </svg>

                                                <a href="{{ route('dashboard') }}"
                                                    class="ml-2 text-gray-500 hover:text-gray-700">Dashboard</a>
                                            </div>
                                        </li>
                                        @if (!request()->routeIs('dashboard'))
                                            <li>
                                                <div class="flex items-center">
                                                    <svg class="h-4 w-4 text-gray-400" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="ml-2 text-gray-700 font-medium">
                                                        @if (!empty($title ?? null))
                                                            {{ $title }}
                                                        @elseif (request()->routeIs('users.*'))
                                                            Manajemen Pengguna
                                                        @elseif(request()->routeIs('posts.*'))
                                                            Berita
                                                        @elseif(request()->routeIs('post-categories.*'))
                                                            Kategori Berita
                                                        @elseif(request()->routeIs('roles.*'))
                                                            Roles & Permissions
                                                        @elseif(request()->routeIs('audit-logs.*'))
                                                            Notifikasi Audit
                                                        @elseif(request()->routeIs('profile.*'))
                                                            Pengaturan Profil
                                                        @elseif(request()->routeIs('budgets.index'))
                                                            APBDes
                                                        @elseif(request()->routeIs('budgets.fiscal-years'))
                                                            Tahun Anggaran APBDes
                                                        @elseif(request()->routeIs('budgets.funding-sources'))
                                                            Sumber Dana APBDes
                                                        @elseif(request()->routeIs('budgets.accounts'))
                                                            Akun APBDes
                                                        @elseif(request()->routeIs('budgets.budget-lines'))
                                                            Baris Anggaran APBDes
                                                        @elseif(request()->routeIs('budgets.operations'))
                                                            Operasional APBDes
                                                        @else
                                                            {{ ucwords(str_replace(['-', '_', '.'], ' ', request()->route()->getName())) }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </li>
                                        @endif
                                    </ol>
                                </nav>
                            </div>

                            <!-- Right side items -->
                            <div class="flex items-center space-x-4">
                                @if ($canViewAuditLogs)
                                    <livewire:admin.audit.notification-dropdown />
                                @endif

                                <div class="relative" data-user-menu>
                                    <button type="button"
                                        class="group flex items-center gap-2 rounded-full border border-gray-200 bg-white px-2 py-1.5 shadow-sm transition hover:border-blue-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        data-user-menu-trigger aria-haspopup="true" aria-expanded="false">
                                        <img src="{{ $userAvatarUrl ?? '' }}" alt="{{ $currentUser->name }}"
                                            data-user-avatar-image
                                            class="h-10 w-10 rounded-full object-cover {{ $userAvatarUrl ? '' : 'hidden' }}">
                                        <div data-user-avatar-fallback
                                            class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-blue-600 to-indigo-800 text-sm font-bold text-white {{ $userAvatarUrl ? 'hidden' : '' }}">
                                            <span data-user-initials>{{ $userInitials }}</span>
                                        </div>
                                        <span
                                            class="flex h-6 w-6 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-500 transition group-hover:text-blue-600">
                                            <svg class="h-3.5 w-3.5 transition-transform duration-200"
                                                data-user-menu-chevron fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </span>
                                    </button>

                                    <div class="absolute right-0 z-50 mt-3 hidden w-80 overflow-hidden rounded-3xl border border-blue-100 bg-white shadow-2xl"
                                        data-user-menu-panel>
                                        <div class="bg-gradient-to-r from-slate-50 to-blue-50 px-5 py-4">
                                            <div class="flex items-center gap-4">
                                                <img src="{{ $userAvatarUrl ?? '' }}" alt="{{ $currentUser->name }}"
                                                    data-user-avatar-image
                                                    class="h-14 w-14 rounded-2xl object-cover ring-2 ring-white {{ $userAvatarUrl ? '' : 'hidden' }}">
                                                <div data-user-avatar-fallback
                                                    class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-800 text-lg font-bold text-white {{ $userAvatarUrl ? 'hidden' : '' }}">
                                                    <span data-user-initials>{{ $userInitials }}</span>
                                                </div>
                                                <div class="min-w-0">
                                                    <div class="truncate text-xl font-normal text-slate-900"
                                                        data-user-name>{{ $currentUser->name }}</div>
                                                    <div class="truncate text-sm text-slate-500" data-user-email>
                                                        {{ $currentUser->email }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="border-t border-gray-100 px-5 py-3">
                                            <div class="text-xs font-normal uppercase tracking-[0.22em] text-slate-400">
                                                Account</div>
                                        </div>
                                        <div class="px-3 pb-3">
                                            <a href="{{ route('profile.index') }}"
                                                class="flex items-center rounded-2xl px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-blue-50 hover:text-blue-700">
                                                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                    </path>
                                                </svg>
                                                Profile Settings
                                            </a>
                                            <form method="POST" action="{{ route('logout') }}" id="topbar-logout-form">
                                                @csrf
                                                <button type="button" onclick="confirmTopbarLogout()"
                                                    class="flex w-full items-center rounded-2xl px-4 py-3 text-sm font-medium text-red-600 transition hover:bg-red-50">
                                                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                                        </path>
                                                    </svg>
                                                    Sign Out
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Page Content -->
                <main class="p-6 min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/40 to-cyan-50/30">
                    <!-- Modern Flash Messages -->
                    @if (session('message'))
                        <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl shadow-lg backdrop-blur-sm"
                            role="alert">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <span class="font-medium">{{ session('message') }}</span>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6 bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl shadow-lg backdrop-blur-sm"
                            role="alert">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <span class="font-medium">{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    @yield('content')
                </main>

                <!-- Modern Footer -->
                <footer class="bg-gradient-to-r from-white via-slate-50 to-blue-50/40 border-t border-gray-200 shadow-lg">
                    <div class="px-6 py-6">
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center space-x-3 text-gray-600">
                                <div
                                    class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-800 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900">{{ config('app.name', 'SatuDesa') }}</div>
                                    <div class="text-xs text-gray-500">© {{ date('Y') }} All rights reserved.</div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-6 text-gray-500">
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                    <span class="text-xs font-medium">Version 1.0.0</span>
                                </div>
                                <div class="hidden md:flex items-center space-x-4">
                                    <a href="#"
                                        class="hover:text-blue-600 transition-colors duration-200 flex items-center space-x-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        <span>Documentation</span>
                                    </a>
                                    <a href="#"
                                        class="hover:text-blue-600 transition-colors duration-200 flex items-center space-x-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z">
                                            </path>
                                        </svg>
                                        <span>Support</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <!-- Mobile sidebar overlay -->
        <div id="sidebar-overlay"
            class="fixed inset-0 z-40 bg-gray-900/75 opacity-0 pointer-events-none transition-opacity duration-300 ease-linear md:hidden">
        </div>

        <script>
            // Sidebar toggle functionality
            document.addEventListener('DOMContentLoaded', function() {
                const sidebarToggle = document.getElementById('sidebar-toggle');
                const sidebar = document.getElementById('sidebar');
                const sidebarOverlay = document.getElementById('sidebar-overlay');
                const mainContent = document.getElementById('main-content');

                function toggleSidebar() {
                    sidebar.classList.toggle('-translate-x-full');
                    sidebarOverlay.classList.toggle('opacity-0');
                    sidebarOverlay.classList.toggle('pointer-events-none');
                }

                if (sidebarToggle) {
                    sidebarToggle.addEventListener('click', toggleSidebar);
                }

                if (sidebarOverlay) {
                    sidebarOverlay.addEventListener('click', toggleSidebar);
                }

                document.querySelectorAll('[data-sidebar-dropdown]').forEach((dropdown) => {
                    const trigger = dropdown.querySelector('[data-sidebar-dropdown-trigger]');
                    const panel = dropdown.querySelector('[data-sidebar-dropdown-panel]');
                    const chevron = dropdown.querySelector('[data-sidebar-dropdown-chevron]');

                    if (!trigger || !panel || !chevron) {
                        return;
                    }

                    trigger.addEventListener('click', () => {
                        const isExpanded = trigger.getAttribute('aria-expanded') === 'true';

                        document.querySelectorAll('[data-sidebar-dropdown]').forEach((
                            otherDropdown) => {
                            if (otherDropdown === dropdown) {
                                return;
                            }

                            const otherTrigger = otherDropdown.querySelector(
                                '[data-sidebar-dropdown-trigger]');
                            const otherPanel = otherDropdown.querySelector(
                                '[data-sidebar-dropdown-panel]');
                            const otherChevron = otherDropdown.querySelector(
                                '[data-sidebar-dropdown-chevron]');

                            if (!otherTrigger || !otherPanel || !otherChevron) {
                                return;
                            }

                            otherTrigger.setAttribute('aria-expanded', 'false');
                            otherPanel.classList.add('hidden');
                            otherPanel.classList.remove('block');
                            otherChevron.classList.remove('rotate-180');
                            otherDropdown.classList.remove('bg-white/10');
                        });

                        trigger.setAttribute('aria-expanded', String(!isExpanded));
                        panel.classList.toggle('hidden', isExpanded);
                        panel.classList.toggle('block', !isExpanded);
                        chevron.classList.toggle('rotate-180', !isExpanded);
                        dropdown.classList.toggle('bg-white/10', !isExpanded);
                    });
                });

                const userMenu = document.querySelector('[data-user-menu]');
                const userMenuTrigger = document.querySelector('[data-user-menu-trigger]');
                const userMenuPanel = document.querySelector('[data-user-menu-panel]');
                const userMenuChevron = document.querySelector('[data-user-menu-chevron]');

                function closeUserMenu() {
                    if (!userMenuPanel || !userMenuTrigger || !userMenuChevron) {
                        return;
                    }

                    userMenuPanel.classList.add('hidden');
                    userMenuTrigger.setAttribute('aria-expanded', 'false');
                    userMenuChevron.classList.remove('rotate-180');
                }

                function toggleUserMenu() {
                    if (!userMenuPanel || !userMenuTrigger || !userMenuChevron) {
                        return;
                    }

                    const isHidden = userMenuPanel.classList.contains('hidden');
                    if (isHidden) {
                        userMenuPanel.classList.remove('hidden');
                        userMenuTrigger.setAttribute('aria-expanded', 'true');
                        userMenuChevron.classList.add('rotate-180');
                    } else {
                        closeUserMenu();
                    }
                }

                if (userMenuTrigger) {
                    userMenuTrigger.addEventListener('click', function(event) {
                        event.stopPropagation();
                        toggleUserMenu();
                    });
                }

                if (userMenuPanel) {
                    userMenuPanel.addEventListener('click', function(event) {
                        event.stopPropagation();
                    });
                }

                document.addEventListener('click', function(event) {
                    if (userMenu && !userMenu.contains(event.target)) {
                        closeUserMenu();
                    }
                });

                document.addEventListener('keydown', function(event) {
                    if (event.key === 'Escape') {
                        closeUserMenu();
                    }
                });

                function syncModalState() {
                    const hasVisibleModal = Array.from(document.querySelectorAll('[data-modal-overlay]'))
                        .some((element) => !element.classList.contains('hidden'));

                    document.body.classList.toggle('modal-open', hasVisibleModal);
                }

                const modalObserver = new MutationObserver(syncModalState);

                modalObserver.observe(document.body, {
                    childList: true,
                    subtree: true,
                    attributes: true,
                    attributeFilter: ['class'],
                });

                syncModalState();

                function syncUserIdentity(data) {
                    if (!data) {
                        return;
                    }

                    document.querySelectorAll('[data-user-name]').forEach((element) => {
                        element.textContent = data.name || element.textContent;
                    });

                    document.querySelectorAll('[data-user-email]').forEach((element) => {
                        element.textContent = data.email || element.textContent;
                    });

                    document.querySelectorAll('[data-user-initials]').forEach((element) => {
                        element.textContent = data.initials || element.textContent;
                    });

                    const hasAvatar = !!data.avatarUrl;

                    document.querySelectorAll('[data-user-avatar-image]').forEach((element) => {
                        if (hasAvatar) {
                            element.src = data.avatarUrl;
                            element.classList.remove('hidden');
                        } else {
                            element.removeAttribute('src');
                            element.classList.add('hidden');
                        }
                    });

                    document.querySelectorAll('[data-user-avatar-fallback]').forEach((element) => {
                        element.classList.toggle('hidden', hasAvatar);
                    });
                }

                document.addEventListener('livewire:init', () => {
                    Livewire.on('profileUpdated', (event) => {
                        const data = Array.isArray(event) ? event[0] : event;
                        syncUserIdentity(data);
                    });
                });
            });
        </script>
    @else
        <!-- Not authenticated content -->
        <div class="min-h-screen flex items-center justify-center">
            <div class="text-center">
                <p class="text-gray-500">Please log in to access the application.</p>
                <a href="{{ route('login') }}"
                    class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Login</a>
            </div>
        </div>
    @endauth

    @livewireScripts

    <!-- SweetAlert2 for modern alerts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')

    <script>
        // Modern Alert System
        window.showAlert = function(type, title, text, options = {}) {
            const config = {
                title: title,
                text: text,
                icon: type,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'OK',
                ...options
            };

            return Swal.fire(config);
        };

        window.showConfirm = function(title, text, confirmText = 'Yes, proceed!', cancelText = 'Cancel') {
            return Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#ef4444',
                confirmButtonText: confirmText,
                cancelButtonText: cancelText,
                reverseButtons: true
            });
        };

        window.showSuccess = function(title, text = '') {
            return showAlert('success', title, text);
        };

        window.showError = function(title, text = '') {
            return showAlert('error', title, text);
        };

        window.showWarning = function(title, text = '') {
            return showAlert('warning', title, text);
        };

        window.showInfo = function(title, text = '') {
            return showAlert('info', title, text);
        };

        // Toast notifications
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        window.showToast = function(type, title) {
            Toast.fire({
                icon: type,
                title: title
            });
        };

        // Handle SatuDesa flash messages with modern alerts
        @if (session('message'))
            showToast('success', '{{ session('message') }}');
        @endif

        @if (session('error'))
            showToast('error', '{{ session('error') }}');
        @endif

        @if (session('warning'))
            showToast('warning', '{{ session('warning') }}');
        @endif

        @if (session('info'))
            showToast('info', '{{ session('info') }}');
        @endif

        // Livewire integration
        document.addEventListener('livewire:init', () => {
            Livewire.on('show-alert', (event) => {
                const data = Array.isArray(event) ? event[0] : event;
                showAlert(data.type, data.title, data.text, data.options || {});
            });

            Livewire.on('show-toast', (event) => {
                const data = Array.isArray(event) ? event[0] : event;
                showToast(data.type, data.title);
            });

            Livewire.on('show-confirm', (event) => {
                const data = Array.isArray(event) ? event[0] : event;
                showConfirm(data.title, data.text, data.confirmText, data.cancelText)
                    .then((result) => {
                        if (result.isConfirmed && data.method) {
                            const component = data.componentId ? Livewire.find(data.componentId) : null;

                            if (component) {
                                component.call(data.method, data.params || {});
                            }
                        }
                    });
            });
        });

        // Logout confirmation
        function confirmLogout() {
            showConfirm(
                'Sign Out',
                'Are you sure you want to sign out?',
                'Yes, sign out',
                'Cancel'
            ).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }

        function confirmTopbarLogout() {
            showConfirm(
                'Sign Out',
                'Are you sure you want to sign out?',
                'Yes, sign out',
                'Cancel'
            ).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('topbar-logout-form').submit();
                }
            });
        }
    </script>
</body>

</html>
