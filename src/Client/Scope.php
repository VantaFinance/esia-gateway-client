<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Client;

use Webmozart\Assert\Assert;

final class Scope
{
    /**
     * @var list<ScopePermission>
     */
    private array $permissions = [];

    /**
     * @param string|list<ScopePermission>|null $value
     */
    public function __construct(string|array|null $value)
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

    /**
     * @return non-empty-string
     */
    public function __toString(): string
    {
        /** @var non-empty-string $value */
        $value = implode(
            ' ',
            array_map(
                static fn (ScopePermission $permission): string => $permission->value,
                $this->permissions
            ),
        );

        return $value;
    }

    public function withPermission(ScopePermission $permission): self
    {
        if (in_array($permission, $this->permissions)) {
            return $this;
        }

        /** @var list<ScopePermission> $permissions */
        $permissions = array_merge($this->permissions, [$permission]);

        return new self($permissions);
    }

    public function withoutPermission(ScopePermission $permission): self
    {
        if (!in_array($permission, $this->permissions)) {
            return $this;
        }

        /** @var list<ScopePermission> $permissions */
        $permissions = array_diff($this->permissions, [$permission]);

        return new self($permissions);
    }
}
