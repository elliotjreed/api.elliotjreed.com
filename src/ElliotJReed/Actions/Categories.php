<?php
declare(strict_types=1);

namespace ElliotJReed\Actions;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class Categories implements Action
{
    private $categoriesParser;

    public function __construct(ContainerInterface $container)
    {
        $this->categoriesParser = $container->get('categoriesParser');
    }

    public function __invoke(Request $request, Response $response): Response
    {
        return $response->withJson($this->categoriesParser->parse(file_get_contents('http://172.17.0.2')), 200);
    }
}
