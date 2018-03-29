<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */

/*
 * returns the table header as an array
 */
function table_header($table_array)
{
    $header_array = array();
    foreach ($table_array as $i => $v) {
        $header_array[] = $i;
    }
    
    return $header_array;
}
?>