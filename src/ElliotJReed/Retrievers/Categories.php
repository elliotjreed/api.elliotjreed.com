<?php
declare(strict_types=1);

namespace ElliotJReed\Retrievers;

use ElliotJReed\Formatters\Url;
use GuzzleHttp\ClientInterface;
use Spatie\SchemaOrg\BreadcrumbList;
use Spatie\SchemaOrg\ListItem;
use stdClass;

class Categories
{
    private $guzzle;
    private $urlFormatter;
    private $categories = [];

    public function __construct(ClientInterface $guzzle, Url $urlFormatter)
    {
        /** @var ClientInterface guzzle */
        $this->guzzle = $guzzle;
        $this->urlFormatter = $urlFormatter;
    }

    public function get(string $uri): BreadcrumbList
    {
        if (apcu_exists($uri)) {
            return apcu_fetch($uri);
        }

        $categories = (new BreadcrumbList())
            ->itemListElement($this->categories);
        apcu_store($uri, $categories, 3600);

        return $categories;
    }

    public function retrieve(string $uri = ''): Categories
    {
        $body = $this->guzzle->request('GET', $uri)->getBody();
        foreach (json_decode($body->read($body->getSize())) as $item) {
            if ($item->type === 'directory') {
                $this->parseDirectory($uri, $item);
            }
        }

        return $this;
    }

    private function parseDirectory(string $uri, stdClass $item): void
    {
        $categoryLink = $uri . '/' . rawurlencode($item->name);
        $this->categories[] = (new ListItem())
            ->name($item->name)
            ->url($uri . '/' . $this->urlFormatter->format($item->name));
        $this->retrieve($categoryLink);
    }
}
