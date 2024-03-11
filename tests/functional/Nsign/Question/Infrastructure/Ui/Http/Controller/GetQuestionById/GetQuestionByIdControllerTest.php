<?php

declare(strict_types=1);

namespace App\Tests\functional\Nsign\Question\Infrastructure\Ui\Http\Controller\GetQuestionById;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

final class GetQuestionByIdControllerTest extends WebTestCase
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
    public function shouldReturnOktOnGetQuestionById()
    {
        $this->client->request(
            method: 'GET',
            uri: '/question/78136584',
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}