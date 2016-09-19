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

namespace EmberDb\Filter\Operator;

class ElementMatch extends AbstractOperator
{
    public function matches($value)
    {
        // $value has to be an indexed array
        if ($this->isList($value)) {
            $isMatch = false;
            foreach ($value as $listElement) {
                $isMatch |= $this->matchesListElement($listElement);
            }

        } else {
            $isMatch = false;
        }


        return $isMatch;
    }



    public function isValid()
    {
        $isValid = $this->isNumber($this->operand);

        return $isValid;
    }



    private function matchesListElement($listElement)
    {
        $isMatch = $this->operand === $listElement;

        return $isMatch;
    }



    private function isList($array)
    {
        $isList = array() === $array || array_keys($array) === range(0, count($array) - 1);

        return $isList;
    }
}
