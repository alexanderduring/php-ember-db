<?php

use EmberDb\Client\Interpreter;
use EmberDb\Client\Options;
use EmberDb\DocumentManager;
use EmberDb\Client\LineReader\LineReader;
use EmberDb\Client\LineReader\LineReaderFallback;

require_once __DIR__ . '/../vendor/autoload.php';


$options = new Options();
echo 'Working directory: '.$options->workingDirectory."\n";

// Setup DocumentManager
$config = array('database' => array('path' => $options->workingDirectory));
$documentManager = new DocumentManager($config);

// Set up Interpreter
$interpreter = new Interpreter();
$interpreter->injectDocumentManager($documentManager);

echo "\nEmberDb command line client.\n";
echo "Type your command followed by <return>. Type 'help' to get a command overview or 'exit' to leave the client.\n\n";

// Check readline support
if (!function_exists('readline')) {
    echo "Your PHP distribution has no readline support. Some feature like line editing and history will be unavailable.\n\n";
    $lineReader = new LineReaderFallback('$ ');
} else {
    $lineReader = new LineReader('$ ');
}

// Start command input loop
$quit = false;
while (!$quit) {
    $inputLine = $lineReader->readline();
    if ($inputLine == 'exit') {
        $quit = true;
        $output = "Closing EmberDb command line client.\n\n";
    } else {
        $output = $interpreter->execute($inputLine);
    }

    echo $output;
}
