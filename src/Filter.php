<?php

namespace EmberDb;

class Filter
{
    private $filterData = array();



    public function __construct($filterArray)
    {
        $this->filterData = $filterArray;
    }



    public function matchesEntry(array $entry)
    {
        $isMatch = $this->matchesArray($this->filterData, $entry);

        return $isMatch;
    }



    private function matchesArray($filterArray, $entryArray)
    {
        $isMatch = true;
        foreach ($filterArray as $filterKey => $filterValue) {

            // Check if the filter key exists and fetch corresponding value from entry
            if (array_key_exists($filterKey, $entryArray)) {
                $entryValue = $entryArray[$filterKey];
            } else {
                $isMatch = false;
                break;
            }

            // Check if the values match
            $isMatch &= $this->matchesValue($filterValue, $entryValue);
        }

        return $isMatch;
    }



    private function matchesValue($filterValue, $entryValue)
    {
        $isMatch = false;

        // If both are an array ...
        if (is_array($filterValue) && is_array($entryValue)) {
            $isMatch = $this->matchesArray($filterValue, $entryValue);
        }

        if (!is_array($filterValue) && !is_array($entryValue)) {
            $isMatch = $filterValue === $entryValue;
        }

        return $isMatch;
    }



    private function isOperator($value)
    {
        if (is_array($value) && count($value) == 1) {
            $key = array_keys($value)[0];
            $isOperator = in_array($key, array('$gt', '$lt'));
        } else {
            $isOperator = false;
        }

        return $isOperator;
    }
}
