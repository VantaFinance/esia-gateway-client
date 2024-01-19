<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Client;

use Symfony\Component\Uid\Uuid;

final class AuthorizationUrlBuilder
{
    private string $baseUri;

    private Provider $provider = Provider::CPG_OAUTH;

    private string $clientId;

    /**
     * @var non-empty-string
     */
    private string $redirectUri;

    private string $responseType = 'code';

    /**
     * @var non-empty-list<ScopePermission>
     */
    private array $permissions;

    /**
     * @var non-empty-list<Purpose>
     */
    private array $purposes;

    private Purpose $sysname;

    private int $expire;

    private Actions $actions;

    private Uuid $state;

    /**
     * @param non-empty-list<Purpose>         $purposes
     * @param non-empty-list<ScopePermission> $permissions
     * @param non-empty-string                $redirectUri
     */
    public function __construct(
        string $baseUri,
        string $clientId,
        string $redirectUri,
        array $purposes = [
            Purpose::FIN_AGREEMENT,
        ],
        Purpose $sysname = Purpose::FIN_AGREEMENT,
        array $permissions = [
            ScopePermission::FULL_NAME,
            ScopePermission::GENDER,
            ScopePermission::BIRTHDATE,
            ScopePermission::MOBILE,
            ScopePermission::EMAIL,
        ],
        int $expire = 5,
        Actions $actions = Actions::ALL_ACTIONS_TO_DATA,
        ?Uuid $state = null,
    ) {
        $this->baseUri     = $baseUri;
        $this->clientId    = $clientId;
        $this->redirectUri = $redirectUri;
        $this->purposes    = $purposes;
        $this->sysname     = $sysname;
        $this->permissions = $permissions;
        $this->expire      = $expire;
        $this->actions     = $actions;
        $this->state       = $state ?? Uuid::v4();
    }

    /**
     * @param non-empty-list<Purpose>         $purposes
     * @param non-empty-list<ScopePermission> $permissions
     * @param non-empty-string                $redirectUri
     */
    public static function create(
        string $gatewayHostname,
        string $clientId,
        string $redirectUri,
        array $purposes = [
            Purpose::CREDIT,
        ],
        Purpose $sysname = Purpose::CREDIT,
        array $permissions = [
            ScopePermission::FULL_NAME,
            ScopePermission::GENDER,
            ScopePermission::BIRTHDATE,
            ScopePermission::MOBILE,
            ScopePermission::EMAIL,
        ],
        int $expire = 5,
        Actions $actions = Actions::ALL_ACTIONS_TO_DATA,
        ?Uuid $state = null,
    ): self {
        return new self($gatewayHostname, $clientId, $redirectUri, $purposes, $sysname, $permissions, $expire, $actions, $state);
    }

    public function withBaseUri(string $baseUri): self
    {
        return new self(
            $baseUri,
            $this->clientId,
            $this->redirectUri,
            $this->purposes,
            $this->sysname,
            $this->permissions,
            $this->expire,
            $this->actions,
            $this->state,
        );
    }

    public function withClientId(string $clientId): self
    {
        return new self(
            $this->baseUri,
            $clientId,
            $this->redirectUri,
            $this->purposes,
            $this->sysname,
            $this->permissions,
            $this->expire,
            $this->actions,
            $this->state,
        );
    }

    public function withPermission(ScopePermission $permission): self
    {
        if (in_array($permission, $this->permissions, true)) {
            return $this;
        }

        return new self(
            $this->baseUri,
            $this->clientId,
            $this->redirectUri,
            $this->purposes,
            $this->sysname,
            array_merge($this->permissions, [$permission]),
            $this->expire,
            $this->actions,
            $this->state,
        );
    }

    public function withoutPermission(ScopePermission $permission): self
    {
        $permissions = array_diff($this->permissions, [$permission]);

        if ($permissions == []){
            throw new \LogicException('Список типов согласий должен быть не пустой');
        }

        return new self(
            $this->baseUri,
            $this->clientId,
            $this->redirectUri,
            $this->purposes,
            $this->sysname,
            $permissions,
            $this->expire,
            $this->actions,
            $this->state,
        );
    }

    public function withPurpose(Purpose $purpose): self
    {
        if (in_array($purpose, $this->purposes, true)) {
            return $this;
        }

        return new self(
            $this->baseUri,
            $this->clientId,
            $this->redirectUri,
            array_merge($this->purposes, [$purpose]),
            $this->sysname,
            $this->permissions,
            $this->expire,
            $this->actions,
            $this->state,
        );
    }

    public function withoutPurpose(Purpose $purpose): self
    {
        $purposes = array_diff($this->purposes, [$purpose]);

        if ($purposes == []){
            throw new \LogicException('Мнемоника целей должна быть не пустой');
        }

        return new self(
            $this->baseUri,
            $this->clientId,
            $this->redirectUri,
            $purposes,
            $this->sysname,
            $this->permissions,
            $this->expire,
            $this->actions,
            $this->state,
        );
    }

    public function withSysname(Purpose $sysname): self
    {
        return new self(
            $this->baseUri,
            $this->clientId,
            $this->redirectUri,
            $this->purposes,
            $sysname,
            $this->permissions,
            $this->expire,
            $this->actions,
            $this->state,
        );
    }

    public function withExpire(int $expire): self
    {
        return new self(
            $this->baseUri,
            $this->clientId,
            $this->redirectUri,
            $this->purposes,
            $this->sysname,
            $this->permissions,
            $expire,
            $this->actions,
            $this->state,
        );
    }

    public function withState(Uuid $state): self
    {
        return new self(
            $this->baseUri,
            $this->clientId,
            $this->redirectUri,
            $this->purposes,
            $this->sysname,
            $this->permissions,
            $this->expire,
            $this->actions,
            $state,
        );
    }

    /**
     * @param non-empty-string $redirectUri
     */
    public function withRedirectUri(string $redirectUri): self
    {
        return new self(
            $this->baseUri,
            $this->clientId,
            $redirectUri,
            $this->purposes,
            $this->sysname,
            $this->permissions,
            $this->expire,
            $this->actions,
            $this->state,
        );
    }

    /**
     * @return non-empty-string
     */
    public function build(): string
    {
        $query = http_build_query([
            'client_id'     => $this->clientId,
            'response_type' => $this->responseType,
            'redirect_uri'  => $this->redirectUri,
            'scope'         => ScopePermission::OPEN_ID->value,
            'permissions'   => implode(' ', array_column($this->permissions, 'value')),
            'purposes'      => implode(' ', array_column($this->purposes, 'value')),
            'sysname'       => $this->sysname->value,
            'state'         => $this->state->toRfc4122(),
            'expire'        => $this->expire,
            'actions'       => $this->actions->value,
            'provider'      => $this->provider->value,
        ]);

        return sprintf('%s/auth/authorize?%s', $this->baseUri, $query);
    }
}
