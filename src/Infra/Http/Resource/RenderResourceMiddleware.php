<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Infra\Http\Resource;

use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * @codeCoverageIgnore
 */
final class RenderResourceMiddleware implements MiddlewareInterface
{
    public function __construct(private ResourceGenerator $resourceGenerator, private HalResponseFactory $responseFactory)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $result = $handler->handle($request);

        if ($result instanceof ResourceResponse) {
            $data = $result->object;

            if (is_object($data)) {
                $resource = $this->resourceGenerator->fromObject($data, $request);
                $response = $this->responseFactory->createResponse(
                    $request,
                    $resource
                );
                $response = $response->withStatus($result->getStatusCode());
                $response->getBody()->rewind();
                return $response;
            }

            if (is_array($data)) {
                $resource = $this->resourceGenerator->fromArray($data);
                $response = $this->responseFactory->createResponse(
                    $request,
                    $resource
                );
                $response = $response->withStatus($result->getStatusCode());
                $response->getBody()->rewind();
                return $response;
            }
        }

        return $result;
    }
}
