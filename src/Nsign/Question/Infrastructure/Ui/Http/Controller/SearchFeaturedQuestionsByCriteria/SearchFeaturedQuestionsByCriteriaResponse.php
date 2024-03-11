<?php

declare(strict_types=1);

namespace App\Nsign\Question\Infrastructure\Ui\Http\Controller\SearchFeaturedQuestionsByCriteria;

use App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\SearchFeaturedQuestionsByCriteriaUseCaseResponse;
use App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\SearchFeaturedQuestionsByCriteriaUseCaseResponseQuestion;
use App\Shared\Kernel\Infrastructure\Ui\Http\Response\SerializableResponse;
use Symfony\Component\HttpFoundation\Response;

final class SearchFeaturedQuestionsByCriteriaResponse implements SerializableResponse
{
    /**
     * @param SearchFeaturedQuestionsByCriteriaResponseQuestion[] $questions
     */
    public function __construct(
        public array $questions,
        public bool $hasMore,
    ) {
    }

    public static function fromApplication(SearchFeaturedQuestionsByCriteriaUseCaseResponse $response): SearchFeaturedQuestionsByCriteriaResponse
    {
        return new self(
            array_map(
                fn(
                    SearchFeaturedQuestionsByCriteriaUseCaseResponseQuestion $question
                ) => SearchFeaturedQuestionsByCriteriaResponseQuestion::fromApplication($question),
                $response->questions
            ),
            $response->hasMore,
        );
    }

    public function statusCode(): int
    {
        return Response::HTTP_OK;
    }
}