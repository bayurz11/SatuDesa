@extends('layouts.app')

@section('content')
<div class="space-y-8 animate-fadeInUp">
    <div class="relative bg-gradient-to-br from-slate-700 via-slate-800 to-slate-900 rounded-2xl shadow-2xl overflow-hidden">
        <div class="absolute inset-0 bg-white/5"></div>

        <div class="relative p-8 text-white">
            <h1 class="text-4xl font-bold">{{ $title ?? 'Admin Section' }}</h1>
            <p class="mt-3 text-slate-200 max-w-3xl">{{ $description ?? 'Halaman admin ini sudah terdaftar, tetapi implementasi fitur detailnya belum dibuat.' }}</p>
        </div>
    </div>

    <div class="bg-white shadow-xl rounded-2xl border border-gray-200 p-8">
        <div class="flex items-start justify-between gap-6 flex-col md:flex-row">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Modul Siap Di-wire</h2>
                <p class="mt-2 text-gray-600">Route ini sudah aktif sehingga navigasi dashboard tidak gagal. Anda bisa lanjut menghubungkannya ke Livewire, controller, atau view final kapan saja.</p>
            </div>

            <div class="rounded-xl bg-slate-50 border border-slate-200 px-4 py-3 text-sm text-slate-700">
                <span class="font-semibold">Route name:</span>
                {{ $routeName ?? request()->route()->getName() }}
            </div>
        </div>
    </div>
</div>
@endsection
