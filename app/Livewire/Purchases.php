<?php

namespace App\Livewire;

use App\Models\Partner;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\InventoryMovement;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Purchases extends Component
{
    use WithPagination;

    // Form properties
    public $showForm = false;
    public $editMode = false;
    public $viewMode = false;
    public $selected_id;
    public $purchase_number = '';

    // Purchase fields
    public $supplier_id;
    public $purchase_date;
    public $invoice_number;
    public $notes;
    public $status = 'pending';
    public $payment_status = 'pending';
    public $due_date;
    public $tax_amount = 0;
    public $subtotal = 0;

    // Purchase items
    public $items = [];
    public $productSearches = []; // Search input for each item
    public $productNames = []; // Selected product names for each item
    public $total_amount = 0;
    public $showExchangeRate = false;

    // Supplier search
    public $supplierSearch = '';
    public $showSupplierDropdown = false;
    public $selectedSupplierName = '';

    // Search and filters
    public $search = '';
    public $filterStatus = '';
    public $filterSupplier = '';
    public $filterTrashed = ''; // '', 'only', 'with'

    // Delete confirmation modal
    public $showDeleteModal = false;
    public $deletePurchaseId = null;
    
    // Force delete confirmation modal
    public $showForceDeleteModal = false;
    public $forceDeletePurchaseId = null;
    
    // Cancel purchase confirmation modal
    public $showCancelModal = false;
    public $cancelPurchaseId = null;

    // Quick product creation modal
    public $showQuickProductModal = false;
    public $currentItemIndex = null;
    public $quickProductName = '';
    public $quickProductSku = '';
    public $quickProductCategory = null;
    public $quickCategorySearch = '';
    public $quickProductPrice = '';
    public $quickProductType = 'physical';
    public $quickProductStock = 0;

    protected $rules = [
        'supplier_id' => 'required|exists:partners,id',
        'purchase_date' => 'required|date',
        'invoice_number' => 'required|string|unique:purchases,invoice_number',
        'status' => 'required|in:pending,completed,cancelled',
        'notes' => 'nullable|string',
        'items' => 'required|array|min:1',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.quantity' => 'required|integer|min:1',
        'items.*.unit_price' => 'required|numeric|min:0',
    ];

    public function mount()
    {
        $this->purchase_date = now()->format('Y-m-d');
        $this->addItem();
    }

    public function create()
    {
        $this->resetUI();
        $this->showForm = true;
        $this->editMode = false;
        $this->purchase_date = now()->format('Y-m-d');
        $this->purchase_number = $this->generatePurchaseNumber();
    }

    public function addItem()
    {
        $index = count($this->items);
        $this->items[] = [
            'product_id' => '',
            'quantity' => 1,
            'unit_price' => 0,
            'subtotal' => 0,
            'tax_rate' => 0,
            'tax_amount' => 0,
            'is_tax_exempt' => false,
        ];
        $this->productSearches[$index] = '';
        $this->productNames[$index] = '';
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->calculateTotal();
    }

    public function updated($propertyName)
    {
        // Recalculate total whenever any item property changes
        if (str_starts_with($propertyName, 'items.')) {
            $this->calculateTotal();
        }
    }

    public function calculateTotal()
    {
        foreach ($this->items as $index => $item) {
            // Calculate item subtotal
            $subtotal = (float)($item['quantity'] ?? 0) * (float)($item['unit_price'] ?? 0);
            $this->items[$index]['subtotal'] = $subtotal;
            
            // Calculate item tax
            if ($item['is_tax_exempt'] ?? false) {
                $this->items[$index]['tax_amount'] = 0;
            } else {
                $taxRate = (float)($item['tax_rate'] ?? 0);
                $this->items[$index]['tax_amount'] = $subtotal * ($taxRate / 100);
            }
        }
        
        // Calculate total amount (subtotal + tax)
        $this->total_amount = collect($this->items)->sum(function ($item) {
            return ($item['subtotal'] ?? 0) + ($item['tax_amount'] ?? 0);
        });
    }

    public function Store()
    {
        // Comprehensive backend validation
        $rules = [
            'supplier_id' => 'required|exists:partners,id',
            'purchase_date' => 'required|date|before_or_equal:today',
            'invoice_number' => 'required|string|max:100|unique:purchases,invoice_number' . ($this->selected_id ? ',' . $this->selected_id : ''),
            'status' => 'required|in:pending,completed,cancelled',
            'payment_status' => 'required|in:pending,partial,paid',
            'due_date' => 'nullable|date|after_or_equal:purchase_date',
            'notes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1|max:999999',
            'items.*.unit_price' => 'required|numeric|min:0|max:9999999.99',
            'items.*.tax_rate' => 'nullable|numeric|min:0|max:100',
            'items.*.tax_amount' => 'nullable|numeric|min:0',
            'items.*.is_tax_exempt' => 'nullable|boolean',
        ];

        // Custom validation messages
        $messages = [
            'supplier_id.required' => 'Supplier is required',
            'supplier_id.exists' => 'Selected supplier does not exist',
            'purchase_date.required' => 'Purchase date is required',
            'purchase_date.before_or_equal' => 'Purchase date cannot be in the future',
            'invoice_number.required' => 'Invoice number is required',
            'invoice_number.unique' => 'Invoice number already exists',
            'due_date.after_or_equal' => 'Due date must be after purchase date',
            'items.required' => 'At least one product is required',
            'items.min' => 'At least one product is required',
            'items.*.product_id.required' => 'Product is required for all items',
            'items.*.product_id.exists' => 'Selected product does not exist',
            'items.*.quantity.required' => 'Quantity is required',
            'items.*.quantity.min' => 'Quantity must be at least 1',
            'items.*.quantity.max' => 'Quantity cannot exceed 999,999',
            'items.*.unit_price.required' => 'Price is required',
            'items.*.unit_price.max' => 'Price is too high',
            'items.*.tax_rate.max' => 'Tax rate cannot exceed 100%',
            'items.*.tax_rate.min' => 'Tax rate cannot be negative',
        ];

        $this->validate($rules, $messages);

        try {
            // Auto-set status based on payment status
            if ($this->payment_status === 'paid') {
                $this->status = 'completed';
            } else {
                $this->status = 'pending';
            }
            
            $purchase = null; // Initialize variable
            DB::transaction(function () use (&$purchase) {
                // Calculate tax breakdown from items
                $taxableSubtotal = collect($this->items)->where('is_tax_exempt', false)->sum('subtotal');
                $exemptSubtotal = collect($this->items)->where('is_tax_exempt', true)->sum('subtotal');
                $totalTax = collect($this->items)->sum('tax_amount');
                $subtotal = $taxableSubtotal + $exemptSubtotal;
                $grandTotal = $subtotal + $totalTax;
                
                if ($this->editMode && $this->selected_id) {
                    // Update existing purchase
                    $purchase = Purchase::findOrFail($this->selected_id);
                    $purchase->update([
                        'supplier_id' => $this->supplier_id,
                        'purchase_date' => $this->purchase_date,
                        'invoice_number' => $this->invoice_number,
                        'subtotal' => $subtotal,
                        'taxable_subtotal' => $taxableSubtotal,
                        'exempt_subtotal' => $exemptSubtotal,
                        'tax_amount' => $totalTax,
                        'total' => $grandTotal,
                        'notes' => $this->notes,
                        'status' => $this->status,
                        'payment_status' => $this->payment_status,
                        'due_date' => $this->due_date,
                    ]);

                    // Delete old items
                    $purchase->items()->delete();
                } else {
                    // Create new purchase
                    $purchase = Purchase::create([
                        'purchase_number' => $this->purchase_number,
                        'supplier_id' => $this->supplier_id,
                        'purchase_date' => $this->purchase_date,
                        'invoice_number' => $this->invoice_number,
                        'subtotal' => $subtotal,
                        'taxable_subtotal' => $taxableSubtotal,
                        'exempt_subtotal' => $exemptSubtotal,
                        'tax_amount' => $totalTax,
                        'total' => $grandTotal,
                        'notes' => $this->notes,
                        'status' => $this->status,
                        'payment_status' => $this->payment_status,
                        'due_date' => $this->due_date,
                        'created_by' => auth()->id(),
                    ]);
                }

                // Create purchase items and inventory movements
                foreach ($this->items as $item) {
                    $purchaseItem = PurchaseItem::create([
                        'purchase_id' => $purchase->id,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'cost' => $item['unit_price'],
                        'subtotal' => $item['subtotal'],
                        'tax_rate' => $item['tax_rate'] ?? 0,
                        'tax_amount' => $item['tax_amount'] ?? 0,
                        'is_tax_exempt' => $item['is_tax_exempt'] ?? false,
                    ]);

                    // Update inventory and cost if purchase is completed
                    if ($this->status === 'completed') {
                        $this->updateProductCostAndInventory($purchaseItem, $item['product_id'], $item['quantity'], $item['unit_price']);
                    }
                }
            });

            // Determine message before switching mode
            $message = $this->editMode ? __('common.purchase_updated_successfully') : __('common.purchase_created_successfully');
            
            if (!$this->editMode) {
                // Switch to edit mode after creating
                $this->selected_id = $purchase->id;
                $this->editMode = true;
            }
            
            $this->dispatch('msg', $message);
            // Don't reset UI - stay in form in edit mode
        } catch (\Exception $e) {
            // Log technical error for developers
            \Log::error('Purchase save failed', [
                'purchase_id' => $this->selected_id ?? 'new',
                'invoice_number' => $this->invoice_number ?? 'unknown',
                'supplier_id' => $this->supplier_id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Show user-friendly error message
            $this->dispatch('msg', __('common.purchase_save_error'));
        }
    }

    public function storeAndExit()
    {
        $this->Store();
        if (!session()->has('error')) {
            $this->resetUI();
        }
    }

    public function openCancelModal($id)
    {
        $this->cancelPurchaseId = $id;
        $this->showCancelModal = true;
    }

    public function closeCancelModal()
    {
        $this->showCancelModal = false;
        $this->cancelPurchaseId = null;
    }

    public function confirmCancel()
    {
        if (!$this->cancelPurchaseId) {
            return;
        }

        try {
            $purchase = Purchase::findOrFail($this->cancelPurchaseId);
            
            // Update status to cancelled
            $purchase->update([
                'status' => 'cancelled',
            ]);
            
            $this->closeCancelModal();
            $this->dispatch('msg', __('common.purchase_cancelled_successfully'));
        } catch (\Exception $e) {
            \Log::error('Purchase cancellation failed', [
                'purchase_id' => $this->cancelPurchaseId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            $this->closeCancelModal();
            $this->dispatch('msg', __('common.purchase_cancel_error'));
        }
    }

    /**
     * Update product cost using weighted average and create inventory movement
     */
    protected function updateProductCostAndInventory($purchaseItem, $productId, $quantity, $newCost)
    {
        $product = Product::find($productId);
        
        // Get current values
        $currentStock = $product->stock ?? 0;
        $currentCost = $product->cost ?? 0;
        
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
            'product_id' => $productId,
            'movable_type' => Purchase::class,
            'movable_id' => $purchaseItem->purchase_id,
            'type' => 'in',
            'quantity' => $quantity,
            'stock_before' => $currentStock,
            'stock_after' => $newStock,
            'notes' => "Purchase - Cost updated from $$currentCost to $" . round($averageCost, 2),
            'created_by' => auth()->id(),
        ]);
        
        // Activate product if it's in draft status
        if ($product->status === 'draft') {
            $product->update(['status' => 'active']);
        }
    }

    /**
     * Legacy method - keeping for compatibility
     */
    protected function createInventoryMovement($purchase, $productId, $quantity)
    {
        // This method is kept for backward compatibility but is now handled by updateProductCostAndInventory
        // when status is 'completed'
    }

    public function edit($id)
    {
        $purchase = Purchase::with(['items.product', 'supplier'])->findOrFail($id);
        
        $this->selected_id = $id;
        $this->purchase_number = $purchase->purchase_number;
        $this->supplier_id = $purchase->supplier_id;
        $this->purchase_date = $purchase->purchase_date->format('Y-m-d');
        $this->invoice_number = $purchase->invoice_number;
        $this->notes = $purchase->notes;
        $this->status = $purchase->status;
        $this->payment_status = $purchase->payment_status;
        $this->due_date = $purchase->due_date ? $purchase->due_date->format('Y-m-d') : null;
        $this->tax_amount = $purchase->tax_amount;
        $this->subtotal = $purchase->subtotal;
        $this->total_amount = $purchase->total;
        
        // Load supplier name for search input
        if ($purchase->supplier) {
            $this->supplierSearch = $purchase->supplier->name;
            $this->selectedSupplierName = $purchase->supplier->name;
        }
        
        // Load items and product names
        $this->items = [];
        $this->productSearches = [];
        $this->productNames = [];
        
        foreach ($purchase->items as $index => $item) {
            $this->items[$index] = [
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->cost,
                'tax_rate' => $item->tax_rate ?? 0,
                'tax_amount' => $item->tax_amount ?? 0,
                'is_tax_exempt' => $item->is_tax_exempt ?? false,
                'subtotal' => $item->subtotal,
            ];
            
            // Load product name for search input
            if ($item->product) {
                $this->productSearches[$index] = $item->product->name;
                $this->productNames[$index] = $item->product->name;
            } else {
                $this->productSearches[$index] = '';
                $this->productNames[$index] = '';
            }
        }
        
        $this->calculateTotal();
        $this->showForm = true;
        $this->editMode = true;
        // Allow editing of specific fields even for completed purchases
        $this->viewMode = false;
    }
    
    public function view($id)
    {
        $purchase = Purchase::with(['items.product', 'supplier'])->findOrFail($id);
        
        $this->selected_id = $id;
        $this->purchase_number = $purchase->purchase_number;
        $this->supplier_id = $purchase->supplier_id;
        $this->purchase_date = $purchase->purchase_date->format('Y-m-d');
        $this->invoice_number = $purchase->invoice_number;
        $this->notes = $purchase->notes;
        $this->status = $purchase->status;
        $this->payment_status = $purchase->payment_status;
        $this->due_date = $purchase->due_date ? $purchase->due_date->format('Y-m-d') : null;
        $this->tax_amount = $purchase->tax_amount;
        $this->subtotal = $purchase->subtotal;
        $this->total_amount = $purchase->total;
        
        // Load supplier name for search input
        if ($purchase->supplier) {
            $this->supplierSearch = $purchase->supplier->name;
            $this->selectedSupplierName = $purchase->supplier->name;
        }
        
        // Load items and product names
        $this->items = [];
        $this->productSearches = [];
        $this->productNames = [];
        
        foreach ($purchase->items as $index => $item) {
            $this->items[$index] = [
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->cost,
                'tax_rate' => $item->tax_rate ?? 0,
                'tax_amount' => $item->tax_amount ?? 0,
                'is_tax_exempt' => $item->is_tax_exempt ?? false,
                'subtotal' => $item->subtotal,
            ];
            
            // Load product name for search input
            if ($item->product) {
                $this->productSearches[$index] = $item->product->name;
                $this->productNames[$index] = $item->product->name;
            } else {
                $this->productSearches[$index] = '';
                $this->productNames[$index] = '';
            }
        }
        
        $this->calculateTotal();
        $this->showForm = true;
        $this->editMode = false;
        $this->viewMode = true;
    }

    public function openDeleteModal($id)
    {
        $this->deletePurchaseId = $id;
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deletePurchaseId = null;
    }

    public function confirmDelete()
    {
        if (!$this->deletePurchaseId) {
            return;
        }

        try {
            $purchase = Purchase::findOrFail($this->deletePurchaseId);
            $purchase->delete(); // Soft delete
            
            $this->closeDeleteModal();
            $this->dispatch('msg', __('common.purchase_deleted_successfully'));
        } catch (\Exception $e) {
            \Log::error('Purchase delete failed', [
                'purchase_id' => $this->deletePurchaseId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            $this->closeDeleteModal();
            $this->dispatch('msg', __('common.purchase_delete_error'));
        }
    }

    public function restore($id)
    {
        $purchase = Purchase::withTrashed()->findOrFail($id);
        $purchase->restore();
        
        $this->dispatch('msg', __('common.purchase_restored_successfully'));
    }

    public function openForceDeleteModal($id)
    {
        $this->forceDeletePurchaseId = $id;
        $this->showForceDeleteModal = true;
    }

    public function closeForceDeleteModal()
    {
        $this->showForceDeleteModal = false;
        $this->forceDeletePurchaseId = null;
    }

    public function confirmForceDelete()
    {
        if (!$this->forceDeletePurchaseId) {
            return;
        }

        try {
            $purchase = Purchase::withTrashed()->findOrFail($this->forceDeletePurchaseId);
            $purchase->forceDelete();
            
            $this->closeForceDeleteModal();
            $this->dispatch('msg', __('common.purchase_permanently_deleted'));
        } catch (\Exception $e) {
            \Log::error('Purchase force delete failed', [
                'purchase_id' => $this->forceDeletePurchaseId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            $this->closeForceDeleteModal();
            $this->dispatch('msg', __('common.purchase_force_delete_error'));
        }
    }

    // Quick Product Creation Methods
    public function openQuickProductModal($itemIndex = null)
    {
        $this->currentItemIndex = $itemIndex;
        $this->showQuickProductModal = true;
        $this->generateSku();
    }

    public function closeQuickProductModal()
    {
        $this->showQuickProductModal = false;
        $this->currentItemIndex = null;
        $this->resetQuickProductFields();
    }

    public function generateSku()
    {
        // Generate SKU: PRD-YYYYMMDD-XXXX
        $date = now()->format('Ymd');
        $lastProduct = Product::whereDate('created_at', today())->latest()->first();
        $sequence = $lastProduct ? (int)substr($lastProduct->sku, -4) + 1 : 1;
        $this->quickProductSku = 'PRD-' . $date . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    public function createQuickProduct()
    {
        $this->validate([
            'quickProductName' => 'required|string|max:255',
            'quickProductSku' => 'required|string|unique:products,sku',
            'quickProductCategory' => 'required|exists:categories,id',
        ], [
            'quickProductName.required' => __('common.product_name_required'),
            'quickProductSku.required' => __('common.sku_required'),
            'quickProductSku.unique' => __('common.sku_already_exists'),
            'quickProductCategory.required' => __('common.category_required'),
        ]);

        $product = Product::create([
            'name' => $this->quickProductName,
            'sku' => $this->quickProductSku,
            'category_id' => $this->quickProductCategory,
            'price' => 0, // Default price, will be set later in Products module
            'product_type' => $this->quickProductType,
            'stock' => $this->quickProductStock,
            'status' => 'draft', // Draft until purchase is completed
            'description' => 'Producto creado desde compras - completar información',
        ]);

        // Auto-select the created product in the current item
        if ($this->currentItemIndex !== null && isset($this->items[$this->currentItemIndex])) {
            $this->selectProduct(
                $this->currentItemIndex,
                $product->id,
                $product->name,
                0 // Don't auto-fill price, user will enter purchase price
            );
        }

        $this->dispatch('msg', __('common.product_created_successfully'));
        
        $this->closeQuickProductModal();
    }

    private function resetQuickProductFields()
    {
        $this->quickProductName = '';
        $this->quickProductSku = '';
        $this->quickProductCategory = null;
        $this->quickCategorySearch = '';
        $this->quickProductPrice = '';
        $this->quickProductType = 'physical';
        $this->quickProductStock = 0;
    }

    public function selectQuickCategory($categoryId, $categoryName)
    {
        $this->quickProductCategory = $categoryId;
        $this->quickCategorySearch = $categoryName;
    }

    public function clearQuickCategory()
    {
        $this->quickProductCategory = null;
        $this->quickCategorySearch = '';
    }

    public function getFilteredQuickCategoriesProperty()
    {
        if (empty($this->quickCategorySearch)) {
            return \App\Models\Category::orderBy('name')->get();
        }

        return \App\Models\Category::where('name', 'like', '%' . $this->quickCategorySearch . '%')
            ->orderBy('name')
            ->get();
    }

    // Product search methods
    public function selectProduct($index, $productId, $productName, $productPrice)
    {
        $this->items[$index]['product_id'] = $productId;
        // Don't auto-fill price - purchase price is different from sale price
        // $this->items[$index]['unit_price'] = $productPrice;
        $this->productSearches[$index] = $productName;
        $this->productNames[$index] = $productName;
        
        // Recalculate totals
        $this->calculateTotal();
    }

    public function clearProduct($index)
    {
        $this->items[$index]['product_id'] = null;
        $this->items[$index]['unit_price'] = 0;
        $this->productSearches[$index] = '';
        $this->productNames[$index] = '';
    }

    public function getFilteredProductsForItem($index)
    {
        $search = $this->productSearches[$index] ?? '';
        
        if (empty($search)) {
            return Product::active()
                ->where('product_type', 'physical') // Solo productos físicos
                ->orderBy('name')
                ->limit(20)
                ->get();
        }

        return Product::active()
            ->where('product_type', 'physical') // Solo productos físicos
            ->where('name', 'like', '%' . $search . '%')
            ->orderBy('name')
            ->limit(20)
            ->get();
    }

    public function updatedSupplierSearch()
    {
        $this->showSupplierDropdown = !empty($this->supplierSearch);
    }

    public function selectSupplier($supplierId, $supplierName)
    {
        $this->supplier_id = $supplierId;
        $this->supplierSearch = $supplierName;
        $this->selectedSupplierName = $supplierName;
        $this->showSupplierDropdown = false;
    }

    public function clearSupplier()
    {
        $this->supplier_id = null;
        $this->supplierSearch = '';
        $this->selectedSupplierName = '';
        $this->showSupplierDropdown = false;
    }

    public function getFilteredSuppliersProperty()
    {
        if (empty($this->supplierSearch)) {
            return Partner::suppliers()
                ->orderBy('name')
                ->limit(20)
                ->get();
        }

        return Partner::suppliers()
            ->where('name', 'like', '%' . $this->supplierSearch . '%')
            ->orderBy('name')
            ->limit(20)
            ->get();
    }

    public function cancel()
    {
        $this->resetUI();
    }

    public function resetUI()
    {
        $this->showForm = false;
        $this->editMode = false;
        $this->selected_id = null;
        $this->supplier_id = null;
        $this->purchase_date = now()->format('Y-m-d');
        $this->invoice_number = null;
        $this->notes = null;
        $this->status = 'pending';
        $this->payment_status = 'pending';
        $this->due_date = null;
        $this->tax_amount = 0;
        $this->subtotal = 0;
        $this->items = [];
        $this->total_amount = 0;
        $this->resetValidation();
        $this->addItem();
    }

    private function generatePurchaseNumber()
    {
        $year = now()->year;
        $prefix = "PO-{$year}-";
        
        // Get the last purchase number for this year
        $lastPurchase = Purchase::withTrashed()
            ->where('purchase_number', 'like', "{$prefix}%")
            ->orderBy('purchase_number', 'desc')
            ->first();
        
        if ($lastPurchase) {
            // Extract the sequential number and increment
            $lastNumber = (int) substr($lastPurchase->purchase_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            // First purchase of the year
            $newNumber = 1;
        }
        
        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    public function render()
    {
        $purchases = $this->showForm ? collect() : Purchase::with(['supplier', 'creator', 'items.product'])
            ->when($this->filterTrashed === 'only', function ($query) {
                $query->onlyTrashed();
            })
            ->when($this->filterTrashed === 'with', function ($query) {
                $query->withTrashed();
            })
            ->when($this->search, function ($query) {
                $query->where('invoice_number', 'like', '%' . $this->search . '%')
                    ->orWhereHas('supplier', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->when($this->filterSupplier, function ($query) {
                $query->where('supplier_id', $this->filterSupplier);
            })
            ->latest()
            ->paginate(10);

        $suppliers = Partner::suppliers()->where('is_active', true)->orderBy('name')->get();
        $products = Product::active()->get();
        $categories = \App\Models\Category::orderBy('name')->get();
        
        // Get current exchange rate
        $exchangeRate = \App\Models\ExchangeRate::where('is_active', true)->first();

        return view('livewire.purchases.component', [
            'purchases' => $purchases,
            'suppliers' => $suppliers,
            'products' => $products,
            'categories' => $categories,
            'exchangeRate' => $exchangeRate,
        ]);
    }
}
