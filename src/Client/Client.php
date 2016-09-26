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

use EmberDb\Client\LineReader\InjectLineReaderTrait;
use EmberDb\Client\Parser\InjectParserTrait;
use EmberDb\Logger;

/**
 * The main responsibility of the class Client is to continuously read
 * input lines from the user and forward them to the interpreter until
 * the exit command is given.
 * A second responsibility is to handle command line options.
 */
class Client
{
    use InjectLineReaderTrait;
    use InjectOptionsTrait;
    use InjectParserTrait;
    use InjectServiceLocatorTrait;



    public static function create()
    {
        $serviceLocator = new ServiceLocator();
        $client = $serviceLocator->getClient();

        return $client;
    }



    public function bootstrap()
    {
        $workingDirectory = $this->options->workingDirectory;
    }



    public function start()
    {
        // Echo greeting
        echo "\nEmberDb command line client.\n";
        echo "Type your command followed by <return>. Type 'help' to get a command overview or 'exit' to leave the client.\n\n";

        // Start command input loop
        $quit = false;
        while (!$quit) {
            $inputLine = $this->lineReader->readline();
            if ($inputLine == 'exit') {
                $quit = true;
                $output = "Closing EmberDb command line client.\n\n";
            } else {
                Logger::log("Starting execution of '" . $inputLine . "'.\n");
                $output = $this->parser->execute($inputLine);
                Logger::log("Execution finished.\n\n");
            }

            echo $output;
        }
    }
}
