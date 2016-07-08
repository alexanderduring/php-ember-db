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
        $isMatch = true;
        foreach ($this->filterData as $key => $value) {
            $isMatch = array_key_exists($key, $entry) && $entry[$key] == $value && $isMatch;
        }

        return $isMatch;
    }
}
