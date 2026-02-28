<div class="w-full max-w-9xl mx-auto">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <flux:heading size="xl" level="1" class="text-zinc-900 dark:text-white font-bold tracking-tight">
                {{ __('common.inventory_movements') }}
            </flux:heading>
            <flux:subheading size="lg" class="text-zinc-500 dark:text-zinc-400 mt-1">
                {{ $product->name }} - {{ __('common.sku') }}: {{ $product->sku }}
            </flux:subheading>
        </div>

        <button wire:click="closeMovements"
                class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-600 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            {{ __('common.back_to_inventory') }}
        </button>
    </div>

    {{-- Stock Summary Card --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('common.current_stock') }}</p>
                    <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-1">{{ $product->stock ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('common.total_movements') }}</p>
                    <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-1">{{ $movements->total() }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('common.stock_status') }}</p>
                    <p class="text-lg font-semibold mt-1">
                        @if($product->stock <= 0)
                            <span class="text-red-600 dark:text-red-400">{{ __('common.out_of_stock') }}</span>
                        @elseif($product->low_stock_threshold && $product->stock <= $product->low_stock_threshold)
                            <span class="text-yellow-600 dark:text-yellow-400">{{ __('common.low_stock') }}</span>
                        @else
                            <span class="text-green-600 dark:text-green-400">{{ __('common.in_stock') }}</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Movements Table --}}
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800">
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ __('common.movement_history') }}</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                        <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider">{{ __('common.date') }}</th>
                        <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider">{{ __('common.type') }}</th>
                        <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider">{{ __('common.quantity') }}</th>
                        <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider">{{ __('common.stock_before') }}</th>
                        <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider">{{ __('common.stock_after') }}</th>
                        <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider">{{ __('common.reference') }}</th>
                        <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider">{{ __('common.created_by') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    @forelse ($movements as $movement)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                        <td class="py-4 px-6">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ $movement->created_at->format('d/m/Y H:i') }}</span>
                        </td>
                        <td class="py-4 px-6">
                            @if($movement->type === 'in')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                                    </svg>
                                    {{ __('common.in') }}
                                </span>
                            @elseif($movement->type === 'out')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                                    </svg>
                                    {{ __('common.out') }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                    {{ __('common.adjustment') }}
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <span class="font-semibold {{ $movement->type === 'in' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ $movement->type === 'in' ? '+' : '-' }}{{ abs($movement->quantity) }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-zinc-600 dark:text-zinc-400">{{ $movement->stock_before }}</span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $movement->stock_after }}</span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">
                                {{ $movement->notes ?? '-' }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ $movement->creator->name ?? '-' }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center">
                            <p class="text-zinc-500 dark:text-zinc-400">{{ __('common.no_movements_found') }}</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($movements->hasPages())
            <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-800">
                {{ $movements->links() }}
            </div>
        @endif
    </div>
</div>
