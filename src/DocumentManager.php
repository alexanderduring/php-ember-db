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
        echo "Inserting entry into ".$collectionName.".\n";

        // Open or create file
        $collectionFilePath = $this->getDatabasePath().'/'.$collectionName.'.edb';
        $collectionFileHandle = fopen($collectionFilePath, 'a');

        // Add entry to end of file
        fwrite($collectionFileHandle, json_encode($document)."\n");
        fclose($collectionFileHandle);
    }


    private function getDatabasePath()
    {
        return $this->config['database']['path'];
    }
}