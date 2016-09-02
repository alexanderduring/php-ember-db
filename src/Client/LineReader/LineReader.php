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