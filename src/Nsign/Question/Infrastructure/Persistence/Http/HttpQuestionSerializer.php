<?php

declare(strict_types=1);

namespace App\Nsign\Question\Infrastructure\Persistence\Http;

use App\Nsign\Question\Domain\Question;
use App\Nsign\Question\Domain\QuestionId;
use App\Nsign\Question\Domain\Score;
use App\Nsign\Question\Domain\Tag;
use App\Nsign\Question\Domain\Tags;
use App\Nsign\Question\Domain\Title;
use App\Shared\Nsign\Domain\UserId;

final class HttpQuestionSerializer
{
    public function deserialize(array $data)
    {
        return new Question(
            QuestionId::fromInt($data['question_id']),
            UserId::tryFromInt(isset($data['owner']) ? $data['owner']['user_id'] : null),
            new Tags(...array_map(fn(string $tag) => Tag::fromString($tag),$data['tags'])),
            $data['is_answered'],
            Score::fromInt($data['score']),
            Title::fromString($data['title']),
        );
    }
}