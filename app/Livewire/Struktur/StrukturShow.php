<?php

namespace App\Livewire\Struktur;

use Livewire\Component;
use App\Domains\Struktur\Models\Struktur;

class StrukturShow extends Component
{
    // Pimpinan
    public ?Struktur $pimpinan = null;

    // Sekretariat (3 kartu)
    public $sekretaris;             // Sekretaris Desa
    public $kaurKeuangan;           // Kaur Keuangan
    public $kaurUmumPerencanaan;    // Kaur Umum & Perencanaan

    // Seksi (3 kartu)
    public $kasiPemerintahan;
    public $kasiKesejahteraan;
    public $kasiPelayanan;

    // Kewilayahan (3 Kadus)
    public $kadusMentuda;
    public $kadusPulunJelutung;
    public $kadusTembokMentengah;

    public function mount(): void
    {
        // ===== Pimpinan =====
        $this->pimpinan = Struktur::active()
            ->where('level', Struktur::LEVEL_PIMPINAN)
            ->where('jabatan', 'Kepala Desa')
            ->first();

        // ===== Sekretariat =====
        $sekret = Struktur::active()
            ->where('level', Struktur::LEVEL_STRUKTURAL)
            ->whereIn('jabatan', [
                'Sekretaris Desa',
                'Kaur Keuangan',
                'Kaur Umum & Perencanaan',
            ])
            ->orderByRaw("FIELD(jabatan,'Sekretaris Desa','Kaur Keuangan','Kaur Umum & Perencanaan')")
            ->get()
            ->keyBy('jabatan');

        $this->sekretaris            = $sekret->get('Sekretaris Desa');
        $this->kaurKeuangan          = $sekret->get('Kaur Keuangan');
        $this->kaurUmumPerencanaan   = $sekret->get('Kaur Umum & Perencanaan');

        // ===== Seksi =====
        $seksi = Struktur::active()
            ->where('level', Struktur::LEVEL_STRUKTURAL)
            ->whereIn('jabatan', [
                'Kasi Pemerintahan',
                'Kasi Kesejahteraan',
                'Kasi Pelayanan',
            ])
            ->orderByRaw("FIELD(jabatan,'Kasi Pemerintahan','Kasi Kesejahteraan','Kasi Pelayanan')")
            ->get()
            ->keyBy('jabatan');

        $this->kasiPemerintahan  = $seksi->get('Kasi Pemerintahan');
        $this->kasiKesejahteraan = $seksi->get('Kasi Kesejahteraan');
        $this->kasiPelayanan     = $seksi->get('Kasi Pelayanan');

        // ===== Kewilayahan (3 Kadus) =====
        $kadus = Struktur::active()
            ->where('level', Struktur::LEVEL_KEWILAYAHAN)
            ->whereIn('jabatan', [
                'Kepala Dusun Mentuda',
                'Kepala Dusun Pulun & Jelutung',
                'Kepala Dusun Tembok & Mentengah',
            ])
            ->orderByRaw("FIELD(jabatan,'Kepala Dusun Mentuda','Kepala Dusun Pulun & Jelutung','Kepala Dusun Tembok & Mentengah')")
            ->get()
            ->keyBy('jabatan');

        $this->kadusMentuda         = $kadus->get('Kepala Dusun Mentuda');
        $this->kadusPulunJelutung   = $kadus->get('Kepala Dusun Pulun & Jelutung');
        $this->kadusTembokMentengah = $kadus->get('Kepala Dusun Tembok & Mentengah');
    }

    public function render()
    {
        return view('livewire.struktur.struktur-show');
    }
}
