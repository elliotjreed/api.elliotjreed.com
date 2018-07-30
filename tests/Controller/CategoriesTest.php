<?php
declare(strict_types=1);

namespace App\Tests\Controller;

use SplFileObject;

class CategoriesTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        (new SplFileObject('/tmp/content.json', 'w'))->fwrite('[]');
        putenv('CONTENT=/tmp/content.json');
    }

    public function testItHasHttpResponseCodeOf200(): void
    {
        $this->client->request('GET', '/categories');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testItReturnsJsonContentType(): void
    {
        $this->client->request('GET', '/categories');

        $this->assertTrue(
            $this->client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }

    public function testItDoesNotAllowPost(): void
    {
        $this->expectException('Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException');

        $this->client->request('POST', '/categories');
    }
}
