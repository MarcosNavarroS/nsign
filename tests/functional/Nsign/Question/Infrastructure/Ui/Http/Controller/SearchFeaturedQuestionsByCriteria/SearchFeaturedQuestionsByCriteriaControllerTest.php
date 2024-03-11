<?php

declare(strict_types=1);

namespace App\Tests\functional\Nsign\Question\Infrastructure\Ui\Http\Controller\SearchFeaturedQuestionsByCriteria;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

final class SearchFeaturedQuestionsByCriteriaControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        self::ensureKernelShutdown();
        $this->client = static::createClient();
    }

    /**
     * @test
     */
    public function shouldReturnOktOnSearchFeaturedQuestionsByCriteria()
    {
        $this->client->request(
            method: 'GET',
            uri: '/questions/featured?order=desc&sort=activity&page=1&pageSize=2',
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}