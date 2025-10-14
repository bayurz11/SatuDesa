<?php

namespace App\Livewire\Sejarah;

use Livewire\Component;
use App\Domains\Sejarah\Models\Sejarah;

class SejarahShow extends Component
{
    public ?Sejarah $sejarah = null;

    public function mount()
    {
        $this->sejarah = Sejarah::query()
            ->where('is_active', true)
            ->orderByDesc('tanggal')
            // ->with('timelines') // hapus jika tidak pakai timeline
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.sejarah.sejarah-show', [
            'sejarah' => $this->sejarah,
        ]);
    }
}
