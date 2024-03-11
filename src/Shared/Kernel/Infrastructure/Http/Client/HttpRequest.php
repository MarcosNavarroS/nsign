<?php

declare(strict_types=1);

namespace App\Shared\Kernel\Infrastructure\Http\Client;

use InvalidArgumentException;

final class HttpRequest
{
    public array $headers;
    public array $headerNames;

    public function __construct(
        public readonly string $method,
        public readonly string $uri,
        array $headers = [],
        public readonly ?string $body = null,
        public readonly string $version = '1.1',
        public readonly bool $checkCertificate = true,
    ) {
        $this->setHeaders($headers);
    }

    public function hasHeader($header): bool
    {
        return isset($this->headerNames[strtolower($header)]);
    }

    public function getHeader($header): ?string
    {
        $header = strtolower($header);

        if (!isset($this->headerNames[$header])) {
            return null;
        }

        $header = $this->headerNames[$header];

        return $this->headers[$header];
    }

    public function getHeaderLine($header): string
    {
        return implode(', ', $this->getHeader($header));
    }

    public function setHeader(string $key, string $value): void
    {
        $this->headerNames[strtolower($key)] = $key;
        $this->headers[$key] = $this->normalizeHeaderValue($value);
    }

    private function setHeaders(array $headers): void
    {
        $headerNames = $headerValues = [];
        foreach ($headers as $header => $value) {
            if (is_int($header)) {
                // Numeric array keys are converted to int by PHP but having a header name '123' is not forbidden by the spec
                // and also allowed in withHeader(). So we need to cast it to string again for the following assertion to pass.
                $header = (string)$header;
            }
            $this->assertHeader($header);
            $value = $this->normalizeHeaderValue($value);
            $normalized = strtolower($header);
            if (isset($headerNames[$normalized])) {
                $header = $headerNames[$normalized];
                $headerValues[$header] = array_merge($this->headers[$header], $value);
            } else {
                $headerNames[$normalized] = $header;
                $headerValues[$header] = $value;
            }
        }
        $this->headerNames = $headerNames;
        $this->headers = $headerValues;
    }

    private function assertHeader($header): void
    {
        if (!is_string($header)) {
            throw new InvalidArgumentException(sprintf(
                'Header name must be a string but %s provided.',
                is_object($header) ? get_class($header) : gettype($header)
            ));
        }

        if ($header === '') {
            throw new InvalidArgumentException('Header name can not be empty.');
        }
    }

    private function normalizeHeaderValue($value): array
    {
        if (!is_array($value)) {
            return $this->trimHeaderValues([$value]);
        }

        if (count($value) === 0) {
            throw new InvalidArgumentException('Header value can not be an empty array.');
        }

        return $this->trimHeaderValues($value);
    }

    private function trimHeaderValues(array $values): array
    {
        return array_map(function ($value) {
            if (!is_scalar($value) && null !== $value) {
                throw new InvalidArgumentException(sprintf(
                    'Header value must be scalar or null but %s provided.',
                    is_object($value) ? get_class($value) : gettype($value)
                ));
            }

            return trim((string) $value, " \t");
        }, array_values($values));
    }
}
