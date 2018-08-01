<?php
declare(strict_types=1);

namespace ElliotJReed;

use ElliotJReed\Actions\Categories;
use ElliotJReed\Actions\Files;
use ElliotJReed\Formatters\Url;
use ElliotJReed\Parsers\Categories as CategoriesParser;
use ElliotJReed\Parsers\Files as FilesParser;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\App as SlimApp;

class App
{
    private $app;

    public function __construct(array $settings = [])
    {
        $app = new SlimApp($settings);

        $container = $app->getContainer();

        $container['logger'] = function (ContainerInterface $container): Logger {
            $settings = $container->get('settings')['logger'];
            return (new Logger($settings['name']))
                ->pushProcessor(new UidProcessor())
                ->pushHandler(new StreamHandler($settings['path'], $settings['level']));
        };

        $container['urlFormatter'] = function (): Url {
            return new Url();
        };

        $container['filesParser'] = function (ContainerInterface $container): FilesParser {
            return new FilesParser($container->get('urlFormatter'));
        };

        $container['categoriesParser'] = function (ContainerInterface $container): CategoriesParser {
            return new CategoriesParser($container->get('urlFormatter'));
        };

        $app->add(function (RequestInterface $req, ResponseInterface $res, callable $next) {
            $response = $next($req, $res);
            return $response
                ->withHeader('Access-Control-Allow-Origin', 'http://127.0.0.1:8000')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
        });

        $app->get('/files', Files::class);
        $app->get('/categories', Categories::class);

        $this->app = $app;
    }

    public function get(): SlimApp
    {
        return $this->app;
    }
}
