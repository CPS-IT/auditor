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

use Composer\Factory;
use Composer\Installer;
use Composer\IO\BufferIO;
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

    /**
     * @var bool
     */
    protected $keepTestApplication = false;

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

    protected function initializeComposer(): array
    {
        // Initialize test application if not done yet
        if (!$this->isTestApplicationInitialized()) {
            $this->initializeTestApplication();
        }

        // Initialize Composer
        $io = new BufferIO();
        $composer = (new Factory())->createComposer($io);

        // Assert dependencies can be installed
        static::assertSame(
            0,
            Installer::create($io, $composer)
                ->setDevMode(false)
                ->setPreferDist(true)
                ->setVerbose(true)
                ->run(),
            sprintf('Unable to install Composer dependencies of test application (%s): %s', $this->testApplicationPath, $io->getOutput())
        );

        return [
            'composer' => $composer,
            'io' => $io,
        ];
    }

    protected function isTestApplicationInitialized(): bool
    {
        $filesystem = new Filesystem();
        return is_string($this->testApplicationPath) && $filesystem->exists($this->testApplicationPath);
    }

    protected function cleanUpTestApplication(): void
    {
        if ($this->isTestApplicationInitialized() && !$this->keepTestApplication) {
            $filesystem = new Filesystem();
            $filesystem->remove($this->testApplicationPath);
        }
    }

    protected function onNotSuccessfulTest(\Throwable $t): void
    {
        $this->keepTestApplication = true;
        parent::onNotSuccessfulTest($t);
    }
}
