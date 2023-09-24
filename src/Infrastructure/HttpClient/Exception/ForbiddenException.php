<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Infrastructure\HttpClient\Exception;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class ForbiddenException extends EsiaGatewayException
{
    public static function create(Response $response, Request $request): self
    {
        return new self($response, $request, 'Forbidden');
    }
}
