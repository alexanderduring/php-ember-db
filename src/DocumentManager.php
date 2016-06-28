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
    
    

    private function writeLines($collectionName, $documents)
    {
        // Open or create file
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