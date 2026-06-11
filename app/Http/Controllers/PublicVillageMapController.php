<?php

namespace App\Http\Controllers;

use App\Domains\Village\Models\Village;
use App\Domains\Village\Models\VillageProfile;
use Illuminate\View\View;

class PublicVillageMapController extends Controller
{
    public function index(): View
    {
        $village = Village::query()->orderBy('id')->firstOrFail();
        $defaults = VillageProfile::defaultMapAttributesForVillage($village);

        $profile = VillageProfile::query()->firstOrCreate(
            ['village_id' => $village->id],
            $defaults
        );

        $missingDefaults = collect($defaults)
            ->filter(function ($value, string $key) use ($profile) {
                return blank($profile->{$key}) && filled($value);
            })
            ->all();

        if ($missingDefaults !== []) {
            $profile->fill($missingDefaults)->save();
        }

        return view('pages.public.village-map', compact('village', 'profile'));
    }
}
