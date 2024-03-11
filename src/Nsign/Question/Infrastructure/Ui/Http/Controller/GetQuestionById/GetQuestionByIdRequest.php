<?php

declare(strict_types=1);

namespace App\Nsign\Question\Infrastructure\Ui\Http\Controller\GetQuestionById;


use App\Shared\Kernel\Infrastructure\Ui\Http\Request\SerializableRequest;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Type;

final readonly class GetQuestionByIdRequest implements SerializableRequest
{
    public function __construct(
        public int $questionId
    ) {
    }

    public static function validationConstraint(): Constraint
    {
        return new Collection([
            'fields' => [
                'questionId' => [
                    new Type('numeric'),
                    new Positive(),
                ],
            ],
        ]);
    }
}