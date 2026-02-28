<?php

namespace App\Livewire;

use App\Models\Store as StoreModel;
use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class Store extends Component
{
    use WithFileUploads;

    public $pageTitle = 'Store Settings';
    public $componentName = 'Store';
    
    public $store_id;
    public $name;
    public $slug;
    public $description;
    public $logo;
    public $banner;
    public $favicon;
    public $email;
    public $phone;
    public $whatsapp;
    public $address;
    public $business_hours = [];
    public $facebook;
    public $instagram;
    public $twitter;
    public $regional_settings_id;
    public $tax_rate = 18.00;
    public $shipping_cost = 0.00;
    public $free_shipping_threshold = 0.00;
    public $meta_title;
    public $meta_description;
    public $meta_keywords;
    public $is_active = true;
    public $maintenance_mode = false;

    // File uploads
    public $new_logo;
    public $new_banner;

    // Regional Settings Modal
    public $showRegionalModal = false;
    public $modal_editing = false; // Track if editing existing
    public $modal_regional_id; // ID of regional setting being edited
    public $modal_country_id;
    public $modal_date_format;
    public $modal_region_name;
    public $modal_city;
    public $modal_zip;
    public $modal_lat;
    public $modal_lon;

    public function mount()
    {
        $this->loadStore();
    }

    public function loadStore()
    {
        $store = StoreModel::first();
        
        if ($store) {
            $this->store_id = $store->id;
            $this->name = $store->name;
            $this->slug = $store->slug;
            $this->description = $store->description;
            $this->logo = $store->logo;
            $this->banner = $store->banner;
            $this->favicon = $store->favicon;
            $this->email = $store->email;
            $this->phone = $store->phone;
            $this->whatsapp = $store->whatsapp;
            $this->address = $store->address;
            $this->business_hours = $store->business_hours ?? [];
            $this->facebook = $store->facebook;
            $this->instagram = $store->instagram;
            $this->twitter = $store->twitter;
            $this->regional_settings_id = $store->regional_settings_id;
            $this->tax_rate = $store->tax_rate;
            $this->shipping_cost = $store->shipping_cost;
            $this->free_shipping_threshold = $store->free_shipping_threshold;
            $this->meta_title = $store->meta_title;
            $this->meta_description = $store->meta_description;
            $this->meta_keywords = $store->meta_keywords;
            $this->is_active = $store->is_active;
            $this->maintenance_mode = $store->maintenance_mode;
        }
    }

    public function render()
    {
        $regionalSettings = \App\Models\RegionalSettings::with('country')->get();
        $countries = \App\Models\Country::orderBy('name_es')->get();
        
        return view('livewire.store.component', [
            'regionalSettings' => $regionalSettings,
            'countries' => $countries,
        ]);
    }

    public function Update()
    {
        // Comprehensive backend validation
        $rules = [
            'name' => 'required|string|min:3|max:255',
            'description' => 'nullable|string|max:1000',
            'email' => [
                "required",
                "string",
                "lowercase",
                'regex:/^[\w\.\-]+@([\w\-]+\.)+[\w\-]{2,4}$/',
                "max:255",
            ],
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'regional_settings_id' => 'required|exists:regional_settings,id',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'shipping_cost' => 'required|numeric|min:0|max:999999.99',
            'free_shipping_threshold' => 'required|numeric|min:0|max:999999.99',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'new_logo' => 'nullable|image|max:2048',
            'new_banner' => 'nullable|image|max:2048',
        ];

        $messages = [
            "email.regex" => __("validation.email_format"),
            'name.required' => 'Store name is required',
            'name.min' => 'Store name must be at least 3 characters',
            'name.max' => 'Store name cannot exceed 255 characters',
            'description.max' => 'Description cannot exceed 1000 characters',
            'phone.max' => 'Phone cannot exceed 20 characters',
            'address.max' => 'Address cannot exceed 500 characters',
            'facebook.url' => 'Facebook must be a valid URL',
            'instagram.url' => 'Instagram must be a valid URL',
            'twitter.url' => 'Twitter must be a valid URL',
            'regional_settings_id.required' => 'Regional settings is required',
            'tax_rate.required' => 'Tax rate is required',
            'tax_rate.max' => 'Tax rate cannot exceed 100%',
            'shipping_cost.max' => 'Shipping cost is too high',
            'new_logo.image' => 'Logo must be an image',
            'new_logo.max' => 'Logo size cannot exceed 2MB',
            'new_banner.image' => 'Banner must be an image',
            'new_banner.max' => 'Banner size cannot exceed 2MB',
        ];

        $this->validate($rules, $messages);

        try {
            \DB::transaction(function () {
                $store = StoreModel::first() ?? new StoreModel();

                $slug = \Str::slug($this->name);

                $data = [
                    'name' => $this->name,
                    'slug' => $slug,
                    'description' => $this->description,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'whatsapp' => $this->whatsapp,
                    'address' => $this->address,
                    'business_hours' => $this->business_hours,
                    'facebook' => $this->facebook,
                    'instagram' => $this->instagram,
                    'twitter' => $this->twitter,
                    'regional_settings_id' => $this->regional_settings_id,
                    'tax_rate' => $this->tax_rate,
                    'shipping_cost' => $this->shipping_cost,
                    'free_shipping_threshold' => $this->free_shipping_threshold,
                    'meta_title' => $this->meta_title,
                    'meta_description' => $this->meta_description,
                    'meta_keywords' => $this->meta_keywords,
                    'is_active' => $this->is_active,
                    'maintenance_mode' => $this->maintenance_mode,
                ];

                /*
                |--------------------------------------------------------------------------
                | LOGO
                |--------------------------------------------------------------------------
                */
                if ($this->new_logo) {

                    $oldLogo = $store->logo;
                    $oldIco  = $store->favicon;

                    $customFileName = $slug . '-' . uniqid();

                    // Crear directorio si no existe
                    if (!file_exists(storage_path('app/public/store'))) {
                        mkdir(storage_path('app/public/store'), 0755, true);
                    }

                    // Crear instancia de ImageManager
                    $manager = new ImageManager(new Driver());

                    // Procesar Logo
                    $image = $manager->read($this->new_logo->getRealPath());
                    $image->scale(width: 400);
                    $image->toWebp(90)->save(storage_path('app/public/store/' . $customFileName . '.webp'));

                    $data['logo'] = 'store/' . $customFileName . '.webp';

                    // Generar favicon .ico
                    $favicon = $manager->read($this->new_logo->getRealPath());
                    $favicon->scale(width: 64, height: 64);
                    $favicon->save(storage_path('app/public/store/' . $customFileName . '.ico'));

                    $data['favicon'] = 'store/' . $customFileName . '.ico';

                    // Borrar archivos antiguos
                    if ($oldLogo && file_exists(storage_path('app/public/' . $oldLogo))) {
                        unlink(storage_path('app/public/' . $oldLogo));
                    }
                    if ($oldIco && file_exists(storage_path('app/public/' . $oldIco))) {
                        unlink(storage_path('app/public/' . $oldIco));
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | BANNER
                |--------------------------------------------------------------------------
                */
                if ($this->new_banner) {

                    $oldBanner = $store->banner;

                    $customFileNameBanner = $slug . '-banner-' . uniqid();

                    // Crear directorio si no existe
                    if (!file_exists(storage_path('app/public/store'))) {
                        mkdir(storage_path('app/public/store'), 0755, true);
                    }

                    // Crear instancia de ImageManager
                    $manager = new ImageManager(new Driver());

                    $banner = $manager->read($this->new_banner->getRealPath());
                    $banner->scale(width: 1920);
                    $banner->toWebp(80)->save(storage_path('app/public/store/' . $customFileNameBanner . '.webp'));

                    $data['banner'] = 'store/' . $customFileNameBanner . '.webp';

                    if ($oldBanner && file_exists(storage_path('app/public/' . $oldBanner))) {
                        unlink(storage_path('app/public/' . $oldBanner));
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | Guardar
                |--------------------------------------------------------------------------
                */
                if ($store->exists) {
                    $store->update($data);
                } else {
                    $store = StoreModel::create($data);
                    $this->store_id = $store->id;
                }

                \Cache::forget('store_data');
            });

            $this->dispatch('msg', __('common.store_updated_successfully'));
            $this->loadStore();

        } catch (\Exception $e) {
            // Log technical error
            \Log::error('Store update failed', [
                'store_id' => $this->store_id ?? 'new',
                'name' => $this->name,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Show user-friendly error
            $this->dispatch('msg', __('common.store_save_error'));
        }
    }

    public function removeLogo(): void
    {
        $store = StoreModel::first();

        if ($store && $store->logo && file_exists(storage_path('app/public/' . $store->logo))) {
            unlink(storage_path('app/public/' . $store->logo));
        }

        if ($store && $store->favicon && file_exists(storage_path('app/public/' . $store->favicon))) {
            unlink(storage_path('app/public/' . $store->favicon));
        }

        if ($store) {
            $store->logo = null;
            $store->favicon = null;
            $store->save();
        }

        $this->logo = null;
        $this->favicon = null;
        $this->new_logo = null;

        \Cache::forget('store_data');

        $this->dispatch('msg', 'Logo removed successfully');
    }

    public function removeBanner(): void
    {
        $store = StoreModel::first();

        if ($store && $store->banner && file_exists(storage_path('app/public/' . $store->banner))) {
            unlink(storage_path('app/public/' . $store->banner));
        }

        if ($store) {
            $store->banner = null;
            $store->save();
        }

        $this->banner = null;
        $this->new_banner = null;

        \Cache::forget('store_data');

        $this->dispatch('msg', 'Banner removed successfully');
    }

    public function resetUI()
    {
        // Reset file uploads
        $this->reset([
            'new_logo',
            'new_banner',
        ]);
        
        // Reset validation errors
        $this->resetValidation();
        
        // Reload store data from database
        $this->loadStore();
        
        $this->dispatch('msg', 'Form reset successfully');
    }

    // Regional Settings Modal Methods
    public function openRegionalModal()
    {
        // Check if there's a selected regional setting to edit
        if ($this->regional_settings_id) {
            $regionalSetting = \App\Models\RegionalSettings::find($this->regional_settings_id);
            
            if ($regionalSetting) {
                $this->modal_editing = true;
                $this->modal_regional_id = $regionalSetting->id;
                $this->modal_country_id = $regionalSetting->country_id;
                $this->modal_date_format = $regionalSetting->date_format ?? 'Y-m-d';
                
                // Load region data based on country_id
                $region = \App\Models\Region::where('country_id', $regionalSetting->country_id)->first();
                
                if ($region) {
                    $this->modal_region_name = $region->region_name;
                    $this->modal_city = $region->city;
                    $this->modal_zip = $region->zip;
                    $this->modal_lat = $region->lat;
                    $this->modal_lon = $region->lon;
                } else {
                    // No region data yet, set to null
                    $this->modal_region_name = null;
                    $this->modal_city = null;
                    $this->modal_zip = null;
                    $this->modal_lat = null;
                    $this->modal_lon = null;
                }
            } else {
                // No existing setting, create new
                $this->resetModalFields();
            }
        } else {
            // No selection, create new
            $this->resetModalFields();
        }
        
        $this->showRegionalModal = true;
        $this->resetValidation();
        
        // Force Livewire to refresh the component
        $this->dispatch('modal-opened');
    }

    private function resetModalFields()
    {
        $this->modal_editing = false;
        $this->modal_regional_id = null;
        $this->modal_country_id = null;
        $this->modal_date_format = 'Y-m-d';
        $this->modal_region_name = null;
        $this->modal_city = null;
        $this->modal_zip = null;
        $this->modal_lat = null;
        $this->modal_lon = null;
    }

    public function saveRegionalSettings()
    {
        $this->validate([
            'modal_country_id' => 'required|exists:countries,id',
            'modal_region_name' => 'nullable|string|max:255',
            'modal_city' => 'nullable|string|max:255',
            'modal_zip' => 'nullable|string|max:20',
        ]);

        try {
            \DB::transaction(function () {
                if ($this->modal_editing && $this->modal_regional_id) {
                    // Update existing regional setting
                    $regionalSetting = \App\Models\RegionalSettings::find($this->modal_regional_id);
                    
                    if ($regionalSetting) {
                        // Update regional settings (only country_id if changed)
                        $regionalSetting->update([
                            'country_id' => $this->modal_country_id,
                        ]);
                        
                        // Update or create region data
                        \App\Models\Region::updateOrCreate(
                            ['country_id' => $this->modal_country_id],
                            [
                                'region_name' => $this->modal_region_name,
                                'city' => $this->modal_city,
                                'zip' => $this->modal_zip,
                                'lat' => null,
                                'lon' => null,
                            ]
                        );
                    }
                } else {
                    // Create new regional setting
                    $regionalSetting = \App\Models\RegionalSettings::create([
                        'country_id' => $this->modal_country_id,
                        'date_format' => 'Y-m-d',
                    ]);
                    
                    // Create region data
                    \App\Models\Region::updateOrCreate(
                        ['country_id' => $this->modal_country_id],
                        [
                            'region_name' => $this->modal_region_name,
                            'city' => $this->modal_city,
                            'zip' => $this->modal_zip,
                            'lat' => null,
                            'lon' => null,
                        ]
                    );
                    
                    // Auto-select the newly created regional setting
                    $this->regional_settings_id = $regionalSetting->id;
                }
            });

            $message = $this->modal_editing ? __('common.regional_settings_updated') : __('common.regional_settings_created');
            $this->dispatch('msg', $message);
            $this->showRegionalModal = false;
        } catch (\Exception $e) {
            // Log technical error
            \Log::error('Regional settings save failed', [
                'regional_id' => $this->modal_regional_id ?? 'new',
                'country_id' => $this->modal_country_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Show user-friendly error
            $this->dispatch('msg', __('common.regional_settings_save_error'));
        }
    }

    public function closeRegionalModal()
    {
        $this->showRegionalModal = false;
        $this->reset([
            'modal_country_id',
            'modal_date_format',
            'modal_region_name',
            'modal_city',
            'modal_zip',
            'modal_lat',
            'modal_lon'
        ]);
        $this->resetValidation();
    }
}
