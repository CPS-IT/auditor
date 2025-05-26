![Tests](https://github.com/CPS-IT/auditor/workflows/Tests/badge.svg)
![Coverage](https://sonarcloud.io/api/project_badges/measure?project=CPS-IT_auditor&metric=coverage)
![Code quality](https://sonarcloud.io/api/project_badges/measure?project=CPS-IT_auditor&metric=alert_status)

# Auditor

This is a Composer plugin. It allows to access information about the current (root) package.

## Requirements

* Composer 2.1+
* PHP ^8.2 || ^8.3

### Version matrix

|              | PHP 8.3 | PHP 8.2 | PHP 8.1 | PHP 8.0 | PHP 7.4 |
| ------------ |---------|---------|---------|---------|---------|
| Composer 2.x | >=0.7   | >=0.7   | <=0.6.x | <=0.6.x | <=0.6.x |

**Note:** Version 0.7+ requires PHP 8.2+ and uses modern PHP features including strict types, typed properties, and PHPUnit 10/11.

## Usage

In your project root  

```bash
composer require cpsit/auditor
```

After installation or update via Composer a class `CPSIT\Auditor\BundleDescriber` is generated.

It allows to access each property of your bundle (root package).

#### Examples
Get the name of the current root package:
```php
$name = \CPSIT\Auditor\BundleDescriber::getProperty('name');
```

Get the repositories used by composer for the installation:
```php
$repositories = \CPSIT\Auditor\BundleDescriber::getProperty('repositories');
```

Get the installed packages (omit not installed package):
```php
$packages = \CPSIT\Auditor\Reflection\PackageVersions::getAll();
```
Returns an array of `CPSIT\Auditor\Dto\Package` objects.

