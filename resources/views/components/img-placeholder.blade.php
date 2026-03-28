{{-- Reusable bakery-themed placeholder for missing images --}}
@props(['class' => ''])

<div {{ $attributes->merge(['class' => 'bg-brand-blush flex items-center justify-center ' . $class]) }}>
    <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg"
        class="w-16 h-16 opacity-40">
        {{-- Cake base --}}
        <rect x="12" y="46" width="56" height="18" rx="4" fill="#A09890"/>
        {{-- Cake middle layer --}}
        <rect x="18" y="32" width="44" height="16" rx="3" fill="#A09890" opacity=".75"/>
        {{-- Cake top layer --}}
        <rect x="24" y="20" width="32" height="14" rx="3" fill="#A09890" opacity=".55"/>
        {{-- Candles --}}
        <rect x="34" y="12" width="4" height="10" rx="2" fill="#7D766C"/>
        <rect x="42" y="14" width="4" height="8" rx="2" fill="#7D766C"/>
        {{-- Flames --}}
        <ellipse cx="36" cy="11" rx="2" ry="3" fill="#EAEAE6"/>
        <ellipse cx="44" cy="13" rx="2" ry="2.5" fill="#EAEAE6"/>
        {{-- Decoration dots on base --}}
        <circle cx="24" cy="55" r="2" fill="white" opacity=".6"/>
        <circle cx="34" cy="55" r="2" fill="white" opacity=".6"/>
        <circle cx="44" cy="55" r="2" fill="white" opacity=".6"/>
        <circle cx="54" cy="55" r="2" fill="white" opacity=".6"/>
    </svg>
</div>
