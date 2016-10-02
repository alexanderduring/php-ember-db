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

use EmberDb\Logger;

class Filter
{
    private $filterData = array();



    public function __construct(array $filterArray)
    {
        $this->filterData = $filterArray;
    }



    public function matchesEntry(array $entry)
    {
        $isMatch = $this->matchesDocument($this->filterData, $entry);

        return $isMatch;
    }



    private function matchesDocument(array $filterArray, array $entryArray)
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

        // If both are a scalar ...
        if ($this->isScalar($filterValue) && $this->isScalar($entryValue)) {
            Logger::log("query:" . $filterValue . " and entry:" . $entryValue . " are both scalars.\n");
            $isMatch = $filterValue === $entryValue;
        }
        // If both are a list ...
        if ($this->isList($filterValue) && $this->isList($entryValue)) {
            Logger::log("query:" . json_encode($filterValue) . " and entry:" . json_encode($entryValue) . " are both lists.\n");
            $isMatch = $filterValue === $entryValue;
        }

        // If both are a document ...
        if ($this->isDocument($filterValue) && $this->isDocument($entryValue)) {
            Logger::log("query:" . json_encode($filterValue) . " and entry:" . json_encode($entryValue) . " are both documents.\n");

            // If filter is an operator ...
            if ($this->isOperator($filterValue)) {
                Logger::log("Is operator\n");
                $operatorManager = new OperatorManager();
                $operator = $operatorManager->buildOperator($filterValue);
                $isMatch = $operator->matches($entryValue);
            } else {
                $isMatch = $this->matchesDocument($filterValue, $entryValue);
            }
        }


        return $isMatch;
    }



    private function isList($array)
    {
        $isList = is_array($array) && (array() === $array || array_keys($array) === range(0, count($array) - 1));

        return $isList;
    }



    private function isDocument($array)
    {
        $isDocument = is_array($array) && !$this->isList($array);

        return $isDocument;
    }



    private function isScalar($scalar)
    {
        $isScalar = !is_array($scalar);

        return $isScalar;
    }



    private function isOperator($array)
    {
        if ($this->isDocument($array)) {
            $firstKey = array_keys($array)[0];
            $isOperator = strpos($firstKey, '$') === 0;
        } else {
            $isOperator = false;
        }

        return $isOperator;
    }
}
