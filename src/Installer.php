<?php

namespace Cpsit\Conductor;

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
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Package\AliasPackage;
use Composer\Package\Locker;
use Composer\Package\PackageInterface;
use Composer\Package\RootPackageInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event;
use Composer\Script\ScriptEvents;
use Cpsit\Conductor\Generator\ApplicationReflectionClassGenerator;
use Cpsit\Conductor\Reflection\RootPackageReflection;
use Cpsit\Conductor\SettingsInterface as SI;

/**
 * Class Installer
 */
final class Installer implements PluginInterface, EventSubscriberInterface
{

    public const ENTRY_METHOD_NAME = 'dumpApplicationReflectionClass';

    /**
     * {@inheritDoc}
     */
    public function activate(Composer $composer, IOInterface $io): void
    {
        // Nothing to do here, as all features are provided through event listeners
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            ScriptEvents::POST_INSTALL_CMD => self::ENTRY_METHOD_NAME,
            ScriptEvents::POST_UPDATE_CMD => self::ENTRY_METHOD_NAME,
        ];
    }

    /**
     * @param Event $composerEvent
     */
    public static function dumpApplicationReflectionClass(Event $composerEvent)
    {
        $composer = $composerEvent->getComposer();
        $properties = RootPackageReflection::getProperties($composer->getPackage());
        $generator = new ApplicationReflectionClassGenerator($composer, $composerEvent->getIO());
        $generator->writeFile($properties);
    }

}
