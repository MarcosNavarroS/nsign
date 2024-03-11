<?php

declare(strict_types=1);

namespace App\Shared\Kernel\Infrastructure\Ui\Http\Response;

interface SerializableResponse
{
    public function statusCode(): int;
}
