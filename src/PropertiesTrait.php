<?php

declare(strict_types=1);

namespace CPSIT\Auditor;

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

trait PropertiesTrait
{
    protected static ?array $resolvedProperties = null;

    public static function getProperty(string $key): mixed
    {
        if (!self::hasProperty($key)) {
            throw new \OutOfBoundsException(
                'Required key "' . $key . '" is not valid: property not found in package',
                1557047730
            );
        }
        return static::$resolvedProperties[$key];
    }

    public static function hasProperty(string $key): bool
    {
        if (!static::arePropertiesResolved()) {
            static::resolveProperties();
        }
        return array_key_exists($key, static::$resolvedProperties ?? []);
    }

    protected static function arePropertiesResolved(): bool
    {
        return is_array(static::$resolvedProperties);
    }

    protected static function resolveProperties(): void
    {
        if (!property_exists(self::class, 'properties')) {
            return;
        }
        static::$resolvedProperties = unserialize(self::$properties, ['allowed_classes' => false]) ?: [];
    }
}
