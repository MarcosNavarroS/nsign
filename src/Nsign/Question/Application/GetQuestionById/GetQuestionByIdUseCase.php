<?php

declare(strict_types=1);

namespace App\Nsign\Question\Application\GetQuestionById;

use App\Nsign\Question\Domain\QuestionId;
use App\Nsign\Question\Domain\QuestionNotFound;
use App\Nsign\Question\Domain\QuestionRepository;
use App\Nsign\Question\Domain\UnableToGetQuestion;

class GetQuestionByIdUseCase
{
    public function __construct(
        private readonly QuestionRepository $questionRepository
    ) {
    }

    /**
     * @throws QuestionNotFound
     * @throws UnableToGetQuestion
     */
    public function __invoke(GetQuestionByIdUseCaseRequest $request): GetQuestionByIdUseCaseResponse
    {
        $question = $this->questionRepository->getById(QuestionId::fromInt($request->questionId));

        return GetQuestionByIdUseCaseResponse::fromDomain($question);
    }
}