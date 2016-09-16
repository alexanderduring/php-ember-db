<?php
/**
 * Ember Db - An embeddable document database for php.
 * Copyright (C) 2016 Alexander During
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @link      http://github.com/alexanderduring/php-ember-db
 * @copyright Copyright (C) 2016 Alexander During
 * @license   http://www.gnu.org/licenses GNU General Public License v3.0
 */

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
        if ($this->isExpression($filterValue)) {
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
