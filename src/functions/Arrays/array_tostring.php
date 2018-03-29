<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
function array_tostring($array, $sep = ',', $esc = '"')
{
    $array = array_values($array);
    $i = sizeof($array);
    $str_new = '';
    for ($x = 0; $x < $i; $x ++) {
        if ($x == $i - 1)
            $sep = '';
        
        $str_new .= $esc . $array[$x] . $esc . $sep;
    }
    return $str_new;
}

?>