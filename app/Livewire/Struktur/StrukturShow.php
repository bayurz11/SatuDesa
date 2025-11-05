<?php

namespace App\Livewire\Struktur;

use Livewire\Component;
use App\Domains\Struktur\Models\Struktur;

class StrukturShow extends Component
{
    public ?Struktur $pimpinan = null;

    // Sekretariat & Keuangan (2 kartu)
    public $sekretariat; // Sekretaris Desa
    public $bendahara;   // Bendahara Desa

    // Kepala Urusan (3 kartu)
    public $kaurUmum;
    public $kaurKeuangan;
    public $kaurPembangunan;

    // Kewilayahan (4 kartu: 2 RW + 2 RT)
    public $rw01;
    public $rw02;
    public $rt01;
    public $rt02;

    public function mount(): void
    {
        // ===== Pimpinan =====
        $this->pimpinan = Struktur::active()
            ->where('level', Struktur::LEVEL_PIMPINAN)
            ->where(function ($q) {
                $q->where('jabatan', 'Kepala Desa')
                    ->orWhere('jabatan', 'like', '%Kepala Desa%');
            })
            ->first();

        // ===== Sekretariat & Keuangan =====
        $sekretariat = Struktur::active()
            ->where('level', Struktur::LEVEL_STRUKTURAL)
            ->whereIn('jabatan', ['Sekretaris Desa', 'Bendahara Desa'])
            ->orderByRaw("FIELD(jabatan,'Sekretaris Desa','Bendahara Desa')")
            ->get()
            ->keyBy('jabatan');

        $this->sekretariat = $sekretariat->get('Sekretaris Desa');
        $this->bendahara   = $sekretariat->get('Bendahara Desa');

        // ===== Kepala Urusan =====
        $kaur = Struktur::active()
            ->where('level', Struktur::LEVEL_STRUKTURAL)
            ->whereIn('jabatan', ['Kaur Umum', 'Kaur Keuangan', 'Kaur Pembangunan'])
            ->orderByRaw("FIELD(jabatan,'Kaur Umum','Kaur Keuangan','Kaur Pembangunan')")
            ->get()
            ->keyBy('jabatan');

        $this->kaurUmum         = $kaur->get('Kaur Umum');
        $this->kaurKeuangan     = $kaur->get('Kaur Keuangan');
        $this->kaurPembangunan  = $kaur->get('Kaur Pembangunan');

        // ===== Kewilayahan (ambil yang ada; fallback akan ditangani di view) =====
        $rw = Struktur::active()
            ->where('level', Struktur::LEVEL_KEWILAYAHAN)
            ->where('jabatan', 'like', 'RW%')
            ->orderBy('jabatan')
            ->take(2)->get()->values();

        $rt = Struktur::active()
            ->where('level', Struktur::LEVEL_KEWILAYAHAN)
            ->where('jabatan', 'like', 'RT%')
            ->orderBy('jabatan')
            ->take(2)->get()->values();

        $this->rw01 = $rw->get(0);
        $this->rw02 = $rw->get(1);
        $this->rt01 = $rt->get(0);
        $this->rt02 = $rt->get(1);
    }

    public function render()
    {
        return view('livewire.struktur.struktur-show');
    }
}
