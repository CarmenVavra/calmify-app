@props(['as' => 'h2'])

<{{ $as }} {{ $attributes->merge(['class' => 'px-1 text-[14px] font-normal uppercase tracking-[.14em] text-calm-muted']) }}>{{ $slot }}</{{ $as }}>
