<?php

declare(strict_types=1);

namespace App\Tests\Support\Nsign\Question\Domain;

use App\Nsign\Question\Domain\Tag;
use App\Nsign\Question\Domain\Tags;

final class TagsTestDataFactory
{
    public static function create(
        Tag ...$tags
    ): Tags {
        if(empty($tags)) {
            $tags = [
                Tag::fromString('java'),
                Tag::fromString('csharp'),
            ];
        }
        return new Tags(...$tags);
    }
}