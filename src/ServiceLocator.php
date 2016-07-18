<?php

namespace EmberDb;

use EmberDb\Client\Client;
use EmberDb\Client\Options;

class ServiceLocator
{
    private $instances = array();



    /**
     * @return \EmberDb\Client\Client
     */
    public function getClient()
    {
        $name = 'EmberDb\Client\Client';
        if (!array_key_exists($name, $this->instances)) {
            $client = $this->buildClient();
            $this->instances[$name] = $client;
        }

        return $this->instances[$name];
    }



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
     * @return \EmberDb\Client\Options
     */
    public function getOptions()
    {
        if (!array_key_exists('EmberDb\Client\Options', $this->instances)) {
            $options = new Options();
            $this->instances['EmberDb\Client\Options'] = $options;
        }

        return $this->instances['EmberDb\Client\Options'];
    }


    /**
     * @return \EmberDb\Client\Client
     */
    private function buildClient()
    {
        $client = new Client();

        $options = $this->getOptions();
        $client->injectOptions($options);

        return $client;
    }


    /**
     * @return \EmberDb\DocumentManager
     */
    private function buildDocumentManager()
    {
        $documentManager = new DocumentManager();

        return $documentManager;
    }
}
