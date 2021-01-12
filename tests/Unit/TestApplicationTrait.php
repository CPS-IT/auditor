<?php

declare(strict_types=1);

/*
 * This file is part of the Composer package "cpsit/auditor".
 *
 * Copyright (C) 2021 Elias Häußler <e.haeussler@familie-redlich.de>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace CPSIT\Auditor\Tests\Unit;

use Symfony\Component\Filesystem\Filesystem;

/**
 * Trait for usage of test application in Unit tests.
 *
 * @author Elias Häußler <e.haeussler@familie-redlich.de>
 * @license GPL-2.0-or-later
 */
trait TestApplicationTrait
{
    /**
     * @var string
     */
    protected static $testApplicationTemplate = __DIR__ . '/../Build/test-application';

    /**
     * @var string
     */
    protected $testApplicationPath;

    protected function initializeTestApplication(): void
    {
        // Clean up previous test application
        $this->cleanUpTestApplication();

        // Create test application
        $filesystem = new Filesystem();
        $this->testApplicationPath = $filesystem->tempnam(sys_get_temp_dir(), 'auditor_test_');
        $this->cleanUpTestApplication();
        $filesystem->mkdir($this->testApplicationPath);

        // Create composer.json from template file
        $sourceComposerJson = static::$testApplicationTemplate . '/composer.json';
        $targetComposerJson = $this->testApplicationPath . '/composer.json';
        $filesystem->dumpFile(
            $targetComposerJson,
            str_replace('%APPLICATION_PATH%', realpath(dirname(__DIR__)), file_get_contents($sourceComposerJson))
        );

        // Switch to test application to make Composer dependency management testable
        chdir($this->testApplicationPath);
    }

    protected function cleanUpTestApplication(): void
    {
        $filesystem = new Filesystem();
        if (is_string($this->testApplicationPath) && $filesystem->exists($this->testApplicationPath)) {
            $filesystem->remove($this->testApplicationPath);
        }
    }
}
