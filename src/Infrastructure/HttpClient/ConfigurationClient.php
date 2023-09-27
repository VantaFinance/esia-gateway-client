<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Infrastructure\HttpClient;

final class ConfigurationClient
{
    /**
     * @var non-empty-string
     */
    private string $clientId;

    /**
     * @var non-empty-string
     */
    private string $clientSecret;

    /**
     * @var non-empty-string
     */
    private string $url;

    /**
     * @var non-empty-string
     */
    private string $redirectUri;

    /**
     * @param string $clientId
     * @param string $clientSecret
     * @param string $url
     * @param string $url
     */
    public function __construct(string $clientId, string $clientSecret, string $url, string $redirectUri)
    {
        $this->clientId     = $clientId;
        $this->clientSecret = $clientSecret;
        $this->url          = $url;
        $this->redirectUri  = $redirectUri;
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getRedirectUri(): string
    {
        return $this->redirectUri;
    }
}
