<?php

declare(strict_types=1);

namespace App\Nsign\Question\Domain;

use App\Shared\Kernel\Domain\Integer;

final class QuestionId extends Integer
{
    protected function validate(): void
    {
        $this->validator()->positive();
    }
}