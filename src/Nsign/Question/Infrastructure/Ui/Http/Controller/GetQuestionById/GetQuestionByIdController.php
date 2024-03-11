<?php

declare(strict_types=1);

namespace App\Nsign\Question\Infrastructure\Ui\Http\Controller\GetQuestionById;

use App\Nsign\Question\Application\GetQuestionById\GetQuestionByIdUseCase;
use App\Nsign\Question\Application\GetQuestionById\GetQuestionByIdUseCaseRequest;
use App\Nsign\Question\Domain\QuestionNotFound;
use App\Nsign\Question\Domain\UnableToGetQuestion;
use App\Shared\Kernel\Infrastructure\Ui\Http\Response\ErrorResponse;
use App\Shared\Kernel\Infrastructure\Ui\Http\Response\SerializableResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GetQuestionByIdController
{
    public function __construct(
        public readonly GetQuestionByIdUseCase $getQuestionByIdUseCase
    ) {
    }

    #[Route('/question/{questionId}', name: 'nsign.question.get', methods: ['GET'], format: 'json')]
    public function __invoke(GetQuestionByIdRequest $request): SerializableResponse
    {
        try {
            $response = $this->getQuestionByIdUseCase->__invoke(
                new GetQuestionByIdUseCaseRequest($request->questionId)
            );
            return GetQuestionByIdResponse::fromApplication($response);
        } catch (QuestionNotFound $e) {
            return new ErrorResponse($e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (UnableToGetQuestion $e) {
            return new ErrorResponse($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}