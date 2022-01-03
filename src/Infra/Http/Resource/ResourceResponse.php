<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Infra\Http\Resource;

use Laminas\Diactoros\Response;

/**
 * @codeCoverageIgnore
 */
final class ResourceResponse extends Response
{
    /**
     * @param object|object[] $object
     * @param int $status
     * @param array<string, string> $headers
     */
    public function __construct(public readonly array|object $object, int $status = 200, array $headers = [])
    {
        parent::__construct('php://memory', $status, $headers);
    }
}
