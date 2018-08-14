<?php
declare(strict_types=1);

namespace ElliotJReed\Exceptions;

use Exception;
use Throwable;

class NotFoundException extends Exception implements Throwable
{
    protected $message = 'Content not found';
}
