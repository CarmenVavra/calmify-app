{{-- One-tap call card: the whole card is the tel: link. --}}
@props(['href', 'name', 'detail' => null, 'variant' => 'surface'])

<a href="{{ $href }}"
   {{ $attributes->class([
       'flex min-h-[80px] items-center gap-4 rounded-[24px] py-3.5 pl-5 pr-3.5 text-calm-text no-underline hover:text-calm-text focus-visible:outline-offset-[3px]',
       'bg-calm-surface' => $variant === 'surface',
       'border-[1.5px] border-calm-line bg-transparent' => $variant === 'outline',
   ]) }}>
    <span class="flex min-w-0 flex-1 flex-col gap-[3px]">
        <span class="break-words text-[19px] font-medium">{{ $name }}</span>
        @if ($detail)
            <span class="break-words text-[15px] text-calm-muted">{{ $detail }}</span>
        @endif
    </span>
    <span @class([
        'grid h-[52px] min-w-[104px] flex-none place-items-center rounded-full px-[18px] text-[16px] font-medium',
        'bg-calm-btn' => $variant === 'surface',
        'border-[1.5px] border-calm-line' => $variant === 'outline',
    ])>Anrufen</span>
</a>
