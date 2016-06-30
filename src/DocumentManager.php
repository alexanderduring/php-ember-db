<?php

namespace EmberDb;

class DocumentManager
{
    private $config;



    public function __construct($config = array())
    {
        $this->config = $config;
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



    private function readEntries($collectionName, $filter)
    {
        $entries = array();

        // Open file for reading
        $collectionFilePath = $this->getCollectionFilePath($collectionName);
        $file = fopen($collectionFilePath, 'r');

        // Read file line by line
        while (($buffer = fgets($file)) !== false) {
            $entry = json_decode(trim($buffer), true);
            // Match entry against filter
            if ($this->matchesFilter($entry, $filter)) {
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



    private function matchesFilter($entry, $filter)
    {
        $isMatch = true;
        foreach ($filter as $key => $value) {
            $isMatch = array_key_exists($key, $entry) && $entry[$key] == $value && $isMatch;
        }

        return $isMatch;
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



    private function getDatabasePath()
    {
        return $this->config['database']['path'];
    }
}
