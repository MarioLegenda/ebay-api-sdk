<?php

namespace FindingAPI\Core\ItemFilter;

use StrongType\ArrayType;

class Condition extends AbstractFilter implements FilterInterface
{
    protected $filter;
    /**
     * @param array $filter
     * @return bool
     */
    public function validateFilter() : bool
    {
        if (!$this->genericValidation($this->filter)) {
            return false;
        }

        $allowedValues = new ArrayType(array(
            'text-values' => array('New', 'Used', 'Unspecified'),
            'id-values' => array(1000, 1500, 1750, 2000, 2500, 3000, 4000, 5000, 6000, 7000),
        ));

        $uniques = array_unique($this->filter);

        foreach ($uniques as $val) {
            if (!$allowedValues->inArray($val, 'text-values') and !$allowedValues->inArray($val, 'id-values')) {
                $this->exceptionMessages['Invalid argument for item filter '.$this->name.'. Please, refer to http://developer.ebay.com/devzone/finding/callref/types/ItemFilterType.html'];

                return false;
            }
        }

        $this->filter = $uniques;

        return true;
    }
}