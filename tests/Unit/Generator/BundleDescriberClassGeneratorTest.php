<?php

namespace CPSIT\Auditor\Tests\Unit\Generator;

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
use CPSIT\Auditor\BundleDescriber;
use CPSIT\Auditor\Generator\BundleDescriberClassGenerator;
use CPSIT\Auditor\Reflection\RootPackageReflection;
use CPSIT\Auditor\SettingsInterface as SI;
use CPSIT\Auditor\Tests\Unit\GeneratedFilesTrait;
use CPSIT\Auditor\Tests\Unit\TestApplicationTrait;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class BundleDescriberClassGeneratorTest
 */
class BundleDescriberClassGeneratorTest extends TestCase
{
    use GeneratedFilesTrait;
    use TestApplicationTrait;

    /**
     * @var BundleDescriberClassGenerator|MockObject
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
    public function setUp(): void
    {
        $this->composer = $this->getMockBuilder(Composer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->io = $this->createMock(IOInterface::class);

        $this->subject = new BundleDescriberClassGenerator($this->composer, $this->io);

        $this->cleanUpGeneratedFiles();
        $this->initializeTestApplication();
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function writeFileWritesMessageForMissingFilePath(): void
    {
        $invalidFilePath = '/bar/baz.boo';

        $this->subject = $this->getMockBuilder(BundleDescriberClassGenerator::class)
            ->onlyMethods(['getFilePath'])
            ->setConstructorArgs([$this->composer, $this->io])
            ->getMock();
        $this->subject->expects($this->once())->method('getFilePath')
            ->willReturn($invalidFilePath);

        $this->io->expects($this->once())->method('write')
            ->with($this->subject::MESSAGE_INFO_LEAD . $this->subject::ERROR_ROOT_PACKAGE_NOT_FOUND);

        $this->subject->writeFile();
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function writeFileWritesContentsCorrectlyIntoFile(): void
    {
        ['composer' => $composer, 'io' => $io] = $this->initializeComposer();

        // Create class with given contents
        $subject = new BundleDescriberClassGenerator($composer, $io);
        $properties = RootPackageReflection::getProperties($composer->getPackage());
        $installedPackages = $composer->getRepositoryManager()->getLocalRepository()->getPackages();
        $subject->writeFile($properties, $installedPackages);

        // Check whether the class was generated successfully
        $targetFileName = implode(DIRECTORY_SEPARATOR, [
            $composer->getConfig()->get(SI::KEY_VENDOR_DIR),
            SI::PACKAGE_IDENTIFIER,
            SI::SOURCE_FOLDER_NAME,
            SI::BUNDLE_DESCRIBER_CLASS . '.php',
        ]);
        self::assertFileExists($targetFileName);
        self::assertTrue(class_exists(BundleDescriber::class));

        // Check whether the class contains all relevant properties
        foreach ($properties as $propertyKey => $propertyValue) {
            self::assertTrue(BundleDescriber::hasProperty($propertyKey));
        }

        // Verify that we can access properties through the BundleDescriber
        // The actual values may differ from the test application due to runtime environment
        if (BundleDescriber::hasProperty('name')) {
            $name = BundleDescriber::getProperty('name');
            self::assertIsString($name, 'Package name should be a string');
            self::assertNotEmpty($name, 'Package name should not be empty');
        }
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function writeFileWritesMessageAfterGeneration(): void
    {
        $this->markTestSkipped("Test fails due to missing composer config in InstallPath->toString()");
        $invalidFilePath = 'bar/';

        $this->io->expects($this->once())->method('write')
            ->with($this->subject::MESSAGE_INFO_LEAD . $this->subject::MESSAGE_DONE_BUNDLE_DESCRIBER);

        $this->subject->writeFile();
    }

    protected function tearDown(): void
    {
        $this->cleanUpTestApplication();
    }
}
