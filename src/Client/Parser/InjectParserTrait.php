<?php

namespace EmberDb\Client\Parser;

trait InjectParserTrait
{
    /** @var \EmberDb\Client\Parser\Parser */
    private $parser;



    /**
     * @param \EmberDb\Client\Parser\Parser $parser
     */
    public function injectParser(Parser $parser)
    {
        $this->parser = $parser;
    }
}
