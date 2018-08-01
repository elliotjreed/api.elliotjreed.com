<?php
declare(strict_types=1);

namespace ElliotJReed\Actions;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class Files implements Action
{
    private $filesParser;

    public function __construct(ContainerInterface $container)
    {
        $this->filesParser = $container->get('filesParser');
    }

    public function __invoke(Request $request, Response $response): Response
    {
        return $response->withJson($this->filesParser->parse('{}'), 200);
    }
}
