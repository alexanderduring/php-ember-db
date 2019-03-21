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

declare(strict_types=1);

namespace EmberDb\Collection;

use EmberDb\Document;
use EmberDb\Exception;
use EmberDb\Filter\Filter;
use EmberDb\Logger;

class Collection
{
    /** @var MetaData */
    private $metaData;

    /** @var string */
    private $name;

    /** @var string */
    private $path;



    public function __construct(string $name, string $path)
    {
        $this->name = $name;
        $this->path = $path;
        $this->metaData = new MetaData($path . '/' . $name . 'meta.edb');
    }



    public function insert(Document $document)
    {
        $this->insertEntries(array($document));
    }



    public function insertMany($documents)
    {
        $this->insertEntries($documents);
    }



    public function find(Filter $filter): array
    {
        $documents = [];

        $entries = $this->readEntries($filter);
        foreach ($entries as $entry) {
            $documents[] = new Document($entry);
        }

        return $documents;
    }



    public function remove()
    {
        $filePath = $this->getCollectionFilePath();
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }



    private function readEntries(Filter $filter)
    {
        $entries = array();

        try {
            // Open file for reading
            $collectionFilePath = $this->getCollectionFilePath();
            $file = fopen($collectionFilePath, 'r');

            $lockAquired = $this->aquireReadLock($file);
            if (!$lockAquired) {
                throw new Exception('Lock wait timeout.');
            }
            Logger::log("Read lock aquired on $collectionFilePath.\n");

            // Read file line by line
            while (($buffer = fgets($file)) !== false) {
                $entry = json_decode(trim($buffer), true);
                // Match entry against filter
                if ($filter->matchesEntry($entry)) {
                    $entries[] = $entry;
                }
            }

            // Close file
            fclose($file);

        } catch (Exception $exception) {
            Logger::log($exception->getMessage());
        }


        return $entries;
    }



    private function insertEntries($documents)
    {
        // Open or create file for writing
        $collectionFilePath = $this->getCollectionFilePath();
        $collectionFileHandle = fopen($collectionFilePath, 'a');

        // Add entries to end of file
        foreach ($documents as $document) {
            $document->setId($this->createId());
            fwrite($collectionFileHandle, json_encode($document)."\n");
        }

        // Close file
        fclose($collectionFileHandle);
    }



    private function removeEntries(array $filterArray)
    {
        // Do the same like readEntries does, but copy all non matching
        // entries into new file and remove the old one.
    }




    private function getCollectionFilePath()
    {
        return $this->path . '/' . $this->name . '.edb';
    }



    private function createId(): string
    {
        return $id = time() . '-' . mt_rand(1000, 9999);
    }



    private function aquireReadLock($file)
    {
        $lockAquired = flock($file, LOCK_SH | LOCK_NB);

        if (!$lockAquired) {
            $deadline = time() + 1 * 60; // 1 minute
            while (!$lockAquired && time() < $deadline) {
                sleep(1);
                $lockAquired = flock($file, LOCK_SH | LOCK_NB);
            }
        }

        return $lockAquired;
    }
}
