<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
function alphaToNumber($string)
{
    $string = str_split($string, 1);
    $alpha = range('A', 'Z');
    $value = array_search($string[0], $alpha);
    return ($value);
}

function numberToAlpha($value)
{
    $alpha = range('A', 'Z');
    $value = max(0, preg_replace("/^0*/", "", $value)) % 26;
    return ($alpha[$value]);
}

?>
