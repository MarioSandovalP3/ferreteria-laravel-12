{{-- User Form --}}
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-800">
        <form wire:submit.prevent="{{ $editMode ? 'Update' : 'Store' }}">
            {{-- Header --}}
            <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">
                            {{ $editMode ? __('common.edit_user') : __('common.create_user') }}
                        </h2>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                            {{ __('common.manage_user_details') }}
                        </p>
                    </div>
                    <flux:button wire:click="cancel" variant="ghost" icon="x-mark">
                        {{ __('common.close') }}
                    </flux:button>
                </div>
            </div>

            <div class="p-6 space-y-6">
                {{-- Profile Section - Image and Name --}}
                <div>
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-4">
                        {{ __('common.profile') }}
                    </h3>
                    
                    <div class="flex flex-col md:flex-row gap-6">
                        {{-- Image Upload --}}
                        <div class="flex-shrink-0">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.profile_image') }}
                            </label>
                            
                            <div class="relative">
                                <input type="file" 
                                       wire:model="imageFile" 
                                       accept="image/*"
                                       class="hidden" 
                                       id="user-image">
                                
                                <label for="user-image" 
                                       class="flex flex-col items-center justify-center w-48 h-48 border-2 border-dashed border-zinc-300 dark:border-zinc-600 rounded-lg cursor-pointer hover:border-blue-500 dark:hover:border-blue-400 transition-colors bg-zinc-50 dark:bg-zinc-800/50 overflow-hidden">
                                    
                                    @if ($imageFile)
                                        {{-- Preview nueva imagen --}}
                                        <div class="relative w-full h-full">
                                            <img src="{{ $imageFile->temporaryUrl() }}" class="w-full h-full object-cover">
                                            <div class="absolute top-2 right-2">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-500 text-white shadow-lg">
                                                    {{ __('common.new_image') }}
                                                </span>
                                            </div>
                                        </div>
                                    @elseif(filled($image))
                                        {{-- Imagen actual --}}
                                        <div class="relative w-full h-full">
                                            <img src="{{ Storage::url($image) }}" class="w-full h-full object-cover">
                                            <div class="absolute top-2 right-2">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-500 text-white shadow-lg">
                                                    {{ __('common.current') }}
                                                </span>
                                            </div>
                                        </div>
                                    @else
                                        {{-- Estado vacío --}}
                                        <div class="flex flex-col items-center justify-center p-4">
                                            <svg class="w-12 h-12 mb-2 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400 text-center">
                                                {{ __('common.click_to_upload') }}
                                            </p>
                                        </div>
                                    @endif
                                </label>
                            </div>

                            {{-- Loading Indicator --}}
                            <div wire:loading wire:target="imageFile" class="mt-2">
                                <p class="text-xs text-blue-600 dark:text-blue-400">{{ __('common.uploading_image') }}</p>
                            </div>

                            @error('imageFile')
                                <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror

                            {{-- Remove button --}}
                            @if(filled($image) && $editMode)
                                <button type="button" 
                                        wire:click="removeImage({{ $selected_id }})" 
                                        class="mt-2 w-full px-3 py-1.5 text-xs border border-red-300 dark:border-red-600 rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors font-medium">
                                    {{ __('common.remove_image') }}
                                </button>
                            @endif
                        </div>

                        {{-- Name and Basic Info --}}
                        <div class="flex-1 space-y-4">
                            {{-- Name --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('common.name') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       wire:model="name" 
                                       placeholder="{{ __('common.user_name') }}"
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

                            {{-- Phone --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('common.phone') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       wire:model="phone" 
                                       placeholder="{{ __('common.phone') }}"
                                       class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('phone') border-red-500 @enderror"
                                       required>
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Additional Information --}}
                <div>
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-4">
                        {{ __('common.additional_information') }}
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Address --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.address') }}
                            </label>
                            <input type="text" 
                                   wire:model="address" 
                                   placeholder="{{ __('common.address') }}"
                                   class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        </div>

                        {{-- Password --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.password') }} @if(!$editMode)<span class="text-red-500">*</span>@endif
                            </label>
                            <input type="password" 
                                   wire:model="password" 
                                   placeholder="{{ $editMode ? __('common.leave_blank_to_keep') : __('common.password') }}"
                                   class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                                   @if(!$editMode) required @endif>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password Confirmation --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.confirm_password') }} @if(!$editMode)<span class="text-red-500">*</span>@endif
                            </label>
                            <input type="password" 
                                   wire:model="password_confirmation" 
                                   placeholder="{{ __('common.confirm_password') }}"
                                   class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                   @if(!$editMode) required @endif>
                        </div>

                        {{-- Role --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.role') }} <span class="text-red-500">*</span>
                            </label>
                            <select wire:model="role"
                                    class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('role') border-red-500 @enderror"
                                    required>
                                <option value="">{{ __('common.select_role') }}</option>
                                @foreach(\Spatie\Permission\Models\Role::all() as $r)
                                    <option value="{{ $r->name }}">{{ __('common.' . $r->name) }}</option>
                                @endforeach     
                            </select>
                            @error('role')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Account State --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.account_state') }}
                            </label>
                            <select wire:model="account_state"
                                    class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                <option value="Active">{{ __('common.active') }}</option>
                                <option value="Inactive">{{ __('common.inactive') }}</option>
                            </select>
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