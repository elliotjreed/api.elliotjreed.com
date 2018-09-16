<?php
declare(strict_types=1);

use Monolog\Logger;

return [
    'settings' => [
        'displayErrorDetails' => true,
        'addContentLengthHeader' => false,
        'logger' => [
            'name' => 'api',
            'path' => 'php://stdout',
            'level' => Logger::INFO,
        ],
        'api' => [
            'baseUri' => 'http://172.17.0.2/'
        ]
    ]
];
