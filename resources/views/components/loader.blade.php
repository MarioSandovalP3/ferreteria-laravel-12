@props(['target', 'action' => 'processing'])

@php
    // Configuración de mensajes e iconos según la acción
    $config = [
        'Store' => [
            'title' => 'Guardando...',
            'message' => 'Creando nuevo registro',
            'color' => 'text-green-600',
            'icon' => 'save'
        ],
        'Update' => [
            'title' => 'Actualizando...',
            'message' => 'Guardando cambios',
            'color' => 'text-blue-600',
            'icon' => 'edit'
        ],
        'Delete' => [
            'title' => 'Eliminando...',
            'message' => 'Eliminando registro',
            'color' => 'text-red-600',
            'icon' => 'delete'
        ],
        'default' => [
            'title' => 'Procesando...',
            'message' => 'Por favor espere',
            'color' => 'text-blue-600',
            'icon' => 'spinner'
        ]
    ];

    $currentConfig = $config[$action] ?? $config['default'];
@endphp

<span wire:loading wire:target="{{ $target }}">
    <!-- Overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-20 backdrop-blur-sm flex items-center justify-center z-[9999]">

        <!-- Caja centrada -->
        <div class="bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-2xl p-8 flex flex-col items-center gap-4 shadow-2xl animate-fadeIn max-w-xs w-full">

            <!-- Icono según la acción -->
            @if($currentConfig['icon'] === 'save')
                <!-- Icono de guardar -->
                <div class="relative">
                    <svg class="animate-spin h-12 w-12 {{ $currentConfig['color'] }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <svg class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 h-6 w-6 {{ $currentConfig['color'] }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            @elseif($currentConfig['icon'] === 'edit')
                <!-- Icono de editar -->
                <div class="relative">
                    <svg class="animate-spin h-12 w-12 {{ $currentConfig['color'] }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <svg class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 h-6 w-6 {{ $currentConfig['color'] }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
            @elseif($currentConfig['icon'] === 'delete')
                <!-- Icono de eliminar -->
                <div class="relative">
                    <svg class="animate-spin h-12 w-12 {{ $currentConfig['color'] }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <svg class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 h-6 w-6 {{ $currentConfig['color'] }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
            @else
                <!-- Spinner por defecto -->
                <svg class="animate-spin h-12 w-12 {{ $currentConfig['color'] }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
            @endif

            <!-- Título -->
            <h3 class="text-lg font-semibold">{{ $currentConfig['title'] }}</h3>

            <!-- Mensaje secundario -->
            <p class="text-sm text-gray-500 dark:text-gray-400 text-center">
                {{ $slot->isEmpty() ? $currentConfig['message'] : $slot }}
            </p>

        </div>

    </div>
</span>

<!-- Tailwind animation -->
@once
<style>
    @keyframes fadeIn {
        from {opacity:0;}
        to {opacity:1;}
    }
    .animate-fadeIn { animation: fadeIn 0.5s ease-in-out; }
</style>
@endonce
