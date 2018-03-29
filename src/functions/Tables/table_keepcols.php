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
function table_keepcols($table_array, $cols)
{
    /*
     * quiet exit if COL is not present
     */
    $table_cols = table_header($table_array);
    
    if (! is_array($cols))
        $cols = array(
            $cols
        );
        
        foreach ($table_cols as $table_col) {
            if (is_false(array_search($table_col, $cols)))
                unset($table_array[$table_col]);
        }
        return $table_array;
}
?>