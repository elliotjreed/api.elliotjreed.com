<?php
declare(strict_types=1);

namespace ElliotJReed\Formatters;

interface Formatter
{
    public function format(string $string): string;
}
