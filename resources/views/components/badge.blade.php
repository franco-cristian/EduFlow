@props(['color' => 'blue'])

@php
    $colors = [
        'blue' => 'bg-blue-100 text-blue-800',
        'green' => 'bg-green-100 text-green-800',
        'yellow' => 'bg-yellow-100 text-yellow-800',
        'red' => 'bg-red-100 text-red-800',
        'purple' => 'bg-purple-100 text-purple-800',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'px-2 py-1 text-xs font-medium rounded-full ' . $colors[$color]]) }}>
    {{ $slot }}
</span>