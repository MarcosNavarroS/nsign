<?php

declare(strict_types=1);

namespace App\Tests\unit\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria;

use App\Nsign\Question\Application\GetQuestionById\GetQuestionByIdUseCase;
use App\Nsign\Question\Application\GetQuestionById\GetQuestionByIdUseCaseRequest;
use App\Nsign\Question\Application\GetQuestionById\GetQuestionByIdUseCaseResponse;
use App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\SearchFeaturedQuestionsByCriteriaRepository;
use App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\SearchFeaturedQuestionsByCriteriaUseCase;
use App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\SearchFeaturedQuestionsByCriteriaUseCaseRequest;
use App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\SearchFeaturedQuestionsByCriteriaUseCaseResponse;
use App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\SearchFeaturedQuestionsCriteria;
use App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\UnableToSearchFeaturedQuestions;
use App\Nsign\Question\Domain\Question;
use App\Nsign\Question\Domain\QuestionId;
use App\Nsign\Question\Domain\QuestionNotFound;
use App\Nsign\Question\Domain\QuestionRepository;
use App\Nsign\Question\Domain\Tag;
use App\Nsign\Question\Domain\UnableToGetQuestion;
use App\Tests\Support\Nsign\Question\Application\GetQuestionById\GetQuestionByIdUseCaseResponseTestDataFactory;
use App\Tests\Support\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\SearchFeaturedQuestionsByCriteriaUseCaseResponseTestDataFactory;
use App\Tests\Support\Nsign\Question\Domain\QuestionTestDataFactory;
use App\Tests\unit\Nsign\Question\Application\GetQuestionById\GetQuestionByIdUseCaseRequestTestDataFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class SearchFeaturedQuestionsByCriteriaUseCaseTest extends TestCase
{
    private QuestionRepository|MockObject $repository;
    private SearchFeaturedQuestionsByCriteriaUseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(SearchFeaturedQuestionsByCriteriaRepository::class);
        $this->useCase = new SearchFeaturedQuestionsByCriteriaUseCase(
            $this->repository,
        );
    }

    /**
     * @test
     */
    public function shouldSearchFeaturedQuestionsByCriteriaUseCaseResponseGivenQuestions()
    {
        $useCaseResponse = SearchFeaturedQuestionsByCriteriaUseCaseResponseTestDataFactory::create();

        $criteria = SearchFeaturedQuestionsCriteria::create();
        $request = new SearchFeaturedQuestionsByCriteriaUseCaseRequest($criteria);

        $this->givenSearchFeaturedByCriteria($criteria, $useCaseResponse);

        $response = $this->invokeUseCase($request);

        $this->assertEquals($useCaseResponse, $response);
    }

    /**
     * @test
     */
    public function shouldThrowUnableToSearchFeaturedQuestionsGivenUnableToSearchFeaturedQuestions()
    {
        $criteria = SearchFeaturedQuestionsCriteria::create();
        $request = new SearchFeaturedQuestionsByCriteriaUseCaseRequest($criteria);

        $this->givenUnableToSearchFeaturedQuestions($request->criteria);
        $this->expectUnableToSearchFeaturedQuestions();

        $this->invokeUseCase($request);
    }

    private function givenSearchFeaturedByCriteria(SearchFeaturedQuestionsCriteria $criteria, SearchFeaturedQuestionsByCriteriaUseCaseResponse $useCaseResponse): void
    {
        $this->repository
            ->expects(self::once())
            ->method('searchFeaturedByCriteria')
            ->with($criteria)
            ->willReturn($useCaseResponse);
    }

    private function givenUnableToSearchFeaturedQuestions(SearchFeaturedQuestionsCriteria $criteria): void
    {
        $this->repository
            ->expects(self::once())
            ->method('searchFeaturedByCriteria')
            ->with($criteria)
            ->willThrowException(new UnableToSearchFeaturedQuestions());
    }

    private function expectUnableToSearchFeaturedQuestions(): void
    {
        $this->expectException(UnableToSearchFeaturedQuestions::class);
    }

    private function invokeUseCase(SearchFeaturedQuestionsByCriteriaUseCaseRequest $request): SearchFeaturedQuestionsByCriteriaUseCaseResponse
    {
        return $this->useCase->__invoke($request);
    }
}