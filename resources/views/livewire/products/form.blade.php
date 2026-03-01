{{-- Product Form --}}
<div class="max-w-6xl mx-auto">
    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-800">
        <form wire:submit="save">
            {{-- Header --}}
            <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">
                            {{ $editMode ? __('common.edit_product') : __('common.new_product') }}
                        </h2>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                            {{ $editMode ? __('common.update_product_information') : __('common.add_a_new_product_to_your_catalog') }}
                        </p>
                    </div>
                    <flux:button wire:click="cancel" variant="ghost" icon="x-mark">
                        {{ __('common.close') }}
                    </flux:button>
                </div>
            
            {{-- Success Notification --}}
            <div 
                x-data="{ show: false, message: '' }"
                @brand-created.window="show = true; message = $event.detail.message; setTimeout(() => show = false, 3000)"
                @brand-updated.window="show = true; message = $event.detail.message; setTimeout(() => show = false, 3000)"
                x-show="show"
                x-transition
                class="mx-6 mt-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm font-medium text-green-800 dark:text-green-300" x-text="message"></p>
                </div>
            </div>
            </div>

            <div class="p-6 space-y-6">
                {{-- Basic Information --}}
                <div class="border-b border-zinc-200 dark:border-zinc-800 pb-6">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">{{ __('common.basic_information') }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Name --}}
                        <div class="md:col-span-2">
                            <flux:input 
                                wire:model="name" 
                                label="{{ __('common.product_name') }}" 
                                placeholder="{{ __('common.enter_product_name') }}"
                                required
                            />
                        </div>

                        {{-- SKU --}}
                        <div>
                            <flux:input 
                                wire:model="sku" 
                                label="{{ __('common.sku') }}" 
                                placeholder="{{ __('common.auto_generated_if_empty') }}"
                            />
                        </div>

                        {{-- Barcode --}}
                        <div>
                            <flux:input 
                                wire:model="barcode" 
                                label="{{ __('common.barcode') }}" 
                                placeholder="{{ __('common.enter_barcode') }}"
                            />
                            <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">{{ __('common.barcode_help') }}</p>
                        </div>

                        {{-- Category --}}
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                {{ __('common.category') }} <span class="text-red-500">*</span>
                            </label>
                            
                            <div class="relative" x-data="{ open: @entangle('showCategoryDropdown') }">
                                {{-- Search Input --}}
                                <input 
                                    type="text"
                                    wire:model.live="categorySearch"
                                    @click="open = true"
                                    @click.away="open = false"
                                    placeholder="{{ __('common.search_category') }}"
                                    class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                    required>
                                
                                {{-- Clear Button --}}
                                @if($category_id)
                                    <button 
                                        type="button"
                                        wire:click="clearCategory"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                @endif
                                
                                {{-- Dropdown --}}
                                <div 
                                    x-show="open"
                                    x-transition
                                    class="absolute z-50 w-full mt-1 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                    @if($this->filteredCategories->count() > 0)
                                        @foreach($this->filteredCategories as $category)
                                            <button
                                                type="button"
                                                wire:click="selectCategory({{ $category->id }}, '{{ $category->name }}')"
                                                class="w-full px-4 py-2 text-left hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-900 dark:text-white transition-colors">
                                                {{ $category->name }}
                                            </button>
                                        @endforeach
                                    @else
                                        <div class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
                                            {{ __('common.no_categories_found') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Product Type --}}
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                {{ __('common.product_type') }} <span class="text-red-500">*</span>
                            </label>
                            <select 
                                wire:model.live="product_type"
                                class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                required>
                                <option value="physical">{{ __('common.physical_product') }}</option>
                                <option value="service">{{ __('common.service_product') }}</option>
                                <option value="digital">{{ __('common.digital_product') }}</option>
                            </select>
                            @error('product_type')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Short Description --}}
                        <div class="md:col-span-2">
                            <flux:textarea 
                                wire:model="short_description" 
                                label="{{ __('common.short_description') }}" 
                                placeholder="{{ __('common.brief_product_description') }}"
                                rows="2"
                            />
                        </div>

                        {{-- Full Description --}}
                        <div class="md:col-span-2">
                            <flux:textarea 
                                wire:model="description" 
                                label="{{ __('common.full_description') }}" 
                                placeholder="{{ __('common.detailed_product_description') }}"
                                rows="4"
                            />
                        </div>
                    </div>
                </div>

                {{-- Variant Attributes (Dynamic based on Category) --}}
                @if($category_id && count($this->categoryAttributes['required']) > 0)
                <div class="border-b border-zinc-200 dark:border-zinc-800 pb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
                            Atributos del Producto
                        </h3>
                        <span class="text-xs text-zinc-500 dark:text-zinc-400 bg-blue-100 dark:bg-blue-900/30 px-2 py-1 rounded">
                            Categoría: {{ $categorySearch }}
                        </span>
                    </div>
                    
                    {{-- Brand Field (moved here) --}}
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                {{ __('common.brand') }}
                            </label>
                            <div class="flex gap-2">
                                <button 
                                    type="button"
                                    wire:click="openBrandModal('create')"
                                    class="text-xs px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Nueva Marca
                                </button>
                                @if($brand_id)
                                    <button 
                                        type="button"
                                        wire:click="openBrandModal('edit', {{ $brand_id }})"
                                        class="text-xs px-3 py-1 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Editar
                                    </button>
                                @endif
                            </div>
                        </div>
                        
                        <div class="relative" x-data="{ open: @entangle('showBrandDropdown') }">
                            {{-- Search Input --}}
                            <input 
                                type="text"
                                wire:model.live="brandSearch"
                                @click="open = true"
                                @click.away="open = false"
                                placeholder="{{ __('common.search_brand') }}"
                                class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                            
                            {{-- Clear Button --}}
                            @if($brand_id)
                                <button 
                                    type="button"
                                    wire:click="clearBrand"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            @endif
                            
                            {{-- Dropdown --}}
                            <div 
                                x-show="open"
                                x-transition
                                class="absolute z-50 w-full mt-1 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                @if($this->filteredBrands->count() > 0)
                                    @foreach($this->filteredBrands as $brand)
                                        <button
                                            type="button"
                                            wire:click="selectBrand({{ $brand->id }}, '{{ $brand->name }}')"
                                            class="w-full px-4 py-2 text-left hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-900 dark:text-white transition-colors">
                                            {{ $brand->name }}
                                        </button>
                                    @endforeach
                                @else
                                    <div class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
                                        {{ __('common.no_brands_found') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        @error('brand_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Required Attributes --}}
                        @foreach($this->categoryAttributes['required'] as $attr)
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                    {{ $attr['label'] }} <span class="text-red-500">*</span>
                                </label>
                                
                                @if($attr['type'] === 'select')
                                    <select 
                                        wire:model="variant_attributes.{{ $attr['key'] }}"
                                        class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                        required>
                                        <option value="">Seleccionar {{ $attr['label'] }}</option>
                                        @foreach($attr['options'] ?? [] as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                @elseif($attr['type'] === 'number')
                                    <div x-data="moneyInput({{ $variant_attributes[$attr['key']] ?? 0 }}, '', 0)">
                                        <input 
                                            type="text"
                                            x-model="formatted"
                                            @input="updateValue($event)"
                                            @click="forceEnd($el)"
                                            @keydown.arrow-left.prevent
                                            @keydown.arrow-right.prevent
                                            data-field="variant_attributes.{{ $attr['key'] }}"
                                            inputmode="numeric"
                                            placeholder="Ej: {{ $attr['key'] === 'piezas' ? '120' : ($attr['key'] === 'edad_recomendada' ? '3' : '100') }}"
                                            class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                            required>
                                    </div>
                                @else
                                    @php
                                        $placeholder = match($attr['key']) {
                                            // Tecnología
                                            'modelo' => 'Ej: Galaxy A54, iPhone 15 Pro, ThinkPad X1',
                                            'capacidad' => 'Ej: 256GB, 512GB, 1TB',
                                            'ram' => 'Ej: 8GB, 16GB, 32GB',
                                            'almacenamiento' => 'Ej: 512GB SSD, 1TB HDD',
                                            'procesador' => 'Ej: Intel Core i7, AMD Ryzen 5',
                                            'pantalla' => 'Ej: 6.4 pulgadas, 15.6" Full HD',
                                            'tarjeta_grafica' => 'Ej: NVIDIA RTX 3060, AMD Radeon',
                                            'sistema_operativo' => 'Ej: Android 13, iOS 17, Windows 11',
                                            'bateria' => 'Ej: 5000mAh, 8 horas',
                                            'camara' => 'Ej: 50MP, Triple cámara',
                                            'conectividad' => 'Ej: WiFi, Bluetooth 5.0, 5G',
                                            'cancelacion_ruido' => 'Ej: Sí, No',
                                            'potencia' => 'Ej: 1200W, 800W',
                                            
                                            // Ropa y Calzado
                                            'color' => 'Ej: Negro, Blanco, Azul Marino',
                                            'material' => 'Ej: Algodón 100%, Cuero genuino',
                                            'material_exterior' => 'Ej: Cuero genuino, Sintético',
                                            'material_suela' => 'Ej: Goma antideslizante, EVA',
                                            'estilo' => 'Ej: Casual, Formal, Deportivo',
                                            
                                            // Hogar
                                            'dimensiones' => 'Ej: 40x20x15 cm, 2m x 1.5m',
                                            'peso_maximo' => 'Ej: 120kg, 200kg',
                                            'voltaje' => 'Ej: 110V, 220V',
                                            
                                            // Deportes
                                            'deporte' => 'Ej: Fútbol, Basketball, Tenis',
                                            'peso' => 'Ej: 1.5kg, 500g',
                                            
                                            // Belleza
                                            'contenido' => 'Ej: 150ml, 250g, 50ml',
                                            'ingredientes_principales' => 'Ej: Ácido Hialurónico, Vitamina C',
                                            'tono' => 'Ej: Beige Natural, Rosa Suave',
                                            
                                            // Juguetes y Bebés
                                            'piezas' => 'Ej: 120, 500',
                                            'edad' => 'Ej: 0-6 meses, 1-3 años',
                                            
                                            // Libros
                                            'titulo' => 'Ej: Cien Años de Soledad',
                                            'autor' => 'Ej: Gabriel García Márquez',
                                            'editorial' => 'Ej: Penguin Random House',
                                            'paginas' => 'Ej: 350, 500',
                                            
                                            // Alimentos
                                            'sabor' => 'Ej: Chocolate, Vainilla, Fresa',
                                            'fecha_caducidad' => 'Ej: 12/2025, 6 meses',
                                            'informacion_nutricional' => 'Ej: 150 cal, 5g proteína',
                                            
                                            // Automotriz
                                            'compatibilidad' => 'Ej: Toyota Corolla 2020-2024',
                                            'modelo_vehiculo' => 'Ej: Corolla, Civic, Sentra',
                                            
                                            // Mascotas
                                            'tipo_mascota' => 'Ej: Perro, Gato',
                                            'tipo_producto' => 'Ej: Alimento seco, Juguete',
                                            
                                            default => 'Ingrese ' . strtolower($attr['label'])
                                        };
                                    @endphp
                                    <input 
                                        type="text"
                                        wire:model="variant_attributes.{{ $attr['key'] }}"
                                        placeholder="{{ $placeholder }}"
                                        class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                        required>
                                @endif
                                
                                @error("variant_attributes.{$attr['key']}")
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                        
                        {{-- Optional Attributes --}}
                        @foreach($this->categoryAttributes['optional'] as $attr)
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                    {{ $attr['label'] }} <span class="text-xs text-zinc-400">(Opcional)</span>
                                </label>
                                
                                @if($attr['type'] === 'select')
                                    <select 
                                        wire:model="variant_attributes.{{ $attr['key'] }}"
                                        class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                        <option value="">Seleccionar {{ $attr['label'] }}</option>
                                        @foreach($attr['options'] ?? [] as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                @elseif($attr['type'] === 'number')
                                    <div x-data="moneyInput({{ $variant_attributes[$attr['key']] ?? 0 }}, '', 0)">
                                        <input 
                                            type="text"
                                            x-model="formatted"
                                            @input="updateValue($event)"
                                            @click="forceEnd($el)"
                                            @keydown.arrow-left.prevent
                                            @keydown.arrow-right.prevent
                                            data-field="variant_attributes.{{ $attr['key'] }}"
                                            inputmode="numeric"
                                            placeholder="Ej: {{ $attr['key'] === 'piezas' ? '120 piezas' : '10' }}"
                                            class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                    </div>
                                @else
                                    @php
                                        $placeholder = match($attr['key']) {
                                            // Tecnología
                                            'conectividad' => 'Ej: WiFi, Bluetooth 5.0, 5G',
                                            'sistema_operativo' => 'Ej: Android 13, iOS 17, Windows 11',
                                            'bateria' => 'Ej: 5000mAh, 8 horas de uso',
                                            'camara' => 'Ej: 50MP, Triple cámara',
                                            'tarjeta_grafica' => 'Ej: NVIDIA RTX 3060, AMD Radeon',
                                            'cancelacion_ruido' => 'Ej: Activa, Pasiva',
                                            'potencia' => 'Ej: 1200W, 800W',
                                            
                                            // Ropa
                                            'estilo' => 'Ej: Casual, Formal, Deportivo',
                                            'tipo_prenda' => 'Ej: Camisa, Pantalón, Vestido',
                                            'ajuste' => 'Ej: Slim Fit, Regular',
                                            'largo' => 'Ej: Corto, Medio, Largo',
                                            'genero' => 'Ej: Hombre, Mujer, Unisex',
                                            'cierre' => 'Ej: Cordones, Velcro',
                                            
                                            // Hogar
                                            'capacidad' => 'Ej: 2L, 500ml, 10kg',
                                            'peso' => 'Ej: 1.5kg, 3kg',
                                            'peso_maximo' => 'Ej: 120kg, 200kg',
                                            'color' => 'Ej: Negro, Blanco, Gris',
                                            'voltaje' => 'Ej: 110V, 220V',
                                            
                                            // Belleza
                                            'tipo_piel' => 'Ej: Seca, Grasa, Mixta',
                                            'spf' => 'Ej: 30, 50, 50+',
                                            'ingredientes_principales' => 'Ej: Ácido Hialurónico, Vitamina C',
                                            'tono' => 'Ej: Beige Natural, Rosa Suave',
                                            'acabado' => 'Ej: Mate, Brillante',
                                            'aroma' => 'Ej: Lavanda, Coco, Sin aroma',
                                            'contenido' => 'Ej: 150ml, 50g',
                                            
                                            // Juguetes y Bebés
                                            'material' => 'Ej: Plástico, Madera, Tela',
                                            'baterias' => 'Ej: Sí (no incluidas), No',
                                            'piezas' => 'Ej: 120 piezas',
                                            'talla' => 'Ej: 0-3 meses, S, M, L',
                                            
                                            // Libros
                                            'editorial' => 'Ej: Penguin Random House, Planeta',
                                            'idioma' => 'Ej: Español, Inglés',
                                            'paginas' => 'Ej: 350 páginas',
                                            'formato' => 'Ej: Físico, Digital',
                                            
                                            // Alimentos
                                            'sabor' => 'Ej: Chocolate, Vainilla, Fresa',
                                            'fecha_caducidad' => 'Ej: 12/2025',
                                            'informacion_nutricional' => 'Ej: 150 cal, 5g proteína',
                                            
                                            // Automotriz
                                            'modelo_vehiculo' => 'Ej: Corolla 2020-2024, Civic',
                                            
                                            // Deportes
                                            'deporte' => 'Ej: Fútbol, Basketball',
                                            
                                            default => 'Ingrese ' . strtolower($attr['label'])
                                        };
                                    @endphp
                                    <input 
                                        type="text"
                                        wire:model="variant_attributes.{{ $attr['key'] }}"
                                        placeholder="{{ $placeholder }}"
                                        class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                @endif
                                
                                @error("variant_attributes.{$attr['key']}")
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                    
                    {{-- Info Message --}}
                    <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                        <div class="flex">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm text-blue-800 dark:text-blue-300">
                                Estos atributos son específicos para la categoría <strong>{{ $categorySearch }}</strong>. 
                                Los campos marcados con <span class="text-red-500">*</span> son obligatorios.
                            </p>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Images Section (Not for Services) --}}
                @if($product_type !== 'service')
                <div class="border-b border-zinc-200 dark:border-zinc-800 pb-6">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">{{ __('common.product_images') }}</h3>
                    
                    {{-- Existing Images --}}
                    @if(!empty($existing_images))
                        <div class="mb-4">
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-3">{{ __('common.current_images') }}</p>
                            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                                @foreach($existing_images as $index => $image)
                                    <div class="relative group">
                                        <img src="{{ Storage::url($image) }}" 
                                             alt="Product image {{ $index + 1 }}"
                                             class="w-full h-32 object-cover rounded-lg border-2 {{ $index === $featured_image_index ? 'border-yellow-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                                        
                                        {{-- Featured Badge --}}
                                        @if($index === $featured_image_index)
                                            <div class="absolute top-2 left-2">
                                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-yellow-500 text-white">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                    {{ __('common.featured') }}
                                                </span>
                                            </div>
                                        @endif

                                        {{-- Actions --}}
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-200 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100">
                                            <div class="flex gap-2">
                                                @if($index !== $featured_image_index)
                                                    <button type="button"
                                                            wire:click="setFeaturedImage({{ $index }})"
                                                            class="p-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors"
                                                            :title="__('common.set_as_featured')">
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    </button>
                                                @endif
                                                <button type="button"
                                                        wire:click="removeExistingImage({{ $index }})"
                                                        class="p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors"
                                                        title="Remove image">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Upload New Images --}}
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            {{ __('common.upload_images') }}
                        </label>
                        <div class="relative">
                            <input type="file" 
                                   wire:model="images" 
                                   multiple 
                                   accept="image/*"
                                   class="hidden" 
                                   id="product-images">
                            
                            <label for="product-images" 
                                   class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-zinc-300 dark:border-zinc-600 rounded-lg cursor-pointer hover:border-blue-500 dark:hover:border-blue-400 transition-colors bg-zinc-50 dark:bg-zinc-800/50">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-12 h-12 mb-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <p class="mb-2 text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ __('common.click_to_upload_or_drag_and_drop') }}
                                    </p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ __('common.png_jpg_or_webp_max_2mb') }}
                                    </p>
                                </div>
                            </label>
                        </div>

                        {{-- Loading Indicator --}}
                        <div wire:loading wire:target="images" class="mt-2">
                            <p class="text-sm text-blue-600 dark:text-blue-400">{{ __('common.uploading_images') }}</p>
                        </div>

                        @error('images.*')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Preview New Images --}}
                    @if(!empty($images))
                        <div class="mt-4">
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-3">{{ __('common.new_images_will_be_saved_on_submit') }}</p>
                            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                                @foreach($images as $index => $image)
                                    <div class="relative group">
                                        <img src="{{ $image->temporaryUrl() }}" 
                                             alt="New image {{ $index + 1 }}"
                                             class="w-full h-32 object-cover rounded-lg border-2 border-green-500">
                                        
                                        {{-- New Badge --}}
                                        <div class="absolute top-2 left-2">
                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-green-500 text-white">
                                                {{ __('common.new') }}
                                            </span>
                                        </div>

                                        {{-- Remove Button --}}
                                        <button type="button"
                                                wire:click="removeImage({{ $index }})"
                                                class="absolute top-2 right-2 p-1.5 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors opacity-0 group-hover:opacity-100">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                @endif

                {{-- Pricing --}}
                <div class="border-b border-zinc-200 dark:border-zinc-800 pb-6">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ __('common.pricing') }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            {{ __('common.pricing_description') }}
                        </p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Regular Price --}}
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <label class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ __('common.price') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="group relative">
                                    <svg class="w-4 h-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 cursor-help" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                    <div class="invisible group-hover:visible absolute left-0 top-6 z-10 w-64 p-3 bg-gray-900 dark:bg-gray-700 text-white text-xs rounded-lg shadow-lg">
                                        {!! __('common.price_tooltip') !!}
                                    </div>
                                </div>
                            </div>
                        <div x-data="moneyInput({{ $price ?? 0 }}, '', 0)">
                            <flux:input 
                                x-model="formatted"
                                @input="updateValue($event)"
                                @click="forceEnd($el)"
                                @keydown.arrow-left.prevent
                                @keydown.arrow-right.prevent
                                data-field="price"
                                inputmode="numeric"
                                placeholder="Ej: 20.00"
                                required
                            />
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                💵 {{ __('common.price_helper') }}
                            </p>
                        </div>
                        </div>

                        {{-- Sale Price --}}
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <label class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ __('common.sale_price') }}
                                </label>
                                <div class="group relative">
                                    <svg class="w-4 h-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 cursor-help" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                    <div class="invisible group-hover:visible absolute left-0 top-6 z-10 w-64 p-3 bg-gray-900 dark:bg-gray-700 text-white text-xs rounded-lg shadow-lg">
                                        {!! __('common.sale_price_tooltip') !!}
                                    </div>
                                </div>
                            </div>
                        <div x-data="moneyInput({{ $sale_price ?? 0 }}, '', 0)">
                            <flux:input 
                                x-model="formatted"
                                @input="updateValue($event)"
                                @click="forceEnd($el)"
                                @keydown.arrow-left.prevent
                                @keydown.arrow-right.prevent
                                data-field="sale_price"
                                inputmode="numeric"
                                placeholder="Ej: 15.00 (opcional)"
                            />
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                🏷️ {{ __('common.sale_price_helper') }}
                            </p>
                        </div>
                        </div>

                        {{-- Compare at Price --}}
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <label class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ __('common.compare_at_price') }}
                                </label>
                                <div class="group relative">
                                    <svg class="w-4 h-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 cursor-help" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                    <div class="invisible group-hover:visible absolute left-0 top-6 z-10 w-64 p-3 bg-gray-900 dark:bg-gray-700 text-white text-xs rounded-lg shadow-lg">
                                        {!! __('common.compare_at_price_tooltip') !!}
                                    </div>
                                </div>
                            </div>
                        <div x-data="moneyInput({{ $compare_at_price ?? 0 }}, '', 0)">
                            <flux:input 
                                x-model="formatted"
                                @input="updateValue($event)"
                                @click="forceEnd($el)"
                                @keydown.arrow-left.prevent
                                @keydown.arrow-right.prevent
                                data-field="compare_at_price"
                                inputmode="numeric"
                                placeholder="Ej: 25.00 (opcional)"
                            />
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                📊 {{ __('common.compare_at_price_helper') }}
                            </p>
                        </div>
                        </div>

                        {{-- Cost --}}
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <label class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ __('common.cost_per_item') }}
                                </label>
                                <div class="group relative">
                                    <svg class="w-4 h-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 cursor-help" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                    <div class="invisible group-hover:visible absolute left-0 top-6 z-10 w-64 p-3 bg-gray-900 dark:bg-gray-700 text-white text-xs rounded-lg shadow-lg">
                                        {!! __('common.cost_per_item_tooltip') !!}
                                    </div>
                                </div>
                            </div>
                        <div x-data="moneyInput({{ $cost ?? 0 }}, '', 0)">
                            <flux:input 
                                x-model="formatted"
                                @input="updateValue($event)"
                                @click="forceEnd($el)"
                                @keydown.arrow-left.prevent
                                @keydown.arrow-right.prevent
                                data-field="cost"
                                inputmode="numeric"
                                placeholder="Ej: 10.00 (opcional)"
                            />
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                🔒 {{ __('common.cost_per_item_helper') }}
                            </p>
                        </div>
                        </div>
                    </div>

                    {{-- Pricing Example --}}
                    @if($price)
                        <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                            <p class="text-sm font-medium text-blue-900 dark:text-blue-300 mb-2">
                                📌 {{ __('common.pricing_example_title') }}
                            </p>
                            <div class="flex items-center gap-3">
                                @if($compare_at_price)
                                    <span class="text-sm text-gray-500 dark:text-gray-400 line-through">
                                        ${{ number_format($compare_at_price, 2) }}
                                    </span>
                                @endif
                                @if($sale_price)
                                    <span class="text-xl font-bold text-green-600 dark:text-green-400">
                                        ${{ number_format($sale_price, 2) }}
                                    </span>
                                    @if($compare_at_price && $sale_price < $compare_at_price)
                                        <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-medium rounded">
                                            {{ __('common.save_amount') }} ${{ number_format($compare_at_price - $sale_price, 2) }}
                                        </span>
                                    @endif
                                @else
                                    <span class="text-xl font-bold text-gray-900 dark:text-white">
                                        ${{ number_format($price, 2) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Currency Exchange (only show if rate exists) --}}
                @if($this->currentRate)
                <div class="border-b border-zinc-200 dark:border-zinc-800 pb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Conversión de Moneda</h3>
                        <label class="flex items-center cursor-pointer">
                            <input 
                                type="checkbox" 
                                wire:model.live="show_local_price"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                Mostrar precio local
                            </span>
                        </label>
                    </div>

                    @if($show_local_price)
                        <div class="space-y-4">
                            {{-- Price Conversion Display --}}
                            @if($this->currentRate)
                                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Tasa de Cambio Actual</p>
                                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                                1 USD = {!! $this->selectedCountry->currency_symbol !!}{{ number_format($this->currentRate->rate, 2) }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                {{ $this->selectedCountry->name_es }} • Efectiva desde: {{ $this->currentRate->effective_date->format('d/m/Y') }}
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                                                <span class="text-2xl">{!! $this->selectedCountry->currency_symbol !!}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        {{-- Regular Price --}}
                                        @if($price)
                                            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">Precio Regular</p>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">${{ number_format($price, 2) }} USD</p>
                                                <p class="text-xl font-bold text-gray-900 dark:text-white mt-1">
                                                    {!! $this->selectedCountry->currency_symbol !!}{{ number_format($this->priceLocal, 2) }}
                                                </p>
                                            </div>
                                        @endif

                                        {{-- Sale Price --}}
                                        @if($sale_price)
                                            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-green-200 dark:border-green-700">
                                                <p class="text-xs font-medium text-green-600 dark:text-green-400 uppercase mb-1">Precio de Oferta</p>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">${{ number_format($sale_price, 2) }} USD</p>
                                                <p class="text-xl font-bold text-green-600 dark:text-green-400 mt-1">
                                                    {!! $this->selectedCountry->currency_symbol !!}{{ number_format($this->salePriceLocal, 2) }}
                                                </p>
                                            </div>
                                        @endif

                                        {{-- Compare Price --}}
                                        @if($compare_at_price)
                                            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">Precio de Comparación</p>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">${{ number_format($compare_at_price, 2) }} USD</p>
                                                <p class="text-xl font-bold text-gray-900 dark:text-white mt-1">
                                                    {!! $this->selectedCountry->currency_symbol !!}{{ number_format($this->comparePriceLocal, 2) }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium text-yellow-800 dark:text-yellow-300">
                                                No hay tasa de cambio registrada
                                            </p>
                                            <p class="text-xs text-yellow-700 dark:text-yellow-400 mt-1">
                                                Por favor, registra una tasa de cambio en el módulo de Tasas de Cambio
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
                @endif

                {{-- Inventory (Only for Physical Products) --}}
                @if($product_type === 'physical')
                <div class="border-b border-zinc-200 dark:border-zinc-800 pb-6">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">{{ __('common.inventory') }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.stock_quantity') }} <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                wire:model="stock"
                                min="0"
                                step="1"
                                inputmode="numeric"
                                pattern="[0-9]*"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                placeholder="0"
                                class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                required>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                💡 {{ __('common.stock_quantity_helper') }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('common.low_stock_threshold') }}
                            </label>
                            <input 
                                type="number" 
                                wire:model="low_stock_threshold"
                                min="0"
                                step="1"
                                inputmode="numeric"
                                pattern="[0-9]*"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                placeholder="5"
                                class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                ⚠️ {{ __('common.low_stock_threshold_helper') }}
                            </p>
                        </div>

                        <div x-data="moneyInput({{ $weight ?? 0 }}, '', 0)">
                            <flux:input 
                                x-model="formatted"
                                @input="updateValue($event)"
                                @click="forceEnd($el)"
                                @keydown.arrow-left.prevent
                                @keydown.arrow-right.prevent
                                data-field="weight"
                                inputmode="numeric"
                                label="{{ __('common.weight_kg') }}" 
                                placeholder="0.00"
                            />
                        </div>

                        <div class="md:col-span-3 space-y-3">
                            <flux:checkbox wire:model="track_inventory" label="{{ __('common.track_inventory') }}" />
                            <flux:checkbox wire:model="allow_backorder" label="{{ __('common.allow_backorder_when_out_of_stock') }}" />
                        </div>
                    </div>
                </div>
                @endif



                {{-- Physical Product: Dimensions & Shipping --}}
                @if($product_type === 'physical')
                <div class="border-b border-zinc-200 dark:border-zinc-800 pb-6">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">{{ __('common.dimensions_shipping') }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div x-data="moneyInput({{ $length ?? 0 }}, '', 0)">
                            <flux:input 
                                x-model="formatted"
                                @input="updateValue($event)"
                                @click="forceEnd($el)"
                                @keydown.arrow-left.prevent
                                @keydown.arrow-right.prevent
                                data-field="length"
                                inputmode="numeric"
                                label="{{ __('common.length_cm') }}" 
                                placeholder="0.00"
                            />
                        </div>

                        <div x-data="moneyInput({{ $width ?? 0 }}, '', 0)">
                            <flux:input 
                                x-model="formatted"
                                @input="updateValue($event)"
                                @click="forceEnd($el)"
                                @keydown.arrow-left.prevent
                                @keydown.arrow-right.prevent
                                data-field="width"
                                inputmode="numeric"
                                label="{{ __('common.width_cm') }}" 
                                placeholder="0.00"
                            />
                        </div>

                        <div x-data="moneyInput({{ $height ?? 0 }}, '', 0)">
                            <flux:input 
                                x-model="formatted"
                                @input="updateValue($event)"
                                @click="forceEnd($el)"
                                @keydown.arrow-left.prevent
                                @keydown.arrow-right.prevent
                                data-field="height"
                                inputmode="numeric"
                                label="{{ __('common.height_cm') }}" 
                                placeholder="0.00"
                            />
                        </div>

                        <div class="md:col-span-3">
                            <flux:checkbox wire:model="requires_shipping" label="{{ __('common.requires_shipping') }}" />
                        </div>
                    </div>
                </div>
                @endif

                {{-- Service: Configuration --}}
                @if($product_type === 'service')
                <div class="border-b border-zinc-200 dark:border-zinc-800 pb-6">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">{{ __('common.service_configuration') }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <flux:input 
                                wire:model="duration" 
                                type="number"
                                label="{{ __('common.duration_minutes') }}" 
                                placeholder="60"
                            />
                        </div>

                        <div>
                            <flux:input 
                                wire:model="max_bookings_per_day" 
                                type="number"
                                label="{{ __('common.max_bookings_per_day') }}" 
                                placeholder="10"
                            />
                        </div>

                        <div class="md:col-span-2">
                            <flux:checkbox wire:model="booking_required" label="{{ __('common.booking_required') }}" />
                        </div>
                    </div>
                </div>
                @endif

                {{-- Digital: File Information --}}
                @if($product_type === 'digital')
                <div class="border-b border-zinc-200 dark:border-zinc-800 pb-6">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">{{ __('common.file_information') }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- File Type --}}
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                {{ __('common.file_type') }}
                            </label>
                            <select 
                                wire:model="file_type"
                                class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                <option value="">{{ __('common.select_file_type') }}</option>
                                <option value="ebook">{{ __('common.ebook') }}</option>
                                <option value="video">{{ __('common.video') }}</option>
                                <option value="audio">{{ __('common.audio') }}</option>
                                <option value="software">{{ __('common.software') }}</option>
                                <option value="template">{{ __('common.template') }}</option>
                                <option value="document">{{ __('common.document') }}</option>
                                <option value="other">{{ __('common.other') }}</option>
                            </select>
                        </div>

                        {{-- Version --}}
                        <div>
                            <flux:input 
                                wire:model="version" 
                                label="{{ __('common.version') }}" 
                                placeholder="1.0.0"
                            />
                        </div>

                        {{-- Main File Upload --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                {{ __('common.file_upload') }}
                            </label>
                            
                            {{-- Dropzone Style Upload --}}
                            <div class="relative">
                                <input type="file" 
                                       wire:model="digital_file"
                                       id="digital_file"
                                       class="hidden">
                                <label for="digital_file" 
                                       class="flex flex-col items-center justify-center w-full h-32 border-2 border-zinc-300 dark:border-zinc-600 border-dashed rounded-lg cursor-pointer bg-zinc-50 dark:bg-zinc-800/50 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-10 h-10 mb-3 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <p class="mb-2 text-sm text-zinc-500 dark:text-zinc-400">
                                            <span class="font-semibold">{{ __('common.click_to_upload') }}</span> or drag and drop
                                        </p>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                            Any file type accepted
                                        </p>
                                    </div>
                                </label>
                            </div>
                            
                            <div wire:loading wire:target="digital_file" class="mt-2">
                                <p class="text-sm text-blue-600 dark:text-blue-400">{{ __('common.uploading_images') }}</p>
                            </div>
                            
                            @error('digital_file')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Download URL (Optional) --}}
                        <div class="md:col-span-2">
                            <flux:input 
                                wire:model="download_url" 
                                label="{{ __('common.download_url') }} (Optional)" 
                                placeholder="https://example.com/download/product-file"
                            />
                            <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">For external hosting (Dropbox, Google Drive, etc.)</p>
                        </div>

                        {{-- Preview File Upload --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                {{ __('common.preview_url') }}
                            </label>
                            
                            {{-- Dropzone Style Upload --}}
                            <div class="relative">
                                <input type="file" 
                                       wire:model="preview_file"
                                       id="preview_file"
                                       accept="image/*,video/*,audio/*,.pdf"
                                       class="hidden">
                                <label for="preview_file" 
                                       class="flex flex-col items-center justify-center w-full h-32 border-2 border-zinc-300 dark:border-zinc-600 border-dashed rounded-lg cursor-pointer bg-zinc-50 dark:bg-zinc-800/50 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-10 h-10 mb-3 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                        <p class="mb-2 text-sm text-zinc-500 dark:text-zinc-400">
                                            <span class="font-semibold">{{ __('common.click_to_upload') }}</span> preview/demo
                                        </p>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                            Image, Video, Audio, or PDF
                                        </p>
                                    </div>
                                </label>
                            </div>
                            
                            <div wire:loading wire:target="preview_file" class="mt-2">
                                <p class="text-sm text-blue-600 dark:text-blue-400">{{ __('common.uploading_images') }}</p>
                            </div>
                            
                            @error('preview_file')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror

                            {{-- OR Divider --}}
                            <div class="relative my-4">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-zinc-300 dark:border-zinc-600"></div>
                                </div>
                                <div class="relative flex justify-center text-sm">
                                    <span class="px-3 bg-white dark:bg-zinc-900 text-zinc-500 dark:text-zinc-400 font-medium">OR use URL</span>
                                </div>
                            </div>

                            {{-- Preview URL Input --}}
                            <flux:input 
                                wire:model="preview_url" 
                                placeholder="https://youtube.com/watch?v=..."
                            />
                            <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">YouTube, Vimeo, SoundCloud, or any preview URL</p>
                        </div>

                        {{-- File Size --}}
                        <div>
                            <flux:input 
                                wire:model="file_size" 
                                type="number"
                                step="0.01"
                                label="{{ __('common.file_size_mb') }}" 
                                placeholder="5.2"
                            />
                        </div>

                        {{-- Download Limit --}}
                        <div>
                            <flux:input 
                                wire:model="download_limit" 
                                type="number"
                                label="{{ __('common.download_limit') }}" 
                                placeholder="3"
                            />
                            <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Leave empty for unlimited downloads</p>
                        </div>

                        {{-- Download Expiry --}}
                        <div class="md:col-span-2">
                            <flux:input 
                                wire:model="download_expiry_days" 
                                type="number"
                                label="{{ __('common.download_expiry_days') }}" 
                                placeholder="30"
                            />
                        </div>
                    </div>
                </div>
                @endif

                {{-- Status & Visibility --}}
                <div class="border-b border-zinc-200 dark:border-zinc-800 pb-6">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">{{ __('common.status_visibility') }}</h3>
                    
                    <div class="space-y-3">
                        <flux:checkbox wire:model="is_active" label="{{ __('common.product_is_active') }}" />
                        <flux:checkbox wire:model="is_featured" label="{{ __('common.featured_product') }}" />
                        <flux:checkbox wire:model="is_new" label="{{ __('common.mark_as_new') }}" />
                    </div>
                </div>

                {{-- SEO --}}
                <div>
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">{{ __('common.seo_optional') }}</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <flux:input 
                                wire:model="meta_title" 
                                label="{{ __('common.meta_title') }}" 
                                placeholder="{{ __('common.seo_title_for_search_engines') }}"
                            />
                        </div>

                        <div>
                            <flux:textarea 
                                wire:model="meta_description" 
                                label="{{ __('common.meta_description') }}" 
                                placeholder="{{ __('common.seo_description_for_search_engines') }}"
                                rows="2"
                            />
                        </div>

                        <div>
                            <flux:input 
                                wire:model="meta_keywords" 
                                label="{{ __('common.meta_keywords') }}" 
                                placeholder="{{ __('common.keyword1_keyword2_keyword3') }}"
                            />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="px-6 py-4 bg-zinc-50/50 dark:bg-zinc-900/50 border-t border-zinc-200 dark:border-zinc-800 flex justify-end gap-3">
                <flux:button type="button" wire:click="cancel" variant="ghost">
                    {{ __('common.cancel') }}
                </flux:button>
                <flux:button type="submit" variant="primary">
                    {{ $editMode ? __('common.update_product') : __('common.create_product') }}
                </flux:button>
            </div>
        </form>
    </div>
    
    {{-- Brand Modal --}}
    @if($showBrandModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" wire:ignore.self>
        {{-- Background overlay --}}
        <div 
            class="fixed inset-0 bg-gray-500 bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-75 transition-opacity"
            wire:click="closeBrandModal">
        </div>

        {{-- Modal container --}}
        <div class="flex items-center justify-center min-h-screen p-4">
            {{-- Modal panel --}}
            <div class="relative w-full max-w-md bg-white dark:bg-gray-800 rounded-2xl shadow-xl transform transition-all" wire:click.stop>
                
                {{-- Header --}}
                <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        {{ $brandModalMode === 'edit' ? 'Editar Marca' : 'Nueva Marca' }}
                    </h3>
                    <button 
                        type="button"
                        wire:click="closeBrandModal"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Form Content --}}
                <div class="p-6 space-y-4">
                    {{-- Brand Name --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nombre de la Marca <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text"
                            wire:model="brandModalName"
                            placeholder="Ej: Samsung, Apple, Nike"
                            class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('brandModalName')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Brand Description --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Descripción (Opcional)
                        </label>
                        <textarea 
                            wire:model="brandModalDescription"
                            rows="3"
                            placeholder="Descripción de la marca..."
                            class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"></textarea>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex justify-end gap-3 p-6 border-t border-gray-200 dark:border-gray-700">
                    <button 
                        type="button"
                        wire:click="closeBrandModal"
                        class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                        Cancelar
                    </button>
                    <button 
                        type="button"
                        wire:click="saveBrand"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ $brandModalMode === 'edit' ? 'Actualizar' : 'Crear Marca' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
