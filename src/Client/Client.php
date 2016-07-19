<?php

namespace EmberDb\Client;

use EmberDb\Client\LineReader\LineReaderInterface;

/**
 * The main responsibility of the class Client is to continuously read
 * input lines from the user and forward them to the interpreter until
 * the exit command is given.
 * A second responsibility is to handle command line options.
 */
class Client
{
    /** @var \EmberDb\Client\Interpreter */
    private $interpreter;

    /** @var \EmberDb\Client\LineReader\LineReaderInterface */
    private $lineReader;

    /** @var \EmberDb\Client\Options */
    private $options;



    /**
     * @param \EmberDb\Client\Options $options
     */
    public function injectOptions(Options $options)
    {
        $this->options = $options;
    }



    /**
     * @param \EmberDb\Client\Interpreter $interpreter
     */
    public function injectInterpreter(Interpreter $interpreter)
    {
        $this->interpreter = $interpreter;
    }



    /**
     * @param \EmberDb\Client\LineReader\LineReaderInterface $lineReader
     */
    public function injectLineReader(LineReaderInterface $lineReader)
    {
        $this->lineReader = $lineReader;
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
                $output = $this->interpreter->execute($inputLine);
            }

            echo $output;
        }
    }
}
