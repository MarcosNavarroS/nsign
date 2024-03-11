<?php

namespace App\Shared\Kernel\Infrastructure\Ui\Http\Validator;

use Exception;

class ValidationError extends Exception
{
    private $field;

    public function __construct(
        string $field,
        string $message
    ) {
        parent::__construct($message);
        $this->field = $field;
    }

    public function getField(): string
    {
        return $this->field;
    }
}
