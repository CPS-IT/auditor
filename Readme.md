# Auditor

This is a Composer plugin. It allows to access information about the current (root) package.

## Requirements

* Composer
* PHP >= 7.1

### Version matrix

|              | PHP 8.0 | PHP 7.4 | PHP 7.3 | PHP 7.2 | PHP 7.1 |
| ------------ | ------- | ------- | ------- | ------- | ------- |
| Composer 1.x | 0.5.x | 0.5.x | 0.5.x | 0.1.0 - 0.5.x | 0.1.0 - 0.5.x
| Composer 2.x | 0.5.x | 0.5.x | 0.5.x | 0.5.x | 0.5.x |

## Usage

In your project root  

```bash
composer require cpsit/auditor
```

After installation or update via Composer a class `CPSIT\Auditor\BundleDescriber` is generated.

It allows to access each property of your bundle (root package).

```php
$name = \CPSIT\Auditor\BundleDescriber::getProperty('name');
```
