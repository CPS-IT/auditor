<?php

namespace Cpsit\Conductor\Tests\Unit\Generator;

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
use Composer\IO\IOInterface;
use Cpsit\Conductor\Generator\ApplicationReflectionClassGenerator;
use Cpsit\Conductor\Reflection\InstallPathLocator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class ApplicationReflectionClassGeneratorTest
 */
class ApplicationReflectionClassGeneratorTest extends TestCase
{
    /**
     * @var ApplicationReflectionClassGenerator|MockObject
     */
    protected $subject;

    /**
     * @var Composer|MockObject
     */
    protected $composer;

    /**
     * @var IOInterface|MockObject
     */
    protected $io;

    /**
     * {@inheritDoc)
     */
    public function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        $this->composer = $this->getMockBuilder(Composer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->io = $this->getMockBuilder(IOInterface::class)
            ->setMethods(['write'])
            ->getMockForAbstractClass();

        $this->subject = $this->getMockBuilder(ApplicationReflectionClassGenerator::class)
            ->setMethods(['dummy'])
            ->setConstructorArgs([$this->composer, $this->io])
            ->getMock();
    }

    /**
     * @test
     */
    public function constructorSetsInstallPathLocator()
    {
        $this->assertInstanceOf(
            InstallPathLocator::class,
            $this->subject->getInstallPathLocator()
        );
    }

    /**
     * @test
     */
    public function constructorSetsIO()
    {
        $this->assertInstanceOf(
            IOInterface::class,
            $this->subject->getIo()
        );
    }

    /**
     * @test
     */
    public function writeFileWritesMessageForMissingFilePath()
    {
        $invalidFilePath = '/bar/baz.boo';

        $this->subject = $this->getMockBuilder(ApplicationReflectionClassGenerator::class)
            ->setMethods(['getFilePath'])
            ->setConstructorArgs([$this->composer, $this->io])
            ->getMock();
        $this->subject->expects($this->once())->method('getFilePath')
            ->willReturn($invalidFilePath);

        $this->io->expects($this->once())->method('write')
            ->with($this->subject::MESSAGE_INFO_LEAD . $this->subject::ERROR_ROOT_PACKAGE_NOT_FOUND);

        $this->subject->writeFile();
    }

    /**
     * @test
     */
    public function writeFileWritesMessageAfterGeneration()
    {
        $this->markTestSkipped();
        $invalidFilePath = 'bar/';

        $this->io->expects($this->once())->method('write')
            ->with($this->subject::MESSAGE_INFO_LEAD . $this->subject::MESSAGE_DONE_APPLICATION_REFLECTION);

        $this->subject->writeFile();
    }
}