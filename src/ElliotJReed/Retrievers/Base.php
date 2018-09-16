<?php
declare(strict_types=1);

namespace ElliotJReed\Retrievers;

use DateTime;
use Spatie\SchemaOrg\EducationalOrganization;
use Spatie\SchemaOrg\Language;
use Spatie\SchemaOrg\Person;

class Base
{
    protected function getLanguage(): Language
    {
        return (new Language())->name('English')->alternateName('en-GB');
    }

    protected function getAuthor(): Person
    {
        return (new Person())
            ->name('Elliot J. Reed')
            ->familyName('Reed')
            ->birthDate(new DateTime('1990-02-25'))
            ->alumniOf(
                (new EducationalOrganization())
                    ->name('University of Nottingham')
                    ->sameAs('https://www.nottingham.ac.uk/')
            )
            ->email('website@elliotjreed.com');
    }
}