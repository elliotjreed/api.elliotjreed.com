<?php

declare(strict_types=1);

namespace App\Validator;

class NonEmptyField extends Validator
{
    public function valid(mixed $value): bool
    {
        if (!\is_string($value) || \trim($value) === '') {
            $this->errors[] = 'Please fill in all required fields';

            return false;
        }

        return true;
    }
}
