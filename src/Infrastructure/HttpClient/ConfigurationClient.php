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
     * @param non-empty-string $clientId
     * @param non-empty-string $clientSecret
     * @param non-empty-string $url
     * @param non-empty-string $redirectUri
     */
    public function __construct(
        public readonly string $clientId,
        public readonly string $clientSecret,
        public readonly string $url,
        public readonly string $redirectUri
    ) {
    }
}
