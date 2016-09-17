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

class OperatorManager
{
    public function isOperator($filterValue)
    {
        $operator = $this->getOperator($filterValue);
        $isOperator = in_array($operator, array('$gt', '$gte', '$lt', '$lte', '$ne'));

        return $isOperator;
    }



    public function createOperator($operatorArray)
    {
//        switch ($this->operator) {
//            case '$gt':
//                $isMatch = $this->isNumber($value) && $value > $this->operand;
//                break;
//            case '$gte':
//                $isMatch = $this->isNumber($value) && $value >= $this->operand;
//                break;
//            case '$lt':
//                $isMatch = $this->isNumber($value) && $value < $this->operand;
//                break;
//            case '$lte':
//                $isMatch = $this->isNumber($value) && $value <= $this->operand;
//                break;
//            case '$ne':
//                $isMatch = $value !== $this->operand;
//                break;
//            default:
//                $isMatch = false;
//
//        }

        $operator = new Operator($operatorArray);

        return $operator;
    }



    private function getOperator($operatorArray)
    {
        if (is_array($operatorArray) && count($operatorArray) == 1) {
            $operator = array_keys($operatorArray)[0];
            $operand = $operatorArray[$operator];
        } else {
            $operator = null;
        }

        return $operator;
    }



    private function getOperand($operatorArray)
    {
        if (is_array($operatorArray) && count($operatorArray) == 1) {
            $operand = $operatorArray[$this->getOperator()];
        }

        return $operand;
    }

}
