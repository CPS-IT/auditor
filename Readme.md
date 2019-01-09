Auditor
=========

This is a composer plugin. It allows to access information about the current (root) package.

### Requirements
* composer
* PHP >= 7.1

### Usage

In your project root  

````bash
composer require cpsit/auditor
````

**Note:** The package is not yet available on packagist.org. 
Please add `https://github.com/CPS-IT/auditor` to  the list of repositories in your 
`composer.json`

After installation or update via composer a class `CPSIT\Auditor\BundleDescriber` is generated.

It allows to access each property of your bundle (root package).

```php
$name = \CPSIT\Auditor\BundleDescriber::getProperty('name');

```

