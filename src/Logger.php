<?php

namespace EmberDb;

class Logger
{
    static private $instance = null;

    public $logFile;



    static public function log($text)
    {
        file_put_contents(self::$instance->logFile, $text, FILE_APPEND);
    }



    static public function setup($path)
    {
        self::$instance = new self($path);
    }



    private function __construct($path)
    {
        $this->logFile = $path;
    }
}