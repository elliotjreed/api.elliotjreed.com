<?php
declare(strict_types=1);

namespace ElliotJReed\Actions;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class Categories implements Action
{
    private $categories;

    public function __construct(ContainerInterface $container)
    {
        /** @var \ElliotJReed\Retrievers\Posts posts */
        $this->categories = $container->get('categories');
    }

    public function __invoke(Request $request, Response $response, array $arguments = []): Response
    {
        return $response->withJson($this->categories->get(''));
    }
}
