<?php

namespace App\Shared\Kernel\Infrastructure\Ui\Http\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestValidator
{

    public function __construct(private ValidatorInterface $validator)
    {
    }

    public function validateArray(array $data, Constraint $constraints): void
    {
        $errors = $this->validator->validate($data, $constraints);

        if (count($errors) > 0) {
            throw new RequestValidationException($this->getValidationErrors($errors));
        }
    }

    private function getValidationErrors(ConstraintViolationListInterface $errors): array
    {
        $errorList = [];
        foreach ($errors as $error) {
            $key = strtolower(preg_replace('/[A-Z]/', '_\\0', lcfirst($error->getPropertyPath())));
            $errorList[$key] = new ValidationError($error->getPropertyPath(), (string)$error->getMessage());
        }

        return $errorList;
    }
}
