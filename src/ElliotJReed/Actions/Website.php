<?php
declare(strict_types=1);

namespace ElliotJReed\Actions;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class Website implements Action
{
    private $nginxIndexParser;

    public function __construct(ContainerInterface $container)
    {
        $this->nginxIndexParser = $container->get('nginxIndexParser');
    }

    public function __invoke(Request $request, Response $response, array $arguments = []): Response
    {
        return $response->withJson($this->nginxIndexParser->parse());
    }
}
