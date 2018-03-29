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
    
    $TableArrayUseFunction = "array_multisort(";
    $TableArrayUseFunction .= "\$table_array['$column'],";
    $table_array_header = table_header($table_array);
    
    // SORT_ASC, SORT_DESC, SORT_REGULAR, SORT_NUMERIC, SORT_STRING.
    if ($order == 'ascn') {
        $TableArrayUseFunction .= "SORT_ASC,";
    } elseif ($order == 'desc') {
        $TableArrayUseFunction .= "SORT_DESC,";
    } else {
        systemError("sort order [$order] not recognized");
    }
    
    if ($type == 'string') {
        $TableArrayUseFunction .= "SORT_STRING,";
    } elseif ($type == 'number') {
        $TableArrayUseFunction .= "SORT_NUMERIC,";
    } else {
        systemError("sort type [$type] not recognized");
    }
    
    $foundElement = FALSE;
    foreach ($table_array_header as $table_array_head) {
        if ($table_array_head == $column)
            continue;
        $TableArrayUseFunction .= "\$table_array['$table_array_head'],";
    }
    $TableArrayUseFunction = trim($TableArrayUseFunction, ",") . ")";
    
    /*
     * evaluate the sort method
     */
    @eval("$TableArrayUseFunction;");
    
    //
    return $table_array;
}
?>