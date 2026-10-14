{{--
    Home, 5-4-3-2-1 grounding exercise and completion screen.
    State lives in the Alpine component `grounding` (resources/js/grounding.js):
    taps and breathing never hit the server; `$wire.complete()` runs once at the end.
--}}
<div x-data="grounding" class="flex flex-1 flex-col">

    {{-- 01 Home --------------------------------------------------------- --}}
    <section x-show="screen === 'home'"
             aria-labelledby="home-title"
             class="flex flex-1 animate-calm-fade flex-col items-center px-6 pb-12 pt-8">
        <x-wordmark />

        <div class="flex w-full flex-1 flex-col items-center justify-center gap-12">
            <h1 id="home-title" class="text-balance text-center text-[22px] font-normal leading-[1.45] text-calm-muted">
                Du bist hier sicher.<br>Wir atmen zusammen.
            </h1>

            <div class="relative grid aspect-square w-full max-w-[290px] place-items-center">
                <div aria-hidden="true" class="absolute inset-0 animate-calm-halo rounded-full bg-calm-accent opacity-[.16]"></div>
                <button type="button"
                        x-ref="calmifyButton"
                        x-on:click="start()"
                        class="relative flex h-[86.2%] w-[86.2%] cursor-pointer flex-col items-center justify-center gap-2.5 rounded-full border-0 bg-calm-btn text-calm-text shadow-calm-button focus-visible:outline-offset-[6px]">
                    <span class="text-[34px] font-semibold tracking-[-.01em]">Calmify Me</span>
                    <span class="text-[17px] text-calm-muted">Übung starten</span>
                </button>
            </div>

            <a href="{{ route('sos') }}"
               class="flex min-h-[60px] items-center gap-3 rounded-full border-[1.5px] border-calm-line bg-transparent px-[34px] text-[18px] text-calm-text no-underline hover:text-calm-text">
                <span aria-hidden="true" class="h-2.5 w-2.5 rounded-full bg-calm-sos"></span>
                <span>SOS Kontakte</span>
            </a>
        </div>
    </section>

    {{-- 02 Grounding exercise: the whole screen is the tap target ------- --}}
    <section x-show="screen === 'exercise'"
             x-cloak
             x-ref="exercise"
             role="button"
             tabindex="0"
             aria-label="Tippe, sobald du ein Ding benannt hast"
             x-on:click="tap()"
             x-on:keydown="onKey($event)"
             class="flex flex-1 animate-calm-fade cursor-pointer select-none flex-col px-5 pb-10 pt-3.5 focus-visible:shadow-[inset_0_0_0_3px_var(--calm-accent)] focus-visible:outline-none">
        <div class="flex items-center justify-between">
            <button type="button"
                    aria-label="Übung beenden"
                    x-on:click.stop="exit()"
                    class="grid h-12 w-12 cursor-pointer place-items-center rounded-full border-0 bg-transparent text-[30px] leading-none text-calm-muted focus-visible:outline-offset-2">×</button>
            <p class="text-[15px] tracking-[.04em] text-calm-muted">
                Schritt <span x-text="stepNo">1</span> von 5
            </p>
            <div class="w-12" aria-hidden="true"></div>
        </div>

        <h1 class="mt-7 text-balance text-center text-[27px] font-normal leading-[1.3]">
            Benenne <span x-text="sense.n">5</span> <span x-text="noun">Dinge, die du</span>
            <span class="font-semibold" x-text="sense.word">siehst</span>.
        </h1>

        <div class="grid min-h-[330px] flex-1 place-items-center">
            <x-breath-circle class="max-w-[310px]" core-inset="inset-[11%]">
                <div x-show="!between"
                     aria-hidden="true"
                     class="text-[118px] font-light leading-none tabular-nums transition-[opacity,transform] duration-[220ms] ease-in-out"
                     :style="numberStyle"
                     x-text="remaining">5</div>
                <div x-show="between" x-cloak class="animate-calm-fade-fast pb-5 pt-[30px] text-[30px] font-medium leading-[1.2]">
                    Gut gemacht.
                </div>
                <div class="text-[18px] uppercase tracking-[.14em] text-calm-text" x-text="phaseLabel">Einatmen</div>
            </x-breath-circle>
        </div>

        <p class="mb-[26px] text-balance text-center text-[17px] leading-[1.45] text-calm-muted">
            Sag es leise oder denk es dir.<br>Dann tippe irgendwo.
        </p>

        <div aria-hidden="true" class="flex items-center justify-center gap-2.5">
            @for ($i = 0; $i < 5; $i++)
                <span class="h-2 rounded-full transition-all duration-[600ms] ease-in-out" :style="dotStyle({{ $i }})"></span>
            @endfor
        </div>

        <div aria-live="polite" class="sr-only" x-text="liveText"></div>
    </section>

    {{-- 03 Completion -------------------------------------------------- --}}
    <section x-show="screen === 'done'"
             x-cloak
             aria-labelledby="done-title"
             class="flex flex-1 animate-calm-fade-slow flex-col items-center px-6 pb-12 pt-8">
        <x-wordmark />

        <div class="flex w-full flex-1 flex-col items-center justify-center gap-9">
            <x-breath-circle class="max-w-[200px]" core-inset="inset-6" :shadow="false">
                <div class="text-[16px] uppercase tracking-[.14em]" x-text="phaseLabel">Einatmen</div>
            </x-breath-circle>

            <div class="flex flex-col gap-3 text-center">
                <h1 id="done-title" x-ref="doneTitle" tabindex="-1" class="text-[30px] font-medium focus-visible:outline-none">
                    Du hast es geschafft.
                </h1>
                <p class="text-balance text-[18px] leading-normal text-calm-muted">
                    Spür kurz nach, wie sich dein Körper jetzt anfühlt. Du kannst einfach weiter atmen.
                </p>
            </div>

            <div class="flex w-full max-w-[320px] flex-col gap-3.5">
                <x-button x-on:click="start()">Noch eine Runde</x-button>
                <x-button variant="outline" x-on:click="exit()">Zur Startseite</x-button>
            </div>
        </div>
    </section>
</div>
