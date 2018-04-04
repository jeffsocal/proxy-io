<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
function array_rowtocol($array)
{
    if (is_false($array)) {
        return false;
    }
    
    foreach ($array as $n => $row_vals) {
        foreach ($row_vals as $name_col => $value) {
            if (is_array($value)) {
                $array_new[$name_col][$n] = $value;
            } else {
                $array_new[$name_col][$n] = trim($value);
            }
        }
    }
    if (! isset($array_new)) {
        systemError("Function::array_rowtocol - Array could not be converted.");
    }
    return $array_new;
}

?>