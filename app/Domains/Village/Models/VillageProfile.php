<?php

namespace App\Domains\Village\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class VillageProfile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'village_id',
        'description',
        'vision',
        'mission',
        'address',
        'phone',
        'email',
        'website',
        'logo_path',
        'map_title',
        'map_description',
        'map_latitude',
        'map_longitude',
        'map_zoom',
        'map_popup_title',
        'map_popup_description',
        'map_info_title',
        'map_boundary_title',
        'map_boundary_description',
        'map_facility_title',
        'map_facility_description',
        'map_potential_title',
        'map_potential_description',
        'map_note',
        'map_markers',
    ];

    protected $casts = [
        'map_latitude' => 'decimal:7',
        'map_longitude' => 'decimal:7',
        'map_zoom' => 'integer',
        'map_markers' => 'array',
    ];

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }
}
