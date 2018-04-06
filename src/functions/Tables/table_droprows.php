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
    if (! is_array($rows))
        $rows = array(
            $rows
        );
    
    $table_header = table_header($table_array);
    
    foreach ($table_header as $table_header_name) {
        foreach ($rows as $row) {
            if (key_exists($row, $table_array[$table_header_name]))
                unset($table_array[$table_header_name][$row]);
        }
    }
    return $table_array;
}
?>