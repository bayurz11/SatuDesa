<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CitizensImportTemplateExport implements FromArray, ShouldAutoSize, WithHeadings
{
    public function headings(): array
    {
        return [
            'nik',
            'full_name',
            'gender',
            'birth_place',
            'birth_date',
            'religion',
            'marital_status',
            'occupation',
            'education',
            'citizenship',
            'address',
            'status',
            'no_kk',
        ];
    }

    public function array(): array
    {
        return [
            [
                '2104011201800001',
                'Ahmad Fauzi',
                'L',
                'Lingga',
                '1980-01-12',
                'Islam',
                'Kawin',
                'Nelayan/Perikanan',
                'SLTA/Sederajat',
                'WNI',
                'Jl. Pelantar Bahari No. 01',
                'active',
                '2104010101010001',
            ],
        ];
    }
}
