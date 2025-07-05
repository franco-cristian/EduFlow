<div {{ $attributes->merge(['class' => 'bg-white rounded-xl shadow-md overflow-hidden']) }}>
    @if(isset($header))
    <div class="px-6 py-4 border-b border-gray-200">
        {{ $header }}
    </div>
    @endif
    
    <div class="p-6">
        {{ $slot }}
    </div>
    
    @if(isset($footer))
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
        {{ $footer }}
    </div>
    @endif
</div>