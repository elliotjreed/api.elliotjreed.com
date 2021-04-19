<?php

declare(strict_types=1);

namespace App\Tests\Content;

use App\Content\BlogPost;
use App\Exception\BlogPostNotFound;
use App\Tests\Double\Github\Client;
use App\Tests\Double\Github\Contents;
use App\Tests\Double\Github\Repo;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

final class BlogPostTest extends TestCase
{
    public function testItThrowsExceptionWhenNoPostsFound(): void
    {
        $contents = new Contents();
        $contents->throwException = true;
        $githubApiClient = new Client(new Repo($contents));

        $schema = new BlogPost($githubApiClient, new ArrayAdapter());

        $this->expectException(BlogPostNotFound::class);
        $this->expectExceptionMessage('post-link');

        $schema->fetch('post-link', '2020-01-01');
    }

    public function testItRendersSchemaForDirectLink(): void
    {
        $contents = new Contents();
        $contents->fileContents = "# A Test Post\nWith some test content";
        $githubApiClient = new Client(new Repo($contents));

        $schema = new BlogPost($githubApiClient, new ArrayAdapter());

        $expected = [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'name' => 'Post Link',
            'dateCreated' => '2020-01-01T00:00:00+00:00',
            'datePublished' => '2020-01-01T00:00:00+00:00',
            'dateModified' => '2020-01-01T00:00:00+00:00',
            'wordCount' => 7,
            'author' => [
                '@type' => 'Person',
                'name' => 'Elliot J. Reed',
                'alternateName' => 'Elliot Reed',
                'givenName' => 'Elliot',
                'additionalName' => 'John',
                'familyName' => 'Reed'
            ],
            'url' => 'https://www.elliotjreed.com/blog/2020-01-01/post-link',
            'mainEntityOfPage' => 'https://www.elliotjreed.com/blog/2020-01-01/post-link',
            'inLanguage' => 'en-GB',
            'copyrightHolder' => [
                '@type' => 'Person',
                'name' => 'Elliot J. Reed',
                'alternateName' => 'Elliot Reed',
                'givenName' => 'Elliot',
                'additionalName' => 'John',
                'familyName' => 'Reed'
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Elliot J. Reed',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => 'https://res.cloudinary.com/elliotjreed/image/upload/f_auto,q_auto/v1553434444/blog/ejr-rectangle-logo.png'
                ],
            ],
            'headline' => 'A Test Post',
            'license' => 'MIT',
            'image' => [
                '@type' => 'ImageObject',
                'url' => 'https://res.cloudinary.com/elliotjreed/image/upload/f_auto,q_auto/v1553434444/blog/ejr-rectangle-logo.png'
            ],
            'sameAs' => 'https://github.com/elliotjreed/elliotjreed/blob/master/blog/2020-01-01%20post%20link.md',
            'articleBody' => "# A Test Post\nWith some test content"
        ];

        $this->assertSame($expected, $schema->fetch('post-link', '2020-01-01')->toArray());
    }
}
