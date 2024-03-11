<?php

declare(strict_types=1);

namespace App\Shared\Kernel\Infrastructure\Http\Client;

final class HttpException extends \Exception
{
    public function __construct(?\Throwable $previous = null)
    {
        parent::__construct('Http Exception. '.$previous?->getMessage(), 0, $previous);
    }
}
