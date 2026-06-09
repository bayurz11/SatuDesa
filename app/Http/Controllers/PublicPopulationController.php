<?php

namespace App\Http\Controllers;

use App\Domains\Citizen\Models\Citizen;
use App\Domains\Hamlet\Models\Hamlet;
use App\Domains\Household\Models\Household;
use App\Domains\Rt\Models\Rt;
use App\Domains\Rw\Models\Rw;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;

class PublicPopulationController extends Controller
{
    public function index(): View
    {
        $citizensQuery = Citizen::query()->with(['household.hamlet:id,name']);
        $householdsQuery = Household::query()->with(['hamlet:id,name']);

        $citizens = $citizensQuery->get([
            'id',
            'household_id',
            'gender',
            'birth_date',
            'religion',
            'education',
            'occupation',
            'status',
            'updated_at',
        ]);

        $households = $householdsQuery->get([
            'id',
            'hamlet_id',
            'updated_at',
        ]);

        $totalCitizens = $citizens->count();
        $totalHouseholds = $households->count();
        $totalHamlets = Hamlet::query()->count();
        $totalRws = Rw::query()->count();
        $totalRts = Rt::query()->count();
        $maleCitizens = $citizens->filter(fn (Citizen $citizen) => $this->normalizeGender($citizen->gender) === 'L')->count();
        $femaleCitizens = $citizens->filter(fn (Citizen $citizen) => $this->normalizeGender($citizen->gender) === 'P')->count();
        $activeCitizens = $citizens->where('status', 'active')->count();

        $ageGroups = [
            'Balita (0-5)' => 0,
            'Anak (6-12)' => 0,
            'Remaja (13-17)' => 0,
            'Produktif (18-59)' => 0,
            'Lansia (60+)' => 0,
        ];

        foreach ($citizens as $citizen) {
            if (! $citizen->birth_date) {
                continue;
            }

            $age = Carbon::parse($citizen->birth_date)->age;

            if ($age <= 5) {
                $ageGroups['Balita (0-5)']++;
            } elseif ($age <= 12) {
                $ageGroups['Anak (6-12)']++;
            } elseif ($age <= 17) {
                $ageGroups['Remaja (13-17)']++;
            } elseif ($age <= 59) {
                $ageGroups['Produktif (18-59)']++;
            } else {
                $ageGroups['Lansia (60+)']++;
            }
        }

        $hamletStats = $households
            ->groupBy(fn (Household $household) => $household->hamlet?->name ?? 'Belum Terpetakan')
            ->map(function ($items, $hamletName) use ($citizens) {
                $householdIds = $items->pluck('id');
                $hamletCitizens = $citizens->whereIn('household_id', $householdIds);

                return [
                    'name' => $hamletName,
                    'households' => $items->count(),
                    'citizens' => $hamletCitizens->count(),
                    'male' => $hamletCitizens->filter(fn (Citizen $citizen) => $this->normalizeGender($citizen->gender) === 'L')->count(),
                    'female' => $hamletCitizens->filter(fn (Citizen $citizen) => $this->normalizeGender($citizen->gender) === 'P')->count(),
                ];
            })
            ->sortByDesc('citizens')
            ->values();

        $religionStats = $citizens
            ->groupBy(fn (Citizen $citizen) => $citizen->religion ?: 'Belum Diisi')
            ->map(fn ($items, $religion) => [
                'label' => $religion,
                'total' => $items->count(),
            ])
            ->sortByDesc('total')
            ->values();

        $educationStats = $citizens
            ->groupBy(fn (Citizen $citizen) => $citizen->education ?: 'Belum Diisi')
            ->map(fn ($items, $education) => [
                'label' => $education,
                'total' => $items->count(),
            ])
            ->sortByDesc('total')
            ->take(6)
            ->values();

        $occupationStats = $citizens
            ->groupBy(fn (Citizen $citizen) => $citizen->occupation ?: 'Belum Diisi')
            ->map(fn ($items, $occupation) => [
                'label' => $occupation,
                'total' => $items->count(),
            ])
            ->sortByDesc('total')
            ->take(6)
            ->values();

        $areaStats = collect([
            ['label' => 'Dusun', 'total' => $totalHamlets],
            ['label' => 'RW', 'total' => $totalRws],
            ['label' => 'RT', 'total' => $totalRts],
        ]);

        $lastUpdated = collect([
            $citizens->max('updated_at'),
            $households->max('updated_at'),
        ])->filter()->max();

        return view('pages.public.population', compact(
            'totalCitizens',
            'totalHouseholds',
            'totalHamlets',
            'totalRws',
            'totalRts',
            'maleCitizens',
            'femaleCitizens',
            'activeCitizens',
            'ageGroups',
            'hamletStats',
            'religionStats',
            'educationStats',
            'occupationStats',
            'areaStats',
            'lastUpdated'
        ));
    }

    private function normalizeGender(?string $gender): ?string
    {
        return match (mb_strtolower(trim((string) $gender))) {
            'l', 'laki-laki' => 'L',
            'p', 'perempuan' => 'P',
            default => null,
        };
    }
}
