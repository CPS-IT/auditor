<?php

declare(strict_types=1);

namespace CPSIT\Auditor\Dto;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2019 Dirk Wenzel
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

/**
 * Class NullPackage
 */
final class NullPackage extends Package
{
    public const NAME = 'NullPackageName';
    public const VERSION = 'NullPackageVersion';
    public const SOURCE_REFERENCE = 'NullPackageSourceReference';

    public function getName(): string
    {
        return self::NAME;
    }

    public function setName(string $name): Package
    {
        // We ignore $name here since the package name is static
        return $this;
    }

    public function getVersion(): string
    {
        return self::VERSION;
    }

    public function setVersion(string $version): Package
    {
        // We ignore $version here since the package version is static
        return $this;
    }

    public function getSourceReference(): string
    {
        return self::SOURCE_REFERENCE;
    }

    public function setSourceReference(string $sourceReference): Package
    {
        // We ignore $sourceReference here since the packages' source reference is static
        return $this;
    }
}
