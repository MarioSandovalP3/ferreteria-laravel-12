<div class="w-full max-w-9xl mx-auto">
    @if($showForm)
        @include('livewire.partners.form')
    @else
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <flux:heading size="xl" level="1" class="text-zinc-900 dark:text-white font-bold tracking-tight">
                    {{ __('common.partners') }}
                </flux:heading>
                <flux:subheading size="lg" class="text-zinc-500 dark:text-zinc-400 mt-1">
                    {{ __('common.customers_and_suppliers') }}
                </flux:subheading>
            </div>

            <button wire:click="create"
               class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-500 active:bg-blue-700 rounded-lg shadow-sm transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 dark:focus:ring-offset-zinc-900 cursor-pointer">
                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('common.btn_new') }}
            </button>
        </div>

        <!-- Main Content Card -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm overflow-hidden">
            
            <!-- Toolbar -->
            <div class="p-5 border-b border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                <div class="flex flex-col sm:flex-row gap-4 justify-between">
                    <!-- Search -->
                    <div class="relative w-full sm:max-w-md">
                        <flux:input 
                            wire:model.live="search" 
                            placeholder="{{ __('common.search_partners') }}"
                            type="text"  
                            class="w-full bg-white dark:bg-zinc-800"
                        />
                    </div>

                    <!-- Filters -->
                    <div class="w-full sm:w-auto min-w-[200px]">
                        <flux:select 
                            wire:model.live="filterRole" 
                            label="{{ __('common.filter_by_role') }}"
                            class="w-full"
                        >
                            <flux:select.option value="">{{ __('common.all_roles') }}</flux:select.option>
                            <flux:select.option value="customer">{{ __('common.customer') }}</flux:select.option>
                            <flux:select.option value="supplier">{{ __('common.supplier') }}</flux:select.option>
                            <flux:select.option value="reseller">{{ __('common.reseller') }}</flux:select.option>
                        </flux:select>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                            <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider">{{ __('common.name') }}</th>
                            <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider">{{ __('common.tax_id') }}</th>
                            <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider">{{ __('common.email') }}</th>
                            <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider">{{ __('common.type') }}</th>
                            <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider">{{ __('common.roles') }}</th>
                            <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider">{{ __('common.active') }}</th>
                            <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider text-right">{{ __('common.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @foreach ($partners as $partner)
                        <tr class="group hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors duration-150 ease-in-out">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 font-bold text-xs">
                                        JD
                                    </div>
                                    <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $partner->name }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-sm text-zinc-600 dark:text-zinc-400">
                                {{ $partner->tax_id }}
                            </td>
                            <td class="py-4 px-6 text-sm text-zinc-600 dark:text-zinc-400">
                                {{ $partner->email }}
                            </td>
                            <td class="py-4 px-6 text-sm text-zinc-600 dark:text-zinc-400">
                                {{ __('common.type_' . $partner->type) }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($partner->roles as $role)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            bg-blue-50 text-blue-700 border border-blue-100
                                            dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800">
                                            {{ __('common.' . $role->name) }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>

                            <td class="py-4 px-6">
                                @if($partner->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        {{ __('common.active') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-400 border border-red-100 dark:border-red-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                        {{ __('common.inactive') }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="relative inline-block text-left">
                                    <flux:dropdown align="end">
                                        <flux:button variant="ghost" size="sm" class="-my-2 cursor-pointer">
                                            <flux:icon icon="ellipsis-horizontal" />
                                        </flux:button>
                                        
                                        <flux:menu>
                                            <flux:menu.item icon="pencil-square" wire:click="Edit({{ $partner->id }})" class="cursor-pointer">{{ __('common.btn_edit') }}</flux:menu.item>
                                            <flux:menu.item icon="trash" variant="danger" class="cursor-pointer">{{ __('common.btn_delete') }}</flux:menu.item>
                                        </flux:menu>
                                    </flux:dropdown>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination (Placeholder) -->
            <div class="px-6 py-4 mt-4 border-t border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                <div class="text-xs text-zinc-500 dark:text-zinc-400">
                    {{ $partners->links() }}
                </div>
            </div>
        </div>
    @endif
</div>
