<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $quotation->rfq_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .document-title {
            font-size: 18px;
            color: #666;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-row {
            margin-bottom: 5px;
        }
        .label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
        }
        .status-draft { background-color: #e5e7eb; color: #374151; }
        .status-sent { background-color: #dbeafe; color: #1e40af; }
        .status-received { background-color: #fef3c7; color: #92400e; }
        .status-approved { background-color: #d1fae5; color: #065f46; }
        .status-converted { background-color: #e9d5ff; color: #6b21a8; }
        .status-cancelled { background-color: #fee2e2; color: #991b1b; }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background-color: #f3f4f6;
            padding: 10px;
            text-align: left;
            border-bottom: 2px solid #333;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .notes-section {
            margin-top: 30px;
            padding: 15px;
            background-color: #f9fafb;
            border-left: 4px solid #3b82f6;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        @if($store && $store->logo)
            <div style="text-align: center; margin-bottom: 10px;">
                <img src="{{ storage_path('app/public/' . $store->logo) }}" alt="{{ $store->name }}" style="max-height: 80px; max-width: 200px;">
            </div>
        @endif
        <div class="company-name">{{ $store ? $store->name : config('app.name') }}</div>
        @if($store && $store->address)
            <div style="font-size: 11px; color: #666; margin-top: 5px;">{{ $store->address }}</div>
        @endif
        @if($store && ($store->phone || $store->email))
            <div style="font-size: 11px; color: #666;">
                @if($store->phone) Tel: {{ $store->phone }} @endif
                @if($store->phone && $store->email) | @endif
                @if($store->email) {{ $store->email }} @endif
            </div>
        @endif
        <div class="document-title">SOLICITUD DE COTIZACIÓN</div>
    </div>

    <div class="info-section">
        <div class="info-row">
            <span class="label">RFQ Número:</span>
            <strong>{{ $quotation->rfq_number }}</strong>
        </div>
        <div class="info-row">
            <span class="label">Proveedor:</span>
            {{ $quotation->supplier->name }}
        </div>
        @if($quotation->supplier->email)
        <div class="info-row">
            <span class="label">Email:</span>
            {{ $quotation->supplier->email }}
        </div>
        @endif
        <div class="info-row">
            <span class="label">Fecha de Solicitud:</span>
            {{ $quotation->request_date->format('d/m/Y') }}
        </div>
        @if($quotation->expected_date)
        <div class="info-row">
            <span class="label">Fecha Esperada:</span>
            {{ $quotation->expected_date->format('d/m/Y') }}
        </div>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 10%">#</th>
                <th style="width: 40%">Producto</th>
                <th style="width: 15%" class="text-center">Cantidad</th>
                <th style="width: 17%" class="text-right">Precio Sugerido</th>
                <th style="width: 18%" class="text-right">Precio Cotizado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quotation->items as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->product->name }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">
                    @if($item->requested_price)
                        ${{ number_format($item->requested_price, 2) }}
                    @else
                        -
                    @endif
                </td>
                <td class="text-right">
                    @if($item->quoted_price)
                        ${{ number_format($item->quoted_price, 2) }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"></td>
                <td class="text-right"><strong>Total Solicitado:</strong></td>
                <td class="text-right"><strong>${{ number_format($quotation->total_requested, 2) }}</strong></td>
            </tr>
            @if($quotation->hasAllQuotedPrices())
            <tr>
                <td colspan="3"></td>
                <td class="text-right"><strong>Total Cotizado:</strong></td>
                <td class="text-right"><strong>${{ number_format($quotation->total_quoted, 2) }}</strong></td>
            </tr>
            @endif
        </tfoot>
    </table>

    @if($quotation->notes)
    <div class="notes-section">
        <strong>Notas:</strong><br>
        {{ $quotation->notes }}
    </div>
    @endif

    <div class="footer">
        Generado el {{ now()->format('d/m/Y H:i') }} | {{ $store ? $store->name : config('app.name') }}
    </div>
</body>
</html>
