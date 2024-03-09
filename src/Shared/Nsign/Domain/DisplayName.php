<?php

declare(strict_types=1);

namespace App\Shared\Nsign\Domain;

use App\Shared\Kernel\Domain\Text;

final class DisplayName extends Text
{
    protected function validate(): void
    {
        $this->validator()->notBlank();
    }
}