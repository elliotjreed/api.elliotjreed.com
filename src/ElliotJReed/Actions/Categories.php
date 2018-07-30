<?php
declare(strict_types=1);

namespace ElliotJReed\Actions;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class Categories implements Action
{
    private $categoriesParser;

    public function __construct(ContainerInterface $container)
    {
        $this->categoriesParser = $container->get('categoriesParser');
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $response->withJson($this->categoriesParser->parse('{}'), 200);
    }
}
