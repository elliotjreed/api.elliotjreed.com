<?php

declare(strict_types=1);

namespace App\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

final class ApiJsonResponse extends JsonResponse
{
    public function __construct(ApiResponseData $data, int $status = 200, array $headers = [], bool $json = false)
    {
        parent::__construct($data->toArray(), $status, $headers, $json);
    }
}
