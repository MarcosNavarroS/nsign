<?php

declare(strict_types=1);

namespace App\Nsign\Question\Domain;

use App\Shared\Kernel\Domain\Collection;

final class Tags extends Collection
{
    public function __construct(Tag ...$tag)
    {
        parent::__construct($tag);
    }
}