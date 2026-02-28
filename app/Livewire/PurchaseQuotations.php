<?php

namespace App\Livewire;

use App\Models\Partner;
use App\Models\Product;
use App\Models\PurchaseQuotation;
use App\Models\PurchaseQuotationItem;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class PurchaseQuotations extends Component
{
    use WithPagination;

    // Form properties
    public $showForm = false;
    public $viewMode = false;
    public $editMode = false;
    public $confirmingOrder = false;  // Flag for confirm order workflow
    public $selected_id;
    public $rfqNumber = '';

    // RFQ fields
    public $supplier_id;
    public $request_date;
    public $expected_date;
    public $notes;
    public $internal_notes;
    public $status = 'draft';

    // Items
    public $items = [];
    public $productSearches = [];
    public $productNames = [];

    // Supplier search
    public $supplierSearch = '';
    public $showSupplierDropdown = false;
    public $selectedSupplierName = '';

    // Search and filters
    public $search = '';
    public $filterStatus = '';
    public $filterSupplier = '';
    public $filterTrashed = ''; // '', 'only', 'with'

    // Email modal
    public $showEmailModal = false;
    public $emailQuotationId = null;
    public $emailRecipient = '';
    public $emailSubject = '';
    public $emailMessage = '';

    // Delete confirmation modal
    public $showDeleteModal = false;
    public $deleteQuotationId = null;

    // Cancel confirmation modal
    public $showCancelModal = false;
    public $cancelQuotationId = null;

    protected $listeners = ['refreshQuotations' => '$refresh'];

    public function mount()
    {
        $this->request_date = now()->format('Y-m-d');
    }

    public function create()
    {
        $this->resetUI();
        $this->showForm = true;
        $this->editMode = false;
        $this->viewMode = false;
        $this->addItem();
    }

    public function addItem()
    {
        $index = count($this->items);
        $this->items[] = [
            'product_id' => '',
            'quantity' => 1,
            'requested_price' => '0.00',
            'quoted_price' => '0.00',
            'notes' => '',
            'tax_rate' => '0.00',
            'tax_amount' => 0,
            'is_tax_exempt' => false,
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
    }

    public function selectProduct($index, $productId, $productName, $productPrice)
    {
        $this->items[$index]['product_id'] = $productId;
        $this->items[$index]['requested_price'] = $productPrice;
        $this->productSearches[$index] = $productName;
        $this->productNames[$index] = $productName;
    }

    public function clearProduct($index)
    {
        $this->items[$index]['product_id'] = null;
        $this->items[$index]['requested_price'] = 0;
        $this->productSearches[$index] = '';
        $this->productNames[$index] = '';
    }

    public function getFilteredProductsForItem($index)
    {
        $search = $this->productSearches[$index] ?? '';
        
        if (empty($search)) {
            return Product::active()
                ->where('product_type', 'physical')
                ->orderBy('name')
                ->limit(20)
                ->get();
        }

        return Product::active()
            ->where('product_type', 'physical')
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

    public function store()
    {
        $rules = [
            'supplier_id' => 'required|exists:partners,id',
            'request_date' => 'required|date|after_or_equal:' . now()->subYear()->format('Y-m-d') . '|before_or_equal:today',
            'expected_date' => 'nullable|date|after_or_equal:request_date',
            'notes' => 'nullable|string|max:1000',
            'internal_notes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1|max:999999',
            'items.*.requested_price' => 'nullable|numeric|min:0|max:9999999.99',
            'items.*.quoted_price' => 'nullable|numeric|min:0|max:9999999.99',
            'items.*.tax_rate' => 'nullable|numeric|min:0|max:100',
            'items.*.tax_amount' => 'nullable|numeric|min:0',
            'items.*.is_tax_exempt' => 'nullable|boolean',
            'items.*.notes' => 'nullable|string|max:500',
        ];

        $messages = [
            'supplier_id.required' => __('validation.supplier_required'),
            'supplier_id.exists' => __('validation.supplier_not_exist'),
            'request_date.required' => __('validation.request_date_required'),
            'request_date.date' => __('validation.request_date_must_be_date'),
            'request_date.after_or_equal' => __('validation.request_date_not_too_old'),
            'request_date.before_or_equal' => __('validation.request_date_not_future'),
            'expected_date.date' => __('validation.expected_date_must_be_date'),
            'expected_date.after_or_equal' => __('validation.expected_date_after_request'),
            'items.required' => __('validation.at_least_one_product_required'),
            'items.min' => __('validation.at_least_one_product_required'),
            'items.*.product_id.required' => __('validation.product_required_all_items'),
            'items.*.product_id.exists' => __('validation.product_not_exist'),
            'items.*.quantity.required' => __('validation.quantity_required'),
            'items.*.quantity.min' => __('validation.quantity_min_one'),
            'items.*.quantity.max' => __('validation.quantity_max_999999'),
            'items.*.tax_rate.max' => __('validation.tax_rate_max_100'),
            'items.*.tax_rate.min' => __('validation.tax_rate_not_negative'),
            'items.*.requested_price.max' => __('validation.price_too_high'),
            'items.*.quoted_price.max' => __('validation.price_too_high'),
        ];

        $this->validate($rules, $messages);

        if ($this->confirmingOrder) {
            $missingPrices = collect($this->items)->filter(fn($item) => empty($item['quoted_price']) || $item['quoted_price'] <= 0)->count();
            
            if ($missingPrices > 0) {
                $this->dispatch('msg', __('common.missing_quoted_prices'));
                return;
            }
        }

        try {
            DB::transaction(function () {
                $quotation = PurchaseQuotation::create([
                    'supplier_id' => $this->supplier_id,
                    'request_date' => $this->request_date,
                    'expected_date' => $this->expected_date,
                    'notes' => $this->notes,
                    'internal_notes' => $this->internal_notes,
                    'status' => 'draft',
                    'created_by' => auth()->id(),
                ]);

                foreach ($this->items as $item) {
                    PurchaseQuotationItem::create([
                        'quotation_id' => $quotation->id,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'requested_price' => $item['requested_price'] ?? null,
                        'quoted_price' => $item['quoted_price'] ?? null,
                        'tax_rate' => $item['tax_rate'] ?? 0,
                        'tax_amount' => $item['tax_amount'] ?? 0,
                        'is_tax_exempt' => $item['is_tax_exempt'] ?? false,
                        'notes' => $item['notes'] ?? null,
                    ]);
                }

                if ($this->confirmingOrder) {
                    $quotation->load('items.product');
                    $purchase = $quotation->convertToPurchase();
                    $this->dispatch('msg', __('common.order_confirmed_and_purchase_created') . ' #' . $purchase->id);
                    $this->resetUI();
                } else {
                    // Switch to edit mode after creating
                    $this->selected_id = $quotation->id;
                    $this->editMode = true;
                    $this->status = $quotation->status;
                    $this->rfqNumber = $quotation->rfq_number;
                    
                    $this->dispatch('msg', __('common.quotation_created_successfully'));
                    // Don't reset UI - stay in form in edit mode
                }
            });
            
        } catch (\Exception $e) {
            \Log::error('Purchase Quotation creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            $this->dispatch('msg', __('common.quotation_save_error'));
        }
    }

    public function storeAndExit()
    {
        $this->store();
        $this->resetUI();
    }

    public function update()
    {
        $rules = [
            'supplier_id' => 'required|exists:partners,id',
            'request_date' => 'required|date|after_or_equal:' . now()->subYear()->format('Y-m-d') . '|before_or_equal:today',
            'expected_date' => 'nullable|date|after_or_equal:request_date',
            'notes' => 'nullable|string|max:1000',
            'internal_notes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1|max:999999',
            'items.*.requested_price' => 'nullable|numeric|min:0|max:9999999.99',
            'items.*.quoted_price' => 'nullable|numeric|min:0|max:9999999.99',
            'items.*.tax_rate' => 'nullable|numeric|min:0|max:100',
            'items.*.tax_amount' => 'nullable|numeric|min:0',
            'items.*.is_tax_exempt' => 'nullable|boolean',
            'items.*.notes' => 'nullable|string|max:500',
        ];

        $messages = [
            'supplier_id.required' => 'Supplier is required',
            'supplier_id.exists' => 'Selected supplier does not exist',
            'request_date.required' => 'Request date is required',
            'request_date.date' => 'Request date must be a valid date',
            'request_date.after_or_equal' => __('validation.request_date_not_too_old'),
            'request_date.before_or_equal' => __('validation.request_date_not_future'),
            'expected_date.date' => 'Expected date must be a valid date',
            'expected_date.after_or_equal' => __('validation.expected_date_after_request'),
            'items.required' => 'At least one product is required',
            'items.min' => 'At least one product is required',
            'items.*.product_id.required' => 'Product is required for all items',
            'items.*.product_id.exists' => 'Selected product does not exist',
            'items.*.quantity.required' => 'Quantity is required',
            'items.*.quantity.min' => 'Quantity must be at least 1',
            'items.*.quantity.max' => 'Quantity cannot exceed 999,999',
            'items.*.tax_rate.max' => 'Tax rate cannot exceed 100%',
            'items.*.tax_rate.min' => 'Tax rate cannot be negative',
            'items.*.requested_price.max' => 'Price is too high',
            'items.*.quoted_price.max' => 'Price is too high',
        ];

        // If status is received or approved, quoted_price is required for all items
        if (in_array($this->status, ['received', 'approved'])) {
            $rules['items.*.quoted_price'] = 'required|numeric|min:0.01|max:9999999.99';
            $messages['items.*.quoted_price.required'] = __('validation.quoted_price_required');
            $messages['items.*.quoted_price.min'] = __('validation.quoted_price_must_be_greater_than_zero');
        }

        $this->validate($rules, $messages);

        try {
            DB::transaction(function () {
                $quotation = PurchaseQuotation::findOrFail($this->selected_id);
                
                $quotation->update([
                    'supplier_id' => $this->supplier_id,
                    'request_date' => $this->request_date,
                    'expected_date' => $this->expected_date,
                    'notes' => $this->notes,
                    'internal_notes' => $this->internal_notes,
                ]);

                $quotation->items()->delete();

                foreach ($this->items as $item) {
                    PurchaseQuotationItem::create([
                        'quotation_id' => $quotation->id,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'requested_price' => $item['requested_price'] ?? null,
                        'quoted_price' => $item['quoted_price'] ?? null,
                        'tax_rate' => $item['tax_rate'] ?? 0,
                        'tax_amount' => $item['tax_amount'] ?? 0,
                        'is_tax_exempt' => $item['is_tax_exempt'] ?? false,
                        'notes' => $item['notes'] ?? null,
                    ]);
                }

                if ($this->confirmingOrder) {
                    $quotation->load('items.product');
                    $purchase = $quotation->convertToPurchase();
                    $this->dispatch('msg', __('common.order_confirmed_and_purchase_created') . ' #' . $purchase->id);
                    $this->resetUI();
                } else {
                    $this->dispatch('msg', __('common.quotation_updated_successfully'));
                    // Don't reset UI - stay in form
                }
            });
        } catch (\Exception $e) {
            \Log::error('Purchase Quotation update failed', [
                'quotation_id' => $this->selected_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            $this->dispatch('msg', __('common.quotation_save_error'));
        }
    }

    public function updateAndExit()
    {
        $this->update();
        if (!session()->has('error')) {
            $this->resetUI();
        }
    }

    public function view($id)
    {
        $quotation = PurchaseQuotation::withTrashed()->with(['items.product', 'supplier'])->findOrFail($id);
        
        $this->selected_id = $id;
        $this->rfqNumber = $quotation->rfq_number;
        $this->supplier_id = $quotation->supplier_id;
        $this->request_date = $quotation->request_date->format('Y-m-d');
        $this->expected_date = $quotation->expected_date?->format('Y-m-d');
        $this->notes = $quotation->notes;
        $this->internal_notes = $quotation->internal_notes;
        $this->status = $quotation->status;
        
        // Load supplier name for search input
        if ($quotation->supplier) {
            $this->supplierSearch = $quotation->supplier->name;
            $this->selectedSupplierName = $quotation->supplier->name;
        }
        
        $this->items = [];
        $this->productSearches = [];
        $this->productNames = [];
        
        foreach ($quotation->items as $index => $item) {
            $this->items[$index] = [
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'requested_price' => $item->requested_price,
                'quoted_price' => $item->quoted_price,
                'tax_rate' => $item->tax_rate ?? 0,
                'tax_amount' => $item->tax_amount ?? 0,
                'is_tax_exempt' => $item->is_tax_exempt ?? false,
                'notes' => $item->notes,
            ];
            
            if ($item->product) {
                $this->productSearches[$index] = $item->product->name;
                $this->productNames[$index] = $item->product->name;
            }
        }
        
        $this->showForm = true;
        $this->viewMode = true;
        $this->editMode = false;
    }

    public function edit($id)
    {
        $this->view($id);
        
        // If quotation is converted, keep it in view mode (read-only)
        if ($this->status === 'converted') {
            $this->viewMode = true;
            $this->editMode = false;
        } else {
            $this->viewMode = false;
            $this->editMode = true;
        }
        
        $this->confirmingOrder = false;
    }

    public function confirmOrder($id)
    {
        // Load quotation in edit mode for confirming order
        $this->view($id);
        $this->viewMode = false;
        $this->editMode = true;
        $this->confirmingOrder = true;  // Special flag for confirm workflow
    }

    public function convertToPurchase($id)
    {
        // If in edit mode, save changes first
        if ($this->editMode && $this->selected_id == $id) {
            // Validate and save current changes
            try {
                $this->update();
            } catch (\Exception $e) {
                // If validation fails, show error and don't proceed with conversion
                $this->dispatch('msg', $e->getMessage());
                return;
            }
        }
        
        $quotation = PurchaseQuotation::with(['items.product', 'supplier'])->findOrFail($id);
        
        try {
            // Convert quotation to purchase
            $purchase = $quotation->convertToPurchase();
            
            if ($purchase) {
                $this->dispatch('msg', __('common.quotation_converted_successfully') . ' - ' . $purchase->purchase_number);
                $this->resetUI();
            } else {
                $this->dispatch('msg', __('common.quotation_conversion_error'));
            }
        } catch (\Exception $e) {
            // Show the specific error message from the model
            $this->dispatch('msg', $e->getMessage());
        }
    }

    // State transition methods
    public function markAsSent($id)
    {
        try {
            $quotation = PurchaseQuotation::with(['supplier', 'items.product'])->findOrFail($id);
            
            // Check if supplier has email
            if (empty($quotation->supplier->email)) {
                session()->flash('error', __('common.supplier_has_no_email'));
                return;
            }
            
            // Mark as sent
            if ($quotation->markAsSent()) {
                // Send email to supplier
                \Mail::to($quotation->supplier->email)->send(new \App\Mail\PurchaseQuotationMail($quotation));
                
                session()->flash('message', __('common.quotation_sent_successfully'));
            } else {
                session()->flash('error', __('common.cannot_mark_as_sent'));
            }
        } catch (\Exception $e) {
            session()->flash('error', __('common.error_sending_email') . ': ' . $e->getMessage());
        }
    }

    public function markAsReceived($id)
    {
        $quotation = PurchaseQuotation::findOrFail($id);
        if ($quotation->markAsReceived()) {
            session()->flash('message', __('common.quotation_marked_as_received'));
            // Reload the quotation to show updated status
            if ($this->showForm) {
                // Reload in the current mode (view or edit)
                if ($this->viewMode) {
                    $this->view($id);
                } else {
                    $this->edit($id);
                }
            }
        } else {
            session()->flash('error', __('common.cannot_mark_as_received'));
        }
    }

    public function approve($id)
    {
        $quotation = PurchaseQuotation::findOrFail($id);
        if ($quotation->approve(auth()->id())) {
            session()->flash('message', __('common.quotation_approved'));
            // Reload the quotation to show updated status
            if ($this->showForm) {
                // Reload in the current mode (view or edit)
                if ($this->viewMode) {
                    $this->view($id);
                } else {
                    $this->edit($id);
                }
            }
        } else {
            session()->flash('error', __('common.cannot_approve_quotation'));
        }
    }


    public function openCancelModal($id)
    {
        $this->cancelQuotationId = $id;
        $this->showCancelModal = true;
    }

    public function closeCancelModal()
    {
        $this->showCancelModal = false;
        $this->cancelQuotationId = null;
    }

    public function confirmCancel()
    {
        if (!$this->cancelQuotationId) {
            return;
        }

        try {
            $quotation = PurchaseQuotation::findOrFail($this->cancelQuotationId);
            
            if ($quotation->cancel()) {
                $this->dispatch('msg', __('common.quotation_cancelled'));
                
                // Reload the quotation to show updated status
                if ($this->showForm && $this->viewMode) {
                    $this->view($this->cancelQuotationId);
                }
            } else {
                $this->dispatch('msg', __('common.cannot_cancel_quotation'));
            }
            
            $this->closeCancelModal();
        } catch (\Exception $e) {
            \Log::error('Purchase Quotation cancel failed', [
                'quotation_id' => $this->cancelQuotationId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            $this->closeCancelModal();
            $this->dispatch('msg', __('common.quotation_cancel_error'));
        }
    }

    public function openDeleteModal($id)
    {
        $this->deleteQuotationId = $id;
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deleteQuotationId = null;
    }

    public function confirmDelete()
    {
        if (!$this->deleteQuotationId) {
            return;
        }

        try {
            $quotation = PurchaseQuotation::findOrFail($this->deleteQuotationId);
            $quotation->delete(); // Soft delete
            
            $this->closeDeleteModal();
            $this->dispatch('msg', __('common.quotation_deleted_successfully'));
        } catch (\Exception $e) {
            \Log::error('Purchase Quotation delete failed', [
                'quotation_id' => $this->deleteQuotationId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            $this->closeDeleteModal();
            $this->dispatch('msg', __('common.quotation_delete_error'));
        }
    }

    public function restore($id)
    {
        try {
            $quotation = PurchaseQuotation::onlyTrashed()->findOrFail($id);
            $quotation->restore();
            
            // Close form and return to list
            $this->resetUI();
            $this->dispatch('msg', __('common.quotation_restored_successfully'));
        } catch (\Exception $e) {
            \Log::error('Purchase Quotation restore failed', [
                'quotation_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            $this->dispatch('msg', __('common.quotation_restore_error'));
        }
    }

    public function cancel()
    {
        $this->closeCancelModal();
        $this->closeDeleteModal();
        $this->resetUI();
    }

    public function resetUI()
    {
        $this->showForm = false;
        $this->viewMode = false;
        $this->editMode = false;
        $this->selected_id = null;
        $this->confirmingOrder = false;  // Reset confirming order state
        $this->supplier_id = null;
        $this->supplierSearch = '';
        $this->showSupplierDropdown = false;
        $this->selectedSupplierName = '';
        $this->request_date = now()->format('Y-m-d');
        $this->expected_date = null;
        $this->notes = null;
        $this->internal_notes = null;
        $this->status = 'draft';
        $this->items = [];
        $this->productSearches = [];
        $this->productNames = [];
        $this->resetValidation();
        
        // Close any open modals to prevent overlay issues
        $this->closeCancelModal();
        $this->closeDeleteModal();
        $this->closeEmailModal();
    }

    // PDF and Email methods
    public function downloadPDF($id)
    {
        $quotation = PurchaseQuotation::with(['supplier', 'items.product'])->findOrFail($id);
        $store = \App\Models\Store::first(); // Get the first/main store
        
        $pdf = \PDF::loadView('pdfs.purchase-quotation', [
            'quotation' => $quotation,
            'store' => $store
        ]);
        
        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, $quotation->rfq_number . '.pdf');
    }

    public function openEmailModal($id)
    {
        $quotation = PurchaseQuotation::with('supplier')->findOrFail($id);
        
        if (empty($quotation->supplier->email)) {
            session()->flash('error', __('common.supplier_has_no_email'));
            return;
        }

        $this->emailQuotationId = $id;
        $this->emailRecipient = $quotation->supplier->email;
        $this->emailSubject = 'Solicitud de Cotización - ' . $quotation->rfq_number;
        $this->emailMessage = "Estimado/a proveedor,\n\nAdjunto encontrará nuestra solicitud de cotización.\n\nPor favor, envíenos su cotización con los precios y disponibilidad.\n\nGracias.";
        $this->showEmailModal = true;
    }

    public function sendEmailWithPDF()
    {
        try {
            // Validate email configuration first
            if (!config('mail.from.address')) {
                session()->flash('error', __('common.email_not_configured'));
                return;
            }

            if (!config('mail.default')) {
                session()->flash('error', __('common.email_mailer_not_set'));
                return;
            }

            // Validate recipient
            if (empty($this->emailRecipient)) {
                session()->flash('error', __('common.recipient_required'));
                return;
            }

            if (!filter_var($this->emailRecipient, FILTER_VALIDATE_EMAIL)) {
                session()->flash('error', __('common.invalid_email_address'));
                return;
            }

            // Validate subject and message
            if (empty($this->emailSubject)) {
                session()->flash('error', __('common.subject_required'));
                return;
            }

            $quotation = PurchaseQuotation::with(['supplier', 'items.product'])->findOrFail($this->emailQuotationId);
            
            // Send email with PDF attachment using Mailable
            \Mail::to($this->emailRecipient)->send(
                new \App\Mail\PurchaseQuotationMail(
                    $quotation,
                    $this->emailMessage,
                    $this->emailSubject
                )
            );
            
            // Mark as sent
            $quotation->markAsSent();
            
            session()->flash('message', __('common.quotation_sent_successfully'));
            $this->showEmailModal = false;
            $this->resetEmailModal();
            $this->showForm = false; // Return to list
            
        } catch (\Exception $e) {
            \Log::error('Error sending quotation email: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            session()->flash('error', __('common.error_sending_email') . ': ' . $e->getMessage());
            // Don't close modal so user can see the error and retry
        }
    }

    public function closeEmailModal()
    {
        $this->showEmailModal = false;
        $this->resetEmailModal();
    }

    private function resetEmailModal()
    {
        $this->emailQuotationId = null;
        $this->emailRecipient = '';
        $this->emailSubject = '';
        $this->emailMessage = '';
    }

    public function render()
    {
        if ($this->showForm) {
            $suppliers = Partner::suppliers()->orderBy('name')->get();
            
            return view('livewire.purchase-quotations.form', [
                'suppliers' => $suppliers,
            ]);
        }

        $query = PurchaseQuotation::with(['supplier', 'creator']);

        // Apply trash filter
        if ($this->filterTrashed === 'only') {
            $query->onlyTrashed();
        } elseif ($this->filterTrashed === 'with') {
            $query->withTrashed();
        }
        // Default: only non-deleted (no need to call anything)

        if ($this->search) {
            $query->where(function($q) {
                $q->where('rfq_number', 'like', '%' . $this->search . '%')
                  ->orWhereHas('supplier', function($q) {
                      $q->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterSupplier) {
            $query->where('supplier_id', $this->filterSupplier);
        }

        $quotations = $query->latest()->paginate(10);
        $suppliers = Partner::suppliers()->orderBy('name')->get();

        return view('livewire.purchase-quotations.component', [
            'quotations' => $quotations,
            'suppliers' => $suppliers,
        ]);
    }
}
