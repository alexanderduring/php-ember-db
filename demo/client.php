<?php

use EmberDb\Client\Client;
use EmberDb\Client\Interpreter;
use EmberDb\Client\LineReader\LineReader;
use EmberDb\Client\LineReader\LineReaderFallback;
use EmberDb\ServiceLocator;

require_once __DIR__ . '/../vendor/autoload.php';

$serviceLocator = new ServiceLocator();

$options = $serviceLocator->getOptions();
echo 'Working directory: '.$options->workingDirectory."\n";

// Setup DocumentManager
$documentManager = $serviceLocator->getDocumentManager();
$documentManager->setDatabasePath($options->workingDirectory);

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