<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class PersonTest extends WebTestCase
{
    public function testItReturnsPersonJson(): void
    {
        $client = self::createClient();

        $client->request('GET', '/blog/author');

        $this->assertResponseIsSuccessful();
        $this->assertJsonStringEqualsJsonString('{
          "data": {
            "@context": "https://schema.org",
            "@type": "Person",
            "additionalName": "John",
            "address": {
              "@type": "PostalAddress",
              "addressCountry": {
                "@type": "Country",
                "name": "United Kingdom"
              },
              "addressLocality": "Nottingham",
              "addressRegion": "Nottinghamshire"
            },
            "alternateName": "Elliot Reed",
            "alumniOf": [
              {
                "@type": "CollegeOrUniversity",
                "name": "University of Nottingham",
                "url": "https://www.nottingham.ac.uk"
              },
              {
                "@type": "CollegeOrUniversity",
                "name": "Nottingham Trent University",
                "url": "https://www.ntu.ac.uk"
              },
              {
                "@type": "EducationalOrganization",
                "name": "Stowupland High School",
                "url": "https://www.stowuplandhighschool.co.uk"
              }
            ],
            "birthDate": "1990-02-25T12:21:00+00:00",
            "birthPlace": {
              "@type": "Place",
              "address": {
                "@type": "PostalAddress",
                "addressCountry": {
                  "@type": "Country",
                  "name": "United Kingdom"
                },
                "addressLocality": "Bury St. Edmunds",
                "addressRegion": "Suffolk"
              }
            },
            "description": "Technical Lead in software development based in Nottingham, United Kingdom.",
            "familyName": "Reed",
            "gender": "https://schema.org/Male",
            "givenName": "Elliot",
            "height": {
              "@type": "QuantitativeValue",
              "unitCode": "cm",
              "value": 183
            },
            "honorificSuffix": "BA (Hons.)",
            "image": {
              "@type": "ImageObject",
              "url": "https://res.cloudinary.com/elliotjreed/image/upload/f_auto,q_auto/v1553434444/elliotjreed.jpg"
            },
            "jobTitle": "Technical Lead",
            "knowsLanguage": "en-GB",
            "name": "Elliot J. Reed",
            "nationality": {
              "@type": "Country",
              "name": "United Kingdom"
            },
            "sameAs": [
              "https://www.elliotjreed.com",
              "https://twitter.com/elliotjreed",
              "https://www.linkedin.com/in/elliotjreed",
              "https://github.com/elliotjreed"
            ],
            "url": "https://www.elliotjreed.com"
          },
          "errors": []
        }', $client->getResponse()->getContent());
    }
}
