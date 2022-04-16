<?php

declare(strict_types=1);

namespace App\Controller;

use App\Content\BlogPosts;
use App\Response\ApiJsonResponse;
use App\Response\ApiResponseData;
use Symfony\Component\Routing\Annotation\Route;

final class Posts
{
    #[Route('/blog/posts', methods: ['GET'])]
    public function all(BlogPosts $posts): ApiJsonResponse
    {
        return new ApiJsonResponse((new ApiResponseData())->setData($posts->all()->toArray()));
    }
}
