<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Store extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo',
        'banner',
        'favicon',
        'email',
        'phone',
        'whatsapp',
        'address',
        'business_hours',
        'facebook',
        'instagram',
        'twitter',
        'regional_settings_id',
        'tax_rate',
        'shipping_cost',
        'free_shipping_threshold',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_active',
        'maintenance_mode',
    ];

    protected $casts = [
        'business_hours' => 'array',
        'tax_rate' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'free_shipping_threshold' => 'decimal:2',
        'is_active' => 'boolean',
        'maintenance_mode' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($store) {
            if (empty($store->slug)) {
                $store->slug = Str::slug($store->name);
            }
        });
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeNotInMaintenance($query)
    {
        return $query->where('maintenance_mode', false);
    }

    // Relationships
    public function regionalSettings()
    {
        return $this->belongsTo(RegionalSettings::class);
    }

    // Accessors for backward compatibility
    public function getCurrencyAttribute()
    {
        return $this->regionalSettings?->country?->currency ?? 'USD';
    }

    public function getTimezoneAttribute()
    {
        return $this->regionalSettings?->country?->timezone ?? 'UTC';
    }

    public function getCityAttribute()
    {
        return $this->regionalSettings?->country?->name_es ?? null;
    }

    public function getCountryAttribute()
    {
        return $this->regionalSettings?->country?->name_es ?? null;
    }
}
