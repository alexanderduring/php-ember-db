<?php

use EmberDb\DocumentManager;
use EmberDb\Interpreter;

require_once __DIR__ . '/../src/EmberDb/Document.php';
require_once __DIR__ . '/../src/EmberDb/DocumentManager.php';
require_once __DIR__ . '/../src/EmberDb/Interpreter.php';

// command line options
$longopts = array(
    "directory::"
);
$options = getopt('', $longopts);

// working directory
$workingDirectory = array_key_exists('directory', $options) ? $options['directory'] : '.';
if ($workingDirectory[0] != '/') {
    $workingDirectory = './'.$workingDirectory;
}
$workingDirectory = realpath($workingDirectory);
echo 'Working directory: '.$workingDirectory."\n";

// Setup DocumentManager
$config = array('database' => array('path' => $workingDirectory));
$documentManager = new DocumentManager($config);

// Set up Interpreter
$inputStream = fopen('php://stdin', 'r');
$quit = false;
$interpreter = new Interpreter();
$interpreter->injectDocumentManager($documentManager);

echo "\nEmberDb command line client.\n";
echo "Type your command followed by <return>. Type 'help' to get a command overview or 'exit' to leave the client.\n\n";

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
