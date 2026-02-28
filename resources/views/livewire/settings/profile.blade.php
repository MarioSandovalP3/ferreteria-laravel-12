<section class="w-full">
    @include('partials.settings-heading')
    <form wire:submit="updateProfileInformation">
        <x-settings.layout :heading="__('common.profile_settings')" :subheading="__('common.update_your_name_and_email_address')">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Imagen de perfil a la derecha -->
                <div class="lg:w-1/4">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 sticky">
                        <flux:label class="text-lg font-medium mb-4 block">{{ __('common.profile_image') }}</flux:label>
                        {{-- Simple Upload Area --}}
                        <div class="relative">
                            <input type="file" 
                                   wire:model="imageFile" 
                                   accept="image/*"
                                   class="hidden" 
                                   id="profile-image-input">
                            
                            <label for="profile-image-input" 
                                   class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-blue-500 dark:hover:border-blue-400 transition-colors bg-gray-50 dark:bg-gray-800/50 overflow-hidden">
                                
                                @if ($imageFile)
                                    <div class="relative w-full h-full">
                                        <img src="{{ $imageFile->temporaryUrl() }}" class="w-full h-full object-contain">
                                        <div class="absolute top-2 right-2">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-500 text-white shadow-lg">
                                                {{ __('common.new_image') }}
                                            </span>
                                        </div>
                                    </div>
                                @elseif(filled($image))
                                    <div class="relative w-full h-full">
                                        <img src="{{ Storage::url($image) }}" class="w-full h-full object-contain">
                                        <div class="absolute top-2 right-2">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-500 text-white shadow-lg">
                                                {{ __('common.current') }}
                                            </span>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex flex-col items-center justify-center p-4">
                                        <svg class="w-12 h-12 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 text-center">
                                            {{ __('common.click_to_upload') }}
                                        </p>
                                    </div>
                                @endif
                            </label>
                        </div>

                        <div wire:loading wire:target="imageFile" class="mt-2">
                            <p class="text-xs text-blue-600 dark:text-blue-400">{{ __('common.uploading_image') }}</p>
                        </div>

                        @error('imageFile')
                        <flux:text class="!text-red-600 dark:!text-red-400 mt-3 text-sm">{{ $message }}</flux:text>
                        @enderror
                        @if(filled($image))
                        <div class="mt-4 text-center">
                            <button type="button" wire:click="removeProfileImage" class="w-full px-4 py-2 text-sm border border-red-300 dark:border-red-600 rounded-md text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                            {{ __('common.remove_image') }}
                            </button> 
                        </div>
                        @endif
                    </div>
                </div>
                <!-- Formulario a la izquierda -->
                <div class="flex-1">
                    <flux:input 
                    wire:model="name" 
                    :label="__('common.name')" 
                    type="text" 
                    required 
                    autofocus autocomplete="name" 
                    class="block w-full max-w-xs sm:max-w-sm md:max-w-xl"/>
                    <div class="mt-4">
                        <flux:input 
                        wire:model="email" 
                        :label="__('common.email')" 
                        type="email" 
                        required autocomplete="email" 
                        class="block w-full max-w-xs sm:max-w-sm md:max-w-xl"/>
                        

                        <div class="mt-3">
                            <flux:input 
                        wire:model="phone" 
                        :label="__('common.phone')" 
                        type="text" 
                        autocomplete="phone" 
                        class="block w-full max-w-xs sm:max-w-sm md:max-w-xl"/>
                        </div>

                        <div class="mt-3">
                            <flux:input 
                        wire:model="address" 
                        :label="__('common.address')" 
                        type="text" 
                        autocomplete="address" 
                        class="block w-full max-w-xs sm:max-w-sm md:max-w-xl"/>
                        </div>
                        

                        @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                        <div>
                            <flux:text class="mt-4">
                                {{ __('Your email address is unverified.') }}
                                <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                    {{ __('Click here to re-send the verification email.') }}
                                </flux:link>
                            </flux:text>
                            @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </flux:text>
                            @endif
                        </div>
                        @endif
                    </div>
                    <div class="space-y-4 mt-4">
                        

                    <div class="mt-4 border-t border-gray-700 pt-3">
    <flux:select
        wire:model="language"
        :label="__('common.language')"
        placeholder="Choose a language..."
        class="w-full max-w-xs sm:max-w-sm"
    >
        <flux:select.option value="en">🇺🇸 English</flux:select.option>
        <flux:select.option value="es">🇪🇸 Español</flux:select.option>
    </flux:select>
</div>

                        
                        <div class="flex items-center gap-3 mt-2">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('common.account_state') }}
                            </label>
                            <button
                                type="button"
                                wire:click="toggleAccountState"
                                class="relative inline-flex items-center h-5 rounded-full w-10 transition-colors focus:outline-none
                                {{ $account_state === 'Active' ? 'bg-green-500' : 'bg-gray-400' }}"
                                 
                                >
                            <span
                                class="inline-block w-4 h-4 transform bg-white rounded-full transition-transform
                                {{ $account_state === 'Active' ? 'translate-x-5' : 'translate-x-1' }}"
                                ></span>
                            </button>
                            <span class="text-sm font-semibold {{ $account_state === 'Active' ? 'text-green-600' : 'text-red-500' }}">
                            {{$account_state}}

                            </span>
                        </div>

                        
                    </div>
                    <div class="flex items-center gap-4 mt-6">
                        <div class="flex items-center justify-end">
                            <flux:button variant="primary" type="submit" class="w-full" data-test="update-profile-button">
                                {{ __('common.saved') }}
                            </flux:button>
                        </div>
                        <x-action-message class="me-3" on="profile-updated">
                            {{ __('common.saved.') }}
                        </x-action-message>
                    </div>
                    <livewire:settings.delete-user-form />
                </div>
                
            </div>
        </x-settings.layout>
    </form>
    <span wire:loading wire:target="removeProfileImage">
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
                <div class="flex items-center space-x-3">
                    <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
                    <span class="text-gray-700 dark:text-gray-300">{{ __('Removing image') }}</span>
                </div>
            </div>
        </div>
    </span>
</section>
