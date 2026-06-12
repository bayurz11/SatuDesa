<?php

namespace Database\Seeders;

use App\Domains\Gallery\Models\Gallery;
use App\Domains\Village\Models\Village;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $village = Village::query()->orderBy('id')->first();

        if (! $village) {
            return;
        }

        if (Gallery::query()->where('village_id', $village->id)->exists()) {
            return;
        }

        foreach (Gallery::defaultEntriesForVillage($village) as $payload) {
            Gallery::query()->create($payload);
        }
    }
}
