<div class="w-full max-w-9xl mx-auto">
    @if($showForm)
        @include('livewire.sales.form')
    @else
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <flux:heading size="xl" level="1" class="text-zinc-900 dark:text-white font-bold tracking-tight">
                    {{ __('common.sales') }}
                </flux:heading>
                <flux:subheading size="lg" class="text-zinc-500 dark:text-zinc-400 mt-1">
                    {{ __('common.manage_sales') }}
                </flux:subheading>
            </div>

            <button wire:click="create"
               class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-500 active:bg-blue-700 rounded-lg shadow-sm transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 dark:focus:ring-offset-zinc-900 cursor-pointer">
                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('common.new_sale') }}
            </button>
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
                            placeholder="{{ __('common.search') }}"
                            type="text"  
                            class="w-full bg-white dark:bg-zinc-800"
                        />
                    </div>

                    {{-- Filters --}}
                    <div class="flex gap-3">
                        <flux:select 
                            wire:model.live="filterStatus" 
                            class="w-40"
                        >
                            <flux:select.option value="">{{ __('common.all_statuses') }}</flux:select.option>
                            <flux:select.option value="pending">{{ __('common.pending') }}</flux:select.option>
                            <flux:select.option value="completed">{{ __('common.completed') }}</flux:select.option>
                            <flux:select.option value="cancelled">{{ __('common.cancelled') }}</flux:select.option>
                        </flux:select>

                        <flux:select 
                            wire:model.live="filterPaymentStatus" 
                            class="w-40"
                        >
                            <flux:select.option value="">{{ __('common.all_payment_statuses') }}</flux:select.option>
                            <flux:select.option value="paid">{{ __('common.paid') }}</flux:select.option>
                            <flux:select.option value="partial">{{ __('common.partial') }}</flux:select.option>
                            <flux:select.option value="unpaid">{{ __('common.unpaid') }}</flux:select.option>
                        </flux:select>

                        <flux:select 
                            wire:model.live="filterClient" 
                            class="w-48"
                        >
                            <flux:select.option value="">{{ __('common.all_clients') }}</flux:select.option>
                            @foreach($clients as $client)
                                <flux:select.option value="{{ $client->id }}">{{ $client->name }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-zinc-200 dark:divide-zinc-800">
                    <thead class="bg-zinc-50/50 dark:bg-zinc-900/50">
                        <tr>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">
                                {{ __('common.invoice_number') }}
                            </th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">
                                {{ __('common.client') }}
                            </th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">
                                {{ __('common.total') }}
                            </th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">
                                {{ __('common.status') }}
                            </th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">
                                {{ __('common.payment_status') }}
                            </th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">
                                {{ __('common.date') }}
                            </th>
                            <th class="px-6 py-3.5 text-right text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">
                                {{ __('common.actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-zinc-900 divide-y divide-zinc-200 dark:border-zinc-800">
                        @forelse($sales as $sale)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                    {{ $sale->invoice_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-400">
                                    {{ $sale->client->name ?? __('common.general_public') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                    ${{ number_format($sale->total, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <flux:badge 
                                        size="sm"
                                        :color="$sale->status === 'completed' ? 'green' : ($sale->status === 'pending' ? 'yellow' : 'red')"
                                    >
                                        {{ __('common.' . $sale->status) }}
                                    </flux:badge>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <flux:badge 
                                        size="sm"
                                        :color="$sale->payment_status === 'paid' ? 'green' : ($sale->payment_status === 'partial' ? 'yellow' : 'red')"
                                    >
                                        {{ __('common.' . $sale->payment_status) }}
                                    </flux:badge>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-400">
                                    {{ $sale->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-3">
                                        <button wire:click="edit({{ $sale->id }})" 
                                                class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium transition-colors">
                                            {{ __('common.edit') }}
                                        </button>
                                        <button wire:click="destroy({{ $sale->id }})" 
                                                wire:confirm="{{ __('common.confirm_delete') }}"
                                                class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium transition-colors">
                                            {{ __('common.delete') }}
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-zinc-400 dark:text-zinc-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                        </svg>
                                        <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ __('common.no_sales_found') }}</p>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">{{ __('common.get_started_by_creating_new_sale') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($sales->hasPages())
                <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-800">
                    {{ $sales->links() }}
                </div>
            @endif
        </div>
    @endif
</div>
