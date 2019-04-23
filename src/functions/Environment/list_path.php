<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
function list_directories($path, $filter_in = NULL, $full_path = FALSE)
{
    $path = preg_replace("/\\/$/", "", $path) . "/";
    
    $dirs = array_diff(scandir($path), array(
        '.',
        '..'
    ));
    
    if (! is_null($filter_in))
        $dirs = preg_grep("/" . $filter_in . "/", $dirs);
    
    foreach ($dirs as $n => $dir) {
        if (! is_dir($path . $dir)) {
            unset($dirs[$n]);
            continue;
        }
        
        if (is_true($full_path)) {
            $dirs[$n] = realpath($path . $dir);
        }
    }
    
    return array_values($dirs);
}

function list_files($path, $filter_in = NULL, $full_path = FALSE)
{
    $path = preg_replace("/\\/$/", "", $path) . "/";
    
    $files = array_diff(scandir($path), array(
        '.',
        '..'
    ));
    
    if (! is_null($filter_in))
        $files = preg_grep("/" . $filter_in . "/", $files);
    
    
    foreach ($files as $n => $file) {
        
//         $file = preg_replace("/.*\//", "", $file);
//         $files[$n] = $file;
        
        if (is_dir($path . $file)) {
            unset($files[$n]);
            continue;
        }
        
        if (is_true($full_path)) {
            $files[$n] = realpath($path . $file);
        }
    }
    
    return array_values($files);
}

?>