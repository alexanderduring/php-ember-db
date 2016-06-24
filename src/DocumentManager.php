<?php

namespace EmberDb;

class DocumentManager
{
    private $config;



    public function __construct($config = array())
    {
        $this->config = $config;
    }



    public function insert($collection, $document)
    {
        echo "Inserting entry into ".$collection.".\n";
    }
}