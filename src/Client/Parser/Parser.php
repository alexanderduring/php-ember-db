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

namespace EmberDb\Client\Parser;

use EmberDb\Client\Exception;
use EmberDb\Document;
use EmberDb\DocumentManager;

/**
 * The responsibility of the class Parser is parsing the
 * input line and finding the right command and parameters.
 * Currently it also executes the command by invoking it on
 * the document manager. It also renders a help view.
 */
class Parser
{
    /** @var \EmberDb\DocumentManager */
    private $documentManager;



    /**
     * @param \EmberDb\DocumentManager $documentManager
     */
    public function injectDocumentManager(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }



    public function execute($inputLine)
    {
        $output = '';

        $tokens = explode(' ', $inputLine);
        $command = array_shift($tokens);
        $parameters = $tokens;

        switch ($command) {
            case 'insert':
                try {
                    if (count($parameters) != 2) {
                        throw new Exception('Incorrect number of parameters for command "insert".');
                    }
                    $collection = $parameters[0];
                    $documentData = json_decode($parameters[1], true);
                    if ($documentData !== null) {
                        $document = new Document($documentData);
                    } else {
                        throw new Exception('The description of the document is not a valid json.');
                    }

                    $this->documentManager->insert($collection, $document);
                    $output .= "Inserted document in the $collection collection.\n";
                }
                catch (Exception $exception) {
                    $output .= "Error: ".$exception->getMessage()."\n";
                }
                break;
            case 'find':
                $collection = $parameters[0];
                $filter = count($parameters) == 2 ? json_decode($parameters[1], true) : array();
                $documents = $this->documentManager->find($collection, $filter);
                foreach ($documents as $document) {
                    $output .= json_encode($document)."\n";
                }
                break;
            case 'pwd':
                $output .= $this->documentManager->getDatabasePath()."\n";
                break;
            case 'help':
                $output .= "Available commands:\n";
                $output .= "   insert <collection> <document>   Insert the document <document> into the collection <collection>.\n";
                $output .= "   find <collection> <filter>       Find all documents into the collection <collection> that match <filter>.\n";
                $output .= "   pwd                              Print working directory.\n";
                $output .= "   help                             Display this help.\n";
                $output .= "   exit                             Exit this client.\n";
                break;
            default:
                $output .= "Syntax error: Unknown command '".$command."'.\n";
        }
        $output .= "\n";

        return $output;
    }
}
