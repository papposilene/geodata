# Geodata

[geodata](https://github.com/papposilene/geodata) is a package that offers data about continents, countries, geolocation data and many more little data (SVG & emoji flags, currencies, etc.). 

## Installation

You can install the package via composer:

```bash
composer require papposilene/geodata
```

## Usage

You can publish all the configuration and data in one line:
```php
php artisan vendor:publish --provider="Papposilene\Geodata\GeodataServiceProvider"
```

or file by file:
```php
php artisan vendor:publish --tag=geodata-config
php artisan vendor:publish --tag=geodata-migrations
php artisan vendor:publish --tag=geodata-seeders
php artisan vendor:publish --tag=geodata-data

php artisan migrate
php artisan db:seed
```

In the config/geodata.php, you can add some option (as SVG flags, currencies, geometries and topologies), then publish the migrations, seeders and data files with these lines:
```php
php artisan vendor:publish --tag=geodata-flags
php artisan vendor:publish --tag=geodata-currencies
php artisan vendor:publish --tag=geodata-geometries
php artisan vendor:publish --tag=geodata-topologies
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please use the issue tracker.

## Sources

This package uses some other open source packages and, until we don't build a better documentation, you can find some more info about data on [antonioribeiro/countries](https://github.com/antonioribeiro/countries/blob/master/README.md) and [mledoze/countries](https://github.com/mledoze/countries/blob/master/README.md).

Please check the copyright section for a complete list of packages used by this one.

## Credits

-   [Philippe-Alexandre Pierre](https://github.com/papposilene)
-   [Antonio Carlos Ribeiro](https://github.com/antonioribeiro)
-   [Mohammed Le Doze](https://github.com/mledoze)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## PHP Package Boilerplate

This package was generated using the [PHP Package Boilerplate](https://laravelpackageboilerplate.com) by [Beyond Code](http://beyondco.de/).
