<?php

declare(strict_types=1);

/**
 * Copyright 1999-2026 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @category  Horde
 * @license   http://www.horde.org/licenses/lgpl21 LGPL 2.1
 * @package   Nls
 */

namespace Horde\Nls;

use DateTimeZone;
use Horde\Nls\Coordinates\CoordinatesInterface;
use Horde\Nls\Dns\NullResolver;
use Horde\Nls\Dns\ResolverInterface;
use Horde\Nls\Geoip\GeoipInterface;
use Horde\Nls\Geoip\NullDriver;

/**
 * Native Language Support service.
 *
 * Provides country, language, timezone, and geographic lookup functionality
 * as an injectable service.
 *
 * @category  Horde
 * @license   http://www.horde.org/licenses/lgpl21 LGPL 2.1
 * @package   Nls
 */
class Nls
{
    private ?array $localeInfo = null;
    private ?array $langInfo = null;
    private ?array $timezones = null;

    public function __construct(
        private readonly Countries $countries = new Countries(),
        private readonly Languages $languages = new Languages(),
        private readonly Tld $tld = new Tld(),
        private readonly Alpha3 $alpha3 = new Alpha3(),
        private readonly Carsigns $carsigns = new Carsigns(),
        private readonly LegacyCodes $legacyCodes = new LegacyCodes(),
        private readonly GeoipInterface $geoip = new NullDriver(),
        private readonly ResolverInterface $resolver = new NullResolver(),
        private readonly CoordinatesInterface $coordinates = new Coordinates\StaticCoordinates(),
    ) {}

    public function countries(): Countries
    {
        return $this->countries;
    }

    public function languages(): Languages
    {
        return $this->languages;
    }

    public function tld(): Tld
    {
        return $this->tld;
    }

    public function alpha3(): Alpha3
    {
        return $this->alpha3;
    }

    public function carsigns(): Carsigns
    {
        return $this->carsigns;
    }

    public function legacyCodes(): LegacyCodes
    {
        return $this->legacyCodes;
    }

    public function coordinates(): CoordinatesInterface
    {
        return $this->coordinates;
    }

    /**
     * Validates whether a charset string is recognized by PHP's mbstring.
     */
    public function checkCharset(string $charset): bool
    {
        if ($charset === '') {
            return false;
        }

        $check = strtolower($charset);
        $supported = array_map('strtolower', mb_list_encodings());

        if (in_array($check, $supported, true)) {
            return true;
        }

        foreach (mb_list_encodings() as $encoding) {
            $aliases = @mb_encoding_aliases($encoding);
            if ($aliases !== false && in_array($check, array_map('strtolower', $aliases), true)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns a list of available timezones.
     *
     * @return array<string, string> Timezone identifiers as both keys and values
     */
    public function getTimezones(): array
    {
        if ($this->timezones === null) {
            $identifiers = DateTimeZone::listIdentifiers();
            $this->timezones = array_combine($identifiers, $identifiers);
        }

        return $this->timezones;
    }

    /**
     * Returns timezones with abbreviations as keys.
     *
     * @return array<string, string> Abbreviation/identifier => timezone ID
     */
    public function getTimezonesWithAbbreviations(): array
    {
        $timezones = array_flip($this->getTimezones());

        foreach (DateTimeZone::listAbbreviations() as $abbreviation => $zones) {
            $abbreviation = strtoupper($abbreviation);
            if ($abbreviation === 'UTC' || strlen($abbreviation) < 2) {
                continue;
            }
            if (!empty($zones[0]['timezone_id'])) {
                $timezones[$abbreviation] = $zones[0]['timezone_id'];
            }
        }

        return $timezones;
    }

    /**
     * Returns cached localeconv() output.
     *
     * @return array<string, mixed>
     */
    public function getLocaleInfo(): array
    {
        if ($this->localeInfo === null) {
            $this->localeInfo = localeconv();
        }

        return $this->localeInfo;
    }

    /**
     * Returns cached nl_langinfo() output.
     *
     * @return string|false
     */
    public function getLangInfo(int $item): string|false
    {
        if (!function_exists('nl_langinfo')) {
            return false;
        }

        if (!isset($this->langInfo[$item])) {
            $this->langInfo[$item] = nl_langinfo($item);
        }

        return $this->langInfo[$item];
    }

    /**
     * Get country information from a hostname or IP address.
     *
     * Uses TLD matching first, then GeoIP fallback.
     *
     * @return array{code: string, name: string}|null
     */
    public function getCountryByHost(string $host): ?array
    {
        $checkHost = null;

        if (filter_var($host, FILTER_VALIDATE_IP)) {
            $checkHost = $this->resolver->reverse($host);
            if ($checkHost === null) {
                $checkHost = @gethostbyaddr($host);
                if ($checkHost === false || $checkHost === $host) {
                    $checkHost = null;
                }
            }
        } else {
            $checkHost = $host;
        }

        if ($checkHost === null) {
            return $this->geoip->getCountryInfo($host);
        }

        $pos = strrpos($checkHost, '.');
        if ($pos === false) {
            return $this->geoip->getCountryInfo($host);
        }

        $domain = strtolower(substr($checkHost, $pos + 1));

        if (!$this->tld->isGeneric($domain)) {
            $name = $this->tld->get($domain);
            if ($name !== null) {
                return [
                    'code' => $domain,
                    'name' => $name,
                ];
            }
        }

        return $this->geoip->getCountryInfo($host);
    }
}
