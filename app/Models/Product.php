<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'parent_id',
        'is_variant',
        'category_id',
        'product_type',
        'sku',
        'barcode',
        'name',
        'slug',
        'short_description',
        'description',
        'price',
        'compare_at_price',
        'cost',
        'tax_rate',
        'is_tax_exempt',
        'on_sale',
        'sale_price',
        'sale_starts_at',
        'sale_ends_at',
        'stock',
        'low_stock_threshold',
        'track_inventory',
        'allow_backorder',
        'stock_status',
        'weight',
        'length',
        'width',
        'height',
        'requires_shipping',
        'duration',
        'booking_required',
        'max_bookings_per_day',
        'file_type',
        'file_path',
        'download_url',
        'preview_url',
        'file_size',
        'version',
        'download_limit',
        'download_expiry_days',
        'featured_image',
        'images',
        'brand_id',
        'model',
        'specifications',
        'features',
        'variant_attributes',
        'is_active',
        'status',
        'is_featured',
        'is_new',
        'views',
        'order',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_at_price' => 'decimal:2',
        'cost' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'is_tax_exempt' => 'boolean',
        'sale_price' => 'decimal:2',
        'on_sale' => 'boolean',
        'sale_starts_at' => 'datetime',
        'sale_ends_at' => 'datetime',
        'stock' => 'integer',
        'low_stock_threshold' => 'integer',
        'track_inventory' => 'boolean',
        'allow_backorder' => 'boolean',
        'weight' => 'decimal:2',
        'length' => 'decimal:2',
        'width' => 'decimal:2',
        'height' => 'decimal:2',
        'images' => 'array',
        'specifications' => 'array',
        'features' => 'array',
        'variant_attributes' => 'array',
        'is_variant' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_new' => 'boolean',
        'views' => 'integer',
        'order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            if (empty($product->sku)) {
                $product->sku = 'PRD-' . strtoupper(Str::random(8));
            }
        });

        static::updating(function ($product) {
            // Update stock status based on stock quantity
            if ($product->track_inventory) {
                if ($product->stock <= 0) {
                    $product->stock_status = $product->allow_backorder ? 'on_backorder' : 'out_of_stock';
                } else {
                    $product->stock_status = 'in_stock';
                }
            }
        });
    }

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    // Variant Relationships
    public function parent()
    {
        return $this->belongsTo(Product::class, 'parent_id');
    }

    public function variants()
    {
        return $this->hasMany(Product::class, 'parent_id')->where('is_variant', true);
    }

    public function inventoryMovements()
    {
        return $this->hasMany(InventoryMovement::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where('status', '!=', 'draft');
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_status', 'in_stock');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeNew($query)
    {
        return $query->where('is_new', true);
    }

    public function scopeOnSale($query)
    {
        return $query->where('on_sale', true);
    }

    public function scopeInCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('sku', 'like', "%{$search}%")
              ->orWhere('brand', 'like', "%{$search}%");
        });
    }

    // Variant Scopes
    public function scopeParentProducts($query)
    {
        return $query->whereNull('parent_id')->where('is_variant', false);
    }

    public function scopeVariantProducts($query)
    {
        return $query->whereNotNull('parent_id')->where('is_variant', true);
    }

    public function scopeWithVariants($query)
    {
        return $query->with(['variants' => function ($q) {
            $q->where('is_active', true)->orderBy('price');
        }]);
    }

    // Accessors
    public function getCurrentPriceAttribute()
    {
        if ($this->is_on_sale && $this->sale_price) {
            return $this->sale_price;
        }
        return $this->price;
    }

    public function getIsOnSaleAttribute()
    {
        if (!$this->on_sale || !$this->sale_price) {
            return false;
        }
        
        $now = now();
        
        if ($this->sale_starts_at && $now->lt($this->sale_starts_at)) {
            return false;
        }
        
        if ($this->sale_ends_at && $now->gt($this->sale_ends_at)) {
            return false;
        }
        
        return true;
    }

    public function getDiscountPercentageAttribute()
    {
        if (!$this->is_on_sale || !$this->compare_at_price) {
            return 0;
        }
        
        return round((($this->compare_at_price - $this->current_price) / $this->compare_at_price) * 100);
    }

    public function getIsLowStockAttribute()
    {
        if (!$this->track_inventory) {
            return false;
        }
        
        return $this->stock <= $this->low_stock_threshold && $this->stock > 0;
    }

    public function getIsOutOfStockAttribute()
    {
        return $this->stock_status === 'out_of_stock';
    }

    public function getFormattedPriceAttribute()
    {
        return 'DOP $' . number_format($this->current_price, 2);
    }

    // Variant Accessors
    public function getTotalStockAttribute()
    {
        if ($this->is_variant || $this->parent_id) {
            return $this->stock;
        }
        
        // For parent products, sum variant stock
        return $this->variants()->sum('stock');
    }

    public function getHasVariantsAttribute()
    {
        return !$this->is_variant && $this->variants()->count() > 0;
    }

    public function getVariantCountAttribute()
    {
        return $this->variants()->count();
    }

    public function getAvailableVariantsAttribute()
    {
        return $this->variants()
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->get();
    }

    public function getPriceRangeAttribute()
    {
        if ($this->is_variant) {
            return null;
        }

        $variants = $this->variants()->where('is_active', true)->get();
        
        if ($variants->isEmpty()) {
            return null;
        }

        $minPrice = $variants->min('price');
        $maxPrice = $variants->max('price');

        if ($minPrice == $maxPrice) {
            return 'DOP $' . number_format($minPrice, 2);
        }

        return 'DOP $' . number_format($minPrice, 2) . ' - DOP $' . number_format($maxPrice, 2);
    }

    // Methods
    public function incrementViews()
    {
        $this->increment('views');
    }

    public function decrementStock($quantity)
    {
        try {
            if ($this->track_inventory) {
                $this->decrement('stock', $quantity);
            }
            return true;
        } catch (\Exception $e) {
            \Log::error('Product stock decrement failed', [
                'product_id' => $this->id,
                'product_name' => $this->name,
                'quantity' => $quantity,
                'current_stock' => $this->stock,
                'error' => $e->getMessage()
            ]);
            
            throw $e;
        }
    }

    public function incrementStock($quantity)
    {
        try {
            if ($this->track_inventory) {
                $this->increment('stock', $quantity);
            }
            return true;
        } catch (\Exception $e) {
            \Log::error('Product stock increment failed', [
                'product_id' => $this->id,
                'product_name' => $this->name,
                'quantity' => $quantity,
                'current_stock' => $this->stock,
                'error' => $e->getMessage()
            ]);
            
            throw $e;
        }
    }
}
