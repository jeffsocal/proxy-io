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
function table_dropcols($table_array, $cols)
{
    /*
     * quiet exit if COL is not present
     */
    if (! is_array($cols))
        $cols = array(
            $cols
        );
        
        foreach ($cols as $col) {
            if (key_exists($col, $table_array))
                unset($table_array[$col]);
        }
        return $table_array;
}
?>