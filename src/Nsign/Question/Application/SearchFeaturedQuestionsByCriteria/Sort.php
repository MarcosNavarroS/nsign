<?php

declare(strict_types=1);

namespace App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria;

enum Sort: string
{
    case activity = 'activity';
    case creation = 'creation';
    case votes = 'votes';
}