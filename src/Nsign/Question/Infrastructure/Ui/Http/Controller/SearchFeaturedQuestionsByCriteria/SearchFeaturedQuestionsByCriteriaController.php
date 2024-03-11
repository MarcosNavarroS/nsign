<?php

declare(strict_types=1);

namespace App\Nsign\Question\Infrastructure\Ui\Http\Controller\SearchFeaturedQuestionsByCriteria;

use App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\Order;
use App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\SearchFeaturedQuestionsByCriteriaUseCase;
use App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\SearchFeaturedQuestionsByCriteriaUseCaseRequest;
use App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\SearchFeaturedQuestionsCriteria;
use App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\Sort;
use App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\UnableToSearchFeaturedQuestions;
use App\Shared\Kernel\Infrastructure\Ui\Http\Response\ErrorResponse;
use App\Shared\Kernel\Infrastructure\Ui\Http\Response\SerializableResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SearchFeaturedQuestionsByCriteriaController
{
    public function __construct(
        public readonly SearchFeaturedQuestionsByCriteriaUseCase $searchFeaturedQuestionsByCriteriaUseCase
    ) {
    }

    #[Route('/questions/featured', name: 'nsign.question.search.featured', methods: ['GET'], priority: 1, format: 'json')]
    public function __invoke(SearchFeaturedQuestionsByCriteriaRequest $request): SerializableResponse
    {
        try {
            $response = $this->searchFeaturedQuestionsByCriteriaUseCase->__invoke(
                new SearchFeaturedQuestionsByCriteriaUseCaseRequest(
                    SearchFeaturedQuestionsCriteria::create(
                        $request->fromDate,
                        $request->toDate,
                        $request->page,
                        $request->pageSize,
                        $request->sort ? Sort::from($request->sort) : null,
                        $request->order ? Order::from($request->order) : null,
                    )
                )
            );
            return SearchFeaturedQuestionsByCriteriaResponse::fromApplication($response);
        } catch (UnableToSearchFeaturedQuestions $e) {
            return new ErrorResponse($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}