<?php

declare(strict_types=1);

namespace App\Tests\Support\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria;

use App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\SearchFeaturedQuestionsByCriteriaUseCaseResponseQuestion;

final class SearchFeaturedQuestionsByCriteriaUseCaseResponseQuestionTestDataFactory
{
    public static function create(
        int $questionId = 123123,
        int $userId = 3321321,
        array $tags = ['java'],
        bool $isAnswered = false,
        int $score = 5,
        string $title = 'AnswerTitle',
    ): SearchFeaturedQuestionsByCriteriaUseCaseResponseQuestion {
        return new SearchFeaturedQuestionsByCriteriaUseCaseResponseQuestion(
            $questionId,
            $userId,
            $tags,
            $isAnswered,
            $score,
            $title,
        );
    }
}