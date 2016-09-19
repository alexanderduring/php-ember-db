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

use EmberDb\DocumentManager;

require_once __DIR__ . '/../vendor/autoload.php';

$car = array(
    'license-number' => 'HH-DS 1243',
    'manufacturer' => 'BMW',
    'model' => '325i'
);

$someCars = array(
    array(
        'license-number' => 'HH-EE 1822',
        'manufacturer' => 'Fiat',
        'model' => 'Punto',
        'year' => 1993,
        'color' => 'yellow',
        'engine' => array(
            'powerInKw' => 40,
            'displacementInLiters' => 1.1
        ),
        'editions' => array('Active', 'Dynamic', 'Emotion', 'Sport', 'Cabriolet')
    ),
    array(
        'manufacturer' => 'Fiat',
        'model' => 'Uno',
        'year' => 1983,
        'color' => 'blue',
        'engine' => array(
            'powerInKw' => 32,
            'displacementInLiters' => 0.9
        )
    ),
    array(
        'license-number' => 'B-SD 456',
        'manufacturer' => 'VW',
        'model' => 'Golf',
        'year' => 1974,
        'color' => 'blue',
        'engine' => array(
            'powerInKw' => 37,
            'displacementInLiters' => 1.1
        ),
        'editions' => array('City', 'Country', 'Gti', 'Cabriolet')
    )
);

$documentManager = new DocumentManager();
$documentManager->setDatabasePath(__DIR__.'/data');

// Remove existing collection (from last run of this script)
$documentManager->remove('cars');

// Add some entries to the collection
$documentManager->insert('cars', $car);
$documentManager->insertMany('cars', $someCars);

// Query the collection and output the result
$documents = $documentManager->find('cars');
echo "\nAll cars in the collection:\n";
foreach ($documents as $document) {
    echo $document->toJson()."\n";
}

// Query the collection and output the result
$documents = $documentManager->find('cars', array('color' => 'blue'));
echo "\nAll blue cars in the collection:\n";

foreach ($documents as $document) {
    echo $document->toJson()."\n";
}

foreach ($documents as $document) {
    echo $document->get('manufacturer')." with ".$document->get('engine.powerInKw')." kw.\n";
}

echo "\n";