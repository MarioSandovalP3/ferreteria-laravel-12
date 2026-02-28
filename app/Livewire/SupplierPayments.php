<?php

namespace App\Livewire;

use App\Models\Partner;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Product;
use App\Models\InventoryMovement;
use App\Models\SupplierPayment;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class SupplierPayments extends Component
{
    use WithPagination;

    // Form properties
    public $showForm = false;
    public $editMode = false;
    public $viewMode = false;
    public $selected_id;

    // Payment fields
    public $supplier_id;
    public $supplierSearch = '';
    public $supplierName = '';
    public $showSupplierDropdown = false;
    public $purchase_id;
    public $purchaseSearch = '';
    public $purchaseName = '';
    public $showPurchaseDropdown = false;
    public $amount;
    public $payment_date;
    public $payment_method = 'cash';
    public $reference;
    public $notes;

    // Search and filters
    public $search = '';
    public $filterSupplier = '';
    public $filterPaymentMethod = '';

    protected $listeners = ['refreshPayments' => '$refresh'];

    public function mount()
    {
        $this->payment_date = now()->format('Y-m-d');
    }

    public function create()
    {
        $this->resetUI();
        $this->showForm = true;
        $this->editMode = false;
        $this->viewMode = false;
    }
    
    public function view($id)
    {
        $payment = SupplierPayment::with(['supplier', 'purchase'])->findOrFail($id);
        
        $this->selected_id = $id;
        $this->supplier_id = $payment->supplier_id;
        $this->supplierSearch = $payment->supplier->name;
        $this->supplierName = $payment->supplier->name;
        $this->purchase_id = $payment->purchase_id;
        
        if ($payment->purchase_id) {
            // Use total field if it exists and is greater than 0, otherwise calculate
            $purchaseTotal = ($payment->purchase->total && $payment->purchase->total > 0)
                ? $payment->purchase->total
                : ($payment->purchase->subtotal + $payment->purchase->tax_amount);
            $this->purchaseSearch = $payment->purchase->invoice_number . ' - $' . number_format($purchaseTotal, 2);
            $this->purchaseName = $payment->purchase->invoice_number;
        }
        
        $this->amount = $payment->amount;
        $this->payment_date = $payment->payment_date->format('Y-m-d');
        $this->payment_method = $payment->payment_method;
        $this->reference = $payment->reference;
        $this->notes = $payment->notes;
        
        $this->showForm = true;
        $this->editMode = false;
        $this->viewMode = true;
    }
    
    public function edit($id)
    {
        $payment = SupplierPayment::with(['supplier', 'purchase'])->findOrFail($id);
        
        $this->selected_id = $id;
        $this->supplier_id = $payment->supplier_id;
        $this->supplierSearch = $payment->supplier->name;
        $this->supplierName = $payment->supplier->name;
        $this->purchase_id = $payment->purchase_id;
        
        if ($payment->purchase_id) {
            // Use total field if it exists and is greater than 0, otherwise calculate
            $purchaseTotal = ($payment->purchase->total && $payment->purchase->total > 0)
                ? $payment->purchase->total
                : ($payment->purchase->subtotal + $payment->purchase->tax_amount);
            $this->purchaseSearch = $payment->purchase->invoice_number . ' - $' . number_format($purchaseTotal, 2);
            $this->purchaseName = $payment->purchase->invoice_number;
        }
        
        $this->amount = $payment->amount;
        $this->payment_date = $payment->payment_date->format('Y-m-d');
        $this->payment_method = $payment->payment_method;
        $this->reference = $payment->reference;
        $this->notes = $payment->notes;
        
        $this->showForm = true;
        $this->editMode = true;
        $this->viewMode = false;
    }

    public function submitForm()
    {
        // Comprehensive backend validation
        $rules = [
            'supplier_id' => 'required|exists:partners,id',
            'amount' => 'required|numeric|min:0.01|max:9999999.99',
            'payment_date' => 'required|date|before_or_equal:today',
            'payment_method' => 'required|in:cash,transfer,check,card',
            'purchase_id' => 'nullable|exists:purchases,id',
            'reference' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:1000',
        ];

        $messages = [
            'supplier_id.required' => 'Supplier is required',
            'supplier_id.exists' => 'Selected supplier does not exist',
            'amount.required' => 'Amount is required',
            'amount.min' => 'Amount must be greater than 0',
            'amount.max' => 'Amount is too high',
            'payment_date.required' => 'Payment date is required',
            'payment_date.before_or_equal' => 'Payment date cannot be in the future',
            'payment_method.required' => 'Payment method is required',
            'payment_method.in' => 'Invalid payment method',
            'purchase_id.exists' => 'Selected purchase does not exist',
            'reference.max' => 'Reference cannot exceed 100 characters',
            'notes.max' => 'Notes cannot exceed 1000 characters',
        ];

        $this->validate($rules, $messages);

        try {
            DB::transaction(function () {
                if ($this->editMode && $this->selected_id) {
                    $payment = SupplierPayment::findOrFail($this->selected_id);
                    $payment->update([
                        'supplier_id' => $this->supplier_id,
                        'purchase_id' => $this->purchase_id,
                        'amount' => $this->amount,
                        'payment_date' => $this->payment_date,
                        'payment_method' => $this->payment_method,
                        'reference' => $this->reference,
                        'notes' => $this->notes,
                    ]);
                } else {
                    $payment = SupplierPayment::create([
                        'supplier_id' => $this->supplier_id,
                        'purchase_id' => $this->purchase_id,
                        'amount' => $this->amount,
                        'payment_date' => $this->payment_date,
                        'payment_method' => $this->payment_method,
                        'reference' => $this->reference,
                        'notes' => $this->notes,
                        'created_by' => auth()->id(),
                    ]);
                }

                // If payment is linked to a purchase, update payment status
                if ($this->purchase_id) {
                    $purchase = Purchase::findOrFail($this->purchase_id);
                    
                    // Calculate total payments for this purchase
                    $totalPaid = SupplierPayment::where('purchase_id', $this->purchase_id)->sum('amount');
                    
                    // Calculate purchase total with taxes (use total field if exists, otherwise calculate)
                    $purchaseTotal = ($purchase->total && $purchase->total > 0)
                        ? $purchase->total
                        : ($purchase->subtotal + $purchase->tax_amount);
                    
                    // Update payment_status and status based on amount paid
                    if ($totalPaid >= $purchaseTotal) {
                        // Check if this is a status change from pending to completed
                        $wasNotCompleted = $purchase->status !== 'completed';
                        
                        // Fully paid - mark as paid and completed
                        $purchase->update([
                            'payment_status' => 'paid',
                            'status' => 'completed'
                        ]);
                        
                        // If status changed to completed, update inventory
                        if ($wasNotCompleted) {
                            $this->updateInventoryForCompletedPurchase($purchase);
                        }
                    } elseif ($totalPaid > 0) {
                        // Partial payment - update only payment_status, keep status as pending
                        $purchase->update([
                            'payment_status' => 'partial'
                        ]);
                    } else {
                        // No payments - set to pending
                        $purchase->update([
                            'payment_status' => 'pending'
                        ]);
                    }
                }
            });

            $message = $this->editMode ? __('common.payment_updated_successfully') : __('common.payment_created_successfully');
            session()->flash('message', $message);
            $this->resetUI();
        } catch (\Exception $e) {
            // Log technical error
            \Log::error('Supplier payment save failed', [
                'payment_id' => $this->selected_id ?? 'new',
                'supplier_id' => $this->supplier_id,
                'amount' => $this->amount,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Show user-friendly error
            session()->flash('error', __('common.payment_save_error'));
        }
    }


    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $payment = SupplierPayment::findOrFail($id);
                $purchaseId = $payment->purchase_id;
                
                // Delete the payment
                $payment->delete();
                
                // If payment was linked to a purchase, recalculate payment status
                if ($purchaseId) {
                    $purchase = Purchase::find($purchaseId);
                    
                    if ($purchase) {
                        // Calculate remaining total payments for this purchase
                        $totalPaid = SupplierPayment::where('purchase_id', $purchaseId)->sum('amount');
                        
                        // Calculate purchase total with taxes
                        $purchaseTotal = ($purchase->total && $purchase->total > 0)
                            ? $purchase->total
                            : ($purchase->subtotal + $purchase->tax_amount);
                        
                        // Update payment status based on remaining payments
                        if ($totalPaid >= $purchaseTotal) {
                            $purchase->update([
                                'payment_status' => 'paid',
                                'status' => 'completed'
                            ]);
                        } elseif ($totalPaid > 0) {
                            $purchase->update([
                                'payment_status' => 'partial'
                            ]);
                        } else {
                            // No payments left
                            $purchase->update([
                                'payment_status' => 'pending'
                            ]);
                        }
                    }
                }
            });
            
            session()->flash('message', __('common.payment_deleted_successfully'));
        } catch (\Exception $e) {
            // Log technical error
            \Log::error('Supplier payment delete failed', [
                'payment_id' => $id,
                'error' => $e->getMessage()
            ]);

            // Show user-friendly error
            session()->flash('error', __('common.payment_delete_error'));
        }
    }

    public function cancel()
    {
        $this->resetUI();
    }

    public function selectSupplier($supplierId, $supplierName)
    {
        $this->supplier_id = $supplierId;
        $this->supplierSearch = $supplierName;
        $this->supplierName = $supplierName;
        $this->showSupplierDropdown = false;
    }
    
    public function clearSupplier()
    {
        $this->supplier_id = null;
        $this->supplierSearch = '';
        $this->supplierName = '';
        $this->showSupplierDropdown = false;
    }

    public function selectPurchase($purchaseId, $purchaseName)
    {
        $this->purchase_id = $purchaseId;
        $this->purchaseSearch = $purchaseName;
        $this->purchaseName = $purchaseName;
        $this->showPurchaseDropdown = false;
    }
    
    public function clearPurchase()
    {
        $this->purchase_id = null;
        $this->purchaseSearch = '';
        $this->purchaseName = '';
        $this->showPurchaseDropdown = false;
    }

    public function resetUI()
    {
        $this->showForm = false;
        $this->editMode = false;
        $this->viewMode = false;
        $this->selected_id = null;
        $this->supplier_id = null;
        $this->supplierSearch = '';
        $this->supplierName = '';
        $this->showSupplierDropdown = false;
        $this->purchase_id = null;
        $this->purchaseSearch = '';
        $this->purchaseName = '';
        $this->showPurchaseDropdown = false;
        $this->amount = null;
        $this->payment_date = now()->format('Y-m-d');
        $this->payment_method = 'cash';
        $this->reference = null;
        $this->notes = null;
        $this->resetValidation();
    }

    public function render()
    {
        if ($this->showForm) {
            // Get suppliers for search
            $suppliersQuery = Partner::suppliers();
            if ($this->supplierSearch) {
                $suppliersQuery->where('name', 'like', '%' . $this->supplierSearch . '%');
            }
            $suppliers = $suppliersQuery->orderBy('name')->limit(20)->get();
            
            // Get purchases for search
            $purchasesQuery = Purchase::with('supplier')
                ->when($this->supplier_id, function($query) {
                    $query->where('supplier_id', $this->supplier_id);
                })
                ->where('payment_status', '!=', 'paid');
            
            if ($this->purchaseSearch) {
                $purchasesQuery->where('invoice_number', 'like', '%' . $this->purchaseSearch . '%');
            }
            
            $purchases = $purchasesQuery->orderBy('purchase_date', 'desc')->limit(20)->get();
            
            return view('livewire.supplier-payments.form', [
                'suppliers' => $suppliers,
                'purchases' => $purchases,
            ]);
        }

        $query = SupplierPayment::with(['supplier', 'purchase']);

        if ($this->search) {
            $query->where(function($q) {
                $q->where('reference', 'like', '%' . $this->search . '%')
                  ->orWhereHas('supplier', function($q) {
                      $q->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->filterSupplier) {
            $query->where('supplier_id', $this->filterSupplier);
        }

        if ($this->filterPaymentMethod) {
            $query->where('payment_method', $this->filterPaymentMethod);
        }

        $payments = $query->latest()->paginate(10);
        $suppliers = Partner::suppliers()->orderBy('name')->get();

        return view('livewire.supplier-payments.component', [
            'payments' => $payments,
            'suppliers' => $suppliers,
        ]);
    }
    
    /**
     * Update inventory when a purchase is completed through payment
     */
    protected function updateInventoryForCompletedPurchase($purchase)
    {
        // Load purchase items
        $purchase->load('items');
        
        foreach ($purchase->items as $purchaseItem) {
            $product = Product::find($purchaseItem->product_id);
            
            if (!$product) {
                continue;
            }
            
            // Get current values
            $currentStock = $product->stock ?? 0;
            $currentCost = $product->cost ?? 0;
            $quantity = $purchaseItem->quantity;
            $newCost = $purchaseItem->cost;
            
            // Calculate weighted average cost
            $totalValue = ($currentStock * $currentCost) + ($quantity * $newCost);
            $totalQuantity = $currentStock + $quantity;
            $averageCost = $totalQuantity > 0 ? $totalValue / $totalQuantity : $newCost;
            
            // Save cost history in purchase_item
            $purchaseItem->update([
                'previous_cost' => $currentCost,
                'new_average_cost' => round($averageCost, 2),
            ]);
            
            // Update product with new stock and average cost
            $newStock = $currentStock + $quantity;
            $product->update([
                'stock' => $newStock,
                'cost' => round($averageCost, 2),
            ]);
            
            // Create inventory movement
            InventoryMovement::create([
                'product_id' => $purchaseItem->product_id,
                'movable_type' => Purchase::class,
                'movable_id' => $purchase->id,
                'type' => 'in',
                'quantity' => $quantity,
                'stock_before' => $currentStock,
                'stock_after' => $newStock,
                'notes' => "Purchase completed via payment - Cost updated from $$currentCost to $" . round($averageCost, 2),
                'created_by' => auth()->id(),
            ]);
            
            // Activate product if it's in draft status
            if ($product->status === 'draft') {
                $product->update(['status' => 'active']);
            }
        }
    }
}
