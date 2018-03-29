<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
namespace ProxyIO\File;

class Write
{

    protected $classErrorMessage;

    protected $fileLocationName;

    protected $fileContents;

    protected $writeCommand;

    protected $suppressMessage;

    protected $suppressFail;

    protected $strMessage;

    //
    public function __construct()
    {
        $this->writeCommand = 'a';
        $this->classErrorMessage = "CLASS - fileIO (system.class.php)\n";
        $this->suppressFail = FALSE;
        $this->suppressMessage = FALSE;
    }

    //
    protected function setFileLocationName($string)
    {
        $this->fileLocationName = $string;
    }

    //
    protected function setFileContents($string)
    {
        $this->fileContents = $string;
    }

    //
    protected function setWriteCommand($string)
    {
        $this->writeCommand = $string;
    }

    //
    function deleteFile($file_name)
    {
        if (file_exists($file_name)) {
            unlink($file_name);
        }
    }

    //
    function writeFile($file_name, $file_content, $set = 'w')
    {
        $this->setFileLocationName($file_name);
        $this->setFileContents($file_content);
        $this->setWriteCommand($set);
        $this->finalWriteFile();
    }

    //
    protected function finalWriteFile()
    {
        $file_name = $this->fileLocationName;
        $file_content = $this->fileContents;
        $set = $this->writeCommand;
        if (preg_match("/\//", $file_name)) {
            $dirname = preg_replace("/\/[\w+|\.|\-]+$/", "", $file_name);
            if (! file_exists($dirname)) {
                mkdir($dirname, 0777, TRUE);
            }
        }
        
        @touch($file_name);
        @chmod($file_name, 0777);
        
        if (! $handle = fopen($file_name, $set)) {
            systemError("$this->classErrorMessage ERROR: Cannot open file ($file_name)\n");
        }
        if (fwrite($handle, $file_content) === FALSE) {
            systemError("$this->classErrorMessage ERROR: Cannot write to file ($file_name)\n");
        }
        fclose($handle);
    }
}
?>