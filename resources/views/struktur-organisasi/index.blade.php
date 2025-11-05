@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <livewire:struktur.struktur-list />
        <livewire:struktur.struktur-form />
        {{-- <livewire:struktur.struktur-modal /> --}}
    </div>
@endsection
