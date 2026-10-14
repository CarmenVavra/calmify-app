{{-- Sub-page frame (SOS, settings, forms): back link, heading, intro text. --}}
@props(['title', 'subtitle' => null, 'back' => null, 'backLabel' => 'Zurück'])

<section aria-labelledby="screen-title" {{ $attributes->merge(['class' => 'flex flex-1 animate-calm-fade-fast flex-col gap-7 px-5 pb-10 pt-3.5']) }}>
    <x-back-link :href="$back ?? route('home')" :label="$backLabel" />

    <x-flash />

    <div class="flex flex-col gap-2 px-1">
        <h1 id="screen-title" class="text-[30px] font-medium leading-tight">{{ $title }}</h1>
        @if ($subtitle)
            <p class="text-[17px] leading-[1.45] text-calm-muted">{{ $subtitle }}</p>
        @endif
    </div>

    {{ $slot }}
</section>
