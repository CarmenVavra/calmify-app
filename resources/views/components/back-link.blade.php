@props(['href', 'label' => 'Zurück'])

<div class="flex items-center gap-1.5">
    <a href="{{ $href }}" {{ $attributes->merge(['class' => 'flex h-12 min-w-12 items-center gap-1.5 rounded-full pl-1 pr-3 text-[17px] text-calm-muted no-underline focus-visible:outline-offset-2']) }}>
        <span aria-hidden="true" class="text-[26px] leading-none">‹</span>
        <span>{{ $label }}</span>
    </a>
</div>
