<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */

/*
 *
 */
function table_head($table_array, $n = 10)
{
    $table_array_length = table_length($table_array);
    
    if ($table_array_length <= $n) {
        return $table_array;
    }
    
    //
    $table_array_header = table_header($table_array);
    foreach ($table_array_header as $table_array_head) {
        $table_array[$table_array_head] = array_slice($table_array[$table_array_head], 0, $n);
    }
    return $table_array;
}
?>