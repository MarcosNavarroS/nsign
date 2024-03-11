<?php

declare(strict_types=1);

namespace App\Tests\unit\Nsign\Question\Application\GetQuestionById;

use App\Nsign\Question\Application\GetQuestionById\GetQuestionByIdUseCaseRequest;

final class GetQuestionByIdUseCaseRequestTestDataFactory
{
    public static function create(
        int $questionId = 123123
    ): GetQuestionByIdUseCaseRequest
    {
        return new GetQuestionByIdUseCaseRequest(
            $questionId
        );
    }
}