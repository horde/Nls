<?php
/**
 * OOP-style loader for various NLS data
 * 
 * As of H5, at least turba and Forms make assumptions about the filesystem
 * location of the data files and make an unconditional cross-library include.
 * 
 * This breaks for composer or other layouts. Use this wrapper but leave the original
 * files unchanged for backward compat
 * 
 * @TODO H6: Namespaced version of Horde_Nls should wrap these data into proper classes
 * @TODO H7: Remove backward compat
 */
class Horde_Nls_Loader
{
    public static function loadCarsigns(): array
    {
        include 'Carsigns.php';
        return $carsigns;
    }
    public static function loadCountries(): array
    {
        include 'Countries.php';
        return $countries;
    }
    public static function loadCoordinates(): array
    {
        include 'Coordinates.php';
        return $coordinates;
    }
    public function loadAlpha3(): array
    {
        include 'Alpha3.php';
        return $alpha3;
    }
    public function loadLanguages(): array
    {
        include 'Languages.php';
        return $languages;
    }
    public function loadTld(): array
    {
        include 'Tld.php';
        return $tld;
    }
}