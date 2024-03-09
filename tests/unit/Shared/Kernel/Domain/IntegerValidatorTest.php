<?php

declare(strict_types=1);

namespace App\Tests\unit\Shared\Kernel\Domain;

use App\Shared\Kernel\Domain\IntegerValidator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class IntegerValidatorTest extends TestCase
{
    /** @test */
    public function shouldThrowExceptionOnPositiveViolation(): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new IntegerValidator(DummyInteger::fromInt(-1)))->positive();
    }

    /** @test */
    public function shouldNotThrowExceptionOnPositive(): void
    {
        $this->expectNotToPerformAssertions();

        (new IntegerValidator(DummyInteger::fromInt(1)))->positive();
    }

    /** @test */
    public function shouldThrowExceptionOnBetweenViolation(): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new IntegerValidator(DummyInteger::fromInt(6)))->between(1, 5);
    }

    /** @test */
    public function shouldNotThrowExceptionOnBetween(): void
    {
        $this->expectNotToPerformAssertions();

        (new IntegerValidator(DummyInteger::fromInt(5)))->between(1, 5);
    }
}