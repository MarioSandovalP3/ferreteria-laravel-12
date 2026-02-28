<?php

namespace App\Livewire;

use App\Models\Partner;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\InventoryMovement;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Sales extends Component
{
    use WithPagination;

    // Form properties
    public $showForm = false;
    public $editMode = false;
    public $selected_id;

    // Sale fields
    public $client_id;
    public $invoice_number;
    public $notes;
    public $status = 'pending';
    public $payment_status = 'unpaid';
    public $payment_method;

    // Sale items
    public $items = [];
    public $productSearches = [];
    public $productNames = [];
    
    // Totals
    public $subtotal = 0;
    public $tax_amount = 0;
    public $discount_amount = 0;
    public $total = 0;
    
    // Global tax and discount
    public $global_tax_percent = 0;
    public $global_discount_percent = 0;

    // Search and filters
    public $search = '';
    public $filterStatus = '';
    public $filterClient = '';
    public $filterPaymentStatus = '';

    protected $listeners = ['refreshSales' => '$refresh'];

    public function mount()
    {
        $this->invoice_number = $this->generateInvoiceNumber();
    }

    public function create()
    {
        $this->resetUI();
        $this->showForm = true;
        $this->editMode = false;
        $this->invoice_number = $this->generateInvoiceNumber();
        $this->addItem();
    }

    public function addItem()
    {
        $index = count($this->items);
        $this->items[] = [
            'product_id' => '',
            'quantity' => 1,
            'unit_price' => 0,
            'discount_percent' => 0,
            'discount_amount' => 0,
            'tax_percent' => $this->global_tax_percent,
            'tax_amount' => 0,
            'subtotal' => 0,
            'total' => 0,
        ];
        $this->productSearches[$index] = '';
        $this->productNames[$index] = '';
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        unset($this->productSearches[$index]);
        unset($this->productNames[$index]);
        $this->items = array_values($this->items);
        $this->productSearches = array_values($this->productSearches);
        $this->productNames = array_values($this->productNames);
        $this->calculateTotals();
    }

    public function updatedItems($value, $key)
    {
        // Parse the key to get index and field
        $parts = explode('.', $key);
        if (count($parts) === 2) {
            $index = $parts[0];
            $field = $parts[1];
            
            if (in_array($field, ['quantity', 'unit_price', 'discount_percent', 'tax_percent'])) {
                $this->calculateItemTotals($index);
            }
        }
    }

    public function updatedGlobalTaxPercent()
    {
        foreach ($this->items as $index => $item) {
            $this->items[$index]['tax_percent'] = $this->global_tax_percent;
            $this->calculateItemTotals($index);
        }
    }

    public function updatedGlobalDiscountPercent()
    {
        foreach ($this->items as $index => $item) {
            $this->items[$index]['discount_percent'] = $this->global_discount_percent;
            $this->calculateItemTotals($index);
        }
    }

    private function calculateItemTotals($index)
    {
        if (!isset($this->items[$index])) return;

        $item = &$this->items[$index];
        $quantity = (float)($item['quantity'] ?? 0);
        $unitPrice = (float)($item['unit_price'] ?? 0);
        $discountPercent = (float)($item['discount_percent'] ?? 0);
        $taxPercent = (float)($item['tax_percent'] ?? 0);

        // Calculate base amount
        $baseAmount = $quantity * $unitPrice;

        // Calculate discount
        $discountAmount = $baseAmount * ($discountPercent / 100);
        $item['discount_amount'] = round($discountAmount, 2);

        // Calculate subtotal (after discount)
        $subtotal = $baseAmount - $discountAmount;
        $item['subtotal'] = round($subtotal, 2);

        // Calculate tax
        $taxAmount = $subtotal * ($taxPercent / 100);
        $item['tax_amount'] = round($taxAmount, 2);

        // Calculate total
        $item['total'] = round($subtotal + $taxAmount, 2);

        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $this->subtotal = 0;
        $this->tax_amount = 0;
        $this->discount_amount = 0;
        $this->total = 0;

        foreach ($this->items as $item) {
            $this->subtotal += (float)($item['subtotal'] ?? 0);
            $this->tax_amount += (float)($item['tax_amount'] ?? 0);
            $this->discount_amount += (float)($item['discount_amount'] ?? 0);
            $this->total += (float)($item['total'] ?? 0);
        }
    }

    public function submitForm()
    {
        // Comprehensive backend validation
        $rules = [
            'invoice_number' => 'required|string|max:100|unique:sales,invoice_number' . ($this->selected_id ? ',' . $this->selected_id : ''),
            'status' => 'required|in:pending,completed,cancelled',
            'payment_status' => 'required|in:paid,partial,unpaid',
            'payment_method' => 'nullable|in:cash,card,transfer,mixed,credit',
            'notes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1|max:999999',
            'items.*.unit_price' => 'required|numeric|min:0|max:9999999.99',
            'items.*.discount_percent' => 'nullable|numeric|min:0|max:100',
            'items.*.tax_percent' => 'nullable|numeric|min:0|max:100',
        ];

        $messages = [
            'invoice_number.required' => 'Invoice number is required',
            'invoice_number.unique' => 'Invoice number already exists',
            'invoice_number.max' => 'Invoice number cannot exceed 100 characters',
            'status.required' => 'Status is required',
            'payment_status.required' => 'Payment status is required',
            'notes.max' => 'Notes cannot exceed 1000 characters',
            'items.required' => 'At least one product is required',
            'items.min' => 'At least one product is required',
            'items.*.product_id.required' => 'Product is required',
            'items.*.product_id.exists' => 'Selected product does not exist',
            'items.*.quantity.required' => 'Quantity is required',
            'items.*.quantity.min' => 'Quantity must be at least 1',
            'items.*.quantity.max' => 'Quantity cannot exceed 999,999',
            'items.*.unit_price.required' => 'Price is required',
            'items.*.unit_price.max' => 'Price is too high',
            'items.*.discount_percent.max' => 'Discount cannot exceed 100%',
            'items.*.tax_percent.max' => 'Tax cannot exceed 100%',
        ];

        $this->validate($rules, $messages);

        // Validate stock availability
        if ($this->status === 'completed') {
            foreach ($this->items as $item) {
                $product = Product::find($item['product_id']);
                if ($product && $product->track_inventory) {
                    if ($product->stock < $item['quantity']) {
                        session()->flash('error', __('common.insufficient_stock', ['product' => $product->name, 'available' => $product->stock]));
                        return;
                    }
                }
            }
        }

        try {
            DB::transaction(function () {
                if ($this->editMode && $this->selected_id) {
                    $sale = Sale::findOrFail($this->selected_id);
                    $sale->update([
                        'client_id' => $this->client_id,
                        'invoice_number' => $this->invoice_number,
                        'subtotal' => $this->subtotal,
                        'tax_amount' => $this->tax_amount,
                        'discount_amount' => $this->discount_amount,
                        'total' => $this->total,
                        'notes' => $this->notes,
                        'status' => $this->status,
                        'payment_status' => $this->payment_status,
                        'payment_method' => $this->payment_method,
                    ]);

                    $sale->items()->delete();
                } else {
                    $sale = Sale::create([
                        'user_id' => auth()->id(),
                        'client_id' => $this->client_id,
                        'invoice_number' => $this->invoice_number,
                        'subtotal' => $this->subtotal,
                        'tax_amount' => $this->tax_amount,
                        'discount_amount' => $this->discount_amount,
                        'total' => $this->total,
                        'notes' => $this->notes,
                        'status' => $this->status,
                        'payment_status' => $this->payment_status,
                        'payment_method' => $this->payment_method,
                    ]);
                }

                foreach ($this->items as $item) {
                    SaleItem::create([
                        'sale_id' => $sale->id,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'discount_percent' => $item['discount_percent'],
                        'discount_amount' => $item['discount_amount'],
                        'tax_percent' => $item['tax_percent'],
                        'tax_amount' => $item['tax_amount'],
                        'subtotal' => $item['subtotal'],
                        'total' => $item['total'],
                    ]);

                    if ($this->status === 'completed') {
                        $this->createInventoryMovement($sale, $item['product_id'], $item['quantity']);
                    }
                }
            });

            $message = $this->editMode ? __('common.sale_updated_successfully') : __('common.sale_created_successfully');
            session()->flash('message', $message);
            $this->resetUI();
        } catch (\Exception $e) {
            // Log technical error
            \Log::error('Sale save failed', [
                'sale_id' => $this->selected_id ?? 'new',
                'invoice_number' => $this->invoice_number,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Show user-friendly error
            session()->flash('error', __('common.sale_save_error'));
        }
    }

    protected function createInventoryMovement($sale, $productId, $quantity)
    {
        $product = Product::find($productId);
        
        if ($product && $product->track_inventory) {
            InventoryMovement::create([
                'product_id' => $productId,
                'movable_type' => Sale::class,
                'movable_id' => $sale->id,
                'type' => 'out',
                'quantity' => $quantity,
                'created_by' => auth()->id(),
            ]);

            $product->decrement('stock', $quantity);
        }
    }

    public function edit($id)
    {
        $sale = Sale::with('items.product')->findOrFail($id);
        
        $this->selected_id = $id;
        $this->client_id = $sale->client_id;
        $this->invoice_number = $sale->invoice_number;
        $this->notes = $sale->notes;
        $this->status = $sale->status;
        $this->payment_status = $sale->payment_status;
        $this->payment_method = $sale->payment_method;
        
        $this->items = [];
        $this->productSearches = [];
        $this->productNames = [];
        
        foreach ($sale->items as $index => $item) {
            $this->items[$index] = [
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'discount_percent' => $item->discount_percent,
                'discount_amount' => $item->discount_amount,
                'tax_percent' => $item->tax_percent,
                'tax_amount' => $item->tax_amount,
                'subtotal' => $item->subtotal,
                'total' => $item->total,
            ];
            
            if ($item->product) {
                $this->productSearches[$index] = $item->product->name;
                $this->productNames[$index] = $item->product->name;
            }
        }
        
        $this->calculateTotals();
        $this->showForm = true;
        $this->editMode = true;
    }

    public function destroy($id)
    {
        Sale::findOrFail($id)->delete();
        session()->flash('message', __('common.sale_deleted_successfully'));
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
        $this->client_id = null;
        $this->invoice_number = $this->generateInvoiceNumber();
        $this->notes = '';
        $this->status = 'pending';
        $this->payment_status = 'unpaid';
        $this->payment_method = null;
        $this->items = [];
        $this->productSearches = [];
        $this->productNames = [];
        $this->subtotal = 0;
        $this->tax_amount = 0;
        $this->discount_amount = 0;
        $this->total = 0;
        $this->global_tax_percent = 0;
        $this->global_discount_percent = 0;
    }

    private function generateInvoiceNumber()
    {
        $date = now()->format('Ymd');
        $lastSale = Sale::whereDate('created_at', today())->latest()->first();
        $sequence = $lastSale ? (int)substr($lastSale->invoice_number, -4) + 1 : 1;
        return 'FAC-' . $date . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    // Product search methods
    public function selectProduct($index, $productId, $productName, $productPrice)
    {
        $this->items[$index]['product_id'] = $productId;
        $this->items[$index]['unit_price'] = $productPrice;
        $this->productSearches[$index] = $productName;
        $this->productNames[$index] = $productName;
        $this->calculateItemTotals($index);
    }

    public function clearProduct($index)
    {
        $this->items[$index]['product_id'] = null;
        $this->items[$index]['unit_price'] = 0;
        $this->productSearches[$index] = '';
        $this->productNames[$index] = '';
        $this->calculateItemTotals($index);
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

    public function render()
    {
        if ($this->showForm) {
            $clients = Partner::where('type', 'customer')->orderBy('name')->get();
            
            return view('livewire.sales.form', [
                'clients' => $clients,
            ]);
        }

        $query = Sale::with(['client', 'user']);

        if ($this->search) {
            $query->where(function($q) {
                $q->where('invoice_number', 'like', '%' . $this->search . '%')
                  ->orWhereHas('client', function($q) {
                      $q->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterPaymentStatus) {
            $query->where('payment_status', $this->filterPaymentStatus);
        }

        if ($this->filterClient) {
            $query->where('client_id', $this->filterClient);
        }

        $sales = $query->latest()->paginate(10);
        $clients = Partner::where('type', 'customer')->orderBy('name')->get();

        return view('livewire.sales.component', [
            'sales' => $sales,
            'clients' => $clients,
        ]);
    }
}
