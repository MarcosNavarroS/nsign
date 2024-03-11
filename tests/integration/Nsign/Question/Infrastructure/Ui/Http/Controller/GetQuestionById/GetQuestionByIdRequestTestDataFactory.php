<?php

declare(strict_types=1);

namespace App\Tests\integration\Nsign\Question\Infrastructure\Ui\Http\Controller\GetQuestionById;

use App\Nsign\Question\Infrastructure\Ui\Http\Controller\GetQuestionById\GetQuestionByIdRequest;

final class GetQuestionByIdRequestTestDataFactory
{
    public static function create(
        int $questionId = 123123,
    ): GetQuestionByIdRequest {
        return new GetQuestionByIdRequest(
            $questionId,
        );
    }
}