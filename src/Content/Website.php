<?php

declare(strict_types=1);

namespace App\Content;

use Github\Client;
use Parsedown;
use Spatie\SchemaOrg\Blog;
use Spatie\SchemaOrg\Schema;
use Symfony\Component\HttpClient\HttpClient;

final class Website
{
    private $client;
    private $parser;

    public function __construct(Client $client, Parsedown $parser)
    {
        $this->client = $client;
        $this->parser = $parser;
    }

    public function fetch(): Blog
    {
        $api = $this->client->api('repo');
        $directoryContents = $api->contents()->show('elliotjreed', 'content.elliotjreed.com');
        $posts = [];
        $httpClient = HttpClient::create();
        foreach ($directoryContents as $directory) {
            $subDirectoryContents = $api->contents()->show('elliotjreed', 'content.elliotjreed.com', $directory['path']);
            foreach ($subDirectoryContents as $subDirectoryContent) {
                $response = $httpClient->request('GET', $subDirectoryContent['download_url']);
                if ($response->getStatusCode() === 200) {
                    $posts[] = $this->buildPost($response->getContent(), $subDirectoryContent['name'], $directory['path']);
                }
            }
        }

        return Schema::blog()->blogPosts($posts);
    }

    public function buildPost(string $content, string $fileName, string $category)
    {
        $date = new \DateTime(\substr($fileName, 0, 10));;
        return Schema::blogPosting()
            ->name(\substr($fileName, 10))
            ->dateCreated($date)
            ->datePublished($date)
            ->articleBody($content)
            ->wordCount(\str_word_count($content))
            ->author(ElliotReed::schema())
            ->url('?')
            ->copyrightHolder(ElliotReed::schema())
            ->genre($category)
            ->headline(\strtok($content, "\n"))
            ->keywords($category)
            ->license('MIT')
            ->publisher(ElliotReed::schema());
    }
}
