<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
namespace ProxyIO\File;

class Log extends Write
{

    //
    private $currentLogDump;

    private $logFileDirectory;

    private $verbose;

    private $pad;

    private $pid;

    private $ipa;

    //
    public function __construct($dir)
    {
        parent::__construct();
        $this->setLogFileDirectory($dir);
        $this->pad = 60;
        $this->pid = $_ENV['PID'];
        $this->ipa = 'cli.local';
        if (key_exists('REMOTE_ADDR', $_SERVER))
            $this->ipa = $_SERVER['REMOTE_ADDR'];
    }

    //
    protected function setLogFileDirectory($dir)
    {
        $this->logFileDirectory = '../log/' . $dir;
    }

    //
    public function setVerbose($boolean = true)
    {
        $this->verbose = $boolean;
    }

    //
    protected function getStrTimeStamp()
    {
        $dt = date("Y.m.d H:i:s");
        $mt = str_pad(preg_replace("/.+\./", "", microtime(true)), 4, 0, STR_PAD_LEFT);
        return $dt . $mt;
    }

    //
    protected function getFileTimeStamp()
    {
        return date("YmdH");
    }

    //
    protected function getFileTimeStampExtended()
    {
        return date("YmdHis");
    }

    //
    public function dumpStrToLog($logMessage)
    {
        // $file_name = $this->logFileDirectory . "/logfile." . $this->getFileTimeStamp() . ".txt";
        $file_name = $this->logFileDirectory . "/logfile.txt";
        
        /*
         * timestamp and archive the logfile
         * this will allow for a tail -f logfile.txt to
         * continuously to monitor this file
         */
        
        if (file_exists($file_name) and filesize($file_name) > 1048576) {
            rename($file_name, preg_replace("/\.txt$/", $this->getFileTimeStamp() . ".txt", $file_name));
        }
        
        $this->writeFile($file_name, $logMessage, 'a');
        return $file_name;
    }

    //
    public function addToLog($primary, $secondary = false)
    {
        
        //
        $logTimeDate = $this->getStrTimeStamp();
        $logFileDate = $this->getFileTimeStamp();
        $logMessage = '';
        
        //
        $info = @pathinfo($_SERVER['PATH_TRANSLATED']);
        if ($info['filename'] == '')
            $info = @pathinfo($_SERVER['PHP_SELF']);
        
        //
        $primary = preg_replace("/\s+/", " ", $primary);
        $secondary = preg_replace("/\s+/", " ", $secondary);
        
        $message = preg_replace("/[\t\n]+/", " ", str_replace("..", "", $primary . ' ' . $secondary));
        
        $this->currentLogDump .= $message . PHP_EOL;
        
        $logMessage .= $logTimeDate;
        $logMessage .= '|' . str_pad($this->pid, 8, " ", STR_PAD_LEFT);
        
        if (key_exists('REMOTE_ADDR', $_SERVER))
            $logMessage .= '|' . str_pad($_SERVER['REMOTE_ADDR'], 16, " ", STR_PAD_LEFT);
        
        $logMessage .= '| ' . $message;
        $logMessage .= PHP_EOL;
        
        // $message = wordwrap ( $message, 140, "\n", true );
        // $messages = explode ( "\n", trim ( $message ) );
        // foreach ( $messages as $i => $message ) {
        // if (! is_false ( $secondary ) and $i > 0) {
        // $message = str_pad ( $this->pid, $this->pad, " ", STR_PAD_RIGHT ) . " " . $message;
        // }
        // }
        
        if ($this->verbose == true)
            echo $logMessage;
        
        $this->dumpStrToLog($logMessage);
        
        /*
         * if you see an error stop all processes
         */
        if (strstr($primary, "SYS.ERROR")) {
            systemError($this->getCurrentlogDump());
        }
    }

    //
    public function getUserIPAddress()
    {
        return $this->ipa;
    }

    //
    public function getCurrentlogDump()
    {
        return $this->currentLogDump;
    }

    //
    public function clearCurrentlogDump()
    {
        $this->currentLogDump = "";
    }
}
?>