![Tests](https://github.com/CPS-IT/auditor/workflows/Tests/badge.svg)
![Coverage](https://sonarcloud.io/api/project_badges/measure?project=CPS-IT_auditor&metric=coverage)
![Code quality](https://sonarcloud.io/api/project_badges/measure?project=CPS-IT_auditor&metric=alert_status)

# Auditor

This is a Composer plugin. It allows to access information about the current (root) package.

## Requirements

* Composer
* PHP >= 7.4

### Version matrix

|              | PHP 8.0 | PHP 7.4 | PHP 7.3 | PHP 7.2       | PHP 7.1       |
| ------------ |---------|---------|---------|---------------|---------------|
| Composer 1.x | 0.5.x   | 0.5.x   | 0.5.x   | 0.1.0 - 0.5.x | 0.1.0 - 0.5.x |
| Composer 2.x | >=0.5   | >=0.5   | 0.5.x   | 0.5.x         | 0.5.x         |

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

