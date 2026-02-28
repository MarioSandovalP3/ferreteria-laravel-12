<div class="flex items-start max-md:flex-col">
    <div class="me-10 w-full pb-4 md:w-[220px]">
    <flux:navlist>
        <flux:navlist.item :href="route('profile.edit')" wire:navigate>
            {{ __('common.profile') }}
        </flux:navlist.item>

        <flux:navlist.item :href="route('user-password.edit')" wire:navigate>
            {{ __('common.password') }}
        </flux:navlist.item>

        @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
            <flux:navlist.item :href="route('two-factor.show')" wire:navigate>
                {{ __('common.two-factor-auth') }}
            </flux:navlist.item>
        @endif

        <flux:navlist.item :href="route('appearance.edit')" wire:navigate>
            {{ __('common.appearance') }}
        </flux:navlist.item>

        @if (Auth::check() && Auth::user()->role === 'Super Admin')
            <flux:navlist.item :href="route('regional-settings.edit')" wire:navigate>
                {{ __('common.regional-settings') }}
            </flux:navlist.item>
        @endif
    </flux:navlist>
</div>


    <flux:separator class="md:hidden" />

    <div class="flex-1 self-stretch max-md:pt-6">
        <flux:heading>{{ $heading ?? '' }}</flux:heading>
        <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>

        <!-- CAMBIA ESTA LÍNEA -->
        <div class="mt-5 w-full">
            {{ $slot }}
        </div>
    </div>
</div>