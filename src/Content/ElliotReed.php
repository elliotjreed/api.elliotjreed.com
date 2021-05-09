<?php

declare(strict_types=1);

namespace App\Content;

use DateTime;
use Spatie\SchemaOrg\Person;
use Spatie\SchemaOrg\Schema;

final class ElliotReed
{
    public static function schema(): Person
    {
        return Schema::person()
            ->name('Elliot J. Reed')
            ->givenName('Elliot')
            ->additionalName('John')
            ->familyName('Reed')
            ->alternateName('Elliot Reed')
            ->address(Schema::postalAddress()
                ->addressLocality('Nottingham')
                ->addressRegion('Nottinghamshire')
                ->addressCountry(Schema::country()->name('United Kingdom')))
            ->alumniOf([
                Schema::collegeOrUniversity()
                    ->name('University of Nottingham')
                    ->url('https://www.nottingham.ac.uk'),
                Schema::collegeOrUniversity()
                    ->name('Nottingham Trent University')
                    ->url('https://www.ntu.ac.uk'),
                Schema::educationalOrganization()
                    ->name('Stowupland High School')
                    ->url('https://www.stowuplandhighschool.co.uk')
            ])
            ->birthDate(new DateTime('1990-02-25 12:21:00'))
            ->birthPlace(Schema::place()
                ->address(Schema::postalAddress()
                    ->addressLocality('Bury St. Edmunds')
                    ->addressRegion('Suffolk')
                    ->addressCountry(Schema::country()->name('United Kingdom'))))
            ->description('Technical Lead in software development based in Nottingham, United Kingdom.')
            ->gender(Schema::genderType()::Male)
            ->honorificSuffix('BA (Hons.)')
            ->jobTitle('Technical Lead')
            ->knowsLanguage('en-GB')
            ->image(Schema::imageObject()->url('https://res.cloudinary.com/elliotjreed/image/upload/f_auto,q_auto/v1553434444/elliotjreed.jpg'))
            ->nationality(Schema::country()->name('United Kingdom'))
            ->sameAs(['https://www.elliotjreed.com', 'https://twitter.com/elliotjreed', 'https://www.linkedin.com/in/elliotjreed', 'https://github.com/elliotjreed'])
            ->url('https://www.elliotjreed.com')
            ->height(Schema::quantitativeValue()->unitCode('cm')->value(183));
    }
}
