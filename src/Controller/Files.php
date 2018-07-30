<?php
declare(strict_types=1);

namespace App\Controller;

use App\Parsers\Files as FilesParser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class Files extends AbstractController
{
    /**
     * @Route("/files", methods={"GET"})
     */
    public function all(FilesParser $parser): JsonResponse
    {
        return new JsonResponse($parser->parse(file_get_contents(getenv('CONTENT'))),
            200,
            [
                'Access-Control-Allow-Origin' => getenv('CROSS_ORIGIN'),
                'Access-Control-Allow-Headers' => 'Origin, Content-Type, Content-Length'
            ]
        );
    }

    /**
     * @Route("/files/{categoryLink}", methods={"GET"})
     */
    public function inCategory(string $categoryLink, FilesParser $parser): JsonResponse
    {
        $url = getenv('CONTENT') . '/' . $categoryLink;

        return new JsonResponse($parser->parse(file_get_contents($url)), 200, [
            'Access-Control-Allow-Origin' => getenv('CROSS_ORIGIN'),
            'Access-Control-Allow-Headers' => 'Origin, Content-Type, Content-Length'
        ]);
    }
}
