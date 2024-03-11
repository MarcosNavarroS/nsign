<?php

declare(strict_types=1);

namespace App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria;

final class SearchFeaturedQuestionsByCriteriaUseCaseResponseQuestion
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

    public static function fromData(array $data): SearchFeaturedQuestionsByCriteriaUseCaseResponseQuestion
    {
        return new self(
            $data['question_id'],
            isset($data['owner']) ? $data['owner']['user_id'] : null,
            $data['tags'],
            $data['is_answered'],
            $data['score'],
            $data['title'],
        );
    }
}