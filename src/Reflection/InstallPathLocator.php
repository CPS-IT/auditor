<?php

namespace Cpsit\Conductor\Reflection;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use Composer\Composer;
use Composer\Config;
use Composer\Package\AliasPackage;
use Composer\Package\RootPackageInterface;
use Cpsit\Conductor\SettingsInterface as SI;

/**
 * Class InstallPathLocator
 */
class InstallPathLocator
{
    /**
     * @var Config
     */
    protected $composerConfig;

    /**
     * @var RootPackageInterface
     */
    protected $rootPackage;

    /**
     * InstallPathLocator constructor.
     * @param Composer $composer
     */
    public function __construct(Composer $composer)
    {
        $this->composerConfig = $composer->getConfig();
        $this->rootPackage = $composer->getPackage();
    }

    /**
     * @return string
     */
    public function getInstallPath(): string {
        return $this->getComposerConfig()->get(SI::KEY_VENDOR_DIR) . '/' . SI::PACKAGE_IDENTIFIER;
    }

    /**
     * @return Config
     */
    public function getComposerConfig(): Config {
        return $this->composerConfig;
    }

    /**
     * @return RootPackageInterface
     */
    public function getRootPackage(): RootPackageInterface
    {
        return $this->rootPackage;
    }

}