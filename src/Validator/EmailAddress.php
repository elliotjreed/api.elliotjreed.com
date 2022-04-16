<?php

declare(strict_types=1);

namespace App\Validator;

use ElliotJReed\DisposableEmail\Email;

final class EmailAddress extends Validator
{
    public function __construct(private Email $disposableEmailAddress)
    {
    }

    public function valid(mixed $emailAddress): bool
    {
        $isValidEmailAddress = false === \filter_var($emailAddress, \FILTER_VALIDATE_EMAIL);
        if ($isValidEmailAddress || $this->disposableEmailAddress->isDisposable($emailAddress)) {
            $this->errors[] = 'The email address appears to be invalid.';

            return false;
        }

        return true;
    }
}
