<?php

namespace CPSIT\Auditor\Tests\Unit\Dto;
use CPSIT\Auditor\Dto\Package;
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

class PackageTest extends TestCase
{
    /**
     * @var Package
     */
    protected $subject;


    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->subject = new Package();
    }

    public function testVersionIsInitiallyEmptyString(): void
    {
        $this->assertSame(
            '',
            $this->subject->getVersion()
        );
    }

    public function testVersionCanBeSet(): void
    {
        $value = 'foo';
        $this->subject->setVersion($value);

        $this->assertSame(
            $value,
            $this->subject->getVersion()
        );
    }

    public function testNameIsInitiallyEmptyString(): void
    {
        $this->assertSame(
            '',
            $this->subject->getName()
        );
    }

    public function testNameCanBeSet(): void
    {
        $value = 'foo';
        $this->subject->setName($value);

        $this->assertSame(
            $value,
            $this->subject->getName()
        );
    }

    public function testSourceReferenceIsInitiallyEmptyString(): void
    {
        $this->assertSame(
            '',
            $this->subject->getSourceReference()
        );
    }

    public function testSourceReferenceCanBeSet(): void
    {
        $value = 'foo';
        $this->subject->setSourceReference($value);

        $this->assertSame(
            $value,
            $this->subject->getSourceReference()
        );
    }
}
