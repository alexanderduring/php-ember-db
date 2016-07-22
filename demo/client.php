<?php

use EmberDb\Client\Client;
use EmberDb\Client\LineReader\LineReader;
use EmberDb\Client\LineReader\LineReaderFallback;
use EmberDb\Client\Parser\Parser;
use EmberDb\Client\ServiceLocator;

require_once __DIR__ . '/../vendor/autoload.php';

$serviceLocator = new ServiceLocator();

$options = $serviceLocator->getOptions();
echo 'Working directory: '.$options->workingDirectory."\n";

// Setup DocumentManager
$documentManager = $serviceLocator->getDocumentManager();
$documentManager->setDatabasePath($options->workingDirectory);

// Set up Interpreter
$parser = new Parser();
$parser->injectDocumentManager($documentManager);

// Check readline support
if (!function_exists('readline')) {
    echo "Your PHP distribution has no readline support. Some feature like line editing and history will be unavailable.\n\n";
    $lineReader = new LineReaderFallback('$ ');
} else {
    $lineReader = new LineReader('$ ');
}

$client = Client::create();
$client->injectParser($parser);
$client->injectLineReader($lineReader);

$client->start();