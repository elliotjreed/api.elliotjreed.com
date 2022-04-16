<?php

declare(strict_types=1);

namespace App\Controller;

use App\Response\ApiJsonResponse;
use App\Response\ApiResponseData;
use Symfony\Component\Routing\Annotation\Route;

final class Root
{
    #[Route('/', methods: ['GET', 'POST', 'PUT', 'PATCH'])]
    public function index(): ApiJsonResponse
    {
        return new ApiJsonResponse(
            (new ApiResponseData())->setData(["Hi there! I'm Elliot, welcome to my API!"])
        );
    }
}
