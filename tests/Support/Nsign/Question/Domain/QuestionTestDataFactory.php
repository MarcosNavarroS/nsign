<?php

declare(strict_types=1);

namespace App\Tests\Support\Nsign\Question\Domain;

use App\Nsign\Question\Domain\Question;
use App\Nsign\Question\Domain\QuestionId;
use App\Nsign\Question\Domain\Score;
use App\Nsign\Question\Domain\Tag;
use App\Nsign\Question\Domain\Tags;
use App\Nsign\Question\Domain\Title;
use App\Shared\Nsign\Domain\UserId;

final class QuestionTestDataFactory
{
    public static function create(
        QuestionId|int $questionId = null,
        UserId|int $userId = null,
        Tags $tags = null,
        bool $isAnswered = false,
        Score|int $score = null,
        Title|string $title = null,
    ): Question {
        return new Question(
            is_int($questionId) ? QuestionId::fromInt($questionId) : $questionId ?? QuestionId::fromInt(123123),
            is_int($userId) ? UserId::fromInt($userId) : $userId ?? UserId::fromInt(321321),
            $tags ?? TagsTestDataFactory::create(),
            $isAnswered,
            is_int($score) ? Score::fromInt($score) : $score ?? Score::fromInt(5),
            is_string($title) ? Title::fromString($title) : $title ?? Title::fromString('Question title'),
        );
    }
}