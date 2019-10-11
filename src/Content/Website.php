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
        $me = Schema::person()->name('Elliot J. Reed');
        $httpClient = HttpClient::create();
        foreach ($directoryContents as $directory) {
            $subDirectoryContents = $api->contents()->show('elliotjreed', 'content.elliotjreed.com', $directory['path']);
            foreach ($subDirectoryContents as $subDirectoryContent) {
                $response = $httpClient->request('GET', $subDirectoryContent['download_url']);
                $statusCode = $response->getStatusCode();
                if ($statusCode === 200) {
                    $date = new \DateTime(\substr($subDirectoryContent['name'], 0, 10));
                    $content = $response->getContent();
                    $posts[] = Schema::blogPosting()
                        ->name(\substr($subDirectoryContent['name'], 10))
                        ->dateCreated($date)
                        ->datePublished($date)
                        ->articleBody($content)
                        ->wordCount(\str_word_count($content))
                        ->author($me)
                        ->url('?')
                        ->copyrightHolder($me)
                        ->genre($directory['path'])
                        ->headline(\strtok($content, "\n"))
                        ->keywords($directory['path'])
                        ->license('MIT')
                        ->publisher($me);
                    $directories[$directory['name']][$subDirectoryContent['name']] = $content;
                }
            }
        }

        return Schema::blog()->blogPosts($posts);
    }
}
