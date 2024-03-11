<?php

declare(strict_types=1);

namespace App\Nsign\Question\Infrastructure\Persistence\Http;

use App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\SearchFeaturedQuestionsByCriteriaUseCaseResponse;
use App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\SearchFeaturedQuestionsByCriteriaUseCaseResponseQuestion;
use App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\SearchFeaturedQuestionsByCriteriaRepository;
use App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\SearchFeaturedQuestionsCriteria;
use App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\UnableToSearchFeaturedQuestions;
use App\Nsign\Question\Domain\Question;
use App\Nsign\Question\Domain\QuestionId;
use App\Nsign\Question\Domain\QuestionNotFound;
use App\Nsign\Question\Domain\QuestionRepository;
use App\Nsign\Question\Domain\UnableToGetQuestion;
use App\Shared\Kernel\Infrastructure\Http\Client\HttpClient;
use App\Shared\Kernel\Infrastructure\Http\Client\HttpException;
use App\Shared\Kernel\Infrastructure\Http\Client\HttpRequest;

final class HttpQuestionRepository implements QuestionRepository, SearchFeaturedQuestionsByCriteriaRepository
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

    /**
     * @throws UnableToSearchFeaturedQuestions
     */
    public function searchFeaturedByCriteria(SearchFeaturedQuestionsCriteria $criteria): SearchFeaturedQuestionsByCriteriaUseCaseResponse
    {
        $url = $this->getSearchFeaturedUrl($criteria);

        try {
            $response = $this->httpClient->request(
                new HttpRequest(
                    'GET',
                    $url,
                )
            );

            $data = json_decode($response->content, true);
            $statusCode = $response->statusCode;

            if(200 !== $statusCode) {
                throw new UnableToSearchFeaturedQuestions(sprintf('Unable to search featured questions: Status code: %d', $statusCode));
            }

            return new SearchFeaturedQuestionsByCriteriaUseCaseResponse(
                array_map(fn(array $dataItem) => SearchFeaturedQuestionsByCriteriaUseCaseResponseQuestion::fromData($dataItem), $data['items']),
                $data['has_more']
            );
        } catch (HttpException $e) {
            throw new UnableToSearchFeaturedQuestions(sprintf('Unable to search featured questions: Status code: %s', $e->getMessage()));
        }
    }


    private function getSearchFeaturedUrl(SearchFeaturedQuestionsCriteria $criteria): string
    {
        $query = [
            'site' => $this->site,
            'order' => $criteria->order->value,
            'sort' => $criteria->sort->value,
            'page' => $criteria->page,
            'pagesize' => $criteria->pageSize,
        ];

        if (null !== $criteria->fromDate) {
            $query['fromdate'] = $criteria->fromDate;
        }

        if (null !== $criteria->toDate) {
            $query['todate'] = $criteria->toDate;
        }

        return sprintf(
            '%s/questions/featured?%s',
            $this->host,
            http_build_query($query)
        );
    }
}