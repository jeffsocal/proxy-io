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

function print_var($variable)
{
    if (! is_cli())
        echo "<br><pre>";
    
    if (is_array($variable)) {
        print_r($variable);
    } elseif (is_true($variable)) {
        echo '[' . $variable . '] => TRUE' . PHP_EOL;
    } elseif (is_false($variable)) {
        echo '[' . $variable . '] => FALSE' . PHP_EOL;
    } else {
        echo $variable . PHP_EOL;
    }
    
    if (! is_cli())
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