<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
namespace ProxyIO\File;

class Read
{

    protected $str_path;

    protected $str_contents;

    protected $var_cleanfile;

    //
    public function __construct($file_path)
    {
        $this->setPath($file_path);
        $this->readFile();
        return ($this->getContents());
    }

    //
    protected function setPath($string)
    {
        $this->str_path = $string;
    }

    //
    protected function setContents($string)
    {
        $this->str_contents = $string;
    }

    //
    public function getContents()
    {
        return ($this->str_contents);
    }

    //
    protected function readFile()
    {
        if (! file_exists($this->str_path)) {
            systemError("File not found for $this->str_path");
        }
        $str_contents = file_get_contents($this->str_path, FALSE, NULL);
        $str_contents = preg_replace("/\n\r/", "", $str_contents);
        $this->setContents($str_contents);
    }
}

?>