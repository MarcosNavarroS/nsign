<?php

declare(strict_types=1);

namespace App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria;

class SearchFeaturedQuestionsByCriteriaUseCase
{
    public function __construct(
        private readonly SearchFeaturedQuestionsByCriteriaRepository $searchQuestionByCriteriaRepository
    ) {
    }

    /**
     * @throws UnableToSearchFeaturedQuestions
     */
    public function __invoke(SearchFeaturedQuestionsByCriteriaUseCaseRequest $request): SearchFeaturedQuestionsByCriteriaUseCaseResponse
    {
        return $this->searchQuestionByCriteriaRepository->searchFeaturedByCriteria($request->criteria);
    }
}