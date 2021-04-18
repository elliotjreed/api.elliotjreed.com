<?php

declare(strict_types=1);

namespace App\Tests\Double\Github;

final class Repo extends \Github\Api\Repo
{
    public function __construct(private Contents $contents)
    {
    }

    public function contents(): Contents
    {
        return $this->contents;
    }
}
