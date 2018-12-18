<?php

namespace Cpsit\Conductor\Tests\Unit\Reflection;

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

use Composer\Composer;
use Composer\Config;
use Composer\Package\RootPackageInterface;
use Cpsit\Conductor\Reflection\InstallPathLocator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Cpsit\Conductor\SettingsInterface as SI;

/**
 * Class InstallPathLocatorTest
 */
class InstallPathLocatorTest extends TestCase
{
    /**
     * @var InstallPathLocator
     */
    protected $subject;

    /**
     * @var Composer|MockObject
     */
    protected $composer;

    /**
     * {@inheritdoc}
     */
    public function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        $this->composer = $this->getMockBuilder(Composer::class)
            ->setMethods(['getConfig', 'getPackage'])
            ->disableOriginalConstructor()
            ->getMock();
        $this->subject = new InstallPathLocator($this->composer);
    }

    /**
     * @test
     */
    public function constructorSetsConfigFromComposer() {
        $config = $this->getMockBuilder(Config::class)->getMock();

        $this->composer->expects($this->once())->method('getConfig')->willReturn($config);

        $this->subject->__construct($this->composer);
        $this->assertSame(
            $config,
            $this->subject->getComposerConfig()
        );
    }

    /**
     * @test
     */
    public function constructorSetsRootPackageFromComposer() {
        $rootPackage = $this->getMockBuilder(RootPackageInterface::class)->getMock();

        $this->composer->expects($this->once())->method('getPackage')->willReturn($rootPackage);

        $this->subject->__construct($this->composer);
        $this->assertSame(
            $rootPackage,
            $this->subject->getRootPackage()
        );
    }

    /**
     * @test
     */
    public function getInstallPathReturnsPathFromComposerConfig() {
        $vendorDir = 'foo';

        $config = $this->getMockBuilder(Config::class)
            ->setMethods(['get'])
            ->getMock();
        $expectedPath = $vendorDir . '/' . SI::PACKAGE_IDENTIFIER;
        $config->expects($this->once())->method('get')
            ->with(SI::KEY_VENDOR_DIR)
            ->willReturn($vendorDir);

        $this->composer->expects($this->once())->method('getConfig')->willReturn($config);

        $this->subject->__construct($this->composer);

        $this->assertSame(
            $expectedPath,
            $this->subject->getInstallPath()
        );
    }
}