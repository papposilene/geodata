# Geodata

[geodata](https://github.com/papposilene/geodata) is a package that offers data about continents, countries, regions and cities.

## Config folder
The `config` folder contains a config file for Laravel.

## Data Folder
The `data` folder contains all the JSON files, with `countries`, `administrative-levels` (from 4 to 6), `cities`, `currencies`.
A last folder, `flags`, contains the SVG-version of countries' flags. 

## Database folder
The `database` folder contains a `migrations` and a `seeders` folders. 
The `migrations` one has the directives for creating some databases : 
- `geodata__continents` ;
- `geodata__subcontients` ;
- `geodata__countries` ;
- `geodata__regions` ;
- `geodata__cities`.

The `seeders` files will hydrate the databases :
- `geodata__continents`: 6 rows ;
- `geodata__subcontients`: 23 rows ;
- `geodata__countries`: 250 rows ;
- `geodata__regions`: 44,524 rows ;
- `geodata__cities`: still counting...

All data folders, except the `countries` one, has its files subdivided by country. 

Obviously, you are totally free to install and hydrate the databases and their data you need for your own project. :)

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
