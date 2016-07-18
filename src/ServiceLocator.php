<?php

namespace EmberDb;

use EmberDb\Client\Options;

class ServiceLocator
{
    private $instances = array();


    /**
     * @return \EmberDb\DocumentManager
     */
    public function getDocumentManager()
    {
        $name = 'EmberDb\DocumentManger';
        if (!array_key_exists($name, $this->instances)) {
            $documentManager = $this->buildDocumentManager();
            $this->instances[$name] = $documentManager;
        }

        return $this->instances[$name];
    }



    /**
     * @return Options
     */
    public function getOptions()
    {
        if (!array_key_exists('EmberDb\Client\Options', $this->instances)) {
            $options = new Options();
            $this->instances['EmberDb\Client\Options'] = $options;
        }

        return $this->instances['EmberDb\Client\Options'];
    }



    private function buildDocumentManager()
    {
        $documentManager = new DocumentManager();

        return $documentManager;
    }
}