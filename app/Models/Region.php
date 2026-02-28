<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = [
        'country_id',
        'region_name',
        'city',
        'zip',
        'lat',
        'lon',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
