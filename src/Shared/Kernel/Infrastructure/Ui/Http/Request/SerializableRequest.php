<?php

declare(strict_types=1);

namespace App\Shared\Kernel\Infrastructure\Ui\Http\Request;

use Symfony\Component\Validator\Constraint;

interface SerializableRequest
{
    public static function validationConstraint(): Constraint;
}
