import { loadSettings, prefersReducedMotion } from './settings';

/** 5-4-3-2-1 method: one sense per step. */
export const SENSES = [
    { n: 5, word: 'siehst' },
    { n: 4, word: 'fühlst' },
    { n: 3, word: 'hörst' },
    { n: 2, word: 'riechst' },
    { n: 1, word: 'schmeckst' },
];

/** Breathing rhythms as [phase, seconds] sequences. */
export const RHYTHMS = {
    '4-6': [['in', 4], ['out', 6]],
    '4-7-8': [['in', 4], ['hold', 7], ['out', 8]],
    box: [['in', 4], ['hold', 4], ['out', 4], ['hold', 4]],
};

const LABELS = { in: 'Einatmen', hold: 'Halten', out: 'Ausatmen' };

const FADE_MS = 200;
const BETWEEN_MS = 1900;
const START_DELAY_MS = 60;

/**
 * Alpine component: home, exercise and completion screen.
 * All counting and breathing happens locally; the Livewire component is
 * called exactly once per completed exercise.
 */
export default function grounding() {
    return {
        screen: 'home', // 'home' | 'exercise' | 'done'
        step: 0,
        remaining: SENSES[0].n,
        between: false,
        fading: false,
        phase: 'in',
        big: false,
        dur: 0,
        startedAt: null,
        settings: loadSettings(),
        timers: { breath: null, fade: null, between: null },

        init() {
            this.timers.breath = setTimeout(() => this.runPhase(0), 80);
        },

        destroy() {
            Object.values(this.timers).forEach(clearTimeout);
        },

        // ---- Breathing pacer ---------------------------------------------

        get rhythm() {
            return RHYTHMS[this.settings.rhythm] ?? RHYTHMS['4-6'];
        },

        get reduced() {
            return prefersReducedMotion(this.settings);
        },

        runPhase(index) {
            const sequence = this.rhythm;
            const i = index % sequence.length;
            const [phase, seconds] = sequence[i];

            this.phase = phase;
            this.dur = seconds * 1000;
            if (phase === 'in') this.big = true;
            if (phase === 'out') this.big = false;

            this.timers.breath = setTimeout(() => this.runPhase(i + 1), seconds * 1000);
        },

        get smallScale() {
            return this.reduced ? 0.86 : 0.6;
        },

        get circleStyle() {
            return {
                transform: `scale(${this.big ? 1 : this.smallScale})`,
                transition: `transform ${this.dur}ms cubic-bezier(.37,0,.63,1)`,
            };
        },

        get haloStyle() {
            return {
                transform: `scale(${this.big ? 1.04 : this.smallScale + 0.02})`,
                transition: `transform ${this.dur}ms cubic-bezier(.37,0,.63,1)`,
            };
        },

        get phaseLabel() {
            return LABELS[this.phase];
        },

        // ---- Exercise texts ------------------------------------------------

        get sense() {
            return SENSES[this.step];
        },

        get stepNo() {
            return this.step + 1;
        },

        get noun() {
            return this.sense.n === 1 ? 'Ding, das du' : 'Dinge, die du';
        },

        get liveText() {
            if (this.screen !== 'exercise') return '';
            if (this.between) return 'Gut gemacht.';

            const noun = this.remaining === 1 ? 'Ding, das du' : 'Dinge, die du';

            return `Noch ${this.remaining} ${noun} ${this.sense.word}.`;
        },

        get numberStyle() {
            return {
                opacity: this.fading ? 0 : 1,
                transform: `translateY(${this.fading ? 6 : 0}px)`,
            };
        },

        dotStyle(i) {
            return {
                width: `${i === this.step ? 26 : 8}px`,
                background: i <= this.step ? 'var(--calm-text)' : 'var(--calm-muted)',
                opacity: i === this.step ? 0.9 : i < this.step ? 0.55 : 0.25,
            };
        },

        // ---- Actions -------------------------------------------------------

        start() {
            Object.values(this.timers).forEach(clearTimeout);
            this.settings = loadSettings();

            this.startedAt = Date.now();
            this.step = 0;
            this.remaining = SENSES[0].n;
            this.between = false;
            this.fading = false;
            this.phase = 'in';
            // Jump to the small circle without animation, then start inhaling.
            this.big = false;
            this.dur = 0;
            this.show('exercise', 'exercise');

            this.timers.breath = setTimeout(() => this.runPhase(0), START_DELAY_MS);
        },

        tap() {
            if (this.screen !== 'exercise' || this.between || this.fading) return;

            if (this.settings.haptics && typeof navigator.vibrate === 'function') {
                navigator.vibrate(12);
            }

            this.fading = true;

            this.timers.fade = setTimeout(() => {
                const remaining = this.remaining - 1;

                if (remaining > 0) {
                    this.remaining = remaining;
                    this.fading = false;

                    return;
                }

                this.remaining = 0;
                this.between = true;
                this.fading = false;
                this.timers.between = setTimeout(() => this.nextSense(), BETWEEN_MS);
            }, FADE_MS);
        },

        nextSense() {
            const next = this.step + 1;

            if (next >= SENSES.length) {
                this.finish();

                return;
            }

            this.step = next;
            this.remaining = SENSES[next].n;
            this.between = false;
        },

        finish() {
            const minutes = Math.max(1, Math.round((Date.now() - this.startedAt) / 60000));

            this.between = false;
            this.show('done', 'doneTitle');

            // Best effort: the exercise must never depend on the network.
            Promise.resolve(this.$wire.complete(minutes)).catch(() => {});
        },

        exit() {
            clearTimeout(this.timers.fade);
            clearTimeout(this.timers.between);
            this.between = false;
            this.fading = false;
            this.show('home', 'calmifyButton');
        },

        onKey(event) {
            // Keys on the nested close button must keep their own meaning.
            if (event.target !== event.currentTarget) return;

            if (event.key === ' ' || event.key === 'Enter') {
                event.preventDefault();
                this.tap();
            }
        },

        /** Switches the screen and moves focus for keyboard & screen-reader users. */
        show(screen, focusRef) {
            this.screen = screen;

            // x-show reveals elements in an animation frame; focus only afterwards.
            this.$nextTick(() => requestAnimationFrame(() => {
                window.scrollTo(0, 0);
                this.$refs[focusRef]?.focus({ preventScroll: true });
            }));
        },
    };
}
