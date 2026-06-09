@extends('layouts.app')

@section('content')
<div class="space-y-8 animate-fadeInUp">
    <div class="relative bg-gradient-to-br from-emerald-600 via-teal-700 to-cyan-800 rounded-2xl shadow-2xl overflow-hidden">
        <div class="absolute inset-0 bg-white/10"></div>

        <div class="relative p-8 text-white">
            <h1 class="text-4xl font-bold">{{ $title ?? 'Portal Warga' }}</h1>
            <p class="mt-3 text-emerald-50 max-w-3xl">{{ $description ?? 'Halaman portal warga sudah terdaftar dan siap dihubungkan ke modul layanan.' }}</p>
        </div>
    </div>

    <div class="bg-white shadow-xl rounded-2xl border border-gray-200 p-8">
        <div class="flex items-start justify-between gap-6 flex-col md:flex-row">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Halaman Warga Aktif</h2>
                <p class="mt-2 text-gray-600">Struktur view untuk area warga sudah mengikuti pemisahan area. Implementasi detail modul dapat ditambahkan bertahap tanpa mengubah route lagi.</p>
            </div>

            <div class="rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-800">
                <span class="font-semibold">Route name:</span>
                {{ $routeName ?? request()->route()->getName() }}
            </div>
        </div>
    </div>
</div>
@endsection
