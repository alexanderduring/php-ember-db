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

namespace EmberDb;

class Document
{
    private $data;



    /**
     * @param array $data
     */
    public function __construct($data = array())
    {
        $this->data = $data;
    }



    /**
     * @param string $path 'comma.separated.path.to.value'
     * @return boolean
     */
    public function has($path)
    {
        $exists = true;

        $subtree = $this->data;
        $segments = $this->getPathSegments($path);

        foreach ($segments as $key) {
            if (!array_key_exists($key, $subtree)) {
                $exists = false;
            } else {
                $subtree = $subtree[$key];
            }
        }

        return $exists;
    }



    /**
     * @param string $path 'comma.separated.path.to.value'
     * @return array|mixed
     */
    public function get($path)
    {
        $subtree = $this->data;
        $segments = $this->getPathSegments($path);

        foreach ($segments as $key) {
            $subtree = $subtree[$key];
        }

        return $subtree;
    }



    /**
     * This method allows you to set a value in the document by using this syntax:
     *
     * set('path.to.level', 'myValue')
     *
     * ... does nothing else than ...
     *
     * document[path][to][level] = 'myValue'
     *
     * Because the path is translated into an array structure in interations
     * we need to store the reference to each intermediate array field
     * for usage in the next iteration.
     *
     * @param string $path 'comma.separated.path.to.value'
     * @param mixed $value The value to store
     * @return boolean
     */
    public function set($path, $value)
    {
        $subtree = &$this->data;
        $segments = $this->getPathSegments($path);
        $lastKey = array_pop($segments);

        foreach ($segments as $key) {
            if (array_key_exists($key, $subtree)) {
                if (!is_array($subtree[$key])) {
                    return false;
                }
                $subtree = &$subtree[$key];
            } else {
                $subtree[$key] = array();
                $subtree = &$subtree[$key];
            }
        }

        $subtree[$lastKey] = $value;
    }



    public function toJson()
    {
        return json_encode($this->data);
    }



    /**
     * @param string $path
     * @return array
     */
    private function getPathSegments($path)
    {
        trim($path, '.');
        $segments = explode('.', $path);

        return $segments;
    }
}
