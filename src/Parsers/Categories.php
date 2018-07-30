<?php
declare(strict_types=1);

namespace App\Parsers;

use App\Formatters\Url;
use DateTime;

class Categories implements Parser
{
    private $urlFormatter;

    public function __construct(Url $urlFormatter)
    {
        $this->urlFormatter = $urlFormatter;
    }

    public function parse(string $source): string
    {
        $listing = json_decode($source);

        $categories = [];
        foreach ($listing as $item) {
            if ($item->type === 'directory') {
                $categories[] = [
                    'title' => $item->name,
                    'link' => urlencode($item->name),
                    'slug' => $this->urlFormatter->format($item->name),
                    'modified' => (new DateTime($item->mtime))->format(DateTime::ATOM)
                ];
            }
        }

        return json_encode($categories);
    }
}
