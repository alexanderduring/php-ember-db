<?php

namespace EmberDb;

class Interpreter
{
    public function execute($inputLine)
    {
        $output = '';

        $tokens = explode(' ', $inputLine);
        $command = array_shift($tokens);
        $parameters = $tokens;
        print_r($tokens);
        switch ($command) {
            case 'insert':
                $collection = $parameters[0];
                $document = $parameters[1];
                $output .= "You want to insert $document in the $collection collection.\n\n";
                break;
            case 'find':
                $collection = $parameters[0];
                $filter = $parameters[1];
                $output .= "You want to find something in the $collection collection that matches $filter.\n\n";
                break;
            default:
                $output .= "Syntax error: Unknown command '".$command."'.\n\n";
        }

        return $output;
    }
}
