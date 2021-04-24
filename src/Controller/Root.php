<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class Root
{
    #[Route('/', methods: ['GET', 'POST', 'PUT', 'PATCH'])]
    public function index(): JsonResponse
    {
        return new JsonResponse(['welcome' => "Hi there! I'm Elliot, welcome to my API!"]);
    }
}
