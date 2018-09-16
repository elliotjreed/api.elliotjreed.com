<?php
declare(strict_types=1);

namespace ElliotJReed\Retrievers;

use ElliotJReed\Formatters\Url;
use DateTime;
use GuzzleHttp\ClientInterface;
use Spatie\SchemaOrg\Blog;
use Spatie\SchemaOrg\BlogPosting;
use stdClass;

class Posts extends Base
{
    private $guzzle;
    private $urlFormatter;
    private $posts = [];

    public function __construct(ClientInterface $guzzle, Url $urlFormatter)
    {
        /** @var ClientInterface guzzle */
        $this->guzzle = $guzzle;
        $this->urlFormatter = $urlFormatter;
    }

    public function get(string $uri): Blog
    {
        if (apcu_exists($uri)) {
            return apcu_fetch($uri);
        }

        $posts = $this->retrieveFromApi($uri);
        apcu_store($uri, $posts, 3600);

        return (new Blog())->url($uri)->inLanguage($this->getLanguage())->author($this->getAuthor())->name()->description()->blogPosts($posts);
    }

    private function retrieveFromApi(string $uri = ''): array
    {
        $body = $this->guzzle->request('GET', $uri)->getBody();
        foreach (json_decode($body->read($body->getSize())) as $item) {
            if ($item->type === 'directory') {
                $this->parseDirectory($uri, $item);
            }
        }

        return $this->posts;
    }

    private function parsePosts(stdClass $item, string $uri): void
    {
        $content = $this->guzzle->request('GET', $uri . '/' . rawurlencode($item->name))->getBody();
        $fileNameWithoutExtension = pathinfo($item->name, PATHINFO_FILENAME);
        $slug = strtolower($uri) . '/' . substr($this->urlFormatter->format($fileNameWithoutExtension), 20);
        $author = $this->getAuthor();
        $this->posts[$slug] = (new BlogPosting())
            ->headline($item->name)
            ->author($author)
            ->publisher($author)
            ->articleBody($content->read($content->getSize()))
            ->copyrightHolder($author)
            ->dateCreated(new DateTime(substr($item->name, 0, 19)))
            ->datePublished(new DateTime(substr($item->name, 0, 19)))
            ->dateModified(new DateTime($item->mtime))
            ->inLanguage($this->getLanguage())
            ->description($item->name)
            ->url($slug)
            ->isBasedOnUrl($uri . '/' . rawurlencode($item->name))
            ->mainEntityOfPage($slug . '#main');
    }

    private function parseDirectory(string $uri, stdClass $item): void
    {
        $categoryLink = $uri . '/' . rawurlencode($item->name);
        $categoryContents = $this->guzzle->request('GET', $categoryLink)->getBody();
        foreach (json_decode($categoryContents->read($categoryContents->getSize())) as $categoryItem) {
            if ($categoryItem->type === 'file') {
                $this->parsePosts($categoryItem, $categoryLink);
            }
        }
        $this->retrieveFromApi($categoryLink);
    }
}
