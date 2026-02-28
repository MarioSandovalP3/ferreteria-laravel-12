@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
    @php
        $store = \App\Models\Store::first();
        $storeName = $store ? $store->name : config('app.name');
    @endphp
    @if(config('mail.logo_url'))
        <div style="text-align: center;">
            <img src="{{ config('mail.logo_url') }}" alt="{{ $storeName }}" style="height: 60px; margin-bottom: 10px;">
            <div style="font-size: 20px; font-weight: bold; color: #3d4852;">{{ $storeName }}</div>
        </div>
    @else
        <span style="font-size: 24px; font-weight: bold; color: #3d4852;">{{ $storeName }}</span>
    @endif
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>
