<?php

declare(strict_types=1);

namespace App\Tests\Validator;

use App\Validator\Captcha;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

final class CaptchaTest extends TestCase
{
    public function testItReturnsFalseWithInvalidCaptchaErrorMessageWhenCaptchaTokenIsNotString(): void
    {
        $validator = new Captcha(new MockHttpClient());

        $this->assertFalse($validator->valid(123));
        $this->assertSame(['The captcha appears to be invalid.'], $validator->getErrors());
    }

    public function testItReturnsFalseWithInvalidCaptchaErrorMessageWhenCaptchaTokenIsOnlyWhitespaceString(): void
    {
        $validator = new Captcha(new MockHttpClient());

        $this->assertFalse($validator->valid('    '));
        $this->assertSame(['The captcha appears to be invalid.'], $validator->getErrors());
    }

    public function testItReturnsFalseWithInvalidCaptchaErrorMessageWhenCaptchaIsInvalid(): void
    {
        $mockResponseBody = '{
          "success": false
        }';
        $validator = new Captcha(new MockHttpClient(new MockResponse($mockResponseBody)));

        $this->assertFalse($validator->valid('test-captcha-token'));
        $this->assertSame(['The captcha appears to be invalid.'], $validator->getErrors());
    }

    public function testItReturnsFalseWithInvalidCaptchaErrorMessageWhenCaptchaThrowsNonTwoHundredResponse(): void
    {
        $validator = new Captcha(new MockHttpClient(new MockResponse('', ['http_code' => 500])));

        $this->assertFalse($validator->valid('test-captcha-token'));
        $this->assertSame([
            'There was a problem verifying the captcha response. Please try reloading the page and try again.'
        ], $validator->getErrors());
    }

    public function testItReturnsTrueWhenCaptchaIsValid(): void
    {
        $mockResponseBody = '{
          "success": true
        }';
        $validator = new Captcha(new MockHttpClient(new MockResponse($mockResponseBody)));

        $this->assertTrue($validator->valid('test-captcha-token'));
        $this->assertSame([], $validator->getErrors());
    }
}
