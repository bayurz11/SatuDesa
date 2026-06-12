<?php

namespace App\Exports;

use App\Domains\Citizen\Models\Citizen;
use App\Support\SpreadsheetValueSanitizer;
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
            SpreadsheetValueSanitizer::escape($citizen->nik),
            SpreadsheetValueSanitizer::escape($citizen->full_name),
            SpreadsheetValueSanitizer::escape($citizen->gender),
            SpreadsheetValueSanitizer::escape($citizen->birth_place),
            SpreadsheetValueSanitizer::escape($citizen->birth_date?->format('Y-m-d')),
            SpreadsheetValueSanitizer::escape($citizen->religion),
            SpreadsheetValueSanitizer::escape($citizen->marital_status),
            SpreadsheetValueSanitizer::escape($citizen->occupation),
            SpreadsheetValueSanitizer::escape($citizen->education),
            SpreadsheetValueSanitizer::escape($citizen->citizenship),
            SpreadsheetValueSanitizer::escape($citizen->address),
            SpreadsheetValueSanitizer::escape($citizen->status),
            SpreadsheetValueSanitizer::escape($citizen->household?->no_kk),
        ];
    }
}
