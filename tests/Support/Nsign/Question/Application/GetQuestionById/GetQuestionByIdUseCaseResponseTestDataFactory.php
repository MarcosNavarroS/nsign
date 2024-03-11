<?php

declare(strict_types=1);

namespace App\Tests\Support\Nsign\Question\Application\GetQuestionById;

use App\Nsign\Question\Application\GetQuestionById\GetQuestionByIdUseCaseResponse;

final class GetQuestionByIdUseCaseResponseTestDataFactory
{
    public static function create(
        int $questionId = 123321,
        int $userId = 111222,
        array $tags = ['java'],
        bool $isAnswered = false,
        int $score = 5,
        string $title = 'Question title'
    ): GetQuestionByIdUseCaseResponse {
        return new GetQuestionByIdUseCaseResponse(
            $questionId,
            $userId,
            $tags,
            $isAnswered,
            $score,
            $title
        );
    }
}