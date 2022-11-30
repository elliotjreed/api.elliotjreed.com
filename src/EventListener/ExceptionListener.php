<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Exception\Validation;
use App\Response\ApiJsonResponse;
use App\Response\ApiResponseData;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

final class ExceptionListener
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $request = $event->getRequest();

        $response = $this->createApiResponse($exception, $request);
        $event->setResponse($response);
    }

    private function createApiResponse(\Throwable $exception, Request $request): ApiJsonResponse
    {
        $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        $errors = ['An unexpected error occurred.'];
        $logLevel = LogLevel::WARNING;

        if ($exception instanceof HttpExceptionInterface) {
            $statusCode = $exception->getStatusCode();
            $errors = [$exception->getMessage()];

            if ($statusCode >= Response::HTTP_INTERNAL_SERVER_ERROR) {
                $logLevel = LogLevel::ERROR;
            }
        } elseif ($exception instanceof Validation) {
            $statusCode = Response::HTTP_BAD_REQUEST;
            $errors = $exception->getErrors();
        } elseif ($exception instanceof \JsonException) {
            $statusCode = Response::HTTP_NOT_ACCEPTABLE;
            $errors = ['Malformed JSON in request body.'];
        }

        $log = \get_class($exception) . ': ' . $exception->getMessage() .
            '" at ' . $exception->getFile() . ' line ' . $exception->getLine();

        $this->logger->log($logLevel, $log, [
            'trace' => $exception->getTrace(),
            'request' => \substr($request->getContent(), 0, 2048)
        ]);

        return new ApiJsonResponse((new ApiResponseData())->setErrorMessages(...$errors), $statusCode);
    }
}
