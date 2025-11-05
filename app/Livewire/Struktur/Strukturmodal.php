<?php

namespace App\Livewire\Struktur;

use Livewire\Component;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Blade;

class Strukturmodal extends Component
{

    public bool $showModal = false;
    public string $content = '';

    protected $listeners = ['openVisiMisiModal' => 'openModal'];

    public function openModal()
    {
        // Ambil isi halaman struktur desa
        $rawBlade = File::get(resource_path('views/strukturdesa.blade.php'));

        // Bersihkan layout section supaya tidak ikut render
        $cleanBlade = preg_replace('/@extends\(.*?\)|@section\(.*?\)|@endsection/', '', $rawBlade);

        // Ambil file layout utama (app2.blade.php)
        $layout = File::get(resource_path('views/layouts/app2.blade.php'));

        // Ambil isi CSS inline dari <style>...</style>
        preg_match('/<style.*?>(.*?)<\/style>/s', $layout, $matches);
        $inlineCss = $matches[1] ?? '';

        // Gabungkan CSS inline + isi halaman
        $rendered = "<style>{$inlineCss}</style>" . $cleanBlade;

        // Render hasilnya
        $this->content = Blade::render($rendered);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->reset(['showModal', 'content']);
    }
    public function render()
    {
        return view('livewire.struktur.struktur-modal');
    }
}
