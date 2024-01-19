<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Client;

final class Scope
{
    /**
     * @var list<ScopePermission>
     */
    private array $permissions;

    /**
     * @param list<ScopePermission> $permissions
     */
    public function __construct(array $permissions = [])
    {
        $this->permissions = $permissions;
    }

    public static function fromRawScope(string $value): self
    {
        return new self(array_map(ScopePermission::from(...), explode(' ', $value)));
    }

    /**
     * @return literal-string
     */
    public function __toString(): string
    {
        return implode(' ', array_column($this->permissions, 'value'));
    }

    public function withPermission(ScopePermission $permission): self
    {
        if (in_array($permission, $this->permissions)) {
            return $this;
        }

        return new self(array_merge($this->permissions, [$permission]));
    }

    public function withoutPermission(ScopePermission $permission): self
    {
        if (!in_array($permission, $this->permissions)) {
            return $this;
        }

        return new self(array_diff($this->permissions, [$permission]));
    }
}
