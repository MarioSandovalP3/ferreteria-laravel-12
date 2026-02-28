<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Partner extends Model
{
    protected $fillable = [
        'name',
        'tax_id',
        'address',
        'phone',
        'email',
        'type',
        'is_active',
        'credit_days',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'credit_days' => 'integer',
    ];

    /**
     * Get the roles for the partner.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(PartnerRoleType::class, 'partner_roles', 'partner_id', 'partner_role_type_id');
    }

    /**
     * Check if partner has a specific role.
     */
    public function hasRole(string $roleName): bool
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    /**
     * Check if partner is a customer.
     */
    public function isCustomer(): bool
    {
        return $this->hasRole('customer');
    }

    /**
     * Check if partner is a supplier.
     */
    public function isSupplier(): bool
    {
        return $this->hasRole('supplier');
    }

    /**
     * Check if partner is a reseller.
     */
    public function isReseller(): bool
    {
        return $this->hasRole('reseller');
    }

    /**
     * Get role names as array.
     */
    public function getRoleNamesAttribute(): array
    {
        return $this->roles->pluck('name')->toArray();
    }

    /**
     * Scope to get only suppliers.
     */
    public function scopeSuppliers($query)
    {
        return $query->whereHas('roles', function($q) {
            $q->where('name', 'supplier');
        });
    }
}
