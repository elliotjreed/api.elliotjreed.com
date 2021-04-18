<?php

declare(strict_types=1);

namespace App\Controller;

use App\Content\BlogPosts;
use App\Response\MarkdownResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class Posts
{
    #[Route('/blog/posts', methods: ['GET'])]
    public function all(BlogPosts $posts): JsonResponse
    {
        return new JsonResponse($posts->all()->toArray());
    }

    #[Route('/blog/markdown', methods: ['GET'])]
    public function markdown(BlogPosts $posts): Response
    {
        return new MarkdownResponse($posts->markdown());
    }
}
