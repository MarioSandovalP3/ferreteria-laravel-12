<!-- Header -->
        <header class="bg-neutral-900 text-white sticky top-0 z-50 shadow-lg border-b-4 border-yellow-500">
            <!-- Top Bar -->
            <div class="bg-neutral-800 text-xs py-1 px-4 hidden md:block">
                <div class="container mx-auto flex justify-between text-gray-400">
                    <span>📞 Soporte 24/7: {{ $store->phone ?? '+1 (809) 555-1234' }}</span>
                    <div class="flex gap-4">
                        <a href="#" class="hover:text-yellow-400">Envíos y Devoluciones</a>
                        <a href="#" class="hover:text-yellow-400">Seguimiento de Pedido</a>
                    </div>
                </div>
            </div>

            <!-- Main Header -->
            <div class="container mx-auto px-4 py-4">
                <div class="flex items-center justify-between gap-4">

                    <!-- Logo -->
                    <a href="/" class="flex items-center gap-2 group">
                        <div class="bg-yellow-500 rounded-sm text-neutral-900 transform group-hover:rotate-12 transition-transform">
                            @if($store && $store->logo)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($store->logo) }}" alt="{{ $store->name }}" class="w-8 h-8 object-contain">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
                                </svg>
                            @endif
                        </div>
                        <div class="flex flex-col">
                            <span class="text-2xl font-bold tracking-tighter leading-none">{{ $store->name ?? 'FERRETERÍA PRO' }}</span>
                            <span class="text-[10px] text-gray-400 tracking-widest uppercase">Equipamiento
                                Industrial</span>
                        </div>
                    </a>

                    <!-- Search Bar (Hidden on mobile initially, or small) -->
                    <div class="hidden md:flex flex-1 max-w-xl mx-8">
                        <div class="relative w-full">
                            <input type="text" placeholder="Buscar herramientas, materiales..."
                                class="w-full bg-neutral-800 border border-neutral-700 text-white pl-4 pr-10 py-2 rounded-sm focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition-all placeholder-gray-500">
                            <button class="absolute right-0 top-0 h-full px-3 text-gray-400 hover:text-yellow-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-6">
                        <a href="./pages/login.html"
                            class="hidden md:flex items-center gap-2 hover:text-yellow-400 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            <div class="flex flex-col text-xs text-right">
                                <span class="text-gray-400">Hola, Invitado</span>
                                <span class="font-bold">Iniciar Sesión</span>
                            </div>
                        </a>

                        <a href="./pages/cart.html"
                            class="relative group flex items-center gap-2 hover:text-yellow-400 transition-colors">
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                </svg>
                                <span
                                    class="absolute -top-2 -right-2 bg-yellow-500 text-neutral-900 text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center">0</span>
                            </div>
                            <span class="hidden md:block font-bold">{{ $store->currency ?? 'DOP' }} $0.00</span>
                        </a>

                        <!-- Mobile Menu Button -->
                        <button id="mobile-menu-btn" class="md:hidden text-white hover:text-yellow-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-7 h-7">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Navigation Bar -->
            <div class="bg-neutral-800 border-t border-neutral-700 hidden md:block">
                <div class="container mx-auto px-4">
                    <ul class="flex gap-8 text-sm font-medium">
                        <li><a href="#" class="block py-3 text-yellow-500 border-b-2 border-yellow-500">Inicio</a></li>
                        <li class="group relative">
                            <a href="./pages/products.html"
                                class="block py-3 text-gray-300 hover:text-white transition-colors flex items-center gap-1">
                                Productos
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" class="w-3 h-3">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </a>
                            <!-- Dropdown (Simple CSS hover) -->
                            <div
                                class="absolute left-0 top-full w-48 bg-white text-neutral-900 shadow-xl rounded-b-sm hidden group-hover:block z-50">
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100">Herramientas Eléctricas</a>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100">Herramientas Manuales</a>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100">Construcción</a>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100">Electricidad</a>
                            </div>
                        </li>
                        <li><a href="#" class="block py-3 text-gray-300 hover:text-white transition-colors">Ofertas</a>
                        </li>
                        <li><a href="#" class="block py-3 text-gray-300 hover:text-white transition-colors">Nuevos
                                Ingresos</a></li>
                        <li><a href="#" class="block py-3 text-gray-300 hover:text-white transition-colors">Marcas</a>
                        </li>
                        <li><a href="#" class="block py-3 text-gray-300 hover:text-white transition-colors">Contacto</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Mobile Menu (Hidden by default) -->
            <div id="mobile-menu" class="hidden md:hidden bg-neutral-800 border-t border-neutral-700">
                <div class="p-4 space-y-4">
                    <input type="text" placeholder="Buscar..."
                        class="w-full bg-neutral-900 border border-neutral-700 text-white px-4 py-2 rounded-sm">
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="block py-2 text-yellow-500">Inicio</a></li>
                        <li><a href="./pages/products.html" class="block py-2 text-gray-300">Productos</a></li>
                        <li><a href="#" class="block py-2 text-gray-300">Ofertas</a></li>
                        <li><a href="#" class="block py-2 text-gray-300">Contacto</a></li>
                        <li><a href="./pages/login.html"
                                class="block py-2 text-gray-300 border-t border-neutral-700 mt-2 pt-4">Iniciar
                                Sesión</a></li>
                    </ul>
                </div>
            </div>
        </header>