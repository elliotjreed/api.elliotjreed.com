<?php
declare(strict_types=1);

namespace Tests\ElliotJReed\Parsers;

use ElliotJReed\Formatters\Url;
use ElliotJReed\Parsers\Files;
use PHPUnit\Framework\TestCase;

class FilesTest extends TestCase
{
    public function testItParsesDirectoryListingToFileList(): void
    {
        $json = '[
            {"name": "Category", "type": "directory", "mtime": "Thu, 1 Jan 1970 00:00:00 GMT"},
            {"name": "1970-01-01 12:00:00 My First Test File.txt", "type": "file", "mtime": "Thu, 1 Jan 1970 13:00:00 GMT", "size": 20},
            {"name": "1970-01-02 13:30:00 My Second Test File.txt", "type": "file", "mtime": "Fri, 2 Jan 1970 13:45:00 GMT", "size": 25},
            {"name": "1970-01-03 14:45:00 My Third Test File.txt", "type": "file", "mtime": "Sat, 3 Jan 1970 14:45:00 GMT", "size": 30}
        ]';

        $parsed = (new Files(new Url()))->parse($json);

        $expected = '[
          {
            "title": "My First Test File",
            "link": "1970-01-01+12%3A00%3A00+My+First+Test+File.txt",
            "slug": "my-first-test-file",
            "created": "1970-01-01T12:00:00+00:00",
            "modified": "1970-01-01T13:00:00+00:00"
          },
          {
            "title": "My Second Test File",
            "link": "1970-01-02+13%3A30%3A00+My+Second+Test+File.txt",
            "slug": "my-second-test-file",
            "created": "1970-01-02T13:30:00+00:00",
            "modified": "1970-01-02T13:45:00+00:00"
          },
          {
            "title": "My Third Test File",
            "link": "1970-01-03+14%3A45%3A00+My+Third+Test+File.txt",
            "slug": "my-third-test-file",
            "created": "1970-01-03T14:45:00+00:00",
            "modified": "1970-01-03T14:45:00+00:00"
          }
        ]';

        $this->assertJsonStringEqualsJsonString($expected, $parsed);
    }
}
