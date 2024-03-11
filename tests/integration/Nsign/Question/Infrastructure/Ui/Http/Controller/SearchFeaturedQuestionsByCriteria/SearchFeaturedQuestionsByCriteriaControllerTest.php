<?php

declare(strict_types=1);

namespace App\Tests\integration\Nsign\Question\Infrastructure\Ui\Http\Controller\SearchFeaturedQuestionsByCriteria;

use App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\Order;
use App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\SearchFeaturedQuestionsByCriteriaUseCase;
use App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\SearchFeaturedQuestionsByCriteriaUseCaseRequest;
use App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\SearchFeaturedQuestionsByCriteriaUseCaseResponse;
use App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\SearchFeaturedQuestionsCriteria;
use App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\Sort;
use App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\UnableToSearchFeaturedQuestions;
use App\Nsign\Question\Infrastructure\Ui\Http\Controller\SearchFeaturedQuestionsByCriteria\SearchFeaturedQuestionsByCriteriaRequest;
use App\Tests\Support\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\SearchFeaturedQuestionsByCriteriaUseCaseResponseTestDataFactory;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

final class SearchFeaturedQuestionsByCriteriaControllerTest extends WebTestCase
{
    private SearchFeaturedQuestionsByCriteriaUseCase|MockObject $useCase;
    private KernelBrowser $client;

    protected function setUp(): void
    {
        self::ensureKernelShutdown();
        $this->client = static::createClient();
        $this->useCase = $this->createMock(SearchFeaturedQuestionsByCriteriaUseCase::class);
        static::getContainer()->set('App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\SearchFeaturedQuestionsByCriteriaUseCase', $this->useCase);
    }

    /**
     * @test
     */
    public function shouldReturnOkWithValidRequest()
    {
        $request = SearchFeaturedQuestionsByCriteriaRequestTestDataFactory::create();
        $useCaseResponse = SearchFeaturedQuestionsByCriteriaUseCaseResponseTestDataFactory::create();
        $this->givenSearchFeaturedQuestionsByCriteriaUseCaseResponse($request, $useCaseResponse);
        $this->searchFeaturedQuestionsByCriteria([
            'fromDate' => $request->fromDate,
            'toDate' => $request->toDate,
            'page' => $request->page,
            'pageSize' => $request->pageSize,
            'sort' => $request->sort,
            'order' => $request->order,
        ]);

        $expectedResponse = [
            "questions" => [
                [
                    "questionId" => $useCaseResponse->questions[0]->questionId,
                    "userId" => $useCaseResponse->questions[0]->userId,
                    "tags" => [
                        $useCaseResponse->questions[0]->tags[0]
                    ],
                    "isAnswered" => $useCaseResponse->questions[0]->isAnswered,
                    "score" => $useCaseResponse->questions[0]->score,
                    "title" => $useCaseResponse->questions[0]->title
                ]
            ],
            "hasMore" => false
        ];
        $response = $this->client->getResponse();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertEquals($expectedResponse, json_decode($response->getContent(), true));
    }

    /**
     * @test
     */
    public function shouldReturnUnprocessableEntityWithInvalidFields()
    {
        $this->searchFeaturedQuestionsByCriteria([
            'fromDate' => -2,
            'toDate' => -1,
            'page' => -1,
            'pageSize' => 'a',
            'sort' => 'invalid',
            'order' => 'invalid',
        ]);

        $response = $this->client->getResponse();

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertEquals(
            [
                "message" => [
                    "[fromDate]" => "This value should be positive.",
                    "[toDate]" => "This value should be positive.",
                    "[page]" => "This value should be positive.",
                    "[pageSize]" => "This value should be of type numeric.",
                    "[sort]" => "The value you selected is not a valid choice.",
                    "[order]" => "The value you selected is not a valid choice."
                ]
            ],
            json_decode($response->getContent(), true),
        );
    }

    /**
     * @test
     */
    public function shouldReturnUnprocessableEntityOnUnableToSearchFeaturedQuestionsException()
    {
        $request = SearchFeaturedQuestionsByCriteriaRequestTestDataFactory::create(null, null, null, null, null, null);

        $this->givenUnableToSearchFeaturedQuestions($request);

        $this->searchFeaturedQuestionsByCriteria([]);

        $response = $this->client->getResponse();

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertEquals(
            [
                'message' => 'Unable to search featured questions',
            ],
            json_decode($response->getContent(), true),
        );
    }

    private function searchFeaturedQuestionsByCriteria(array $request): void
    {
        $query = http_build_query($request);
        $url = sprintf('/questions/featured?%s', $query);
        $this->client->request(
            method: 'GET',
            uri: $url,
        );
    }

    private function givenSearchFeaturedQuestionsByCriteriaUseCaseResponse(SearchFeaturedQuestionsByCriteriaRequest $request, SearchFeaturedQuestionsByCriteriaUseCaseResponse $useCaseResponse): void
    {
        $this->useCase
            ->expects(self::once())
            ->method('__invoke')
            ->with($this->getUseCaseRequest($request))
            ->willReturn($useCaseResponse);
    }

    private function getUseCaseRequest(SearchFeaturedQuestionsByCriteriaRequest $request): SearchFeaturedQuestionsByCriteriaUseCaseRequest
    {
        return new SearchFeaturedQuestionsByCriteriaUseCaseRequest(
            SearchFeaturedQuestionsCriteria::create(
                $request->fromDate,
                $request->toDate,
                $request->page,
                $request->pageSize,
                $request->sort ? Sort::from($request->sort) : null,
                $request->order ? Order::from($request->order) : null,
            )
        );
    }

    private function givenUnableToSearchFeaturedQuestions(SearchFeaturedQuestionsByCriteriaRequest $request): void
    {
        $this->useCase
            ->expects(self::once())
            ->method('__invoke')
            ->with($this->getUseCaseRequest($request))
            ->willThrowException(new UnableToSearchFeaturedQuestions('Unable to search featured questions'));
    }
}