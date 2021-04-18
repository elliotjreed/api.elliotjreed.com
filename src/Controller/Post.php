<?php

declare(strict_types=1);

namespace App\Controller;

use App\Content\BlogPost;
use App\Exception\BlogPostNotFound;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

final class Post
{
    #[Route('/blog/post/{dateString}/{link}', methods: ['GET'])]
    public function byLink(BlogPost $post, string $link, $dateString): JsonResponse
    {
        try {
            return new JsonResponse($post->fetch($link, $dateString)->toArray());
        } catch (BlogPostNotFound $exception) {
            throw new NotFoundHttpException();
        }
    }
}
