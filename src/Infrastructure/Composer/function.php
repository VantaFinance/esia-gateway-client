<?php
/**
 * ESIA Gateway Client
 *
 * @author Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Infrastructure\Composer;

use Composer\InstalledVersions;
use Composer\Semver\Comparator;
use RuntimeException;

/**
 * @internal
 *
 * @param non-empty-string $package
 * @param non-empty-string $version
 */
function isOldPackage(string $package, string $version): bool
{
    $packageVersion = InstalledVersions::getVersion($package);

    if (null == $packageVersion) {
        throw new RuntimeException(sprintf('Not found version package: %s', $package));
    }

    return Comparator::greaterThan($version, $packageVersion);
}
