<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseItem extends Model
{
    protected $fillable = [
        'purchase_id',
        'product_id',
        'quantity',
        'cost',
        'subtotal',
        'previous_cost',
        'new_average_cost',
        'tax_rate',
        'tax_amount',
        'is_tax_exempt',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'cost' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'previous_cost' => 'decimal:2',
        'new_average_cost' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'is_tax_exempt' => 'boolean',
    ];

    /**
     * Get the purchase that owns this item
     */
    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    /**
     * Get the product for this item
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Calculate subtotal and tax automatically
     */
    protected static function booted()
    {
        static::saving(function ($item) {
            $item->subtotal = $item->quantity * $item->cost;
            
            // Calculate tax if not exempt
            if ($item->is_tax_exempt) {
                $item->tax_amount = 0;
            } else {
                $item->tax_amount = $item->subtotal * ($item->tax_rate / 100);
            }
        });
    }

    /**
     * Calculate tax for this item
     */
    public function calculateTax(): void
    {
        if ($this->is_tax_exempt) {
            $this->tax_amount = 0;
        } else {
            $this->tax_amount = $this->subtotal * ($this->tax_rate / 100);
        }
    }

    /**
     * Get subtotal including tax
     */
    public function getSubtotalWithTaxAttribute(): float
    {
        return $this->subtotal + $this->tax_amount;
    }
}
