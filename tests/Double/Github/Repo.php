<?php

declare(strict_types=1);

namespace App\Tests\Double\Github;

final class Repo extends \Github\Api\Repo
{
    public bool $throwException = false;
    private Contents $contents;

    public function __construct(Contents $contents)
    {
        $this->contents = $contents;
    }

    public function contents(): Contents
    {
        if ($this->throwException) {
            throw new ApiException();
        }

        return $this->contents;
    }
}
