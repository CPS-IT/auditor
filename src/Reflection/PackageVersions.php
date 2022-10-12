<?php

namespace CPSIT\Auditor\Reflection;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2019 Dirk Wenzel <wenzel@cps-it.de>
 *  All rights reserved
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the text file GPL.txt and important notices to the license
 * from the author is found in LICENSE.txt distributed with these scripts.
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use Composer\InstalledVersions;
use CPSIT\Auditor\Dto\Package;
use PackageVersions\Versions;

/**
 * Class PackageVersions
 */
class PackageVersions
{
    public static function getAll()
    {
        $versions = self::parsePackageVersions();
        $packages = [];

        foreach ($versions as $packageName => $installedVersion) {
            if (null === $installedVersion) {
                continue;
            }
            $sourceReference = InstalledVersions::getReference($packageName) ?? 'n.a. (package is being replaced or provided but is not really installed)';

            $package = new Package();
            $package->setName($packageName)
                ->setVersion($installedVersion)
                ->setSourceReference($sourceReference);

            $packages[] = $package;
        }

        return $packages;
    }

    private static function parsePackageVersions(): array
    {
        $packages = InstalledVersions::getInstalledPackages();
        return array_combine($packages, array_map([InstalledVersions::class, 'getVersion'], $packages));
    }
}
