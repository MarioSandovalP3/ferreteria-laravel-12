<div class="w-full max-w-9xl mx-auto">
    @if($showForm)
        @include('livewire.purchases.form', ['exchangeRate' => $exchangeRate])
    @else
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <flux:heading size="xl" level="1" class="text-zinc-900 dark:text-white font-bold tracking-tight">
                    {{ __('common.purchases') }}
                </flux:heading>
                <flux:subheading size="lg" class="text-zinc-500 dark:text-zinc-400 mt-1">
                    {{ __('common.manage_product_purchases') }}
                </flux:subheading>
            </div>

            <button wire:click="create"
               class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-500 active:bg-blue-700 rounded-lg shadow-sm transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 dark:focus:ring-offset-zinc-900 cursor-pointer">
                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('common.new_purchase') }}
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
                            placeholder="{{ __('common.search_purchases') }}"
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
                            wire:model.live="filterSupplier" 
                            class="w-48"
                        >
                            <flux:select.option value="">{{ __('common.all_suppliers') }}</flux:select.option>
                            @foreach($suppliers as $supplier)
                                <flux:select.option value="{{ $supplier->id }}">{{ $supplier->name }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        
                        {{-- Trash Filter --}}
                        <flux:select 
                            wire:model.live="filterTrashed" 
                            class="w-32"
                        >
                            <flux:select.option value="">{{ __('common.active') }}</flux:select.option>
                            <flux:select.option value="only">{{ __('common.trash') }}</flux:select.option>
                            <flux:select.option value="with">{{ __('common.all_including_trash') }}</flux:select.option>
                        </flux:select>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                            <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider">{{ __('common.purchase_number') }}</th>
                            <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider">{{ __('common.invoice') }}</th>
                            <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider">{{ __('common.supplier') }}</th>
                            <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider">{{ __('common.date') }}</th>
                            <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider">{{ __('common.total') }}</th>
                            <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider">{{ __('common.status') }}</th>
                            <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider">{{ __('common.payment_status') }}</th>
                            <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider">{{ __('common.items') }}</th>
                            <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider text-right">{{ __('common.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse ($purchases as $purchase)
                        <tr class="group hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors duration-150 ease-in-out {{ $purchase->trashed() ? 'opacity-60' : '' }}">
                            <td class="py-4 px-6">
                                <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $purchase->purchase_number }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-2">
                                    <span class="font-medium text-zinc-900 dark:text-zinc-100 {{ $purchase->trashed() ? 'line-through' : '' }}">{{ $purchase->invoice_number }}</span>
                                    @if($purchase->trashed())
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                            {{ __('common.deleted') }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-zinc-700 dark:text-zinc-300">{{ $purchase->supplier->name }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-zinc-600 dark:text-zinc-400">{{ $purchase->purchase_date->format('d/m/Y') }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="font-semibold text-zinc-900 dark:text-zinc-100">${{ number_format($purchase->total, 2) }}</span>
                            </td>
                            <td class="py-4 px-6">
                                @if($purchase->status === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        {{ __('common.completed') }}
                                    </span>
                                @elseif($purchase->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                        {{ __('common.pending') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                        {{ __('common.cancelled') }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                @if($purchase->payment_status === 'paid')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        {{ __('common.paid') }}
                                    </span>
                                @elseif($purchase->payment_status === 'partial')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                        {{ __('common.partial') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400">
                                        {{ __('common.pending') }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-zinc-600 dark:text-zinc-400">{{ $purchase->items->count() }} {{ __('common.products') }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center justify-end gap-2">
                                    <flux:dropdown align="end">
                                        <flux:button variant="ghost" size="sm" class="-my-2 cursor-pointer">
                                            <flux:icon icon="ellipsis-horizontal" />
                                        </flux:button>
                                        
                                        <flux:menu>
                                            @if($purchase->trashed())
                                                {{-- Restore button for deleted purchases --}}
                                                <flux:menu.item 
                                                    icon="arrow-path" 
                                                    wire:click="restore({{ $purchase->id }})"
                                                    class="cursor-pointer">{{ __('common.restore_purchase') }}</flux:menu.item>
                                                
                                                {{-- Permanently delete button --}}
                                                <flux:menu.item 
                                                    icon="trash" 
                                                    variant="danger" 
                                                    wire:click="openForceDeleteModal({{ $purchase->id }})"
                                                    class="cursor-pointer">{{ __('common.permanently_delete') }}</flux:menu.item>
                                            @else
                                                {{-- View and Edit buttons --}}
                                                <flux:menu.item 
                                                    icon="eye" 
                                                    wire:click="view({{ $purchase->id }})" 
                                                    class="cursor-pointer">
                                                    {{ __('common.view') }}
                                                </flux:menu.item>
                                                
                                                <flux:menu.item 
                                                    icon="pencil-square" 
                                                    wire:click="edit({{ $purchase->id }})" 
                                                    class="cursor-pointer">
                                                    {{ __('common.edit') }}
                                                </flux:menu.item>
                                                
                                                {{-- Cancel purchase option (only for pending purchases) --}}
                                                @if(!in_array($purchase->status, ['completed', 'cancelled']))
                                                    <flux:menu.item 
                                                        icon="x-circle" 
                                                        variant="danger"
                                                        wire:click="openCancelModal({{ $purchase->id }})"
                                                        class="cursor-pointer">{{ __('common.cancel_purchase') }}</flux:menu.item>
                                                @endif
                                                
                                                <flux:menu.item 
                                                    icon="trash" 
                                                    variant="danger" 
                                                    wire:click="openDeleteModal({{ $purchase->id }})"
                                                    class="cursor-pointer">{{ __('common.delete') }}</flux:menu.item>
                                            @endif
                                        </flux:menu>
                                    </flux:dropdown>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-zinc-300 dark:text-zinc-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                    <p class="text-zinc-500 dark:text-zinc-400 text-lg font-medium">{{ __('common.no_purchases_found') }}</p>
                                    <p class="text-zinc-400 dark:text-zinc-500 text-sm mt-1">{{ __('common.create_your_first_purchase') }}</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($purchases->hasPages())
                <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-800">
                    {{ $purchases->links() }}
                </div>
            @endif
        </div>

        {{-- Delete Confirmation Modal --}}
        @if($showDeleteModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            {{-- Modal --}}
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            {{-- Icon --}}
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                            </div>

                            {{-- Content --}}
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-white" id="modal-title">
                                    {{ __('common.delete_purchase') }}
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ __('common.delete_purchase_message') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-3">
                        <button type="button" 
                                wire:click="confirmDelete"
                                class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2.5 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            {{ __('common.delete') }}
                        </button>
                        <button type="button" 
                                wire:click="closeDeleteModal"
                                class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2.5 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm transition-colors">
                            {{ __('common.cancel') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Cancel Purchase Confirmation Modal --}}
        @if($showCancelModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            {{-- Modal --}}
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            {{-- Icon --}}
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                            </div>

                            {{-- Content --}}
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-white" id="modal-title">
                                    {{ __('common.cancel_purchase') }}
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ __('common.cancel_purchase_message') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-3">
                        <button type="button" 
                                wire:click="confirmCancel"
                                class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2.5 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            {{ __('common.yes_cancel') }}
                        </button>
                        <button type="button" 
                                wire:click="$set('showCancelModal', false)"
                                class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2.5 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm transition-colors">
                            {{ __('common.no_keep') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Permanent Delete Confirmation Modal --}}
        @if($showForceDeleteModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            {{-- Modal --}}
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            {{-- Icon --}}
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                            </div>

                            {{-- Content --}}
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-white" id="modal-title">
                                    {{ __('common.permanently_delete_purchase') }}
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ __('common.permanently_delete_purchase_message') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-3">
                        <button type="button" 
                                wire:click="confirmForceDelete"
                                class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2.5 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            {{ __('common.permanently_delete') }}
                        </button>
                        <button type="button" 
                                wire:click="closeForceDeleteModal"
                                class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2.5 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm transition-colors">
                            {{ __('common.cancel') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endif
</div>
