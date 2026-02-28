{{-- Sales Form --}}
<div class="max-w-6xl mx-auto">
    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-800">
        <form wire:submit.prevent="submitForm">
            {{-- Header --}}
            <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">
                            {{ $editMode ? __('common.edit_sale') : __('common.new_sale') }}
                        </h2>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                            {{ __('common.manage_sales') }}
                        </p>
                    </div>
                    <flux:button wire:click="cancel" variant="ghost" icon="x-mark">
                        {{ __('common.close') }}
                    </flux:button>
                </div>
            </div>

            <div class="p-6 space-y-6">
                {{-- Sale Information --}}
                <div>
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-4">
                        {{ __('common.sale_information') }}
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Client --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.client') }}
                            </label>
                            <select wire:model="client_id"
                                    class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                <option value="">{{ __('common.general_public') }}</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Invoice Number --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.invoice_number') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   wire:model="invoice_number" 
                                   class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('invoice_number') border-red-500 @enderror"
                                   required>
                            @error('invoice_number')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.status') }} <span class="text-red-500">*</span>
                            </label>
                            <select wire:model="status"
                                    class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                <option value="pending">{{ __('common.pending') }}</option>
                                <option value="completed">{{ __('common.completed') }}</option>
                                <option value="cancelled">{{ __('common.cancelled') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        {{-- Payment Status --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.payment_status') }} <span class="text-red-500">*</span>
                            </label>
                            <select wire:model="payment_status"
                                    class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                <option value="unpaid">{{ __('common.unpaid') }}</option>
                                <option value="partial">{{ __('common.partial') }}</option>
                                <option value="paid">{{ __('common.paid') }}</option>
                            </select>
                        </div>

                        {{-- Payment Method --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.payment_method') }}
                            </label>
                            <select wire:model="payment_method"
                                    class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                <option value="">{{ __('common.select') }}</option>
                                <option value="cash">{{ __('common.cash') }}</option>
                                <option value="card">{{ __('common.card') }}</option>
                                <option value="transfer">{{ __('common.transfer') }}</option>
                                <option value="mixed">{{ __('common.mixed') }}</option>
                                <option value="credit">{{ __('common.credit') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Global Tax/Discount --}}
                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.global_tax_percent') }}
                            </label>
                            <input wire:model.live="global_tax_percent" type="number" step="0.01" 
                                   class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.global_discount_percent') }}
                            </label>
                            <input wire:model.live="global_discount_percent" type="number" step="0.01" 
                                   class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                {{-- Products --}}
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-zinc-900 dark:text-white">
                            {{ __('common.products') }}
                        </h3>
                        <button type="button" wire:click="addItem"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            {{ __('common.add_product') }}
                        </button>
                    </div>

                    <div class="space-y-3">
                        @foreach($items as $index => $item)
                            <div class="p-4 bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg">
                                <div class="grid grid-cols-12 gap-3">
                                    {{-- Product Search --}}
                                    <div class="col-span-3">
                                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('common.product') }}</label>
                                        <div class="relative" x-data="{ open: false }">
                                            <input type="text" wire:model.live="productSearches.{{ $index }}" @click="open = true" @click.away="open = false"
                                                   placeholder="{{ __('common.search_product') }}"
                                                   class="w-full px-3 py-2 text-sm bg-white dark:bg-zinc-900 border border-gray-300 dark:border-gray-600 rounded-lg">
                                            
                                            @if(isset($items[$index]['product_id']) && $items[$index]['product_id'])
                                                <button type="button" wire:click="clearProduct({{ $index }})"
                                                        class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                            @endif
                                            
                                            <div x-show="open" x-transition class="absolute z-50 w-full mt-1 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg max-h-48 overflow-y-auto">
                                                @php $filteredProducts = $this->getFilteredProductsForItem($index); @endphp
                                                @if($filteredProducts->count() > 0)
                                                    @foreach($filteredProducts as $product)
                                                        <button type="button" wire:click="selectProduct({{ $index }}, {{ $product->id }}, '{{ $product->name }}', {{ $product->price }})" @click="open = false"
                                                                class="w-full px-3 py-2 text-left hover:bg-zinc-100 dark:hover:bg-zinc-800 text-sm">
                                                            {{ $product->name }} (Stock: {{ $product->stock }})
                                                        </button>
                                                    @endforeach
                                                @else
                                                    <div class="px-3 py-2 text-sm text-gray-500">{{ __('common.no_products_found') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Quantity --}}
                                    <div class="col-span-1">
                                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('common.qty') }}</label>
                                        <input wire:model.live="items.{{ $index }}.quantity" type="number" min="1" 
                                               class="w-full px-2 py-2 text-sm bg-white dark:bg-zinc-900 border border-gray-300 dark:border-gray-600 rounded-lg">
                                    </div>

                                    {{-- Unit Price --}}
                                    <div class="col-span-2">
                                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('common.unit_price') }}</label>
                                        <input wire:model.live="items.{{ $index }}.unit_price" type="number" step="0.01" 
                                               class="w-full px-2 py-2 text-sm bg-white dark:bg-zinc-900 border border-gray-300 dark:border-gray-600 rounded-lg">
                                    </div>

                                    {{-- Discount % --}}
                                    <div class="col-span-1">
                                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('common.disc') }}%</label>
                                        <input wire:model.live="items.{{ $index }}.discount_percent" type="number" step="0.01" 
                                               class="w-full px-2 py-2 text-sm bg-white dark:bg-zinc-900 border border-gray-300 dark:border-gray-600 rounded-lg">
                                    </div>

                                    {{-- Tax % --}}
                                    <div class="col-span-1">
                                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('common.tax') }}%</label>
                                        <input wire:model.live="items.{{ $index }}.tax_percent" type="number" step="0.01" 
                                               class="w-full px-2 py-2 text-sm bg-white dark:bg-zinc-900 border border-gray-300 dark:border-gray-600 rounded-lg">
                                    </div>

                                    {{-- Subtotal --}}
                                    <div class="col-span-2">
                                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('common.subtotal') }}</label>
                                        <div class="px-2 py-2 text-sm bg-zinc-100 dark:bg-zinc-700 border border-zinc-200 dark:border-zinc-600 rounded-lg">
                                            ${{ number_format((float)($item['subtotal'] ?? 0), 2) }}
                                        </div>
                                    </div>

                                    {{-- Total --}}
                                    <div class="col-span-2">
                                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('common.total') }}</label>
                                        <div class="px-2 py-2 text-sm bg-zinc-100 dark:bg-zinc-700 border border-zinc-200 dark:border-zinc-600 rounded-lg font-semibold">
                                            ${{ number_format((float)($item['total'] ?? 0), 2) }}
                                        </div>
                                    </div>

                                    {{-- Remove --}}
                                    <div class="col-span-1 flex items-end">
                                        <button type="button" wire:click="removeItem({{ $index }})" 
                                                class="w-full px-2 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm transition-colors">
                                            <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Totals --}}
                <div class="p-4 bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg">
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div class="text-right font-medium text-gray-700 dark:text-gray-300">{{ __('common.subtotal') }}:</div>
                        <div class="text-right text-gray-900 dark:text-white">${{ number_format($subtotal, 2) }}</div>
                        
                        <div class="text-right font-medium text-gray-700 dark:text-gray-300">{{ __('common.discount') }}:</div>
                        <div class="text-right text-red-600 dark:text-red-400">-${{ number_format($discount_amount, 2) }}</div>
                        
                        <div class="text-right font-medium text-gray-700 dark:text-gray-300">{{ __('common.tax') }}:</div>
                        <div class="text-right text-gray-900 dark:text-white">${{ number_format($tax_amount, 2) }}</div>
                        
                        <div class="text-right text-lg font-bold text-gray-900 dark:text-white">{{ __('common.total') }}:</div>
                        <div class="text-right text-lg font-bold text-blue-600 dark:text-blue-400">${{ number_format($total, 2) }}</div>
                    </div>
                </div>

                {{-- Notes --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('common.notes') }}
                    </label>
                    <textarea wire:model="notes" rows="3" 
                              class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
            </div>

            {{-- Footer --}}
            <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-800 flex justify-end gap-3">
                <flux:button wire:click="cancel" variant="ghost">
                    {{ __('common.cancel') }}
                </flux:button>
                <flux:button type="submit" variant="primary">
                    {{ $editMode ? __('common.update_sale') : __('common.save_sale') }}
                </flux:button>
            </div>
        </form>
    </div>
</div>
