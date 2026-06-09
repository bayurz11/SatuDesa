<?php

namespace App\Exports;

use App\Domains\Citizen\Models\Citizen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CitizensExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    public function __construct(
        private readonly ?string $search = null,
        private readonly ?string $status = null,
        private readonly ?string $gender = null,
    ) {
    }

    public function collection()
    {
        return Citizen::query()
            ->with('household:id,no_kk,address')
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery
                        ->where('full_name', 'like', '%' . $this->search . '%')
                        ->orWhere('nik', 'like', '%' . $this->search . '%')
                        ->orWhere('occupation', 'like', '%' . $this->search . '%')
                        ->orWhereHas('household', function ($householdQuery) {
                            $householdQuery->where('no_kk', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->status, fn ($query) => $query->where('status', $this->status))
            ->when($this->gender, fn ($query) => $query->where('gender', $this->gender))
            ->orderBy('full_name')
            ->get();
    }

    public function headings(): array
    {
        return [
            'NIK',
            'Nama Lengkap',
            'Gender',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Agama',
            'Status Perkawinan',
            'Pekerjaan',
            'Pendidikan',
            'Kewarganegaraan',
            'Alamat',
            'Status Penduduk',
            'No KK',
        ];
    }

    public function map($citizen): array
    {
        return [
            $citizen->nik,
            $citizen->full_name,
            $citizen->gender,
            $citizen->birth_place,
            $citizen->birth_date?->format('Y-m-d'),
            $citizen->religion,
            $citizen->marital_status,
            $citizen->occupation,
            $citizen->education,
            $citizen->citizenship,
            $citizen->address,
            $citizen->status,
            $citizen->household?->no_kk,
        ];
    }
}
