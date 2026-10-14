import defaultTheme from 'tailwindcss/defaultTheme';

/**
 * Design tokens from the Calmify design handoff.
 * Colours are CSS variables so the theme (Salbei | Nachtblau) can switch at runtime.
 *
 * @type {import('tailwindcss').Config}
 */
export default {
    content: [
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                calm: {
                    outer: 'var(--calm-outer)',
                    bg: 'var(--calm-bg)',
                    surface: 'var(--calm-surface)',
                    btn: 'var(--calm-btn)',
                    circle: 'var(--calm-circle)',
                    accent: 'var(--calm-accent)',
                    text: 'var(--calm-text)',
                    muted: 'var(--calm-muted)',
                    line: 'var(--calm-line)',
                    sos: 'var(--calm-sos)',
                },
            },
            fontFamily: {
                sans: ['"Atkinson Hyperlegible Next"', 'system-ui', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                'calm-button': '0 24px 60px -24px rgba(0,0,0,.55), inset 0 1px 0 rgba(255,255,255,.06)',
                'calm-circle': '0 30px 70px -30px rgba(0,0,0,.5)',
            },
            keyframes: {
                'calm-halo': {
                    '0%': { transform: 'scale(1)', opacity: '.22' },
                    '100%': { transform: 'scale(1.12)', opacity: '.06' },
                },
                'calm-fade': {
                    from: { opacity: '0' },
                    to: { opacity: '1' },
                },
            },
            animation: {
                'calm-halo': 'calm-halo 5s ease-in-out infinite alternate',
                'calm-fade': 'calm-fade .8s ease both',
                'calm-fade-fast': 'calm-fade .6s ease both',
                'calm-fade-slow': 'calm-fade 1s ease both',
            },
            transitionTimingFunction: {
                breath: 'cubic-bezier(.37,0,.63,1)',
            },
        },
    },
    plugins: [],
};
