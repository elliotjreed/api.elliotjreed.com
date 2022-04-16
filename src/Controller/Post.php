<?php

declare(strict_types=1);

namespace App\Controller;

use App\Content\BlogPost;
use App\Exception\BlogPostNotFound;
use App\Response\ApiJsonResponse;
use App\Response\ApiResponseData;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

final class Post
{
    #[Route(
        '/blog/post/{dateString}/{link}',
        requirements: ['dateString' => '^\d{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$'],
        methods: ['GET']
    )]
    public function byLink(BlogPost $post, string $link, $dateString): ApiJsonResponse
    {
        try {
            return new ApiJsonResponse((new ApiResponseData())->setData($post->fetch($link, $dateString)->toArray()));
        } catch (BlogPostNotFound) {
            throw new NotFoundHttpException('Blog post not found.');
        }
    }
}
