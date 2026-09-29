@props([
    'path' => null,
    'icon' => 'fa-image',
    'size' => '100px',
    'alt' => '',
    'rounded' => false,
])

@php
    $boxStyle = "width:{$size};height:{$size};" . ($rounded ? 'border-radius:50%;' : 'border-radius:10px;');
    $defaultStyle = $boxStyle . 'background:var(--image-placeholder-bg, #EEF0F4);display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;';
    $iconSize = preg_match('/^([0-9.]+)px$/', $size, $matches) ? ((float) $matches[1] * 0.36) . 'px' : '2.5rem';
    $imageUrl = $path && str_starts_with($path, 'images/') ? asset($path) : ($path ? asset('storage/' . $path) : null);
@endphp

<div {{ $attributes->except('style')->merge(['class' => 'image-or-icon'])->merge(['style' => $defaultStyle . $attributes->get('style', '')]) }}>
    @if($path)
        <img src="{{ $imageUrl }}" alt="{{ $alt }}" style="width:100%;height:100%;object-fit:cover;">
    @else
        <i class="fa-solid {{ $icon }}" aria-hidden="true" style="font-size:{{ $iconSize }};color:var(--image-placeholder-icon, #687589);"></i>
    @endif
</div>
