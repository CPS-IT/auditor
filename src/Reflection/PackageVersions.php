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
use CPSIT\Auditor\Dto\Package;
use PackageVersions\Versions;

/**
 * Class PackageVersions
 */
class PackageVersions
{
    const VERSION_SEPATOR = '@';

    public static function getAll($versions = [])
    {
        if (empty($versions)) {
            $versions = Versions::VERSIONS;
        }
        $packages = [];

        foreach ($versions as $key => $value) {
            if (false === strpos($value, static::VERSION_SEPATOR)) {
                continue;
            }
            $package = new Package();
            $info = explode(static::VERSION_SEPATOR, $value);
            $package->setName($key)
                ->setVersion($info[0])
                ->setSourceReference($info[1]);

            $packages[] = $package;
        }

        return $packages;
    }
}
