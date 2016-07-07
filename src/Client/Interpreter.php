<?php

namespace EmberDb\Client;

use EmberDb\DocumentManager;

class Interpreter
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
        print_r($tokens);
        switch ($command) {
            case 'insert':
                $collection = $parameters[0];
                $document = $parameters[1];
                $output .= "You want to insert $document in the $collection collection.";
                break;
            case 'find':
                $collection = $parameters[0];
                $filter = $parameters[1];
                $output .= "You want to find something in the $collection collection that matches $filter.";
                break;
            case 'pwd':
                $output .= $this->documentManager->getDatabasePath();
                break;
            case 'help':
                $output .= "Available commands:\n";
                $output .= "   insert <collection> <document>   Insert the document <document> into the collection <collection>.\n";
                $output .= "   find <collection> <filter>       Find all documents into the collection <collection> that match <filter>.\n";
                $output .= "   pwd                              Print working directory.\n";
                $output .= "   help                             Display this help.\n";
                $output .= "   exit                             Exit this client.";
                break;
            default:
                $output .= "Syntax error: Unknown command '".$command."'.";
        }

        $output .= "\n\n";
        return $output;
    }
}
