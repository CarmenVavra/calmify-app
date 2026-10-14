/*
 * Calmify service worker: the grounding exercise must start even offline.
 *
 * - Build assets (hashed file names): cache first.
 * - Home page and legal pages: network first, cached copy as offline fallback.
 * - Other pages are never cached (they may contain personal contacts);
 *   offline they fall back to the cached home page.
 */
const CACHE = 'calmify-v2';
const HOME = '/';
const PUBLIC_PAGES = [HOME, '/ueber', '/impressum', '/datenschutz'];

self.addEventListener('install', (event) => {
    event.waitUntil(caches.open(CACHE).then((cache) => cache.addAll(PUBLIC_PAGES)).then(() => self.skipWaiting()));
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
                    if (response.ok && PUBLIC_PAGES.includes(url.pathname)) {
                        const copy = response.clone();
                        caches.open(CACHE).then((cache) => cache.put(url.pathname, copy));
                    }

                    return response;
                })
                .catch(() => caches.match(PUBLIC_PAGES.includes(url.pathname) ? url.pathname : HOME)),
        );
    }
});
