<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
function array_rowtotable($array)
{
    if (is_false($array))
        return false;
    
    $header = $array[0];
    $n_header = count($header);
    unset($array[0]);
    
    if (count($array) <= 0)
        return false;
    
    foreach ($array as $row => $vals) {
        ksort($vals);
        $vals = array_values($vals);
        $n_vals = count($vals);
        if ($n_vals < $n_header) {
            $array[$row] = array_merge($vals, array_fill($n_vals, $n_header - $n_vals, ''));
        }
    }
    
    $new_table = array_rowtocol($array);
    
    if (count($new_table) != count($header)) {
        systemMessage("Function::array_rowtotable - Array could not be converted.");
        return FALSE;
    }
    
    $new_table = array_combine($header, $new_table);
    
    foreach ($new_table as $header => $array) {
        $new_table[$header] = array_values($array);
    }
    
    return $new_table;
}

?>