<?php

declare(strict_types=1);

namespace App\Nsign\Question\Application\GetQuestionById;

use App\Nsign\Question\Domain\Question;
use App\Nsign\Question\Domain\Tag;

final class GetQuestionByIdUseCaseResponse
{
    public function __construct(
        public int $questionId,
        public ?int $userId,
        public array $tags,
        public bool $isAnswered,
        public int $score,
        public string $title,
    )
    {
    }

    public static function fromDomain(Question $question): GetQuestionByIdUseCaseResponse
    {
        return new self(
            $question->id()->toInt(),
            $question->userId()->toInt(),
            $question->tags()->map(
                fn(Tag $tag) => $tag->toString()
            ),
            $question->isAnswered(),
            $question->score()->toInt(),
            $question->title()->toString(),
        );
    }
}