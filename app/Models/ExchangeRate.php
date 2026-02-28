<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    protected $fillable = [
        'country_id',
        'rate',
        'effective_date',
        'is_active',
        'notes',
    ];
    
    protected $casts = [
        'rate' => 'decimal:4',
        'effective_date' => 'date',
        'is_active' => 'boolean',
    ];
    
    // Relationships
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    
    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeForCountry($query, $countryId)
    {
        return $query->where('country_id', $countryId);
    }
    
    public function scopeLatestFirst($query)
    {
        return $query->orderBy('effective_date', 'desc');
    }
    
    // Static methods
    public static function getCurrentRate($countryId)
    {
        return static::where('country_id', $countryId)
            ->where('effective_date', '<=', now())
            ->where('is_active', true)
            ->orderBy('effective_date', 'desc')
            ->first();
    }
    
    public static function convertToLocal($usdAmount, $countryId)
    {
        $rate = static::getCurrentRate($countryId);
        return $rate ? $usdAmount * $rate->rate : $usdAmount;
    }
    
    public static function convertToUSD($localAmount, $countryId)
    {
        $rate = static::getCurrentRate($countryId);
        return $rate && $rate->rate > 0 ? $localAmount / $rate->rate : $localAmount;
    }
}
