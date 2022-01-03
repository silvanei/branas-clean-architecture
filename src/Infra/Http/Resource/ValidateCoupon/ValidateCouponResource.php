<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Infra\Http\Resource\ValidateCoupon;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Silvanei\BranasCleanArchitecture\Application\UseCase\ValidateCoupon\ValidateCoupon;
use Silvanei\BranasCleanArchitecture\Infra\Http\Resource\AbstractResource;
use Silvanei\BranasCleanArchitecture\Infra\Http\Resource\ProblemDetailsException;
use Throwable;

final class ValidateCouponResource extends AbstractResource
{
    public function __construct(private ValidateCoupon $validateCoupon)
    {
    }

    public function post(ServerRequestInterface $request): ResponseInterface
    {
        $code = $request->getAttributes()['code'] ?? '';
        try {
            $isValid = $this->validateCoupon->execute($code);
            return new JsonResponse([
                'code' => $code,
                'isValid' => $isValid,
            ]);
        } catch (Throwable $exception) {
            throw ProblemDetailsException::badRequest($exception->getMessage());
        }
    }
}
