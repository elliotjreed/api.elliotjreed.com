<?php

declare(strict_types=1);

namespace App\Controller;

use App\Content\BlogPosts;
use App\Response\ApiJsonResponse;
use App\Response\ApiResponseData;
use DateInterval;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Cache\ItemInterface;

final class Posts
{
    #[Route('/api/v1/blog/posts', methods: ['GET'])]
    public function api(CacheItemPoolInterface $cache, BlogPosts $posts): ApiJsonResponse
    {
        $data = $cache->get(
            'posts.json',
            static function (ItemInterface $item) use ($posts): ApiResponseData {
                $item->expiresAfter(new DateInterval('P1D'));

                return (new ApiResponseData())->setData($posts->all()->toArray());
            }
        );

        return new ApiJsonResponse($data);
    }

    #[Route('/schema/blog/posts', methods: ['GET'])]
    public function schema(CacheItemPoolInterface $cache, BlogPosts $posts): JsonResponse
    {
        $data = $cache->get(
            'posts.ld.json',
            static function (ItemInterface $item) use ($posts): array {
                $item->expiresAfter(new DateInterval('P1D'));

                return $posts->all()->toArray();
            }
        );

        return new JsonResponse($data);
    }
}
