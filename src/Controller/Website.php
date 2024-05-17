<?php

declare(strict_types=1);

namespace App\Controller;

use App\Content\Website as WebsiteSchema;
use App\Response\ApiJsonResponse;
use App\Response\ApiResponseData;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class Website
{
    #[Route('/api/v1/website', methods: ['GET'])]
    public function api(): ApiJsonResponse
    {
        return new ApiJsonResponse((new ApiResponseData())->setData(WebsiteSchema::schema()->toArray()));
    }

    #[Route('/schema/website', methods: ['GET'])]
    public function schema(): JsonResponse
    {
        return new JsonResponse(WebsiteSchema::schema()->toArray());
    }
}
