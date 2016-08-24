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
                $isMatch = $value > $this->operand;
                break;
        }

        return $isMatch;
    }



    public function isValid()
    {
        $isValid = in_array($this->operator, array('$gt', '$lt'));

        return $isValid;
    }
}
