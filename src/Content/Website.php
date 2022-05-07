<?php

declare(strict_types=1);

namespace App\Content;

use DateTime;
use Spatie\SchemaOrg\Schema;
use Spatie\SchemaOrg\WebSite as WebSiteSchema;

final class Website
{
    public static function schema(): WebSiteSchema
    {
        return Schema::webSite()
            ->about('Elliot Reed is a Technical Lead based in Nottingham, United Kingdom with over 10 years experience in software development and e-commerce management')
            ->url('https://www.elliotjreed.com')
            ->sameAs(['https://amp.elliotjreed.com'])
            ->keywords(['Elliot Reed', 'Elliot J. Reed', 'PHP', 'Javascript', 'Symfony', 'React', 'Linux'])
            ->name('Elliot J. Reed')
            ->alternateName('Elliot Reed')
            ->headline("Elliot J. Reed's Website")
            ->alternativeHeadline("Elliot Reed's Website")
            ->dateCreated(new DateTime('2010-05-15T00:00:00+01:00'))
            ->author(ElliotReed::schema())
            ->description('The personal website of Elliot Reed, containing current and past projects, and guides on PHP, Symfony, Javascript, React, Python, and Linux / DevOps.')
            ->inLanguage(['en-GB', 'en-US']);
    }
}
