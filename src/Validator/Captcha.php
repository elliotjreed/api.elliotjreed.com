<?php

declare(strict_types=1);

namespace App\Validator;

use JsonException;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Captcha extends Validator
{
    public function __construct(private HttpClientInterface $httpClient)
    {
    }

    public function valid(mixed $captchaToken): bool
    {
        if (!\is_string($captchaToken) || \trim($captchaToken) === '') {
            $this->errors[] = 'The captcha appears to be invalid.';

            return false;
        }

        try {
            $response = $this->httpClient->request('POST', 'https://hcaptcha.com/siteverify', [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ],
                'body' => [
                    'response' => $captchaToken,
                    'secret' => $_ENV['HCAPTCHA_SECRET_KEY'],
                    'sitekey' => $_ENV['HCAPTCHA_SITE_KEY']
                ]
            ]);

            $decodedResponse = \json_decode($response->getContent(), true, 2, JSON_THROW_ON_ERROR);

            if ($decodedResponse['success'] !== true) {
                $this->errors[] = 'The captcha appears to be invalid.';

                return false;
            }
        } catch (JsonException | ExceptionInterface $e) {
            $this->errors[] = 'There was a problem verifying the captcha response. Please try reloading the page and try again.';

            return false;
        }

        return true;
    }
}
