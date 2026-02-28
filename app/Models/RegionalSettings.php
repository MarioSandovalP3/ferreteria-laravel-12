<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegionalSettings extends Model
{
    protected $fillable = [
        'date_format',
        'country_id',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
