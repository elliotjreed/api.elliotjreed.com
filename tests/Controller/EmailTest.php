<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Mailer\MailerInterface;

final class EmailTest extends WebTestCase
{
    private KernelBrowser $client;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = self::createClient();
    }

    public function testItReturnsErrorWhenRequestIsInvalid(): void
    {
        $this->client->request('POST', '/email/send');

        $this->assertResponseStatusCodeSame(400);
        $this->assertJsonStringEqualsJsonString('
          {
            "errors": [
              "Please fill in all required fields"
            ],
            "uri": "http://localhost/email/send",
            "request": ""
          }
        ', $this->client->getResponse()->getContent());
        $this->assertFalse($this->client->getContainer()->get(MailerInterface::class)->called);
    }

    public function testItReturnsEmptyJsonResponseWhenSuccessful(): void
    {
        $this->client->request('POST', '/email/send', [
            'name' => 'Mr Name',
            'email' => 'email@example.com',
            'message' => 'A Message',
            'captcha' => 'captcha-token'
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonStringEqualsJsonString('{}', $this->client->getResponse()->getContent());
        $this->assertTrue($this->client->getContainer()->get(MailerInterface::class)->called);
    }
}
