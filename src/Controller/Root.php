<?php

declare(strict_types=1);

namespace App\Controller;

use App\Response\ApiJsonResponse;
use App\Response\ApiResponseData;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class Root
{
    #[Route('/', methods: ['GET', 'POST', 'PUT', 'PATCH'])]
    public function root(): JsonResponse
    {
        return new JsonResponse("Hi there! I'm Elliot, welcome to my API!");
    }

    #[Route('/api/v1', methods: ['GET', 'POST', 'PUT', 'PATCH'])]
    public function index(): ApiJsonResponse
    {
        return new ApiJsonResponse(
            (new ApiResponseData())->setData(["Hi there! I'm Elliot, welcome to my API!"])
        );
    }
}
