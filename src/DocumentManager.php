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

use EmberDb\Filter\Filter;

/**
 * The class DocumentManager is responsible for acting as an interface to the database.
 */
class DocumentManager
{
    private $config = array();



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



    public function insert($collectionName, $document)
    {
        $this->writeEntries($collectionName, array($document));
    }



    public function insertMany($collectionName, $documents)
    {
        $this->writeEntries($collectionName, $documents);
    }



    /**
     * @param string $collectionName
     * @param array $filter
     * @return Document[]
     */
    public function find($collectionName, $filter = array())
    {
        $documents = array();

        $entries = $this->readEntries($collectionName, $filter);
        foreach ($entries as $entry) {
            $documents[] = new Document($entry);
        }

        return $documents;
    }



    public function remove($collectionName)
    {
        $filePath = $this->getCollectionFilePath($collectionName);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }



    private function readEntries($collectionName, $filterArray)
    {
        $entries = array();

        $filter = new Filter($filterArray);

        // Open file for reading
        $collectionFilePath = $this->getCollectionFilePath($collectionName);
        $file = fopen($collectionFilePath, 'r');

        // Read file line by line
        while (($buffer = fgets($file)) !== false) {
            $entry = json_decode(trim($buffer), true);
            // Match entry against filter
            if ($filter->matchesEntry($entry)) {
                $entries[] = $entry;
            }
        }

        if (!feof($file)) {
            throw new Exception('File pointer does not point to end of file.');
        }

        // Close file
        fclose($file);

        return $entries;
    }



    private function writeEntries($collectionName, $documents)
    {
        // Open or create file for writing
        $collectionFilePath = $this->getCollectionFilePath($collectionName);
        $collectionFileHandle = fopen($collectionFilePath, 'a');

        // Add entries to end of file
        foreach ($documents as $document) {
            fwrite($collectionFileHandle, json_encode($document)."\n");
        }

        // Close file
        fclose($collectionFileHandle);
    }



    private function getCollectionFilePath($collectionName)
    {
        return $this->getDatabasePath().'/'.$collectionName.'.edb';
    }
}
