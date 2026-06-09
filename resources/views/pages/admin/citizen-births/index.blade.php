@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <livewire:admin.citizen-births.citizen-birth-list />
        <livewire:admin.citizen-births.citizen-birth-form />
    </div>
@endsection
