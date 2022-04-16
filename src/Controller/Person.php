<?php

declare(strict_types=1);

namespace App\Controller;

use App\Content\ElliotReed;
use App\Response\ApiJsonResponse;
use App\Response\ApiResponseData;
use Symfony\Component\Routing\Annotation\Route;

final class Person
{
    #[Route('/blog/author', methods: ['GET'])]
    public function index(): ApiJsonResponse
    {
        return new ApiJsonResponse((new ApiResponseData())->setData(ElliotReed::schema()->toArray()));
    }
}
