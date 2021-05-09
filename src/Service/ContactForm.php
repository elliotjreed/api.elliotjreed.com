<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\Validation;
use App\Validator\Captcha;
use App\Validator\EmailAddress;
use App\Validator\NonEmptyField;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class ContactForm
{
    public function __construct(private NonEmptyField $nonEmptyFieldValidator, private EmailAddress $emailAddressValidator, private Captcha $captchaValidator, private Environment $twig, private MailerInterface $mailer)
    {
    }

    public function sendEmail(?string $name, ?string $emailAddress, ?string $message, ?string $captchaToken): void
    {
        if (!$this->nonEmptyFieldValidator->valid($name) || !$this->nonEmptyFieldValidator->valid($message)) {
            throw (new Validation())->setErrors($this->nonEmptyFieldValidator->getErrors());
        }

        if (!$this->emailAddressValidator->valid($emailAddress)) {
            throw (new Validation())->setErrors($this->emailAddressValidator->getErrors());
        }

        if (!$this->captchaValidator->valid($captchaToken)) {
            throw (new Validation())->setErrors($this->captchaValidator->getErrors());
        }

        $emailBody = $this->twig->render('contact.html.twig', [
            'name' => \htmlspecialchars(\strip_tags($name)),
            'email' => \htmlspecialchars(\strip_tags($emailAddress)),
            'message' => \htmlspecialchars(\strip_tags($message))
        ]);

        $this->mailer->send((new Email())
            ->from('hello@elliotjreed.com')
            ->to('website-contact-form@elliotjreed.com')
            ->subject('Email from www.elliotjreed.com')
            ->html($emailBody));
    }
}
