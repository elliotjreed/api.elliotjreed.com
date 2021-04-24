<?php

declare(strict_types=1);

namespace App\Tests\Validator;

use App\Validator\NonEmptyField;
use PHPUnit\Framework\TestCase;

final class NonEmptyFieldTest extends TestCase
{
    public function testItReturnsFalseWithEmptyFieldErrorMessageWhenFieldIsNull(): void
    {
        $validator = new NonEmptyField();

        $this->assertFalse($validator->valid(null));
        $this->assertSame(['Please fill in all required fields'], $validator->getErrors());
    }

    public function testItReturnsFalseWithEmptyFieldErrorMessageWhenFieldIsEmptyString(): void
    {
        $validator = new NonEmptyField();

        $this->assertFalse($validator->valid(''));
        $this->assertSame(['Please fill in all required fields'], $validator->getErrors());
    }

    public function testItReturnsFalseWithEmptyFieldErrorMessageWhenFieldIsStringWithOnlyWhitespace(): void
    {
        $validator = new NonEmptyField();

        $this->assertFalse($validator->valid('          '));
        $this->assertSame(['Please fill in all required fields'], $validator->getErrors());
    }
}
