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
        $this->assertJsonStringEqualsJsonString('
          {
            "@context": "https://schema.org",
            "@type": "Person",
            "name": "Elliot J. Reed",
            "givenName": "Elliot",
            "additionalName": "John",
            "familyName": "Reed",
            "alternateName": "Elliot Reed",
            "address": {
              "@type": "PostalAddress",
              "addressLocality": "Nottingham",
              "addressRegion": "Nottinghamshire",
              "addressCountry": {
                "@type": "Country",
                "name": "United Kingdom"
              }
            },
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
                "addressLocality": "Bury St. Edmunds",
                "addressRegion": "Suffolk",
                "addressCountry": {
                  "@type": "Country",
                  "name": "United Kingdom"
                }
              }
            },
            "description": "Technical Lead in software development based in Nottingham, United Kingdom.",
            "gender": {
              "@type": "GenderType",
              "name": "male"
            },
            "honorificSuffix": "BA (Hons.)",
            "jobTitle": "Technical Lead",
            "image": {
              "@type": "ImageObject",
              "url": "https://res.cloudinary.com/elliotjreed/image/upload/f_auto,q_auto/v1553434444/elliotjreed.jpg"
            },
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
            "telephone": "+447708309156",
            "url": "https://www.elliotjreed.com",
            "height": {
              "@type": "QuantitativeValue",
              "unitCode": "cm",
              "value": 183
            }
          }
        ', $client->getResponse()->getContent());
    }
}
