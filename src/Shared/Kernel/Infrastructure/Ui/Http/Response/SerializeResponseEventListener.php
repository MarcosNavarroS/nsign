<?php

declare(strict_types=1);

namespace App\Shared\Kernel\Infrastructure\Ui\Http\Response;

use Symfony\Component\HttpKernel\Event\ViewEvent;

final class SerializeResponseEventListener
{
    public function __construct(private readonly SerializableResponseFactory $responseFactory)
    {
    }

    public function __invoke(ViewEvent $event)
    {
        $response = $event->getControllerResult();

        if (!$response instanceof SerializableResponse) {
            return;
        }

        $event->setResponse($this->responseFactory->create($response));
    }
}
