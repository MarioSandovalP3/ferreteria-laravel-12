<x-mail::message>
# Solicitud de Cotización

Estimado/a proveedor,

Le enviamos la siguiente solicitud de cotización:

**RFQ:** {{ $quotation->rfq_number }}  
**Fecha de Solicitud:** {{ $quotation->request_date->format('d/m/Y') }}  
@if($quotation->expected_date)
**Fecha Esperada de Entrega:** {{ $quotation->expected_date->format('d/m/Y') }}
@endif

## Productos Solicitados

<x-mail::table>
| Producto | Cantidad | Precio Sugerido |
|:---------|:--------:|----------------:|
@foreach($items as $item)
| {{ $item->product->name }} | {{ $item->quantity }} | @if($item->requested_price) ${{ number_format($item->requested_price, 2) }} @else - @endif |
@endforeach
</x-mail::table>

@if($quotation->notes)
## Notas Adicionales

{{ $quotation->notes }}
@endif

Por favor, envíenos su cotización con los precios y disponibilidad de los productos solicitados.

Gracias,  
{{ config('app.name') }}
</x-mail::message>
