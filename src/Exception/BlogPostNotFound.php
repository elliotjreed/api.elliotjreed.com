<?php

declare(strict_types=1);

namespace App\Exception;

final class BlogPostNotFound extends \Exception
{
    protected $message = 'Blog post could not be found in GitHub repository.';
}
