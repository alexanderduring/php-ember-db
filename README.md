[![License](https://poser.pugx.org/alexanderduring/ember-db/license)](https://packagist.org/packages/alexanderduring/ember-db)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alexanderduring/php-ember-db/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alexanderduring/php-ember-db/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/alexanderduring/php-ember-db/badges/build.png?b=master)](https://scrutinizer-ci.com/g/alexanderduring/php-ember-db/build-status/master) 
[![Total Downloads](https://poser.pugx.org/alexanderduring/ember-db/downloads)](https://packagist.org/packages/alexanderduring/ember-db)
[![Latest Stable Version](https://poser.pugx.org/alexanderduring/ember-db/v/stable)](https://packagist.org/packages/alexanderduring/ember-db)
[![Latest Unstable Version](https://poser.pugx.org/alexanderduring/ember-db/v/unstable)](https://packagist.org/packages/alexanderduring/ember-db)

# Ember DB



EmberDb is planned to be a light, embeddable implementation of a document based database
for php projects. 

## Overview

The project consists of two parts:

- the library that you need to embed in your application
- a command line client to directly access your database.

## Usage

Via composer:

```
$ composer require alexanderduring/ember-db
```

## Demo

To try it out just clone the repository and in the project home type

```
$ php demo/index.php
```

You will see some example output of creating a collection, inserting documents und querying for documents.
There is also a command line client which you can start with

```
$ bin/ember-db --directory=demo/data
```

## Features

### Setting up the database

To set up the database, you need to tell the documentManager where he should store and search for database files (*.edb).

```php
$documentManager = new DocumentManager();
$documentManager->setDatabasePath(__DIR__.'/data');
```

### Create a collection

To create a collection just insert a document into it.

### Remove a collection

To remove the entire 'cars' collection:

```php
$documentManager->remove('cars');
```

### Insert documents

To insert a document into a collection:

```php
// Set up database
$documentManager = new DocumentManager();
$documentManager->setDatabasePath(__DIR__.'/data');

$car = [
    'license-number' => 'HH-DS 1243',
    'manufacturer' => 'BMW',
    'model' => '325i'
];

// Add an entry to the collection
$documentManager->insert('cars', $car);
```

To insert multiple documents into a collection:

```php
$cars = [
    ['manufacturer' => 'BMW', 'model' => '325i', 'color' => 'blue'],
    ['manufacturer' => 'VW', 'model' => 'Golf', 'color' => 'yellow'],
    ['manufacturer' => 'Fiat', 'model' => 'Punto', 'color' => 'blue']
];
$documentManager->insertMany('cars', $cars);
```
### Remove documents

-not implemented yet-

### Query documents

To select all documents in the collection 'cars':

```php
$documents = $documentManager->find('cars');
```

To select all cars, that have a blue color:

```php
$filter = ['color' => 'blue'];
$documents = $documentManager->find('cars', $filter);
```

### Filters

The implementation of filters in Ember Db is inspired by the query operators used in [BSON/MongoDB](https://docs.mongodb.com/).

These filter operators are currently available:

- $gt (greater than)
- $gte (greater than or equal)
- $lt (lower than)
- $lte (lower than or equal)
- $ne (not equal)
- $elementMatch (matches at least one element in an array)

#### Examples

Query for all cars with more than 36 kw engine power:

```php
$filter = ['engine' => [
    'powerInKw' => ['$gt' => 36]
]];
$documents = $documentManager->find('cars', $filter);
```

Query for all cars with a manufacturer other than Fiat:

```php
$filter = ['manufacturer' => ['$ne' => 'Fiat']];
$documents = $documentManager->find('cars', $filter);
```


## Implemetation Brainstorming

There will probably be a "Manager" class as the unique access point to the database.
A decision has to be made, if this class should return a document as an array or 
as an object.



### Arrays

#### Advantages

  - An array has no methods, so there is no possibility to add business logic into the row object.
    There is a stronger need to implement such classes in the domain model layer.

### Objects

#### Advantages

  - The implementation of accessor methods provides hooks that could execute things on every set/get event.
  - Because of the unstructured nature of documents some of them could have an entry "foo" and some may not.
    In order to check this, you would need to do several calls to array_key_exists to walk to the structure
    of the document. Having an document object providing helper methods to easily achieve this task is an 
    advantage.

```php
class document
{
    private $data;



    public __construct($jsonData = null)
    {
        $this->data = is_null($jsonData) ? array() : json_decode($jsonData, true);
    }



    public function has($path)
    {
        // Check if array key decribed by $path exists.
    }



    public function get($path)
    {
        // Return array value indexed by array key decribed by $path.
    }



    public function toJson()
    {
        return json_encode($this->data);
    }
}
```

