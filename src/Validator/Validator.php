<?php

declare(strict_types=1);

namespace App\Validator;

abstract class Validator
{
    protected array $errors = [];

    public function getErrors(): array
    {
        return $this->errors;
    }
}
