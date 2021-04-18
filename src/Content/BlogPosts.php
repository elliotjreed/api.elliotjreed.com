<?php

declare(strict_types=1);

namespace App\Content;

use Psr\Http\Client\ClientExceptionInterface;
use Spatie\SchemaOrg\Blog;
use Spatie\SchemaOrg\Schema;

final class BlogPosts extends BlogPost
{
    public function all(): Blog
    {
        $posts = $this->getDirectoryContents();

        \sort($posts);

        return Schema::blog()->blogPosts($posts);
    }

    public function markdown(): string
    {
        $contentsApi = $this->githubApi->contents();
        $directoryContents = $contentsApi->show('elliotjreed', 'elliotjreed', 'blog');
        $posts = '';
        foreach ($directoryContents as $directory) {
            $posts .= '- [' . $directory['name'] . '](' . $directory['path'] . ')' . PHP_EOL;
        }

        return $posts;
    }

    private function getDirectoryContents(): array
    {
        $posts = [];
        try {
            $files = $this->githubApi->contents()->show('elliotjreed', 'elliotjreed', 'blog');
            foreach ($files as $file) {
                if ($file['type'] === 'file') {
                    $response = $this->githubApi->contents()->download('elliotjreed', 'elliotjreed', $file['path']);
                    $link = \substr(\substr($file['name'], 0, -3), 11);
                    $dateString = \substr($file['name'], 0, 10);
                    $posts[] = $this->buildPostSummary($response, $link, $dateString);
                }
            }
        } catch (ClientExceptionInterface $exception) { /** phpcs:ignore Generic.CodeAnalysis.EmptyStatement.DetectedCatch */
        }

        return $posts;
    }
}
