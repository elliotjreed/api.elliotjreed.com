<?php

declare(strict_types=1);

namespace App\Validator;

use ElliotJReed\DisposableEmail\Email;

class EmailAddress extends Validator
{
    public function __construct(private Email $disposableEmailAddress)
    {
    }

    public function valid(mixed $emailAddress): bool
    {
        if (false === \filter_var($emailAddress, \FILTER_VALIDATE_EMAIL) || $this->disposableEmailAddress->isDisposable($emailAddress)) {
            $this->errors[] = 'The email address appears to be invalid.';

            return false;
        }

        return true;
    }
}
