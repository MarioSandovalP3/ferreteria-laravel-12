<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'purchase_number',
        'supplier_id',
        'purchase_date',
        'invoice_number',
        'subtotal',
        'taxable_subtotal',
        'exempt_subtotal',
        'tax_amount',
        'total',
        'notes',
        'status',
        'payment_status',
        'due_date',
        'created_by',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'due_date' => 'date',
        'subtotal' => 'decimal:2',
        'taxable_subtotal' => 'decimal:2',
        'exempt_subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /**
     * Get the supplier (partner) for this purchase
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Partner::class, 'supplier_id');
    }

    /**
     * Get the user who created this purchase
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the purchase items for this purchase
     */
    public function items(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    /**
     * Get all inventory movements for this purchase
     */
    public function inventoryMovements(): MorphMany
    {
        return $this->morphMany(InventoryMovement::class, 'movable');
    }

    /**
     * Calculate all totals with tax breakdown
     */
    public function calculateTotals(): void
    {
        try {
            // Separate taxable and exempt items
            $taxableItems = $this->items->where('is_tax_exempt', false);
            $exemptItems = $this->items->where('is_tax_exempt', true);
            
            // Calculate subtotals
            $this->taxable_subtotal = $taxableItems->sum('subtotal');
            $this->exempt_subtotal = $exemptItems->sum('subtotal');
            $this->subtotal = $this->taxable_subtotal + $this->exempt_subtotal;
            
            // Calculate total tax
            $this->tax_amount = $this->items->sum('tax_amount');
            
            // Calculate grand total
            $this->total = $this->subtotal + $this->tax_amount;
        } catch (\Exception $e) {
            // Log technical error
            \Log::error('Purchase total calculation failed', [
                'purchase_id' => $this->id,
                'invoice_number' => $this->invoice_number,
                'error' => $e->getMessage()
            ]);
            
            // Set safe defaults
            $this->taxable_subtotal = 0;
            $this->exempt_subtotal = 0;
            $this->tax_amount = 0;
            $this->subtotal = 0;
            $this->total = 0;
        }
    }

    /**
     * Calculate total from items (legacy method)
     */
    public function calculateTotal(): float
    {
        return $this->items->sum('subtotal');
    }

    /**
     * Get supplier payments for this purchase
     */
    public function payments(): HasMany
    {
        return $this->hasMany(SupplierPayment::class);
    }

    /**
     * Get remaining balance (total - paid)
     */
    public function remainingBalance(): float
    {
        $paid = $this->payments()->sum('amount');
        return $this->total - $paid;
    }
}
