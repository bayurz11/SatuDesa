@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <livewire:struktur-organisasi.struktur-list />
        <livewire:struktur-organisasi.struktur-form />
        {{-- <livewire:sejarah.sejarah-modal /> --}}
    </div>
@endsection
