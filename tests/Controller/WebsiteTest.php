<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class WebsiteTest extends WebTestCase
{
    public function testItReturnsWebsiteJson(): void
    {
        $client = self::createClient();

        $client->request('GET', '/api/v1/website');

        $this->assertResponseIsSuccessful();
        $this->assertJsonStringEqualsJsonString('{
          "data": {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "about": "Elliot Reed is a Technical Lead based in Nottingham, United Kingdom with over 10 years experience in software development and e-commerce management",
            "alternateName": "Elliot Reed",
            "alternativeHeadline": "Elliot Reed\'s Website",
            "author": {
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
            "dateCreated": "2010-05-15T00:00:00+01:00",
            "description": "The personal website of Elliot Reed, containing current and past projects, and guides on PHP, Symfony, Javascript, React, Python, and Linux / DevOps.",
            "headline": "Elliot J. Reed\'s Website",
            "inLanguage": [
              "en-GB",
              "en-US"
            ],
            "keywords": [
              "Elliot Reed",
              "Elliot J. Reed",
              "PHP",
              "Javascript",
              "Symfony",
              "React",
              "Linux"
            ],
            "name": "Elliot J. Reed",
            "sameAs": [
              "https://amp.elliotjreed.com"
            ],
            "url": "https://www.elliotjreed.com"
          },
          "errors": []
        }', $client->getResponse()->getContent());
    }

    public function testItReturnsPersonJsonSchema(): void
    {
        $client = self::createClient();

        $client->request('GET', '/schema/website');

        $this->assertResponseIsSuccessful();
        $this->assertJsonStringEqualsJsonString('{
          "@context": "https://schema.org",
          "@type": "WebSite",
          "about": "Elliot Reed is a Technical Lead based in Nottingham, United Kingdom with over 10 years experience in software development and e-commerce management",
          "alternateName": "Elliot Reed",
          "alternativeHeadline": "Elliot Reed\'s Website",
          "author": {
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
          "dateCreated": "2010-05-15T00:00:00+01:00",
          "description": "The personal website of Elliot Reed, containing current and past projects, and guides on PHP, Symfony, Javascript, React, Python, and Linux / DevOps.",
          "headline": "Elliot J. Reed\'s Website",
          "inLanguage": [
            "en-GB",
            "en-US"
          ],
          "keywords": [
            "Elliot Reed",
            "Elliot J. Reed",
            "PHP",
            "Javascript",
            "Symfony",
            "React",
            "Linux"
          ],
          "name": "Elliot J. Reed",
          "sameAs": [
            "https://amp.elliotjreed.com"
          ],
          "url": "https://www.elliotjreed.com"
        }', $client->getResponse()->getContent());
    }
}
