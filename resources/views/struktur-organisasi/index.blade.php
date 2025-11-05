@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <livewire:struktur.struktur-list />
        <livewire:struktur.struktur-form />
        {{-- <livewire:sejarah.sejarah-modal /> --}}
    </div>
@endsection
