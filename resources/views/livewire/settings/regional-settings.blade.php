<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('common.regional-settings')" :subheading="__('common.update_your_regional_preferences')">
       
<div class="mt-4 border-t border-gray-700 pt-3">
    <label class="block text-sm font-medium text-gray-300 mb-2">
        {{ __('common.country') }}
    </label>
    <flux:dropdown>
    {{-- Main button: Selected country --}}
    <flux:button 
        
        icon:trailing="chevron-down"
        class="w-auto max-w-xs sm:max-w-sm flex items-center justify-start gap-2 px-3 py-2 text-left"
    >
        <div class="flex items-center gap-2">
            @if($selectedCountry = $countries->firstWhere('id', $country_id))
                <img
                    src="{{ Storage::url('images/flags/' . $selectedCountry->image) }}"
                    alt="{{ $selectedCountry->name_en }}"
                    class="w-5 h-5 rounded-full object-cover"
                />
                <span>{{ $selectedCountry->name_en }}</span>
            @else
                <span class="text-gray-400">{{ __('Choose a country...') }}</span>
            @endif
        </div>
    </flux:button>

    {{-- Country dropdown list --}}
    <flux:menu class="max-h-64 overflow-y-auto w-auto max-w-xs sm:max-w-sm" >
        @foreach($countries as $country)
            <flux:menu.item
                    wire:click="$set('country_id', {{ $country->id }})"
                    class="flex items-center gap-2 px-3 py-2 hover:bg-gray-700"
                >
                <img
                    src="{{ Storage::url('images/flags/' . $country->image) }}"
                    alt="{{ $country->name_en }}"
                    class="w-5 h-5 rounded-full object-cover"
                />
                <span>{{ $country->name_en }}</span>
                @if($country->name_es)
                    <span class="text-gray-400 text-xs">({{ $country->name_es }})</span>
                @endif
            </flux:menu.item>
        @endforeach
    </flux:menu>
</flux:dropdown>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">

    <flux:input
        wire:model="region_name"
        :label="__('common.region')"
        placeholder="{{ __('common.enter_region') }}"
    />

    <flux:input
        wire:model="city"
        :label="__('common.city')"
        placeholder="{{ __('common.enter_city') }}"
    />

    <flux:input
        wire:model="zip"
        :label="__('common.zip_code')"
        placeholder="{{ __('common.enter_zip_code') }}"
    />

    <flux:input
        wire:model="lat"
        :label="__('common.latitude')"
        placeholder="{{ __('common.enter_latitude') }}"
    />

    <flux:input
        wire:model="lon"
        :label="__('common.longitude')"
        placeholder="{{ __('common.enter_longitude') }}"
    />

</div>


</div>

<div class="mt-4">
    <flux:select
        wire:model="date_format"
        :label="__('common.date_format')"
        placeholder="Selecciona un formato de fecha..."
        class="w-full max-w-xs sm:max-w-sm"
    >
        @foreach($dateFormats as $format)
            <flux:select.option :value="$format">
                {{ $now->translatedFormat($format) }}
            </flux:select.option>
        @endforeach
    </flux:select>

</div>






    <div class="flex items-center gap-4 mt-6">
                        <div class="flex items-center justify-end">
                            <flux:button variant="primary" wire:click="Update" class="w-full" data-test="update-profile-button">
                                {{ __('common.saved') }}
                            </flux:button>
                        </div>
                        <x-action-message class="me-3" on="profile-updated">
                            {{ __('common.saved.') }}
                        </x-action-message>
                    </div>
     

                   <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
    {{-- 🖥️ Información del servidor --}}
    <div class="bg-gray-800/60 border border-gray-700 rounded-2xl p-4 sm:p-5 shadow-md">
        <h2 class="font-semibold text-gray-300 mb-3 flex items-center gap-2">
            <flux:icon icon="globe-alt" class="w-6 h-6 text-white" />
            {{ __('common.server_information') }}
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            {{-- Zona horaria --}}
            <div class="flex items-center gap-2">
                <flux:icon icon="clock" class="w-4 h-4 text-yellow-400 shrink-0" />
                <div>
                    <p class="text-gray-400">{{ __('common.timezone') }}</p>
                    <p class="font-medium text-gray-200">{{ $serverTimezone }}</p>
                </div>
            </div>

            {{-- Hora actual del servidor --}}
            <div class="flex items-center gap-2">
                <flux:icon icon="calendar-days" class="w-4 h-4 text-yellow-400 shrink-0" />
                <div>
                    <p class="text-gray-400">{{ __('common.current_server_date') }}</p>
                    <p class="font-medium text-gray-200">
                        {{ $serverTime->locale(app()->getLocale())->translatedFormat($date_format) }}
                    </p>
                </div>
            </div>

            {{-- Moneda --}}
            <div class="flex items-center gap-2">
                <flux:icon icon="banknotes" class="w-4 h-4 text-yellow-400 shrink-0" />
                <div>
                    <p class="text-gray-400">{{ __('common.currency') }}</p>
                    <p class="font-medium text-gray-200">{{ $currency }}</p>
                </div>
            </div>

            {{-- Símbolo de moneda --}}
            <div class="flex items-center gap-2">
                <flux:icon icon="currency-dollar" class="w-4 h-4 text-yellow-400 shrink-0" />
                <div>
                    <p class="text-gray-400">{{ __('common.currency_symbol') }}</p>
                    <p class="font-medium text-gray-200">{{ $currency_symbol }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- 📍 Información de la región --}}
    <div class="bg-gray-800/60 border border-gray-700 rounded-2xl p-4 sm:p-5 shadow-md">
        <h2 class="font-semibold text-gray-300 mb-3 flex items-center gap-2">
            🌎 {{ __('common.region_information') }}
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-400">{{ __('common.region') }}</p>
                <p class="font-medium text-gray-200">{{ $region_name ?? __('Not set') }}</p>
            </div>

            <div>
                <p class="text-gray-400">{{ __('common.city') }}</p>
                <p class="font-medium text-gray-200">{{ $city ?? __('Not set') }}</p>
            </div>

            <div>
                <p class="text-gray-400">{{ __('common.zip_code') }}</p>
                <p class="font-medium text-gray-200">{{ $zip ?? __('Not set') }}</p>
            </div>

            <div>
                <p class="text-gray-400">{{ __('common.coordinates') }}</p>
                <p class="font-medium text-gray-200">
                    {{ $lat && $lon ? "$lat, $lon" : __('Not set') }}
                </p>
            </div>
        </div>
    </div>
</div>




    </x-settings.layout>
</section>
