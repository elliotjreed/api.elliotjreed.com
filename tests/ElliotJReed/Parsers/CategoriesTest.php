<?php
declare(strict_types=1);

namespace Tests\ElliotJReed\Parsers;

use ElliotJReed\Formatters\Url;
use ElliotJReed\Parsers\Categories;
use PHPUnit\Framework\TestCase;

class CategoriesTest extends TestCase
{
    public function testItParsesDirectoryListingToCategoryList(): void
    {
        $json = '[
            {"name": "Category One", "type": "directory", "mtime": "Thu, 1 Jan 1970 00:00:00 GMT"},
            {"name": "Category Two", "type": "directory", "mtime": "Fri, 2 Jan 1970 12:00:00 GMT"},
            {"name": "file.txt", "type": "file", "mtime": "Thu, 1 Jan 1970 00:00:00 GMT", "size": 20}
        ]';

        $parsed = (new Categories(new Url()))->parse($json);

        $expected = '[
          {
            "title": "Category One",
            "link": "Category+One",
            "slug": "category-one",
            "modified": "1970-01-01T00:00:00+00:00"
          },
          {
            "title": "Category Two",
            "link": "Category+Two",
            "slug": "category-two",
            "modified": "1970-01-02T12:00:00+00:00"
          }
        ]';

        $this->assertJsonStringEqualsJsonString($expected, $parsed);
    }
}
