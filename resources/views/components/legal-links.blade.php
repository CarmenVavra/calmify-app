{{-- Footer links to the legal pages, reachable from every screen. --}}
@php
    $links = [
        'legal.about' => 'Über Calmify',
        'legal.imprint' => 'Impressum',
        'legal.privacy' => 'Datenschutz',
    ];
@endphp

<nav aria-label="Rechtliches" {{ $attributes->class('flex flex-wrap items-center justify-center gap-x-1 text-[14px] text-calm-muted') }}>
    @foreach ($links as $route => $label)
        <a href="{{ route($route) }}"
           @if (request()->routeIs($route)) aria-current="page" @endif
           class="rounded-full px-2.5 py-2.5 text-calm-muted no-underline underline-offset-4 hover:text-calm-text hover:underline aria-[current=page]:text-calm-text">{{ $label }}</a>
    @endforeach
</nav>
