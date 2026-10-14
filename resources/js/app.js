import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import grounding from './grounding';
import { applySettings, countryPicker, loadSettings, settingsForm } from './settings';

applySettings(loadSettings());

Alpine.data('grounding', grounding);
Alpine.data('settingsForm', settingsForm);
Alpine.data('countryPicker', countryPicker);

// The only server call is the best-effort exercise log. A failed or expired
// request must never interrupt someone mid-crisis with an error dialog.
Livewire.hook('request', ({ fail }) => {
    fail(({ status, preventDefault }) => {
        preventDefault();
        console.warn(`Calmify: Protokollierung nicht möglich (Status ${status}).`);
    });
});

Livewire.start();

// Offline support: the exercise must start even without a connection.
if ('serviceWorker' in navigator && import.meta.env.PROD) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js').catch(() => {});
    });
}
