<?php

declare(strict_types=1);

namespace App\Shared\Kernel\Infrastructure\Ui\Http\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

final readonly class SerializableResponseFactory
{
    public function __construct(
        private SerializerInterface $serializer
    ) {
    }

    public function create(SerializableResponse $response): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize(
                $response,
                'json',
                [
                    'preserve_empty_objects' => true,
                ]
            ),
            $response->statusCode(),
            json: true,
        );
    }
}
