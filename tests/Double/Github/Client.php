<?php

declare(strict_types=1);

namespace App\Tests\Double\Github;

use Psr\Cache\CacheItemPoolInterface;

final class Client extends \Github\Client
{
    private Repo $repo;

    public function __construct(Repo $repo)
    {
        $this->repo = $repo;
    }

    public function api($name): Repo /* phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter */
    {
        return $this->repo;
    }

    public function addCache(CacheItemPoolInterface $cachePool, array $config = []): void /* phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter */
    {
    }
}
