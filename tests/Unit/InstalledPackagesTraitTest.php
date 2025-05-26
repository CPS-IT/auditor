<?php

namespace CPSIT\Auditor\Tests\Unit;

use CPSIT\Auditor\DescriberInterface;
use CPSIT\Auditor\Dto\Package;
use CPSIT\Auditor\InstalledPackagesTrait;
use PHPUnit\Framework\TestCase;

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

#[\PHPUnit\Framework\Attributes\CoversClass(\CPSIT\Auditor\InstalledPackagesTrait::class)]
class InstalledPackagesTraitTest extends TestCase
{
    /**
     * @var InstalledPackagesTrait
     */
    protected $subjectWithPropertyInstalledPackages;

    /**
     * @var InstalledPackagesTrait
     */
    protected $subjectWithoutPropertyInstalledPackages;

    public function setUp(): void
    {
        $this->subjectWithPropertyInstalledPackages = new class()
        {
            use InstalledPackagesTrait;

            protected static $installedPackages = 'a:1:{s:3:"foo";a:1:{i:0;s:3:"bar";}}';
        };
        $this->subjectWithoutPropertyInstalledPackages = new class()
        {
            use InstalledPackagesTrait;
        };
    }

    public function testGetInstalledPackagesReturnsArray(): void
    {
        self::assertIsArray(
            $this->subjectWithPropertyInstalledPackages::getInstalledPackages()
        );
    }

    public function testIsPackageInstalledReturnsTrueForInstalledPackage(): void
    {
        self::assertTrue(
            $this->subjectWithPropertyInstalledPackages::isPackageInstalled('foo')
        );
    }

    #[\PHPUnit\Framework\Attributes\Covers('isPackageInstalled')]
    public function testIsPackageInstalledReturnsFalseForMissingPackage(): void
    {
        self::assertFalse(
            $this->subjectWithPropertyInstalledPackages::isPackageInstalled('anyPackageName')
        );
    }

    #[\PHPUnit\Framework\Attributes\Covers('propertyExists')]
    public function testPropertyExistThrowsExceptionForMissingProperty(): void
    {
        $expectedMessage = sprintf(
            DescriberInterface::ERROR_MISSING_PROPERTY,
            DescriberInterface::INSTALLED_PACKAGES,
            get_class($this->subjectWithoutPropertyInstalledPackages)
        );

        $this->expectException(
            \OutOfBoundsException::class
        );
        $this->expectExceptionCode(
            1557047757
        );
        $this->expectExceptionMessage(
            $expectedMessage
        );

        $this->subjectWithoutPropertyInstalledPackages::propertyExists(DescriberInterface::INSTALLED_PACKAGES);
    }

    #[\PHPUnit\Framework\Attributes\Covers('getInstalledPackage')]
    public function testGetInstalledPackageReturnsPackageObject(): void
    {
        self::assertInstanceOf(
            Package::class,
            $this->subjectWithPropertyInstalledPackages::getInstalledPackage('foo')
        );
    }
}
