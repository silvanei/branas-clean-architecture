<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Infra\Http\Action;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Silvanei\BranasCleanArchitecture\Application\UseCase\ValidateCoupon\ValidateCoupon;

class ValidateCouponAction implements RequestHandlerInterface
{
    public function __construct(private ValidateCoupon $validateCoupon)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $code = $request->getAttributes()['code'] ?? '';
        $isValid = $this->validateCoupon->execute($code);
        return new JsonResponse([
            'code' => $code,
            'isValid' => $isValid,
        ]);
    }
}
