<?php

namespace EmberDb\Client;

trait InjectOptionsTrait
{
    /** @var \EmberDb\Client\Options */
    private $options;



    /**
     * @param \EmberDb\Client\Options $options
     */
    public function injectOptions(Options $options)
    {
        $this->options = $options;
    }
}
