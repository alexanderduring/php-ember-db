<?php
/**
 * Ember Db - An embeddable document database for php.
 * Copyright (C) 2016 Alexander During
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @link      http://github.com/alexanderduring/php-ember-db
 * @copyright Copyright (C) 2016 Alexander During
 * @license   http://www.gnu.org/licenses GNU General Public License v3.0
 */

namespace EmberDb\Client;

use EmberDb\DocumentManager;

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

        // Inject this service locator
        $client->injectServiceLocator($this);

        // Inject options
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
