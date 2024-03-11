<?php

namespace App\Shared\Kernel\Infrastructure\Http\Client;

interface HttpClient
{
    /** @throws HttpException */
    public function request(HttpRequest $httpRequest): HttpResponse;
}
