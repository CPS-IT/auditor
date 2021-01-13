<?php

namespace CPSIT\Auditor\Tests\Unit;

use CPSIT\Auditor\DescriberInterface;
use CPSIT\Auditor\Dto\Package;
use CPSIT\Auditor\InstalledPackagesTrait;
use PHPUnit\Framework\MockObject\MockObject;
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

class MockClassWithPropertyInstalledPackages
{
    use InstalledPackagesTrait;

    static protected $installedPackages = [
        'foo' => ['bar']
    ];
}
class MockClassWithoutPropertyInstalledPackage
{
    use InstalledPackagesTrait;
}

/**
 * Class InstalledPackagesTraitTest
 * @coversDefaultClass \CPSIT\Auditor\InstalledPackagesTrait
 */
class InstalledPackagesTraitTest extends TestCase
{
    /**
     * @var InstalledPackagesTrait|MockObject
     */
    protected $subject;

    protected $packages = [
        'foo' => ['bar']
    ];

    public function setUp(): void
    {
        $this->subject = $this->getMockBuilder(InstalledPackagesTrait::class)
            ->getMockForTrait();
    }

    public function testGetInstalledPackagesReturnsArray(): void
    {
        $this->assertIsArray(
            $this->subject::getInstalledPackages()
        );
    }

    public function testIsPackageInstalledReturnsTrueForInstalledPackage(): void
    {
        $this->assertTrue(
            MockClassWithInstalledPackages::isPackageInstalled('foo')
        );
    }

    /**
     * @covers ::isPackageInstalled
     */
    public function testIsPackageInstalledReturnsFalseForMissingPackage(): void
    {
        $this->assertFalse(
            MockClassWithInstalledPackages::isPackageInstalled('anyPackageName')
        );
    }

    /**
     * @covers ::propertyExists
     * @expectedException \OutOfBoundsException
     * @expextedExceptionCode 1557047757
     */
    public function testPropertyExistThrowsExceptionForMissingProperty(): void
    {
        $expectedMessage = sprintf(
            DescriberInterface::ERROR_MISSING_PROPERTY,
            DescriberInterface::INSTALLED_PACKAGES,
            MockClassWithoutPropertyInstalledPackage::class
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
        MockClassWithoutPropertyInstalledPackage::propertyExists(DescriberInterface::INSTALLED_PACKAGES);
    }

    /**
     * @covers ::getInstalledPackage
     */
    public function testGetInstalledPackageReturnsPackageObject(): void
    {
        $this->assertInstanceOf(
            Package::class,
            MockClassWithPropertyInstalledPackages::getInstalledPackage('foo')
        );
    }
}