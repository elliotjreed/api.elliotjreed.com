<?php
declare(strict_types=1);

namespace ElliotJReed\Mappers;

use ElliotJReed\Exceptions\NotFoundException;
use ElliotJReed\Parsers\Parser;

class Slug
{
    private $parser;

    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    public function map(string $json, string $slug): string
    {
        $items = $this->parser->parse($json);
        foreach ($items as $item) {
            if (in_array($slug, $item)) {
                return $item['link'];
            }
        }

        throw new NotFoundException('Could not map slug: ' . $slug);
    }
}
