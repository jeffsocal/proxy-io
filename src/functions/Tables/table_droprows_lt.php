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
function table_droprows_lt($table_array, $column, $lessthan)
{
    eval('$func = function ($x) { return $x < ' . $lessthan . '; };');
    
    $filtered = array_filter($table_array[$column], $func);
    $keys_toss = array_keys($filtered);
    
    $table_array = table_droprows($table_array, $keys_toss);
    
    return table_reindex($table_array);
}
?>