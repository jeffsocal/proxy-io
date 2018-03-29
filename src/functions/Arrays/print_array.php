<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */


function print_array($array, $width_max = 80, $print_cli = true)
{
    $str_new = wordwrap(preg_replace("/\"/", "", array_tostring($array)), $width_max);
    if (is_true($print_cli)) {
        echo $str_new . PHP_EOL;
    }
    return $str_new;
}
?>