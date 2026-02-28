<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use SoftDeletes;

    // Product type constants
    const TYPE_PHYSICAL = 'physical';
    const TYPE_SERVICE = 'service';
    const TYPE_DIGITAL = 'digital';

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'product_type',
        'description',
        'image',
        'icon',
        'order',
        'is_active',
        'is_featured',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'attribute_schema',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'order' => 'integer',
        'attribute_schema' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // Relationships
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('order');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public function scopeForProductType($query, $type)
    {
        return $query->where('product_type', $type);
    }

    // Accessors
    public function getProductCountAttribute()
    {
        return $this->products()->count();
    }

    public function getHasChildrenAttribute()
    {
        return $this->children()->count() > 0;
    }

    // Attribute Schema Accessors
    public function getRequiredAttributesAttribute()
    {
        return $this->attribute_schema['required_attributes'] ?? [];
    }

    public function getOptionalAttributesAttribute()
    {
        return $this->attribute_schema['optional_attributes'] ?? [];
    }

    public function getAllAttributesAttribute()
    {
        return array_merge($this->required_attributes, $this->optional_attributes);
    }
}
