<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */

/*
 * add a unique identifier for each row
 */
function table_addUID($table_array, $col)
{
    $table_l = table_length($table_array);
    $table_array[$col] = array_fill(0, $table_l, uniqueAlphaNumId(8));
    
    $n_pad = ceil(log10($table_l));
    
    for ($n = 0; $n < $table_l; $n ++) {
        $table_array[$col][$n] = $table_array[$col][$n] . str_pad($n, $n_pad, 0, STR_PAD_LEFT);
    }
    return $table_array;
}
?>