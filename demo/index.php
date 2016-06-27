<?php

namespace EmberDb;

require_once __DIR__.'/../src/DocumentManager.php';

$config = array(
    'database' => array(
        'path' => __DIR__
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

$anotherCar = array(
    'license-number' => 'HH-EE 1822',
    'manufacturer' => 'Fiat',
    'model' => 'Punto',
    'color' => 'yellow'
);

$documentManager = new DocumentManager($config);
$documentManager->insert('cars', $car);
$documentManager->insert('cars', $anotherCar);

