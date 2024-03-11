<?php

declare(strict_types=1);

namespace App\Nsign\Question\Infrastructure\Ui\Http\Controller\SearchFeaturedQuestionsByCriteria;

use App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\SearchFeaturedQuestionsByCriteriaUseCaseResponseQuestion;

final class SearchFeaturedQuestionsByCriteriaResponseQuestion
{
    public function __construct(
        public int $questionId,
        public ?int $userId,
        public array $tags,
        public bool $isAnswered,
        public int $score,
        public string $title,
    )
    {
    }

    public static function fromApplication(SearchFeaturedQuestionsByCriteriaUseCaseResponseQuestion $question): SearchFeaturedQuestionsByCriteriaResponseQuestion
    {
        return new self(
            $question->questionId,
            $question->userId,
            $question->tags,
            $question->isAnswered,
            $question->score,
            $question->title,
        );
    }
}