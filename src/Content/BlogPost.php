<?php

declare(strict_types=1);

namespace App\Content;

use App\Exception\BlogPostNotFound;
use DateTime;
use Github\Api\Repo;
use Github\Client;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Spatie\SchemaOrg\BlogPosting;
use Spatie\SchemaOrg\Organization;
use Spatie\SchemaOrg\Person;
use Spatie\SchemaOrg\Schema;

class BlogPost
{
    protected Repo $githubApi;

    public function __construct(Client $githubClient, CacheItemPoolInterface $cachePool)
    {
        $githubClient->addCache($cachePool);
        $this->githubApi = $githubClient->api('repo');
    }

    public function fetch(string $link, string $dateString): BlogPosting
    {
        try {
            $blogPostGitHubPath = 'blog/' . $dateString . ' ' . \str_replace('-', ' ', $link) . '.md';
            $githubResponse = $this->githubApi->contents()->download('elliotjreed', 'elliotjreed', $blogPostGitHubPath);

             return $this->buildPost($githubResponse, $link, $dateString);
        } catch (ClientExceptionInterface $exception) { /** phpcs:ignore Generic.CodeAnalysis.EmptyStatement.DetectedCatch */
        }

        throw new BlogPostNotFound($link);
    }

    public function buildPost(string $content, string $link, string $dateString): BlogPosting
    {
        return $this->buildPostSummary($content, $link, $dateString)->articleBody($content);
    }

    public function buildPostSummary(string $content, string $link, string $dateString): BlogPosting
    {
        $date = new DateTime($dateString);
        $websiteUrl = 'https://www.elliotjreed.com/blog/' . $dateString . '/' . \strtolower(\str_replace(' ', '-', $link));
        return Schema::blogPosting()
            ->name(\ucwords(\str_replace('-', ' ', $link)))
            ->dateCreated($date)
            ->datePublished($date)
            ->dateModified($date)
            ->wordCount(\str_word_count($content))
            ->author($this->person())
            ->url($websiteUrl)
            ->mainEntityOfPage($websiteUrl)
            ->inLanguage('en-GB')
            ->copyrightHolder($this->person())
            ->publisher((new Organization())->name('Elliot J. Reed')->logo(Schema::imageObject()->url('https://res.cloudinary.com/elliotjreed/image/upload/f_auto,q_auto/v1553434444/elliotjreed.jpg')))
            ->headline(\substr(\strtok($content, "\n"), 2))
            ->license('MIT')
            ->image(Schema::imageObject()->url('https://res.cloudinary.com/elliotjreed/image/upload/f_auto,q_auto/v1553434444/blog.png'))
            ->sameAs('https://github.com/elliotjreed/elliotjreed/blob/master/blog/' . \rawurlencode($dateString . ' ' . \str_replace('-', ' ', $link)) . '.md');
    }

    private function person(): Person
    {
        return Schema::person()
            ->name('Elliot J. Reed')
            ->alternateName('Elliot Reed')
            ->givenName('Elliot')
            ->additionalName('John')
            ->familyName('Reed');
    }
}
