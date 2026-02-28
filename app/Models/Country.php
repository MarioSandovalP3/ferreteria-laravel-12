<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name_es',
        'name_en',
        'country_code',
        'image',
        'iso_code',
        'currency',
        'currency_symbol',
        'timezone',
        'utc_offset',
    ];

    public function regionalSettings()
    {
        return $this->hasMany(RegionalSettings::class);
    }

    public function region()
    {
        return $this->hasOne(Region::class);
    }
    
    public function exchangeRates()
    {
        return $this->hasMany(ExchangeRate::class);
    }
    
    public function currentExchangeRate()
    {
        return $this->hasOne(ExchangeRate::class)
            ->where('effective_date', '<=', now())
            ->where('is_active', true)
            ->latestOfMany('effective_date');
    }
    
    public function getCurrentRate()
    {
        return $this->currentExchangeRate?->rate ?? 1;
    }
}


