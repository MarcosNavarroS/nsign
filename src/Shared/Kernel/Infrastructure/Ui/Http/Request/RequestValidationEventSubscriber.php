<?php

declare(strict_types=1);

namespace App\Shared\Kernel\Infrastructure\Ui\Http\Request;

use App\Shared\Kernel\Infrastructure\Ui\Http\Validator\RequestValidationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final readonly class RequestValidationEventSubscriber implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();

        if (!$throwable instanceof RequestValidationException) {
            return;
        }

        $event->setResponse(new JsonResponse([
            'message' => $throwable->toArray(),
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', 100],
        ];
    }
}
