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
function print_row_neat($array_vars, $array_spaces = null)
{
    if (is_null($array_vars))
        return false;
    
    $array_vars = array_values($array_vars);
    if (is_null($array_spaces))
        $array_spaces = array_fill(0, count($array_vars), 20);
    
    foreach ($array_vars as $n => $val) {
        echo str_pad($val, $array_spaces[$n], " ", STR_PAD_RIGHT);
    }
    echo PHP_EOL;
}
?>