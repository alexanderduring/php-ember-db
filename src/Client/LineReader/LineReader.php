<?php

namespace EmberDb\Client\LineReader;

class LineReader
{
    private $prompt = '';



    public function __construct($prompt)
    {
        $this->prompt = $prompt;
    }



    public function readline()
    {
        $inputLine = trim(readline($this->prompt));
        readline_add_history($inputLine);

        return $inputLine;
    }
}