<?php

namespace CPSIT\Auditor\Tests\Unit;

use Composer\Composer;
use Composer\EventDispatcher\EventDispatcher;
use Composer\IO\IOInterface;
use Composer\Script\ScriptEvents;
use CPSIT\Auditor\Installer;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class InstallerTest extends TestCase
{
    /**
     * @var Installer
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
     * @var EventDispatcher|MockObject
     */
    protected $eventDispatcher;

    /**
     * {@inheritDoc}
     *
     * @throws \PHPUnit\Framework\Exception
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = new Installer();
        $this->io = $this->createMock(IOInterface::class);
        $this->composer = $this->createMock(Composer::class);
        $this->eventDispatcher = $this->getMockBuilder(EventDispatcher::class)->disableOriginalConstructor()->getMock();
        $this->composer->expects(self::any())->method('getEventDispatcher')->willReturn($this->eventDispatcher);
    }

    public function testGetSubscribedEvents(): void
    {
        $events = Installer::getSubscribedEvents();
        self::assertSame(
            [
                ScriptEvents::POST_INSTALL_CMD => Installer::ENTRY_METHOD_NAME,
                ScriptEvents::POST_UPDATE_CMD => Installer::ENTRY_METHOD_NAME,
            ],
            $events
        );
        foreach ($events as $callback) {
            self::assertInternalType('callable', [$this->subject, $callback]);
        }
    }

}
