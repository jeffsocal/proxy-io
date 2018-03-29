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
function table_subset($table_array, $keys)
{
    $thdr = table_header($table_array);
    
    $new_table = array();
    
    foreach ($thdr as $col) {
        $new_table[$col] = array_intersect_key($table_array[$col], array_flip($keys));
    }
    
    return $new_table;
}

?>