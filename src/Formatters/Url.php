<?php
declare(strict_types=1);

namespace App\Formatters;

class Url implements Formatter
{
    public function format(string $string): string
    {
        $nonAlphaNumericReplacesWithDash = preg_replace('~[^\pL\d]+~u', '-', $string);
        $transliteration = iconv('UTF-8', 'ASCII//TRANSLIT', $nonAlphaNumericReplacesWithDash);
        $cleaned = preg_replace('~[^-\w]+~', '', $transliteration);
        $trimmed = trim($cleaned, '-');
        $duplicateDashesRemoved = preg_replace('~-+~', '-', $trimmed);

        return strtolower($duplicateDashesRemoved);
    }
}
