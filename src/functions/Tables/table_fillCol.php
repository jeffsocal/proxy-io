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
function table_fillCol($table_array, $col, $val)
{
    $table_l = table_length($table_array);
    $table_array[$col] = array_fill(0, $table_l, $val);
    return $table_array;
}
?>