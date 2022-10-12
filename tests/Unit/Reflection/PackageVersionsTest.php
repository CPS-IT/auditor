<?php

namespace CPSIT\Auditor\Tests\Unit\Reflection;

use Composer\InstalledVersions;
use CPSIT\Auditor\Dto\Package;
use CPSIT\Auditor\Reflection\PackageVersions;
use PackageVersions\Versions;
use PHPUnit\Framework\TestCase;

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

class PackageVersionsTest extends TestCase
{
    public function testGetAllReturnsArray(): void
    {
        self::assertIsArray(
            PackageVersions::getAll()
        );
    }

    /**
     * @test
     */
    public function getAllReturnsArrayOfAllInstalledPackages(): void
    {
        $packages = PackageVersions::getAll();
        self::assertPackageExists(new Package(['name' => 'cpsit/auditor']), $packages);
    }

    /**
     * @test
     */
    public function getAllDoesNotReturnMetaPackages(): void
    {
        $installedPackages = InstalledVersions::getInstalledPackages();
        $expected = array_filter($installedPackages, function (string $packageName) {
            return null !== InstalledVersions::getVersion($packageName);
        });

        $actual = PackageVersions::getAll();
        $actual = array_map(function (Package $package) {
            return $package->getName();
        }, $actual);

        self::assertEquals(
            sort($expected),
            sort($actual)
        );
    }

    public function testGetAllReturnsPackagesArray(): void
    {
        $installed = InstalledVersions::getInstalledPackages();
        $expected = array_filter($installed, function (string $packageName) {
            return (null !== InstalledVersions::getVersion($packageName));
        });

        $packages = PackageVersions::getAll();

        self::assertCount(
            count($expected),
            $packages
        );
        /** @var Package $package */
        $package = $packages[0];
        self::assertInstanceOf(
            Package::class,
            $package
        );

        self::assertEquals(
            InstalledVersions::getVersion($package->getName()),
            $package->getVersion()
        );

        self::assertEquals(
            InstalledVersions::getReference($package->getName()),
            $package->getSourceReference()
        );
    }

    protected static function assertPackageExists(Package $expected, array $actual): void
    {
        $filterResult = array_filter($actual, function (Package $package) use ($expected) {
            return $package->getName() === $expected->getName();
        });
        self::assertNotSame(
            [],
            $filterResult,
            sprintf('"%s" was expected to be existent, but does not exist actually.', $expected->getName())
        );
    }
}
