<?php

declare(strict_types=1);

namespace App\Tests\Content;

use App\Content\Cv;
use App\Tests\Double\Github\Client;
use App\Tests\Double\Github\Contents;
use App\Tests\Double\Github\Repo;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

final class CvTest extends TestCase
{
    public function testItRendersSchemaForDirectLink(): void
    {
        $contents = new Contents();
        $githubApiClient = new Client(new Repo($contents));

        $cv = new Cv($githubApiClient, new ArrayAdapter());

        $this->assertSame("# A Test Post\nWith some test content", $cv->asMarkdown());
    }
}
