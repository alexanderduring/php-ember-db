<?php

use EmberDb\Client\Client;
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

// Check readline support
if (!function_exists('readline')) {
    echo "Your PHP distribution has no readline support. Some feature like line editing and history will be unavailable.\n\n";
    $lineReader = new LineReaderFallback('$ ');
} else {
    $lineReader = new LineReader('$ ');
}

$client = new Client();
$client->injectInterpreter($interpreter);
$client->injectLineReader($lineReader);

$client->start();