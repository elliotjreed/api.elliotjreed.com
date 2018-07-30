<?php
declare(strict_types=1);

namespace ElliotJReed\Parsers;

use ElliotJReed\Formatters\Url;

interface Parser
{
    public function __construct(Url $urlFormatter);
    public function parse(string $string): string;
}
