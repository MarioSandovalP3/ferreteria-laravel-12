<div>
<!-- Hero Section -->
<section class="relative bg-neutral-900 text-white h-[500px] flex items-center overflow-hidden">
    <!-- Background Image Overlay -->
    <div
        class="absolute inset-0 z-0 opacity-40 bg-[url('https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=2070&auto=format&fit=crop')] bg-cover bg-center">
    </div>
    <div class="absolute inset-0 z-0 bg-gradient-to-r from-neutral-900 via-neutral-900/80 to-transparent">
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-2xl">
            <span
                class="inline-block bg-yellow-500 text-neutral-900 text-xs font-bold px-3 py-1 rounded-full mb-4 uppercase tracking-wider">Calidad
                Profesional</span>
            <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                {{ $store->name }}
            </h1>
            <p class="text-xl text-gray-300 mb-8 max-w-lg">
                {{ $store->description }}
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="#"
                    class="bg-yellow-500 hover:bg-yellow-400 text-neutral-900 font-bold py-3 px-8 rounded-sm transition-colors flex items-center gap-2">
                    Ver Catálogo
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>
                <a href="#"
                    class="border border-white hover:bg-white hover:text-neutral-900 text-white font-bold py-3 px-8 rounded-sm transition-colors">
                    Ofertas del Día
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Features / Trust Area -->
<section class="bg-yellow-500 py-8">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-neutral-900">
            <div class="flex items-center gap-4 p-4 bg-yellow-400/50 rounded-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-10 h-10">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                </svg>
                <div>
                    <h3 class="font-bold text-lg">Envío Rápido</h3>
                    <p class="text-sm opacity-80">En 24/48 horas</p>
                </div>
            </div>
            <div class="flex items-center gap-4 p-4 bg-yellow-400/50 rounded-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-10 h-10">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                </svg>
                <div>
                    <h3 class="font-bold text-lg">Garantía Total</h3>
                    <p class="text-sm opacity-80">30 días de devolución</p>
                </div>
            </div>
            <div class="flex items-center gap-4 p-4 bg-yellow-400/50 rounded-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-10 h-10">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                </svg>
                <div>
                    <h3 class="font-bold text-lg">Pago Seguro</h3>
                    <p class="text-sm opacity-80">Tarjetas y Efectivo</p>
                </div>
            </div>
            <div class="flex items-center gap-4 p-4 bg-yellow-400/50 rounded-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-10 h-10">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
                </svg>
                <div>
                    <h3 class="font-bold text-lg">Soporte 24/7</h3>
                    <p class="text-sm opacity-80">Expertos en línea</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Categories -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-3xl font-bold mb-2">Categorías Populares</h2>
                <p class="text-gray-500">Encuentra todo lo que necesitas para tu proyecto</p>
            </div>
            <a href="#"
                class="text-yellow-600 font-bold hover:text-yellow-700 flex items-center gap-1">
                Ver todas
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @forelse($featuredCategories as $category)
            <a href="#" class="group relative overflow-hidden rounded-sm aspect-square bg-gray-100">
                <img src="https://images.unsplash.com/photo-1504148455328-c376907d081c?q=80&w=1780&auto=format&fit=crop"
                    alt="{{ $category->name }}"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div
                    class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex items-end p-6">
                    <h3 class="text-white font-bold text-xl group-hover:text-yellow-400 transition-colors">
                        {{ $category->name }}</h3>
                </div>
            </a>
            @empty
            <div class="col-span-4 text-center py-8 text-gray-500">
                No hay categorías destacadas disponibles
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center">Ofertas Destacadas</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($featuredProducts as $product)
            <div class="bg-white rounded-sm shadow-sm hover:shadow-md transition-shadow group">
                <div class="relative aspect-[4/3] overflow-hidden bg-gray-100">
                    @if($product->is_on_sale)
                    <span
                        class="absolute top-2 left-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-sm z-10">
                        -{{ $product->discount_percentage }}%
                    </span>
                    @endif
                    @if($product->is_new)
                    <span
                        class="absolute top-2 left-2 bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded-sm z-10">
                        NUEVO
                    </span>
                    @endif
                    <img src="{{ $product->featured_image ?? 'https://images.unsplash.com/photo-1572981779307-38b8cabb2407?q=80&w=1932&auto=format&fit=crop' }}"
                        alt="{{ $product->name }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <button
                        class="absolute bottom-4 right-4 bg-yellow-500 text-neutral-900 p-2 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300 hover:bg-yellow-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </button>
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-500 mb-1">{{ $product->brand ?? 'Sin marca' }}</p>
                    <h3 class="font-bold text-lg mb-2 group-hover:text-yellow-600 transition-colors line-clamp-2">
                        {{ $product->name }}
                    </h3>
                    <div class="flex items-end gap-2">
                        <span class="text-xl font-bold text-neutral-900">{{ $product->formatted_price }}</span>
                        @if($product->compare_at_price)
                        <span class="text-sm text-gray-400 line-through">DOP ${{ number_format($product->compare_at_price, 2) }}</span>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-4 text-center py-12 text-gray-500">
                <p class="text-lg">No hay productos destacados disponibles en este momento</p>
            </div>
            @endforelse
        </div>

        <div class="text-center mt-12">
            <a href="#"
                class="inline-block border-2 border-neutral-900 text-neutral-900 hover:bg-neutral-900 hover:text-white font-bold py-3 px-8 rounded-sm transition-colors">
                Ver Todos los Productos
            </a>
        </div>
    </div>
</section></div>
