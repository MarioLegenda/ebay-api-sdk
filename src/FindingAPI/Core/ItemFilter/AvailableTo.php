<?php

namespace FindingAPI\Core\ItemFilter;

use Symfony\Component\Yaml\Yaml;

class AvailableTo extends AbstractConstraint implements FilterInterface
{
    /**
     * @param array $filter
     * @return bool
     */
    public function validateFilter(array $filter) : bool
    {
        if (count($filter) !== 1) {
            $this->exceptionMessages[] = $this->name.' has to be an array argument with only one value';

            return false;
        }

        $userCode = $filter[0];
        $codes = array();

        $countryCodes = Yaml::parse(file_get_contents(__DIR__.'/country_codes.yml'));

        foreach ($countryCodes['iso-codes'] as $code) {
            $codes[] = $code['alpha2'];
        }

        if (in_array($userCode, $codes) === false) {
            $this->exceptionMessages[] = '\'AvailableTo has to receive an array with one value. Also, AvailableTo has to be a valid ISO 3166 country name. Please, refer to https://www.iso.org/obp/ui/#search\'';

            return false;
        }

        return true;
    }
}