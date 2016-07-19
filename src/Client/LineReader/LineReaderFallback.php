<?php

namespace EmberDb\Client\LineReader;

/**
 * The class LineReaderFallback is responsible for reading input lines
 * using the fgets command.
 */
class LineReaderFallback implements LineReaderInterface
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