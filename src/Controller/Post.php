<?php

declare(strict_types=1);

namespace App\Controller;

use App\Content\BlogPost;
use App\Exception\BlogPostNotFound;
use App\Response\ApiJsonResponse;
use App\Response\ApiResponseData;
use DateInterval;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Cache\ItemInterface;

final class Post
{
    #[Route(
        '/api/v1/blog/post/{date}/{link}',
        requirements: ['date' => '^\d{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$'],
        methods: ['GET']
    )]
    public function api(CacheItemPoolInterface $cache, BlogPost $post, string $link, string $date): ApiJsonResponse
    {
        try {
            $data = $cache->get(
                $date . '_' . $link . '.json',
                static function (ItemInterface $item) use ($post, $link, $date): ApiResponseData {
                    $item->expiresAfter(new DateInterval('P3M'));

                    return (new ApiResponseData())->setData($post->fetch($link, $date)->toArray());
                }
            );

            return new ApiJsonResponse($data);
        } catch (BlogPostNotFound) {
            throw new NotFoundHttpException('Blog post not found.');
        }
    }

    #[Route(
        '/schema/blog/post/{date}/{link}',
        requirements: ['date' => '^\d{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$'],
        methods: ['GET']
    )]
    public function schema(CacheItemPoolInterface $cache, BlogPost $post, string $link, string $date): JsonResponse
    {
        try {
            $data = $cache->get(
                $date . '_' . $link . '.ld.json',
                static function (ItemInterface $item) use ($post, $link, $date): array {
                    $item->expiresAfter(new DateInterval('P3M'));

                    return $post->fetch($link, $date)->toArray();
                }
            );

            return new JsonResponse($data);
        } catch (BlogPostNotFound) {
            throw new NotFoundHttpException('Blog post not found.');
        }
    }
}
