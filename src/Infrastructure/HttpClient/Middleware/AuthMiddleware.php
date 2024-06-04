<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Infrastructure\HttpClient\Middleware;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Vanta\Integration\EsiaGateway\Infrastructure\HttpClient\ConfigurationClient;

final readonly class AuthMiddleware implements Middleware
{
    public function process(Request $request, ConfigurationClient $configuration, callable $next): Response
    {
        if (!$request->hasHeader('redirect_uri')) {
            return $next($request, $configuration);
        }

        $result      = [];
        $uri         = $request->getUri();
        $redirectUri = $request->getHeaderLine('redirect_uri');
        $redirectUri = '' == $redirectUri ? $configuration->redirectUri : $redirectUri;

        parse_str($uri->getQuery(), $result);

        $query = http_build_query([
            'client_id'     => $configuration->clientId,
            'client_secret' => $configuration->clientSecret,
            'redirect_uri'  => $redirectUri,
            ...$result,
        ]);

        $request = $request->withoutHeader('redirect_uri')
            ->withUri($uri->withQuery($query))
        ;

        return $next($request, $configuration);
    }
}
