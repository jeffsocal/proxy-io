<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
function uniqueAlphaNumId($n = 5)
{
    $array_n[] = date('d');
    $array_n[] = date('H');
    $array_n[] = date('i');
    $array_n[] = date('s');
    $array_n[] = rand(0, 25);
    
    $str_id = "";
    for ($x = 0; $x < 5; $x ++) {
        $str_id .= numberToAlpha($array_n[$x]);
    }
    for ($x = 5; $x < $n; $x ++) {
        $coin = rand(0, 1);
        if ($coin == 1) {
            $str_id .= numberToAlpha(rand(0, 25));
        } else {
            $str_id .= rand(0, 9);
        }
    }
    
    return $str_id;
}

?>