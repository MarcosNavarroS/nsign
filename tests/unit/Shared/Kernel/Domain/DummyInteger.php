<?php

declare(strict_types=1);

namespace App\Tests\unit\Shared\Kernel\Domain;

use App\Shared\Kernel\Domain\Integer;

final class DummyInteger extends Integer
{
    protected function validate(): void
    {
    }
}
