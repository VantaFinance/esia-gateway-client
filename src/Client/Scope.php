<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Client;

use Webmozart\Assert\Assert;

final class Scope
{
    /**
     * @var list<ScopePermission> $permissions
     */
    private array $permissions = [];

    /**
     * @param string|list<ScopePermission>|null $value
     */
    public function __construct($value = null)
    {
        if (is_string($value)) {
            $this->permissions = array_map(
                [ScopePermission::class, 'from'],
                explode(' ', $value)
            );
        } elseif (is_array($value)) {
            Assert::allIsInstanceOf($value, ScopePermission::class);
            $this->permissions = $value;
        }
    }

    public function __toString()
    {
        return implode(
            ' ',
            array_map(
                function (ScopePermission $permission) { return $permission->getValue(); },
                $this->permissions
            ),
        );
    }

    public function withPermission(ScopePermission $permission): self
    {
        if (in_array($permission, $this->permissions)) {
            return $this;
        }

        return new self(
            array_merge($this->permissions, [$permission]),
        );
    }

    public function withoutPermission(ScopePermission $permission): self
    {
        if (!in_array($permission, $this->permissions)) {
            return $this;
        }

        return new self(
            array_diff($this->permissions, [$permission]),
        );
    }
}
