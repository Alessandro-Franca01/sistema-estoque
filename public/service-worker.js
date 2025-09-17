self.addEventListener("install", (event) => {
  const VERSION = "v1.0.0";
  const CACHE_NAME = `gestin-cache-${VERSION}`;

  // Pré-cache de rotas/app shell mínimas
  event.waitUntil(
    (async () => {
      const cache = await caches.open(CACHE_NAME);
      try {
        await cache.addAll([
          "/",
          "/favicon.ico",
          "/manifest.json",
        ]);
      } catch (e) {
        // Falhas de pré-cache não devem impedir a instalação
        console.warn("[SW] Precache falhou:", e);
      }
      // Torna o SW ativo imediatamente após instalação
      await self.skipWaiting();
    })()
  );
});

// Limpa caches antigos na ativação
self.addEventListener("activate", (event) => {
  const VERSION = "v1.0.0";
  const CURRENT_CACHE = `gestin-cache-${VERSION}`;
  event.waitUntil(
    (async () => {
      const keys = await caches.keys();
      await Promise.all(
        keys
          .filter((key) => key.startsWith("gestin-cache-") && key !== CURRENT_CACHE)
          .map((key) => caches.delete(key))
      );
      await self.clients.claim();
    })()
  );
});

// Permite que o app solicite a ativação imediata do SW atualizado
self.addEventListener("message", (event) => {
  if (event.data && event.data.type === "SKIP_WAITING") {
    self.skipWaiting();
  }
});

// Estratégias de cache:
// - HTML: network-first (para sempre buscar páginas atualizadas)
// - Assets (css/js/imagens): cache-first com fallback à rede
self.addEventListener("fetch", (event) => {
  const req = event.request;
  const url = new URL(req.url);

  // Apenas lidar com requisições do mesmo domínio
  if (url.origin !== self.location.origin) return;

  if (req.mode === "navigate" || (req.destination === "document" && req.method === "GET")) {
    // Páginas HTML: network-first
    event.respondWith(networkFirst(req));
  } else if (["style", "script", "image", "font"].includes(req.destination)) {
    // Assets estáticos: cache-first
    event.respondWith(cacheFirst(req));
  }
});

async function networkFirst(request) {
  const cache = await caches.open(getCurrentCacheName());
  try {
    const fresh = await fetch(request);
    cache.put(request, fresh.clone());
    return fresh;
  } catch (e) {
    const cached = await cache.match(request);
    if (cached) return cached;
    // Fallback básico para offline
    return new Response("Offline", { status: 503, statusText: "Offline" });
  }
}

async function cacheFirst(request) {
  const cache = await caches.open(getCurrentCacheName());
  const cached = await cache.match(request);
  if (cached) return cached;
  const fresh = await fetch(request);
  cache.put(request, fresh.clone());
  return fresh;
}

function getCurrentCacheName() {
  const VERSION = "v1.0.0";
  return `gestin-cache-${VERSION}`;
}
