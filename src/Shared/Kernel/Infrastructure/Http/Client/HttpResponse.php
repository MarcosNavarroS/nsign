<?php

declare(strict_types=1);

namespace App\Shared\Kernel\Infrastructure\Http\Client;

final class HttpResponse
{
    public function __construct(
        public readonly int $statusCode,
        public readonly array $headers,
        public readonly string $content,
    ) {
    }
}
