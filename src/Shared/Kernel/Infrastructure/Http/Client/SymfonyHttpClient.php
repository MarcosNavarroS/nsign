<?php

declare(strict_types=1);

namespace App\Shared\Kernel\Infrastructure\Http\Client;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

final class SymfonyHttpClient implements HttpClient
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private int $timeout,
    ) {
    }

    /** @throws HttpException */
    public function request(HttpRequest $httpRequest): HttpResponse
    {
        try {
            $options = [
                'headers' => $httpRequest->headers,
                'body' => $httpRequest->body,
                'timeout' => $this->timeout,
                'verify_peer' => $httpRequest->checkCertificate,
                'verify_host' => $httpRequest->checkCertificate,
            ];

            $response = $this->httpClient->request(
                $httpRequest->method,
                $httpRequest->uri,
                $options
            );

            return new HttpResponse(
                $response->getStatusCode(),
                $response->getHeaders(false),
                $response->getContent(false)
            );
        } catch (Throwable $throwable) {
            throw new HttpException($throwable);
        }
    }
}
