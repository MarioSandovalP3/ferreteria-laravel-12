<div>
    @if($showForm)
        @include('livewire.exchange-rates.form')
    @else
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <flux:heading size="xl" level="1" class="text-zinc-900 dark:text-white font-bold tracking-tight">
                    {{ __('common.exchange_rates_title') }}
                </flux:heading>
                <flux:subheading size="lg" class="text-zinc-500 dark:text-zinc-400 mt-1">
                    {{ __('common.manage_exchange_rates') }}
                </flux:subheading>
            </div>
            <flux:button wire:click="create" variant="primary" icon="plus">
                {{ __('common.new_rate') }}
            </flux:button>
        </div>

        {{-- Filters --}}
        <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-800 p-6 mb-6">
            {{-- Search --}}
            <flux:input 
                wire:model.live.debounce.300ms="search"
                placeholder="{{ __('common.search_by_date_or_notes') }}"
                icon="magnifying-glass"
            />
        </div>

        {{-- Exchange Rates Table --}}
        <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-800 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                {{ __('common.currency') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                {{ __('common.rate_1_usd') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                {{ __('common.effective_date') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                {{ __('common.state') }}
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                {{ __('common.actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse($rates as $rate)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-zinc-900 dark:text-white">
                                        {{ $rate->country->currency }}
                                    </div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ $rate->country->currency_symbol }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-blue-600 dark:text-blue-400">
                                        {{ number_format($rate->rate, 4) }}
                                    </div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ $rate->country->currency_symbol }}{{ number_format($rate->rate, 2) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-zinc-900 dark:text-white">
                                        {{ $rate->effective_date->format('d/m/Y') }}
                                    </div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ $rate->effective_date->diffForHumans() }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($rate->is_active)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ __('common.active') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400">
                                            {{ __('common.inactive') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="relative inline-block text-left">
                                        <flux:dropdown align="end">
                                            <flux:button variant="ghost" size="sm" class="-my-2 cursor-pointer">
                                                <flux:icon icon="ellipsis-horizontal" />
                                            </flux:button>
                                            
                                            <flux:menu>
                                                <flux:menu.item icon="pencil-square" wire:click="edit({{ $rate->id }})" class="cursor-pointer">
                                                    {{ __('common.edit') }}
                                                </flux:menu.item>
                                                <flux:menu.item 
                                                    icon="trash" 
                                                    variant="danger" 
                                                    wire:click="delete({{ $rate->id }})"
                                                    wire:confirm="{{ __('common.are_you_sure_delete_rate') }}"
                                                    class="cursor-pointer">
                                                    {{ __('common.delete') }}
                                                </flux:menu.item>
                                            </flux:menu>
                                        </flux:dropdown>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="h-12 w-12 text-zinc-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-zinc-500 dark:text-zinc-400 text-lg font-medium">{{ __('common.no_rates_registered') }}</p>
                                        <p class="text-zinc-400 dark:text-zinc-500 text-sm mt-1">{{ __('common.start_by_registering_first_rate') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($rates->hasPages())
                <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-800">
                    {{ $rates->links() }}
                </div>
            @endif
        </div>
    @endif
</div>
