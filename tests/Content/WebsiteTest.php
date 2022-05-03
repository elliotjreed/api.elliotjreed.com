<?php

declare(strict_types=1);

namespace App\Tests\Content;

use App\Content\Website;
use PHPUnit\Framework\TestCase;

final class WebsiteTest extends TestCase
{
    public function testItRendersSchema(): void
    {
        $this->assertSame([
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'about' => 'Elliot Reed is a Technical Lead based in Nottingham, United Kingdom with over 10 years experience in software development and e-commerce management',
            'url' => 'https://www.elliotjreed.com',
            'sameAs' => [
                'https://amp.elliotjreed.com'
            ],
            'keywords' => [
                'Elliot Reed',
                'Elliot J. Reed',
                'PHP',
                'Javascript',
                'Symfony',
                'React',
                'Linux'
            ],
            'name' => 'Elliot J. Reed',
            'alternateName' => 'Elliot Reed',
            'headline' => 'Elliot J. Reed\'s Website',
            'alternativeHeadline' => 'Elliot Reed\'s Website',
            'dateCreated' => '2010-05-15T00:00:00+01:00',
            'author' => [
                '@type' => 'Person',
                'name' => 'Elliot J. Reed',
                'givenName' => 'Elliot',
                'additionalName' => 'John',
                'familyName' => 'Reed',
                'alternateName' => 'Elliot Reed',
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Nottingham',
                    'addressRegion' => 'Nottinghamshire',
                    'addressCountry' => [
                        '@type' => 'Country',
                        'name' => 'United Kingdom'
                    ],
                ],
                'alumniOf' => [
                    [
                        '@type' => 'CollegeOrUniversity',
                        'name' => 'University of Nottingham',
                        'url' => 'https://www.nottingham.ac.uk'
                    ],
                    [
                        '@type' => 'CollegeOrUniversity',
                        'name' => 'Nottingham Trent University',
                        'url' => 'https://www.ntu.ac.uk'
                    ],
                    [
                        '@type' => 'EducationalOrganization',
                        'name' => 'Stowupland High School',
                        'url' => 'https://www.stowuplandhighschool.co.uk'
                    ],
                ],
                'birthDate' => '1990-02-25T12:21:00+00:00',
                'birthPlace' => [
                    '@type' => 'Place',
                    'address' => [
                        '@type' => 'PostalAddress',
                        'addressLocality' => 'Bury St. Edmunds',
                        'addressRegion' => 'Suffolk',
                        'addressCountry' => [
                            '@type' => 'Country',
                            'name' => 'United Kingdom'
                        ],
                    ],
                ],
                'description' => 'Technical Lead in software development based in Nottingham, United Kingdom.',
                'gender' => 'https://schema.org/Male',
                'honorificSuffix' => 'BA (Hons.)',
                'jobTitle' => 'Technical Lead',
                'knowsLanguage' => 'en-GB',
                'image' => [
                    '@type' => 'ImageObject',
                    'url' => 'https://res.cloudinary.com/elliotjreed/image/upload/f_auto,q_auto/v1553434444/elliotjreed.jpg'
                ],
                'nationality' => [
                    '@type' => 'Country',
                    'name' => 'United Kingdom'
                ],
                'sameAs' => [
                    'https://www.elliotjreed.com',
                    'https://twitter.com/elliotjreed',
                    'https://www.linkedin.com/in/elliotjreed',
                    'https://github.com/elliotjreed'
                ],
                'url' => 'https://www.elliotjreed.com',
                'height' => [
                    '@type' => 'QuantitativeValue',
                    'unitCode' => 'cm',
                    'value' => 183
                ],
            ],
            'description' => 'The personal website of Elliot Reed, containing current and past projects, and guides on PHP, Symfony, Javascript, React, Python, and Linux / DevOps.',
            'inLanguage' => [
                'en-GB',
                'en-US'
            ],
        ], Website::schema()->toArray());
    }
}
