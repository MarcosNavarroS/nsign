<?php

declare(strict_types=1);

namespace App\Tests\unit\Shared\Kernel\Domain;

use App\Shared\Kernel\Domain\Text;

final class DummyText extends Text
{
    protected function validate(): void
    {
    }
}
