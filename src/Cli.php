<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
namespace ProxyIO;

class Cli extends Args
{

    function __construct()
    {
        parent::__construct();
        $_ENV['PID'] = uniqueId();
        
        $this->displayHelp();
    }

    private function displayHelp()
    {
        if (! preg_grep("/^-{1,2}h/", $_SERVER['argv']))
            return null;
        
        $incf = get_included_files();
        
        $con = file_get_contents($incf[0]);
        
        
        if (preg_match("/\sNAME[\s\*\r\n\w\-\.\>\<\'\"\:\,]+/", $con, $man) != FALSE) {
            $man[0] = preg_replace("/(?<=\n)\s+\*/", "     ", $man[0]);
            $man[0] = preg_replace("/(?<=\n)\s+(?=[A-Z]{4})/", "\n ", $man[0]);
            echo PHP_EOL . $man[0] . PHP_EOL . PHP_EOL;
        }
        
        exit();
    }
}
?>