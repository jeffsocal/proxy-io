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
function table_sort($table_array, $column, $order = 'ascn', $type = 'string')
{
    
    /*
     * exit if sort COL is not present
     */
    if (! key_exists($column, $table_array)) {
        systemError("table_sort cound not find [$column] in the dataSet size=" . sizeof($table_array));
    }
    
    $arr = $table_array[$column];
    
    /*
     * set the type of ordering
     */
    if ($type == 'string') {} elseif ($type == 'number') {} else {
        systemError("sort type [$type] not recognized");
    }
    
    /*
     * set the direction of ordering
     */
    if ($order == 'ascn') {
        if ($type == 'number')
            asort($arr, SORT_NUMERIC);
        else
            asort($arr);
    } elseif ($order == 'desc') {
        if ($type == 'number')
            arsort($arr, SORT_NUMERIC);
        else
            arsort($arr);
    } else {
        systemError("sort order [$order] not recognized");
    }
    
    foreach ($table_array as $col => $vals) {
        
        // print_r($arr);
        // print_r($vals);
        // exit;
        
        $new_table_array[$col] = array_values(array_replace($arr, $vals));
    }
    
    return $new_table_array;
}
?>