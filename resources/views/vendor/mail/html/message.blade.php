<x-mail::layout>
{{-- Header --}}
<x-slot:header>
@php
    $store = \App\Models\Store::first();
    $storeName = $store ? $store->name : config('app.name');
@endphp
<x-mail::header :url="config('app.url')">
{{ $storeName }}
</x-mail::header>
</x-slot:header>

{{-- Body --}}
{!! $slot !!}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{!! $subcopy !!}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
© {{ date('Y') }} {{ $storeName ?? config('app.name') }}. {{ __('All rights reserved.') }}
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
