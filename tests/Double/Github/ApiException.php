<?php

declare(strict_types=1);

namespace App\Tests\Double\Github;

use Exception;
use Psr\Http\Client\ClientExceptionInterface;

final class ApiException extends Exception implements ClientExceptionInterface
{
    public function __toString(): string
    {
        return '__toString';
    }
}
