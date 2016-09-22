<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Exception\ItemFilterException;

class GlobalId
{
    const EBAY_AT = 'ebay-at';
    const EBAY_AU = 'ebay-au';
    const EBAY_CH = 'ebay-ch';
    const EBAY_DE = 'ebay-de';
    const EBAY_ENCA = 'ebay-enca';
    const EBAY_ES = 'ebay-es';
    const EBAY_FR = 'ebay-fr';
    const EBAY_FRBE = 'ebay-frbe';
    const EBAY_FRCA = 'ebay-frca';
    const EBAY_GB = 'ebay-gb';
    const EBAY_HK = 'ebay-hk';
    const EBAY_IE = 'ebay-ie';
    const EBAY_IN = 'ebay-in';
    const EBAY_IT = 'ebay-it';
    const EBAY_MOTOR = 'ebay-motor';
    const EBAY_MY = 'ebay-my';
    const EBAY_NL = 'ebay-nl';
    const EBAY_NLBE = 'ebay-nlbe';
    const EBAY_PH = 'ebay-ph';
    const EBAY_PL = 'ebay-pl';
    const EBAY_SG = 'ebay-sg';
    const EBAY_US = 'ebay-us';

    /**
     * @var array $globalIds
     */
    private $globalIds = array(
        'ebay-at' => array(
            'global-id' => 'EBAY-AT',
            'language' => 'de-AT',
            'teritory' => 'AT',
            'site-name' => 'Ebay Austria',
            'ebay-site-id' => 16,
        ),
        'ebay-au' => array(
            'global-id' => 'EBAY-AU',
            'language' => 'en-AU',
            'teritory' => 'AU',
            'site-name' => 'Ebay Australia',
            'ebay-site-id' => 15,
        ),
        'ebay-ch' => array(
            'global-id' => 'EBAY-CH',
            'language' => 'de-CH',
            'teritory' => 'CH',
            'site-name' => 'eBay Switzerland',
            'ebay-site-id' => 193,
        ),
        'ebay-de' => array(
            'global-id' => 'EBAY-DE',
            'language' => 'de-DE',
            'teritory' => 'DE',
            'site-name' => 'eBay Germany',
            'ebay-site-id' => 77,
        ),
        'ebay-enca' => array(
            'global-id' => 'EBAY-ENCA',
            'language' => 'en-CA',
            'teritory' => 'CA',
            'site-name' => 'eBay Canada (English)',
            'ebay-site-id' => 2,
        ),
        'ebay-es' => array(
            'global-id' => 'EBAY-ES',
            'language' => 'es-ES',
            'teritory' => 'ES',
            'site-name' => 'eBay Spain',
            'ebay-site-id' => 186,
        ),
        'ebay-fr' => array(
            'global-id' => 'EBAY-FR',
            'language' => 'fr-FR',
            'teritory' => 'FR',
            'site-name' => 'eBay France',
            'ebay-site-id' => 71,
        ),
        'ebay-frbe' => array(
            'global-id' => 'EBAY-FRBE',
            'language' => 'fr-BE',
            'teritory' => 'BE',
            'site-name' => 'eBay Belgium (French)',
            'ebay-site-id' => 23,
        ),
        'ebay-frca' => array(
            'global-id' => 'EBAY-FRCA',
            'language' => 'fr-CA',
            'teritory' => 'CA',
            'site-name' => 'eBay Canada (French)',
            'ebay-site-id' => 210,
        ),
        'ebay-gb' => array(
            'global-id' => 'EBAY-GB',
            'language' => 'en-GB',
            'teritory' => 'GB',
            'site-name' => 'eBay UK',
            'ebay-site-id' => 3,
        ),
        'ebay-hk' => array(
            'global-id' => 'EBAY-HK',
            'language' => 'zh-Hant',
            'teritory' => 'HK',
            'site-name' => 'eBay Hong Kong',
            'ebay-site-id' => 201,
        ),
        'ebay-ie' => array(
            'global-id' => 'EBAY-IE',
            'language' => 'en-IE',
            'teritory' => 'IE',
            'site-name' => 'eBay Ireland',
            'ebay-site-id' => 205,
        ),
        'ebay-in' => array(
            'global-id' => 'EBAY-IN',
            'language' => 'en-IN',
            'teritory' => 'IN',
            'site-name' => 'eBay India',
            'ebay-site-id' => 203,
        ),
        'ebay-it' => array(
            'global-id' => 'EBAY-IT',
            'language' => 'it-IT',
            'teritory' => 'IT',
            'site-name' => 'eBay Italy',
            'ebay-site-id' => 101,
        ),
        'ebay-motor' => array(
            'global-id' => 'EBAY-MOTOR',
            'language' => 'en-US',
            'teritory' => 'US',
            'site-name' => 'eBay Motors',
            'ebay-site-id' => 100,
        ),
        'ebay-my' => array(
            'global-id' => 'EBAY-MY',
            'language' => 'en-MY',
            'teritory' => 'MY',
            'site-name' => 'eBay Malaysia',
            'ebay-site-id' => 207,
        ),
        'ebay-nl' => array(
            'global-id' => 'EBAY-NL',
            'language' => 'nl-NL',
            'teritory' => 'NL',
            'site-name' => 'eBay Netherlands',
            'ebay-site-id' => 146,
        ),
        'ebay-nlbe' => array(
            'global-id' => 'EBAY-NLBE',
            'language' => 'nl-BE',
            'teritory' => 'BE',
            'site-name' => 'eBay Belgium (Dutch)',
            'ebay-site-id' => 123,
        ),
        'ebay-ph' => array(
            'global-id' => 'EBAY-PH',
            'language' => 'en-PH',
            'teritory' => 'PH',
            'site-name' => 'eBay Philippines',
            'ebay-site-id' => 212,
        ),
        'ebay-pl' => array(
            'global-id' => 'EBAY-PL',
            'language' => 'pl-PL',
            'teritory' => 'PL',
            'site-name' => 'eBay Poland',
            'ebay-site-id' => 212,
        ),
        'ebay-sg' => array(
            'global-id' => 'EBAY-SG',
            'language' => 'en-SG',
            'teritory' => 'SG',
            'site-name' => 'eBay Singapore',
            'ebay-site-id' => 216,
        ),
        'ebay-us' => array(
            'global-id' => 'EBAY-US',
            'language' => 'en-US',
            'teritory' => 'US',
            'site-name' => 'eBay United States',
            'ebay-site-id' => 0,
        ),
    );
    /**
     * @var GlobalId $instance
     */
    private static $instance;
    /**
     * @return GlobalId
     */
    public static function instance()
    {
        self::$instance = (self::$instance instanceof self) ? self::$instance : new self();

        return self::$instance;
    }
    /**
     * @param string $id
     * @return mixed|null
     */
    public function getId(string $id)
    {
        if (!$this->hasId($id)) {
            return null;
        }

        return $this->globalIds[$id];
    }
    /**
     * @param string $id
     * @return mixed
     */
    public function hasId(string $id)
    {
        return array_key_exists($id, $this->globalIds);
    }
    /**
     * @param string $name
     * @param array $values
     * @return GlobalId
     * @throws ItemFilterException
     */
    public function addId(string $name, array $values) : GlobalId
    {
        if ($this->hasId($name)) {
            throw new ItemFilterException('Global id '.$name.' already exists');
        }

        if (!array_key_exists('global-id', $values) and !empty($values['global-id'])) {
            throw new ItemFilterException('Global id '.$name.' value array has to have at least a global-id key and corresponding value');
        }

        $this->globalIds[$name] = $values;

        return $this;
    }
    /**
     * @param string $id
     * @return bool
     */
    public function removeId(string $id) : bool
    {
        if (!$this->hasId($id)) {
            return false;
        }

        unset($this->globalIds[$id]);

        return true;
    }
}