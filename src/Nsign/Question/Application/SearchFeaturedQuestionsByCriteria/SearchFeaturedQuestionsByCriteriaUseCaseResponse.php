<?php

declare(strict_types=1);

namespace App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria;

final class SearchFeaturedQuestionsByCriteriaUseCaseResponse
{
    /**
     * @param SearchFeaturedQuestionsByCriteriaUseCaseResponseQuestion[] $questions
     */
    public function __construct(
        public array $questions,
        public bool $hasMore,
    )
    {
    }
}