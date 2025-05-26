<?php

namespace CPSIT\Auditor\Tests\Unit\Reflection;

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
use CPSIT\Auditor\Reflection\InstallPath;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use CPSIT\Auditor\SettingsInterface as SI;

/**
 * Class InstallPathTest
 */
class InstallPathTest extends TestCase
{
    /**
     * @var InstallPath
     */
    protected $subject;

    /**
     * @var Composer|MockObject
     */
    protected $composer;

    /**
     * @var Config
     */
    protected $composerConfig;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->composerConfig = $this->getMockBuilder(Config::class)
            ->onlyMethods(['get'])
            ->getMock();
        $this->composer = $this->getMockBuilder(Composer::class)
            ->onlyMethods(['getConfig'])
            ->disableOriginalConstructor()
            ->getMock();
        $this->composer->method('getConfig')
            ->willReturn($this->composerConfig);
        $this->subject = new InstallPath($this->composer);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function testToStringReturnsPackagePathInVendorFolderFromComposerConfig(): void
    {
        $vendorDir = 'foo';

        $expectedPath = $vendorDir . '/' . SI::PACKAGE_IDENTIFIER;
        $this->composerConfig->expects($this->once())->method('get')
            ->with(SI::KEY_VENDOR_DIR)
            ->willReturn($vendorDir);

        $this->assertSame(
            $expectedPath,
            $this->subject->toString()
        );
    }
}
