<?php
declare(strict_types=1);

namespace App\Formatters;

interface Formatter
{
    public function format(string $string): string;
}
