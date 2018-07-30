<?php
declare(strict_types=1);

namespace ElliotJReed\Parsers;

use ElliotJReed\Formatters\Url;
use DateTime;

class Files implements Parser
{
    private $urlFormatter;

    public function __construct(Url $urlFormatter)
    {
        $this->urlFormatter = $urlFormatter;
    }

    public function parse(string $source): string
    {
        $files = [];
        foreach (json_decode($source) as $item) {
            if ($item->type === 'file') {
                $title = $this->extractTitleFromFilename($item->name);
                $files[] = [
                    'title' => $title,
                    'link' => urlencode($item->name),
                    'slug' => $this->urlFormatter->format($title),
                    'created' => (new DateTime(substr($item->name, 0, 19)))->format(DateTime::ATOM),
                    'modified' => (new DateTime($item->mtime))->format(DateTime::ATOM)
                ];
            }
        }

        return json_encode($files);
    }

    private function extractTitleFromFilename(string $fileName): string
    {
        $dateRemoved = substr($fileName, 20);

        return pathinfo($dateRemoved, PATHINFO_FILENAME);
    }
}
