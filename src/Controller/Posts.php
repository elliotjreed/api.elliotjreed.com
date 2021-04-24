<?php

declare(strict_types=1);

namespace App\Controller;

use App\Content\BlogPosts;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class Posts
{
    #[Route('/blog/posts', methods: ['GET'])]
    public function all(BlogPosts $posts): JsonResponse
    {
        return new JsonResponse($posts->all()->toArray());
    }
}
