<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PartnerRoleType extends Model
{
    protected $table = 'partner_role_types';
    
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get the partners that have this role.
     */
    public function partners(): BelongsToMany
    {
        return $this->belongsToMany(Partner::class, 'partner_roles', 'partner_role_type_id', 'partner_id');
    }
}
