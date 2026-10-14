/*
 * Calmify service worker: the grounding exercise must start even offline.
 *
 * - Build assets (hashed file names): cache first.
 * - Home page: network first, cached copy as offline fallback.
 * - Other pages are never cached (they may contain personal contacts);
 *   offline they fall back to the cached home page.
 */
const CACHE = 'calmify-v1';
const HOME = '/';

self.addEventListener('install', (event) => {
    event.waitUntil(caches.open(CACHE).then((cache) => cache.add(HOME)).then(() => self.skipWaiting()));
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys()
            .then((keys) => Promise.all(keys.filter((key) => key !== CACHE).map((key) => caches.delete(key))))
            .then(() => self.clients.claim()),
    );
});

self.addEventListener('fetch', (event) => {
    const request = event.request;
    const url = new URL(request.url);

    if (request.method !== 'GET' || url.origin !== self.location.origin) {
        return;
    }

    if (url.pathname.startsWith('/build/') || url.pathname === '/icon.svg') {
        event.respondWith(
            caches.match(request).then((cached) => cached || fetch(request).then((response) => {
                if (response.ok) {
                    const copy = response.clone();
                    caches.open(CACHE).then((cache) => cache.put(request, copy));
                }

                return response;
            })),
        );

        return;
    }

    if (request.mode === 'navigate') {
        event.respondWith(
            fetch(request)
                .then((response) => {
                    if (response.ok && url.pathname === HOME) {
                        const copy = response.clone();
                        caches.open(CACHE).then((cache) => cache.put(HOME, copy));
                    }

                    return response;
                })
                .catch(() => caches.match(HOME)),
        );
    }
});
