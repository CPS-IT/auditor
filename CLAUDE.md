# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a **Composer Plugin** called "Auditor" that provides runtime access to composer package metadata. It automatically generates a `BundleDescriber` class containing information about the root package and its dependencies, eliminating the need to parse composer.json files at runtime.

## Development Commands

### Testing
```bash
# Run all tests
composer test
```

### Setup
```bash
# Install dependencies and setup coverage directory
composer install
```

## Architecture

The plugin follows a structured approach to provide package introspection:

### Core Plugin System
- **`Installer`** - Main plugin class that implements Composer's `PluginInterface` and `EventSubscriberInterface`
- **`BundleDescriberClassGenerator`** - Generates the runtime reflection class with serialized package data
- Activated on `post-install-cmd` and `post-update-cmd` events

### Reflection System
- **`RootPackageReflection`** - Extracts properties from composer's root package
- **`PackageVersions`** - Manages installed package information  
- **`InstallPath`** - Handles installation path resolution
- **`PropertiesTrait`** - Provides property access methods with lazy loading

### Data Objects
- **`Package`** / **`NullPackage`** DTOs for package representation
- **`DescriberInterface`** - Contract for accessing package properties

## Technical Requirements

- **PHP**: ^8.2 || ^8.3
- **Composer Plugin API**: ^2.1
- Uses custom build directory structure (`.build/vendor`, `.build/bin`)

## Generated Runtime Interface

The plugin generates `CPSIT\Auditor\BundleDescriber` with static methods:
```php
// Access root package properties
$name = \CPSIT\Auditor\BundleDescriber::getProperty('name');

// Get all installed packages  
$packages = \CPSIT\Auditor\Reflection\PackageVersions::getAll();
```