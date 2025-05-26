<?php

declare(strict_types=1);

namespace CPSIT\Auditor\Reflection;

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
use CPSIT\Auditor\SettingsInterface as SI;

/**
 * Class InstallPath
 */
class InstallPath
{
    protected Config $composerConfig;
    public function __construct(Composer $composer)
    {
        $this->composerConfig = $composer->getConfig();
    }

    public function toString(): string
    {
        return $this->composerConfig->get(SI::KEY_VENDOR_DIR) . '/' . SI::PACKAGE_IDENTIFIER;
    }

}
