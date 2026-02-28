<div class="w-full max-w-9xl mx-auto">
    @if($showForm)
        @include('livewire.purchase-quotations.form')
    @else
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <flux:heading size="xl" level="1" class="text-zinc-900 dark:text-white font-bold tracking-tight">
                    {{ __('common.purchase_quotations') }}
                </flux:heading>
                <flux:subheading size="lg" class="text-zinc-500 dark:text-zinc-400 mt-1">
                    {{ __('common.manage_purchase_quotations') }}
                </flux:subheading>
            </div>

            <button wire:click="create"
               class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-500 active:bg-blue-700 rounded-lg shadow-sm transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 dark:focus:ring-offset-zinc-900 cursor-pointer">
                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('common.new_rfq') }}
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
                            placeholder="{{ __('common.search_rfq') }}"
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
                            <flux:select.option value="draft">{{ __('common.draft') }}</flux:select.option>
                            <flux:select.option value="sent">{{ __('common.sent') }}</flux:select.option>
                            <flux:select.option value="received">{{ __('common.received') }}</flux:select.option>
                            <flux:select.option value="approved">{{ __('common.approved') }}</flux:select.option>
                            <flux:select.option value="converted">{{ __('common.converted') }}</flux:select.option>
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

                        <flux:select 
                            wire:model.live="filterTrashed" 
                            class="w-40"
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
                <table class="w-full divide-y divide-zinc-200 dark:divide-zinc-800">
                    <thead class="bg-zinc-50/50 dark:bg-zinc-900/50">
                        <tr>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">
                                {{ __('common.rfq_number') }}
                            </th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">
                                {{ __('common.supplier') }}
                            </th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">
                                {{ __('common.request_date') }}
                            </th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">
                                {{ __('common.expected_date') }}
                            </th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">
                                {{ __('common.status') }}
                            </th>
                            <th class="px-6 py-3.5 text-right text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">
                                {{ __('common.actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-zinc-900 divide-y divide-zinc-200 dark:border-zinc-800">
                        @forelse($quotations as $quotation)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                    {{ $quotation->rfq_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-zinc-100">
                                    {{ $quotation->supplier->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-400">
                                    {{ $quotation->request_date->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-400">
                                    {{ $quotation->expected_date?->format('d/m/Y') ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $colors = [
                                            'draft' => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200',
                                            'sent' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                            'received' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                            'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                            'converted' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                            'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                        ];
                                    @endphp
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $colors[$quotation->status] ?? $colors['draft'] }}">
                                        {{ __('common.' . $quotation->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="relative inline-block text-left">
                                        <flux:dropdown align="end">
                                            <flux:button variant="ghost" size="sm" class="-my-2 cursor-pointer">
                                                <flux:icon icon="ellipsis-horizontal" />
                                            </flux:button>
                                            
                                            <flux:menu>
                                                {{-- View (always available) --}}
                                                <flux:menu.item icon="eye" wire:click="view({{ $quotation->id }})">
                                                    {{ __('common.view') }}
                                                </flux:menu.item>
                                                
                                                {{-- Edit and Cancel (only for non-deleted and non-converted) --}}
                                                @if(!$quotation->trashed())
                                                    {{-- Edit button (only if not converted) --}}
                                                    @if($quotation->status !== 'converted')
                                                        <flux:menu.item icon="pencil" wire:click="edit({{ $quotation->id }})">
                                                            {{ __('common.edit') }}
                                                        </flux:menu.item>
                                                    @endif

                                                    @if($quotation->status !== 'converted' && $quotation->status !== 'cancelled')
                                                        <flux:menu.item icon="x-circle" wire:click="openCancelModal({{ $quotation->id }})">
                                                            {{ __('common.cancel_quotation') }}
                                                        </flux:menu.item>
                                                    @endif

                                                    <flux:menu.separator />
                                                    <flux:menu.item 
                                                        icon="trash" 
                                                        wire:click="openDeleteModal({{ $quotation->id }})"
                                                        variant="danger">
                                                        {{ __('common.delete') }}
                                                    </flux:menu.item>
                                                @else
                                                    {{-- Restore (only for deleted) --}}
                                                    <flux:menu.separator />
                                                    <flux:menu.item 
                                                        icon="arrow-path" 
                                                        wire:click="restore({{ $quotation->id }})">
                                                        {{ __('common.restore') }}
                                                    </flux:menu.item>
                                                @endif
                                            </flux:menu>
                                        </flux:dropdown>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-zinc-400 dark:text-zinc-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ __('common.no_quotations_found') }}</p>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">{{ __('common.get_started_by_creating_new_rfq') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($quotations->hasPages())
                <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-800">
                    {{ $quotations->links() }}
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
                                    {{ __('common.delete_quotation') }}
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ __('common.delete_quotation_message') }}
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

        {{-- Cancel Confirmation Modal --}}
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
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-orange-100 dark:bg-orange-900 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-orange-600 dark:text-orange-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                            </div>

                            {{-- Content --}}
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-white" id="modal-title">
                                    {{ __('common.cancel_quotation') }}
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ __('common.cancel_quotation_message') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-3">
                        <button type="button" 
                                wire:click="confirmCancel"
                                class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2.5 bg-orange-600 text-base font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            {{ __('common.yes_cancel') }}
                        </button>
                        <button type="button" 
                                wire:click="closeCancelModal"
                                class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2.5 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm transition-colors">
                            {{ __('common.no_keep') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endif
</div>
