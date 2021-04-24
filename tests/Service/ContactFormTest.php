<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Exception\Validation;
use App\Service\ContactForm;
use App\Tests\Double\Mailer\EmailSpy;
use App\Validator\Captcha;
use App\Validator\EmailAddress;
use App\Validator\NonEmptyField;
use ElliotJReed\DisposableEmail\Email;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

final class ContactFormTest extends TestCase
{
    private NonEmptyField $nonEmptyFieldValidator;
    private EmailAddress $emailAddressValidator;
    private Captcha $captchaValidator;
    private Environment $twigEnvironment;

    public function setUp(): void
    {
        parent::setUp();

        $this->nonEmptyFieldValidator = new NonEmptyField();
        $this->emailAddressValidator = new EmailAddress(new Email());
        $this->captchaValidator = new Captcha(new MockHttpClient(new MockResponse('{"success": true}')));
        $this->twigEnvironment = new Environment(new FilesystemLoader([__DIR__ . '/../../templates']));
    }

    public function testItThrowsExceptionWhenNameFieldIsInvalid(): void
    {
        $mailer = new EmailSpy();

        $contactForm = (new ContactForm($this->nonEmptyFieldValidator, $this->emailAddressValidator, $this->captchaValidator, $this->twigEnvironment, $mailer));

        $this->expectException(Validation::class);

        try {
            $contactForm->sendEmail(null, 'email@example.com', 'A Message', 'captcha-token');
        } catch (Validation $exception) {
            $this->assertFalse($mailer->called);
            $this->assertSame(['Please fill in all required fields'], $exception->getErrors());

            throw $exception;
        }
    }

    public function testItThrowsExceptionWhenMessageFieldIsInvalid(): void
    {
        $mailer = new EmailSpy();

        $contactForm = (new ContactForm($this->nonEmptyFieldValidator, $this->emailAddressValidator, $this->captchaValidator, $this->twigEnvironment, $mailer));

        $this->expectException(Validation::class);

        try {
            $contactForm->sendEmail('Mr Name', 'email@example.com', null, 'captcha-token');
        } catch (Validation $exception) {
            $this->assertFalse($mailer->called);
            $this->assertSame(['Please fill in all required fields'], $exception->getErrors());

            throw $exception;
        }
    }

    public function testItThrowsExceptionWhenEmailAddressIsInvalid(): void
    {
        $mailer = new EmailSpy();

        $contactForm = (new ContactForm($this->nonEmptyFieldValidator, $this->emailAddressValidator, $this->captchaValidator, $this->twigEnvironment, $mailer));

        $this->expectException(Validation::class);

        try {
            $contactForm->sendEmail('Mr Name', 'invalid email address', 'A Message', 'captcha-token');
        } catch (Validation $exception) {
            $this->assertFalse($mailer->called);
            $this->assertSame(['The email address appears to be invalid.'], $exception->getErrors());

            throw $exception;
        }
    }

    public function testItThrowsExceptionWhenCaptchaTokenIsInvalid(): void
    {
        $failedCaptchaResponse = '
          {
            "success": false
          }
        ';
        $captchaValidator = new Captcha(new MockHttpClient(new MockResponse($failedCaptchaResponse)));
        $mailer = new EmailSpy();

        $contactForm = (new ContactForm($this->nonEmptyFieldValidator, $this->emailAddressValidator, $captchaValidator, $this->twigEnvironment, $mailer));

        $this->expectException(Validation::class);

        try {
            $contactForm->sendEmail('Mr Name', 'email@example.com', 'A Message', 'captcha-token');
        } catch (Validation $exception) {
            $this->assertFalse($mailer->called);
            $this->assertSame(['The captcha appears to be invalid.'], $exception->getErrors());

            throw $exception;
        }
    }

    public function testItCallsMailerWhenValidationPasses(): void
    {
        $mailer = new EmailSpy();

        (new ContactForm($this->nonEmptyFieldValidator, $this->emailAddressValidator, $this->captchaValidator, $this->twigEnvironment, $mailer))
            ->sendEmail('Mr Name', 'email@example.com', 'A Message', 'captcha-token');

        $this->assertTrue($mailer->called);
    }
}
