<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class PurchaseQuotation extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'rfq_number',
        'supplier_id',
        'request_date',
        'expected_date',
        'status',
        'notes',
        'internal_notes',
        'taxable_subtotal',
        'exempt_subtotal',
        'tax_amount',
        'grand_total',
        'created_by',
        'approved_by',
        'approved_at',
        'converted_to_purchase_id',
    ];

    protected $casts = [
        'request_date' => 'date',
        'expected_date' => 'date',
        'approved_at' => 'datetime',
        'taxable_subtotal' => 'decimal:2',
        'exempt_subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'grand_total' => 'decimal:2',
    ];

    /**
     * Boot method to auto-generate RFQ number
     */
    protected static function booted()
    {
        static::creating(function ($quotation) {
            if (empty($quotation->rfq_number)) {
                $quotation->rfq_number = static::generateRfqNumber();
            }
        });
    }

    /**
     * Generate unique RFQ number: RFQ-YYYYMMDD-0001
     */
    public static function generateRfqNumber(): string
    {
        $date = now()->format('Ymd');
        $prefix = "RFQ-{$date}-";
        
        $lastRfq = static::where('rfq_number', 'like', $prefix . '%')
            ->withTrashed()
            ->orderBy('rfq_number', 'desc')
            ->first();
        
        if ($lastRfq) {
            $lastNumber = (int) substr($lastRfq->rfq_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Relationships
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Partner::class, 'supplier_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseQuotationItem::class, 'quotation_id');
    }

    public function convertedPurchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class, 'converted_to_purchase_id');
    }

    /**
     * Scopes
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    public function scopeReceived($query)
    {
        return $query->where('status', 'received');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeConverted($query)
    {
        return $query->where('status', 'converted');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * State machine methods
     */
    public function markAsSent(): bool
    {
        try {
            if ($this->status !== 'draft') {
                return false;
            }

            return $this->update(['status' => 'sent']);
        } catch (\Exception $e) {
            \Log::error('Failed to mark quotation as sent', [
                'quotation_id' => $this->id,
                'rfq_number' => $this->rfq_number,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function markAsReceived(): bool
    {
        try {
            if (!in_array($this->status, ['draft', 'sent'])) {
                return false;
            }

            return $this->update(['status' => 'received']);
        } catch (\Exception $e) {
            \Log::error('Failed to mark quotation as received', [
                'quotation_id' => $this->id,
                'rfq_number' => $this->rfq_number,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function approve(): bool
    {
        try {
            if ($this->status !== 'received') {
                return false;
            }

            return $this->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now()
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to approve quotation', [
                'quotation_id' => $this->id,
                'rfq_number' => $this->rfq_number,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function cancel(): bool
    {
        try {
            if (in_array($this->status, ['converted', 'cancelled'])) {
                return false;
            }

            return $this->update(['status' => 'cancelled']);
        } catch (\Exception $e) {
            \Log::error('Failed to cancel quotation', [
                'quotation_id' => $this->id,
                'rfq_number' => $this->rfq_number,
                'error' => $e->getMessage()
            ]);
            return false;
        }
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
            
            // Calculate subtotals based on quoted prices
            $this->taxable_subtotal = $taxableItems->sum('quoted_total');
            $this->exempt_subtotal = $exemptItems->sum('quoted_total');
            
            // Calculate total tax
            $this->tax_amount = $this->items->sum('tax_amount');
            
            // Calculate grand total
            $this->grand_total = $this->taxable_subtotal + $this->exempt_subtotal + $this->tax_amount;
        } catch (\Exception $e) {
            // Log technical error
            \Log::error('Quotation total calculation failed', [
                'quotation_id' => $this->id,
                'rfq_number' => $this->rfq_number,
                'error' => $e->getMessage()
            ]);
            
            // Set safe defaults
            $this->taxable_subtotal = 0;
            $this->exempt_subtotal = 0;
            $this->tax_amount = 0;
            $this->grand_total = 0;
        }
    }

    /**
     * Convert RFQ to Purchase Order
     */
    public function convertToPurchase(): ?Purchase
    {
        // Allow conversion from draft, sent, or approved status
        if (!in_array($this->status, ['draft', 'sent', 'approved', 'received'])) {
            throw new \Exception('Only draft, sent, received, or approved quotations can be converted to purchases');
        }

        if ($this->converted_to_purchase_id) {
            throw new \Exception('This quotation has already been converted');
        }

        return DB::transaction(function () {
            // Validate all items have quoted prices
            foreach ($this->items as $item) {
                if (!$item->quoted_price || $item->quoted_price <= 0) {
                    throw new \Exception(__('validation.item_missing_quoted_price', ['item' => $item->product->name]));
                }
            }

            // Calculate totals with tax breakdown
            $this->calculateTotals();

            // Generate purchase number
            $year = now()->year;
            $prefix = "PO-{$year}-";
            
            $lastPurchase = Purchase::withTrashed()
                ->where('purchase_number', 'like', "{$prefix}%")
                ->orderBy('purchase_number', 'desc')
                ->first();
            
            if ($lastPurchase) {
                $lastNumber = (int) substr($lastPurchase->purchase_number, -4);
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }
            
            $purchaseNumber = $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

            // Create Purchase Order with tax breakdown
            $purchase = Purchase::create([
                'purchase_number' => $purchaseNumber,
                'supplier_id' => $this->supplier_id,
                'purchase_date' => now()->format('Y-m-d'),
                'invoice_number' => 'PO-' . $this->rfq_number,
                'subtotal' => $this->taxable_subtotal + $this->exempt_subtotal,
                'taxable_subtotal' => $this->taxable_subtotal,
                'exempt_subtotal' => $this->exempt_subtotal,
                'tax_amount' => $this->tax_amount,
                'total' => $this->grand_total,
                'notes' => "Converted from {$this->rfq_number}\n\n" . ($this->notes ?? ''),
                'status' => 'pending',
                'payment_status' => 'pending',
                'due_date' => $this->expected_date,
                'created_by' => auth()->id(),
            ]);

            // Create Purchase Items with tax information
            foreach ($this->items as $item) {
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'cost' => $item->quoted_price,
                    'subtotal' => $item->quantity * $item->quoted_price,
                    'tax_rate' => $item->tax_rate,
                    'tax_amount' => $item->tax_amount,
                    'is_tax_exempt' => $item->is_tax_exempt,
                ]);
            }

            // Mark quotation as converted
            $this->update([
                'status' => 'converted',
                'converted_to_purchase_id' => $purchase->id,
            ]);

            return $purchase;
        });
    }

    /**
     * Calculate total quoted amount
     */
    public function getTotalQuotedAttribute(): float
    {
        return $this->items->sum(function ($item) {
            return ($item->quoted_price ?? 0) * $item->quantity;
        });
    }

    /**
     * Calculate total requested amount
     */
    public function getTotalRequestedAttribute(): float
    {
        return $this->items->sum(function ($item) {
            return ($item->requested_price ?? 0) * $item->quantity;
        });
    }

    /**
     * Check if all items have quoted prices
     */
    public function hasAllQuotedPrices(): bool
    {
        return $this->items->every(fn($item) => $item->quoted_price !== null);
    }

    /**
     * Status badge helpers
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'draft' => 'gray',
            'sent' => 'blue',
            'received' => 'yellow',
            'approved' => 'green',
            'converted' => 'purple',
            'cancelled' => 'red',
            default => 'gray',
        };
    }
}
