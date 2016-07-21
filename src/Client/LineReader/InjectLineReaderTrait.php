<?php

namespace EmberDb\Client\LineReader;

trait InjectLineReaderTrait
{
    /** @var \EmberDb\Client\LineReader\LineReaderInterface */
    private $lineReader;



    /**
     * @param \EmberDb\Client\LineReader\LineReaderInterface $lineReader
     */
    public function injectLineReader(LineReaderInterface $lineReader)
    {
        $this->lineReader = $lineReader;
    }
}
