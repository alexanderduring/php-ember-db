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
        foreach ($filterArray as $key => $value) {
            if (array_key_exists($key, $entryArray)) {
                $entryValue = $entryArray[$key];
            } else {
                $isMatch = false;
                break;
            }

            if (is_array($value) && !is_array($entryValue) || !is_array($value) && is_array($entryValue)) {
                $isMatch = false;
                break;
            }

            if (is_array($value) && is_array($entryValue)) {
                $isMatch = $isMatch && $this->matchesArray($value, $entryValue);
            } else {
                $isMatch = $isMatch && $value === $entryValue;
            }
        }

        return $isMatch;
    }
}
