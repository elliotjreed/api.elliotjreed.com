<?php
declare(strict_types=1);

namespace ElliotJReed\Formatters;

class Url implements Formatter
{
    public function format(string $string): string
    {
        $transliteration = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        $nonAlphaNumericReplacesWithDash = preg_replace('~[^\pL\d]+~u', '-', $transliteration);
        $cleaned = preg_replace('~[^-\w]+~', '', $nonAlphaNumericReplacesWithDash);
        $trimmed = trim($cleaned, '-');
        $duplicateDashesRemoved = preg_replace('~-+~', '-', $trimmed);

        return strtolower($duplicateDashesRemoved);
    }
}
