<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */

// calculates n!
function factorial($int)
{
    if ($int < 2)
        return 1;
    for ($f = 2; $int - 1 > 1; $f *= $int --);
    return $f;
}

?>
