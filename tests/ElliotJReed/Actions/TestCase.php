<?php
declare(strict_types=1);

namespace ElliotJReed\Tests\Actions;

use ElliotJReed\App;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Environment;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\RequestBody;
use Slim\Http\Response;
use Slim\Http\Uri;

class TestCase extends PHPUnitTestCase
{
    protected $app;
    protected $response;

    public function setUp(): void
    {
        $this->app = (new App([
            'settings' => []
        ]))->get();
    }

    protected function httpGetRequest(string $url): ResponseInterface
    {
        $environment = Environment::mock([
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => $url,
        ]);

        $request = Request::createFromEnvironment($environment);
        $this->app->getContainer()['request'] = $request;

        $response = $this->app->run(true);
        $response->getBody()->rewind();

        return $response;
    }

    protected function httpPostRequest(string $url, string $requestParameters): ResponseInterface
    {
        $env = Environment::mock([
            'SCRIPT_NAME' => '/index.php',
            'REQUEST_URI' => $url,
            'REQUEST_METHOD' => 'POST',
        ]);

        $body = new RequestBody();
        $body->write($requestParameters);
        $request = (new Request(
            'POST',
            Uri::createFromEnvironment($env),
            Headers::createFromEnvironment($env),
            [],
            $env->all(),
            $body
        ))->withHeader('Content-Type', 'application/json');

        $app = $this->app;
        $response = $app($request, new Response());
        $response->getBody()->rewind();

        return $response;
    }
}
