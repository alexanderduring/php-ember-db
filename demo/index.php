<?php

namespace EmberDb;

require_once '../src/DocumentManager.php';

$config = array(
    'database' => array(
        'path' => '../demo'
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

$documentManager = new DocumentManager($config);
$documentManager->insert('cars', $car);

