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
function table_droprows($table_array, $rows)
{
    /*
     * quiet exit if ROW is not present
     */
    if(is_null($rows))
        return $table_array;
    
    if (! is_array($rows))
        $rows = array(
            $rows
        );
    $rows = array_flip($rows);
    
    $table_header = table_header($table_array);
    
    foreach ($table_header as $table_header_name) {
        $table_array[$table_header_name] = array_diff_key($table_array[$table_header_name], $rows);
    }
    $table_array = table_reindex($table_array);
    return $table_array;
}
?>