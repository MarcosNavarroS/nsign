<?php

declare(strict_types=1);

namespace App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria;

final class SearchFeaturedQuestionsByCriteriaUseCaseRequest
{
    public function __construct(public SearchFeaturedQuestionsCriteria $criteria)
    {
    }
}