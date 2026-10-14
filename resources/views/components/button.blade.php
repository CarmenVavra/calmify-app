{{-- Pill button (60px high). Renders an <a> when `href` is given. --}}
@props(['variant' => 'primary', 'href' => null, 'type' => 'button'])

@php
    $classes = [
        'inline-flex min-h-[60px] w-full items-center justify-center rounded-full px-6 text-center text-[18px] transition-[filter] duration-300 hover:brightness-110 focus-visible:outline-offset-4',
        match ($variant) {
            'outline' => 'border-[1.5px] border-calm-line bg-transparent text-calm-text hover:text-calm-text',
            'danger' => 'border-[1.5px] border-calm-sos bg-transparent text-calm-text hover:text-calm-text',
            default => 'bg-calm-btn font-medium text-calm-text hover:text-calm-text',
        },
    ];
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->class($classes) }}>{{ $slot }}</button>
@endif
