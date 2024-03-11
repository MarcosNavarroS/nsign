<?php

declare(strict_types=1);

namespace App\Nsign\Question\Infrastructure\Ui\Http\Controller\GetQuestionById;

use App\Nsign\Question\Application\GetQuestionById\GetQuestionByIdUseCaseResponse;
use App\Shared\Kernel\Infrastructure\Ui\Http\Response\SerializableResponse;
use Symfony\Component\HttpFoundation\Response;

final readonly class GetQuestionByIdResponse implements SerializableResponse
{
    public function __construct(
        public int $id,
        public ?int $userId,
        public array $tags,
        public bool $isAnswered,
        public int $score,
        public string $title,
    ) {
    }

    public static function fromApplication(GetQuestionByIdUseCaseResponse $response): GetQuestionByIdResponse
    {
        return new self(
            $response->questionId,
            $response->userId,
            $response->tags,
            $response->isAnswered,
            $response->score,
            $response->title,
        );
    }

    public function statusCode(): int
    {
        return Response::HTTP_OK;
    }
}