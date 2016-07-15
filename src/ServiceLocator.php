<?php

namespace EmberDb;

use EmberDb\Client\Options;

class ServiceLocator
{
    private $instances = array();



    public function getOptions()
    {
        if (!array_key_exists('EmberDb\Client\Options', $this->instances)) {
            $options = new Options();
            $this->instances['EmberDb\Client\Options'] = $options;
        }

        return $this->instances['EmberDb\Client\Options'];
    }
}