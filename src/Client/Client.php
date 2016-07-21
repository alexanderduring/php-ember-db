<?php

namespace EmberDb\Client;

use EmberDb\Client\LineReader\InjectLineReaderTrait;
use EmberDb\Client\Parser\InjectParserTrait;

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
                $output = $this->parser->execute($inputLine);
            }

            echo $output;
        }
    }
}
