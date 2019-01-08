<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
function parse_json_file($file)
{
    if (! file_exists($file)) {
        $file = preg_replace("/.+\//", '', $file);
        systemError("JSON file not found " . $file);
    }
    
    return json_decode(file_get_contents($file), true, 10);
}

?>