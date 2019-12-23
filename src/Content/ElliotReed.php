<?php

declare(strict_types=1);

namespace App\Content;

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
            ->email('contact@elliotjreed.com')
            ->address(Schema::postalAddress()
                ->addressLocality('Nottingham')
                ->addressRegion('Nottinghamshire')
                ->addressCountry(Schema::country()->name('United Kingdom')))
            ->alumniOf([
                Schema::educationalOrganization()
                    ->name('University of Nottingham')
                    ->url('https://www.nottingham.ac.uk'),
                Schema::educationalOrganization()
                    ->name('Nottingham Trent University')
                    ->url('https://www.ntu.ac.uk')
            ])
            ->birthDate(new \DateTime('1990-02-25 12:21:00'))
            ->birthPlace(Schema::place()
                ->address(Schema::postalAddress()
                    ->name('Bury St. Edmunds Hospital')
                    ->streetAddress('Bury St. Edmunds Hospital')
                    ->addressLocality('Bury St. Edmunds')
                    ->addressRegion('Suffolk')
                    ->addressCountry(Schema::country()->name('United Kingdom'))))
            ->description('Software developer based in Nottingham, United Kingdom.')
            ->gender(Schema::genderType()->name('male'))
            ->honorificSuffix('BA (Hons.)')
            ->hasOccupation(Schema::occupation()->name('Software Developer'))
            ->image(Schema::imageObject()->url('https://res.cloudinary.com/elliotjreed/image/upload/f_auto,q_auto/v1553434444/elliotjreed.jpg'))
            ->jobTitle('Software Developer')
            ->nationality(Schema::country()->name('United Kingdom'))
            ->sameAs(['https://twitter.com/elliotjreed', 'https://www.linkedin.com/in/elliotjreed', 'https://github.com/elliotjreed'])
            ->telephone('+447708309156')
            ->url('https://www.elliotjreed.com')
            ->height(Schema::quantitativeValue()->unitCode('cm')->value(183));
    }
}
