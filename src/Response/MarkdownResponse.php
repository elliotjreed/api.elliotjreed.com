<?php

declare(strict_types=1);

namespace App\Response;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

final class MarkdownResponse extends Response
{
    public function __construct(string $content = '', int $status = 200, array $headers = [])
    {
        parent::__construct($content, $status, $headers);

        $this->headers = new ResponseHeaderBag($headers);
        $this->headers->set('Content-Type', 'text/markdown');
        $this->setContent($content);
        $this->setStatusCode($status);
        $this->setProtocolVersion('1.1');
    }
}
