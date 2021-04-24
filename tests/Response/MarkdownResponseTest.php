<?php

declare(strict_types=1);

namespace App\Tests\Response;

use App\Response\MarkdownResponse;
use PHPUnit\Framework\TestCase;

final class MarkdownResponseTest extends TestCase
{
    public function testItSetsMarkdownFileHeadersInResponse(): void
    {
        $markdownResponse = new MarkdownResponse('# Markdown Content');

        $this->assertSame('text/markdown', $markdownResponse->headers->get('Content-Type'));
        $this->assertSame('1.1', $markdownResponse->getProtocolVersion());
        $this->assertSame('# Markdown Content', $markdownResponse->getContent());
    }
}
