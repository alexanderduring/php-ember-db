<?php

namespace EmberDb\Filter;

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

        // If both aren't ...
        if (!is_array($filterValue) && !is_array($entryValue)) {
            $isMatch = $filterValue === $entryValue;
        }

        // If filter is an expression and entry value is no array ...
        if ($this->isExpression($filterValue) && !is_array($entryValue)) {
            $isMatch = $this->matchesExpression($filterValue, $entryValue);
        }

        return $isMatch;
    }



    private function matchesExpression($expressionArray, $entryValue)
    {
        $expression = new Expression($expressionArray);
        $isMatch = $expression->matches($entryValue);

        return $isMatch;
    }



    private function isExpression($value)
    {
        $expression = new Expression($value);
        $isExpression = $expression->isValid();

        return $isExpression;
    }
}
