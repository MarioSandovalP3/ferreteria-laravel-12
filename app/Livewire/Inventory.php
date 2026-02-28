<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\InventoryMovement;
use Livewire\Component;
use Livewire\WithPagination;

class Inventory extends Component
{
    use WithPagination;

    public $search = '';
    public $filterType = '';
    public $selectedProduct = null;
    public $showMovements = false;

    public function viewMovements($productId)
    {
        $this->selectedProduct = $productId;
        $this->showMovements = true;
    }

    public function closeMovements()
    {
        $this->selectedProduct = null;
        $this->showMovements = false;
    }

    public function render()
    {
        try {
            if ($this->showMovements && $this->selectedProduct) {
                $product = Product::find($this->selectedProduct);
                $movements = InventoryMovement::with(['creator', 'movable'])
                    ->where('product_id', $this->selectedProduct)
                    ->latest()
                    ->paginate(20);

                return view('livewire.inventory.movements', [
                    'product' => $product,
                    'movements' => $movements,
                ]);
            }

            $products = Product::active()->with(['inventoryMovements'])
                ->when($this->search, function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('sku', 'like', '%' . $this->search . '%');
                })
                ->where('track_inventory', true)
                ->latest()
                ->paginate(15);

            return view('livewire.inventory.component', [
                'products' => $products,
            ]);
        } catch (\Exception $e) {
            // Log technical error
            \Log::error('Inventory render failed', [
                'search' => $this->search,
                'selected_product' => $this->selectedProduct,
                'error' => $e->getMessage()
            ]);

            // Return empty view with error message
            session()->flash('error', __('common.inventory_load_error'));
            return view('livewire.inventory.component', [
                'products' => collect(),
            ]);
        }
    }
}
