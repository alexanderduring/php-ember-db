<?php

namespace EmberDb;

class Document
{
    private $data;


    public function __construct($jsonData = null)
    {
        $this->data = is_null($jsonData) ? array() : json_decode($jsonData, true);
    }



    public function toJson()
    {
        return json_encode($this->data);
    }
}
