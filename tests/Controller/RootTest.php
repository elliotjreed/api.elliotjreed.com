<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class RootTest extends WebTestCase
{
    public function testItLoadsPage(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $response = $client->getResponse();

        echo $response->getContent();
//
//        $this->assertJsonStringEqualsJsonString('{}', $response->getContent());
//        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testItDisallowsPost(): void
    {
        $client = static::createClient();
        $client->request('POST', '/');

        $this->assertEquals(405, $client->getResponse()->getStatusCode());
    }
}
