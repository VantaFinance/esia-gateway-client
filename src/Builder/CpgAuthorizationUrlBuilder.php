<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Builder;

use InvalidArgumentException;
use LogicException;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV7;
use Vanta\Integration\Esia\Struct\Action;

use function Vanta\Integration\Esia\Struct\Bridge\Enum\array_enum_diff;

use Vanta\Integration\Esia\Struct\Permission;
use Vanta\Integration\Esia\Struct\Sysname;
use Vanta\Integration\EsiaGateway\Request\Provider;

final class CpgAuthorizationUrlBuilder
{
    private string $baseUri;

    private string $clientId;

    /**
     * @var non-empty-string
     */
    private string $redirectUri;

    private string $responseType = 'code';

    /**
     * @var non-empty-list<Permission>
     */
    private array $permissions;

    /**
     * @var non-empty-list<Sysname>
     */
    private array $purposes;

    private Sysname $sysname;

    private int $expire;

    /**
     * @var non-empty-list<Action>
     */
    private array $actions;

    private Uuid $state;

    /**
     * @param non-empty-list<Sysname>    $purposes
     * @param non-empty-list<Permission> $permissions
     * @param non-empty-string           $redirectUri
     * @param non-empty-list<Action>     $actions
     */
    public function __construct(
        string $baseUri,
        string $clientId,
        string $redirectUri,
        array $purposes = [
            Sysname::FIN_AGREEMENT,
        ],
        Sysname $sysname = Sysname::FIN_AGREEMENT,
        array $permissions = [
            Permission::FULL_NAME,
            Permission::GENDER,
            Permission::BIRTHDATE,
            Permission::MOBILE,
            Permission::EMAIL,
        ],
        int $expire = 5,
        array $actions = [Action::ALL_ACTIONS_TO_DATA],
        Uuid $state = new UuidV7(),
    ) {
        $this->state       = $state;
        $this->baseUri     = $baseUri;
        $this->clientId    = $clientId;
        $this->redirectUri = $redirectUri;
        $this->purposes    = $purposes;
        $this->sysname     = $sysname;
        $this->permissions = $permissions;
        $this->expire      = $expire;
        $this->actions     = $actions;
    }

    /**
     * @param non-empty-list<Sysname>    $purposes
     * @param non-empty-list<Permission> $permissions
     * @param non-empty-string           $redirectUri
     * @param non-empty-list<Action>     $actions
     */
    public static function create(
        string $gatewayHostname,
        string $clientId,
        string $redirectUri,
        array $purposes = [
            Sysname::FIN_AGREEMENT,
        ],
        Sysname $sysname = Sysname::FIN_AGREEMENT,
        array $permissions = [
            Permission::FULL_NAME,
            Permission::GENDER,
            Permission::BIRTHDATE,
            Permission::MOBILE,
            Permission::EMAIL,
        ],
        int $expire = 5,
        array $actions = [Action::ALL_ACTIONS_TO_DATA],
        Uuid $state = new UuidV7(),
    ): self {
        return new self(
            baseUri: $gatewayHostname,
            clientId: $clientId,
            redirectUri: $redirectUri,
            purposes: $purposes,
            sysname: $sysname,
            permissions: $permissions,
            expire: $expire,
            actions: $actions,
            state: $state
        );
    }

    /**
     * @param non-empty-string $baseUri
     */
    public function withBaseUri(string $baseUri): self
    {
        $new          = clone $this;
        $new->baseUri = $baseUri;

        return $new;
    }

    /**
     * @param non-empty-string $clientId
     */
    public function withClientId(string $clientId): self
    {
        $new           = clone $this;
        $new->clientId = $clientId;

        return $new;
    }

    public function withSysname(Sysname $sysname): self
    {
        $new          = clone $this;
        $new->sysname = $sysname;

        return $new;
    }

    public function withState(Uuid $state = new UuidV7()): self
    {
        $new        = clone $this;
        $new->state = $state;

        return $new;
    }

    /**
     * @param non-empty-string $redirectUri
     */
    public function withRedirectUri(string $redirectUri): self
    {
        $new              = clone $this;
        $new->redirectUri = $redirectUri;

        return $new;
    }

    public function withAction(Action $action): self
    {
        if (in_array($action, $this->actions, true)) {
            return $this;
        }

        $new          = clone $this;
        $new->actions = array_merge($this->actions, [$action]);

        return $new;
    }

    public function withoutAction(Action $action): self
    {
        $actions = array_enum_diff($this->actions, [$action]);

        if ([] == $actions) {
            throw new LogicException('Список типов мнемоник действий должен быть не пустой');
        }

        $new          = clone $this;
        $new->actions = $actions;

        return $new;
    }

    public function withPermission(Permission $permission): self
    {
        if (Permission::OPEN_ID == $permission) {
            throw new InvalidArgumentException('Запрещено использовать согласие: openid');
        }

        if (in_array($permission, $this->permissions, true)) {
            return $this;
        }

        $new              = clone $this;
        $new->permissions = array_merge($this->permissions, [$permission]);

        return $new;
    }

    public function withoutPermission(Permission $permission): self
    {
        $permissions = array_enum_diff($this->permissions, [$permission]);

        if ([] == $permissions) {
            throw new LogicException('Список типов согласий должен быть не пустой');
        }

        $new              = clone $this;
        $new->permissions = $permissions;

        return $new;
    }

    public function withPurpose(Sysname $purpose): self
    {
        if (in_array($purpose, $this->purposes, true)) {
            return $this;
        }

        $new           = clone $this;
        $new->purposes = array_merge($this->purposes, [$purpose]);

        return $new;
    }

    public function withoutPurpose(Sysname $purpose): self
    {
        $purposes = array_enum_diff($this->purposes, [$purpose]);

        if ([] == $purposes) {
            throw new LogicException('Список типов согласий должен быть не пустой');
        }

        $new           = clone $this;
        $new->purposes = $purposes;

        return $new;
    }

    /**
     * @param positive-int $expire
     */
    public function withExpire(int $expire): self
    {
        $new         = clone $this;
        $new->expire = $expire;

        return $new;
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
            'scope'         => Permission::OPEN_ID->value,
            'permissions'   => implode(' ', array_column($this->permissions, 'value')),
            'purposes'      => implode(' ', array_column($this->purposes, 'value')),
            'sysname'       => $this->sysname->value,
            'state'         => $this->state->toRfc4122(),
            'expire'        => $this->expire,
            'actions'       => implode(' ', array_column($this->actions, 'value')),
            'provider'      => Provider::CPG_OAUTH->value,
        ]);

        return sprintf('%s/auth/authorize?%s', $this->baseUri, $query);
    }
}
