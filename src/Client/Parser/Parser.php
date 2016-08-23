<?php

namespace EmberDb\Client\Parser;

use EmberDb\Client\Exception;
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
                    if (count($parameters) != 2) throw new Exception('Incorrect number of parameters for command "insert".');
                    $collection = $parameters[0];
                    $document = json_decode($parameters[1], true);
                    if ($document === null) throw new Exception('The description of the document is not a valid json.');
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
                    $output .= $document->toJson()."\n";
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
