<?php
declare(strict_types=1);

namespace Tests\ElliotJReed\Actions;

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
        $response = $this->httpGetRequest('/categories');

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testItReturnsJsonContentType(): void
    {
        $response = $this->httpGetRequest('/categories');

        $this->assertEquals('application/json;charset=utf-8', $response->getHeaders()['Content-Type'][0]);
    }

    public function testItDoesNotAllowPost(): void
    {
        $response = $this->httpPostRequest('/categories', '');

        $this->assertEquals(405, $response->getStatusCode());
    }
}
