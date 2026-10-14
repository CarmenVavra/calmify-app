{{--
    Breathing pacer: halo + core circle, both scaled by the surrounding
    Alpine `grounding` component. The slot is not scaled so it stays legible.
--}}
@props(['coreInset' => 'inset-[11%]', 'shadow' => true])

<div {{ $attributes->merge(['class' => 'relative grid aspect-square w-full place-items-center']) }}>
    <div aria-hidden="true" class="absolute inset-0 rounded-full bg-calm-accent opacity-[.13]" :style="haloStyle"></div>
    <div aria-hidden="true" @class(['absolute rounded-full bg-calm-circle', $coreInset, 'shadow-calm-circle' => $shadow]) :style="circleStyle"></div>
    <div class="relative flex flex-col items-center gap-0.5">
        {{ $slot }}
    </div>
</div>
