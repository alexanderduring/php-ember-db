<?php

use EmberDb\DocumentManager;

require_once __DIR__ . '/../src/EmberDb/Document.php';
require_once __DIR__ . '/../src/EmberDb/DocumentManager.php';

echo "\nEmberDb command line client.\nType your command followed by <return>. Type 'help' to get a command overview or 'quit' to leave the client.\n\n";

$inputStream = fopen('php://stdin', 'r');
$quit = false;

while (!$quit) {
    echo '> ';
    $inputLine = fgets($inputStream);
    $command = explode(' ', trim($inputLine));
    print_r($command);

    switch ($command[0]) {
        case 'insert':
            $collection = $command[1];
            $document = $command[2];
            echo "You want to insert $document in the $collection collection.\n\n";
            break;
        case 'find':
            $collection = $command[1];
            $filter = $command[2];
            echo "You want to find something in the $command[1] collection that matches $filter.\n\n";
            break;
        case 'quit':
            $quit = true;
            echo "Closing EmberDb command line client.\n\n";
            break;
        default:
            echo "Syntax error: Unknown command '".$command[0]."'.\n\n";
    }
}
