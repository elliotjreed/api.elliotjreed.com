<?php
declare(strict_types=1);

namespace ElliotJReed\Tests\Mappers;

use ElliotJReed\Exceptions\NotFoundException;
use ElliotJReed\Formatters\Url;
use ElliotJReed\Mappers\Slug;
use ElliotJReed\Parsers\Categories;
use ElliotJReed\Parsers\Files;
use PHPUnit\Framework\TestCase;

class CategoriesTest extends TestCase
{
    public function testItFindsCategoryFromSlug(): void
    {
        $json = '[
            {"name": "Category One", "type": "directory", "mtime": "Thu, 1 Jan 1970 00:00:00 GMT"},
            {"name": "Category Two", "type": "directory", "mtime": "Fri, 2 Jan 1970 12:00:00 GMT"},
            {"name": "file.txt", "type": "file", "mtime": "Thu, 1 Jan 1970 00:00:00 GMT", "size": 20}
        ]';
        $parsed = (new Slug(new Categories(new Url())))->map($json, 'category-one');

        $this->assertEquals('Category+One', $parsed);
    }

    public function testItThrowsExceptionIfUnableToFindFileFromCategorySlug(): void
    {
        $json = '[
            {"name": "Category One", "type": "directory", "mtime": "Thu, 1 Jan 1970 00:00:00 GMT"},
            {"name": "Category Two", "type": "directory", "mtime": "Fri, 2 Jan 1970 12:00:00 GMT"},
            {"name": "file.txt", "type": "file", "mtime": "Thu, 1 Jan 1970 00:00:00 GMT", "size": 20}
        ]';

        $slug = 'category-three';

        $this->expectException(NotFoundException::class);

        (new Slug(new Categories(new Url())))->map($json, $slug);
    }

    public function testItFindsFileFromSlug(): void
    {
        $json = '[
            {"name": "Category", "type": "directory", "mtime": "Thu, 1 Jan 1970 00:00:00 GMT"},
            {"name": "1970-01-01 12:00:00 My First Test File.txt", "type": "file", "mtime": "Thu, 1 Jan 1970 13:00:00 GMT", "size": 20},
            {"name": "1970-01-02 13:30:00 My Second Test File.txt", "type": "file", "mtime": "Fri, 2 Jan 1970 13:45:00 GMT", "size": 25},
            {"name": "1970-01-03 14:45:00 My Third Test File.txt", "type": "file", "mtime": "Sat, 3 Jan 1970 14:45:00 GMT", "size": 30}
        ]';
        $parsed = (new Slug(new Files(new Url())))->map($json, 'my-first-test-file');

        $this->assertEquals('1970-01-01+12%3A00%3A00+My+First+Test+File.txt', $parsed);
    }

    public function testItThrowsExceptionIfUnableToFindFileFromFileSlug(): void
    {
        $json = '[
            {"name": "Category", "type": "directory", "mtime": "Thu, 1 Jan 1970 00:00:00 GMT"},
            {"name": "1970-01-01 12:00:00 My First Test File.txt", "type": "file", "mtime": "Thu, 1 Jan 1970 13:00:00 GMT", "size": 20},
            {"name": "1970-01-02 13:30:00 My Second Test File.txt", "type": "file", "mtime": "Fri, 2 Jan 1970 13:45:00 GMT", "size": 25},
            {"name": "1970-01-03 14:45:00 My Third Test File.txt", "type": "file", "mtime": "Sat, 3 Jan 1970 14:45:00 GMT", "size": 30}
        ]';

        $slug = 'fourth-file';

        $this->expectException(NotFoundException::class);

        (new Slug(new Categories(new Url())))->map($json, $slug);
    }
}
