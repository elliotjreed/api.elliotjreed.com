<?php

declare(strict_types=1);

namespace App\Controller;

use App\Content\ElliotReed;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class Person
{
    #[Route('/blog/author', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return new JsonResponse(ElliotReed::schema()->toArray());
    }
}
