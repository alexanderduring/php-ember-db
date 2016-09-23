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

use EmberDb\Filter\Operator\ElemMatch;
use EmberDb\Filter\Operator\GreaterThan;
use EmberDb\Filter\Operator\GreaterThanEqual;
use EmberDb\Filter\Operator\LowerThan;
use EmberDb\Filter\Operator\LowerThanEqual;
use EmberDb\Filter\Operator\NotEqual;

class OperatorManager
{
    public function isOperator($operatorArray)
    {
        $operator = $this->getOperator($operatorArray);
        $isOperator = in_array($operator, array('$gt', '$gte', '$lt', '$lte', '$ne', '$elemMatch'));

        return $isOperator;
    }



    public function buildOperator($operatorArray)
    {
        switch ($this->getOperator($operatorArray)) {
            case '$gt':
                $operator = new GreaterThan($this->getOperand($operatorArray));
                break;
            case '$gte':
                $operator = new GreaterThanEqual($this->getOperand($operatorArray));
                break;
            case '$lt':
                $operator = new LowerThan($this->getOperand($operatorArray));
                break;
            case '$lte':
                $operator = new LowerThanEqual($this->getOperand($operatorArray));
                break;
            case '$ne':
                $operator = new NotEqual($this->getOperand($operatorArray));
                break;
            case '$elemMatch':
                $operator = new ElemMatch($this->getOperand($operatorArray));
                break;
            default:
                $operator = null;
        }

        return $operator;
    }



    private function getOperator($operatorArray)
    {
        if (is_array($operatorArray) && count($operatorArray) == 1) {
            $operator = array_keys($operatorArray)[0];
        } else {
            $operator = null;
        }

        return $operator;
    }



    private function getOperand($operatorArray)
    {
        if (is_array($operatorArray) && count($operatorArray) == 1) {
            $operand = $operatorArray[$this->getOperator($operatorArray)];
        } else {
            $operand = null;
        }

        return $operand;
    }

}
