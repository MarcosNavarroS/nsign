<?php

declare(strict_types=1);

namespace App\Nsign\Question\Domain;

final class Question
{
    public function __construct(
        private readonly QuestionId $id,
        private readonly Owner $owner,
        private readonly bool $isAnswered,
        private readonly bool $isClosed,
        private readonly Score $score,
        private readonly Title $title,
        private readonly Body $body,
    ) {
    }

    public function id(): QuestionId
    {
        return $this->id;
    }

    public function owner(): Owner
    {
        return $this->owner;
    }

    public function isAnswered(): bool
    {
        return $this->isAnswered;
    }

    public function isClosed(): bool
    {
        return $this->isClosed;
    }

    public function score(): Score
    {
        return $this->score;
    }

    public function title(): Title
    {
        return $this->title;
    }

    public function body(): Body
    {
        return $this->body;
    }
}