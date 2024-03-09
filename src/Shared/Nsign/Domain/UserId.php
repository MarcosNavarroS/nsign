<?php

declare(strict_types=1);

namespace App\Shared\Nsign\Domain;

use App\Shared\Kernel\Domain\Integer;

final class UserId extends Integer
{
    protected function validate(): void
    {
        $this->validator()->positive();
    }
}