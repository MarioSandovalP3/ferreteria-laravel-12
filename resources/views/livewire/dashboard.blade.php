<div>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-fr gap-4 md:grid-cols-3 items-stretch">

            {{-- Tarjeta: Mi perfil --}}
            <div class="relative overflow-hidden rounded-2xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 shadow-lg">
                <x-placeholder-pattern class="absolute inset-0 size-full opacity-5 stroke-neutral-900/10 dark:stroke-white/10" />

                <div class="relative z-10 p-6 sm:p-8 space-y-6">
                    <div class="flex items-center justify-between border-b border-neutral-200 dark:border-neutral-700 pb-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2.5 rounded-xl bg-blue-100 dark:bg-blue-500/10 border border-blue-200 dark:border-blue-500/20">
                                <flux:icon icon="user-circle" class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                            </div>
                            <h2 class="text-lg sm:text-xl font-semibold text-neutral-800 dark:text-neutral-100 tracking-wide">
                                {{ __('common.my_profile') }}
                            </h2>
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition-colors duration-200">
                                <flux:icon icon="pencil-square" class="w-6 h-6" />
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
                        {{-- Imagen y nombre --}}
                        <div class="flex items-center gap-4">
                            <div class="relative w-16 h-16 flex items-center justify-center rounded-full border border-neutral-300 dark:border-neutral-700 bg-neutral-100 dark:bg-neutral-800 overflow-hidden">
                                @if($user->image)
                                    <img src="{{ Storage::url($user->image) }}" alt="{{ $user->name }}" class="w-full h-full object-cover rounded-full" />
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <p class="text-neutral-500 dark:text-neutral-400 text-xs uppercase tracking-wide">{{ __('common.name') }}</p>
                                <p class="font-medium text-neutral-800 dark:text-neutral-100 text-base">{{ $user->name }}</p>
                            </div>
                        </div>

                        {{-- Rol --}}
                        <div class="flex items-start gap-3">
                            <div class="p-2 rounded-lg bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700">
                                <flux:icon icon="shield-check" class="w-4 h-4 text-yellow-600 dark:text-yellow-400" />
                            </div>
                            <div>
                                <p class="text-neutral-500 dark:text-neutral-400 text-xs uppercase tracking-wide">{{ __('common.role') }}</p>
                                <p class="font-medium text-neutral-800 dark:text-neutral-100 mt-0.5">{{ ucfirst($user->role) }}</p>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="flex items-start gap-3">
                            <div class="p-2 rounded-lg bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700">
                                <flux:icon icon="envelope" class="w-4 h-4 text-yellow-600 dark:text-yellow-400" />
                            </div>
                            <div>
                                <p class="text-neutral-500 dark:text-neutral-400 text-xs uppercase tracking-wide">{{ __('common.email') }}</p>
                                <p class="font-medium text-neutral-800 dark:text-neutral-100 mt-0.5">{{ $user->email }}</p>
                            </div>
                        </div>

                        {{-- Teléfono --}}
                        <div class="flex items-start gap-3">
                            <div class="p-2 rounded-lg bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700">
                                <flux:icon icon="phone" class="w-4 h-4 text-yellow-600 dark:text-yellow-400" />
                            </div>
                            <div>
                                <p class="text-neutral-500 dark:text-neutral-400 text-xs uppercase tracking-wide">{{ __('common.phone') }}</p>
                                <p class="font-medium text-neutral-800 dark:text-neutral-100 mt-0.5">{{ $user->phone ?? __('Not set') }}</p>
                            </div>
                        </div>

                        {{-- Dirección --}}
                        <div class="flex items-start gap-3 sm:col-span-2">
                            <div class="p-2 rounded-lg bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700">
                                <flux:icon icon="map-pin" class="w-4 h-4 text-yellow-600 dark:text-yellow-400" />
                            </div>
                            <div>
                                <p class="text-neutral-500 dark:text-neutral-400 text-xs uppercase tracking-wide">{{ __('common.address') }}</p>
                                <p class="font-medium text-neutral-800 dark:text-neutral-100 mt-0.5">{{ $user->address ?? __('Not set') }}</p>
                            </div>
                        </div>

                        
                    </div>
                    
                    {{-- Estado de cuenta --}}
                    <div class="flex justify-end mt-auto pt-4 border-t border-gray-200 dark:border-gray-700">
                        <span class="px-3 py-1 text-xs font-medium rounded-full
                                     @if($user->account_state === 'Active')
                                        bg-green-100 dark:bg-green-500/10 text-green-600 dark:text-green-400 border border-green-300 dark:border-green-500/30
                                     @else
                                        bg-red-100 dark:bg-red-500/10 text-red-600 dark:text-red-400 border border-red-300 dark:border-red-500/30
                                     @endif">
                            {{ ucfirst($user->account_state) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Tarjeta: Configuración regional --}}
            <div class="relative aspect-video overflow-hidden rounded-2xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 shadow-lg">
                <x-placeholder-pattern class="absolute inset-0 size-full opacity-5 stroke-neutral-900/10 dark:stroke-white/10" />

                <div class="relative z-10 p-6 sm:p-8 space-y-6">
                    <div class="flex items-center justify-between border-b border-neutral-200 dark:border-neutral-700 pb-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2.5 rounded-xl bg-yellow-100 dark:bg-yellow-500/10 border border-yellow-200 dark:border-yellow-500/20">
                                <flux:icon icon="globe-alt" class="w-6 h-6 text-yellow-600 dark:text-yellow-400" />
                            </div>
                            <h2 class="text-lg sm:text-xl font-semibold text-neutral-800 dark:text-neutral-100 tracking-wide">
                                {{ __('common.regional-settings') }}
                            </h2>
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('regional-settings.edit') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition-colors duration-200">
                                <flux:icon icon="pencil-square" class="w-6 h-6" />
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
                        <div class="flex items-start gap-3">
                            <div class="p-2 rounded-lg bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700">
                                <flux:icon icon="clock" class="w-4 h-4 text-yellow-600 dark:text-yellow-400" />
                            </div>
                            <div>
                                <p class="text-neutral-500 dark:text-neutral-400 text-xs uppercase tracking-wide">{{ __('common.timezone') }}</p>
                                <p class="font-medium text-neutral-800 dark:text-neutral-100 mt-0.5">{{ $serverTimezone }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="p-2 rounded-lg bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700">
                                <flux:icon icon="calendar-days" class="w-4 h-4 text-yellow-600 dark:text-yellow-400" />
                            </div>
                            <div>
                                <p class="text-neutral-500 dark:text-neutral-400 text-xs uppercase tracking-wide">{{ __('common.current_server_date') }}</p>
                                <p class="font-medium text-neutral-800 dark:text-neutral-100 mt-0.5">{{ $serverTime->locale(app()->getLocale())->translatedFormat(config('app.date_format')) }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="p-2 rounded-lg bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700">
                                <flux:icon icon="banknotes" class="w-4 h-4 text-yellow-600 dark:text-yellow-400" />
                            </div>
                            <div>
                                <p class="text-neutral-500 dark:text-neutral-400 text-xs uppercase tracking-wide">{{ __('common.currency') }}</p>
                                <p class="font-medium text-neutral-800 dark:text-neutral-100 mt-0.5">{{ $currency }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="p-2 rounded-lg bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700">
                                <flux:icon icon="currency-dollar" class="w-4 h-4 text-yellow-600 dark:text-yellow-400" />
                            </div>
                            <div>
                                <p class="text-neutral-500 dark:text-neutral-400 text-xs uppercase tracking-wide">{{ __('common.currency_symbol') }}</p>
                                <p class="font-medium text-neutral-800 dark:text-neutral-100 mt-0.5">{{ $currency_symbol }}</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Placeholder adicional --}}
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>

        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>
</div>