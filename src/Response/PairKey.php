<?php
/**
 * ESIA Gateway Client
 *
 * @author    Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Response;

use DateTimeImmutable;
use Symfony\Component\Serializer\Annotation\SerializedPath;
use Vanta\Integration\Esia\Struct\Permission;

final readonly class PairKey
{
    /**
     * @param non-empty-string           $tokenId
     * @param non-empty-string           $tokenType
     * @param positive-int               $expiresIn
     * @param non-empty-string           $accessToken
     * @param non-empty-string           $refreshToken
     * @param non-empty-list<Permission> $scope
     */
    public function __construct(
        #[SerializedPath('[access_token]')]
        public string $accessToken,
        #[SerializedPath('[token_type]')]
        public string $tokenType,
        #[SerializedPath('[expires_in]')]
        public int $expiresIn,
        #[SerializedPath('[created_at]')]
        public DateTimeImmutable $createdAt,
        #[SerializedPath('[refresh_token]')]
        public string $refreshToken,
        #[SerializedPath('[id_token]')]
        public string $tokenId,
        public array $scope
    ) {
    }
}
