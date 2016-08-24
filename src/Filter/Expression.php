<?php

namespace EmberDb\Filter;

class Expression
{
    private $operator;
    private $operand;



    public function __construct($expression)
    {
        if (is_array($expression) && count($expression) == 1) {
            $this->operator = array_keys($expression)[0];
            $this->operand = $expression[$this->operator];
        }
    }



    public function matches($value)
    {
        switch ($this->operator) {
            case '$gt':
                $isMatch = $this->isNumber($value) && $value > $this->operand;
                break;
            case '$gte':
                $isMatch = $this->isNumber($value) && $value >= $this->operand;
                break;
            case '$lt':
                $isMatch = $this->isNumber($value) && $value < $this->operand;
                break;
            case '$lte':
                $isMatch = $this->isNumber($value) && $value <= $this->operand;
                break;
            case '$ne':
                $isMatch = $value !== $this->operand;
                break;
        }

        return $isMatch;
    }



    public function isValid()
    {
        switch ($this->operator) {
            case '$gt':
            case '$gte':
            case '$lt':
            case '$lte':
                $isValid = $this->isNumber($this->operand);
                break;
            case '$ne':
                $isValid = true;
                break;
            default:
                $isValid = false;
        }

        return $isValid;
    }



    private function isNumber($variable)
    {
        $isNumber = is_int($variable) || is_float($variable);

        return $isNumber;
    }
}
