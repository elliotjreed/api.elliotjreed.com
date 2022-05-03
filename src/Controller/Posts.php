<?php

declare(strict_types=1);

namespace App\Controller;

use App\Content\BlogPosts;
use App\Response\ApiJsonResponse;
use App\Response\ApiResponseData;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class Posts
{
    #[Route('/api/v1/blog/posts', methods: ['GET'])]
    public function api(BlogPosts $posts): ApiJsonResponse
    {
        return new ApiJsonResponse((new ApiResponseData())->setData($posts->all()->toArray()));
    }

    #[Route('/schema/blog/posts', methods: ['GET'])]
    public function schema(BlogPosts $posts): JsonResponse
    {
        return new JsonResponse($posts->all()->toArray());
    }
}
