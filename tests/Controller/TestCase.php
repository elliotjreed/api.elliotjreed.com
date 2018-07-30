<?php
declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Client;

abstract class TestCase extends WebTestCase
{
    /** @var Client */
    protected $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }
}
