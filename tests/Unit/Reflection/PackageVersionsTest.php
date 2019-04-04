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
    public function testGetAllReturnsArray()
    {
        $this->assertIsArray(
            PackageVersions::getAll()
        );
    }

    public function testGetAllReturnsPackagesArray()
    {
        $name = 'composer/ca-bundle';
        $version = '1.1.3';
        $sourceReference = '8afa52cd417f4ec417b4bfe86b68106538a87660';

        $versions = [
            $name => $version . PackageVersions::VERSION_SEPATOR . $sourceReference
        ];

        $packages = PackageVersions::getAll($versions);

        $this->assertCount(
            1,
            $packages
        );
        /** @var Package $package */
        $package = $packages[0];
        $this->assertInstanceOf(
            Package::class,
            $package
        );

        $this->assertEquals(
            $version,
            $package->getVersion()
        );

        $this->assertEquals(
            $sourceReference,
            $package->getSourceReference()
        );

        $this->assertEquals(
            $name,
            $package->getName()
        );
    }
}
