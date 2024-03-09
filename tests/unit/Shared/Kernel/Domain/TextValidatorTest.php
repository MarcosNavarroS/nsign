<?php

declare(strict_types=1);

namespace App\Tests\unit\Shared\Kernel\Domain;

use App\Shared\Kernel\Domain\TextValidator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class TextValidatorTest extends TestCase
{
    /** @test */
    public function shouldThrowExceptionOnNotBlankViolation(): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new TextValidator(DummyText::fromString('')))->notBlank();
    }

    /** @test */
    public function shouldThrowExceptionOnNotBlankViolationWithTrimEnabled(): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new TextValidator(DummyText::fromString(' ')))->notBlank(true);
    }

    /** @test */
    public function shouldNotThrowExceptionOnNotBlankViolationWithTrimDisabled(): void
    {
        $this->expectNotToPerformAssertions();

        (new TextValidator(DummyText::fromString(' ')))->notBlank();
    }

    /** @test */
    public function shouldNotThrowExceptionOnNotBlank(): void
    {
        $this->expectNotToPerformAssertions();

        (new TextValidator(DummyText::fromString('hello')))->notBlank();
    }

    /** @test */
    public function shouldThrowExceptionOnLengthViolation(): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new TextValidator(DummyText::fromString('hell')))->length(5);
    }

    /** @test */
    public function shouldNotThrowExceptionOnValidLength(): void
    {
        $this->expectNotToPerformAssertions();

        (new TextValidator(DummyText::fromString('hello')))->length(5);
    }

    /** @test */
    public function shouldThrowExceptionOnInvalidMinLength(): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new TextValidator(DummyText::fromString('hello')))->minLength(8);
    }

    /** @test */
    public function shouldNotThrowExceptionOnValidMinLength(): void
    {
        $this->expectNotToPerformAssertions();

        (new TextValidator(DummyText::fromString('hello')))->minLength(3);
    }
}
