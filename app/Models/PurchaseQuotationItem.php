<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseQuotationItem extends Model
{
    protected $fillable = [
        'quotation_id',
        'product_id',
        'quantity',
        'requested_price',
        'quoted_price',
        'notes',
        'tax_rate',
        'tax_amount',
        'is_tax_exempt',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'requested_price' => 'decimal:2',
        'quoted_price' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'is_tax_exempt' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function quotation(): BelongsTo
    {
        return $this->belongsTo(PurchaseQuotation::class, 'quotation_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Calculate requested total
     */
    public function getRequestedTotalAttribute(): float
    {
        return ($this->requested_price ?? 0) * $this->quantity;
    }

    /**
     * Calculate quoted total
     */
    public function getQuotedTotalAttribute(): float
    {
        return ($this->quoted_price ?? 0) * $this->quantity;
    }

    /**
     * Calculate price difference
     */
    public function getPriceDifferenceAttribute(): ?float
    {
        if (!$this->requested_price || !$this->quoted_price) {
            return null;
        }

        return $this->quoted_price - $this->requested_price;
    }

    /**
     * Calculate price difference percentage
     */
    public function getPriceDifferencePercentAttribute(): ?float
    {
        if (!$this->requested_price || !$this->quoted_price) {
            return null;
        }

        return (($this->quoted_price - $this->requested_price) / $this->requested_price) * 100;
    }

    /**
     * Calculate tax for this item based on quoted price
     */
    public function calculateTax(): void
    {
        $subtotal = $this->quoted_total;
        
        if ($this->is_tax_exempt) {
            $this->tax_amount = 0;
        } else {
            $this->tax_amount = $subtotal * ($this->tax_rate / 100);
        }
    }

    /**
     * Get quoted total including tax
     */
    public function getQuotedTotalWithTaxAttribute(): float
    {
        return $this->quoted_total + ($this->tax_amount ?? 0);
    }
}
