const cacheName = 'equipment-cache-v1';
const assetsToCache = [
    '/',
    '/about',
    '/main.css',
    '/js/indexeddb.js',
    '/js/app.js',
    '/manifest.json'
];

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(cacheName)
            .then(cache => {
                console.log('Caching assets');
                return cache.addAll(assetsToCache);
            })
            .catch(error => console.error('Failed to cache assets:', error))
    );
});

self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                if (response) {
                    return response;
                }
                return fetch(event.request); 
            })
            .catch(error => console.error('Fetch error:', error))
    );
});

self.addEventListener('activate', event => {
    const cacheWhitelist = [cacheName];
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(name => {
                    if (!cacheWhitelist.includes(name)) {
                        return caches.delete(name);
                    }
                })
            );
        })
    );
});
