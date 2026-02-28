<div class="w-full max-w-9xl mx-auto">
    @if($showForm)
        @include('livewire.supplier-payments.form')
    @else
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <flux:heading size="xl" level="1" class="text-zinc-900 dark:text-white font-bold tracking-tight">
                    {{ __('common.supplier_payments') }}
                </flux:heading>
                <flux:subheading size="lg" class="text-zinc-500 dark:text-zinc-400 mt-1">
                    {{ __('common.manage_supplier_payments') }}
                </flux:subheading>
            </div>

            <button wire:click="create"
               class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-500 active:bg-blue-700 rounded-lg shadow-sm transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 dark:focus:ring-offset-zinc-900 cursor-pointer">
                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('common.new_payment') }}
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
                            wire:model.live="filterSupplier" 
                            class="w-48"
                        >
                            <flux:select.option value="">{{ __('common.all_suppliers') }}</flux:select.option>
                            @foreach($suppliers as $supplier)
                                <flux:select.option value="{{ $supplier->id }}">{{ $supplier->name }}</flux:select.option>
                            @endforeach
                        </flux:select>

                        <flux:select 
                            wire:model.live="filterPaymentMethod" 
                            class="w-40"
                        >
                            <flux:select.option value="">{{ __('common.all_methods') }}</flux:select.option>
                            <flux:select.option value="cash">{{ __('common.cash') }}</flux:select.option>
                            <flux:select.option value="transfer">{{ __('common.transfer') }}</flux:select.option>
                            <flux:select.option value="check">{{ __('common.check') }}</flux:select.option>
                            <flux:select.option value="card">{{ __('common.card') }}</flux:select.option>
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
                                {{ __('common.date') }}
                            </th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">
                                {{ __('common.supplier') }}
                            </th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">
                                {{ __('common.purchase') }}
                            </th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">
                                {{ __('common.amount') }}
                            </th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">
                                {{ __('common.method') }}
                            </th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">
                                {{ __('common.reference') }}
                            </th>
                            <th class="px-6 py-3.5 text-right text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">
                                {{ __('common.actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-zinc-900 divide-y divide-zinc-200 dark:border-zinc-800">
                        @forelse($payments as $payment)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-zinc-100">
                                    {{ $payment->payment_date->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                    {{ $payment->supplier->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-400">
                                    {{ $payment->purchase ? $payment->purchase->invoice_number : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600 dark:text-green-400">
                                    ${{ number_format($payment->amount, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-400">
                                    {{ __('common.' . $payment->payment_method) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-400">
                                    {{ $payment->reference ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="relative inline-block text-left">
                                        <flux:dropdown align="end">
                                            <flux:button variant="ghost" size="sm" class="-my-2 cursor-pointer">
                                                <flux:icon icon="ellipsis-horizontal" />
                                            </flux:button>
                                            
                                            <flux:menu>
                                                {{-- Edit --}}
                                                <flux:menu.item icon="pencil" wire:click="edit({{ $payment->id }})">
                                                    {{ __('common.edit') }}
                                                </flux:menu.item>
                                                
                                                {{-- View --}}
                                                <flux:menu.item icon="eye" wire:click="view({{ $payment->id }})">
                                                    {{ __('common.view') }}
                                                </flux:menu.item>
                                                
                                                <flux:menu.separator />
                                                
                                                {{-- Delete --}}
                                                <flux:menu.item 
                                                    icon="trash" 
                                                    wire:click="destroy({{ $payment->id }})"
                                                    wire:confirm="{{ __('common.confirm_delete') }}"
                                                    variant="danger">
                                                    {{ __('common.delete') }}
                                                </flux:menu.item>
                                            </flux:menu>
                                        </flux:dropdown>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-zinc-400 dark:text-zinc-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ __('common.no_payments_found') }}</p>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">{{ __('common.get_started_by_creating_new_payment') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($payments->hasPages())
                <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-800">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>
    @endif
</div>
