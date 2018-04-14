<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
function truncate($value, $n_decimals)
{
    $f = pow(10, $n_decimals);
    return floor($value * $f) / $f;
}

?>
