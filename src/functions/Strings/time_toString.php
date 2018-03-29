<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
function time_toString($seconds, $show_miliseconds = false)
{
    $array_timeChunks = array(
        31536000 => 'y',
        2592000 => 'm',
        604800 => 'w',
        86400 => 'd',
        3600 => 'h',
        60 => 'm',
        1 => 's'
    );
    
    if (! is_false($show_miliseconds)) {
        $array_timeChunks[0] = 'ms';
    }
    
    $str_time = '';
    foreach ($array_timeChunks as $str_time_value => $str_time_variable) {
        if ($seconds >= $str_time_value) {
            if ($str_time_value == 0) {
                $seconds = $seconds - floor($seconds);
                $ms_time = round($seconds * 1000);
                if ($ms_time > 0) {
                    $str_time .= str_pad($ms_time, 3, "0", STR_PAD_LEFT) . $str_time_variable;
                }
            } else {
                $str_time_base = floor($seconds / $str_time_value);
                $str_time .= $str_time_base . $str_time_variable . ":";
                $seconds = $seconds - ($str_time_base * $str_time_value);
            }
        }
    }
    if ($str_time == "")
        $str_time = "0s";
    
    return trim($str_time, ":");
}

?>
