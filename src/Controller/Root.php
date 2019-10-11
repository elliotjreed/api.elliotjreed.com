<?php

declare(strict_types=1);

namespace App\Controller;

use App\Content\Website;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class Root
{
    /**
     * @Route("/", methods={"GET"})
     */
    public function index(Website $website): JsonResponse
    {
        return new JsonResponse($website->fetch()->toArray());
    }
}
