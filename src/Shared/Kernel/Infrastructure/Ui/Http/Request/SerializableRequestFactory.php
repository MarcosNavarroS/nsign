<?php

declare(strict_types=1);

namespace App\Shared\Kernel\Infrastructure\Ui\Http\Request;

use App\Shared\Kernel\Infrastructure\Ui\Http\Validator\RequestValidator;
use InvalidArgumentException;
use JsonException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use function array_merge;
use function json_decode;

final readonly class SerializableRequestFactory
{
    public function __construct(
        private DenormalizerInterface $denormalizer,
        private RequestValidator $validator,
    ) {
    }

    public function create(Request $request, string $type): SerializableRequest
    {
        if (!is_subclass_of($type, SerializableRequest::class)) {
            throw new InvalidArgumentException(
                sprintf('Expected subclass of %s. %s given', SerializableRequest::class, $type)
            );
        }

        try {
            $bodyParams = '' !== $request->getContent() ? json_decode(
                json: $request->getContent(),
                associative: true,
                flags: JSON_THROW_ON_ERROR,
            ) : [];
        } catch (JsonException) {
            throw new NotValidRequestBodyException();
        }

        $attributes = array_filter($request->attributes->all(), function ($key) {
            return !str_contains($key, '_');
        }, ARRAY_FILTER_USE_KEY);

        $data = array_merge($request->query->all(), $attributes, $bodyParams);

        $this->validator->validateArray($data, $type::validationConstraint());

        return $this->denormalizer->denormalize($data, $type, null, [
            AbstractObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true,
        ]);
    }
}
