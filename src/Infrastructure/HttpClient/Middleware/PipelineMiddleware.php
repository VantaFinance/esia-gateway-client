<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Infrastructure\HttpClient\Middleware;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface as PsrHttpClient;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Vanta\Integration\EsiaGateway\Infrastructure\HttpClient\ConfigurationClient;

final class PipelineMiddleware
{
    /**
     * @var array<int, Middleware>
     */
    private array $middlewares;

    private PsrHttpClient $client;

    /**
     * @param array<int, Middleware> $middlewares
     */
    public function __construct(array $middlewares, PsrHttpClient $client)
    {
        $this->middlewares = $middlewares;
        $this->client      = $client;
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function process(Request $request, ConfigurationClient $configuration): Response
    {
        $middlewares = $this->middlewares;
        $middleware  = array_shift($middlewares);

        if (null == $middleware) {
            return $this->client->sendRequest($request);
        }

        return $middleware->process($request, $configuration, [new self($middlewares, $this->client), 'process']);
    }
}
