<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
namespace ProxyIO;

use ProxyIO\File\Log;
use ProxyTime\Timer;

class Exec extends Log
{

    //
    private $exit_on_fail;

    private $str_argument;

    private $str_echo;

    //
    function __construct()
    {
        parent::__construct('cmd');
        $this->setEchoOnExec(true);
        $this->str_argument = NULL;
        $this->addToLog("Exec:working_directory", getcwd());
    }

    //
    function setEchoOnExec($boolean)
    {
        $this->str_echo = is_true($boolean);
    }

    //
    function setExitOnFail($boolean)
    {
        $this->exit_on_fail = is_true($boolean);
    }

    //
    private function setStrCommand($str_command)
    {
        $this->addToLog(__METHOD__, $str_command);
        $this->str_argument = $str_command;
    }

    private function getStrCommand()
    {
        if (is_null($this->str_argument)) {
            $this->addToLog(__METHOD__, "ERROR => trying to access a command argument that is not set");
        }
        return $this->str_argument;
    }

    //
    function run($command)
    {
        $this->setStrCommand($command);
        
        $tmr = new Timer();
        
        $str_out = '';
        if (is_true($this->str_echo)) {
            $this->echoOnExec();
        } else {
            $str_out = $this->stdoutPost();
        }
        
        $this->addToLog(__METHOD__, "TIMER => " . $tmr->timeinstr());
        return $str_out;
    }

    //
    function getStdout()
    {
        return $this->getCurrentlogDump();
    }

    //
    private function echoOnExec()
    {
        $cmd = $this->getStrCommand();
        
        passthru($cmd . ' 2>&1', $str_exitcode);
        
        if ($str_exitcode != 0) {
            $this->addToLog(__METHOD__, "ERROR [$str_exitcode]");
            if (is_true($this->exit_on_fail)) {
                exit();
            }
        } else {
            $this->addToLog(__METHOD__, "SUCCESS [$str_exitcode]");
        }
    }

    //
    private function stdoutPost()
    {
        $cmd = $this->getStrCommand();
        
        exec($cmd . ' 2>&1', $array_out, $str_exitcode);
        $str_out = '';
        foreach ($array_out as $arrExecutionLine) {
            $str_out .= $arrExecutionLine . "\n";
        }
        
        if ($str_exitcode != 0) {
            $this->addToLog(__METHOD__, "ERROR [$str_exitcode] $str_out");
            if (is_true($this->exit_on_fail)) {
                exit();
            }
        } else {
            $this->addToLog(__METHOD__, "SUCCESS [$str_exitcode]");
        }
        
        return $str_out;
    }
}
?>