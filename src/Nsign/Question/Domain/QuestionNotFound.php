<?php

declare(strict_types=1);

namespace App\Nsign\Question\Domain;

use Exception;

final class QuestionNotFound extends Exception
{
    private function __construct(string $message = '')
    {
        parent::__construct($message);
    }

    public static function withId(int $id): self
    {
        return new self(sprintf('Could not find question with id %d', $id));
    }
}