<?php

declare(strict_types=1);

namespace App\Tests\Validator;

use App\Validator\EmailAddress;
use ElliotJReed\DisposableEmail\Email;
use PHPUnit\Framework\TestCase;

final class EmailAddressTest extends TestCase
{
    protected function tearDown(): void
    {
        \unlink(\sys_get_temp_dir() . '/phpunit-emailaddresstest-disposable-list.txt');
    }

    public function testItReturnsFalseWithInvalidEmailAddressErrorMessageWhenEmailAddressIsInvalid(): void
    {
        $disposableEmailAddressFile = new \SplFileObject(\sys_get_temp_dir() . '/phpunit-emailaddresstest-disposable-list.txt', 'wb+');

        $validator = new EmailAddress(new Email($disposableEmailAddressFile->getRealPath()));

        $this->assertFalse($validator->valid('Clearly this is not an email address'));
        $this->assertSame(['The email address appears to be invalid.'], $validator->getErrors());
    }

    public function testItReturnsFalseWithInvalidEmailAddressErrorMessageWhenEmailAddressIsDisposableEmailAddress(): void
    {
        $disposableEmailAddressFile = new \SplFileObject(\sys_get_temp_dir() . '/phpunit-emailaddresstest-disposable-list.txt', 'wb+');
        $disposableEmailAddressFile->fwrite('example.com');

        $validator = new EmailAddress(new Email($disposableEmailAddressFile->getRealPath()));

        $this->assertFalse($validator->valid('email@example.com'));
        $this->assertSame(['The email address appears to be invalid.'], $validator->getErrors());
    }

    public function testItReturnsTrueWhenEmailAddressAppearsToBeValid(): void
    {
        $disposableEmailAddressFile = new \SplFileObject(\sys_get_temp_dir() . '/phpunit-emailaddresstest-disposable-list.txt', 'wb+');
        $disposableEmailAddressFile->fwrite('test.com');

        $validator = new EmailAddress(new Email($disposableEmailAddressFile->getRealPath()));

        $this->assertTrue($validator->valid('email@example.com'));
        $this->assertSame([], $validator->getErrors());
    }
}
