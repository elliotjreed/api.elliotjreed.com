<?php

declare(strict_types=1);

namespace App\Content;

use Github\Api\Repo;
use Github\Client;
use Psr\Cache\CacheItemPoolInterface;

final class Cv
{
    private Repo $githubApi;

    public function __construct(Client $githubClient, CacheItemPoolInterface $cachePool)
    {
        $githubClient->addCache($cachePool);
        $this->githubApi = $githubClient->api('repo');
    }

    public function asMarkdown(): string
    {
        return $this->githubApi->contents()->download('elliotjreed', 'elliotjreed', 'cv.md');
    }
}
