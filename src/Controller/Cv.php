<?php

declare(strict_types=1);

namespace App\Controller;

use App\Content\Cv as GithubCv;
use App\Response\ApiJsonResponse;
use App\Response\ApiResponseData;
use App\Response\MarkdownResponse;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\ItemInterface;

final class Cv
{
    #[Route('/api/v1/cv', methods: ['GET'])]
    public function api(CacheItemPoolInterface $cache, GithubCv $cv): ApiJsonResponse
    {
        $data = $cache->get(
            'cv.json',
            static function (ItemInterface $item) use ($cv): ApiResponseData {
                $item->expiresAfter(new \DateInterval('P1W'));

                return (new ApiResponseData())->setData($cv->asMarkdown());
            }
        );

        return new ApiJsonResponse($data);
    }

    #[Route('/cv.md', methods: ['GET'])]
    public function markdown(CacheItemPoolInterface $cache, GithubCv $cv): MarkdownResponse
    {
        $data = $cache->get(
            'cv.md',
            static function (ItemInterface $item) use ($cv): string {
                $item->expiresAfter(new \DateInterval('P1W'));

                return $cv->asMarkdown();
            }
        );

        return new MarkdownResponse($data);
    }
}
