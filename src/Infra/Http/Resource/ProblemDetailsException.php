<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Infra\Http\Resource;

use DomainException;
use Mezzio\ProblemDetails\Exception\CommonProblemDetailsExceptionTrait;
use Mezzio\ProblemDetails\Exception\ProblemDetailsExceptionInterface;

/**
 * @codeCoverageIgnore
 */
class ProblemDetailsException extends DomainException implements ProblemDetailsExceptionInterface
{
    use CommonProblemDetailsExceptionTrait;

    /**
     * @param string $message
     * @param array<string, string> $details
     * @return ProblemDetailsException
     */
    public static function notFound(string $message, array $details = []): self
    {
        $exception = new self();
        $exception->status = 404;
        $exception->title = 'Not Found';
        $exception->type = 'https://httpstatus.es/404';
        $exception->detail = $message;
        $exception->additional = $details;
        return $exception;
    }

    /**
     * @param string $message
     * @param array<string, string> $details
     * @return ProblemDetailsException
     */
    public static function badRequest(string $message, array $details = [])
    {
        $exception = new self($message);
        $exception->status = 400;
        $exception->title = 'Bad request';
        $exception->type = 'https://httpstatuses.com/400';
        $exception->detail = $message;
        $exception->additional = $details;
        return $exception;
    }
}
