<?php

namespace App\Tests\Double\Mailer;

use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\RawMessage;

final class EmailSpy implements MailerInterface
{
    public bool $called = false;

    public function send(RawMessage $message, Envelope $envelope = null): void
    {
        $this->called = true;
    }
}
