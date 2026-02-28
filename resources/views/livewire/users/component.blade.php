<div class="w-full max-w-9xl mx-auto">
    @if($showForm)
        @include('livewire.users.form')
    @else
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <flux:heading size="xl" level="1" class="text-zinc-900 dark:text-white font-bold tracking-tight">
                    {{ __('common.users') }}
                </flux:heading>
                <flux:subheading size="lg" class="text-zinc-500 dark:text-zinc-400 mt-1">
                    {{ __('common.manage_system_users') }}
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
                            placeholder="{{ __('common.search_users') }}"
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
                            @foreach(\Spatie\Permission\Models\Role::all() as $role)
                                <flux:select.option value="{{ $role->name }}">{{ __('common.' . $role->name) }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                            <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider">{{ __('common.user_name') }}</th>
                            <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider">{{ __('common.user_email') }}</th>
                            <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider">{{ __('common.user_phone') }}</th>
                            <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider">{{ __('common.user_role') }}</th>
                            <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider">{{ __('common.user_status') }}</th>
                            <th class="py-4 px-6 text-xs font-semibold text-zinc-500 uppercase tracking-wider text-right">{{ __('common.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @foreach ($users as $user)
                        @if(auth()->user()->hasRole('Super Admin') || ! $user->hasRole('Super Admin'))
                        <tr class="group hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors duration-150 ease-in-out">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    @if($user->image)
                                        <img src="{{ Storage::url($user->image) }}" 
                                             alt="{{ $user->name }}"
                                             class="w-10 h-10 rounded-full object-cover border-2 border-zinc-200 dark:border-zinc-700">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm shadow-md">
                                            {{ $user->initials() }}
                                        </div>
                                    @endif
                                    <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-sm text-zinc-600 dark:text-zinc-400">
                                {{ $user->email }}
                            </td>
                            <td class="py-4 px-6 text-sm text-zinc-600 dark:text-zinc-400">
                                {{ $user->phone ?? '-' }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($user->roles as $role)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-50 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400 border border-purple-100 dark:border-purple-800">
                                        {{ ucfirst($role->name) }}
                                    </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                @if($user->account_state === 'Active')
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
                                            <flux:menu.item icon="pencil-square" wire:click="Edit({{ $user->id }})" class="cursor-pointer">{{ __('common.btn_edit') }}</flux:menu.item>
                                            @if(! (auth()->user()->hasRole('Super Admin') && auth()->user()->id == $user->id) )
                                                <flux:menu.item icon="trash" variant="danger" class="cursor-pointer">{{ __('common.btn_delete') }}</flux:menu.item>
                                            @endif
                                        </flux:menu>
                                    </flux:dropdown>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 mt-4 border-t border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                <div class="text-xs text-zinc-500 dark:text-zinc-400">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    @endif
</div>
