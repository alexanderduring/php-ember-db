<?php

use EmberDb\DocumentManager;

require_once __DIR__ . '/../src/EmberDb/Document.php';
require_once __DIR__ . '/../src/EmberDb/DocumentManager.php';

print "Type your commands. Type 'quit' on a line by itself when you're done.\n";

$fp = fopen('php://stdin', 'r');
$quit = false;
$message = '';
while (!$quit) {
    $next_line = fgets($fp, 1024); // read the special file to get the user input from keyboard
    if ("quit\n" == $next_line) {
        $quit = true;
    } else {
        $message = trim($next_line);
        $command = explode(' ', $message);
        print_r($command);

        switch ($command[0]) {
            case 'insert':
                $collection = $command[1];
                $document = $command[2];
                echo "You want to insert $document in the $collection collection.\n";
                break;
            case 'find':
                $collection = $command[1];
                $filter = $command[2];
                echo "You want to find something in the $command[1] collection that matches $filter.\n";
                break;
            default:
                echo "Syntax error: Unknown command '".$command[0]."'.\n";
        }
    }
}
