<?php
/**
 * Ember Db - An embeddable document database for php.
 * Copyright (C) 2016 Alexander During
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @link      http://github.com/alexanderduring/php-ember-db
 * @copyright Copyright (C) 2016 Alexander During
 * @license   http://www.gnu.org/licenses GNU General Public License v3.0
 */

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