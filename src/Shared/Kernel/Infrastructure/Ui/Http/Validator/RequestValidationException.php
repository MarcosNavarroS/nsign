<?php

namespace App\Shared\Kernel\Infrastructure\Ui\Http\Validator;

use Exception;

class RequestValidationException extends Exception
{
    private $errors = [];

    public function __construct(array $errors)
    {
        $this->errors = $errors;

        $message = json_encode(array_map(function (ValidationError $exception) {
            return $exception->getMessage();
        }, $errors));

        parent::__construct($message);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function toArray(): array
    {
        /** @var ValidationError $error */
        foreach ($this->errors as $error) {
            $errors[$error->getField()] = $error->getMessage();
        }

        return $errors ?? [];
    }
}
