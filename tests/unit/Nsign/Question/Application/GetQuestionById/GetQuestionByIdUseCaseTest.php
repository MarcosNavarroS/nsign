<?php

declare(strict_types=1);

namespace App\Tests\unit\Nsign\Question\Application\GetQuestionById;

use App\Nsign\Question\Application\GetQuestionById\GetQuestionByIdUseCase;
use App\Nsign\Question\Application\GetQuestionById\GetQuestionByIdUseCaseRequest;
use App\Nsign\Question\Application\GetQuestionById\GetQuestionByIdUseCaseResponse;
use App\Nsign\Question\Domain\Question;
use App\Nsign\Question\Domain\QuestionId;
use App\Nsign\Question\Domain\QuestionNotFound;
use App\Nsign\Question\Domain\QuestionRepository;
use App\Nsign\Question\Domain\Tag;
use App\Nsign\Question\Domain\UnableToGetQuestion;
use App\Tests\Support\Nsign\Question\Application\GetQuestionById\GetQuestionByIdUseCaseResponseTestDataFactory;
use App\Tests\Support\Nsign\Question\Domain\QuestionTestDataFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class GetQuestionByIdUseCaseTest extends TestCase
{
    private QuestionRepository|MockObject $repository;
    private GetQuestionByIdUseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(QuestionRepository::class);
        $this->useCase = new GetQuestionByIdUseCase(
            $this->repository,
        );
    }

    /**
     * @test
     */
    public function shouldGetQuestionByIdUseCaseResponseGivenQuestion()
    {
        $request = GetQuestionByIdUseCaseRequestTestDataFactory::create();
        $question = QuestionTestDataFactory::create(questionId: $request->questionId);
        $useCaseResponse = GetQuestionByIdUseCaseResponseTestDataFactory::create(
            $question->id()->toInt(),
            $question->userId()->toInt(),
            $question->tags()->map(fn(Tag $tag) => $tag->toString()),
            $question->isAnswered(),
            $question->score()->toInt(),
            $question->title()->toString(),
        );

        $this->givenGetById($request, $question);

        $response = $this->invokeUseCase($request);

        $this->assertEquals($useCaseResponse, $response);
    }

    /**
     * @test
     */
    public function shouldThrowQuestionNotFoundGivenQuestionNotFound()
    {
        $request = GetQuestionByIdUseCaseRequestTestDataFactory::create();

        $this->givenQuestionNotFound($request);
        $this->expectQuestionNotFound();

        $this->invokeUseCase($request);
    }

    /**
     * @test
     */
    public function shouldThrowUnableToGetQuestionGivenUnableToGetQuestion()
    {
        $request = GetQuestionByIdUseCaseRequestTestDataFactory::create();

        $this->givenUnableToGetQuestion($request);
        $this->expectUnableToGetQuestion();

        $this->invokeUseCase($request);
    }

    private function givenGetById(GetQuestionByIdUseCaseRequest $request, Question $question): void
    {
        $this->repository
            ->expects(self::once())
            ->method('getById')
            ->with(QuestionId::fromInt($request->questionId))
            ->willReturn($question);
    }

    private function givenQuestionNotFound(GetQuestionByIdUseCaseRequest $request): void
    {
        $this->repository
            ->expects(self::once())
            ->method('getById')
            ->with(QuestionId::fromInt($request->questionId))
            ->willThrowException(QuestionNotFound::withId($request->questionId));
    }

    private function givenUnableToGetQuestion(GetQuestionByIdUseCaseRequest $request): void
    {
        $this->repository
            ->expects(self::once())
            ->method('getById')
            ->with(QuestionId::fromInt($request->questionId))
            ->willThrowException(new UnableToGetQuestion());
    }

    private function expectQuestionNotFound(): void
    {
        $this->expectException(QuestionNotFound::class);
    }

    private function expectUnableToGetQuestion(): void
    {
        $this->expectException(UnableToGetQuestion::class);
    }

    private function invokeUseCase(GetQuestionByIdUseCaseRequest $request): GetQuestionByIdUseCaseResponse
    {
        return $this->useCase->__invoke($request);
    }
}