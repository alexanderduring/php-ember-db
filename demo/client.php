<?php

use EmberDb\Interpreter;

require_once __DIR__ . '/../src/EmberDb/Document.php';
require_once __DIR__ . '/../src/EmberDb/DocumentManager.php';
require_once __DIR__ . '/../src/EmberDb/Interpreter.php';

$interpreter = new Interpreter();

echo "\nEmberDb command line client.\n";
echo "Type your command followed by <return>. Type 'help' to get a command overview or 'exit' to leave the client.\n\n";

$longopts = array(
    "directory::"
);
$options = getopt('', $longopts);

$workingDirectory = array_key_exists('directory', $options) ? './'.$options['directory'] : '.';
echo 'Working directory: '.$workingDirectory."\n";

$inputStream = fopen('php://stdin', 'r');
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
