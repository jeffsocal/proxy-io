<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
namespace ProxyIO;

class Directory
{

    protected $str_path;

    protected $arr_contents;

    public function __construct($file_path)
    {
        $this->setPath($file_path);
        $this->listFiles();
    }

    protected function setPath($string)
    {
        $this->str_path = $string;
    }

    protected function setContents($array)
    {
        foreach ($array as $n => $v) {
            if (preg_match("/^\.+$/", $v))
                unset($array[$n]);
        }
        rsort($array);
        $this->arr_contents = $array;
    }

    public function getContents($limit = 100)
    {
        return (array_splice($this->arr_contents, 0, $limit));
    }

    protected function listFiles()
    {
        if (! file_exists($this->str_path)) {
            systemError("File not found for $this->str_path");
        }
        
        $list_contents = scandir($this->str_path, 1);
        
        $this->setContents($list_contents);
    }
}

?>