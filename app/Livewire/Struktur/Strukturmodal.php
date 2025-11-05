<?php

namespace App\Livewire\Struktur;

use Livewire\Component;

class StrukturModal extends Component
{
    public bool $showModal = false;

    protected $listeners = ['openStrukturModal' => 'openModal'];

    public function openModal(): void
    {
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.struktur.struktur-modal');
    }
}
