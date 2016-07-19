<?php

namespace EmberDb\Client\LineReader;

/**
 * The class LineReader is responsible for reading input lines
 * using the readline command.
 */
class LineReader implements LineReaderInterface
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