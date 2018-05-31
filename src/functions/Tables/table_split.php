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
function table_split($table_array, $split_on_column = NULL)
{
    $new_tables = array();
    
    if (is_null($split_on_column)) {
    } else {
        
        $groupby_vals = array_unique($table_array[$split_on_column]);
        sort($groupby_vals);
        
    }
    /*
     * if there is only one unique value
     */
    if (sizeof($groupby_vals) == 1) {
        $gbv = $groupby_vals[0];
        $new_tables[$gbv] = $table_array;
        return $new_tables;
    }
    
    foreach ($groupby_vals as $gbv) {
        $keys = array_keys($table_array[$split_on_column], $gbv);
        $new_tables[$gbv] = table_subset($table_array, $keys);
    }
    
    return $new_tables;
}

?>