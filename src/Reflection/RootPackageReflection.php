<?php

namespace Cpsit\Conductor\Reflection;
use Composer\Package\RootPackageInterface;
use Cpsit\Conductor\RootPackageReflectionInterface;

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

class RootPackageReflection
{

    static protected $foo = array(
        'bar' => 'bas',
        'foo' => array()
    );
    /**
     * Gets all reflectable properties from Package
     * @param RootPackageInterface $package
     */
    static public function getProperties(RootPackageInterface $package) :array {
        $properties = [];
        $allowedProperties = RootPackageReflectionInterface::SUPPORTED_PACKAGE_PROPERTIES;

        foreach ($allowedProperties as $propertyName) {
            $methodName = 'get' . ucfirst($propertyName);
            if (is_callable([$package, $methodName])) {
                $properties[$propertyName] = $package->{$methodName}();
            }
        }
        return $properties;
    }
}
