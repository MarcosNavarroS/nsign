<?php

declare(strict_types=1);

namespace App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria;

enum Order: string
{
    case asc = 'asc';
    case desc = 'desc';
}