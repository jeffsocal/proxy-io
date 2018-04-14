<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
function print_message($variable, $value = null, $sep = ".", $len = 75, $echo = true)
{
    $out = str_pad("$variable ", $len, $sep) . " $value\n";
    
    if ($echo == true)
        echo $out;
    
    return $out;
}

function print_var($variable, $web = true)
{
    if (is_true($web))
        echo "<br><pre>";
    
    if (is_array($variable)) {
        print_r($variable);
    } else {
        echo $variable . PHP_EOL;
    }
    
    if (is_true($web))
        echo "</pre>";
}

function print_setting($variable = null, $value = null, $sep = " ", $len = 30, $echo = true)
{
    $out = str_pad("$variable :", $len, $sep, STR_PAD_LEFT) . " $value\n";
    
    if ($echo == true)
        echo $out;
    
    return $out;
}
?>