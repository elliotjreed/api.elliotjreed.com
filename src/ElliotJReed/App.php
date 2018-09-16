<?php
declare(strict_types=1);

namespace ElliotJReed;

use ElliotJReed\Actions\Website;
use ElliotJReed\Formatters\Url;
use ElliotJReed\Mappers\Slug;
use ElliotJReed\Retrievers\Categories;
use ElliotJReed\Retrievers\NginxIndex;
use ElliotJReed\Retrievers\Post;
use ElliotJReed\Retrievers\Posts;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
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

        $container['guzzle'] = function (ContainerInterface $container): ClientInterface {
            return new Client(['base_uri' => $container->get('settings')['api']['baseUri']]);
        };

        $container['urlFormatter'] = function (): Url {
            return new Url();
        };

        $container['categories'] = function (ContainerInterface $container): Categories {
            return new Categories($container->get('guzzle'), $container->get('urlFormatter'));
        };

        $container['posts'] = function (ContainerInterface $container): Posts {
            return new Posts($container->get('guzzle'), $container->get('urlFormatter'));
        };

        $container['categorySlugMapper'] = function (ContainerInterface $container): Slug {
            return new Slug($container->get('categoriesParser'));
        };

        $app->add(function (RequestInterface $req, ResponseInterface $res, callable $next): ResponseInterface {
            $response = $next($req, $res);
            return $response->withHeader('Access-Control-Allow-Origin', 'http://localhost:8000')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
        });

        $app->get('/', Website::class);
        $app->get('/posts', \ElliotJReed\Actions\Posts::class);
        $app->get('/categories', \ElliotJReed\Actions\Categories::class);

        $this->app = $app;
    }

    public function get(): SlimApp
    {
        return $this->app;
    }
}
