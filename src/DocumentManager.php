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
        $this->writeLines($collectionName, array($document));
    }



    public function insertMany($collectionName, $documents)
    {
        $this->writeLines($collectionName, $documents);
    }



    public function find($collectionName, $filter)
    {
        return $this->readLines($collectionName, $filter);
    }



    private function readLines($collectionName, $filter)
    {
        $lines = array();

        // Open file for reading
        $collectionFilePath = $this->getDatabasePath().'/'.$collectionName.'.edb';
        $file = fopen($collectionFilePath, 'r');

        // Read file line by line
        while (($buffer = fgets($file)) !== false) {
            $lines[] = trim($buffer);
        }

        if (!feof($file)) {
            throw new Exception('File pointer does not point to end of file.');
        }

        // Close file
        fclose($file);

        return $lines;
    }



    private function writeLines($collectionName, $documents)
    {
        // Open or create file for writing
        $collectionFilePath = $this->getDatabasePath().'/'.$collectionName.'.edb';
        $collectionFileHandle = fopen($collectionFilePath, 'a');

        // Add entries to end of file
        foreach ($documents as $document) {
            fwrite($collectionFileHandle, json_encode($document)."\n");
        }

        // Close file
        fclose($collectionFileHandle);
    }



    private function getDatabasePath()
    {
        return $this->config['database']['path'];
    }
}
