<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Infrastructure\HttpClient\Middleware;

use Psr\Http\Client\ClientExceptionInterface as ClientException;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Vanta\Integration\EsiaGateway\Infrastructure\HttpClient\ConfigurationClient;

interface Middleware
{
    /**
     * @param callable(Request, ConfigurationClient): Response $next
     *
     * @throws ClientException
     */
    public function process(Request $request, ConfigurationClient $configuration, callable $next): Response;
}
