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

    protected $path_files;

    protected $path_folders;

    public function __construct($file_path)
    {
        $this->setPath($file_path);
        $this->listObjects();
    }

    protected function setPath($string)
    {
        $this->str_path = $string;
    }

    public function getContents($limit = 100, $type = 'file')
    {
        $this_contents = [];
        
        if ($type == 'files')
            $this_contents = $this->listFiles();
        
        if ($type == 'folders')
            $this_contents = $this->listFolders();
        
        return (array_splice($this_contents, 0, $limit));
    }

    public function listFiles()
    {
        return $this->path_files;
    }

    public function listFolders()
    {
        return $this->path_folders;
    }

    protected function listObjects()
    {
        if (! file_exists($this->str_path)) {
            systemError("File not found for $this->str_path");
        }
        
        $list_contents = array_diff(scandir($this->str_path, 1), array(
            '..',
            '.'
        ));
        foreach ($list_contents as $object) {
            if (is_dir($this->str_path . $object)) {
                $this->path_folders[] = $object;
            } else {
                $this->path_files[] = $object;
            }
        }
    }
}

?>