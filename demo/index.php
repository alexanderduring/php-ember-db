<?php

use EmberDb\DocumentManager;

require_once __DIR__ . '/../vendor/autoload.php';

$config = array(
    'database' => array(
        'path' => __DIR__.'/data'
    ),
    'collections' => array(
        'cars'
    )
);

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
        'color' => 'yellow'
    ),
    array(
        'manufacturer' => 'Fiat',
        'model' => 'Uno',
        'color' => 'blue'
    ),
    array(
        'license-number' => 'B-SD 456',
        'manufacturer' => 'VW',
        'model' => 'Golf',
        'color' => 'blue'
    )
);

$documentManager = new DocumentManager($config);

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