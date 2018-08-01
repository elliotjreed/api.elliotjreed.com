<?php
declare(strict_types=1);

namespace ElliotJReed\Tests\Formatters;

use ElliotJReed\Formatters\Url;
use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
    private $formatter;

    public function setUp(): void
    {
        $this->formatter = new Url();
    }

    public function testItGeneratesUrlSlugFromBasicStringInLowercaseWithSpacesReplacedByDashes(): void
    {
        $formatted = $this->formatter->format('An example basic string to be turned into a URL slug');

        $this->assertEquals('an-example-basic-string-to-be-turned-into-a-url-slug', $formatted);
    }

    public function testItGeneratesSlugWithNoDuplicatedDashes(): void
    {
        $formatted = $this->formatter->format('An example basic - string -to be turned --into a URL slug');

        $this->assertEquals('an-example-basic-string-to-be-turned-into-a-url-slug', $formatted);
    }

    public function testItGeneratesSlugWithNoAccentedCharacters(): void
    {
        $formatted = $this->formatter->format('Ån èxâmplë båsïc śtríng tô bê túrńèd întò ã ŰRL şlűg');

        $this->assertEquals('an-example-basic-string-to-be-turned-into-a-url-slug', $formatted);
    }

    public function testItGeneratesUrlSlugNotEndingWithDash(): void
    {
        $formatted = $this->formatter->format('An example basic string to be turned into a URL slug-   -  --');

        $this->assertEquals('an-example-basic-string-to-be-turned-into-a-url-slug', $formatted);
    }
}
