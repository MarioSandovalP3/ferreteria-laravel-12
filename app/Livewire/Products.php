<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class Products extends Component
{
    use WithFileUploads, WithPagination;

    // Product properties
    public $product_id;
    public $category_id;
    public $product_type = 'physical';  // physical, service, digital
    public $name;
    public $sku;
    public $barcode;
    public $slug;
    public $short_description;
    public $description;
    public $price;
    public $compare_at_price;
    public $cost;
    public $tax_rate = 16.00;  // Default Venezuelan IVA rate
    public $is_tax_exempt = false;
    public $sale_price;
    public $stock = 0;
    public $low_stock_threshold = 5;
    public $track_inventory = true;
    public $allow_backorder = false;
    public $brand_id;
    public $model;
    
    // Physical product fields
    public $weight;
    public $length;
    public $width;
    public $height;
    public $requires_shipping = true;
    
    // Service fields
    public $duration;
    public $booking_required = false;
    public $max_bookings_per_day;
    
    // Digital product fields
    public $file_type;
    public $file_path;
    public $download_url;
    public $preview_url;
    public $file_size;
    public $version;
    public $download_limit;
    public $download_expiry_days;
    
    // Digital file uploads
    public $digital_file;  // For uploading the main file
    public $preview_file;  // For uploading preview/demo file
    
    // Status fields
    public $is_active = true;
    public $is_featured = false;
    public $is_new = false;
    
    // SEO fields
    public $meta_title;
    public $meta_description;
    public $meta_keywords;

    // Image handling
    public $images = [];  // New uploads
    public $existing_images = [];  // Already saved images
    public $featured_image_index = 0;  // Which image is featured

    // Currency Exchange
    public $show_local_price = false; // Toggle to show/hide local price

    // Filters
    public $search = '';
    public $category_filter = '';
    public $status_filter = '';
    public $product_type_filter = ''; // New filter
    public $showForm = false;
    public $editMode = false;
    
    // Brand search
    public $brandSearch = '';
    public $showBrandDropdown = false;
    
    // Brand modal
    public $showBrandModal = false;
    public $brandModalMode = 'create'; // 'create' or 'edit'
    public $brandModalId = null;
    public $brandModalName = '';
    public $brandModalDescription = '';
    
    // Category search
    public $categorySearch = '';
    public $showCategoryDropdown = false;
    
    // Variant support
    public $is_variant = false;
    public $parent_id = null;
    public $variant_attributes = [];
    public $showVariantForm = false;

    protected $queryString = ['search', 'category_filter', 'status_filter', 'product_type_filter'];

    public function mount()
    {
        //
    }

    // Reset pagination when search changes
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Reset pagination when category filter changes
    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    // Reset pagination when status filter changes
    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    // Reset pagination and category filter when product type filter changes
    public function updatingProductTypeFilter()
    {
        $this->category_filter = ''; // Reset category when type changes
        $this->resetPage();
    }

    // Computed property for filtered brands
    public function getFilteredBrandsProperty()
    {
        return \App\Models\Brand::where('is_active', true)
            ->when($this->brandSearch, function ($query) {
                $query->where('name', 'like', '%' . $this->brandSearch . '%');
            })
            ->orderBy('name')
            ->limit(50)
            ->get();
    }

    public function selectBrand($brandId, $brandName)
    {
        $this->brand_id = $brandId;
        $this->brandSearch = $brandName;
        $this->showBrandDropdown = false;
    }

    public function openBrandModal($mode = 'create', $brandId = null)
    {
        $this->brandModalMode = $mode;
        $this->brandModalId = $brandId;
        
        if ($mode === 'edit' && $brandId) {
            $brand = \App\Models\Brand::find($brandId);
            if ($brand) {
                $this->brandModalName = $brand->name;
                $this->brandModalDescription = $brand->description;
            }
        } else {
            $this->brandModalName = '';
            $this->brandModalDescription = '';
        }
        
        $this->showBrandModal = true;
    }
    
    public function closeBrandModal()
    {
        $this->showBrandModal = false;
        $this->brandModalName = '';
        $this->brandModalDescription = '';
        $this->brandModalId = null;
    }
    
    public function saveBrand()
    {
        $this->validate([
            'brandModalName' => 'required|string|max:255',
        ]);
        
        try {
            if ($this->brandModalMode === 'edit' && $this->brandModalId) {
                // Update existing brand
                $brand = \App\Models\Brand::find($this->brandModalId);
                $brand->update([
                    'name' => $this->brandModalName,
                    'slug' => \Illuminate\Support\Str::slug($this->brandModalName),
                    'description' => $this->brandModalDescription,
                ]);
                
                // Update the search field
                $this->brandSearch = $brand->name;
                
                $this->dispatch('brand-updated', ['message' => 'Marca actualizada exitosamente']);
            } else {
                // Create new brand
                $brand = \App\Models\Brand::create([
                    'name' => $this->brandModalName,
                    'slug' => \Illuminate\Support\Str::slug($this->brandModalName),
                    'description' => $this->brandModalDescription,
                    'is_active' => true,
                ]);
                
                // Auto-select the new brand
                $this->brand_id = $brand->id;
                $this->brandSearch = $brand->name;
                $this->showBrandDropdown = false;
                
                $this->dispatch('brand-created', ['message' => 'Marca creada y seleccionada exitosamente']);
            }
            
            // Close modal
            $this->closeBrandModal();
            
        } catch (\Exception $e) {
            $this->addError('brandModalName', 'Error al guardar la marca: ' . $e->getMessage());
        }
    }
    
    public function clearBrand()
    {
        $this->brand_id = null;
        $this->brandSearch = '';
    }

    public function updatedBrandSearch()
    {
        $this->showBrandDropdown = !empty($this->brandSearch);
    }

    // Computed property for filtered categories
    public function getFilteredCategoriesProperty()
    {
        return \App\Models\Category::where('is_active', true)
            ->where('product_type', $this->product_type) // Filter by product type
            ->when($this->categorySearch, function ($query) {
                $query->where('name', 'like', '%' . $this->categorySearch . '%');
            })
            ->orderBy('name')
            ->limit(50)
            ->get();
    }

    public function selectCategory($categoryId, $categoryName)
    {
        $this->category_id = $categoryId;
        $this->categorySearch = $categoryName;
        $this->showCategoryDropdown = false;
    }

    public function clearCategory()
    {
        $this->category_id = null;
        $this->categorySearch = '';
    }

    public function updatedCategorySearch()
    {
        $this->showCategoryDropdown = !empty($this->categorySearch);
    }
    
    // When category changes, reset variant attributes
    public function updatedCategoryId()
    {
        $this->variant_attributes = [];
        
        // Initialize variant attributes with empty values
        if ($this->category_id) {
            $category = Category::find($this->category_id);
            if ($category && $category->attribute_schema) {
                foreach ($category->required_attributes as $attr) {
                    $this->variant_attributes[$attr['key']] = '';
                }
                foreach ($category->optional_attributes as $attr) {
                    $this->variant_attributes[$attr['key']] = '';
                }
            }
        }
    }
    
    // When product type changes, reset category
    public function updatedProductType()
    {
        $this->category_id = null;
        $this->categorySearch = '';
        $this->variant_attributes = [];
    }
    
    // Get current category attributes
    public function getCategoryAttributesProperty()
    {
        if (!$this->category_id) {
            return ['required' => [], 'optional' => []];
        }
        
        $category = Category::find($this->category_id);
        
        if (!$category || !$category->attribute_schema) {
            return ['required' => [], 'optional' => []];
        }
        
        return [
            'required' => $category->required_attributes ?? [],
            'optional' => $category->optional_attributes ?? [],
        ];
    }
    
    // Get store's country ID
    public function getStoreCountryIdProperty()
    {
        $store = \App\Models\Store::first();
        return $store?->regionalSettings?->country_id;
    }
    
    // Get current exchange rate for store's country
    public function getCurrentRateProperty()
    {
        if (!$this->storeCountryId) {
            return null;
        }
        
        $rate = \App\Models\ExchangeRate::getCurrentRate($this->storeCountryId);
        return $rate;
    }
    
    // Get store's country
    public function getSelectedCountryProperty()
    {
        if (!$this->storeCountryId) {
            return null;
        }
        
        return \App\Models\Country::find($this->storeCountryId);
    }
    
    // Convert price to local currency
    public function getPriceLocalProperty()
    {
        if (!$this->price || !$this->storeCountryId) {
            return 0;
        }
        
        return \App\Models\ExchangeRate::convertToLocal($this->price, $this->storeCountryId);
    }
    
    // Convert sale price to local currency
    public function getSalePriceLocalProperty()
    {
        if (!$this->sale_price || !$this->storeCountryId) {
            return 0;
        }
        
        return \App\Models\ExchangeRate::convertToLocal($this->sale_price, $this->storeCountryId);
    }
    
    // Convert compare price to local currency
    public function getComparePriceLocalProperty()
    {
        if (!$this->compare_at_price || !$this->storeCountryId) {
            return 0;
        }
        
        return \App\Models\ExchangeRate::convertToLocal($this->compare_at_price, $this->storeCountryId);
    }


    public function render()
    {
        $query = Product::active()->with('category');

        // Search
        if ($this->search) {
            $query->search($this->search);
        }

        // Product type filter
        if ($this->product_type_filter) {
            $query->where('product_type', $this->product_type_filter);
        }

        // Category filter
        if ($this->category_filter) {
            $query->where('category_id', $this->category_filter);
        }

        // Status filter
        if ($this->status_filter === 'active') {
            $query->where('is_active', true);
        } elseif ($this->status_filter === 'inactive') {
            $query->where('is_active', false);
        } elseif ($this->status_filter === 'featured') {
            $query->where('is_featured', true);
        }

        $products = $query->latest()->paginate(10);
        
        // Filter categories by product type if selected
        $categories = Category::query()
            ->when($this->product_type_filter, function($q) {
                $q->where('product_type', $this->product_type_filter);
            })
            ->orderBy('name')
            ->get();

        return view('livewire.products.component', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        $this->resetForm();
        $this->showForm = true;
        $this->editMode = false;
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        
        $this->product_id = $product->id;
        $this->category_id = $product->category_id;
        $this->product_type = $product->product_type ?? 'physical'; // Load product type
        $this->name = $product->name;
        $this->sku = $product->sku;
        $this->barcode = $product->barcode;
        $this->slug = $product->slug;
        $this->short_description = $product->short_description;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->compare_at_price = $product->compare_at_price;
        $this->cost = $product->cost;
        $this->sale_price = $product->sale_price;
        $this->stock = $product->stock;
        $this->low_stock_threshold = $product->low_stock_threshold;
        $this->track_inventory = $product->track_inventory;
        $this->allow_backorder = $product->allow_backorder;
        $this->brand_id = $product->brand_id;
        $this->model = $product->model;
        $this->weight = $product->weight;
        $this->is_active = $product->is_active;
        $this->is_featured = $product->is_featured;
        $this->is_new = $product->is_new;
        $this->meta_title = $product->meta_title;
        $this->meta_description = $product->meta_description;
        $this->meta_keywords = $product->meta_keywords;
        
        // Load category name for search field
        if ($product->category) {
            $this->categorySearch = $product->category->name;
        }
        
        // Load brand name for search field
        if ($product->brand) {
            $this->brandSearch = $product->brand->name;
        }
        
        // Variant support
        $this->is_variant = $product->is_variant;
        $this->parent_id = $product->parent_id;
        $this->variant_attributes = $product->variant_attributes ?? [];
        
        // Load existing images
        $this->existing_images = $product->images ?? [];
        
        $this->showForm = true;
        $this->editMode = true;
    }

    public function save()
    {
        // Comprehensive backend validation
        $rules = [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|min:3|max:255',
            'sku' => 'nullable|string|max:100',
            'barcode' => 'nullable|string|max:100',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string|max:5000',
            'price' => 'required|numeric|min:0|max:9999999.99',
            'compare_at_price' => 'nullable|numeric|min:0|max:9999999.99',
            'cost' => 'nullable|numeric|min:0|max:9999999.99',
            'sale_price' => 'nullable|numeric|min:0|max:9999999.99',
            'stock' => 'required|integer|min:0|max:999999',
            'low_stock_threshold' => 'nullable|integer|min:0|max:999',
            'weight' => 'nullable|numeric|min:0|max:99999',
            'model' => 'nullable|string|max:100',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'images.*' => 'nullable|image|max:2048',
        ];
        
        // Validate variant attributes if category has schema
        $category = Category::find($this->category_id);
        if ($category && $category->attribute_schema) {
            foreach ($category->required_attributes as $attr) {
                $rules["variant_attributes.{$attr['key']}"] = 'required';
            }
        }

        $messages = [
            'category_id.required' => 'Category is required',
            'category_id.exists' => 'Selected category does not exist',
            'name.required' => 'Product name is required',
            'name.min' => 'Product name must be at least 3 characters',
            'name.max' => 'Product name cannot exceed 255 characters',
            'price.required' => 'Price is required',
            'price.min' => 'Price must be greater than or equal to 0',
            'price.max' => 'Price is too high',
            'stock.required' => 'Stock is required',
            'stock.max' => 'Stock cannot exceed 999,999',
            'images.*.image' => 'File must be an image',
            'images.*.max' => 'Image size cannot exceed 2MB',
        ];
        
        $this->validate($rules, $messages);

        try {
            \DB::transaction(function () {
                // Generate slug if not editing
                if (!$this->editMode) {
                    $this->slug = Str::slug($this->name);
                }

                $data = [
                    'category_id' => $this->category_id,
                    'name' => $this->name,
                    'sku' => $this->sku ?: 'PRD-' . strtoupper(Str::random(8)),
                    'barcode' => $this->barcode,
                    'slug' => $this->slug ?: Str::slug($this->name),
                    'short_description' => $this->short_description,
                    'description' => $this->description,
                    'price' => $this->price,
                    'compare_at_price' => $this->compare_at_price,
                    'cost' => $this->cost,
                    'sale_price' => $this->sale_price,
                    'stock' => $this->stock,
                    'low_stock_threshold' => $this->low_stock_threshold,
                    'track_inventory' => $this->track_inventory,
                    'allow_backorder' => $this->allow_backorder,
                    'brand_id' => $this->brand_id,
                    'model' => $this->model,
                    'weight' => $this->weight,
                    'is_active' => $this->is_active,
                    'is_featured' => $this->is_featured,
                    'is_new' => $this->is_new,
                    'meta_title' => $this->meta_title,
                    'meta_description' => $this->meta_description,
                    'meta_keywords' => $this->meta_keywords,
                    'is_variant' => $this->is_variant,
                    'parent_id' => $this->parent_id,
                    'variant_attributes' => !empty(array_filter($this->variant_attributes)) ? $this->variant_attributes : null,
                ];

                if ($this->editMode) {
                    $product = Product::findOrFail($this->product_id);
                    $product->update($data);
                } else {
                    $product = Product::create($data);
                }

                // Process images
                if (!empty($this->images)) {
                    $this->processImages($product);
                }
            });

            $this->dispatch('msg', __($this->editMode ? 'common.product_updated_successfully' : 'common.product_created_successfully'));
            $this->resetForm();
            $this->showForm = false;
        } catch (\Exception $e) {
            // Log technical error
            \Log::error('Product save failed', [
                'product_id' => $this->product_id ?? 'new',
                'name' => $this->name,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Show user-friendly error
            $this->dispatch('msg', __('common.product_save_error'));
        }
    }

    protected function processImages($product)
    {
        // Create directory if not exists
        if (!file_exists(storage_path('app/public/products'))) {
            mkdir(storage_path('app/public/products'), 0755, true);
        }

        $manager = new ImageManager(new Driver());
        $savedImages = $this->existing_images ?? [];

        foreach ($this->images as $index => $image) {
            $filename = $product->slug . '-' . uniqid() . '.webp';
            
            $img = $manager->read($image->getRealPath());
            $img->scale(width: 800);
            $img->toWebp(90)->save(storage_path('app/public/products/' . $filename));
            
            $savedImages[] = 'products/' . $filename;
        }

        // Set featured image
        $featuredImage = $savedImages[$this->featured_image_index] ?? $savedImages[0] ?? null;

        $product->update([
            'images' => $savedImages,
            'featured_image' => $featuredImage,
        ]);
    }

    public function removeImage($index)
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);
        
        // Adjust featured index if needed
        if ($this->featured_image_index >= count($this->images)) {
            $this->featured_image_index = max(0, count($this->images) - 1);
        }
    }

    public function removeExistingImage($index)
    {
        if (isset($this->existing_images[$index])) {
            $imagePath = $this->existing_images[$index];
            
            // Delete file from storage
            if (file_exists(storage_path('app/public/' . $imagePath))) {
                unlink(storage_path('app/public/' . $imagePath));
            }
            
            unset($this->existing_images[$index]);
            $this->existing_images = array_values($this->existing_images);
            
            // Update product
            if ($this->editMode && $this->product_id) {
                $product = Product::find($this->product_id);
                if ($product) {
                    $product->update([
                        'images' => $this->existing_images,
                        'featured_image' => $this->existing_images[0] ?? null,
                    ]);
                }
            }
        }
    }

    public function setFeaturedImage($index)
    {
        $this->featured_image_index = $index;
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        
        $this->dispatch('msg', 'Product deleted successfully');
    }

    public function cancel()
    {
        $this->resetForm();
        $this->showForm = false;
    }

    protected function resetForm()
    {
        $this->reset([
            'product_id', 'category_id', 'name', 'sku', 'barcode', 'slug',
            'short_description', 'description', 'price', 'compare_at_price',
            'cost', 'sale_price', 'stock', 'low_stock_threshold',
            'track_inventory', 'allow_backorder', 'brand_id', 'model',
            'weight', 'is_active', 'is_featured', 'is_new',
            'meta_title', 'meta_description', 'meta_keywords',
            'images', 'existing_images', 'featured_image_index',
            'is_variant', 'parent_id', 'variant_attributes'
        ]);
        
        $this->is_active = true;
        $this->track_inventory = true;
        $this->stock = 0;
        $this->low_stock_threshold = 5;
        $this->featured_image_index = 0;
        
        $this->resetValidation();
    }
}
