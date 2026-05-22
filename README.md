# Horde\Nls Native Language Support

A library for handling language data, country codes, timezones, TLD lookups and IP-to-country resolution.

## Installation

```bash
composer require horde/nls
```

### Optional dependencies

```bash
# For reverse-DNS hostname lookups
composer require mikepultz/netdns2

# For MaxMind GeoIP2/GeoLite2 database lookups
composer require geoip2/geoip2
```

## Usage

### Basic usage (injectable service)

```php
use Horde\Nls\Nls;

$nls = new Nls();

// Country lookup
$nls->countries()->get('DE');          // 'Germany'
$nls->countries()->all();              // ['AD' => 'Andorra', 'AE' => 'United Arab Emirates', ...]
$nls->countries()->translated();       // Localized names, sorted by locale

// Language lookup
$nls->languages()->get('fr');          // 'French'

// Timezones
$nls->getTimezones();                  // ['Africa/Abidjan' => 'Africa/Abidjan', ...]

// Charset validation
$nls->checkCharset('UTF-8');           // true
$nls->checkCharset('NOT-REAL');        // false
```

### Data classes as arrays

All data classes implement `IteratorAggregate`, `ArrayAccess`, and `Countable`:

```php
$countries = new \Horde\Nls\Countries();

foreach ($countries as $code => $name) {
    echo "$code: $name\n";
}

echo $countries['US'];     // 'United States'
echo count($countries);    // 249
isset($countries['XX']);   // false
```

### Translation (explicit)

Translation is never applied implicitly. Call `translated()` when you need localized output:

```php
$countries = new \Horde\Nls\Countries();

$countries->all();         // English names (default)
$countries->translated();  // Localized via gettext, sorted by locale
```

### Country lookup from hostname/IP

```php
use Horde\Nls\Nls;
use Horde\Nls\Dns\NativeResolver;
use Horde\Nls\Geoip\Geoip2Driver;

$nls = new Nls(
    resolver: new NativeResolver(),
    geoip: new Geoip2Driver('/path/to/GeoLite2-Country.mmdb'),
);

$result = $nls->getCountryByHost('example.de');
// ['code' => 'de', 'name' => 'Germany']

$result = $nls->getCountryByHost('8.8.8.8');
// ['code' => 'us', 'name' => 'United States'] (via GeoIP)
```

### Legacy code resolution

Retired ISO-3166 codes and old country names are handled by `LegacyCodes`:

```php
$legacy = new \Horde\Nls\LegacyCodes();

$legacy->resolve('AN');                    // 'BQ' (Netherlands Antilles → Bonaire)
$legacy->resolve('YU');                    // 'RS' (Yugoslavia → Serbia)
$legacy->resolveName('Czech Republic');    // 'CZ'
$legacy->resolveName('Swaziland');         // 'SZ'
```

### GeoIP drivers

```php
use Horde\Nls\Geoip\Geoip2Driver;
use Horde\Nls\Geoip\LegacyDatDriver;
use Horde\Nls\Geoip\NullDriver;

// MaxMind GeoIP2 (recommended)
$geoip = new Geoip2Driver('/path/to/GeoLite2-Country.mmdb');

// Legacy .dat format
$geoip = new LegacyDatDriver('/path/to/GeoIP.dat');

// No GeoIP (default)
$geoip = new NullDriver();
```

### DNS resolvers

```php
use Horde\Nls\Dns\NullResolver;
use Horde\Nls\Dns\NativeResolver;
use Horde\Nls\Dns\NetDns2Resolver;

// No reverse DNS (default)
$resolver = new NullResolver();

// PHP built-in gethostbyaddr
$resolver = new NativeResolver();

// NetDNS2 library
$resolver = new NetDns2Resolver($netdns2Instance);
```

## Architecture

```
src/
├── Nls.php                          # Main injectable service
├── Translation.php                  # Horde\Translation integration
├── Countries.php                    # ISO-3166 country data
├── Languages.php                    # ISO-639-1 language data
├── Tld.php                          # TLD → country mapping
├── Alpha3.php                       # Alpha-2 → Alpha-3 codes
├── Carsigns.php                     # License plate prefixes
├── LegacyCodes.php                  # Retired code resolution
├── Coordinates/
│   ├── CoordinatesInterface.php     # Provider contract
│   └── StaticCoordinates.php        # Bundled city data
├── Dns/
│   ├── ResolverInterface.php        # Reverse DNS contract
│   ├── NullResolver.php
│   ├── NativeResolver.php
│   └── NetDns2Resolver.php
├── Geoip/
│   ├── GeoipInterface.php           # IP→country contract
│   ├── Geoip2Driver.php             # MaxMind GeoIP2/GeoLite2
│   ├── LegacyDatDriver.php          # MaxMind legacy .dat
│   └── NullDriver.php
└── DataRegeneration/
    └── IanaTldUpdater.php           # IANA TLD list updater
```

## Upgrading from Horde_Nls

See [doc/UPGRADING.md](doc/UPGRADING.md) for a complete migration guide from the legacy `Horde_Nls` static API to the new injectable `Horde\Nls\Nls` service.

## Requirements

- PHP 8.1+
- ext-mbstring
- horde/translation ^3

## License

LGPL-2.1-only. See [LICENSE](LICENSE) for details.
