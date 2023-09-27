<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Client;

use Symfony\Component\Uid\Uuid;

final class AuthorizationUrlBuilder
{
    private string $baseUri;

    private Provider $provider;

    private string $clientId;

    private string $redirectUri;

    private string $responseType = 'code';

    private Scope $scope;

    private Uuid $state;

    public function __construct(
        string $baseUri,
        string $clientId,
        string $redirectUri,
        ?Scope $scope = null,
        ?Uuid $state = null,
        ?Provider $provider = null
    ) {
        $this->baseUri  = $baseUri;
        $this->clientId = $clientId;
        $this->redirectUri = $redirectUri;
        $this->scope = $scope ?? new Scope([ScopePermission::OPEN_ID]);
        $this->state = $state ?? Uuid::v4();
        $this->provider = $provider ?? Provider::ESIA_OAUTH;
    }

    public static function create(
        string $gatewayHostname,
        string $clientId,
        string $redirectUri,
        ?Scope $scope = null,
        ?Uuid $state = null,
        ?Provider $provider = null
    ): self {
        return new self($gatewayHostname, $clientId, $redirectUri, $scope, $state, $provider);
    }

    public function withBaseUri(string $baseUri): self
    {
        return new self(
            $baseUri,
            $this->clientId,
            $this->redirectUri,
            $this->scope,
            $this->state,
            $this->provider,
        );
    }

    public function withProvider(Provider $provider): self
    {
        return new self(
            $this->baseUri,
            $this->clientId,
            $this->redirectUri,
            $this->scope,
            $this->state,
            $provider,
        );
    }

    public function withClientId(string $clientId): self
    {
        return new self(
            $this->baseUri,
            $clientId,
            $this->redirectUri,
            $this->scope,
            $this->state,
            $this->provider,
        );
    }

    public function withScope(Scope $scope): self
    {
        return new self(
            $this->baseUri,
            $this->clientId,
            $this->redirectUri,
            $scope,
            $this->state,
            $this->provider,
        );
    }

    public function withState(Uuid $state): self
    {
        return new self(
            $this->baseUri,
            $this->clientId,
            $this->redirectUri,
            $this->scope,
            $state,
            $this->provider,
        );
    }

    public function build(): string
    {
        $query = http_build_query([
            'client_id'     => $this->clientId,
            'response_type' => $this->responseType,
            'redirect_uri'  => $this->redirectUri,
            'scope'         => $this->scope->__toString(),
            'state'         => $this->state->toRfc4122(),
            'provider'      => $this->provider->value,
        ]);

        return sprintf('%s/auth/authorize?%s', $this->baseUri, $query);
    }
}
