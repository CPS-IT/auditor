<?php

namespace CPSIT\Auditor\Tests\Unit\Reflection;

use CPSIT\Auditor\Dto\Package;
use CPSIT\Auditor\Reflection\PackageVersions;
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
        self::assertPackageExists(new Package(['name' => 'composer/package-versions-deprecated']), $packages);
    }

    public function testGetAllReturnsPackagesArray(): void
    {
        $name = 'composer/ca-bundle';
        $version = '1.1.3';
        $sourceReference = '8afa52cd417f4ec417b4bfe86b68106538a87660';

        $versions = [
            $name => $version . PackageVersions::VERSION_SEPARATOR . $sourceReference
        ];

        $packages = PackageVersions::getAll($versions);

        self::assertCount(
            1,
            $packages
        );
        /** @var Package $package */
        $package = $packages[0];
        self::assertInstanceOf(
            Package::class,
            $package
        );

        self::assertEquals(
            $version,
            $package->getVersion()
        );

        self::assertEquals(
            $sourceReference,
            $package->getSourceReference()
        );

        self::assertEquals(
            $name,
            $package->getName()
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
