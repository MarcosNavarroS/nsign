<?php

declare(strict_types=1);

namespace App\Nsign\Question\Domain;

use App\Shared\Nsign\Domain\UserId;

final class Question
{
    public function __construct(
        private readonly QuestionId $id,
        private readonly ?UserId $userId,
        private readonly Tags $tags,
        private readonly bool $isAnswered,
        private readonly Score $score,
        private readonly Title $title,
    ) {
    }

    public function id(): QuestionId
    {
        return $this->id;
    }

    public function userId(): ?UserId
    {
        return $this->userId;
    }

    public function tags(): Tags
    {
        return $this->tags;
    }

    public function isAnswered(): bool
    {
        return $this->isAnswered;
    }

    public function score(): Score
    {
        return $this->score;
    }

    public function title(): Title
    {
        return $this->title;
    }
}