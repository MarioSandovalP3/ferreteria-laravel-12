{{-- Exchange Rate Form --}}
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-800">
        <form wire:submit="save">
            {{-- Header --}}
            <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">
                            {{ $editMode ? __('common.edit_exchange_rate') : __('common.new_exchange_rate') }}
                        </h2>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                            {{ $editMode ? __('common.update_rate_information') : __('common.register_new_dollar_rate') }}
                        </p>
                    </div>
                    <flux:button wire:click="cancel" variant="ghost" icon="x-mark">
                        {{ __('common.close') }}
                    </flux:button>
                </div>
            </div>

            <div class="p-6 space-y-6">
                {{-- Main Information --}}
                <div>
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-4">
                        {{ __('common.rate_information') }}
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Country (Read-only from Store) --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.country') }}
                            </label>
                            @php
                                $store = \App\Models\Store::first();
                                $storeCountry = $store?->regionalSettings?->country;
                            @endphp
                            @if($storeCountry)
                                <div class="flex items-center gap-3 px-4 py-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                                        <span class="text-xl">{!! $storeCountry->currency_symbol !!}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $storeCountry->name_es }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $storeCountry->currency }} ({{ $storeCountry->currency_symbol }})
                                        </p>
                                    </div>
                                </div>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    {{ __('common.country_configured_in_store') }}
                                </p>
                            @else
                                <div class="px-4 py-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                                    <p class="text-sm text-yellow-800 dark:text-yellow-300">
                                        {{ __('common.no_country_configured') }}
                                    </p>
                                </div>
                            @endif
                        </div>

                        {{-- Effective Date --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.effective_date') }} <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="date" 
                                wire:model="effective_date"
                                max="{{ now()->format('Y-m-d') }}"
                                class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                required>
                            @error('effective_date')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                {{ __('common.date_when_rate_becomes_effective') }}
                            </p>
                        </div>

                        {{-- Rate --}}
                        <div class="md:col-span-2" x-data="moneyInput({{ $rate ?? 0 }}, '', 0)">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.exchange_rate_1_usd') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    x-model="formatted"
                                    @input="updateValue($event)"
                                    @click="forceEnd($el)"
                                    @keydown.arrow-left.prevent
                                    @keydown.arrow-right.prevent
                                    data-field="rate"
                                    inputmode="numeric"
                                    placeholder="{{ __('common.example_rate') }}"
                                    class="w-full px-4 py-2.5 pr-20 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 text-lg font-semibold"
                                    required>
                                @if($rate && $storeCountry)
                                    <div class="absolute right-3 top-1/2 -translate-y-1/2 text-lg font-medium text-gray-500 dark:text-gray-400">
                                        {!! $storeCountry->currency_symbol !!}
                                    </div>
                                @endif
                            </div>
                            @error('rate')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            
                            {{-- Conversion Preview --}}
                            @if($rate && $storeCountry)
                                <div class="mt-3 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                                    <div class="flex items-center justify-between text-sm">
                                        <div>
                                            <p class="text-gray-600 dark:text-gray-400">{{ __('common.conversion_example') }}</p>
                                            <p class="text-lg font-bold text-blue-600 dark:text-blue-400 mt-1">
                                                $100 USD = {!! $storeCountry->currency_symbol !!}{{ number_format($rate * 100, 2) }}
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-gray-600 dark:text-gray-400">{{ __('common.rate') }}:</p>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white mt-1">
                                                1 USD = {!! $storeCountry->currency_symbol !!}{{ number_format($rate, 2) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Notes --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.notes') }}
                            </label>
                            <textarea 
                                wire:model="notes"
                                rows="3"
                                placeholder="{{ __('common.additional_notes_about_rate') }}"
                                class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 resize-none"></textarea>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                {{ __('common.additional_information_or_context') }}
                            </p>
                        </div>

                        {{-- Is Active --}}
                        <div class="flex items-center">
                            <div class="flex items-center h-full">
                                <label class="flex items-center cursor-pointer">
                                    <input 
                                        type="checkbox" 
                                        wire:model="is_active"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('common.active_rate') }}
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="px-6 py-4 bg-gray-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-800 flex justify-end gap-3">
                <flux:button type="button" wire:click="cancel" variant="ghost">
                    {{ __('common.cancel') }}
                </flux:button>
                <flux:button type="submit" variant="primary">
                    {{ $editMode ? __('common.update_rate') : __('common.register_rate') }}
                </flux:button>
            </div>
        </form>
    </div>
</div>
