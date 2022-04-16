<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\Validation;
use App\Validator\EmailAddress;
use App\Validator\NonEmptyField;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class ContactForm
{
    public function __construct(
        private NonEmptyField $nonEmptyFieldValidator,
        private EmailAddress $emailAddressValidator,
        private Environment $twig,
        private MailerInterface $mailer
    ) {
    }

    public function sendEmail(?string $name, ?string $emailAddress, ?string $message): void
    {
        if (!$this->nonEmptyFieldValidator->valid($name) || !$this->nonEmptyFieldValidator->valid($message)) {
            throw (new Validation())->setErrors($this->nonEmptyFieldValidator->getErrors());
        }

        if (!$this->emailAddressValidator->valid($emailAddress)) {
            throw (new Validation())->setErrors($this->emailAddressValidator->getErrors());
        }

        $emailBody = $this->twig->render('contact.html.twig', [
            'name' => \htmlspecialchars(\strip_tags($name), \ENT_NOQUOTES),
            'email' => \htmlspecialchars(\strip_tags($emailAddress), \ENT_NOQUOTES),
            'message' => \htmlspecialchars(\strip_tags($message), \ENT_NOQUOTES)
        ]);

        $this->mailer->send((new Email())
            ->from($_ENV['CONTACT_FORM_EMAIL_ADDRESS'])
            ->to($_ENV['CONTACT_FORM_EMAIL_ADDRESS'])
            ->subject('Email from www.elliotjreed.com')
            ->html($emailBody));
    }
}
