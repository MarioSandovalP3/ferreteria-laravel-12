<div>
    @if($showForm)
        @include('livewire.products.form')
    @else
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <flux:heading size="xl" level="1" class="text-zinc-900 dark:text-white font-bold tracking-tight">
                    {{ __('common.products') }}
                </flux:heading>
                <flux:subheading size="lg" class="text-zinc-500 dark:text-zinc-400 mt-1">
                    {{ __('common.manage_your_product_catalog') }}
                </flux:subheading>
            </div>
            <flux:button wire:click="create" variant="primary" icon="plus">
                {{ __('common.new_product') }}
            </flux:button>
        </div>

        {{-- Filters --}}
        <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-800 p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                {{-- Search --}}
                <div>
                    <flux:input 
                        wire:model.live.debounce.300ms="search"
                        placeholder="{{ __('common.search_products') }}"
                        icon="magnifying-glass"
                    />
                </div>

                {{-- Product Type Filter --}}
                <div>
                    <select 
                        wire:model.live="product_type_filter"
                        class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">{{ __('common.all_types') }}</option>
                        <option value="physical">📦 {{ __('common.physical') }}</option>
                        <option value="service">🛠️ {{ __('common.service') }}</option>
                        <option value="digital">💻 {{ __('common.digital') }}</option>
                    </select>
                </div>

                {{-- Category Filter --}}
                <div>
                    <select 
                        wire:model.live="category_filter"
                        class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">{{ __('common.all_categories') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Status Filter --}}
                <div>
                    <select 
                        wire:model.live="status_filter"
                        class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">{{ __('common.all_status') }}</option>
                        <option value="active">{{ __('common.active') }}</option>
                        <option value="inactive">{{ __('common.inactive') }}</option>
                        <option value="featured">{{ __('common.featured') }}</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Products Table --}}
        <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-800 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                {{ __('common.image') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                {{ __('common.product') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                {{ __('common.category') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                {{ __('common.product_type') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                {{ __('common.price') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                {{ __('common.stock') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                {{ __('common.status') }}
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                {{ __('common.actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse($products as $product)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($product->featured_image)
                                        <img src="{{ Storage::url($product->featured_image) }}" 
                                             alt="{{ $product->name }}"
                                             class="h-12 w-12 rounded-lg object-cover">
                                    @else
                                        <div class="h-12 w-12 rounded-lg bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                            <svg class="h-6 w-6 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-zinc-900 dark:text-white">
                                        {{ $product->name }}
                                    </div>
                                    <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                        SKU: {{ $product->sku }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-zinc-900 dark:text-white">
                                        {{ $product->category->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $typeColors = [
                                            'physical' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                            'service' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
                                            'digital' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                        ];
                                        $typeColor = $typeColors[$product->product_type] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $typeColor }}">
                                        {{ __('common.' . $product->product_type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-zinc-900 dark:text-white">
                                        ${{ number_format($product->price, 2) }}
                                    </div>
                                    @if($product->sale_price)
                                        <div class="text-xs text-green-600 dark:text-green-400">
                                            Sale: ${{ number_format($product->sale_price, 2) }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-zinc-900 dark:text-white">
                                        {{ $product->stock }}
                                    </div>
                                    @if($product->is_low_stock)
                                        <span class="text-xs text-orange-600 dark:text-orange-400">{{ __('common.low_stock') }}</span>
                                    @elseif($product->is_out_of_stock)
                                        <span class="text-xs text-red-600 dark:text-red-400">{{ __('common.out_of_stock') }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col gap-1">
                                        @if($product->is_active)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                {{ __('common.active') }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400">
                                                {{ __('common.inactive') }}
                                            </span>
                                        @endif
                                        @if($product->is_featured)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                                {{ __('common.featured') }}
                                            </span>
                                        @endif
                                        @if($product->is_new)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                                {{ __('common.new') }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="relative inline-block text-left">
                                        <flux:dropdown align="end">
                                            <flux:button variant="ghost" size="sm" class="-my-2 cursor-pointer">
                                                <flux:icon icon="ellipsis-horizontal" />
                                            </flux:button>
                                            
                                            <flux:menu>
                                                <flux:menu.item icon="pencil-square" wire:click="edit({{ $product->id }})" class="cursor-pointer">{{ __('common.edit') }}</flux:menu.item>
                                                <flux:menu.item 
                                                    icon="trash" 
                                                    variant="danger" 
                                                    wire:click="delete({{ $product->id }})"
                                                    wire:confirm="Are you sure you want to delete this product?"
                                                    class="cursor-pointer">{{ __('common.delete') }}</flux:menu.item>
                                            </flux:menu>
                                        </flux:dropdown>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="h-12 w-12 text-zinc-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <p class="text-zinc-500 dark:text-zinc-400 text-lg font-medium">{{ __('common.no_products_found') }}</p>
                                        <p class="text-zinc-400 dark:text-zinc-500 text-sm mt-1">{{ __('common.get_started_by_creating_your_first_product') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($products->hasPages())
                <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-800">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    @endif
</div>
