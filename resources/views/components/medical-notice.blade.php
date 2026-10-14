{{--
    "Kein Medizinprodukt" notice. Shown in full on /ueber and as a disclosure
    on the home and SOS screens, so it never stands between someone and the
    exercise.
--}}
@props(['emergencyNumber' => '112', 'collapsible' => false])

@php
    $paragraphs = [
        'Calmify ist kein Medizinprodukt. Die App stellt keine Diagnosen und bietet keine Behandlung. Sie soll dir helfen, in einem akuten Moment wieder im Hier und Jetzt anzukommen.',
        'Du verdienst Unterstützung, die über eine App hinausgeht: Hausärztinnen und Hausärzte, Psychotherapeutinnen und Psychotherapeuten sowie die TelefonSeelsorge sind für dich da.',
        'Wenn du dich oder andere in Gefahr siehst, wähle bitte sofort den Notruf '.$emergencyNumber.'.',
    ];
@endphp

@if ($collapsible)
    <details {{ $attributes->class('group w-full rounded-[24px] border-[1.5px] border-calm-line px-5 py-1 text-left') }}>
        <summary class="flex min-h-12 cursor-pointer list-none items-center justify-between gap-3 text-[15px] text-calm-muted">
            <span>Wichtiger Hinweis: Calmify ist kein Medizinprodukt</span>
            <span aria-hidden="true" class="transition-transform group-open:rotate-90">›</span>
        </summary>
        <div class="flex flex-col gap-2.5 pb-4 pt-1 text-[15px] leading-[1.5] text-calm-text">
            @foreach ($paragraphs as $paragraph)
                <p>{{ $paragraph }}</p>
            @endforeach
        </div>
    </details>
@else
    <div {{ $attributes->class('flex flex-col gap-2.5 rounded-[24px] bg-calm-surface px-5 py-4 text-[16px] leading-[1.55] text-calm-text') }}>
        @foreach ($paragraphs as $paragraph)
            <p>{{ $paragraph }}</p>
        @endforeach
    </div>
@endif
