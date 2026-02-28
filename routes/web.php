<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Regional;
use App\Livewire\Dashboard;
use Illuminate\Support\Facades\Auth;
use App\Models\RegionalSettings;
use App\Livewire\Partners;
use App\Livewire\Home\Home;
use App\Livewire\Store;
use App\Livewire\Users;
use App\Livewire\Purchases;
use App\Livewire\PurchaseQuotations;
use App\Livewire\Sales;
use App\Livewire\SupplierPayments;
use App\Livewire\Expenses;
use App\Livewire\Inventory;

Route::get('/', Home::class)->name('home');



Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Route::get('/dashboard', Dashboard::class)
        ->name('dashboard');
    
    // General
    Route::get('admin/partners', Partners::class)->name('admin.partners');
    Route::get('admin/users', Users::class)->name('admin.users');
    
    // Purchases Section
    Route::get('admin/purchases/quotations', PurchaseQuotations::class)->name('admin.purchase-quotations');
    Route::get('admin/purchases/products', Purchases::class)->name('admin.purchases');
    Route::get('admin/purchases/payments', SupplierPayments::class)->name('admin.supplier-payments');
    Route::get('admin/purchases/expenses', Expenses::class)->name('admin.expenses');
    
    // Sales Section
    Route::get('admin/sales/orders', Sales::class)->name('admin.sales');
    
    // Inventory & Products Section
    Route::get('admin/inventory/movements', Inventory::class)->name('admin.inventory');
    Route::get('admin/inventory/products', \App\Livewire\Products::class)->name('admin.products');
    Route::get('admin/inventory/store', Store::class)->name('admin.store');
    
    // Configuration
    Route::get('admin/config/exchange-rates', \App\Livewire\ExchangeRates::class)->name('admin.exchange-rates');

    Volt::route('settings/profile', Profile::class)->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');
    Volt::route('settings/regional-settings', Regional::class)
    ->name('regional-settings.edit')
    ->middleware(['superadmin']);

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');

});

Route::get('/lang/{lang}', function ($lang) {
    // Validar idioma
    if (!in_array($lang, ['en', 'es'])) {
        return Redirect::back();
    }

    // Guardar en sesión (para visitantes)
    Session::put('locale', $lang);

    // Guardar en el usuario autenticado
    if (Auth::check()) {
        Auth::user()->update(['locale' => $lang]);
    }

    return Redirect::back();
})->name('lang.switch');
