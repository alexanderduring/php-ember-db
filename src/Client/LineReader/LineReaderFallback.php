<?php

namespace EmberDb\Client\LineReader;

class LineReaderFallback
{
    private $prompt = '';



    public function __construct($prompt)
    {
        $this->prompt = $prompt;
    }



    public function readline()
    {
        echo $this->prompt;
        $inputLine = trim(fgets(STDIN));

        return $inputLine;
    }
}