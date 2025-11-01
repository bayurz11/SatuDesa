<?php

namespace App\Livewire\Sejarah;

use Livewire\Component;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;

class SejarahModal extends Component
{
    public bool $showModal = false;

    protected $listeners = ['openSejarahModal' => 'openModal'];

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->reset('showModal');
    }

    public function render()
    {
        return view('livewire.sejarah.sejarah-modal');
    }
}
