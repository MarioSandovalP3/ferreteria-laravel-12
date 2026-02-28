{{-- Partner Form --}}
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-800">
        <form wire:submit.prevent="{{ $editMode ? 'Update' : 'Store' }}">
            {{-- Header --}}
            <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">
                            {{ $editMode ? __('common.edit_partner') : __('common.create_partner') }}
                        </h2>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                            {{ __('common.manage_partner_details') }}
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
                        {{ __('common.basic_information') }}
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Name --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.name') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   wire:model="name" 
                                   placeholder="{{ __('common.partner_name') }}"
                                   class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.email') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   wire:model="email" 
                                   placeholder="email@example.com"
                                   class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                                   required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tax ID --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.tax_id') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   wire:model="tax_id" 
                                   placeholder="{{ __('common.tax_id') }}"
                                   class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('tax_id') border-red-500 @enderror"
                                   required>
                            @error('tax_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.phone') }}
                            </label>
                            <input type="text" 
                                   wire:model="phone" 
                                   placeholder="{{ __('common.phone') }}"
                                   class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        </div>

                        {{-- Address --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.address') }}
                            </label>
                            <input type="text" 
                                   wire:model="address" 
                                   placeholder="{{ __('common.address') }}"
                                   class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        </div>

                        {{-- Type --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.type') }} <span class="text-red-500">*</span>
                            </label>
                            <select wire:model="type"
                                    class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('type') border-red-500 @enderror"
                                    required>
                                <option value="">{{ __('common.select_type') }}</option>
                                <option value="person">{{ __('common.type_person') }}</option>
                                <option value="company">{{ __('common.type_company') }}</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Roles --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                {{ __('common.roles') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="flex flex-wrap gap-4">
                                @foreach(\App\Models\PartnerRoleType::all() as $role)
                                <label class="inline-flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" 
                                           wire:model="roles" 
                                           value="{{ $role->id }}"
                                           class="w-4 h-4 text-blue-600 bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-600 rounded focus:ring-2 focus:ring-blue-500">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ __('common.' . $role->name) }}</span>
                                </label>
                                @endforeach
                            </div>
                            @error('roles')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Active --}}
                        <div class="md:col-span-2">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" 
                                       wire:model="is_active"
                                       class="w-4 h-4 text-blue-600 bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-600 rounded focus:ring-2 focus:ring-blue-500">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('common.active') }}</span>
                            </label>
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
                    {{ $editMode ? __('common.update') : __('common.save') }}
                </flux:button>
            </div>
        </form>
    </div>
</div>