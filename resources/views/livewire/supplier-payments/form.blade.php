{{-- Supplier Payment Form --}}
<div class="max-w-6xl mx-auto">
    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-800">
        <form wire:submit.prevent="submitForm">
            {{-- Header --}}
            <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">
                            @if($viewMode)
                                {{ __('common.view_payment') }}
                            @elseif($editMode)
                                {{ __('common.edit_payment') }}
                            @else
                                {{ __('common.new_payment') }}
                            @endif
                        </h2>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                            {{ __('common.register_supplier_payment') }}
                        </p>
                    </div>
                    <flux:button wire:click="cancel" variant="ghost" icon="x-mark">
                        {{ __('common.close') }}
                    </flux:button>
                </div>
            </div>

            <div class="p-6 space-y-6">
                {{-- Payment Information --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Supplier --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('common.supplier') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   wire:model.live="supplierSearch"
                                   wire:click="$set('showSupplierDropdown', true)"
                                   placeholder="{{ __('common.search_supplier') }}"
                                   class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('supplier_id') border-red-500 @enderror"
                                   autocomplete="off"
                                   @if($viewMode) disabled @endif>
                            
                            @if($supplier_id && $supplierName)
                                <button type="button" 
                                        wire:click="clearSupplier"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                        @if($viewMode) disabled @endif>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            @endif
                            
                            @if($showSupplierDropdown && !$supplier_id && count($suppliers) > 0)
                                <div class="absolute z-10 w-full mt-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                    @foreach($suppliers as $supplier)
                                        <button type="button"
                                                wire:click="selectSupplier({{ $supplier->id }}, '{{ $supplier->name }}')"
                                                class="w-full px-4 py-2 text-left hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 last:border-0">
                                            {{ $supplier->name }}
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        @error('supplier_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Purchase (Optional) --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('common.purchase') }}
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   wire:model.live="purchaseSearch"
                                   wire:click="$set('showPurchaseDropdown', true)"
                                   placeholder="{{ __('common.search_purchase') }}"
                                   class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                   autocomplete="off"
                                   @if($viewMode) disabled @endif>
                            
                            @if($purchase_id && $purchaseName)
                                <button type="button" 
                                        wire:click="clearPurchase"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                        @if($viewMode) disabled @endif>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            @endif
                            
                            @if($showPurchaseDropdown && !$purchase_id && count($purchases) > 0)
                                <div class="absolute z-10 w-full mt-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                    @foreach($purchases as $purchase)
                                        @php
                                            // Use total field if it exists and is greater than 0, otherwise calculate
                                            $purchaseTotal = ($purchase->total && $purchase->total > 0) 
                                                ? $purchase->total 
                                                : ($purchase->subtotal + $purchase->tax_amount);
                                        @endphp
                                        <button type="button"
                                                wire:click="selectPurchase({{ $purchase->id }}, '{{ $purchase->invoice_number }} - ${{ number_format($purchaseTotal, 2) }}')"
                                                class="w-full px-4 py-2 text-left hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 last:border-0">
                                            <div class="font-medium">{{ $purchase->invoice_number }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">${{ number_format($purchaseTotal, 2) }}</div>
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ __('common.purchase_payment_help') }}</p>
                    </div>

                    {{-- Amount --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('common.amount') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               wire:model="amount"
                               step="0.01"
                               min="0.01"
                               placeholder="0.00"
                               class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('amount') border-red-500 @enderror"
                               @if($viewMode) disabled @endif
                               required>
                        @error('amount')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Payment Date --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('common.payment_date') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               wire:model="payment_date" 
                               class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('payment_date') border-red-500 @enderror"
                               @if($viewMode) disabled @endif
                               required>
                        @error('payment_date')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Payment Method --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('common.payment_method') }} <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="payment_method"
                                class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                @if($viewMode) disabled @endif
                                required>
                            <option value="cash">{{ __('common.cash') }}</option>
                            <option value="transfer">{{ __('common.transfer') }}</option>
                            <option value="check">{{ __('common.check') }}</option>
                            <option value="card">{{ __('common.card') }}</option>
                        </select>
                    </div>

                    {{-- Reference --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('common.reference') }}
                        </label>
                        <input type="text" 
                               wire:model="reference"
                               placeholder="{{ __('common.check_number_or_reference') }}"
                               class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                               @if($viewMode) disabled @endif>
                    </div>
                </div>

                {{-- Notes --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('common.notes') }}
                    </label>
                    <textarea wire:model="notes" 
                              rows="3"
                              placeholder="{{ __('common.additional_notes') }}"
                              class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                              @if($viewMode) disabled @endif></textarea>
                </div>
            </div>

            {{-- Footer --}}
            <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-800 flex justify-end gap-3">
                <button type="button" wire:click="cancel"
                        class="px-4 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-500 rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                    {{ $viewMode ? __('common.close') : __('common.cancel') }}
                </button>
                
                @if(!$viewMode)
                    <button type="submit"
                            class="px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        {{ $editMode ? __('common.update') : __('common.save') }}
                    </button>
                @endif
            </div>
        </form>
    </div>
</div>
