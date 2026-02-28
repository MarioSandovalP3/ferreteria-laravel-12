<div class="w-full max-w-9xl mx-auto">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <flux:heading size="xl" level="1" class="text-zinc-900 dark:text-white font-bold tracking-tight">
                {{ __('common.inventory') }}
            </flux:heading>
            <flux:subheading size="lg" class="text-zinc-500 dark:text-zinc-400 mt-1">
                {{ __('common.manage_product_inventory') }}
            </flux:subheading>
        </div>
    </div>

    {{-- Main Content Card --}}
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm overflow-hidden">
        
        {{-- Toolbar --}}
        <div class="p-5 border-b border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
            <div class="flex flex-col sm:flex-row gap-4 justify-between">
                {{-- Search --}}
                <div class="relative w-full sm:max-w-md">
                    <flux:input 
                        wire:model.live="search" 
                        placeholder="{{ __('common.search_products') }}"
                        type="text"  
                        class="w-full bg-white dark:bg-zinc-800"
                    />
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                        <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider">{{ __('common.product') }}</th>
                        <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider">{{ __('common.sku') }}</th>
                        <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider">{{ __('common.current_stock') }}</th>
                        <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider">{{ __('common.low_stock_threshold') }}</th>
                        <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider">{{ __('common.stock_status') }}</th>
                        <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider text-right">{{ __('common.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    @forelse ($products as $product)
                    <tr class="group hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors duration-150 ease-in-out">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                @if($product->featured_image)
                                    <img src="{{ Storage::url($product->featured_image) }}" 
                                         alt="{{ $product->name }}"
                                         class="w-10 h-10 rounded object-cover">
                                @else
                                    <div class="w-10 h-10 rounded bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                @endif
                                <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $product->name }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-zinc-600 dark:text-zinc-400 font-mono text-sm">{{ $product->sku }}</span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ $product->stock ?? 0 }}</span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-zinc-600 dark:text-zinc-400">{{ $product->low_stock_threshold ?? '-' }}</span>
                        </td>
                        <td class="py-4 px-6">
                            @if($product->stock <= 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                    {{ __('common.out_of_stock') }}
                                </span>
                            @elseif($product->low_stock_threshold && $product->stock <= $product->low_stock_threshold)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                    {{ __('common.low_stock') }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                    {{ __('common.in_stock') }}
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center justify-end gap-2">
                                <button wire:click="viewMovements({{ $product->id }})"
                                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 border border-blue-200 dark:border-blue-800 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    {{ __('common.view_movements') }}
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-zinc-300 dark:text-zinc-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                                <p class="text-zinc-500 dark:text-zinc-400 text-lg font-medium">{{ __('common.no_products_found') }}</p>
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
</div>
