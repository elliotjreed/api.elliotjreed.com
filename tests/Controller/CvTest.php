<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class CvTest extends WebTestCase
{
    public function testItReturnsCvAsMarkdown(): void
    {
        $client = self::createClient();

        $client->request('GET', '/cv');

        $this->assertResponseIsSuccessful();
        $this->assertSame("# A Test Post\nWith some test content", $client->getResponse()->getContent());
        $this->assertResponseHeaderSame('Content-Type', 'text/markdown; charset=UTF-8');
    }
}
