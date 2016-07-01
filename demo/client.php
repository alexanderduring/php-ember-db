<?php

use EmberDb\DocumentManager;

require_once __DIR__ . '/../src/EmberDb/Document.php';
require_once __DIR__ . '/../src/EmberDb/DocumentManager.php';

echo "\nEmberDb command line client.\nType your command followed by <return>. Type 'help' to get a command overview or 'exit' to leave the client.\n\n";

$inputStream = fopen('php://stdin', 'r');
$quit = false;

while (!$quit) {
    echo '> ';
    $inputLine = fgets($inputStream);
    $tokens = explode(' ', trim($inputLine));
    $command = array_shift($tokens);
    $parameters = $tokens;
    print_r($tokens);

    switch ($command) {
        case 'insert':
            $collection = $parameters[0];
            $document = $parameters[1];
            echo "You want to insert $document in the $collection collection.\n\n";
            break;
        case 'find':
            $collection = $parameters[0];
            $filter = $parameters[1];
            echo "You want to find something in the $collection collection that matches $filter.\n\n";
            break;
        case 'exit':
            $quit = true;
            echo "Closing EmberDb command line client.\n\n";
            break;
        default:
            echo "Syntax error: Unknown command '".$command."'.\n\n";
    }
}
