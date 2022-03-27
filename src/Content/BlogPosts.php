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

    private function getDirectoryContents(): array
    {
        $posts = [];
        try {
            $files = $this->githubApi->contents()->show('elliotjreed', 'elliotjreed', 'blog');
            foreach ($files as $file) {
                if ('file' === $file['type']) {
                    $response = $this->githubApi->contents()->download('elliotjreed', 'elliotjreed', $file['path']);
                    $link = \substr(\substr($file['name'], 0, -3), 11);
                    $dateString = \substr($file['name'], 0, 10);
                    $posts[] = $this->buildPostSummary($response, $link, $dateString);
                }
            }
        } catch (ClientExceptionInterface) { /* phpcs:ignore Generic.CodeAnalysis.EmptyStatement.DetectedCatch */
        }

        return $posts;
    }
}
