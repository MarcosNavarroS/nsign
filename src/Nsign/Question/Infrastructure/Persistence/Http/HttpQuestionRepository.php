<?php

declare(strict_types=1);

namespace App\Nsign\Question\Infrastructure\Persistence\Http;

use App\Nsign\Question\Domain\Question;
use App\Nsign\Question\Domain\QuestionId;
use App\Nsign\Question\Domain\QuestionNotFound;
use App\Nsign\Question\Domain\QuestionRepository;
use App\Nsign\Question\Domain\UnableToGetQuestion;
use App\Shared\Kernel\Infrastructure\Http\Client\HttpClient;
use App\Shared\Kernel\Infrastructure\Http\Client\HttpException;
use App\Shared\Kernel\Infrastructure\Http\Client\HttpRequest;

final class HttpQuestionRepository implements QuestionRepository
{
    public function __construct(
        private readonly HttpClient $httpClient,
        private readonly string $host,
        private readonly string $site,
        private readonly HttpQuestionSerializer $serializer,
    ) {
    }

    /**
     * @throws QuestionNotFound
     * @throws UnableToGetQuestion
     */
    public function getById(QuestionId $id): Question
    {
        try {
            $response = $this->httpClient->request(
                new HttpRequest(
                    'GET',
                    sprintf('%s/questions/%d?site=%s', $this->host, $id->toInt(), $this->site),
                )
            );

            $data = json_decode($response->content, true);

            $statusCode = $response->statusCode;

            if(200 !== $statusCode) {
                throw new UnableToGetQuestion(sprintf('Unable to get question: Status code: %d', $statusCode));
            }

            if(!isset($data['items'][0])) {
                throw QuestionNotFound::withId($id->toInt());
            }

            return $this->serializer->deserialize($data['items'][0]);

        } catch (HttpException $e) {
            throw new UnableToGetQuestion(sprintf('Unable to get question: %s',$e->getMessage()));
        }
    }
}