<?php

declare(strict_types=1);

namespace App\Tests\integration\Nsign\Question\Infrastructure\Ui\Http\Controller\GetQuestionById;

use App\Nsign\Question\Application\GetQuestionById\GetQuestionByIdUseCase;
use App\Nsign\Question\Application\GetQuestionById\GetQuestionByIdUseCaseRequest;
use App\Nsign\Question\Application\GetQuestionById\GetQuestionByIdUseCaseResponse;
use App\Nsign\Question\Domain\QuestionNotFound;
use App\Nsign\Question\Domain\UnableToGetQuestion;
use App\Nsign\Question\Infrastructure\Ui\Http\Controller\GetQuestionById\GetQuestionByIdRequest;
use App\Tests\Support\Nsign\Question\Application\GetQuestionById\GetQuestionByIdUseCaseResponseTestDataFactory;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

final class GetQuestionByIdControllerTest extends WebTestCase
{
    private GetQuestionByIdUseCase|MockObject $useCase;
    private KernelBrowser $client;

    protected function setUp(): void
    {
        self::ensureKernelShutdown();
        $this->client = static::createClient();
        $this->useCase = $this->createMock(GetQuestionByIdUseCase::class);
        static::getContainer()->set('App\Nsign\Question\Application\GetQuestionById\GetQuestionByIdUseCase', $this->useCase);
    }

    /**
     * @test
     */
    public function shouldReturnOkWithValidRequest()
    {
        $request = GetQuestionByIdRequestTestDataFactory::create();
        $useCaseResponse = GetQuestionByIdUseCaseResponseTestDataFactory::create(questionId: $request->questionId);
        $this->givenGetQuestionByIdUseCaseResponse($request, $useCaseResponse);
        $this->getQuestionById([
            'questionId' => $request->questionId,
        ]);

        $expectedResponse = [
            "id" => $useCaseResponse->questionId,
            "userId" => $useCaseResponse->userId,
            "tags" => $useCaseResponse->tags,
            "isAnswered" => $useCaseResponse->isAnswered,
            "score" => $useCaseResponse->score,
            "title" => $useCaseResponse->title,
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
        $this->getQuestionById([
            'questionId' => -1,
        ]);

        $response = $this->client->getResponse();

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertEquals(
            [
                'message' => [
                    '[questionId]' => 'This value should be positive.',
                ],
            ],
            json_decode($response->getContent(), true),
        );
    }

    /**
     * @test
     */
    public function shouldReturnNotFoundOnQuestionNotFoundException()
    {
        $request = GetQuestionByIdRequestTestDataFactory::create();

        $this->givenQuestionNotFound($request);

        $this->getQuestionById([
            'questionId' => $request->questionId,
        ]);

        $response = $this->client->getResponse();

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        $this->assertEquals(
            [
                'message' => sprintf('Could not find question with id %d', $request->questionId),
            ],
            json_decode($response->getContent(), true),
        );
    }

    /**
     * @test
     */
    public function shouldReturnUnprocessableEntityOnUnableToGetQuestionException()
    {
        $request = GetQuestionByIdRequestTestDataFactory::create();

        $this->givenUnableToGetQuestion($request);

        $this->getQuestionById([
            'questionId' => $request->questionId,
        ]);

        $response = $this->client->getResponse();

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertEquals(
            [
                'message' => 'Unable to get question',
            ],
            json_decode($response->getContent(), true),
        );
    }

    private function getQuestionById(array $request): void
    {
        $this->client->request(
            method: 'GET',
            uri: sprintf('/question/%d', $request['questionId']),
        );
    }

    private function givenGetQuestionByIdUseCaseResponse(GetQuestionByIdRequest $request, GetQuestionByIdUseCaseResponse $useCaseResponse): void
    {
        $this->useCase
            ->expects(self::once())
            ->method('__invoke')
            ->with($this->getUseCaseRequest($request))
            ->willReturn($useCaseResponse);
    }

    private function getUseCaseRequest(GetQuestionByIdRequest $request): GetQuestionByIdUseCaseRequest
    {
        return new GetQuestionByIdUseCaseRequest(
            $request->questionId,
        );
    }

    private function givenQuestionNotFound(GetQuestionByIdRequest $request): void
    {
        $this->useCase
            ->expects(self::once())
            ->method('__invoke')
            ->with($this->getUseCaseRequest($request))
            ->willThrowException(QuestionNotFound::withId($request->questionId));
    }

    private function givenUnableToGetQuestion(GetQuestionByIdRequest $request): void
    {
        $this->useCase
            ->expects(self::once())
            ->method('__invoke')
            ->with($this->getUseCaseRequest($request))
            ->willThrowException(new UnableToGetQuestion('Unable to get question'));
    }
}