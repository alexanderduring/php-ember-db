<?php

namespace EmberDb\Client;

class Options
{
    public $workingDirectory;



    public function __construct()
    {
        // command line options
        $longopts = array(
            "directory::"
        );
        $options = getopt('', $longopts);

        // working directory
        $workingDirectory = array_key_exists('directory', $options) ? $options['directory'] : '.';
        if ($workingDirectory[0] != '/') {
            $workingDirectory = './'.$workingDirectory;
        }
        $this->workingDirectory = realpath($workingDirectory);
    }
}