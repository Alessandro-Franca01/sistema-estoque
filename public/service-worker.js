self.addEventListener("install", (event) => {
    event.waitUntil(
        caches.open("gestin-cache-v1").then((cache) => {
            return cache.addAll([
                "/",
                "/index.html"
                // Adicione aqui CSS, JS e imagens críticas do sistema
            ]);
        })
    );
});

self.addEventListener("fetch", (event) => {
    event.respondWith(
        caches.match(event.request).then((response) => {
            return response || fetch(event.request);
        })
    );
});
