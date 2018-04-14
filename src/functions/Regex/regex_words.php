<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
function regex_words($str)
{
    preg_match_all("/(?<=\")[^\"]*(?=\")|[^\"\s]+/", $str, $matches);
    
    if (! key_exists(0, $matches))
        return false;
    
    foreach ($matches[0] as $n => $match) {
        if (trim($match) == '')
            unset($matches[0][$n]);
    }
    
    if (count($matches[0]) == 0)
        return false;
    
    return array_values($matches[0]);
}

?>
