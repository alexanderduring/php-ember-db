<?php

namespace EmberDb;

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
                $output .= "You want to insert $document in the $collection collection.\n\n";
                break;
            case 'find':
                $collection = $parameters[0];
                $filter = $parameters[1];
                $output .= "You want to find something in the $collection collection that matches $filter.\n\n";
                break;
            case 'help':
                $output .= "Available commands:\n";
                $output .= "   insert <collection> <document>   Insert the document <document> into the collection <collection>.\n";
                $output .= "   find <collection> <filter>       Find all documents into the collection <collection> that match <filter>.\n";
                $output .= "   help                             Display this help.\n";
                $output .= "   exit                             Exit this client.\n";
                $output .= "\n";
                break;
            default:
                $output .= "Syntax error: Unknown command '".$command."'.\n\n";
        }

        return $output;
    }
}
