<?php

declare(strict_types=1);

namespace App\Nsign\Question\Application\GetQuestionById;

final readonly class GetQuestionByIdUseCaseRequest
{
    public function __construct(
        public int $questionId
    ) {
    }
}