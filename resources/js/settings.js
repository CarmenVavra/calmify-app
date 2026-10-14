/**
 * Device-local preferences (no server, no account needed).
 * The same storage key is read by the inline <head> script in the layout
 * to apply the theme before the first paint.
 */
export const STORAGE_KEY = 'calmify.settings';

export const OPTIONS = {
    theme: ['salbei', 'nachtblau'],
    rhythm: ['4-6', '4-7-8', 'box'],
    motion: ['sanft', 'reduziert'],
};

export const DEFAULTS = Object.freeze({
    theme: 'salbei',
    rhythm: '4-6',
    motion: 'sanft',
    haptics: true,
});

/** Returns sanitised settings; unknown or corrupt values fall back to defaults. */
export function loadSettings() {
    let stored = {};

    try {
        stored = JSON.parse(window.localStorage.getItem(STORAGE_KEY) || '{}') || {};
    } catch {
        stored = {};
    }

    const settings = { ...DEFAULTS };

    for (const [key, allowed] of Object.entries(OPTIONS)) {
        if (allowed.includes(stored[key])) {
            settings[key] = stored[key];
        }
    }

    if (typeof stored.haptics === 'boolean') {
        settings.haptics = stored.haptics;
    }

    return settings;
}

export function saveSettings(settings) {
    try {
        window.localStorage.setItem(STORAGE_KEY, JSON.stringify(settings));
    } catch {
        // Private mode / storage disabled: settings simply stay for this page view.
    }

    applySettings(settings);
}

/** Applies theme and motion preference to <html>. */
export function applySettings(settings) {
    const root = document.documentElement;

    if (settings.theme === 'nachtblau') {
        root.dataset.theme = 'nachtblau';
    } else {
        delete root.dataset.theme;
    }

    if (settings.motion === 'reduziert') {
        root.dataset.motion = 'reduced';
    } else {
        delete root.dataset.motion;
    }
}

export function prefersReducedMotion(settings) {
    return settings.motion === 'reduziert'
        || window.matchMedia('(prefers-reduced-motion: reduce)').matches;
}

/** Alpine component for the settings page. */
export function settingsForm() {
    return {
        settings: loadSettings(),

        init() {
            this.$watch('settings', (value) => saveSettings({ ...value }), { deep: true });
        },
    };
}

/**
 * Alpine component for the country choice. Stored as a cookie (one year)
 * because the server renders the matching crisis numbers on the SOS page.
 */
export function countryPicker(initial, cookieName) {
    return {
        country: initial,

        init() {
            this.$watch('country', (value) => {
                const secure = window.location.protocol === 'https:' ? '; Secure' : '';

                document.cookie = `${cookieName}=${encodeURIComponent(value)}; path=/; max-age=31536000; SameSite=Lax${secure}`;
            });
        },
    };
}
