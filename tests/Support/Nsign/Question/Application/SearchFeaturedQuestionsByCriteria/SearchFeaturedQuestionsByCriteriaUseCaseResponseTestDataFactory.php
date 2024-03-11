<?php

declare(strict_types=1);

namespace App\Tests\Support\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria;

use App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\SearchFeaturedQuestionsByCriteriaUseCaseResponse;
use App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\SearchFeaturedQuestionsByCriteriaUseCaseResponseQuestion;

final class SearchFeaturedQuestionsByCriteriaUseCaseResponseTestDataFactory
{
    /**
     * @param SearchFeaturedQuestionsByCriteriaUseCaseResponseQuestion[] $questions
     */
    public static function create(
        array $questions = null,
        bool $hasMore = false,
    ): SearchFeaturedQuestionsByCriteriaUseCaseResponse {
        return new SearchFeaturedQuestionsByCriteriaUseCaseResponse(
            $questions ?? [SearchFeaturedQuestionsByCriteriaUseCaseResponseQuestionTestDataFactory::create()],
            $hasMore,
        );
    }
}