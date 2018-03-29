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
function table_reindex($table_array)
{
    $table_array_header = table_header($table_array);
    
    foreach ($table_array_header as $header) {
        $table_array[$header] = array_values($table_array[$header]);
    }
    return $table_array;
}
?>