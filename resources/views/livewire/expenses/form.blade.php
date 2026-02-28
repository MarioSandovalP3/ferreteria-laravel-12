{{-- Expense Form --}}
<div class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-800">
        <form wire:submit.prevent="submitForm">
            {{-- Header --}}
            <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">
                            {{ $editMode ? __('common.edit_expense') : __('common.new_expense') }}
                        </h2>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                            {{ __('common.register_operational_expense') }}
                        </p>
                    </div>
                    <flux:button wire:click="cancel" variant="ghost" icon="x-mark">
                        {{ __('common.close') }}
                    </flux:button>
                </div>
            </div>

            <div class="p-6 space-y-6">
                {{-- Expense Information --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Category --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('common.category') }} <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="category"
                                class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('category') border-red-500 @enderror"
                                required>
                            <option value="">{{ __('common.select_category') }}</option>
                            @foreach($categories as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Amount --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('common.amount') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               wire:model="amount"
                               step="0.01"
                               min="0.01"
                               placeholder="0.00"
                               class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('amount') border-red-500 @enderror"
                               required>
                        @error('amount')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('common.description') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               wire:model="description"
                               placeholder="{{ __('common.expense_description') }}"
                               class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                               required>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Expense Date --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('common.expense_date') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               wire:model="expense_date" 
                               class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('expense_date') border-red-500 @enderror"
                               required>
                        @error('expense_date')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Payment Method --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('common.payment_method') }} <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="payment_method"
                                class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                required>
                            <option value="cash">{{ __('common.cash') }}</option>
                            <option value="transfer">{{ __('common.transfer') }}</option>
                            <option value="check">{{ __('common.check') }}</option>
                            <option value="card">{{ __('common.card') }}</option>
                        </select>
                    </div>

                    {{-- Invoice Number --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('common.invoice_number') }}
                        </label>
                        <input type="text" 
                               wire:model="invoice_number"
                               placeholder="{{ __('common.invoice_number_optional') }}"
                               class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                {{-- Notes --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('common.notes') }}
                    </label>
                    <textarea wire:model="notes" 
                              rows="3"
                              placeholder="{{ __('common.additional_notes') }}"
                              class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
            </div>

            {{-- Footer --}}
            <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-800 flex justify-end gap-3">
                <flux:button wire:click="cancel" variant="ghost">
                    {{ __('common.cancel') }}
                </flux:button>
                <flux:button type="submit" variant="primary">
                    {{ $editMode ? __('common.update_expense') : __('common.save_expense') }}
                </flux:button>
            </div>
        </form>
    </div>
</div>
