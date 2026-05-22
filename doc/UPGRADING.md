# Upgrading from Horde_Nls to Horde\Nls

## Overview

- New PSR-4 namespace: `Horde\Nls` (classes live in `src/`)
- Injectable service replaces the static facade
- Translation is explicit: call `->translated()` instead of getting pre-translated data
- PHP 8.1+ required

## Quick Start

```php
use Horde\Nls\Nls;
use Horde\Nls\Geoip\LegacyDatDriver;
use Horde\Nls\Resolver\NativeResolver;

// Minimal: no GeoIP, no DNS resolver
$nls = new Nls();

// Full: with GeoIP and DNS
$nls = new Nls(
    geoip: new LegacyDatDriver('/path/to/GeoIP.dat'),
    resolver: new NativeResolver(),
);

// Use via dependency injection
class MyController
{
    public function __construct(
        private readonly Nls $nls,
    ) {}

    public function listCountries(): array
    {
        return $this->nls->countries()->translated();
    }
}
```

## Migration Table

| Legacy (Horde_Nls) | New (Horde\Nls) |
|---|---|
| `Horde_Nls::getCountryISO()` | `$nls->countries()->all()` or `->get($code)` |
| `Horde_Nls::getCountryISO($code)` | `$nls->countries()->get($code)` |
| `Horde_Nls::getLanguageISO()` | `$nls->languages()->all()` |
| `Horde_Nls::getLanguageISO($code)` | `$nls->languages()->get($code)` |
| `Horde_Nls::tldLookup($code)` | `$nls->tld()->get($code)` |
| `Horde_Nls::getCountryByHost($host, $datafile)` | `$nls->getCountryByHost($host)` |
| `Horde_Nls::checkCharset($charset)` | `$nls->checkCharset($charset)` |
| `Horde_Nls::getTimezones()` | `$nls->getTimezones()` |
| `Horde_Nls::getTimezonesWithAbbreviations()` | `$nls->getTimezonesWithAbbreviations()` |
| `Horde_Nls::getLocaleInfo()` | `$nls->getLocaleInfo()` |
| `Horde_Nls::getLangInfo($item)` | `$nls->getLangInfo($item)` |
| `Horde_Nls_Loader::loadCountries()` | `$nls->countries()->all()` |
| `Horde_Nls_Loader::loadLanguages()` | `$nls->languages()->all()` |
| `Horde_Nls_Loader::loadCarsigns()` | `$nls->carsigns()->all()` |
| `Horde_Nls_Loader::loadCoordinates()` | `$nls->coordinates()->forCountry($name)` |
| `Horde_Nls_Loader::loadAlpha3()` | `$nls->alpha3()->all()` |
| `Horde_Nls_Loader::loadTld()` | `$nls->tld()->all()` |
| `new Horde_Nls_Geoip($datafile)` | Inject `GeoipInterface` (`LegacyDatDriver` or `Geoip2Driver`) |
| `Horde_Nls::$dnsResolver = $x` | Inject `ResolverInterface` (`NetDns2Resolver`, `NativeResolver`) |

## Translation Changes

The old API returned pre-translated data. `Horde_Nls_Translation::t()` was called
at load time, so every consumer received localized strings automatically.

The new API separates data from presentation:

- `all()` returns the canonical English dataset
- `translated()` returns localized output using the active gettext locale

```php
// English names (for storage, APIs, machine consumption)
$countries = $nls->countries()->all();
// ['AD' => 'Andorra', 'AE' => 'United Arab Emirates', ...]

// Translated names (for UI display)
$countries = $nls->countries()->translated();
// ['AD' => 'Andorre', 'AE' => 'Emirats arabes unis', ...] (when locale is fr_FR)
```

This applies to all dataset accessors: `countries()`, `languages()`, `carsigns()`.

## GeoIP Configuration

GeoIP functionality requires an explicit driver. The `Nls` constructor accepts a
`GeoipInterface` implementation.

### LegacyDatDriver (MaxMind v1 .dat files)

```php
use Horde\Nls\Geoip\LegacyDatDriver;

$geoip = new LegacyDatDriver('/usr/share/GeoIP/GeoIP.dat');
$nls = new Nls(geoip: $geoip);

$country = $nls->getCountryByHost('example.com');
```

### Geoip2Driver (MaxMind GeoIP2 / GeoLite2 .mmdb files)

```php
use Horde\Nls\Geoip\Geoip2Driver;

$geoip = new Geoip2Driver('/usr/share/GeoIP/GeoLite2-Country.mmdb');
$nls = new Nls(geoip: $geoip);

$country = $nls->getCountryByHost('example.com');
```

### Preference

If both database formats are available, prefer `Geoip2Driver`. The GeoIP2 format
is actively maintained by MaxMind and provides better accuracy. The legacy `.dat`
format is end-of-life.

## DNS Resolver Configuration

The DNS resolver is used by `getCountryByHost()` to resolve hostnames to IP
addresses before GeoIP lookup.

| Resolver | Description |
|---|---|
| `NullResolver` (default) | No reverse DNS; `getCountryByHost()` only works with IP addresses |
| `NativeResolver` | Wraps PHP's `gethostbyaddr()` |
| `NetDns2Resolver` | Wraps `mikepultz/netdns2` for advanced DNS queries |

```php
use Horde\Nls\Nls;
use Horde\Nls\Resolver\NativeResolver;
use Horde\Nls\Resolver\NetDns2Resolver;

// Simple: uses PHP built-in DNS
$nls = new Nls(resolver: new NativeResolver());

// Advanced: uses Net_DNS2
$nls = new Nls(resolver: new NetDns2Resolver());
```

## Legacy Code Handling

### Retired Country Codes

Retired ISO 3166-1 codes (`AN`, `YU`, `ZR`, `CS`, `TP`, etc.) have been removed
from primary datasets. Use the `LegacyCodes` class to resolve old codes:

```php
// Resolve a retired code to its successor(s)
$result = $nls->legacyCodes()->resolve('AN');
// Returns info about Curacao, Sint Maarten, BES islands

// Resolve an outdated country name to current code
$code = $nls->legacyCodes()->resolveName('Czech Republic');
// Returns 'CZ' (now officially "Czechia")
```

### Name Aliases

The following historical names are supported as aliases:

- "Czech Republic" resolves to `CZ` (Czechia)
- "Macedonia" resolves to `MK` (North Macedonia)
- "Swaziland" resolves to `SZ` (Eswatini)
- "Turkey" resolves to `TR` (Turkiye)
- "Cape Verde" resolves to `CV` (Cabo Verde)

## Country Name Updates

The following country names have been updated to their current official forms:

| Old Name | New Name | Code |
|---|---|---|
| Czech Republic | Czechia | CZ |
| Macedonia, The Former Yugoslav Republic of | North Macedonia | MK |
| Swaziland | Eswatini | SZ |
| Turkey | Turkiye | TR |
| Cape Verde | Cabo Verde | CV |

## Breaking Changes

- **PHP 8.1+ required** - no support for older PHP versions
- **No static methods** - use dependency injection; the static `Horde_Nls::` facade is gone
- **Data not auto-translated** - call `->translated()` explicitly for localized output
- **Retired codes removed** from primary datasets - use `LegacyCodes` class for backward compatibility
- **GeoIP requires explicit driver configuration** - no automatic detection of `.dat` files
- **`checkCharset()` now uses mbstring** - previously used an `htmlspecialchars()` probe; now uses `mb_check_encoding()`
- **DNS resolver must be injected** - setting `Horde_Nls::$dnsResolver` as a public static property is no longer supported
