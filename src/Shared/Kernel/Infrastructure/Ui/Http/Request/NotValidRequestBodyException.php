<?php

declare(strict_types=1);

namespace App\Shared\Kernel\Infrastructure\Ui\Http\Request;

final class NotValidRequestBodyException extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct("The request body it's not a valid json");
    }
}
