<?php

namespace Cpsit\Conductor\Tests\Unit;

class InstallerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * {@inheritDoc}
     *
     * @throws \PHPUnit\Framework\Exception
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->installer = new Installer();
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
                'post-install-cmd' => 'dumpVersionsClass',
                'post-update-cmd' => 'dumpVersionsClass',
            ],
            $events
        );
        foreach ($events as $callback) {
            self::assertInternalType('callable', [$this->installer, $callback]);
        }
    }

}
