<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Infrastructure\HttpClient;

final readonly class ConfigurationClient
{
    /**
     * @param non-empty-string $clientId
     * @param non-empty-string $clientSecret
     * @param non-empty-string $url
     * @param non-empty-string $redirectUri
     */
    public function __construct(
        public string $clientId,
        public string $clientSecret,
        public string $url,
        public string $redirectUri
    ) {
    }

    /**
     * @param non-empty-string $clientId
     */
    public function withClientId(string $clientId): self
    {
        return new self(
            clientId: $clientId,
            clientSecret: $this->clientSecret,
            url: $this->url,
            redirectUri: $this->redirectUri,
        );
    }

    /**
     * @param non-empty-string $clientSecret
     */
    public function withClientSecret(string $clientSecret): self
    {
        return new self(
            clientId: $this->clientId,
            clientSecret: $clientSecret,
            url: $this->url,
            redirectUri: $this->redirectUri,
        );
    }

    /**
     * @param non-empty-string $url
     */
    public function withUrl(string $url): self
    {
        return new self(
            clientId: $this->clientId,
            clientSecret: $this->clientSecret,
            url: $url,
            redirectUri: $this->redirectUri,
        );
    }

    /**
     * @param non-empty-string $redirectUri
     */
    public function withRedirectUri(string $redirectUri): self
    {
        return new self(
            clientId: $this->clientId,
            clientSecret: $this->clientSecret,
            url: $this->url,
            redirectUri: $redirectUri,
        );
    }
}
