<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Infra\Http\Resource;

use Laminas\Diactoros\Response\EmptyResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * @codeCoverageIgnore
 */
abstract class AbstractResource implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $method = strtolower($request->getMethod());
        if (method_exists($this, $method)) {
            /** @phpstan-ignore-next-line  */
            return call_user_func_array([$this, $method], [$request]);
        }

        return new EmptyResponse(501);
    }

    public function get(ServerRequestInterface $request): ResponseInterface
    {
        return new EmptyResponse(501);
    }

    public function post(ServerRequestInterface $request): ResponseInterface
    {
        return new EmptyResponse(501);
    }

    public function patch(ServerRequestInterface $request): ResponseInterface
    {
        return new EmptyResponse(501);
    }

    public function put(ServerRequestInterface $request): ResponseInterface
    {
        return new EmptyResponse(501);
    }

    public function delete(ServerRequestInterface $request): ResponseInterface
    {
        return new EmptyResponse(501);
    }
}
