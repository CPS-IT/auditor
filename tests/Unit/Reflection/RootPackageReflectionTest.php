<?php

namespace CPSIT\Auditor\Tests\Unit\Reflection;
use Composer\Package\RootPackageInterface;
use CPSIT\Auditor\Reflection\RootPackageReflection;
use CPSIT\Auditor\RootPackageReflectionInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

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

class RootPackageReflectionTest extends TestCase
{
    /**
     * @var RootPackageReflection
     */
    protected $subject;

    /**
     * @var RootPackageInterface|MockObject
     */
    protected $rootPackage;

    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->rootPackage = $this->getMockBuilder(RootPackageInterface::class)
            ->getMock();
    }

    /**
     * @test
     */
    public function testGetPropertiesReturnsArray(){
        $result = RootPackageReflection::getProperties($this->rootPackage);

        $this->assertTrue(
            is_array($result)
        );
    }

    /**
     * @test
     */
    public function testGetPropertiesContainsAllowedProperties(){
        $expectedProperties = RootPackageReflectionInterface::SUPPORTED_PACKAGE_PROPERTIES;
        $result = RootPackageReflection::getProperties($this->rootPackage);

        foreach ($expectedProperties as $expectedProperty) {
            $this->assertArrayHasKey($expectedProperty, $result);
        }
    }
}
