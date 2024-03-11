<?php

declare(strict_types=1);

namespace App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria;

interface SearchFeaturedQuestionsByCriteriaRepository
{
    /**
     * @throws UnableToSearchFeaturedQuestions
     */
    public function searchFeaturedByCriteria(SearchFeaturedQuestionsCriteria $criteria): SearchFeaturedQuestionsByCriteriaUseCaseResponse;
}