<?php
declare(strict_types=1);

namespace ElliotJReed\Actions;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class Files implements Action
{
    private $filesParser;

    public function __construct(ContainerInterface $container)
    {
        $this->filesParser = $container->get('filesParser');
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $response->withJson($this->filesParser->parse('{}'), 200);
    }
}
