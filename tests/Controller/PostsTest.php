<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class PostsTest extends WebTestCase
{
    public function testItReturnsBlogPostJson(): void
    {
        $client = self::createClient();

        $client->request('GET', '/blog/posts');

        $this->assertResponseIsSuccessful();
        $this->assertJsonStringEqualsJsonString('{
          "data": {
            "@context": "https://schema.org",
            "@type": "Blog",
            "blogPosts": []
          },
          "errors": []
        }', $client->getResponse()->getContent());
    }
}
