<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Middleware sozlesmesi.
 * Router bir rotayi calistirmadan ONCE middleware'lerin handle()'ini cagirir.
 * Middleware isterse ici bos donebilir (izin verir),
 * isterse yonlendirme/hata dondurup rotanin calismasini engelleyebilir.
 */
interface MiddlewareInterface
{
    public function handle(Request $request): void;
}
