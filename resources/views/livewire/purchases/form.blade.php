{{-- Purchase Form --}}
<div class="max-w-6xl mx-auto">
    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-800">
            {{-- Header --}}
            <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">
                            @if($editMode)
                                {{ __('common.edit_purchase') }} - {{ $purchase_number }}
                            @else
                                {{ __('common.new_purchase') }} - {{ $purchase_number }}
                            @endif
                        </h2>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                            {{ __('common.register_product_purchase') }}
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        
                        <flux:button wire:click="cancel" variant="ghost" icon="x-mark" class="border border-gray-500 dark:border-gray-800">
                            {{ __('common.close') }}
                        </flux:button>
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-6">
                {{-- Purchase Information --}}
                <div>
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-4">
                        {{ __('common.purchase_information') }}
                    </h3>
                    
                    {{-- Supplier and Purchase Number Row --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        {{-- Supplier --}}
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.supplier') }} <span class="text-red-500">*</span>
                            </label>
                            
                            <div class="relative">
                                <input type="text" 
                                       wire:model.live="supplierSearch"
                                       wire:focus="$set('showSupplierDropdown', true)"
                                       placeholder="{{ __('common.search_supplier') }}"
                                       @if($viewMode || $status === 'completed') disabled @endif
                                       class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('supplier_id') border-red-500 @enderror"
                                       autocomplete="off">
                                
                                @if($supplier_id && $selectedSupplierName)
                                    <button type="button" 
                                            wire:click="clearSupplier"
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                @endif
                            </div>

                            {{-- Dropdown Results --}}
                            @if($showSupplierDropdown)
                                <div class="absolute z-50 w-full mt-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                    @forelse($this->filteredSuppliers as $supplier)
                                        <button type="button"
                                                wire:click="selectSupplier({{ $supplier->id }}, '{{ $supplier->name }}')"
                                                class="w-full px-4 py-2.5 text-left hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 last:border-0">
                                            <div class="font-medium">{{ $supplier->name }}</div>
                                            @if($supplier->email)
                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $supplier->email }}</div>
                                            @endif
                                        </button>
                                    @empty
                                        <div class="px-4 py-3 text-gray-500 dark:text-gray-400 text-sm">
                                            {{ __('common.no_suppliers_found') }}
                                        </div>
                                    @endforelse
                                </div>
                            @endif

                            @error('supplier_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Purchase Number (Read-only) --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.purchase_number') }}
                            </label>
                            <input type="text" 
                                   value="{{ $purchase_number }}" 
                                   readonly
                                   class="w-full px-4 py-2.5 bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white cursor-not-allowed">
                        </div>
                    </div>

                    {{-- Date and Invoice Row --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Purchase Date --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.purchase_date') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="date" 
                                   wire:model="purchase_date" 
                                   @if($viewMode) disabled @endif
                                   class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('purchase_date') border-red-500 @enderror"
                                   required>
                            @error('purchase_date')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Invoice Number --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.invoice_number') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   wire:model="invoice_number" 
                                   placeholder="{{ __('common.invoice_number') }}"
                                   @if($viewMode) disabled @endif
                                   class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('invoice_number') border-red-500 @enderror"
                                   required>
                            @error('invoice_number')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Payment Information Section --}}
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-4 mt-6">
                        {{ __('common.payment_information') }}
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Payment Status --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.payment_status') }} <span class="text-red-500">*</span>
                            </label>
                            <select wire:model="payment_status"
                                    @if($viewMode || $status === 'completed') disabled @endif
                                    class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('payment_status') border-red-500 @enderror"
                                    required>
                                <option value="pending">{{ __('common.pending') }}</option>
                                <option value="paid">{{ __('common.paid') }}</option>
                                <option value="partial">{{ __('common.partial') }}</option>
                            </select>
                        </div>

                        {{-- Due Date (if credit) --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.due_date') }}
                            </label>
                            <input type="date" 
                                   wire:model="due_date" 
                                   @if($viewMode || $status === 'completed') disabled @endif
                                   class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ __('common.due_date_help') }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 mt-6">
                        {{-- Notes --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.notes') }}
                            </label>
                            <textarea wire:model="notes" 
                                      rows="3"
                                      placeholder="{{ __('common.additional_notes') }}"
                                      @if($viewMode) disabled @endif
                                      class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                    </div>
                </div>

                {{-- Products --}}
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-zinc-900 dark:text-white">
                            {{ __('common.products') }}
                        </h3>
                        @if(!$viewMode && $status !== 'completed')
                            <button type="button" 
                                    wire:click="addItem"
                                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                {{ __('common.add_product') }}
                            </button>
                        @endif
                    </div>

                    {{-- Column Headers - Removed, using labels instead --}}

                    <div class="space-y-4">
                        @foreach($items as $index => $item)
                        <div class="p-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <div class="grid grid-cols-12 gap-4">
                                {{-- Product --}}
                                <div class="col-span-12 md:col-span-4">
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        {{ __('common.product') }} *
                                    </label>
                                    <div class="flex gap-2">
                                        <div class="flex-1 relative" x-data="{ open: false }">
                                            {{-- Search Input --}}
                                            <input 
                                                type="text"
                                                wire:model.live="productSearches.{{ $index }}"
                                                @click="open = true"
                                                @click.away="open = false"
                                                placeholder="{{ __('common.search_product') }}"
                                                @if($viewMode || $status === 'completed') disabled @endif
                                                class="w-full px-3 py-2 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('items.'.$index.'.product_id') border-red-500 @enderror">
                                            
                                            {{-- Clear Button --}}
                                            @if(isset($items[$index]['product_id']) && $items[$index]['product_id'])
                                                <button 
                                                    type="button"
                                                    wire:click="clearProduct({{ $index }})"
                                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            @endif
                                            
                                            {{-- Dropdown --}}
                                            <div 
                                                x-show="open"
                                                x-transition
                                                class="absolute z-50 w-full mt-1 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                                @php
                                                    $filteredProducts = $this->getFilteredProductsForItem($index);
                                                @endphp
                                                @if($filteredProducts->count() > 0)
                                                    @foreach($filteredProducts as $product)
                                                        <button
                                                            type="button"
                                                            wire:click="selectProduct({{ $index }}, {{ $product->id }}, '{{ $product->name }}', {{ $product->price }})"
                                                            @click="open = false"
                                                            class="w-full px-4 py-2 text-left hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-900 dark:text-white transition-colors text-sm">
                                                            {{ $product->name }} (Stock: {{ $product->stock }})
                                                        </button>
                                                    @endforeach
                                                @else
                                                    <div class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
                                                        {{ __('common.no_products_found') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        @if(!$viewMode)
                                            <button type="button" 
                                                    wire:click="openQuickProductModal({{ $index }})"
                                                    class="px-3 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition-colors flex items-center gap-1 whitespace-nowrap"
                                                    title="{{ __('common.register_new_product') }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                </svg>
                                                {{ __('common.new') }}
                                            </button>
                                        @endif
                                    </div>
                                    @error('items.'.$index.'.product_id')
                                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Quantity --}}
                                <div class="col-span-6 md:col-span-2">
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        {{ __('common.quantity') }} *
                                    </label>
                                    <input type="number" 
                                           wire:model.live="items.{{ $index }}.quantity"
                                           min="1"
                                           @if(empty($item['product_id']) || $viewMode || $status === 'completed') disabled @endif
                                           class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 @if(empty($item['product_id'])) opacity-50 cursor-not-allowed @endif @error('items.'.$index.'.quantity') border-red-500 @enderror">
                                    @error('items.'.$index.'.quantity')
                                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Unit Price --}}
                                <div class="col-span-6 md:col-span-2" x-data="moneyInput({{ $item['unit_price'] ?? 0 }}, 'items', {{ $index }})">
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        {{ __('common.price') }} *
                                    </label>
                                    <input type="text" 
                                           x-model="formatted"
                                           @input="updateValue($event)"
                                           @click="forceEnd($el)"
                                           @keydown.arrow-left.prevent
                                           @keydown.arrow-right.prevent
                                           data-field="unit_price"
                                           inputmode="numeric"
                                           @if(empty($item['product_id']) || $viewMode || $status === 'completed') disabled @endif
                                           class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 @if(empty($item['product_id'])) opacity-50 cursor-not-allowed @endif @error('items.'.$index.'.unit_price') border-red-500 @enderror">
                                    @error('items.'.$index.'.unit_price')
                                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Tax Rate --}}
                                <div class="col-span-6 md:col-span-2" x-data="moneyInput({{ $item['tax_rate'] ?? 0 }}, 'items', {{ $index }})">
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Tax %
                                    </label>
                                    <input type="text" 
                                           x-model="formatted"
                                           @input="updateValue($event)"
                                           @click="forceEnd($el)"
                                           @keydown.arrow-left.prevent
                                           @keydown.arrow-right.prevent
                                           data-field="tax_rate"
                                           inputmode="numeric"
                                           @if(empty($item['product_id']) || $viewMode || $status === 'completed') disabled @endif
                                           class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 @if(empty($item['product_id'])) opacity-50 cursor-not-allowed @endif">
                                </div>

                                {{-- Subtotal --}}
                                <div class="col-span-6 md:col-span-2">
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        {{ __('common.subtotal') }}
                                    </label>
                                    <div class="px-3 py-2 bg-zinc-100 dark:bg-zinc-700 border border-zinc-200 dark:border-zinc-600 rounded-lg text-sm text-zinc-900 dark:text-zinc-100 font-medium">
                                        ${{ number_format((float)($item['subtotal'] ?? 0) + (float)($item['tax_amount'] ?? 0), 2) }}
                                    </div>
                                </div>
                            </div>

                            {{-- Remove Button --}}
                            @if(count($items) > 1 && !$viewMode && $status !== 'completed')
                                <div class="mt-3 flex justify-end">
                                    <button type="button" 
                                            wire:click="removeItem({{ $index }})"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        {{ __('common.remove') }}
                                    </button>
                                </div>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    {{-- Total Section --}}
                    <div class="mt-4 space-y-3">
                        {{-- Tax Breakdown Summary --}}
                        <div class="flex justify-end">
                            <div class="bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700 rounded-lg px-6 py-4 min-w-[350px]">
                                <h4 class="text-sm font-semibold text-zinc-900 dark:text-white mb-3">{{ __('common.tax_breakdown') }}</h4>
                                <div class="space-y-2 text-sm">
                                    @php
                                        $taxableSubtotal = collect($items)->where('is_tax_exempt', false)->sum('subtotal');
                                        $exemptSubtotal = collect($items)->where('is_tax_exempt', true)->sum('subtotal');
                                        $totalTax = collect($items)->sum('tax_amount');
                                        $grandTotal = $taxableSubtotal + $exemptSubtotal + $totalTax;
                                    @endphp
                                    
                                    <div class="flex justify-between text-zinc-600 dark:text-zinc-400">
                                        <span>{{ __('common.taxable_subtotal') }}:</span>
                                        <span class="font-medium">${{ number_format($taxableSubtotal, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between text-zinc-600 dark:text-zinc-400">
                                        <span>{{ __('common.exempt_subtotal') }}:</span>
                                        <span class="font-medium">${{ number_format($exemptSubtotal, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between text-zinc-600 dark:text-zinc-400 pt-2 border-t border-zinc-300 dark:border-zinc-600">
                                        <span>Subtotal:</span>
                                        <span class="font-medium">${{ number_format($taxableSubtotal + $exemptSubtotal, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between text-blue-600 dark:text-blue-400">
                                        <span>Tax:</span>
                                        <span class="font-medium">${{ number_format($totalTax, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between text-lg font-bold text-zinc-900 dark:text-white pt-2 border-t-2 border-zinc-300 dark:border-zinc-600">
                                        <span>Total:</span>
                                        <span>${{ number_format($grandTotal, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Exchange Rate Toggle (only show if rate exists) --}}
                        @if(isset($exchangeRate) && $exchangeRate)
                            <div class="flex justify-end">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" 
                                           wire:model.live="showExchangeRate" 
                                           class="sr-only peer">
                                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                    <span class="ms-3 text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('common.show_exchange_rate') }}</span>
                                </label>
                            </div>
                        @endif

                        {{-- Total Display --}}
                        <div class="flex justify-end">
                            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg px-6 py-3 min-w-[300px]">
                                <div class="space-y-2">
                                    {{-- USD Total --}}
                                    <div class="flex items-center justify-between gap-4">
                                        <span class="text-sm font-medium text-blue-900 dark:text-blue-100">{{ __('common.total') }} (USD):</span>
                                        <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">${{ number_format($total_amount, 2) }}</span>
                                    </div>

                                    {{-- Exchange Rate Conversion --}}
                                    @if($showExchangeRate && isset($exchangeRate) && $exchangeRate)
                                        <div class="pt-2 border-t border-blue-200 dark:border-blue-700">
                                            <div class="flex items-center justify-between gap-4 mb-1">
                                                <span class="text-xs text-blue-700 dark:text-blue-300">{{ __('common.exchange_rate') }}:</span>
                                                <span class="text-xs text-blue-700 dark:text-blue-300">Bs. {{ number_format($exchangeRate->rate, 2) }}</span>
                                            </div>
                                            <div class="flex items-center justify-between gap-4">
                                                <span class="text-sm font-medium text-blue-900 dark:text-blue-100">{{ __('common.total') }} (Bs):</span>
                                                <span class="text-xl font-bold text-green-600 dark:text-green-400">Bs. {{ number_format($total_amount * $exchangeRate->rate, 2) }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-800 flex justify-end gap-3">
                <button type="button" wire:click="cancel"
                        class="px-4 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-500 rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                    {{ $viewMode ? __('common.close') : __('common.cancel') }}
                </button>
                
                @if(!$viewMode)
                    {{-- Save/Update button (stays in form) --}}
                    <button type="button" wire:click="Store"
                            class="px-4 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 border-2 border-blue-600 dark:border-blue-500 hover:border-blue-700 dark:hover:border-blue-400 rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        {{ $editMode ? __('common.update') : __('common.save') }}
                    </button>
                    
                    {{-- Save/Update & Exit button (closes form) --}}
                    <button type="button" wire:click="storeAndExit"
                            class="px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        {{ $editMode ? __('common.update_and_exit') : __('common.save_and_exit') }}
                    </button>
                @endif
            </div>
    </div>
</div>

{{-- Quick Product Creation Modal --}}
@if($showQuickProductModal)
<div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    {{-- Backdrop --}}
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" wire:click="closeQuickProductModal"></div>
    
    {{-- Modal --}}
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white dark:bg-zinc-900 rounded-xl shadow-xl max-w-md w-full p-6 border border-zinc-200 dark:border-zinc-800">
            {{-- Header --}}
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
                    {{ __('common.register_new_product') }}
                </h3>
                <button type="button" 
                        wire:click="closeQuickProductModal"
                        class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Form --}}
            <form wire:submit.prevent="createQuickProduct" class="space-y-4">
                {{-- Product Name --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        {{ __('common.product_name') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           wire:model="quickProductName"
                           class="w-full px-3 py-2 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('quickProductName') border-red-500 @enderror"
                           placeholder="{{ __('common.enter_product_name') }}">
                    @error('quickProductName')
                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- SKU (auto-generated) --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        {{ __('common.sku') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           wire:model="quickProductSku"
                           class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-600 dark:text-gray-400"
                           readonly>
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">{{ __('common.auto_generated') }}</p>
                </div>

                {{-- Category --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        {{ __('common.category') }} <span class="text-red-500">*</span>
                    </label>
                    
                    <div class="relative" x-data="{ open: false }">
                        {{-- Search Input --}}
                        <input 
                            type="text"
                            wire:model.live="quickCategorySearch"
                            @click="open = true"
                            @click.away="open = false"
                            placeholder="{{ __('common.search_category') }}"
                            class="w-full px-3 py-2 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('quickProductCategory') border-red-500 @enderror">
                        
                        {{-- Clear Button --}}
                        @if($quickProductCategory)
                            <button 
                                type="button"
                                wire:click="clearQuickCategory"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        @endif
                        
                        {{-- Dropdown --}}
                        <div 
                            x-show="open"
                            x-transition
                            class="absolute z-50 w-full mt-1 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                            @if($this->filteredQuickCategories->count() > 0)
                                @foreach($this->filteredQuickCategories as $category)
                                    <button
                                        type="button"
                                        wire:click="selectQuickCategory({{ $category->id }}, '{{ $category->name }}')"
                                        @click="open = false"
                                        class="w-full px-4 py-2 text-left hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-900 dark:text-white transition-colors text-sm">
                                        {{ $category->name }}
                                    </button>
                                @endforeach
                            @else
                                <div class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('common.no_categories_found') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    @error('quickProductCategory')
                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Product Type --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        {{ __('common.product_type') }}
                    </label>
                    <select wire:model="quickProductType"
                            class="w-full px-3 py-2 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="physical">{{ __('common.physical') }}</option>
                        <option value="digital">{{ __('common.digital') }}</option>
                    </select>
                </div>

                {{-- Info Note --}}
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3">
                    <p class="text-xs text-blue-700 dark:text-blue-300">
                        ℹ️ {{ __('common.quick_product_note') }}
                    </p>
                </div>

                {{-- Actions --}}
                <div class="flex justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                    <button type="button" 
                            wire:click="closeQuickProductModal"
                            class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors">
                        {{ __('common.cancel') }}
                    </button>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition-colors">
                        {{ __('common.create_product') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
