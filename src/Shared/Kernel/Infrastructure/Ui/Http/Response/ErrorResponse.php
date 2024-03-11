<?php

declare(strict_types=1);

namespace App\Shared\Kernel\Infrastructure\Ui\Http\Response;

final readonly class ErrorResponse implements SerializableResponse
{
    public function __construct(
        public string $message,
        private int $status,
    ) {
    }

    public function statusCode(): int
    {
        return $this->status;
    }
}
