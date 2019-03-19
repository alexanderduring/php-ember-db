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

namespace EmberDb;

use EmberDb\Collection\Collection;

/**
 * The class DocumentManager is responsible for acting as an interface to the database.
 */
class DocumentManager
{
    private $config = array();

    private $collections = [];



    public function getDatabasePath()
    {
        try {
            if (!array_key_exists('database', $this->config)) throw new Exception('The config has no entry with key "database".');
            if (!array_key_exists('path', $this->config['database'])) throw new Exception('The config has no entry with key "database/path".');
        }
        catch (Exception $exception) {
            throw new Exception('Missing config: '.$exception->getMessage());
        }

        return $this->config['database']['path'];
    }



    public function setDatabasePath($path)
    {
        $this->config['database']['path'] = $path;
    }



    public function insert($collectionName, Document $document)
    {
        $collection = $this->getCollection($collectionName);
        $collection->insert($document);
    }



    public function insertMany($collectionName, $documents)
    {
        $collection = $this->getCollection($collectionName);
        $collection->insertMany($documents);
    }



    /**
     * @param string $collectionName
     * @param array $filter
     * @return Document[]
     */
    public function find(string $collectionName, array $filter = array()): array
    {
        return $this->getCollection($collectionName)->find($filter);
    }



    public function remove($collectionName)
    {
        $this->getCollection($collectionName)->remove();
    }



    private function getCollection(string $collectionName): Collection
    {
        if (!array_key_exists($collectionName, $this->collections)) {
            $collection = new Collection($collectionName, $this->getDatabasePath());
            $this->collections[$collectionName] = $collection;
        }

        return $this->collections[$collectionName];
    }
}
