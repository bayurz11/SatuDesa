<?php

namespace App\Imports;

use App\Domains\Citizen\Models\Citizen;
use App\Domains\Household\Models\Household;
use App\Support\CitizenReferenceData;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CitizensImport implements ToCollection, WithHeadingRow
{
    public int $created = 0;
    public int $updated = 0;
    public array $errors = [];

    public function collection(Collection $rows): void
    {
        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2;

            if (collect($row)->filter(fn ($value) => $value !== null && $value !== '')->isEmpty()) {
                continue;
            }

            $payload = [
                'nik' => trim((string) ($row['nik'] ?? '')),
                'full_name' => trim((string) ($row['full_name'] ?? '')),
                'gender' => CitizenReferenceData::normalizeGender($row['gender'] ?? null),
                'birth_place' => $this->nullableString($row['birth_place'] ?? null),
                'birth_date' => $this->normalizeDate($row['birth_date'] ?? null),
                'religion' => $this->nullableString($row['religion'] ?? null),
                'marital_status' => $this->nullableString($row['marital_status'] ?? null),
                'occupation' => $this->nullableString($row['occupation'] ?? null),
                'education' => $this->nullableString($row['education'] ?? null),
                'citizenship' => CitizenReferenceData::normalizeCitizenship($row['citizenship'] ?? 'WNI') ?? 'WNI',
                'address' => $this->nullableString($row['address'] ?? null),
                'status' => strtolower(trim((string) ($row['status'] ?? 'active'))),
                'household_id' => $this->resolveHouseholdId($row['no_kk'] ?? null),
            ];

            $validator = Validator::make($payload, [
                'nik' => ['required', 'string', 'max:255', Rule::unique('citizens', 'nik')->ignore(Citizen::where('nik', $payload['nik'])->value('id'))],
                'full_name' => ['required', 'string', 'max:255'],
                'gender' => ['required', Rule::in(array_keys(CitizenReferenceData::genderOptions()))],
                'birth_place' => ['nullable', 'string', 'max:255'],
                'birth_date' => ['nullable', 'date'],
                'religion' => ['nullable', Rule::in(CitizenReferenceData::religionOptions())],
                'marital_status' => ['nullable', Rule::in(CitizenReferenceData::maritalStatusOptions())],
                'occupation' => ['nullable', Rule::in(CitizenReferenceData::occupationOptions())],
                'education' => ['nullable', Rule::in(CitizenReferenceData::educationOptions())],
                'citizenship' => ['nullable', Rule::in(CitizenReferenceData::citizenshipOptions())],
                'address' => ['nullable', 'string'],
                'status' => ['required', Rule::in(array_keys(CitizenReferenceData::statusOptions()))],
                'household_id' => ['nullable', 'exists:households,id'],
            ]);

            if ($validator->fails()) {
                $this->errors[] = "Baris {$rowNumber}: " . $validator->errors()->first();
                continue;
            }

            $existing = Citizen::where('nik', $payload['nik'])->first();

            Citizen::updateOrCreate(
                ['nik' => $payload['nik']],
                $payload
            );

            if ($existing) {
                $this->updated++;
            } else {
                $this->created++;
            }
        }
    }

    private function nullableString(mixed $value): ?string
    {
        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }

    private function normalizeDate(mixed $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        try {
            if (is_numeric($value)) {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((float) $value)->format('Y-m-d');
            }

            return Carbon::parse((string) $value)->format('Y-m-d');
        } catch (\Throwable) {
            return null;
        }
    }

    private function resolveHouseholdId(mixed $noKk): ?int
    {
        $noKk = trim((string) $noKk);

        if ($noKk === '') {
            return null;
        }

        return Household::where('no_kk', $noKk)->value('id');
    }
}
