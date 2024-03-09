<?php

declare(strict_types=1);

namespace App\Nsign\Question\Domain;

use App\Shared\Kernel\Domain\Text;

final class Title extends Text
{
    protected function validate(): void
    {
        $this->validator()->notBlank();
    }
}