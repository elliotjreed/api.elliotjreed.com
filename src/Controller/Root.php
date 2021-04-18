<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class Root
{
    #[Route('/', methods: ['GET', 'POST'])]
    public function index(): JsonResponse
    {
        return new JsonResponse();
    }
}
