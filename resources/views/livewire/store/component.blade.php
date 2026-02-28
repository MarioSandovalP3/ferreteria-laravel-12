<div class="w-full max-w-9xl mx-auto">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <flux:heading size="xl" level="1" class="text-zinc-900 dark:text-white font-bold tracking-tight">
                {{ __('common.store') }}
            </flux:heading>
            <flux:subheading size="lg" class="text-zinc-500 dark:text-zinc-400 mt-1">
                {{ __('common.store_settings') }}
            </flux:subheading>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm overflow-hidden">
        
        <form wire:submit="Update">
            <!-- Basic Information -->
            <div class="p-6 border-b border-zinc-200 dark:border-zinc-800">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">{{ __('common.basic_info') }}</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            {{ __('common.store_name') }} <span class="text-red-500">*</span>
                        </label>
                        <flux:input 
                            wire:model="name" 
                            placeholder="Enter store name"
                            required
                        />
                        @error("name")
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            {{ __('common.store_email') }} <span class="text-red-500">*</span>
                        </label>
                        <flux:input 
                            wire:model="email" 
                            type="email"
                            placeholder="store@example.com"
                            required
                        />
                        @error("email")
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            {{ __('common.store_phone') }} <span class="text-red-500">*</span>
                        </label>
                        <flux:input 
                            wire:model="phone" 
                            placeholder="+1 (809) 555-1234"
                        />
                        @error("phone")
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <flux:input 
                        wire:model="whatsapp" 
                        label="WhatsApp" 
                        placeholder="+1 (809) 555-5678"
                    />

                    <div class="md:col-span-2">
                        <flux:textarea 
                            wire:model="description" 
                            label="{{ __('common.store_description') }}" 
                            placeholder="{{ __('common.store_description') }}"
                            rows="3"
                        />
                    </div>
                </div>
            </div>

            <!-- Regional Settings -->
            <div class="p-6 border-b border-zinc-200 dark:border-zinc-800">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">{{__('common.regional_settings')}}</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            {{ __('common.store_address') }} <span class="text-red-500">*</span>
                        </label>
                        <flux:input 
                            wire:model="address" 
                            placeholder="Av. Industrial 1234"
                        />
                        @error("address")
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            {{ __('common.store_regional_settings') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-2">
                            <select 
                                wire:model.live="regional_settings_id"
                                class="flex-1 px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('regional_settings_id') border-red-500 dark:border-red-500 @enderror">
                                <option value="">Select Regional Settings</option>
                                @foreach($regionalSettings as $setting)
                                    <option value="{{ $setting->id }}">
                                        {{ $setting->country->name_es ?? $setting->country->name_en }} 
                                        ({{ $setting->country->currency }} - {{ $setting->country->timezone }})
                                    </option>
                                @endforeach
                            </select>
                            <button 
                                type="button"
                                wire:click="openRegionalModal"
                                class="px-4 py-2.5 {{ $regional_settings_id ? 'bg-green-600 hover:bg-green-700' : 'bg-blue-600 hover:bg-blue-700' }} text-white rounded-lg transition-colors duration-200 flex items-center gap-2 whitespace-nowrap"
                                title="{{ $regional_settings_id ? 'Edit Regional Setting' : 'Create New Regional Setting' }}">
                                @if($regional_settings_id)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                    {{ __('common.edit') }}
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                    {{ __('common.new') }}
                                @endif
                            </button>
                        </div>
                        @error('regional_settings_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            {{__('common.this_will_set_the_currency_timezone_and_country_for_your_store')}}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Social Media -->
            <div class="p-6 border-b border-zinc-200 dark:border-zinc-800">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">{{__('common.social_media')}}</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <flux:input 
                        wire:model="facebook" 
                        label="{{ __('common.facebook_url') }}" 
                        placeholder="https://facebook.com/yourstore"
                    />

                    <flux:input 
                        wire:model="instagram" 
                        label="{{ __('common.instagram_url') }}" 
                        placeholder="https://instagram.com/yourstore"
                    />

                    <flux:input 
                        wire:model="twitter" 
                        label="{{ __('common.twitter_url') }}" 
                        placeholder="https://twitter.com/yourstore"
                    />
                </div>
            </div>

            <!-- Store Settings -->
            <div class="p-6 border-b border-zinc-200 dark:border-zinc-800">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">{{ __('common.store_settings') }}</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            {{ __('common.tax_rate') }} <span class="text-red-500">*</span>
                        </label>
                        <flux:input 
                            wire:model="tax_rate" 
                            type="number"
                            step="0.01"
                            min="0"
                            max="100"
                            required
                        />
                        @error("tax_rate")
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            {{ __('common.shipping_cost') }} <span class="text-red-500">*</span>
                        </label>
                        <flux:input 
                            wire:model="shipping_cost" 
                            type="number"
                            step="0.01"
                            min="0"
                            required
                        />
                        @error("shipping_cost")
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            {{ __('common.free_shipping_threshold') }} <span class="text-red-500">*</span>
                        </label>
                        <flux:input 
                            wire:model="free_shipping_threshold" 
                            type="number"
                            step="0.01"
                            min="0"
                            required
                        />
                        @error("free_shipping_threshold")
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- SEO Settings -->
            <div class="p-6 border-b border-zinc-200 dark:border-zinc-800">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">{{__('common.seo_settings')}}</h3>
                
                <div class="grid grid-cols-1 gap-6">
                    <flux:input 
                        wire:model="meta_title" 
                        label="{{ __('common.meta_title') }}" 
                        placeholder="Your Store - Best Products"
                    />

                    <flux:textarea 
                        wire:model="meta_description" 
                        label="{{ __('common.meta_description') }}" 
                        placeholder="Store description for search engines"
                        rows="2"
                    />

                    <flux:input 
                        wire:model="meta_keywords" 
                        label="Meta Keywords" 
                        placeholder="keyword1, keyword2, keyword3"
                    />
                </div>
            </div>

            <!-- Status Settings -->
            <div class="p-6 border-b border-zinc-200 dark:border-zinc-800">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">{{ __('common.status') }}</h3>
                
                <div class="flex flex-col gap-4">
                    <flux:checkbox 
                        wire:model="is_active" 
                        label="{{ __('common.store_is_active') }}"
                    />

                    <flux:checkbox 
                        wire:model="maintenance_mode" 
                        label="{{ __('common.maintenance_mode') }}"
                    />
                </div>
            </div>

            <!-- Images Upload -->
            <div class="p-6 border-b border-zinc-200 dark:border-zinc-800">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">{{ __('common.images') }}</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Logo Upload -->
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            {{ __('common.logo') }}
                        </label>
                        
                        <div class="relative group">
                            <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center cursor-pointer hover:border-blue-500 transition-colors relative"
                                 onclick="document.getElementById('new_logo').click()">
                                
                                @if($new_logo)
                                    <img src="{{ $new_logo->temporaryUrl() }}" class="mx-auto h-32 w-32 rounded-lg object-contain">
                                @elseif($logo)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($logo) }}" class="mx-auto h-32 w-32 rounded-lg object-contain">
                                @else
                                    <div class="mx-auto h-32 w-32 bg-gray-100 dark:bg-gray-700 flex items-center justify-center rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{__('common.click_to_upload_logo')}}</p>
                                @endif

                                <input type="file" id="new_logo" wire:model="new_logo" class="hidden" accept="image/*">
                            </div>
                            
                            @if($logo || $new_logo)
                                <button type="button" 
                                        wire:click="removeLogo"
                                        class="absolute top-0 right-0 -mt-2 -mr-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 shadow-sm cursor-pointer"
                                        title="Remove logo">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            @endif
                        </div>
                        @error('new_logo') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Banner Upload -->
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            {{ __('common.banner') }}
                        </label>
                        
                        <div class="relative group">
                            <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center cursor-pointer hover:border-blue-500 transition-colors relative"
                                 onclick="document.getElementById('new_banner').click()">
                                
                                @if($new_banner)
                                    <img src="{{ $new_banner->temporaryUrl() }}" class="mx-auto h-32 w-full rounded-lg object-cover">
                                @elseif($banner)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($banner) }}" class="mx-auto h-32 w-full rounded-lg object-cover">
                                @else
                                    <div class="mx-auto h-32 w-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Click to upload banner</p>
                                @endif

                                <input type="file" id="new_banner" wire:model="new_banner" class="hidden" accept="image/*">
                            </div>
                            
                            @if($banner || $new_banner)
                                <button type="button" 
                                        wire:click="removeBanner"
                                        class="absolute top-0 right-0 -mt-2 -mr-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 shadow-sm cursor-pointer"
                                        title="Remove banner">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            @endif
                        </div>
                        @error('new_banner') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-zinc-50/50 dark:bg-zinc-900/50 flex justify-end gap-3">
                <flux:button type="submit" variant="primary">
                    {{ __('common.save_changes') }}
                </flux:button>
            </div>
        </form>
    </div>

    <!-- Regional Settings Modal -->
    <div x-data="{ show: @entangle('showRegionalModal') }" 
         x-show="show" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         @keydown.escape.window="show = false">
        
        <!-- Overlay -->
        <div x-show="show" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm">
        </div>

        <!-- Modal Container -->
        <div class="flex min-h-screen items-center justify-center p-4">
            <div x-show="show"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 @click.stop
                 class="relative w-full max-w-2xl bg-white dark:bg-gray-800 rounded-xl shadow-2xl">
                
                <!-- Modal Content -->
                <div class="p-6 space-y-6">
                    
                    <!-- Header -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                            @if($modal_editing)
                                {{ __('common.edit_regional_settings') }}
                            @else
                                {{ __('common.create_regional_settings') }}
                            @endif
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            @if($modal_editing)
                                {{ __('common.update_the_regional_configuration') }} (ID: {{ $modal_regional_id }})
                            @else
                                {{ __('common.add_a_new_regional_configuration') }}
                            @endif
                        </p>
                    </div>

                    <!-- Form Fields -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.country') }} <span class="text-red-500">*</span>
                            </label>
                            <select 
                                wire:model="modal_country_id"
                                class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('modal_country_id') border-red-500 dark:border-red-500 @enderror">
                                <option value="">{{ __('common.select_country') }}</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}">
                                        {{ $country->name_es ?? $country->name_en }} 
                                        ({{ $country->currency }} - {{ $country->timezone }})
                                    </option>
                                @endforeach
                            </select>
                            @error('modal_country_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('common.region') }}
                                </label>
                                <input 
                                    type="text"
                                    wire:model="modal_region_name"
                                    placeholder="{{ __('common.enter_region') }}"
                                    class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('modal_region_name') border-red-500 dark:border-red-500 @enderror">
                                @error('modal_region_name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('common.city') }}
                                </label>
                                <input 
                                    type="text"
                                    wire:model="modal_city"
                                    placeholder="{{ __('common.enter_city') }}"
                                    class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('modal_city') border-red-500 dark:border-red-500 @enderror">
                                @error('modal_city')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('common.zip_code') }}
                                </label>
                                <input 
                                    type="text"
                                    wire:model="modal_zip"
                                    placeholder="{{ __('common.enter_zip_code') }}"
                                    class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('modal_zip') border-red-500 dark:border-red-500 @enderror">
                                @error('modal_zip')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <button type="button"
                                wire:click="closeRegionalModal"
                                class="px-5 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-all duration-200 cursor-pointer">
                            {{ __('common.cancel') }}
                        </button>
                        <button type="button"
                                wire:click="saveRegionalSettings"
                                class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-sm hover:shadow-md cursor-pointer">
                            @if($modal_editing)
                                {{ __('common.update') }}
                            @else
                                {{ __('common.create') }}
                            @endif
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
