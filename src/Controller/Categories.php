<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class Categories
{
    /**
     * @Route("/categories", methods={"GET"})
     */
    public function all(): JsonResponse
    {
        return new JsonResponse([], 200, [
            'Access-Control-Allow-Origin' => getenv('CROSS_ORIGIN'),
            'Access-Control-Allow-Headers' => 'Origin, Content-Type, Content-Length'
        ]);
    }
}
