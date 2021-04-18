<?php

declare(strict_types=1);

namespace App\Tests\Double\Github;

final class Client extends \Github\Client
{
    public function __construct(private Repo $repo)
    {
    }

    public function api($name): Repo /** phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter */
    {
        return $this->repo;
    }
}
