<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Github\Api\Repo;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class PostTest extends WebTestCase
{
    public function testItReturnsBlogPostJson(): void
    {
        $client = self::createClient();

        $client->request('GET', '/blog/post/1970-01-01/test-post');

        $this->assertResponseIsSuccessful();
        $this->assertJsonStringEqualsJsonString('
          {
              "@context": "https://schema.org",
              "@type": "BlogPosting",
              "articleBody": "# A Test Post\nWith some test content",
              "author": {
                  "@type": "Person",
                  "additionalName": "John",
                  "alternateName": "Elliot Reed",
                  "familyName": "Reed",
                  "givenName": "Elliot",
                  "name": "Elliot J. Reed"
              },
              "copyrightHolder": {
                  "@type": "Person",
                  "additionalName": "John",
                  "alternateName": "Elliot Reed",
                  "familyName": "Reed",
                  "givenName": "Elliot",
                  "name": "Elliot J. Reed"
              },
              "dateCreated": "1970-01-01T19:00:00+01:00",
              "dateModified": "1970-01-01T19:00:00+01:00",
              "datePublished": "1970-01-01T19:00:00+01:00",
              "headline": "A Test Post",
              "image": {
                  "@type": "ImageObject",
                  "url": "https://res.cloudinary.com/elliotjreed/image/upload/f_auto,q_auto/v1553434444/blog/ejr-rectangle-logo.png"
              },
              "inLanguage": "en-GB",
              "license": "MIT",
              "mainEntityOfPage": "https://www.elliotjreed.com/blog/1970-01-01/test-post",
              "name": "Test Post",
              "publisher": {
                  "@type": "Organization",
                  "logo": {
                      "@type": "ImageObject",
                      "url": "https://res.cloudinary.com/elliotjreed/image/upload/f_auto,q_auto/v1553434444/blog/ejr-rectangle-logo.png"
                  },
                  "name": "Elliot J. Reed"
              },
              "sameAs": "https://github.com/elliotjreed/elliotjreed/blob/master/blog/1970-01-01%20test%20post.md",
              "url": "https://www.elliotjreed.com/blog/1970-01-01/test-post",
              "wordCount": 7
          }
        ', $client->getResponse()->getContent());
    }

    public function testItReturnsHttpNotFoundResponseWhenPostNotFound(): void
    {
        $client = self::createClient();

        $client->getContainer()->get(Repo::class)->throwException = true;

        $client->request('GET', '/blog/post/1970-01-01/test-post');

        $this->assertResponseStatusCodeSame(404);
        $this->assertJsonStringEqualsJsonString('
          {
            "errors": [
              "Blog post not found."
            ],
            "request": "",
            "uri": "http://localhost/blog/post/1970-01-01/test-post"
          }
        ', $client->getResponse()->getContent());
    }
}
