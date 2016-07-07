<?php

use EmberDb\Client\Interpreter;
use EmberDb\Client\Options;
use EmberDb\DocumentManager;

require_once __DIR__ . '/../vendor/autoload.php';

$options = new Options();
echo 'Working directory: '.$options->workingDirectory."\n";

// Setup DocumentManager
$config = array('database' => array('path' => $options->workingDirectory));
$documentManager = new DocumentManager($config);

// Set up Interpreter
$inputStream = fopen('php://stdin', 'r');
$interpreter = new Interpreter();
$interpreter->injectDocumentManager($documentManager);

echo "\nEmberDb command line client.\n";
echo "Type your command followed by <return>. Type 'help' to get a command overview or 'exit' to leave the client.\n\n";

// Start command input loop
$quit = false;
while (!$quit) {
    echo '> ';
    $inputLine = trim(fgets($inputStream));
    if ($inputLine == 'exit') {
        $quit = true;
        $output = "Closing EmberDb command line client.\n\n";
    } else {
        $output = $interpreter->execute($inputLine);
    }

    echo $output;
}
