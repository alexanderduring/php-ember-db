<?php

namespace EmberDb;

class Document
{
    private $data;


    public function __construct($data = array())
    {
        $this->data = $data;
    }



    public function toJson()
    {
        return json_encode($this->data);
    }
}
