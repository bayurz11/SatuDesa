<?php

namespace App\Livewire\VisiMisi;

use Livewire\Component;
use App\Domains\Visimisi\Models\Visimisi;

class VisiMisiShow extends Component
{
    public ?Visimisi $visi = null;
    public ?Visimisi $misi = null;

    public function mount()
    {
        $this->visi = Visimisi::where('kategori', 'visi')
            ->where('is_active', true)
            ->orderByDesc('id')
            ->first();

        $this->misi = Visimisi::where('kategori', 'misi')
            ->where('is_active', true)
            ->orderByDesc('id')
            ->first();
    }

    public function render()
    {
        return view('livewire.visi-misi.visi-misi-show', [
            'visi' => $this->visi,
            'misi' => $this->misi,
        ]);
    }
}
