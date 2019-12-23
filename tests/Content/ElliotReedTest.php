<?php

declare(strict_types=1);

namespace App\Tests\Content;

use App\Content\ElliotReed;
use PHPUnit\Framework\TestCase;

final class ElliotReedTest extends TestCase
{
    public function testItRendersSchema(): void
    {
        $schema = ElliotReed::schema();

        $this->assertSame([], $schema->toArray());
    }
}
