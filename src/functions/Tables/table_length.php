<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */

/*
 * returns the verticel length of the table
 */
function table_length($table_array)
{
    if (is_false($table_array))
        return 0;
    
    if (count($table_array) == 0)
        return 0;
    
    $header_array = array();
    foreach ($table_array as $i => $v) {
        $header_array[] = count($v);
    }
    
    return array_max($header_array);
}
?>