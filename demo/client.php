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
        $message = $next_line;
        $command = explode(' ', $message);
        print_r($command);
    }
}
