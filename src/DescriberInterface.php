<?php

declare(strict_types=1);

namespace CPSIT\Auditor;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2018 Dirk Wenzel <wenzel@cps-it.de>
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
 * Interface DescriberInterface
 */
interface DescriberInterface
{
    public const INSTALLED_PACKAGES = 'installedPackages';
    public const ERROR_MISSING_PROPERTY = 'Required property "%s" does not exist in class "%s".';

    public static function getProperty(string $key): mixed;

    public static function hasProperty(string $key): bool;
}
