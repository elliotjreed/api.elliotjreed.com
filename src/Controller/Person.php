<?php

declare(strict_types=1);

namespace App\Controller;

use App\Content\ElliotReed;
use App\Response\ApiJsonResponse;
use App\Response\ApiResponseData;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class Person
{
    #[Route('/api/v1/person', methods: ['GET'])]
    public function api(): ApiJsonResponse
    {
        return new ApiJsonResponse((new ApiResponseData())->setData(ElliotReed::schema()->toArray()));
    }

    #[Route('/schema/person', methods: ['GET'])]
    public function schema(): JsonResponse
    {
        return new JsonResponse(ElliotReed::schema()->toArray());
    }
}
