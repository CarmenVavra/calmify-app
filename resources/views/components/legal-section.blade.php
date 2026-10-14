{{-- Heading + text block for the legal pages. --}}
@props(['title', 'id' => null])

<section @if ($id) id="{{ $id }}" @endif
         {{ $attributes->class('flex scroll-mt-6 flex-col gap-3 px-1 text-[16px] leading-[1.55] text-calm-text [&_a]:underline [&_a]:underline-offset-4 [&_ul]:flex [&_ul]:list-disc [&_ul]:flex-col [&_ul]:gap-1.5 [&_ul]:pl-5') }}>
    <h2 class="text-[21px] font-medium leading-snug">{{ $title }}</h2>
    {{ $slot }}
</section>
