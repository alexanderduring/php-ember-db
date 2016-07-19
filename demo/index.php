<?php

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
        )
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
        )
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

echo "\n";