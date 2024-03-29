<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class RootTest extends WebTestCase
{
    public function testItReturnsWelcomeMessageJsonResponse(): void
    {
        $client = self::createClient();

        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertJsonStringEqualsJsonString(
            '"Hi there! I\'m Elliot, welcome to my API!"',
            $client->getResponse()->getContent()
        );
    }

    public function testItReturnsWelcomeMessageJsonApiResponse(): void
    {
        $client = self::createClient();

        $client->request('GET', '/api/v1');

        $this->assertResponseIsSuccessful();
        $this->assertJsonStringEqualsJsonString('{
          "data": [
            "Hi there! I\'m Elliot, welcome to my API!"
          ],
          "errors": []
        }', $client->getResponse()->getContent());
    }
}
