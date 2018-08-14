<?php
declare(strict_types=1);

namespace ElliotJReed\Actions;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

interface Action
{
    public function __construct(ContainerInterface $container);
    public function __invoke(Request $request, Response $response, array $arguments = []): Response;
}
