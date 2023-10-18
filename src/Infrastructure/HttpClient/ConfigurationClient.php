<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

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
     * @param non-empty-string $clientId
     * @param non-empty-string $clientSecret
     * @param non-empty-string $url
     * @param non-empty-string $redirectUri
     */
    public function __construct(string $clientId, string $clientSecret, string $url, string $redirectUri)
    {
        $this->clientId     = $clientId;
        $this->clientSecret = $clientSecret;
        $this->url          = $url;
        $this->redirectUri  = $redirectUri;
    }

    /**
     * @return non-empty-string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @return non-empty-string
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * @return non-empty-string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return non-empty-string
     */
    public function getRedirectUri(): string
    {
        return $this->redirectUri;
    }
}
