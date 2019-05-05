<?php

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
    const NAME = 'NullPackageName';
    const VERSION = 'NullPackageVersion';
    const SOURCE_REFERENCE = 'NullPackageSourceReference';

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param string $name
     * @return Package
     */
    public function setName(string $name): Package
    {
        return $this;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return self::VERSION;
    }

    /**
     * @param string $version
     * @return Package
     */
    public function setVersion(string $version): Package
    {
        return $this;
    }

    /**
     * @return string
     */
    public function getSourceReference(): string
    {
        return self::SOURCE_REFERENCE;
    }

    /**
     * @param string $sourceReference
     * @return Package
     */
    public function setSourceReference(string $sourceReference): Package
    {
        return $this;
    }
}