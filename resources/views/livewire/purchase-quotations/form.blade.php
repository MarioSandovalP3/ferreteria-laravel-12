{{-- Purchase Quotation Form --}}
<div class="max-w-6xl mx-auto">
    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-800">
        {{-- Hidden field to persist confirmingOrder state --}}
        <input type="hidden" wire:model="confirmingOrder">
        
            {{-- Header --}}
            <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">
                            @if($viewMode)
                                {{ __('common.view_rfq') }}
                                @if($rfqNumber)
                                    <span class="text-blue-600 dark:text-blue-400">{{ $rfqNumber }}</span>
                                @endif
                            @elseif($editMode)
                                {{ __('common.edit_rfq') }}
                                @if($rfqNumber)
                                    <span class="text-blue-600 dark:text-blue-400">{{ $rfqNumber }}</span>
                                @endif
                            @else
                                {{ __('common.new_rfq') }}
                            @endif
                        </h2>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                            {{ __('common.rfq_form_description') }}
                        </p>
                    </div>
                    
                    <flux:button wire:click="cancel" variant="ghost" icon="x-mark" class="border border-gray-500 dark:border-gray-800">
                        {{ __('common.close') }}
                    </flux:button>
                </div>

                {{-- Action Buttons (Show when editing or viewing existing quotation) --}}
                @if($selected_id && !$confirmingOrder && !$viewMode)
                    @php
                        $quotation = \App\Models\PurchaseQuotation::withTrashed()->find($selected_id);
                        $isDeleted = $quotation && $quotation->trashed();
                    @endphp
                    
                    
                    @if(!$isDeleted)
                        <div class="flex gap-3 flex-wrap">
                            {{-- Draft Actions --}}
                            @if($status === 'draft')
                                <button wire:click="markAsReceived({{ $selected_id }})" 
                                        class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ __('common.quotation_received') }}
                                </button>
                                <button wire:click="openEmailModal({{ $selected_id }})" 
                                        class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-500 rounded-lg shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    {{ __('common.send_email') }}
                                </button>
                                <button wire:click="downloadPDF({{ $selected_id }})" 
                                        class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-lg shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                                    </svg>
                                    {{ __('common.print_pdf') }}
                                </button>
                            @endif

                            {{-- Sent Actions --}}
                            @if($status === 'sent')
                                <button wire:click="markAsReceived({{ $selected_id }})" 
                                        class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ __('common.quotation_received') }}
                                </button>
                                <button wire:click="downloadPDF({{ $selected_id }})" 
                                        class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-lg shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                                    </svg>
                                    {{ __('common.print_pdf') }}
                                </button>
                            @endif

                            {{-- Received Actions --}}
                            @if($status === 'received')
                                <button wire:click="approve({{ $selected_id }})" 
                                        class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    {{ __('common.approve_quotation') }}
                                </button>
                                <button wire:click="openEmailModal({{ $selected_id }})" 
                                        class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-500 rounded-lg shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    {{ __('common.send_email') }}
                                </button>
                                <button wire:click="downloadPDF({{ $selected_id }})" 
                                        class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-lg shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                                    </svg>
                                    {{ __('common.print_pdf') }}
                                </button>
                            @endif


                            {{-- Approved Actions --}}
                            @if($status === 'approved')
                                <button wire:click="convertToPurchase({{ $selected_id }})" 
                                        class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    {{ __('common.convert_to_purchase') }}
                                </button>
                                <button wire:click="downloadPDF({{ $selected_id }})" 
                                        class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-lg shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                                    </svg>
                                    {{ __('common.print_pdf') }}
                                </button>
                            @endif

                            {{-- Converted/Cancelled Actions --}}
                            @if(in_array($status, ['converted', 'cancelled']))
                                <button wire:click="downloadPDF({{ $selected_id }})" 
                                        class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-lg shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                                    </svg>
                                    {{ __('common.print_pdf') }}
                                </button>
                            @endif
                        </div>
                    @endif
                @endif
            </div>



            {{-- Deleted Quotation Warning --}}
            @if($viewMode && $selected_id)
                @php
                    $quotation = \App\Models\PurchaseQuotation::withTrashed()->find($selected_id);
                @endphp
                @if($quotation && $quotation->trashed())
                    <div class="mx-6 mt-4 p-4 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 dark:border-red-700 rounded-r-lg">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-start gap-3 flex-1">
                                <svg class="w-6 h-6 text-red-600 dark:text-red-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <div class="flex-1">
                                    <h4 class="text-sm font-semibold text-red-800 dark:text-red-200">
                                        {{ __('common.deleted_quotation_warning') }}
                                    </h4>
                                    <p class="text-sm text-red-700 dark:text-red-300 mt-1">
                                        {{ __('common.deleted_quotation_message') }}
                                    </p>
                                </div>
                            </div>
                            <button wire:click="restore({{ $selected_id }})"
                                    class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-600 rounded-lg transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                {{ __('common.restore') }}
                            </button>
                        </div>
                    </div>
                @endif
            @endif

            {{-- Helper message for Sent status --}}
            @if($viewMode && $status === 'sent')
                <div class="mx-6 mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-blue-800 dark:text-blue-200">{{ __('common.enter_quoted_prices') }}</p>
                            <p class="text-xs text-blue-700 dark:text-blue-300 mt-1">Haga click en "Cotización Recibida" para habilitar los campos de precios e impuestos.</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="p-6 space-y-6">
                {{-- Basic Information --}}
                <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-4">
                    {{ __('common.basic_information') }}
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Supplier --}}
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('common.supplier') }} <span class="text-red-500">*</span>
                        </label>
                        
                        <div class="relative">
                            <input type="text" 
                                   wire:model.live="supplierSearch"
                                   wire:focus="$set('showSupplierDropdown', true)"
                                   placeholder="{{ __('common.search_supplier') }}"
                                   class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('supplier_id') border-red-500 @enderror"
                                   @if($viewMode) disabled @endif
                                   autocomplete="off">
                            
                            @if($supplier_id && $selectedSupplierName)
                                <button type="button" 
                                        wire:click="clearSupplier"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                        @if($viewMode) disabled @endif>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            @endif
                        </div>

                        {{-- Dropdown Results --}}
                        @if($showSupplierDropdown && !$viewMode)
                            <div class="absolute z-50 w-full mt-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                @forelse($this->filteredSuppliers as $supplier)
                                    <button type="button"
                                            wire:click="selectSupplier({{ $supplier->id }}, '{{ $supplier->name }}')"
                                            class="w-full px-4 py-2.5 text-left hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 last:border-0">
                                        <div class="font-medium">{{ $supplier->name }}</div>
                                        @if($supplier->email)
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $supplier->email }}</div>
                                        @endif
                                    </button>
                                @empty
                                    <div class="px-4 py-3 text-gray-500 dark:text-gray-400 text-sm">
                                        {{ __('common.no_suppliers_found') }}
                                    </div>
                                @endforelse
                            </div>
                        @endif

                        @error('supplier_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Request Date --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('common.request_date') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               wire:model="request_date" 
                               class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('request_date') border-red-500 @enderror"
                               @if($viewMode) disabled @endif
                               required>
                        @error('request_date')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Expected Date --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('common.expected_date') }}
                        </label>
                        <input type="date" 
                               wire:model="expected_date" 
                               class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                               @if($viewMode) disabled @endif>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ __('common.expected_date_help') }}</p>
                        @error('expected_date')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status Badge --}}
                    @if($selected_id)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.status') }}
                            </label>
                            @php
                                $statusConfig = [
                                    'draft' => [
                                        'bg' => 'bg-gray-50 dark:bg-gray-800/50',
                                        'border' => 'border-gray-300 dark:border-gray-600',
                                        'text' => 'text-gray-700 dark:text-gray-300',
                                        'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'
                                    ],
                                    'sent' => [
                                        'bg' => 'bg-blue-50 dark:bg-blue-900/20',
                                        'border' => 'border-blue-300 dark:border-blue-700',
                                        'text' => 'text-blue-700 dark:text-blue-300',
                                        'icon' => 'M12 19l9 2-9-18-9 18 9-2zm0 0v-8'
                                    ],
                                    'received' => [
                                        'bg' => 'bg-yellow-50 dark:bg-yellow-900/20',
                                        'border' => 'border-yellow-300 dark:border-yellow-700',
                                        'text' => 'text-yellow-700 dark:text-yellow-300',
                                        'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
                                    ],
                                    'approved' => [
                                        'bg' => 'bg-green-50 dark:bg-green-900/20',
                                        'border' => 'border-green-300 dark:border-green-700',
                                        'text' => 'text-green-700 dark:text-green-300',
                                        'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z'
                                    ],
                                    'converted' => [
                                        'bg' => 'bg-purple-50 dark:bg-purple-900/20',
                                        'border' => 'border-purple-300 dark:border-purple-700',
                                        'text' => 'text-purple-700 dark:text-purple-300',
                                        'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z'
                                    ],
                                    'cancelled' => [
                                        'bg' => 'bg-red-50 dark:bg-red-900/20',
                                        'border' => 'border-red-300 dark:border-red-700',
                                        'text' => 'text-red-700 dark:text-red-300',
                                        'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'
                                    ],
                                ];
                                $config = $statusConfig[$status] ?? $statusConfig['draft'];
                            @endphp
                            <div class="inline-flex items-center gap-2 px-3 py-2 {{ $config['bg'] }} {{ $config['text'] }} border {{ $config['border'] }} rounded-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}"/>
                                </svg>
                                <span class="text-sm font-semibold uppercase tracking-wide">{{ __('common.' . $status) }}</span>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Products Section --}}
                <div class="mt-8">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-zinc-900 dark:text-white">
                            {{ __('common.products') }}
                        </h3>
                        @if(!$viewMode)
                            <button type="button" wire:click="addItem"
                                    class="px-3 py-1.5 text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 bg-gray-100 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-200 dark:hover:bg-gray-700">
                                + {{ __('common.add_product') }}
                            </button>
                        @endif
                    </div>

                    @if($errors->has('items') || $errors->has('items.0.product_id'))
                        <div class="mb-3 p-3 bg-red-50 dark:bg-red-900/20 rounded-lg">
                            <p class="text-sm font-medium text-red-600 dark:text-red-400">
                                {{ $errors->first('items') ?: __('common.at_least_one_product_is_required') }}
                            </p>
                        </div>
                    @endif

                    <div class="space-y-4">
                        @foreach($items as $index => $item)
                            <div class="p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <div class="grid grid-cols-12 gap-4">
                                    {{-- Product --}}
                                    <div class="col-span-12 md:col-span-4">
                                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            {{ __('common.product') }} *
                                        </label>
                                        @if($viewMode)
                                            <input type="text" value="{{ $productNames[$index] ?? '' }}" disabled
                                                   class="w-full px-3 py-2 text-sm bg-gray-100 dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white">
                                        @else
                                            <div class="relative" x-data="{ open: false }">
                                                <input type="text" 
                                                       wire:model.live="productSearches.{{ $index }}"
                                                       @click="open = true"
                                                       @click.away="open = false"
                                                       placeholder="{{ __('common.search_product') }}"
                                                       class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                                
                                                {{-- Clear Button --}}
                                                @if(isset($items[$index]['product_id']) && $items[$index]['product_id'])
                                                    <button type="button"
                                                            wire:click="clearProduct({{ $index }})"
                                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                @endif

                                                {{-- Dropdown --}}
                                                <div x-show="open"
                                                     x-transition
                                                     class="absolute z-50 w-full mt-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg max-h-60 overflow-auto">
                                                    @php
                                                        $filteredProducts = $this->getFilteredProductsForItem($index);
                                                    @endphp
                                                    @if($filteredProducts->count() > 0)
                                                        @foreach($filteredProducts as $product)
                                                            <button type="button"
                                                                    wire:click="selectProduct({{ $index }}, {{ $product->id }}, '{{ $product->name }}', {{ $product->cost ?? 0 }})"
                                                                    @click="open = false"
                                                                    class="w-full px-4 py-2 text-left text-sm hover:bg-gray-100 dark:hover:bg-gray-700">
                                                                <span>{{ $product->name }}</span>
                                                            </button>
                                                        @endforeach
                                                    @else
                                                        <div class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
                                                            {{ __('common.no_products_found') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Quantity --}}
                                    <div class="col-span-6 md:col-span-2">
                                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            {{ __('common.quantity') }} *
                                        </label>
                                        <input type="number" 
                                               wire:model="items.{{ $index }}.quantity"
                                               min="1"
                                               step="1"
                                               inputmode="numeric"
                                               pattern="[0-9]*"
                                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                               @if($viewMode || empty($item['product_id'])) disabled @endif
                                               class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 @if(empty($item['product_id'])) opacity-50 cursor-not-allowed @endif">
                                    </div>

                                    {{-- Requested Price --}}
                                    <div class="col-span-6 md:col-span-2" x-data="{
                                        formatted: '{{ number_format($item["requested_price"] ?? 0, 2, '.', ',') }}',
                                        format(value) {
                                            let num = value.replace(/[^0-9.]/g, '');
                                            let parts = num.split('.');
                                            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                                            if (parts.length > 1) {
                                                parts[1] = parts[1].substring(0, 2);
                                                return parts.join('.');
                                            }
                                            return parts[0];
                                        },
                                        updateValue(event) {
                                            this.formatted = this.format(event.target.value);
                                            let numValue = this.formatted.replace(/,/g, '');
                                            $wire.set('items.{{ $index }}.requested_price', numValue || '0');
                                        }
                                    }">
                                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            {{ __('common.requested_price') }}
                                        </label>
                                        <input type="text" 
                                               x-model="formatted"
                                               @input="updateValue($event)"
                                               placeholder="0.00"
                                               inputmode="decimal"
                                               @if($viewMode || empty($item['product_id'])) disabled @endif
                                               class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 @if(empty($item['product_id'])) opacity-50 cursor-not-allowed @endif">
                                    </div>

                                    {{-- Quoted Price --}}
                                    <div class="col-span-6 md:col-span-2" x-data="{
                                        formatted: '{{ number_format($item["quoted_price"] ?? 0, 2, '.', ',') }}',
                                        format(value) {
                                            let num = value.replace(/[^0-9.]/g, '');
                                            let parts = num.split('.');
                                            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                                            if (parts.length > 1) {
                                                parts[1] = parts[1].substring(0, 2);
                                                return parts.join('.');
                                            }
                                            return parts[0];
                                        },
                                        updateValue(event) {
                                            this.formatted = this.format(event.target.value);
                                            let numValue = this.formatted.replace(/,/g, '');
                                            $wire.set('items.{{ $index }}.quoted_price', numValue || '0');
                                        }
                                    }">
                                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            {{ __('common.quoted_price') }}
                                            @if($status === 'approved')
                                                <span class="text-red-500">*</span>
                                            @endif
                                        </label>
                                        <input type="text" 
                                               x-model="formatted"
                                               @input="updateValue($event)"
                                               placeholder="0.00"
                                               inputmode="decimal"
                                               @if($viewMode || $status !== 'approved') disabled @endif
                                               class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                        @error('items.'.$index.'.quoted_price')
                                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Tax Rate (IVA) --}}
                                    <div class="col-span-6 md:col-span-1" x-data="{
                                        formatted: '{{ number_format($item["tax_rate"] ?? 0, 2, '.', ',') }}',
                                        updateValue(event) {
                                            let value = event.target.value.replace(/[^0-9.]/g, '');
                                            let numValue = parseFloat(value) || 0;
                                            if (numValue > 100) {
                                                numValue = 100;
                                                this.formatted = numValue.toFixed(2);
                                            } else {
                                                this.formatted = value;
                                            }
                                            $wire.set('items.{{ $index }}.tax_rate', numValue);
                                        },
                                        formatOnBlur(event) {
                                            let numValue = parseFloat(event.target.value) || 0;
                                            if (numValue > 100) numValue = 100;
                                            this.formatted = numValue.toFixed(2);
                                            $wire.set('items.{{ $index }}.tax_rate', numValue);
                                        }
                                    }">
                                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Tax %
                                        </label>
                                        <input type="text" 
                                               x-model="formatted"
                                               @input="updateValue($event)"
                                               @blur="formatOnBlur($event)"
                                               placeholder="0.00"
                                               inputmode="decimal"
                                               @if($viewMode || $status !== 'approved') disabled @endif
                                               class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                    </div>

                                    {{-- Actions --}}
                                    <div class="col-span-6 md:col-span-1 flex items-end">
                                        @if((!$viewMode || $confirmingOrder) && count($items) > 1)
                                            <button type="button" wire:click="removeItem({{ $index }})"
                                                    class="p-2 text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Notes --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('common.notes') }}
                        </label>
                        <textarea wire:model="notes" 
                                  rows="3"
                                  @if($viewMode) disabled @endif
                                  placeholder="{{ __('common.notes_visible_to_supplier') }}"
                                  class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('common.internal_notes') }}
                        </label>
                        <textarea wire:model="internal_notes" 
                                  rows="3"
                                  @if($viewMode) disabled @endif
                                  placeholder="{{ __('common.internal_notes_not_visible') }}"
                                  class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                </div>
            </div>

            {{-- Confirming Order Message --}}
            @if($confirmingOrder)
                <div class="mx-6 mb-4 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-blue-800 dark:text-blue-200">{{ __('common.confirm_order') }}</p>
                            <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">{{ __('common.confirming_order_message') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Footer --}}
            <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-800 flex justify-end gap-3">
                <button type="button" wire:click="cancel"
                        class="px-4 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-500 rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                    {{ $viewMode ? __('common.close') : __('common.cancel') }}
                </button>
                @if(!$viewMode)
                    {{-- Normal mode: Show both Save and Save & Exit buttons --}}
                    {{-- Save button (stays in form) --}}
                    <button type="button" wire:click="{{ $editMode ? 'update' : 'store' }}"
                            class="px-4 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 border-2 border-blue-600 dark:border-blue-500 hover:border-blue-700 dark:hover:border-blue-400 rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        {{ $editMode ? __('common.update') : __('common.save') }}
                    </button>
                    
                    {{-- Save & Exit button (closes form) --}}
                    <button type="button" wire:click="{{ $editMode ? 'updateAndExit' : 'storeAndExit' }}"
                            class="px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        {{ $editMode ? __('common.update_and_exit') : __('common.save_and_exit') }}
                    </button>
                @endif
            </div>
    </div>

    {{-- Email Modal --}}
    @if($showEmailModal)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                {{-- Background overlay --}}
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" wire:click="closeEmailModal"></div>

                {{-- Modal panel --}}
                <div class="inline-block w-full max-w-2xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-zinc-900 shadow-xl rounded-2xl relative z-50">
                    {{-- Header --}}
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-semibold text-zinc-900 dark:text-white">
                            {{ __('common.send_quotation_email') }}
                        </h3>
                        <button wire:click="closeEmailModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Error/Success Messages --}}
                    @if (session()->has('error'))
                        <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-sm text-red-800 dark:text-red-200">{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif

                    @if (session()->has('message'))
                        <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-sm text-green-800 dark:text-green-200">{{ session('message') }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Form --}}
                    <div class="space-y-4">
                        {{-- Recipient --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.recipient') }}
                            </label>
                            <input type="email" 
                                   wire:model="emailRecipient" 
                                   class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                   readonly>
                        </div>

                        {{-- Subject --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.subject') }}
                            </label>
                            <input type="text" 
                                   wire:model="emailSubject" 
                                   class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        </div>

                        {{-- Message --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.message') }}
                            </label>
                            <textarea wire:model="emailMessage" 
                                      rows="6"
                                      class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>

                        {{-- PDF Attachment Info --}}
                        <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-blue-900 dark:text-blue-100">
                                        {{ __('common.pdf_will_be_attached') }}
                                    </p>
                                    <p class="text-xs text-blue-700 dark:text-blue-300 mt-1">
                                        {{ __('common.quotation_pdf_description') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="flex justify-end gap-3 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <flux:button wire:click="closeEmailModal" variant="ghost">
                            {{ __('common.cancel') }}
                        </flux:button>
                        <flux:button wire:click="sendEmailWithPDF" variant="primary" icon="paper-airplane">
                            {{ __('common.send_email') }}
                        </flux:button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
