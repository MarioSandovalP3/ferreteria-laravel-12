<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                {{-- General --}}
                <flux:navlist.group :heading="__('common.general')" class="grid">
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('common.dashboard') }}</flux:navlist.item>
                    <flux:navlist.item icon="user-group" :href="route('admin.partners')" :current="request()->routeIs('admin.partners')" wire:navigate>{{ __('common.partners') }}</flux:navlist.item>
                    <flux:navlist.item icon="users" :href="route('admin.users')" :current="request()->routeIs('admin.users')" wire:navigate>{{ __('common.users') }}</flux:navlist.item>
                </flux:navlist.group>

                {{-- Compras --}}
                <flux:navlist.group :heading="__('common.purchases_section')" class="grid">
                    <flux:navlist.item icon="document-text" :href="route('admin.purchase-quotations')" :current="request()->routeIs('admin.purchase-quotations')" wire:navigate>{{ __('common.quotations') }}</flux:navlist.item>
                    <flux:navlist.item icon="shopping-bag" :href="route('admin.purchases')" :current="request()->routeIs('admin.purchases')" wire:navigate>{{ __('common.product_purchases') }}</flux:navlist.item>
                    <flux:navlist.item icon="banknotes" :href="route('admin.supplier-payments')" :current="request()->routeIs('admin.supplier-payments')" wire:navigate>{{ __('common.supplier_payments') }}</flux:navlist.item>
                    <flux:navlist.item icon="receipt-percent" :href="route('admin.expenses')" :current="request()->routeIs('admin.expenses')" wire:navigate>{{ __('common.expenses') }}</flux:navlist.item>
                </flux:navlist.group>

                {{-- Ventas --}}
                <flux:navlist.group :heading="__('common.sales_section')" class="grid">
                    <flux:navlist.item icon="shopping-cart" :href="route('admin.sales')" :current="request()->routeIs('admin.sales')" wire:navigate>{{ __('common.sales') }}</flux:navlist.item>
                </flux:navlist.group>

                {{-- Inventario & Productos --}}
                <flux:navlist.group :heading="__('common.inventory_products')" class="grid">
                    <flux:navlist.item icon="clipboard-document-list" :href="route('admin.inventory')" :current="request()->routeIs('admin.inventory')" wire:navigate>{{ __('common.inventory') }}</flux:navlist.item>
                    <flux:navlist.item icon="cube" :href="route('admin.products')" :current="request()->routeIs('admin.products')" wire:navigate>{{ __('common.products') }}</flux:navlist.item>
                    <flux:navlist.item icon="building-storefront" :href="route('admin.store')" :current="request()->routeIs('admin.store')" wire:navigate>{{ __('common.store') }}</flux:navlist.item>
                </flux:navlist.group>

                {{-- Configuración --}}
                <flux:navlist.group :heading="__('common.configuration')" class="grid">
                    <flux:navlist.item icon="currency-dollar" :href="route('admin.exchange-rates')" :current="request()->routeIs('admin.exchange-rates')" wire:navigate>{{ __('common.exchange_rates_title') }}</flux:navlist.item>
                </flux:navlist.group>

            </flux:navlist>


            <flux:spacer />

            

            <flux:navlist variant="outline">
                <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                {{ __('common.repository') }}
                </flux:navlist.item>

                <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                {{ __('common.documentation') }}
                </flux:navlist.item>
            </flux:navlist>

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                    data-test="sidebar-menu-button"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('common.settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    




                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full" data-test="logout-button">
                            {{ __('common.logout') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('common.settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full" data-test="logout-button">
                            {{ __('common.logout') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        <!-- Custom Toast Notification -->
        <div x-data="{ show: false, message: '' }"
             x-on:msg.window="show = true; message = $event.detail; setTimeout(() => show = false, 3000)"
             class="fixed top-4 right-4 z-50"
             style="display: none;"
             x-show="show"
             x-transition:enter="transform ease-out duration-300 transition"
             x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
             x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="max-w-2xl w-full min-w-[300px] bg-white dark:bg-zinc-800 shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
                <div class="p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3 flex-1 pt-0.5">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100" x-text="message"></p>
                        </div>
                        <div class="ml-4 flex-shrink-0 flex">
                            <button @click="show = false" class="bg-white dark:bg-zinc-800 rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span class="sr-only">Close</span>
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @fluxScripts
    </body>
</html>
