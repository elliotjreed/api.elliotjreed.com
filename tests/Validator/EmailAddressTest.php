<?php

declare(strict_types=1);

namespace App\Tests\Validator;

use App\Validator\EmailAddress;
use ElliotJReed\DisposableEmail\Email;
use PHPUnit\Framework\TestCase;
use SplFileObject;

final class EmailAddressTest extends TestCase
{
    protected function tearDown(): void
    {
        \unlink(\sys_get_temp_dir() . '/phpunit-emailaddresstest-disposable-list.txt');
    }

    public function testItReturnsFalseWithInvalidEmailAddressErrorMessageWhenEmailAddressIsInvalid(): void
    {
        $filePath = \sys_get_temp_dir() . '/phpunit-emailaddresstest-disposable-list.txt';
        $file = new SplFileObject($filePath, 'wb+');

        $validator = new EmailAddress(new Email($file->getRealPath()));

        $this->assertFalse($validator->valid('Clearly this is not an email address'));
        $this->assertSame(['The email address appears to be invalid.'], $validator->getErrors());
    }

    public function testItReturnsFalseWithInvalidEmailAddressMessageWhenEmailAddressIsDisposableEmailAddress(): void
    {
        $filePath = \sys_get_temp_dir() . '/phpunit-emailaddresstest-disposable-list.txt';
        $file = new SplFileObject($filePath, 'wb+');
        $file->fwrite('example.com');

        $validator = new EmailAddress(new Email($file->getRealPath()));

        $this->assertFalse($validator->valid('email@example.com'));
        $this->assertSame(['The email address appears to be invalid.'], $validator->getErrors());
    }

    public function testItReturnsTrueWhenEmailAddressAppearsToBeValid(): void
    {
        $filePath = \sys_get_temp_dir() . '/phpunit-emailaddresstest-disposable-list.txt';
        $file = new SplFileObject($filePath, 'wb+');
        $file->fwrite('test.com');

        $validator = new EmailAddress(new Email($file->getRealPath()));

        $this->assertTrue($validator->valid('email@example.com'));
        $this->assertSame([], $validator->getErrors());
    }
}
