<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Client;

use Symfony\Component\Serializer\Annotation\SerializedPath;

final class AccessToken
{
    /**
     * @var non-empty-string
     *
     * @SerializedPath("[access_token]")
     */
    private string $accessToken;

    /**
     * @var non-empty-string Always "Bearer"
     *
     * @SerializedPath("[token_type]")
     */
    private string $tokenType;

    /**
     * @var positive-int
     *
     * @SerializedPath("[expires_in]")
     */
    private int $expiresIn;

    /**
     * @var positive-int
     *
     * @SerializedPath("[created_at]")
     */
    private int $createdAt;

    /**
     * @var non-empty-string
     *
     * @SerializedPath("[refresh_token]")
     */
    private string $refreshToken;

    /**
     * @var non-empty-string
     *
     * @SerializedPath("[id_token]")
     */
    private string $idToken;

    private Scope $scope;

    /**
     * @param non-empty-string $accessToken
     * @param non-empty-string $tokenType
     * @param positive-int $expiresIn
     * @param int $createdAt
     * @param non-empty-string $refreshToken
     * @param non-empty-string $idToken
     * @param Scope $scope
     */
    public function __construct(string $accessToken, string $tokenType, int $expiresIn, int $createdAt, string $refreshToken, string $idToken, Scope $scope)
    {
        $this->accessToken  = $accessToken;
        $this->tokenType    = $tokenType;
        $this->expiresIn    = $expiresIn;
        $this->createdAt    = $createdAt;
        $this->refreshToken = $refreshToken;
        $this->idToken      = $idToken;
        $this->scope        = $scope;
    }

    /**
     * @return non-empty-string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @return non-empty-string
     */
    public function getTokenType(): string
    {
        return $this->tokenType;
    }

    /**
     * @return positive-int
     */
    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }

    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    /**
     * @return non-empty-string
     */
    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    /**
     * @return non-empty-string
     */
    public function getIdToken(): string
    {
        return $this->idToken;
    }

    public function getScope(): Scope
    {
        return $this->scope;
    }
}
