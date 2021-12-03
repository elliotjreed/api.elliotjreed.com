<?php

declare(strict_types=1);

namespace App\Tests\Double\Github;

use Github\Exception\InvalidArgumentException;

final class Contents extends \Github\Api\Repository\Contents
{
    public array $repositoryContents = [];
    public string $fileContents = "# A Test Post\nWith some test content";
    public bool $throwException = false;

    public function __construct()
    {
    }

    public function show($username, $repository, $path = null, $reference = null): array
    {
        return $this->repositoryContents;
    }

    public function download($username, $repository, $path, $reference = null): string
    {
        if ($this->throwException) {
            throw new InvalidArgumentException();
        }

        return $this->fileContents;
    }
}
