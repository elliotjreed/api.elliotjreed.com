<?php
declare(strict_types=1);

namespace ElliotJReed\Actions;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

interface Action
{
    public function __construct(ContainerInterface $container);
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface;
}
