<x-mail::message>
# {{ $quotation->rfq_number }}

{{ $customMessage }}

**Proveedor:** {{ $quotation->supplier->name }}  
**Fecha de Solicitud:** {{ $quotation->request_date->format('d/m/Y') }}  
@if($quotation->expected_date)
**Fecha Esperada:** {{ $quotation->expected_date->format('d/m/Y') }}
@endif

Los detalles completos de la solicitud se encuentran en el archivo PDF adjunto.

@php
    $store = \App\Models\Store::first();
    $storeName = $store ? $store->name : config('app.name');
@endphp

Saludos cordiales,  
**{{ $storeName }}**
</x-mail::message>
