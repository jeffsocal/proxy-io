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
    $keys_toss = array_keys(array_lessthan($table_array[$column], $lessthan));
    
    foreach ($keys_toss as $key) {
        $table_array = table_droprow($table_array, $key);
    }
    return table_reindex($table_array);
}
?>