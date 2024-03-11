<?php

declare(strict_types=1);

namespace App\Tests\integration\Nsign\Question\Infrastructure\Persistence\Http;

use App\Nsign\Question\Domain\QuestionId;
use App\Nsign\Question\Domain\QuestionNotFound;
use App\Nsign\Question\Domain\Tag;
use App\Nsign\Question\Domain\Tags;
use App\Nsign\Question\Domain\UnableToGetQuestion;
use App\Nsign\Question\Infrastructure\Persistence\Http\HttpQuestionRepository;
use App\Nsign\Question\Infrastructure\Persistence\Http\HttpQuestionSerializer;
use App\Shared\Kernel\Infrastructure\Http\Client\SymfonyHttpClient;
use App\Tests\Support\Nsign\Question\Domain\QuestionTestDataFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class HttpQuestionRepositoryTest extends KernelTestCase
{
    private HttpQuestionRepository $repository;

    protected function setUp(): void
    {
        $httpClient = $this->getContainer()->get(SymfonyHttpClient::class);
        $serializer = $this->getContainer()->get(HttpQuestionSerializer::class);
        $this->repository = new HttpQuestionRepository(
            $httpClient,
            getenv('STACKEXCHANGE_API_HOST'),
            getenv('STACKEXCHANGE_API_SITE'),
            $serializer,
        );
    }

    /**
     * @test
     */
    public function shouldGetQuestionGivenExistentQuestionId()
    {
        $question = QuestionTestDataFactory::create(
            questionId: 78136584,
            userId: 20331111,
            tags: new Tags(
                Tag::fromString('java'),
                Tag::fromString('list'),
            ),
            isAnswered: true,
            score: -1,
            title: 'mock server title'
        );

        $result = $this->repository->getById($question->id());

        $this->assertEqualsCanonicalizing($question, $result);
    }

    /**
     * @test
     */
    public function shouldThrowQuestionNotFoundGivenNonexistentQuestionId()
    {
        $this->expectException(QuestionNotFound::class);

        $this->repository->getById(QuestionId::fromInt(111));
    }

    /**
     * @test
     */
    public function shouldThrowUnableToGetQuestionGivenError()
    {
        $this->expectException(UnableToGetQuestion::class);

        $this->repository->getById(QuestionId::fromInt(222));
    }
}