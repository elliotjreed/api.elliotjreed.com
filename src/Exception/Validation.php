<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;
use Throwable;

final class Validation extends Exception
{
    private array $errors = [];

    public function __construct(string $message = '', int $code = 0, Throwable $previous = null)
    {
        $this->errors[] = $message;
        parent::__construct($message, $code, $previous);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setErrors(array $errors): self
    {
        $this->errors = $errors;

        return $this;
    }
}
